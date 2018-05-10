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
use App\api_provider;
use Illuminate\Http\Request;

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
Route::resource('utente','UtenteController');
Route::resource('gruppo','GruppoController');
Route::resource('options','SearchOptionController')->except(['show']);

Route::get('home', function(){
    return view('home')->with('options',SearchOption::all());
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
    /*
     * "decodifico" il risultato in formato JSON
     */
    $json = json_decode($result, true);
    /*
     * dal JSON, ricavo i dati presenti nei campi "interessati" ( per interessati, si intendono i campi che sono
     * stati definiti nel modello Fields)
     */
    foreach ($json as $item_json) {
        /*
         * per ogni entità, definisco un "item_array", quali conterrà solamente i valori dei campi "interessati"
         */
        $item_array = array();
        /*
         * TODO: e se "attribute" sia, a sua volta, un array?
         */
        foreach ($attributes as $attribute) {
            $item_array[$attribute->name] = $item_json[$attribute->attr_json];
        }
        $result_array[] = $item_array;
    }
    return back()->with('jsonAPI',$result_array);
});

Route::post('search',function(Response $response){
    return back();
});

Route::get('testMichelangelo',function(){
    return view ('search.page');
});

Route::get('/', function () {
    return view('welcome');
});
