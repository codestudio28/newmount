<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\PaymentScheme;
class PaymentSchemeCustomController extends Controller
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
        //
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
        if($request->input('status')=="REMOVED"){
             $user = PaymentScheme::find($id);
            $user->status = $request->input('status');
            $user->save();
             return redirect('/admin-paymentscheme')->with('success','Payment scheme successfully removed from the active list ');
        }else if($request->input('status')=="ACTIVE"){
             $user = PaymentScheme::find($id);
            $user->status = $request->input('status');
            $user->save();
             return redirect('/admin-paymentscheme-removed')->with('success','Payment scheme successfully retrieved to the active list ');
        }else if($request->input('status')=="IMPORT"){
                $upload = $request->file('import_file');

                $filePath = $upload->getRealPath();
                $file = fopen($filePath,'r');
                $header = fgetcsv($file);
                $escapeHeader=[];
                foreach ($header as $key => $value) {
                    $lheader=strtolower($value);
                    $escapedItem=preg_replace('/[^a-z]/', '', $lheader);
                    // dd($escapedItem);
                    array_push($escapeHeader,$escapedItem);
                }
              
                while($columns=fgetcsv($file)){
                    if($columns[0]==""){
                        continue;
                    }

                    // foreach ($columns as $key => &$value) {
                    //     $value = preg_replace('/\D/', '', $value);
                    // }

                    $data=array_combine($escapeHeader, $columns);

                    $paymentname= $data['paymentname'];
                    $percentage= $data['percentage'];
                    $years= $data['years'];
                    $status= $data['status'];
                   

                    $newpaymentscheme=PaymentScheme::where('paymentname',$paymentname)->where('years',$years)->get();

                    if(count($newpaymentscheme)<=0){
                        $payment = new PaymentScheme;
                        $payment->paymentname =$paymentname;
                        $payment->percentage=$percentage;
                        $payment->years=$years;
                        $payment->status=$status;
                        $payment->save();

                    }
                  

                }

             return redirect('/admin-paymentscheme')->with('success','Successfully import payment scheme information to the list. ');
        }
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
