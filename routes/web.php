<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\SearchOption;
use App\Field;
use App\subField;
use App\api_provider;
use Illuminate\Http\Request;

Route::get('/login',function(){
    return view('login');
});

/*
 * Associo le route per i Controller (per vedere come accedere ad una determinata funzione,
 * eseguire il comando "php artisan
 */
Route::resource('providers','ApiProviderController');
/*
 * PER ORA, è possibile creare un nuovo modello "fields" accedendo alla stessa pagina
 * quale permette la creazione di un nuovo modello "option", pertanto la funzione "create"
 * del FieldController non ha senso di essere rilevata
 */
Route::resource('fields','FieldController')->except(['create','show']);
Route::resource('utente','UserController');
Route::resource('gruppo','GroupController');
Route::resource('options','SearchOptionController')->except(['show']);
Route::resource('subFields','SubFieldController');
Route::get('subFields/create/{field}','SubFieldController@create');
Route::post('subFields/{field}','SubFieldController@store');

Route::get('index', function(){
    return view('index')->with('options',SearchOption::all());
});

Route::get('search/{option}',function(SearchOption $option){
    $attributes = $option->hasMany('App\Field','id_option')->get()->toArray();
    return view('search.index',compact('search'))->with('attributes',$attributes)->with('option',$option);
});

Route::post('result/{option}',function(Request $request, SearchOption $option){
    $attributes = $option->hasMany('App\Field','id_option')->get();
    /*
     * Creazione della query per le API
     *
     * Per effettuare la ricerca tramite API (o almeno per quelli offerti da Mendeley), la richiesta deve essere
     * strutturata come:
     *
     *      attributo = valore
     *
     * quale che sia la richiesta, può essere contenuta all'interno di un array (in questo caso, "queryArrayAPI"), dove
     * "l'attributo" funge da indice dell'array, quale definisce il "valore".
     */
    $queryArrayAPI = array();
    foreach ($attributes as $attribute){
        /*
         * nella pagina di "ricerca", ogni campo sarà definito con l'id ad esso associato. Pertanto basterà
         * utilizzare l'indice per ricavare tali campi e, quindi, i valori quali sono stati inseriti dall'utente
         * (qualora ve ne siano)
         */
        if (!empty($request->get($attribute['id']))){
            /*
             * Verifica che non sia stato già definito l'indice di valore "attributo". In tal caso, provvederà
             * a crearlo. In caso contrario, provvederà a concatenare i valori già presenti con quello in analisi
             *
             * Ogni valore viene "codificato" in formato URL
             */
            if (!isset($queryArrayAPI[$attribute->attr_url]))
                $queryArrayAPI[$attribute->attr_url] = (urlencode($request->get($attribute['id'])));
            else
                $queryArrayAPI[$attribute->attr_url] .= (urlencode(' '.$request->get($attribute['id'])));
        }
    }

    /*
     * Richiesta API
     *
     * l'URL contiene l'host e il percorso associato all'opzione ricercata
     * (es. per ricercare i Profili, il percorso è /search/profiles)
     *
     */
    $url = api_provider::getHost().$option->root_path."?";
    $curl = curl_init();
    $token = api_provider::getToken();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    $headers = array();
    /*
     * Inserisco il "token" (che funge da permesso) nell'heeader
     */
    $headers[] = "Authorization: Bearer ".$token;
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    /*
     * trasformo l'array contenente i valori ricercati in un'unica "stringa", così da poterla concatenare
     * alla URL
     */
    $queryURL = http_build_query($queryArrayAPI);
    curl_setopt($curl, CURLOPT_URL, $url.$queryURL);
    /*
     * Abilito la possibilità di ricavare messaggi di errori
     */
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    if (curl_errno($curl)) {
        /*
         * quale che sia il problema generatosi, si interrompe il normale proseguimento dell'esecuzione
         * e si ritorna alla pagina di ricerca, mostrando un messaggio di errore
         */
        $error_array = array();
        $error_array[] = curl_error($curl);
        curl_close($curl);
        return back()->withErrors($error_array);
    }
    curl_close($curl);
    $result_array = array();
    $popup_array = array();
    /*
     * "decodifico" il risultato in formato JSON
     */
    $json = json_decode($result, true);
    /*
     * dal JSON, ricavo i dati presenti nei campi "interessati" ( per interessati, si intendono i campi che sono
     * stati definiti nel modello Fields)
     */
    foreach ($json as $itemJson) {
        /*
         * per ogni entità, definisco un "item_array", quali conterrà solamente i valori dei campi "interessati"
         */
        $itemTable = array();
        $itemPopup = array();
        foreach ($attributes as $attribute) {
            ($attribute->on_popup) ?  $itemArray = &$itemPopup : $itemArray = &$itemTable;
            /*
             * Controllo se, nell'item del JSON in analisi, non siano definiti altri "sotto-campi" quali lo definiscono
             * (ergo, se è un array). Solitamente questo capita per elencare i dati in merito, per esempio, agli autori
             * degli articoli, i quali possono essere più di una persona e possono essere definiti ciascuno con campi
             * tipo "first_name", "last_name", ecc...)
             *
             * Questo controllo serve perchè la pagina che provvederà a mostrare i risultati della ricerca, accetterà
             * solo dati che sono nel seguente formato:
             *
             *          "attributo" => "valore"
             *
             * (i dati saranno rappresentati in un array , ed ogni elemento dell'array sarà suddiviso in attributi)
             *
             * Nel caso ci siano dei sotto-campi (riprendendo l'esempio degli autori),
             * i dati dovrebbero essere rappresentati come :
             *
             *      "attributo" => {
             *          "sotto_campo_1" => "valore_1",
             *          "sotto_campo_2" => "valore_2",
             *          ...
             *          }
             *
             * Ma dato che la pagina non si aspetta una rappresentazione simile, si "serializzano" i sotto campi,
             * ricavando :
             *
             *      "attributo" => "valore_1 valore_2 ..."
             */
            if (isset($itemJson[$attribute->attr_json])) {
                if (is_array($itemJson[$attribute->attr_json])) {
                    /*
                     * Appurato che l'item del JSON in analisi sia a sua volta un sotto-array, ricaviamo
                     * i sotto-campi associati all'attributo e definiti dagli admin
                     *
                     * "pluck()" funge similmente da select "attributo", ritornando quindi una collezione di dati
                     * rappresentati da quel solo attributo. Serve per poter usufruire del metodo "search()"
                     * che è presente più avanti
                     */
                    $subFields = $attribute->hasMany('App\subField', 'id_super_field')->get()->pluck('sub_attr_json');
                    /*
                     * Ricavo effettivamente l'attributo rappresentato come array
                     */
                    $subArrayJson = $itemJson[$attribute->attr_json];
                    /*
                     * Inizializzo l'array che "filtrerà" i dati presenti nell'array associato all'attributo
                     * in base ai sotto-campi richiesti di essere visualizzati (ovvero, tra quelli presenti nel modell
                     * subFields)
                     */
                    $arrayItemFiltered = array();
                    /*
                     * scandisco l'array associato all'attributo, ricavando così i sotto-campi quali lo definiscono
                     */
                    foreach ($subArrayJson as $subItemJson) {
                        /*
                         * Brevemente, ad ogni elemento dell'"arrayItemSerialized" vengono riportati
                         * le coppie "sotto-campo" => "valore" interessati (ovvero cui sotto-campo è definito
                         * nel modello subFields definiti dagli admin)
                         */
                        $arrayItemFiltered[] = array_where($subItemJson, function ($value, $key) use ($subFields) {
                            $index = ($subFields->search($key));
                            /*
                             * In caso la chiave sia presente nel modello subFields, ritorna l'indice in cui
                             * è definito nel suddetto modello, altrimenti ritorna false (vedere definizione
                             * del metodo nel paragrafo "Collections" della documentazione di Laravel).
                             *
                             * il motivo per cui effettuo questo controllo è perchè, in alcuni casi, l'indice
                             * associato alla chiave ritrovata nel modello assume valore 0. Ma il problema è che
                             * il metodo "array_where" permette di definire un criterio ,tramite una funzione ad hoc,
                             * per poter filtrare i dati desiderati o no, ma per farlo tale funzione deve ritornare
                             * necessariamente un booleano. Non sarebbe un problema in sè, se non fosse per il fatto
                             * che l'indice 0 lo conta come se fosse un "false"
                             *
                             * per ovviare al problema, quindi, si controlla che il risultato della ricerca sia o meno
                             * un boolean. In caso affermativo, allora vuol dire che è un "false" e quindi non ha trovato
                             * la chiave nel modello, altrimenti vuol dire che il valore è un intero e quindi ha ritrovato
                             * la chiave
                             */
                            return gettype($index) != "boolean";
                        });
                    }
                    /*
                     * terminato l'analisi dell'array associato all'attributo, si provvede infine a serializzare
                     * l'array "filtrato", così da ottenere il formato "attribute" => "valore1 valore2 ..."
                     */
                    $itemArray[$attribute->name] = implode(", ", array_map(function ($a) {
                        return implode(" ", $a);
                    }, $arrayItemFiltered));
                } else {
                    $itemArray[$attribute->name] = $itemJson[$attribute->attr_json];
                }
            }
            else{
                $fieldsToSerialize = explode(" ", $attribute->attr_json);
                $itemArray[$attribute->name] = implode(" ", array_where($itemJson, function ($value, $key) use ($fieldsToSerialize) {
                    $index = array_search($key, $fieldsToSerialize);
                    return gettype($index) != "boolean";
                }));
            }
        }
        $result_array[] = array('table' => $itemTable, 'popup' => $itemPopup);
    }
    return back()->with('jsonAPI',$result_array);
});

Route::post('search',function(Response $response){
    return back();
});

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
