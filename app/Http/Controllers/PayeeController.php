<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Payee;
class PayeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payees = Payee::all();
        return view('admin_payee.index')->with('payees',$payees);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin_payee.create');
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
            'payeename'=>'required'

        ]);
        $newpayee = Payee::where('payee_name',$request->input('payeename'))->get();
        if(count($newpayee)>0){
          
            return redirect('/admin-payee/create')->with('error','Payee name is already in the system.');
        }
        $status="ACTIVE";
            $payee = new Payee;
            $payee->payee_name = $request->input('payeename');
            $payee->address = $request->input('address');
            $payee->contactnumber = $request->input('contactnumber');
            $payee->tin = $request->input('tin');
            $payee->remarks = $request->input('remarks');
            $payee->status = $status;
            $payee->save();
            return redirect('/admin-payee')->with('success','New payee successfully added');
      
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
        $payee = Payee::find($id);
        return view('admin_payee.edit')->with('payee',$payee);
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
         $this->validate($request,[
            'payeename'=>'required'
        ]);
        $newpayee = Payee::where('payee_name',$request->input('payeename'))->get();
        if(count($newpayee)>0){
            $newpayeeid = Payee::where('id',$id)->where('payee_name',$request->input('payeename'))->get();
            if(count($newpayeeid)>0){

            }else{
                $path="/admin-payee/".$id."/edit";
                  return redirect($path)->with('error','Payee name is already in the system.');
            }
          
        }
         $payee =Payee::find($id);
            $payee->payee_name = $request->input('payeename');
             $payee->address = $request->input('address');
            $payee->contactnumber = $request->input('contactnumber');
            $payee->tin = $request->input('tin');
            $payee->remarks = $request->input('remarks');
            $payee->save();
            return redirect('/admin-payee')->with('success','Payee information successfully updated.');
       
    }
    public function status(Request $request, $id){
        return $id;
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
