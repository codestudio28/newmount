<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\PaymentScheme;
use App\Log;
class PaymentSchemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if(strlen(session('Data'))<=0){
            return redirect('/');
        }else{
            $paymentschemes = PaymentScheme::where('status','ACTIVE')->get();
         
        return view('paymentscheme.index')->with('paymentschemes',$paymentschemes);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         if(strlen(session('Data'))<=0){
            return redirect('/');
        }else{
             return view('paymentscheme.create');
        }
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
            'paymentname'=>'required',
            'percentage'=>'required',
            'years'=>'required',
        ]);

         $paymentname = PaymentScheme::where('paymentname',$request->input('paymentname'))->where('years',$request->input('years'))->get();
         if(count($paymentname)>0){
             return redirect('/admin-paymentscheme/create')->with('error','Payment name with years already taken.');
         }else{

         }

        $status="ACTIVE";
        $paymentname = new PaymentScheme;
        $paymentname->paymentname = $request->input('paymentname');
        $paymentname->percentage = $request->input('percentage');
        $paymentname->years = $request->input('years');
        $paymentname->status = $status;
        $paymentname->save();

        $admin_id=session('Data')[0]->id;

        $log = new Log;
        $log->admin_id=$admin_id;
        $log->module="Payment Scheme";
        $log->description="Add payment scheme";
        $log->save();

        return redirect('/admin-paymentscheme')->with('success','New payment scheme successfully added');
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
        if(strlen(session('Data'))<=0){
            return redirect('/');
        }else{
             $paymentscheme = PaymentScheme::find($id);
         return view('paymentscheme.edit')->with('paymentscheme',$paymentscheme);
        }
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
            'paymentname'=>'required',
            'percentage'=>'required',
            'years'=>'required',
        ]);

         $paymentname = PaymentScheme::where('paymentname',$request->input('paymentname'))->where('years',$request->input('years'))->get();
         if(count($paymentname)>0){
            $paymentnameid = PaymentScheme::where('id',$id)->where('paymentname',$request->input('paymentname'))->where('years',$request->input('years'))->get();
             if(count($paymentnameid)>0){

             }else{
                 $path = "/admin-paymentscheme/".$id."/edit";
                    return redirect($path)->with('error','Payment name with years already taken.');
             }
         
         }else{

         }

    
        $paymentname = PaymentScheme::find($id);
        $paymentname->paymentname = $request->input('paymentname');
        $paymentname->percentage = $request->input('percentage');
        $paymentname->years = $request->input('years');
        $paymentname->save();

          $admin_id=session('Data')[0]->id;

        $log = new Log;
        $log->admin_id=$admin_id;
        $log->module="Payment Scheme";
        $log->description="Update payment scheme";
        $log->save();


        return redirect('/admin-paymentscheme')->with('success','Payment scheme successfully updated');
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
