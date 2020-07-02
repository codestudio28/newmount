<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Admin;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function login(Request $request)
    {
        // dd($request->all());
        // return md5($request->input('password'));
        // $user = User::where('email',$request->email)->
         // $user = User::where('email',$request->input('email'))
         //    ->where('password',md5($request->input('password')))->get();
         //    $request->session()->put('Data',$user);
         //        return view('/dashboard');
         //    if($user[0]->usertype=="superadmin"){
         //    }else if($user[0]->usertype=="admin"){

         //    }else if($user[0]->usertype=="user"){
         //         return view('/user');
         //    }
        
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $user = Admin::where('email',$request->input('email'))
            ->where('password',md5($request->input('password')))->get();
            $request->session()->put('Data',$user);
          if(count($user)>0){

            if($user[0]->usertype=="superadmin"){
                 return redirect('dashboard');
            }else if($user[0]->usertype=="admin"){
                return redirect('dashboard');
            }else if($user[0]->usertype=="user"){
                return redirect('dashboard');
            }
          } 
            
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
