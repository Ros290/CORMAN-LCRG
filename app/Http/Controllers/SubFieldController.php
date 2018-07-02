<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Field;
use App\subField;

class SubFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $utente = utente::find($id);
        if(!empty($utente))
            return view('search.users_view',compact('utente'));
        else
            abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Field $field)
    {
        return view('search.manage_options.create_subfield')->with('field',$field);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Field $field)
    {
        $this->validate(request(),[
           'sub_attr_json' => 'required'
        ]);
        $subField = [
            'sub_attr_json' => $request->request->get('sub_attr_json'),
            'id_super_field' => $field->id
        ];
        subField::create($subField);
        return back()->with('success','Sub-Field '.$subField['sub_attr_json'].' has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
