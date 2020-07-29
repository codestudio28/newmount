<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Client;
use App\Property;
use App\Buy;
use App\Equity;
use App\Misc;
use App\Pin;
use App\Log;
class EquityController extends Controller
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
        $miscs = Equity::where('client_id',$client_id)->where('property_id',$property_id)->get();
        return view('collection.collect_equity')->with('miscs',$miscs);

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
                $miscs = Equity::all();
                $misc = Equity::find($id);
            
                $client_id = $misc->client_id;
                $property_id = $misc->property_id;
                $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
                $buy_id=$buy[0]->id;
                 $nummisc=Equity::where('client_id',$client_id)->where('property_id',$property_id)->get();
                $len_misc= count($nummisc);

                $misc_penalty = (($buy[0]->misc_penalty)/100);
                $lastpenalty =$nummisc[$len_misc-2]->penalty;
               
                $last_payment = $misc->payment;
                $payment_penalty = $last_payment * $misc_penalty;
                $total_penalty = $payment_penalty +  $lastpenalty;

                $balance = $nummisc[$len_misc-1]->balance;

                $newbalance = $balance+$last_payment;


        
                $misc_id = $nummisc[$len_misc-2]->id;
                $miscpenalty = Equity::find($misc_id);
                $miscpenalty->penalty= $total_penalty;
                $miscpenalty->balance = $newbalance;
                $miscpenalty->save();

                $misc_void =  Equity::find($id);
                $misc_void->status="VOID";
                $misc_void->save();
                
                $newbal_id = $nummisc[$len_misc-1]->id;
                $newbal = Equity::find($newbal_id);
                $newbal->balance = $newbalance;
                $newbal->save();

   $admin_id=session('Data')[0]->id;

        $log = new Log;
        $log->admin_id=$admin_id;
        $log->module="Equity";
        $log->description="Set equity void";
        $log->save();



                $path = "admin-equity/".$buy_id."/edit";
                return redirect($path)->with('success','Successfully set payment to void.');




            }else{
            $misc = Equity::find($id);
            $miscs = Equity::all();
            $client_id = $misc->client_id;
            $property_id = $misc->property_id;
            $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
            $buy_id=$buy[0]->id;

                $path = "admin-equity/".$buy_id."/edit";
            return redirect($path)->with('error','Wrong pin password.');
            }

           
        }else if($process=="UNPAID"){
            $miscs = Equity::all();
            $misc = Equity::find($id);
                
            $client_id = $misc->client_id;
            $property_id = $misc->property_id;
                
            $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
            $buy_id=$buy[0]->id;
            $misc_penalty = (($buy[0]->misc_penalty)/100);
            $nummisc=Equity::where('client_id',$client_id)->where('property_id',$property_id)->get();
            $len_misc= count($nummisc);
            $balance = $nummisc[$len_misc-1]->balance;
            $misc_fee = $misc->equity_fee;
            $payment = $request->input('payment');

            $olddate = $misc->date;
            if($len_misc<=1){
                $penalty = $misc_fee*$misc_penalty;
            }else{
                $bal = $nummisc[$len_misc-2]->penalty;
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
            
            $newmisc = new Equity;
            $newmisc->client_id = $client_id;
            $newmisc->property_id = $property_id;
            $newmisc->date = $nextdate;
            $newmisc->balance=$balance;
            $newmisc->equity_fee=$misc_fee;
            $newmisc->status="PENDING";
            $newmisc->save();


            $admin_id=session('Data')[0]->id;

        $log = new Log;
        $log->admin_id=$admin_id;
        $log->module="Equity";
        $log->description="Set equity unpaid";
        $log->save();


               $path = "admin-equity/".$buy_id."/edit";
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

            $or = Equity::where('aror',$request->input('orar'))->get();
            if(count($or)>0){
                 $miscs = Equity::all();
                $misc = Equity::find($id);
                
                    $client_id = $misc->client_id;
                    $property_id = $misc->property_id;
                  $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
                     $buy_id=$buy[0]->id;
                $path = "admin-equity/".$buy_id."/edit";
                return redirect($path)->with('error','AR number is already in the system.'); 
            }else{
                $miscs = Equity::all();
                $misc = Equity::find($id);
                
                $client_id = $misc->client_id;
                $property_id = $misc->property_id;
                
                $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
                 $buy_id=$buy[0]->id;
                $misc_penalty = (($buy[0]->misc_penalty)/100);
                $nummisc=Equity::where('client_id',$client_id)->where('property_id',$property_id)->get();
                $len_misc= count($nummisc);
                $balance = $nummisc[$len_misc-1]->balance;
                $misc_fee = $misc->equity_fee;
                $payment = $request->input('payment');

                if($paymenttype=="Bank"){
                     $checks = Equity::where('checknumber',$request->input('cheque'))->get();

                    if(count($checks)>0){
                    $path = "admin-equity/".$buy_id."/edit";
                    return redirect($path)->with('error','Cheque already in used.'); 
                    }
                }

                $olddate = $misc->date;
                 if($payment>=$balance){
                         if($len_misc<=1){
                        $bal = $misc_fee - $payment;
                        $penalty = $bal *  $misc_penalty;
                    }else{
                        $changes =$payment-$balance;
                        if($changes<=0){
                            $penalty=0;
                        }else{
                          $oldbal= $nummisc[$len_misc-2]->penalty;
                          if($oldbal<=0){
                            $penalty=0;
                          }else{
                            $penalty = $oldbal + ($oldbal*$misc_penalty);
                          }                    
                        }
                       
                    }

                     if($paymenttype=="Bank"){
                        $newbalance = $balance - $payment;
                        $misc->balance = $newbalance;
                        $misc->penalty = $penalty;
                        $misc->payment = $payment;
                        $misc->payment_type = $paymenttype;
                        $misc->checknumber = $request->input('cheque');
                        $misc->bankname = $request->input('bank');
                        $misc->branch = $request->input('branch');
                        $misc->datepaid = $request->input('paymentdate');
                        $misc->aror =$request->input('orar');
                        $misc->status = "PAID";
                        $misc->save();
                     }else{
                        $newbalance = $balance - $payment;
                        $misc->balance = $newbalance;
                        $misc->penalty = $penalty;
                        $misc->payment = $payment;
                        $misc->payment_type = $paymenttype;
                        $misc->datepaid = $request->input('paymentdate');
                        $misc->aror =$request->input('orar');
                        $misc->status = "PAID";
                        $misc->save();
                     }
                   
                    if($newbalance<=0){
                         $path = "admin-equity/".$buy_id."/edit";
                                return redirect($path)->with('success','Payment completed.'); 
                    }else{
                        $dt = strtotime($olddate);
                        $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                        
                        $newmisc = new Equity;
                        $newmisc->client_id = $client_id;
                        $newmisc->property_id = $property_id;
                        $newmisc->date = $nextdate;
                        $newmisc->balance=$newbalance;
                        $newmisc->equity_fee=$misc_fee;
                        $newmisc->status="PENDING";
                        $newmisc->save();

                    }
                }else{
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
                         if($paymenttype=="Bank"){
                             $newbalance = $balance - $payment;
                            $misc->balance = $newbalance;
                            $misc->penalty = $penalty;
                            $misc->payment = $payment;
                            $misc->payment_type = $paymenttype;
                            $misc->checknumber = $request->input('cheque');
                            $misc->bankname = $request->input('bank');
                            $misc->branch = $request->input('branch');
                            $misc->datepaid = $request->input('paymentdate');
                            $misc->aror =$request->input('orar');
                            $misc->status = "PAID";
                            $misc->save();
                        }else{
                            $newbalance = $balance - $payment;
                            $misc->balance = $newbalance;
                            $misc->penalty = $penalty;
                            $misc->payment = $payment;
                            $misc->payment_type = $paymenttype;
                            $misc->datepaid = $request->input('paymentdate');
                            $misc->aror =$request->input('orar');
                            $misc->status = "PAID";
                            $misc->save();
                        }
                        if($newbalance<=0){
                             $path = "admin-equity/".$buy_id."/edit";
                                    return redirect($path)->with('success','Payment completed.'); 
                        }else{
                            $dt = strtotime($olddate);
                            $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                            
                            $newmisc = new Equity;
                            $newmisc->client_id = $client_id;
                            $newmisc->property_id = $property_id;
                            $newmisc->date = $nextdate;
                            $newmisc->balance=$newbalance;
                            $newmisc->equity_fee=$misc_fee;
                            $newmisc->status="PENDING";
                            $newmisc->save();

                        }
                     }else if($misc_fee==$payment){
                        if($len_misc<=1){
                            $penalty = 0;
                        }else{
                            $bal = $nummisc[$len_misc-2]->penalty;
                            $penalty = $bal + ($bal  *  $misc_penalty);
                        }

                          // Saving
                          if($paymenttype=="Bank"){
                             $newbalance = $balance - $payment;
                            $misc->balance = $newbalance;
                            $misc->penalty = $penalty;
                            $misc->payment = $payment;
                            $misc->payment_type = $paymenttype;
                            $misc->checknumber = $request->input('cheque');
                            $misc->bankname = $request->input('bank');
                            $misc->branch = $request->input('branch');
                            $misc->datepaid = $request->input('paymentdate');
                            $misc->aror =$request->input('orar');
                            $misc->status = "PAID";
                            $misc->save();
                            }else{
                                $newbalance = $balance - $payment;
                                $misc->balance = $newbalance;
                                $misc->penalty = $penalty;
                                $misc->payment = $payment;
                                $misc->payment_type = $paymenttype;
                                $misc->datepaid = $request->input('paymentdate');
                                $misc->aror =$request->input('orar');
                                $misc->status = "PAID";
                                $misc->save();
                            }

                        if($newbalance<=0){
                             $path = "admin-equity/".$buy_id."/edit";
                                    return redirect($path)->with('success','Payment completed.'); 
                        }else{
                            $dt = strtotime($olddate);
                            $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                            
                            $newmisc = new Equity;
                            $newmisc->client_id = $client_id;
                            $newmisc->property_id = $property_id;
                            $newmisc->date = $nextdate;
                            $newmisc->balance=$newbalance;
                            $newmisc->equity_fee=$misc_fee;
                            $newmisc->status="PENDING";
                            $newmisc->save();

                        }

                    }else if($misc_fee<$payment){
                         if($len_misc<=1){
                            $penalty = 0;
                              $counts=0;
                             while(true){
                                   $balpay = $payment-$misc_fee;
                                    $bal = $penalty;
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
                                    if($counts<=0){

                                         if($penalty<=0){
                                            if($balpay<$misc_fee){
                                               
                                                if($paymenttype=="Bank"){
                                                    $newbalance = $balance - $payment;
                                                    $misc->balance = $newbalance;
                                                    $misc->penalty = $penalty;
                                                    $misc->payment = $payment;
                                                    $misc->payment_type = $paymenttype;
                                                    $misc->checknumber = $request->input('cheque');
                                                    $misc->bankname = $request->input('bank');
                                                    $misc->branch = $request->input('branch');
                                                    $misc->datepaid = $request->input('paymentdate');
                                                    $misc->aror =$request->input('orar');
                                                    $misc->status = "PAID";
                                                    $misc->save();
                                                }else{
                                                     $newbalance = $balance - $payment;
                                                    $misc->balance = $newbalance;
                                                    $misc->penalty = $penalty;
                                                    $misc->payment = $payment;
                                                    $misc->payment_type = $paymenttype;
                                                    $misc->datepaid = $request->input('paymentdate');
                                                    $misc->aror =$request->input('orar');
                                                    $misc->status = "PAID";
                                                    $misc->save();
                                                }
                                                $dt = strtotime($olddate);
                                            $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                                            
                                            $newmisc = new Equity;
                                            $newmisc->client_id = $client_id;
                                            $newmisc->property_id = $property_id;
                                            $newmisc->date = $nextdate;
                                            $newmisc->balance=$newbalance;
                                            $newmisc->equity_fee=$misc_fee;
                                            $newmisc->status="PENDING";
                                            $newmisc->save();
                                            break;
                                            } 
                                        }


                                        if($paymenttype=="Bank"){
                                            $newbalance = $balance - $misc_fee;
                                            $misc->balance = $newbalance;
                                            $misc->penalty = $penalty;
                                            $misc->payment = $misc_fee+$bal;
                                            $misc->payment_type = $paymenttype;
                                            $misc->checknumber = $request->input('cheque');
                                            $misc->bankname = $request->input('bank');
                                            $misc->branch = $request->input('branch');
                                            $misc->datepaid = $request->input('paymentdate');
                                            $misc->aror =$request->input('orar');
                                            $misc->status = "PAID";
                                            $misc->save();
                                        }else{
                                             $newbalance = $balance - $misc_fee;
                                            $misc->balance = $newbalance;
                                            $misc->penalty = $penalty;
                                            $misc->payment = $misc_fee+$bal;
                                            $misc->payment_type = $paymenttype;
                                            $misc->datepaid = $request->input('paymentdate');
                                            $misc->aror =$request->input('orar');
                                            $misc->status = "PAID";
                                            $misc->save();
                                        }
                                   
                                    }else{

                                        if($penalty<=0){
                                            if($balpay<$misc_fee){
                                               
                                                if($paymenttype=="Bank"){
                                                    $newbalance = $balance - $payment;
                                                    $misc->balance = $newbalance;
                                                    $misc->penalty = $penalty;
                                                    $misc->payment = $payment;
                                                    $misc->payment_type = $paymenttype;
                                                    $misc->checknumber = $request->input('cheque');
                                                    $misc->bankname = $request->input('bank');
                                                    $misc->branch = $request->input('branch');
                                                    $misc->datepaid = $request->input('paymentdate');
                                                    $misc->aror =$request->input('orar');
                                                    $misc->status = "PAID";
                                                    $misc->save();
                                                }else{
                                                     $newbalance = $balance - $payment;
                                                    $misc->balance = $newbalance;
                                                    $misc->penalty = $penalty;
                                                    $misc->payment = $payment;
                                                    $misc->payment_type = $paymenttype;
                                                    $misc->datepaid = $request->input('paymentdate');
                                                    $misc->aror =$request->input('orar');
                                                    $misc->status = "PAID";
                                                    $misc->save();
                                                }
                                                $dt = strtotime($olddate);
                                            $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                                            
                                            $newmisc = new Equity;
                                            $newmisc->client_id = $client_id;
                                            $newmisc->property_id = $property_id;
                                            $newmisc->date = $nextdate;
                                            $newmisc->balance=$newbalance;
                                            $newmisc->equity_fee=$misc_fee;
                                            $newmisc->status="PENDING";
                                            $newmisc->save();
                                            break;
                                            } 
                                        }

                                         if($paymenttype=="Bank"){
                                            $newbalance = $balance - $misc_fee;
                                            $misc->balance = $newbalance;
                                            $misc->penalty = $penalty;
                                            $misc->payment = $misc_fee;
                                            $misc->payment_type = $paymenttype;
                                            $misc->checknumber = $request->input('cheque');
                                            $misc->bankname = $request->input('bank');
                                            $misc->branch = $request->input('branch');
                                            $misc->datepaid = $request->input('paymentdate');
                                            $misc->aror =$request->input('orar');
                                            $misc->status = "PAID";
                                            $misc->save();
                                         }else{
                                            $newbalance = $balance - $misc_fee;
                                            $misc->balance = $newbalance;
                                            $misc->penalty = $penalty;
                                            $misc->payment = $misc_fee;
                                            $misc->payment_type = $paymenttype;
                                            $misc->datepaid = $request->input('paymentdate');
                                            $misc->aror =$request->input('orar');
                                            $misc->status = "PAID";
                                            $misc->save();
                                         }
                              
                                    }//next
                                      $counts++;
                                        

                                        if($newbalance<=0){
                                             $path = "admin-equity/".$buy_id."/edit";
                                            return redirect($path)->with('success','Payment completed.'); 
                                        }else{
                                            $dt = strtotime($olddate);
                                            $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                                            
                                            $newmisc = new Equity;
                                            $newmisc->client_id = $client_id;
                                            $newmisc->property_id = $property_id;
                                            $newmisc->date = $nextdate;
                                            $newmisc->balance=$newbalance;
                                            $newmisc->equity_fee=$misc_fee;
                                            $newmisc->status="PENDING";
                                            $newmisc->save();

                                        }

                                        $payment=$balpay;
                                        if($payment<$misc_fee){
                                            break;
                                        }else{
                                            $misc = Equity::where('client_id',$client_id)->where('property_id',$property_id)->orderBy('id', 'desc')->first();
                                             $nummisc=Equity::where('client_id',$client_id)->where('property_id',$property_id)->get();
                                            $len_misc= count($nummisc);
                                            $balance = $nummisc[$len_misc-1]->balance;
                                            $misc_fee = $misc->equity_fee;
                                             $olddate = $misc->date;

                                        }
                             }
                        }else{
                             $counts=0;
                             while(true){
                                      $balpay = $payment-$misc_fee;
                                    $bal = $nummisc[$len_misc-2]->penalty;
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
                                    if($counts<=0){
                                        if($penalty<=0){
                                            if($balpay<$misc_fee){
                                               
                                                if($paymenttype=="Bank"){
                                                    $newbalance = $balance - $payment;
                                                    $misc->balance = $newbalance;
                                                    $misc->penalty = $penalty;
                                                    $misc->payment = $payment;
                                                    $misc->payment_type = $paymenttype;
                                                    $misc->checknumber = $request->input('cheque');
                                                    $misc->bankname = $request->input('bank');
                                                    $misc->branch = $request->input('branch');
                                                    $misc->datepaid = $request->input('paymentdate');
                                                    $misc->aror =$request->input('orar');
                                                    $misc->status = "PAID";
                                                    $misc->save();
                                                }else{
                                                     $newbalance = $balance - $payment;
                                                    $misc->balance = $newbalance;
                                                    $misc->penalty = $penalty;
                                                    $misc->payment = $payment;
                                                    $misc->payment_type = $paymenttype;
                                                    $misc->datepaid = $request->input('paymentdate');
                                                    $misc->aror =$request->input('orar');
                                                    $misc->status = "PAID";
                                                    $misc->save();
                                                }
                                                $dt = strtotime($olddate);
                                            $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                                            
                                            $newmisc = new Equity;
                                            $newmisc->client_id = $client_id;
                                            $newmisc->property_id = $property_id;
                                            $newmisc->date = $nextdate;
                                            $newmisc->balance=$newbalance;
                                            $newmisc->equity_fee=$misc_fee;
                                            $newmisc->status="PENDING";
                                            $newmisc->save();
                                            break;
                                            } 
                                        }


                                        if($paymenttype=="Bank"){
                                            $newbalance = $balance - $misc_fee;
                                            $misc->balance = $newbalance;
                                            $misc->penalty = $penalty;
                                            $misc->payment = $misc_fee+$bal;
                                            $misc->payment_type = $paymenttype;
                                            $misc->checknumber = $request->input('cheque');
                                            $misc->bankname = $request->input('bank');
                                            $misc->branch = $request->input('branch');
                                            $misc->datepaid = $request->input('paymentdate');
                                            $misc->aror =$request->input('orar');
                                            $misc->status = "PAID";
                                            $misc->save();
                                        }else{
                                             $newbalance = $balance - $misc_fee;
                                            $misc->balance = $newbalance;
                                            $misc->penalty = $penalty;
                                            $misc->payment = $misc_fee+$bal;
                                            $misc->payment_type = $paymenttype;
                                            $misc->datepaid = $request->input('paymentdate');
                                            $misc->aror =$request->input('orar');
                                            $misc->status = "PAID";
                                            $misc->save();
                                        }
                                   
                                    }else{
                                         if($paymenttype=="Bank"){
                                            $newbalance = $balance - $misc_fee;
                                            $misc->balance = $newbalance;
                                            $misc->penalty = $penalty;
                                            $misc->payment = $misc_fee;
                                            $misc->payment_type = $paymenttype;
                                            $misc->checknumber = $request->input('cheque');
                                            $misc->bankname = $request->input('bank');
                                            $misc->branch = $request->input('branch');
                                            $misc->datepaid = $request->input('paymentdate');
                                            $misc->aror =$request->input('orar');
                                            $misc->status = "PAID";
                                            $misc->save();
                                         }else{
                                            $newbalance = $balance - $misc_fee;
                                            $misc->balance = $newbalance;
                                            $misc->penalty = $penalty;
                                            $misc->payment = $misc_fee;
                                            $misc->payment_type = $paymenttype;
                                            $misc->datepaid = $request->input('paymentdate');
                                            $misc->aror =$request->input('orar');
                                            $misc->status = "PAID";
                                            $misc->save();
                                         }
                              
                                    }
                                    $counts++;
                                        

                                        if($newbalance<=0){
                                             $path = "admin-equity/".$buy_id."/edit";
                                            return redirect($path)->with('success','Payment completed.'); 
                                        }else{
                                            $dt = strtotime($olddate);
                                            $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                                            
                                            $newmisc = new Equity;
                                            $newmisc->client_id = $client_id;
                                            $newmisc->property_id = $property_id;
                                            $newmisc->date = $nextdate;
                                            $newmisc->balance=$newbalance;
                                            $newmisc->equity_fee=$misc_fee;
                                            $newmisc->status="PENDING";
                                            $newmisc->save();

                                        }

                                        $payment=$balpay;
                                        if($payment<$misc_fee){
                                            break;
                                        }else{
                                            $misc = Equity::where('client_id',$client_id)->where('property_id',$property_id)->orderBy('id', 'desc')->first();
                                             $nummisc=Equity::where('client_id',$client_id)->where('property_id',$property_id)->get();
                                            $len_misc= count($nummisc);
                                            $balance = $nummisc[$len_misc-1]->balance;
                                            $misc_fee = $misc->equity_fee;
                                             $olddate = $misc->date;

                                        }

                                    }
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
