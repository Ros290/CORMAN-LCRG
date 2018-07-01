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
    //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $this->validate(request(),[
            'email_admin' => 'required|email',
            'name_group' => 'required'
        ]);
         $gruppo = new Group($attributes);
         //$gruppo->email_admin = $attributes['email_admin'];
         $user_admin = User::where('email',$attributes['email_admin'])->first();
         if(is_null($user_admin))
         {
             return back()->withErrors(['email_admin' => ['Email errata!']]);
         }
         if(!Group::findGroup($attributes['name_group']))
         {
             return back()->withErrors(['name_group' => ['Nome Gruppo errato!']]);
         }
         $gruppo->name = $attributes['name_group'];
         $gruppo->id_creator = $user_admin->id;
         $gruppo->save();

        //return back()->with('success','Api Provider "'.$gruppo['name_group'].'" has been added');
        return back()->withErrors(['name_group' => ['Gruppo creato!']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $email = Group::findEmail($id);
        if(!empty($email))
            return view('accepted',compact('email'));
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('groups.edit');
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
