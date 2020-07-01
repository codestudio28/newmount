<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Client;
use App\Property;
use App\Buy;
use App\Misc;
use App\Pin;
class MiscController extends Controller
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $buy = Buy::find($id);
        $client_id= $buy->client_id;
        $property_id = $buy->property_id;
        $miscs = Misc::where('client_id',$client_id)->where('property_id',$property_id)->get();
        return view('collection.collect')->with('miscs',$miscs);

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
        $process = $request->input('process');
        if($process=="VOID"){
            $this->validate($request,[
            'pin'=>'required'
            ]);
            $pins = Pin::all();
            $pin_id = $pins[0]->id;
            $pin = Pin::find($pin_id);

            $pin_password = $pin->pin;
            if($pin_password==$request->input('pin')){
                  $misc = Misc::find($id);
            $miscs = Misc::all();
            $len_misc=count($miscs);
            $client_id = $misc->client_id;
            $property_id = $misc->property_id;
            $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
            $buy_id=$buy[0]->id;

            $misc_penalty = (($buy[0]->misc_penalty)/100);
            $lastpenalty =$miscs[$len_misc-2]->penalty;
           
            $last_payment = $misc->payment;
            $payment_penalty = $last_payment * $misc_penalty;
            $total_penalty = $payment_penalty +  $lastpenalty;

            $balance = $miscs[$len_misc-1]->balance;

            $newbalance = $balance+$last_payment;

            $misc_id = $miscs[$len_misc-2]->id;
            $miscpenalty = Misc::find($misc_id);
            $miscpenalty->penalty= $total_penalty;
            $miscpenalty->balance = $newbalance;
            $miscpenalty->status = "VOID";
            $miscpenalty->save();
           
            $newbal_id = $miscs[$len_misc-1]->id;
            $newbal = Misc::find($newbal_id);
            $newbal->balance = $newbalance;
            $newbal->save();
            $path = "admin-misc/".$buy_id."/edit";
            return redirect($path)->with('success','Successfully set payment to void.');
            }else{
            $misc = Misc::find($id);
            $miscs = Misc::all();
            $client_id = $misc->client_id;
            $property_id = $misc->property_id;
            $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
            $buy_id=$buy[0]->id;

                $path = "admin-misc/".$buy_id."/edit";
            return redirect($path)->with('error','Wrong pin password.');
            }

           
        }else if($process=="UNPAID"){
            $miscs = Misc::all();
            $misc = Misc::find($id);
            $client_id = $misc->client_id;
            $property_id = $misc->property_id;

            $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
            $buy_id=$buy[0]->id;
            $misc_penalty = (($buy[0]->misc_penalty)/100);
            $len_misc=count($miscs);
            $balance = $misc->balance;
            $misc_fee = $misc->misc_fee;
            $olddate = $misc->date;
            if($len_misc<=1){
                $penalty = $misc_fee*$misc_penalty;
            }else{
                $bal = $miscs[$len_misc-2]->penalty;
                $bal_penalty =$bal + ($bal*$misc_penalty);
                $m_penalty = $misc_fee*$misc_penalty;
                $penalty = $m_penalty + $bal_penalty;
            }
             date_default_timezone_set("Asia/Manila");
            $year =date('Y');
            $month=date('m');
            $day=date('d');
            $today = $year."-".$month."-".$day;
            $dt = strtotime($olddate);
                $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                $misc->balance = $balance;
                $misc->penalty = $penalty;
                $misc->payment = "0";
                $misc->datepaid = $today;
                $misc->status = "UNPAID";
                $misc->save();


                 $dt = strtotime($olddate);
            $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
            
            $newmisc = new Misc;
            $newmisc->client_id = $client_id;
            $newmisc->property_id = $property_id;
            $newmisc->date = $nextdate;
            $newmisc->balance=$balance;
            $newmisc->misc_fee=$misc_fee;
            $newmisc->status="PENDING";
            $newmisc->save();
               $path = "admin-misc/".$buy_id."/edit";
            return redirect($path)->with('success','Successfully set payment to unpaid.'); 




        }elseif($process=="PAID"){
              $paymenttype=$request->input('paymenttype');
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

        $or = Misc::where('aror',$request->input('orar'))->get();

        if(count($or)>0){
                        $path = "admin-misc/".$buy_id."/edit";
            return redirect($path)->with('error','AR/OR number is already in the system.'); 
        }else{
             if($paymenttype=="Bank"){
            $miscs = Misc::all();
            $misc = Misc::find($id);
            $client_id = $misc->client_id;
            $property_id = $misc->property_id;

            $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
            $buy_id=$buy[0]->id;
            $misc_penalty = (($buy[0]->misc_penalty)/100);
            $len_misc=count($miscs);
            $balance = $misc->balance;
            $misc_fee = $misc->misc_fee;
            $payment = $request->input('payment');
            $olddate = $misc->date;
            if($misc_fee>$payment){
                if($len_misc<=1){
                    $bal = $misc_fee - $payment;
                    $penalty = $bal *  $misc_penalty;
                }else{
                    $oldbal = $miscs[$len_misc-2]->penalty;
                    $oldbal = $oldbal + ($oldbal*$misc_penalty);
                    $bal = $misc_fee - $payment;
                    $bal = $bal*$misc_penalty;
                    $totalbal = $bal+$oldbal;
                    $penalty = $totalbal;
                }
               
            }else if($misc_fee==$payment){
                if($len_misc<=1){
                    $penalty = 0;
                }else{
                    $bal = $miscs[$len_misc-2]->penalty;
                    $penalty = $bal + ($bal  *  $misc_penalty);
                }
               
            } else if($misc_fee<$payment){
                if($len_misc<=1){
                    $penalty = 0;
                }else{
                    $balpay = $payment-$misc_fee;
                    $bal = $miscs[$len_misc-2]->penalty;
                    if($bal<=0){
                        $penalty=0;
                    }else{
                        if($balpay>$bal){
                            $penalty=0;
                        }else if($balpay<$bal){
                            $bal1 = $bal-$balpay;
                            $penalty = $bal1 +($bal1*$misc_penalty);
                        }else{
                            $penalty=0;
                        }
                    }
                }
            } 
            $newbalance = $balance - $payment;
            $misc->balance = $newbalance;
            $misc->penalty = $penalty;
            $misc->payment = $payment;
            $misc->payment_type = $paymenttype;
            $misc->aror = $request->input('orar');
            $misc->checknumber = $request->input('cheque');
            $misc->bankname = $request->input('bank');
            $misc->branch = $request->input('branch');
            $misc->datepaid = $today;
            $misc->status = "PAID";
            $misc->save();

            $dt = strtotime($olddate);
            $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
            
            $newmisc = new Misc;
            $newmisc->client_id = $client_id;
            $newmisc->property_id = $property_id;
            $newmisc->date = $nextdate;
            $newmisc->balance=$newbalance;
            $newmisc->misc_fee=$misc_fee;
            $newmisc->status="PENDING";
            $newmisc->save();

            $path = "admin-misc/".$buy_id."/edit";
            return redirect($path)->with('success','Successfully add payment.');
           
            }else{
                 $miscs = Misc::all();
            $misc = Misc::find($id);
            $client_id = $misc->client_id;
            $property_id = $misc->property_id;

            $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
            $buy_id=$buy[0]->id;
            $misc_penalty = (($buy[0]->misc_penalty)/100);
            $len_misc=count($miscs);
            $balance = $misc->balance;
            $misc_fee = $misc->misc_fee;
            $payment = $request->input('payment');
            $olddate = $misc->date;
            if($misc_fee>$payment){
                if($len_misc<=1){
                    $bal = $misc_fee - $payment;
                    $penalty = $bal *  $misc_penalty;
                }else{
                    $oldbal = $miscs[$len_misc-2]->penalty;
                    $oldbal = $oldbal + ($oldbal*$misc_penalty);
                    $bal = $misc_fee - $payment;
                    $bal = $bal*$misc_penalty;
                    $totalbal = $bal+$oldbal;
                    $penalty = $totalbal;
                }
               
            }else if($misc_fee==$payment){
                if($len_misc<=1){
                    $penalty = 0;
                }else{
                    $bal = $miscs[$len_misc-2]->penalty;
                    $penalty = $bal + ($bal  *  $misc_penalty);
                }
               
            } else if($misc_fee<$payment){
                if($len_misc<=1){
                    $penalty = 0;
                }else{
                    $balpay = $payment-$misc_fee;
                    $bal = $miscs[$len_misc-2]->penalty;
                    if($bal<=0){
                        $penalty=0;
                    }else{
                        if($balpay>$bal){
                            $penalty=0;
                        }else if($balpay<$bal){
                            $bal1 = $bal-$balpay;
                            $penalty = $bal1 +($bal1*$misc_penalty);
                        }else{
                            $penalty=0;
                        }
                    }
                    }
                }
            $newbalance = $balance - $payment;
            $misc->balance = $newbalance;
            $misc->penalty = $penalty;
            $misc->payment = $payment;
            $misc->payment_type = $paymenttype;
            $misc->datepaid = $today;
            $misc->status = "PAID";
            $misc->save();

            $dt = strtotime($olddate);
            $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
            
            $newmisc = new Misc;
            $newmisc->client_id = $client_id;
            $newmisc->property_id = $property_id;
            $newmisc->date = $nextdate;
            $newmisc->balance=$newbalance;
            $newmisc->misc_fee=$misc_fee;
            $newmisc->status="PENDING";
            $newmisc->save();

            $path = "admin-misc/".$buy_id."/edit";
            return redirect($path)->with('success','Successfully add payment.'); 
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
