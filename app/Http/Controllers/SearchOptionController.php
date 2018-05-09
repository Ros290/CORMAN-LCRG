<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SearchOption;

class SearchOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = SearchOption::all();
        return view('search.manage_options.index', compact ('options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $options = SearchOption::all()->toArray();
        return view('search.manage_options.create', compact ('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $option = $this->validate(request(), [
            'name' => 'required',
            'root_path' => 'required'
        ]);

        SearchOption::create($option);

        return back()->with('success', 'Option "'.$option['name'].'" has been added');
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
        $option = SearchOption::find($id);
        return view ('search.manage_options.edit_option', compact('option','id'));
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
        $option = SearchOption::find($id);
        $this->validate(request(), [
            'name' => 'required',
            'root_path' => 'required'
        ]);
        $option->name = $request->get('name');
        $option->root_path = $request->get('root_path');
        $option->save();
        return redirect('options')->with('success','Option has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $option = SearchOption::find($id);
        $name = $option['name'];
        $option->delete();
        return redirect('options')->with('success','Option "'.$name. '"" has been  deleted');
    }
}
