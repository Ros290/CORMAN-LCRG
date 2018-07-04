<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\User;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users', ['users' => $users]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $this->validate(request(), [
            'email_admin' => 'required|email',
            'name_group' => 'required'
        ]);

        $gruppo = new Group($attributes);
        //$gruppo->email_admin = $attributes['email_admin'];
        $user_admin = User::where('email', $attributes['email_admin'])->first();

        $errors = array();
        if (is_null($user_admin)) {
            $errors [] = (['Email inesistente !']);
        }

        $name_group = Group::where('name', $attributes['name_group'])->first();

        if (!is_null($name_group))/*(Group::findGroup($attributes['name_group'])*/ {
            $errors [] = (['Nome Gruppo "' . $attributes['name_group'] . '" già esistente!']);
        }

        if (!empty($errors)) {
            return back()->withErrors($errors);
        }
        $gruppo->name = $attributes['name_group'];
        $gruppo->id_creator = $user_admin->id;

        if ($gruppo->save()) {
            return back()->with('success', 'Group "' . $gruppo['name'] . '" has been added!');
        }

        return back()->withErrors(['name_group' => ['Gruppo non salvato!']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        /*$email = Group::findEmail($id);
        if(!empty($email))
            return view('accepted',compact('email'));
        else
            abort(404);*/
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::find($id);
        $group = Group::findId($id);

        if(!is_null($group))
            return view('groups.edit',compact('group'));

          if (is_object($group))
            return view('groups.edit', compact('group->name'));
        else
            abort(404);
        //return view('groups.edit');
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
        $this->validate($request, Group::$rules);
        $group = Group::findOrFail($id);
        $group->update($request->all());
        return Redirect::to(route('group.index'));
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
