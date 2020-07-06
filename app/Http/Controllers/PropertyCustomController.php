<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Property;
use App\Buy;
use App\PaymentScheme;
use App\Inhouse;
class PropertyCustomController extends Controller
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
             $user = Property::find($id);
            $user->status = $request->input('status');
            $user->save();
             return redirect('/admin-property')->with('success','Property successfully removed from the active list ');
        }else if($request->input('status')=="ACTIVE"){
             $user = Property::find($id);
            $user->status = $request->input('status');
            $user->save();
             return redirect('/admin-proptype-removed')->with('success','Property type successfully retrieve to the active list');
        } else if($request->input('status')=="CHANGE"){
           $yesorno = $request->input('transfer');
           $pay_id = $request->input('paymentscheme');
           if($yesorno=="YES"){
                $payments = PaymentScheme::find($pay_id);
                $paymentname = strtoupper($payments->paymentname);
                if($paymentname=="PAGIBIG"){
                     $buy_id = $id;
                   $buys = Buy::find($buy_id);
                   $buys->paymentscheme_id=$pay_id;
                   $buys->status="PAID";
                   $buys->save();
                }else{
                       $buy_id = $id;
                   $buy = Buy::find($buy_id);
                   $client_id = $buy->client_id;
                   $property_id = $buy->property_id;
                   $paymentscheme_id=$pay_id;
                   $loanable = $buy->loanable;
                   $years = $buy->paymentscheme->years;
                   $factor = $buy->paymentscheme->percentage;
                   $amort = $loanable*$factor;

                    date_default_timezone_set("Asia/Manila");
                    $year =date('Y');
                    $month=date('m');
                    $day=date('d');
                    $today = $year."-".$month."-".$day;

                    $dt = strtotime($today);
                    $nextdate = date("Y-m-d", strtotime("+1 month", $dt));

                    $date_due=$nextdate;

                    $inhouse = new Inhouse;
                    $inhouse->client_id=$client_id;
                    $inhouse->property_id=$property_id;
                    $inhouse->buy_id = $buy_id;
                    $inhouse->paymentscheme_id=$paymentscheme_id;
                    $inhouse->monthly_amort=$amort;
                    $inhouse->loanable=$loanable;
                    $inhouse->date_due=$date_due;
                    $inhouse->amount_due=$amort;
                    $inhouse->unpaid_due=0;
                    $inhouse->penalty=0;
                    $inhouse->total_due=0;
                    $inhouse->payment=0;
                    $inhouse->balance=0;
                    $inhouse->status="PENDING";
                    $inhouse->save();


                   $buys = Buy::find($buy_id);
                   $buys->paymentscheme_id=$pay_id;
                   $buys->status="PAID";
                   $buys->save();
                }
               
            

                return redirect('/admin-collection')->with('success','Successfully complete payment.'); 

           }else{
                $payments = PaymentScheme::find($pay_id);
                $paymentname = strtoupper($payments->paymentname);
                if($paymentname=="PAGIBIG"){
                     $buy_id = $id;
                   $buys = Buy::find($buy_id);
                   $buys->paymentscheme_id=$pay_id;
                   $buys->status="PAID";
                   $buys->save();
                }else{
                       $buy_id = $id;
                   $buy = Buy::find($buy_id);
                   $client_id = $buy->client_id;
                   $property_id = $buy->property_id;
                   $paymentscheme_id=$pay_id;
                   $loanable = $buy->loanable;
                   $years = $buy->paymentscheme->years;
                   $factor = $buy->paymentscheme->percentage;
                   $amort = $loanable*$factor;

                    date_default_timezone_set("Asia/Manila");
                    $year =date('Y');
                    $month=date('m');
                    $day=date('d');
                    $today = $year."-".$month."-".$day;

                    $dt = strtotime($today);
                    $nextdate = date("Y-m-d", strtotime("+1 month", $dt));

                    $date_due=$nextdate;

                    $inhouse = new Inhouse;
                    $inhouse->client_id=$client_id;
                    $inhouse->property_id=$property_id;
                    $inhouse->buy_id = $buy_id;
                    $inhouse->paymentscheme_id=$paymentscheme_id;
                    $inhouse->monthly_amort=$amort;
                    $inhouse->loanable=$loanable;
                    $inhouse->date_due=$date_due;
                    $inhouse->amount_due=$amort;
                    $inhouse->unpaid_due=0;
                    $inhouse->penalty=0;
                    $inhouse->total_due=0;
                    $inhouse->payment=0;
                    $inhouse->balance=0;
                    $inhouse->status="PENDING";
                    $inhouse->save();


                   $buys = Buy::find($buy_id);
                   $buys->paymentscheme_id=$pay_id;
                   $buys->status="PAID";
                   $buys->save();
                }
               
            

                return redirect('/admin-collection')->with('success','Successfully complete payment.');
           }
          
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
