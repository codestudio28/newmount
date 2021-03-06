<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Pin;
class VoidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pins = Pin::all();
        if(count($pins)<=0){
            $pin = new Pin;
            $pin->pin="10005";
            $pin->save();
            $pins = Pin::all();
            $pin = $pins[0];
        }else{
             $pin = $pins[0];
        }
        if(session('Data')[0]->usertype=="superadmin"){
                return view('admin_pin.index')->with('pin',$pin);
            }else{
                 return redirect('/dashboard');
        }
         
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request,[
            'pin'=>'required',
        ]);

        $penalty = Pin::all();
        if(count($penalty)<=0){
            $penalty = new Pin;
            $pin = rand(1000,10000);
            $penalty->pin=$pin;
            $penalty->save();
            return redirect('/admin-void')->with('success','Pin successfully generated and updated');
        }else{
            $penalties = Pin::all();
            $penalty_id = $penalties[0]->id;
            $penalty = Pin::find($penalty_id);
             $pin = rand(1000,10000);
            $penalty->pin=$pin;
            $penalty->save();
            return redirect('/admin-void')->with('success','Pin successfully generated and updated');
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
