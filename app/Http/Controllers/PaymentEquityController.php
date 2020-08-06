<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Client;
use App\Property;
use App\Buy;
use App\Equity;
use App\Pin;
use App\Log;
class PaymentEquityController extends Controller
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
         $paymenttype=$request->input('paymenttype');
         $id = $request->input('miscid');

            if($paymenttype=="Bank"){
            $this->validate($request,[
            'payment'=>'required',
            'orar'=>'required',
            'bank'=>'required',
            'branch'=>'required',
            'cheque'=>'required',
            ]);
            }else{
                $this->validate($request,[
                'payment'=>'required',
                'orar'=>'required',
                ]);
            }

            date_default_timezone_set("Asia/Manila");
            $year =date('Y');
            $month=date('m');
            $day=date('d');
            $today = $year."-".$month."-".$day;

            $or = Equity::where('aror',$request->input('orar'))->get();
            if(count($or)>0){
                $miscs = Equity::all();
                $misc = Equity::find($id);
                
                $client_id = $misc->client_id;
                $property_id = $misc->property_id;
                  $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
                     $buy_id=$buy[0]->id;
                $path = "admin-equity/".$buy_id."/edit";
                return redirect($path)->with('error','OR number is already in the system.');
            }else{
                   
                    $misc = Equity::find($id);
                    
                    $client_id = $misc->client_id;
                    $property_id = $misc->property_id;
                    
                    $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
                     $buy_id=$buy[0]->id;
                    $misc_penalty = (($buy[0]->equity_penalty)/100);

                    $nummisc=Equity::where('client_id',$client_id)->where('property_id',$property_id)->orderBy('date','ASC')->get();
                    $len_misc= count($nummisc);
                    $balance = $nummisc[$len_misc-1]->balance;
                    $misc_fee = $misc->equity_fee;
                    $payment = $request->input('payment');
                    if($paymenttype=="Bank"){
                     $checks = Misc::where('checknumber',$request->input('cheque'))->get();

                            if(count($checks)>0){
                            $path = "admin-equity/".$buy_id."/edit";
                            return redirect($path)->with('error','Cheque already in used.'); 
                            }
                        }
                if($misc_fee>$payment){
                     if($len_misc<=1){
                        $bal = $misc_fee - $payment;
                        $penalty = $bal *  $misc_penalty;
                    }else{
                        
                        $oldbal = $nummisc[$len_misc-2]->penalty;

                        $oldbal = $oldbal + ($oldbal*$misc_penalty);
                        $bal = $misc_fee - $payment;
                        $bal = $bal*$misc_penalty;
                        $totalbal = $bal+$oldbal;
                        $penalty = $totalbal;
                       
                    }

                    $lastMisc = Equity::where('property_id',$property_id)->where('client_id',$client_id)->orderBy('date','DESC')->first();
                    $midMisc = Equity::where('property_id',$property_id)->where('client_id',$client_id)->orderBy('date','DESC')->get();
                    $newmidmisc = $midMisc[1]->id;
                    $newid=$lastMisc->id;
                    if($paymenttype=="Bank"){
                           $newbalance = ($balance - $payment)-$change;
                        $newmisc = new Equity;
                        $newmisc->client_id = $client_id;
                        $newmisc->property_id = $property_id;
                        $newmisc->date = $request->input('paymentduedate');
                        $newmisc->balance=$newbalance;
                        $newmisc->equity_fee=$misc_fee;
                        $newmisc->checknumber = $request->input('cheque');
                        $newmisc->bankname = $request->input('bank');
                        $newmisc->branch = $request->input('branch');
                        $newmisc->datepaid = $request->input('paymentdate');
                        $newmisc->aror =$request->input('orar');
                        $newmisc->penalty = $penalty;
                        $newmisc->payment = $payment;
                        $newmisc->payment_type = $paymenttype;
                        $newmisc->datepaid = $request->input('paymentdate');
                        $newmisc->status="PAID";
                        $newmisc->save();

                        $lastmisc = Equity::find($newid);
                        $lastmisc->balance=$newbalance;
                        $lastmisc->save();

                        $midmisc = Equity::find($newmidmisc);
                        $midmisc->balance=$newbalance;
                        $midmisc->penalty=$penalty;
                        $midmisc->save();
                    }else{
                        $newbalance = $balance - $payment;
                        $newmisc = new Equity;
                        $newmisc->client_id = $client_id;
                        $newmisc->property_id = $property_id;
                        $newmisc->date = $request->input('paymentduedate');
                        $newmisc->balance=$newbalance;
                        $newmisc->equity_fee=$misc_fee;
                        $newmisc->aror =$request->input('orar');
                        $newmisc->datepaid = $request->input('paymentdate');
                        $newmisc->penalty = $penalty;
                        $newmisc->payment = $payment;
                        $newmisc->payment_type = $paymenttype;
                        $newmisc->datepaid = $request->input('paymentdate');
                        $newmisc->aror =$request->input('orar');
                        $newmisc->status = "PAID";
                        $newmisc->save();

                        $lastmisc = Equity::find($newid);
                        $lastmisc->balance=$newbalance;
                        $lastmisc->save();

                        $midmisc = Equity::find($newmidmisc);
                        $midmisc->balance=$newbalance;
                        $midmisc->penalty=$penalty;
                        $midmisc->save();


                    }
                }else if($misc_fee==$payment){
                      $lastMisc = Equity::where('property_id',$property_id)->where('client_id',$client_id)->orderBy('date','DESC')->first();
                    $midMisc = Equity::where('property_id',$property_id)->where('client_id',$client_id)->orderBy('date','DESC')->get();
                    $newmidmisc = $midMisc[1]->id;
                    $newid=$lastMisc->id;
                      if($paymenttype=="Bank"){
                          $newbalance = ($balance - $payment)-$change;
                        $newmisc = new Equity;
                        $newmisc->client_id = $client_id;
                        $newmisc->property_id = $property_id;
                        $newmisc->date = $request->input('paymentduedate');
                        $newmisc->balance=$newbalance;
                        $newmisc->equity_fee=$misc_fee;
                        $newmisc->checknumber = $request->input('cheque');
                        $newmisc->bankname = $request->input('bank');
                        $newmisc->branch = $request->input('branch');
                        $newmisc->datepaid = $request->input('paymentdate');
                        $newmisc->aror =$request->input('orar');
                        $newmisc->penalty = 0;
                        $newmisc->payment = $payment;
                        $newmisc->payment_type = $paymenttype;
                        $newmisc->datepaid = $request->input('paymentdate');
                        $newmisc->status="PAID";
                        $newmisc->save();

                        $lastmisc = Equity::find($newid);
                        $lastmisc->balance=$newbalance;
                        $lastmisc->save();

                    
                    }else{
                        $newbalance = $balance - $payment;
                        $newmisc = new Equity;
                        $newmisc->client_id = $client_id;
                        $newmisc->property_id = $property_id;
                        $newmisc->date = $request->input('paymentduedate');
                        $newmisc->balance=$newbalance;
                        $newmisc->equity_fee=$misc_fee;
                        $newmisc->aror =$request->input('orar');
                        $newmisc->datepaid = $request->input('paymentdate');
                        $newmisc->penalty = 0;
                        $newmisc->payment = $payment;
                        $newmisc->payment_type = $paymenttype;
                        $newmisc->datepaid = $request->input('paymentdate');
                        $newmisc->aror =$request->input('orar');
                        $newmisc->status = "PAID";
                        $newmisc->save();

                        $lastmisc = Equity::find($newid);
                        $lastmisc->balance=$newbalance;
                        $lastmisc->save();

                    }
                }else{
                    $change = $payment - $misc_fee;
                    $lastMisc = Equity::where('property_id',$property_id)->where('client_id',$client_id)->orderBy('date','DESC')->first();
                    $midMisc = Equity::where('property_id',$property_id)->where('client_id',$client_id)->orderBy('date','DESC')->get();
                    $newmidmisc = $midMisc[1]->id;
                    $newid=$lastMisc->id;
                    $getpenalty = $midMisc[1]->penalty;

                    if($getpenalty==$change){
                        $penalty=0;
                        $change=0;
                    }else if($getpenalty>$change){
                        $apenalty = $getpenalty-$change;
                        $penalty = $apenalty+($apenalty*$misc_penalty);
                        $change =0;
                    }else{
                        $penalty = 0;
                        $change = $change-$getpenalty;
                    }

                        if($paymenttype=="Bank"){
                        $newbalance = ($balance - $misc_fee)-$change;
                        $newmisc = new Equity;
                        $newmisc->client_id = $client_id;
                        $newmisc->property_id = $property_id;
                        $newmisc->date = $request->input('paymentduedate');
                        $newmisc->balance=$newbalance;
                        $newmisc->equity_fee=$misc_fee;
                        $newmisc->checknumber = $request->input('cheque');
                        $newmisc->bankname = $request->input('bank');
                        $newmisc->branch = $request->input('branch');
                        $newmisc->datepaid = $request->input('paymentdate');
                        $newmisc->aror =$request->input('orar');
                        $newmisc->penalty = $penalty;
                        $newmisc->payment = $payment;
                        $newmisc->payment_type = $paymenttype;
                        $newmisc->datepaid = $request->input('paymentdate');
                        $newmisc->status="PAID";
                        $newmisc->save();

                        $lastmisc = Equity::find($newid);
                        $lastmisc->balance=$newbalance;
                        $lastmisc->save();

                        $midmisc = Equity::find($newmidmisc);
                        $midmisc->balance=$newbalance;
                        $midmisc->penalty=$penalty;
                        $midmisc->save();

                    
                    }else{
                       
                        $newbalance = ($balance - $misc_fee)-$change;
                        $newmisc = new Equity;
                        $newmisc->client_id = $client_id;
                        $newmisc->property_id = $property_id;
                        $newmisc->date = $request->input('paymentduedate');
                        $newmisc->balance=$newbalance;
                        $newmisc->equity_fee=$misc_fee;
                        $newmisc->aror =$request->input('orar');
                        $newmisc->datepaid = $request->input('paymentdate');
                        $newmisc->penalty = $penalty;
                        $newmisc->payment = $payment;
                        $newmisc->payment_type = $paymenttype;
                        $newmisc->datepaid = $request->input('paymentdate');
                        $newmisc->aror =$request->input('orar');
                        $newmisc->status = "PAID";
                        $newmisc->save();

                        $lastmisc = Equity::find($newid);
                        $lastmisc->balance=$newbalance;
                        $lastmisc->save();

                        $midmisc = Equity::find($newmidmisc);
                        $midmisc->balance=$newbalance;
                        $midmisc->penalty=$penalty;
                        $midmisc->save();

                    }
                  
                }
            }

             $admin_id=session('Data')[0]->id;

        $log = new Log;
        $log->admin_id=$admin_id;
        $log->module="Equity";
        $log->description="Set equity paid";
        $log->save();



         $path = "admin-equity/".$buy_id."/edit";
            return redirect($path)->with('success','Successfully add payment.'); 

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
