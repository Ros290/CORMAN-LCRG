<?php

namespace App\Http\Controllers;

use App\Field;
use App\subField;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('search.manage_options.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view ('search.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $field = $this->validate(request(), [
            'name' => 'required',
            'attr_url' => 'required',
            'attr_json' => 'required',
            'values' => 'required',
            'id_option' => 'required|numeric'
        ]);
        Field::create($field);
        return back()->with('success', 'Field "'.$field['name'].'" has been added');
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
        $field = Field::find($id);
        return view ('search.manage_options.edit_field', compact('field','id'));
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
        $field = Field::find($id);
        $this->validate(request(), [
            'name' => 'required',
            'attr_url' => 'required',
            'attr_json' => 'required',
            'values' => 'required',
            'id_option' => 'required|numeric'
        ]);
        $field->name = $request->get('name');
        $field->attr_url = $request->get('attr_url');
        $field->attr_json = $request->get('attr_json');
        $field->values = $request->get('values');
        $field->id_option = $request->get('id_option');
        $field->save();
        return redirect('options')->with('success','Field has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $field = Field::find($id);
        $name = $field['name'];
        $field->delete();
        return back()->with('success','Field "'.$name. '" has been  deleted');
    }
}
