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
use Illuminate\Http\Request;

Route::resource('fields','FieldController');
Route::resource('options','SearchOptionController');

Route::get('search/{id_option}',function($id_option){
    $option = SearchOption::find($id_option);
    $attributes = $option->hasMany('App\Field','id_option')->get()->toArray();
    return view('search.index',compact('search'))->with('attributes',$attributes)->with('option',$option);
});

Route::post('result/{id_option}',function(Request $request, $id_option){
    $option = SearchOption::find($id_option);
    $attributes = $option->hasMany('App\Field','id_option')->get();
    /*
     * Creazione della query per la API
     */
    $queryArrayAPI = array();
    foreach ($attributes as $attribute){
        if (!empty($request->get($attribute['id']))){
            if (!isset($queryArrayAPI[$attribute->query_path]))
                $queryArrayAPI[$attribute->query_path] = (urlencode($request->get($attribute['id'])));
            $queryArrayAPI[$attribute->query_path] .= (urlencode(' '.$request->get($attribute['id'])));
        }
    }
    /*
     * Richiesta Token
     */
    $curl = curl_init();
    $url = 'https://api.mendeley.com/oauth/token';
    $query = array ('grant_type' => 'client_credentials', 'scope' => 'all');
    $id = "5047"; //ID dell'applicazione
    $secret = "iOU6ZIt9cvL5spaz"; //Codice segreto che viene fornito da Mendeley alla registrazione dell'applicazione
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($query));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_USERPWD, $id . ":" . $secret);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    if (curl_errno($curl)){
        $messageError = curl_error($curl);
        curl_close($curl);
        view('search.result',compact('result'))->with('error','Error:' . $messageError);
    }
    $json = json_decode($result, true);
    $token = $json['access_token'];
    /*
     * Richiesta API
     */
    $url = "https://api.mendeley.com".$option->root_path."?";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    $headers = array();
    $headers[] = "Authorization: Bearer ".$token;
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $queryURL = htmlentities(http_build_query($queryArrayAPI));
    curl_setopt($curl, CURLOPT_URL, $url.$queryURL);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    if (curl_errno($curl)) {
        $messageError = curl_error($curl);
        curl_close($curl);
        view('search.result',compact('result'))->with('error','Error:' . $messageError);
    }
    curl_close($curl);
    return back()->with('jsonAPI',$result);
});

Route::post('search',function(Response $response){
    return back();
});


Route::get('/', function () {
    return view('welcome');
});
