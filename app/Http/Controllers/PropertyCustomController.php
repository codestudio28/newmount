<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Property;
use App\Buy;
use App\PaymentScheme;
use App\Inhouse;
use App\Misc;
use App\Equity;
use App\Penalty;
use App\Log;
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

               $admin_id=session('Data')[0]->id;

        $log = new Log;
         $log->admin_id=$admin_id;
        $log->module="Property";
        $log->description="Remove property";
        $log->save();

             return redirect('/admin-property')->with('success','Property successfully removed from the active list ');
        }else if($request->input('status')=="ACTIVE"){
             $user = Property::find($id);
            $user->status = $request->input('status');
            $user->save();


               $admin_id=session('Data')[0]->id;

        $log = new Log;
         $log->admin_id=$admin_id;
        $log->module="Property";
        $log->description="Retrieve property";
        $log->save();

             return redirect('/admin-proptype-removed')->with('success','Property type successfully retrieve to the active list');
        } else if($request->input('status')=="CHANGE"){
          $pay_id = $request->input('paymentscheme');
          $payments = PaymentScheme::find($pay_id);
          $paymentname = strtoupper($payments->paymentname);
          $buy_id = $id;
          $buys = Buy::find($buy_id);
          $buys->paymentscheme_id=$pay_id;
          $buys->save();


             $admin_id=session('Data')[0]->id;

        $log = new Log;
         $log->admin_id=$admin_id;
        $log->module="Change Payment Scheme";
        $log->description="Change payment scheme of a client";
        $log->save();

          return redirect('/admin-collection')->with('success','Successfully change payment scheme.'); 
        
        } else if($request->input('status')=="COMPLETE"){
          $buy_id = $id;
          $buys = Buy::find($buy_id);
          $property_id = $buys['property_id'];
          $client_id = $buys['client_id'];
          $loanable = $buys->loanable;
          $years = $buys->paymentscheme->years;
          $factor = $buys->paymentscheme->percentage;
          $amort = $loanable*$factor;
          $cts = $buys->cts;
          $to_equity=$buys->totalequity;
          $to_misc=$buys->totalmisc;

        date_default_timezone_set("Asia/Manila");
        $year =date('Y');
        $month=date('m');
        $day=date('d');
        $today = $year."-".$month."-".$day;
        $dt = strtotime($today);
        $nextdate = date("Y-m-d", strtotime("+1 month", $dt));

        $date_due=$nextdate;

          $totalequity=0;
          $totalmisc=0;
          $equities = Equity::where('client_id',$client_id)->where('property_id',$property_id)
          ->where('status','PAID')->orderBy('id','desc')->get();
          if(count($equities)<=0){
            $totalequity =$to_equity;
          }else{
            $totalequity =$equities[0]->balance;
          }
          
          // foreach ($equities as $key => $equity) {
          //     $totalequity = $totalequity+$equity->payment;
          // }

         
          $miscs = Misc::where('client_id',$client_id)->where('property_id',$property_id)
          ->where('status','PAID')->orderBy('id','desc')->get();

          if(count($miscs)<=0){
            $totalmisc =$to_misc;
          }else{
            $totalmisc =$miscs[0]->balance;
          }
          
      

          // foreach ($miscs as $key => $misc) {
          //     $totalmisc = $totalmisc+$misc->payment;
          // }
          
          $paymentname = strtoupper($buys->paymentscheme->paymentname);
          if($paymentname=="INHOUSE"){
             if($totalmisc<=0){

               $penalties = Penalty::first();

               $penalty = $penalties->penalty;
              
                $buys = Buy::find($buy_id);
                $property_id = $buys['property_id'];
                $client_id = $buys['client_id'];
                $loanable = $buys->loanable;
                $years = $buys->paymentscheme->years;
                $newloan = $loanable + $totalequity;
                $paymentscheme_id = $buys->paymentscheme_id;
                $factor = $buys->paymentscheme->percentage;
                $amort = $newloan*$factor;
                $cts = $buys->cts;

                $inhouse = new Inhouse;
                $inhouse->client_id=$client_id;
                $inhouse->property_id=$property_id;
                $inhouse->buy_id = $buy_id;
                $inhouse->paymentscheme_id=$paymentscheme_id;
                $inhouse->monthly_amort=$amort;
                $inhouse->loanable=$newloan;
                $inhouse->date_due=$date_due;
                $inhouse->amount_due=$amort;
                $inhouse->cts=$cts;
                $inhouse->unpaid_due=0;
                $inhouse->penalty=0;
                $inhouse->total_due=$amort;
                $inhouse->payment=0;
                $inhouse->balance=$amort;
                $inhouse->percentage=$penalty;
                $inhouse->status="PENDING";
                $inhouse->save();


                $buys = Buy::find($buy_id);
                $buys->status="PAID";
                $buys->save();


                   $admin_id=session('Data')[0]->id;

        $log = new Log;
         $log->admin_id=$admin_id;
        $log->module="Client Paid";
        $log->description="Set client to complete";
        $log->save();

                  return redirect('/admin-collection')->with('success','Client transfer to In-house module.');
             }else{
                $change = $buys->totalmisc - $totalmisc;
                return redirect('/admin-collection')->with('error','The client still have Php.'.number_format($totalmisc,2). ' miscellaneous balance');
             }
          }else{
            if(($totalequity<=0)&&($totalmisc<=0)){
                  $buys = Buy::find($buy_id);
                $buys->status="PAID";
                $buys->save();


                   $admin_id=session('Data')[0]->id;

       $log = new Log;
        $log->admin_id=$admin_id;
        $log->module="Client Paid";
        $log->description="Set client paid";
        $log->save();

        return redirect('/admin-collection')->with('success','Client already paid');



            }else{
               return redirect('/admin-collection')->with('error','The client still have Php.'.number_format($totalmisc,2). ' miscellaneous balance and Php.'.number_format($totalequity,2).' equity balance');
            }
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
