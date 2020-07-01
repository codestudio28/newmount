<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Penalty;
class PenaltyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penalties = Penalty::all();
        if(count($penalties)<=0){
             $penalty = new Penalty;
            $penalty->penalty="5";
            $penalty->save();
            $penalties = Penalty::all();
            $penalty = $penalties[0];
        }else{
             $penalty = $penalties[0];
        }
         return view('admin_penalty.index')->with('penalty',$penalty);
        
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
            'penalty'=>'required',
        ]);

        $penalty = Penalty::all();
        if(count($penalty)<=0){
            $penalty = new Penalty;
            $penalty->penalty=$request->input('penalty');
            $penalty->save();
            return redirect('/admin-penalty')->with('success','Penalty successfully updated');
        }else{
            $penalties = Penalty::all();
            $penalty_id = $penalties[0]->id;
            $penalty = Penalty::find($penalty_id);
            $penalty->penalty=$request->input('penalty');
            $penalty->save();
            return redirect('/admin-penalty')->with('success','Penalty successfully updated');
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
