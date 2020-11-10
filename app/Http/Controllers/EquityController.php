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
        if($process=="PAID"){
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
                    return redirect($path)->with('error','OR number is already in the system.'); 
                }else{
                     if($paymenttype=="Bank"){
                        $checks = Equity::where('checknumber',$request->input('cheque'))->get();

                        if(count($checks)>0){
                            $path = "admin-equity/".$buy_id."/edit";
                        return redirect($path)->with('error','Cheque already in used.'); 
                        }
                    }

                    $misc = Equity::find($id);
                    $client_id = $misc->client_id;
                    $property_id = $misc->property_id;

                     $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
                    $buy_id=$buy[0]->id;
                    $misc_penalty = (($buy[0]->equity_penalty)/100);
                    $balance = $misc->balance;
                    $amountdue = $misc->amountdue;
                    $oldpenalty = $misc->penalty;
                      if(strlen($oldpenalty)<=0){
                        $oldpenalty="0";
                    }
                    $totaldues = $misc->totaldues;
                    $payment = $request->input('payment');
                    $olddate =$misc->date;
                    if($payment<$balance){
                        if($payment==round($totaldues,2)){
                            $penalty="0";
                            $unpaiddues="0";
                             if($paymenttype=="Bank"){
                                $pays=$payment-$oldpenalty;
                                $newbalance = $balance - $pays;
                                $misc->balance = $newbalance;
                               
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
                                $pays=$payment-$oldpenalty;
                                $newbalance = $balance - $pays;
                                $misc->balance = $newbalance;
                               
                                $misc->payment = $payment;

                                $misc->payment_type = $paymenttype;
                                $misc->datepaid = $request->input('paymentdate');
                                $misc->aror =$request->input('orar');
                                $misc->status = "PAID";
                                $misc->save();
                             }
                                $dt = strtotime($olddate);
                                $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                                $misc = new Equity;
                                $misc->client_id = $client_id;
                                $misc->property_id = $property_id;
                                $misc->date =$nextdate;
                                $misc->balance =  $newbalance;
                                $misc->equity_fee = $amountdue;
                                $misc->amountdue = $amountdue;
                                $misc->unpaiddues = "0";
                                $misc->totaldues =  $amountdue;
                                $misc->penalty = "";
                                $misc->payment = "";
                                $misc->payment_type = "";
                                $misc->aror = "";
                                $misc->checknumber = "";
                                $misc->bankname = "";
                                $misc->branch = "";
                                $misc->datepaid = "";
                                $misc->status = "PENDING";
                                $misc->save();
                        }else if($payment<round($totaldues,2)){

                            if($request->input('advance')=="YES"){
                                $unpaiddues=0;
                                $penalty=0;
                                $totaldues = $amountdue-$payment;
                            }else{
                                $unpaiddues=$totaldues-$payment;
                                $penalty=$unpaiddues*$misc_penalty;
                                $totaldues = $amountdue+$penalty+$unpaiddues;     
                            }
                          
                             if($paymenttype=="Bank"){
                                $pays=$payment-$oldpenalty;
                                $newbalance = $balance - $pays;
                                $misc->balance = $newbalance;
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
                                $pays=$payment-$oldpenalty;
                                $newbalance = $balance - $pays;
                                $misc->balance = $newbalance;
                               
                                $misc->payment = $payment;

                                $misc->payment_type = $paymenttype;
                                $misc->datepaid = $request->input('paymentdate');
                                $misc->aror =$request->input('orar');
                                $misc->status = "PAID";
                                $misc->save();
                             }
                                $dt = strtotime($olddate);
                                $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                                $misc = new Equity;
                                $misc->client_id = $client_id;
                                $misc->property_id = $property_id;
                                $misc->date =$nextdate;
                                $misc->balance =  $newbalance;
                                $misc->equity_fee = $amountdue;
                                $misc->amountdue = $amountdue;
                                $misc->unpaiddues = $unpaiddues;
                                $misc->totaldues =  $totaldues;
                                $misc->penalty = $penalty;
                                $misc->payment = "";
                                $misc->payment_type = "";
                                $misc->aror = "";
                                $misc->checknumber = "";
                                $misc->bankname = "";
                                $misc->branch = "";
                                $misc->datepaid = "";
                                $misc->status = "PENDING";
                                $misc->save();
                        }else{
                                 $counter=0;
                            $newbalance=0;
                            $newpayment = 0;
                            while(true){
                                $counter++;
                             
                                if($counter<=1){
                                    $newbalance = $balance-$totaldues;
                                    // echo "COUNT: ".$counter."<br>";
                                    // echo "DATE: ".$olddate."<br>";
                                    // echo "PAYMENT: ".$totaldues."<br>";
                                    // echo "TOTAL DUES: ".$totaldues."<br>";
                                    // echo "BALANCE: ".$newbalance."<br>";
                                    // echo "STATUS: PAID<br><br>";
                                      $temppayment=round($payment,2)-round($totaldues);
                                    $temptotal =$amountdue;
                                    if($temppayment<$temptotal){
                                         if($paymenttype=="Bank"){
                                            $totals=$totaldues+$temppayment;
                                            $misc->balance = $newbalance;
                                            $misc->payment = $totals;
         
                                            $misc->payment_type = $paymenttype;
                                            $misc->checknumber = $request->input('cheque');
                                            $misc->bankname = $request->input('bank');
                                            $misc->branch = $request->input('branch');
                                            $misc->datepaid = $request->input('paymentdate');
                                            $misc->aror =$request->input('orar');
                                            $misc->status = "PAID";
                                            $misc->save();
                                         }else{
                                             $totals=$totaldues+$temppayment;
                                          
                                            $misc->balance = $newbalance;
                                            $misc->payment = $totals;

                                            $misc->payment_type = $paymenttype;
                                            $misc->datepaid = $request->input('paymentdate');
                                            $misc->aror =$request->input('orar');
                                            $misc->status = "PAID";
                                            $misc->save();
                                        }
                                    }else{
                                         if($paymenttype=="Bank"){
                                            $misc->balance = $newbalance;
                                            $misc->payment = $totaldues;
         
                                            $misc->payment_type = $paymenttype;
                                            $misc->checknumber = $request->input('cheque');
                                            $misc->bankname = $request->input('bank');
                                            $misc->branch = $request->input('branch');
                                            $misc->datepaid = $request->input('paymentdate');
                                            $misc->aror =$request->input('orar');
                                            $misc->status = "PAID";
                                            $misc->save();
                                         }else{
                                            
                                            $newbalance = $balance - $totaldues;
                                            $misc->balance = $newbalance;
                                            $misc->payment = $totaldues;

                                            $misc->payment_type = $paymenttype;
                                            $misc->datepaid = $request->input('paymentdate');
                                            $misc->aror =$request->input('orar');
                                            $misc->status = "PAID";
                                            $misc->save();
                                        }
                                    }
                                   


                                    $unpaiddues=0;
                                    $penalty=0;
                                    $newpayment = $payment-$totaldues;
                                    $totaldues=$amountdue+$unpaiddues+$penalty;
                                    
                            
                                    if($newpayment<=0){
                                       
                                        $dt = strtotime($olddate);
                                        $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                                        $olddate=$nextdate;
                                        // echo "COUNT: ".$counter."<br>";
                                        // echo "DATE: ".$olddate."<br>";
                                        // echo "TOTAL DUES: ".$amountdue."<br>";
                                        // echo "BALANCE: ".$newbalance."<br>";
                                        // echo "STATUS: PENDING<br><br>";

                                       
                                            $misc = new Equity;
                                            $misc->client_id = $client_id;
                                            $misc->property_id = $property_id;
                                            $misc->date =$nextdate;
                                            $misc->balance =  $newbalance;
                                            $misc->equity_fee = $amountdue;
                                            $misc->amountdue = $amountdue;
                                            $misc->unpaiddues = $unpaiddues;
                                            $misc->totaldues =  $totaldues;
                                            $misc->penalty = $penalty;
                                            $misc->payment = "";
                                            $misc->payment_type = "";
                                            $misc->aror = "";
                                            $misc->checknumber = "";
                                            $misc->bankname = "";
                                            $misc->branch = "";
                                            $misc->datepaid = "";
                                            $misc->status = "PENDING";
                                            $misc->save();


                                        break;
                                    }else if(round($newpayment,2)<round($totaldues,2)){
                                     
                                        $newbalance=$newbalance-$newpayment;
                                        $totaldues=round($totaldues,2)-round($newpayment,2);
                                        $dt = strtotime($olddate);
                                        $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                                        $olddate=$nextdate;
                                        // echo "COUNT: ".$counter."<br>";
                                        // echo "DATE: ".$olddate."<br>";
                                        //  echo "TOTAL DUES: ".$totaldues."<br>";
                                        // echo "PAYMENT: ".$newpayment."<br>";
                                        // echo "BALANCE: ".$newbalance."<br>";
                                        // echo "STATUS: PENDING<br><br>";


                                            $misc = new Equity;
                                            $misc->client_id = $client_id;
                                            $misc->property_id = $property_id;
                                            $misc->date =$nextdate;
                                            $misc->balance =  $newbalance;
                                            $misc->equity_fee = $amountdue;
                                            $misc->amountdue = $amountdue;
                                            $misc->unpaiddues = $unpaiddues;
                                            $misc->totaldues =  $totaldues;
                                            $misc->penalty = $penalty;
                                            $misc->payment = "";
                                            $misc->payment_type = "";
                                            $misc->aror = "";
                                            $misc->checknumber = "";
                                            $misc->bankname = "";
                                            $misc->branch = "";
                                            $misc->datepaid = "";
                                            $misc->status = "PENDING";
                                            $misc->save();
                                        break;
                                    }else{

                                        
                                    }

                                     
                                }else{
                                   

                                    if($newpayment<=0){
                                        $dt = strtotime($olddate);
                                        $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                                        $olddate=$nextdate;
                                        // echo "COUNT: ".$counter."<br>";
                                        // echo "DATE: ".$olddate."<br>";
                                        // echo "TOTAL DUES: ".$amountdue."<br>";
                                        // echo "BALANCE: ".$newbalance."<br>";
                                        // echo "STATUS: PENDING<br><br>";

                                            $misc = new Equity;
                                            $misc->client_id = $client_id;
                                            $misc->property_id = $property_id;
                                            $misc->date =$nextdate;
                                            $misc->balance =  $newbalance;
                                            $misc->equity_fee = $amountdue;
                                            $misc->amountdue = $amountdue;
                                            $misc->unpaiddues = $unpaiddues;
                                            $misc->totaldues =  $totaldues;
                                            $misc->penalty = $penalty;
                                            $misc->payment = "";
                                            $misc->payment_type = "";
                                            $misc->aror = "";
                                            $misc->checknumber = "";
                                            $misc->bankname = "";
                                            $misc->branch = "";
                                            $misc->datepaid = "";
                                            $misc->status = "PENDING";
                                            $misc->save();
                                        break;
                                    }else if(round($newpayment,2)<round($totaldues,2)){
                                        $newbalance=$newbalance-$newpayment;
                                        $totaldues=round($totaldues,2)-round($newpayment,2);
                                        $dt = strtotime($olddate);
                                        $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                                        $olddate=$nextdate;
                                        // echo "COUNT: ".$counter."<br>";
                                        // echo "DATE: ".$olddate."<br>";
                                        //  echo "TOTAL DUES: ".$totaldues."<br>";
                                        // echo "PAYMENT: ".$totaldues."<br>";
                                        // echo "BALANCE: ".$newbalance."<br>";
                                        // echo "STATUS: PENDING<br><br>";


                                            $misc = new Equity;
                                            $misc->client_id = $client_id;
                                            $misc->property_id = $property_id;
                                            $misc->date =$nextdate;
                                            $misc->balance =  $newbalance;
                                            $misc->equity_fee = $amountdue;
                                            $misc->amountdue = $amountdue;
                                            $misc->unpaiddues = $unpaiddues;
                                            $misc->totaldues =  $totaldues;
                                            $misc->penalty = $penalty;
                                            $misc->payment = "";
                                            $misc->payment_type = "";
                                            $misc->aror = "";
                                            $misc->checknumber = "";
                                            $misc->bankname = "";
                                            $misc->branch = "";
                                            $misc->datepaid = "";
                                            $misc->status = "PENDING";
                                            $misc->save();
                                        break;
                                    }else{
                                         $dt = strtotime($olddate);
                                        $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                                        $olddate=$nextdate;   

                                        $newbalance = $newbalance-$totaldues;

                                        // echo "COUNT: ".$counter."<br>";
                                        // echo "DATE: ".$olddate."<br>";
                                        // echo "PAYMENT: ".$totaldues."<br>";
                                        // echo "TOTAL DUES: ".$totaldues."<br>";
                                        // echo "BALANCE: ".$newbalance."<br>";
                                        // echo "STATUS: PAID<br><br>";
                                         $temppayment=round($newpayment,2)-round($totaldues);
                                        $temptotal =$amountdue;
                                        if(round($temppayment)<round($temptotal)){
                                            $totals=$temptotal+$temppayment;
                                             if($paymenttype=="Bank"){
                                             $misc = new Equity;
                                            $misc->client_id = $client_id;
                                            $misc->property_id = $property_id;
                                            $misc->date =$nextdate;
                                            $misc->balance =  $newbalance;
                                             $misc->equity_fee = $amountdue;
                                            $misc->amountdue = $amountdue;
                                            $misc->unpaiddues = $unpaiddues;
                                            $misc->totaldues =  $totaldues;
                                            $misc->penalty = $penalty;
                                            $misc->payment = $totals;
                                           $misc->payment_type = $paymenttype;
                                           $misc->aror =$request->input('orar');
                                            $misc->checknumber = $request->input('cheque');
                                            $misc->bankname = $request->input('bank');
                                            $misc->branch = $request->input('branch');
                                            $misc->datepaid = $request->input('paymentdate');
                                            $misc->status = "PAID";
                                            $misc->save();

                                           
                                         }else{
                                            
                                            $misc = new Equity;
                                            $misc->client_id = $client_id;
                                            $misc->property_id = $property_id;
                                            $misc->date =$nextdate;
                                            $misc->balance =  $newbalance;
                                            $misc->equity_fee = $amountdue;
                                            $misc->amountdue = $amountdue;
                                            $misc->unpaiddues = $unpaiddues;
                                            $misc->totaldues =  $totaldues;
                                            $misc->penalty = $penalty;
                                            $misc->payment = $totals;
                                           $misc->payment_type = $paymenttype;
                                           $misc->aror =$request->input('orar');
                                            $misc->checknumber = "";
                                            $misc->bankname = "";
                                            $misc->branch = "";
                                            $misc->datepaid = $request->input('paymentdate');
                                            $misc->status = "PAID";
                                            $misc->save();
                                        }
                                        }else{
                                             if($paymenttype=="Bank"){
                                             $misc = new Equity;
                                            $misc->client_id = $client_id;
                                            $misc->property_id = $property_id;
                                            $misc->date =$nextdate;
                                            $misc->balance =  $newbalance;
                                             $misc->equity_fee = $amountdue;
                                            $misc->amountdue = $amountdue;
                                            $misc->unpaiddues = $unpaiddues;
                                            $misc->totaldues =  $totaldues;
                                            $misc->penalty = $penalty;
                                            $misc->payment = $totaldues;
                                           $misc->payment_type = $paymenttype;
                                           $misc->aror =$request->input('orar');
                                            $misc->checknumber = $request->input('cheque');
                                            $misc->bankname = $request->input('bank');
                                            $misc->branch = $request->input('branch');
                                            $misc->datepaid = $request->input('paymentdate');
                                            $misc->status = "PAID";
                                            $misc->save();

                                           
                                         }else{
                                            
                                            $misc = new Equity;
                                            $misc->client_id = $client_id;
                                            $misc->property_id = $property_id;
                                            $misc->date =$nextdate;
                                            $misc->balance =  $newbalance;
                                            $misc->equity_fee = $amountdue;
                                            $misc->amountdue = $amountdue;
                                            $misc->unpaiddues = $unpaiddues;
                                            $misc->totaldues =  $totaldues;
                                            $misc->penalty = $penalty;
                                            $misc->payment = $totaldues;
                                           $misc->payment_type = $paymenttype;
                                           $misc->aror =$request->input('orar');
                                            $misc->checknumber = "";
                                            $misc->bankname = "";
                                            $misc->branch = "";
                                            $misc->datepaid = $request->input('paymentdate');
                                            $misc->status = "PAID";
                                            $misc->save();
                                        }
                                        }
                                       



                                        $unpaiddues=0;
                                        $penalty=0;
                                        $newpayment = $newpayment-$totaldues;
                                        $totaldues=$amountdue+$unpaiddues+$penalty;

                                      
                                      
                                        if($newpayment<=0){
                                            $dt = strtotime($olddate);
                                            $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                                            $olddate=$nextdate;
                                            // echo "COUNT: ".$counter."<br>";
                                            // echo "DATE: ".$olddate."<br>";
                                            // echo "TOTAL DUES: ".$amountdue."<br>";
                                            // echo "BALANCE: ".$newbalance."<br>";
                                            // echo "STATUS: PENDING<br><br>";
                                             $misc = new Equity;
                                            $misc->client_id = $client_id;
                                            $misc->property_id = $property_id;
                                            $misc->date =$nextdate;
                                            $misc->balance =  $newbalance;
                                             $misc->equity_fee = $amountdue;
                                            $misc->amountdue = $amountdue;
                                            $misc->unpaiddues = $unpaiddues;
                                            $misc->totaldues =  $totaldues;
                                            $misc->penalty = $penalty;
                                            $misc->payment = "";
                                            $misc->payment_type = "";
                                            $misc->aror = "";
                                            $misc->checknumber = "";
                                            $misc->bankname = "";
                                            $misc->branch = "";
                                            $misc->datepaid = "";
                                            $misc->status = "PENDING";
                                            $misc->save();


                                            break;
                                        }else if(round($newpayment,2)<round($totaldues,2)){
                                            $newbalance=$newbalance-$newpayment;
                                            $totaldues=round($totaldues,2)-round($newpayment,2);
                                            $dt = strtotime($olddate);
                                            $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                                            $olddate=$nextdate;
                                            // echo "COUNT: ".$counter."<br>";
                                            // echo "DATE: ".$olddate."<br>";
                                            //  echo "TOTAL DUES: ".$totaldues."<br>";
                                            // echo "PAYMENT: ".$newpayment."<br>";
                                            // echo "BALANCE: ".$newbalance."<br>";
                                            // echo "STATUS: PENDING<br><br>";
                                              $misc = new Equity;
                                            $misc->client_id = $client_id;
                                            $misc->property_id = $property_id;
                                            $misc->date =$nextdate;
                                            $misc->balance =  $newbalance;
                                            $misc->equity_fee = $amountdue;
                                            $misc->amountdue = $amountdue;
                                            $misc->unpaiddues = $unpaiddues;
                                            $misc->totaldues =  $totaldues;
                                            $misc->penalty = $penalty;
                                            $misc->payment = "";
                                            $misc->payment_type = "";
                                            $misc->aror = "";
                                            $misc->checknumber = "";
                                            $misc->bankname = "";
                                            $misc->branch = "";
                                            $misc->datepaid = "";
                                            $misc->status = "PENDING";
                                            $misc->save();
                                            break;
                                        }else{

                                        }
                                     
                                      
                                    }
                                }
                            }
                            




                        
                        }
                            
                    }else{
                        

                             if($paymenttype=="Bank"){
                                $pays=$payment-$oldpenalty;
                                $newbalance = $balance - $pays;
                                $misc->balance = $newbalance;
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
                               $pays=$payment-$oldpenalty;
                                $newbalance = $balance - $pays;
                                $misc->balance = $newbalance;
                               
                                $misc->payment = $payment;

                                $misc->payment_type = $paymenttype;
                                $misc->datepaid = $request->input('paymentdate');
                                $misc->aror =$request->input('orar');
                                $misc->status = "PAID";
                                $misc->save();
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

        }else if($process=="UNPAID"){

                    $misc = Equity::find($id);
                    $client_id = $misc->client_id;
                    $property_id = $misc->property_id;

                     $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
                    $buy_id=$buy[0]->id;
                    $misc_penalty = (($buy[0]->equity_penalty)/100);
                    $balance = $misc->balance;
                    $amountdue = $misc->amountdue;
                    $totaldues = $misc->totaldues;
                    $payment = $request->input('payment');
                    $olddate =$misc->date;

                    $unpaiddues=$totaldues;
                    $penalty=$unpaiddues*$misc_penalty;
                    $totaldues = $amountdue+$penalty+$unpaiddues; 
                    
                    $misc->status = "UNPAID";
                    $misc->save();


                    $dt = strtotime($olddate);
                    $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                    $misc = new Equity;
                    $misc->client_id = $client_id;
                    $misc->property_id = $property_id;
                    $misc->date =$nextdate;
                    $misc->balance =  $balance;
                    $misc->equity_fee = $amountdue;
                    $misc->amountdue = $amountdue;
                    $misc->unpaiddues = $unpaiddues;
                    $misc->totaldues =  $totaldues;
                    $misc->penalty = $penalty;
                    $misc->payment = "";
                    $misc->payment_type = "";
                    $misc->aror = "";
                    $misc->checknumber = "";
                    $misc->bankname = "";
                    $misc->branch = "";
                    $misc->datepaid = "";
                    $misc->status = "PENDING";
                    $misc->save();
                        $admin_id=session('Data')[0]->id;

        $log = new Log;
        $log->admin_id=$admin_id;
        $log->module="Equity";
        $log->description="Set unpaid";
        $log->save();



         $path = "admin-equity/".$buy_id."/edit";
            return redirect($path)->with('success','Successfully set unpaid.'); 
        }else{
            $this->validate($request,[
            'pin'=>'required'
            ]);
            $pins = Pin::all();
            $pin_id = $pins[0]->id;
            $pin = Pin::find($pin_id);

            $pin_password = $pin->pin;
            if($pin_password==$request->input('pin')){
                    $misc = Equity::find($id);

                    $client_id = $misc->client_id;
                    $property_id = $misc->property_id;

                    $miscall = Equity::where('client_id',$client_id)->where('property_id',$property_id)->get();

                    $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
                    $buy_id=$buy[0]->id;
                    $misc_penalty = (($buy[0]->equity_penalty)/100);
                    $balance = $misc->balance;
                    $amountdue = $misc->amountdue;
                    $totaldues = $misc->totaldues;
                    $payment = $request->input('payment');
                    $olddate =$misc->date;

                    
                    $misc->status = "VOID";
                    $misc->save();


                    $misc_number =count($miscall);
                    $misc_id = $miscall[$misc_number-1]->id;

                    $miscs = Equity::find($misc_id);
                    $oldbalance = $miscs->balance;
                    $oldunpaid = $miscs->unpaiddues;

                    $unpaiddues = $oldunpaid+$totaldues;
                    $penalty =  $penalty=$unpaiddues*$misc_penalty;
                    $newtotaldues = $amountdue+$penalty+$unpaiddues;

                    $newbalance = $oldbalance + $totaldues;
                    $miscs->balance = $newbalance;
                    $miscs->unpaiddues = $unpaiddues;
                    $miscs->penalty = $penalty;
                    $miscs->totaldues = $newtotaldues;
                    $miscs->save();

                  
                  
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
                $admin_id=session('Data')[0]->id;

        $log = new Log;
        $log->admin_id=$admin_id;
        $log->module="Equity";
        $log->description="Set void";
        $log->save();



         $path = "admin-equity/".$buy_id."/edit";
            return redirect($path)->with('success','Successfully void.'); 
        }

    
                
   //          }
   //      }  
       

       
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
