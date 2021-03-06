<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\api_provider;
use Illuminate\Support\Facades\Crypt;


class ApiProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = api_provider::all();
        return view ('API Provider.index',compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('API Provider.create', compact ('providers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required',
            'host' => 'required|url',
            'id_app' => 'required|integer',
            'secret_app' => 'required'
        ]);
        $provider = new api_provider($attributes);
        $provider->host = $attributes['host'];
        $provider->id_app = $attributes['id_app'];
        /*
         * il codice segreto viene immediatamente "codificato". Questo perchè è solo tramite
         * questo valore che si ha modo di ricavare i token e tutti i permessi necessari per pote
         * svolgere tutte le funzionalità del progetto. Sopratutto non appena si dovrà avere
         * a che fare con i Dataset.
         */
        $provider->secret_app = Crypt::encryptString($attributes['secret_app']);
        $provider->save();
        return redirect('providers')->with('success','Api Provider "'.$provider['name'].'" has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $provider = SearchOption::find($id);
        return view ('API Provider.show', compact('provider','id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $provider = api_provider::find($id);
        return view ('API Provider.edit', compact('provider', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $provider = api_provider::find($id);
        $attributes = $request->validate([
            'name' => 'required',
            'host' => 'required|url',
            'id_app' => 'required|integer',
            'secret_app' => 'nullable',
            'isOn' => 'required'
        ]);
        $provider->name = $attributes['name'];
        $provider->host = $attributes['host'];
        $provider->id_app = $attributes['id_app'];
        /*
         * Per far sì di passare "l'incarico" da un provider ad un altro attualmente in funzione (qualora si voglia
         * utilizzare un altro provider)
         */
        if (($attributes['isOn']!=$provider->isOn)&&($attributes['isOn']=='1')){
            $provider_online = api_provider::where('isOn','1')->first();
            if ($provider_online){
                /*
                 * ricavo il provider in uso (provider_online) , e lo si "spegne", in modo tale da poter affidare l'incarico al provider
                 * desiderato
                 */
                $provider_online->isOn = '0';
                $provider_online->save();
            }

        }
        $provider->isOn = $attributes['isOn'];
        if (!empty($attributes['secret_app']))
            $provider->secret_app = Crypt::encryptString($attributes['secret_app']);
        $provider->save();
        return redirect('providers')->with('success','Provider has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
