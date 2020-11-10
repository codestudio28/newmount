<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Client;
use App\Property;
use App\Buy;
use App\Misc;
use App\Pin;
use App\Log;
use Codedge\Fpdf\Fpdf\Fpdf;
class MiscController extends Controller
{
    private $fpdf;
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
        date_default_timezone_set("Asia/Manila");
        $year =date('Y');
        $month=date('m');
        $day=date('d');
        $hour=date('G');
        $min=date('i');
        $sec=date('s');

        $dates=$year."-".$month."-".$day;
        $times=$hour.":".$min.":".$sec;

        $today = $dates." ".$times;
        $logo = url('logo/logo.png');

        $misc = Misc::find($id);


        $this->fpdf = new Fpdf;
        $this->fpdf->AddPage('P');
        $this->fpdf->SetFont('Arial','',12);
        $this->fpdf->Image($logo,10,10,30);
        $this->fpdf->Cell(30,5,"",0,0,'L');
        $this->fpdf->Cell(100,5,"Mount Malarayat Property Development Corporation",0,0,'L');
        $this->fpdf->Cell(0,5,'',0,1);
        $this->fpdf->Cell(30,5,"",0,0,'L');
        $this->fpdf->Cell(100,5,"Address",0,0,'L');
        $this->fpdf->Cell(0,5,'',0,1);
        $this->fpdf->Cell(30,5,"",0,0,'L');
        $this->fpdf->Cell(100,5,"Contact Number:",0,0,'L');

        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->SetFont('Arial','',14);
        $this->fpdf->Cell(142,7,"ACKNOWLEDGEMENT RECEIPT",0,0,'C');
         $this->fpdf->Cell(50,7,'#'.$misc->aror,0,0,'R');
 
     

        $this->fpdf->SetFont('Arial','',12);
        
        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->Cell(60,7,'Received the amount of ',0,0,'L');
      
        $this->fpdf->Cell(102,7,'Php. '.number_format($misc->payment,2),0,0,'L');
        $this->fpdf->Cell(0,10,'',0,1);
          $this->fpdf->SetFont('Arial','',12);
        $this->fpdf->Cell(60,7,'From  ',0,0,'L');
      
        $this->fpdf->Cell(102,7,$misc->client->firstname.' '.$misc->client->lastname,0,0,'L');
        $this->fpdf->Cell(0,10,'',0,1);
          $this->fpdf->SetFont('Arial','',12);
        $this->fpdf->Cell(60,7,'As payment for  ',0,0,'L');
       
        $this->fpdf->Cell(102,7,'Block: '.$misc->property->block.' Lot: '.$misc->property->lot,0,0,'L');
        $this->fpdf->Cell(0,10,'',0,1);

        if($misc->payment_type=="Bank"){
             $this->fpdf->Cell(162,7,'Payment type: BANK  ',0,0,'L');
             $this->fpdf->Cell(0,10,'',0,1);
             $this->fpdf->Cell(60,7,'Bank : '.$misc->bankname,0,0,'L');
             $this->fpdf->Cell(0,7,'',0,1);
             $this->fpdf->Cell(60,7,'Branch : '.$misc->branch,0,0,'L');
             $this->fpdf->Cell(0,7,'',0,1);
             $this->fpdf->Cell(60,7,'Cheque Number : '.$misc->checknumber,0,0,'L');
        }else{
             $this->fpdf->Cell(162,7,'Payment type: '.$misc->payment_type,0,0,'L');
        }
        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->Cell(60,7,'__________________________',0,0,'L');
        $this->fpdf->Cell(0,5,'',0,1);
        $this->fpdf->Cell(60,7,'Signature  ',0,0,'L');
        $this->fpdf->Cell(0,12,'',0,1);
        $this->fpdf->Cell(162,7,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - ',0,0,'L');

   

       

       
            

            $this->fpdf->Output();
        
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
        $miscs = Misc::where('client_id',$client_id)->where('property_id',$property_id)->orderBy('date','ASC')->get();
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

                $or = Misc::where('aror',$request->input('orar'))->get();
                 if(count($or)>0){
                    $miscs = Misc::all();
                    $misc = Misc::find($id);
                
                    $client_id = $misc->client_id;
                    $property_id = $misc->property_id;
                    $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
                    $buy_id=$buy[0]->id;
                    $path = "admin-misc/".$buy_id."/edit";
                    return redirect($path)->with('error','AR number is already in the system.'); 
                }else{
                     if($paymenttype=="Bank"){
                        $checks = Misc::where('checknumber',$request->input('cheque'))->get();

                        if(count($checks)>0){
                            $path = "admin-misc/".$buy_id."/edit";
                        return redirect($path)->with('error','Cheque already in used.'); 
                        }
                    }

                    $misc = Misc::find($id);
                    $client_id = $misc->client_id;
                    $property_id = $misc->property_id;

                     $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
                    $buy_id=$buy[0]->id;
                    $misc_penalty = (($buy[0]->misc_penalty)/100);
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
                                $misc = new Misc;
                                $misc->client_id = $client_id;
                                $misc->property_id = $property_id;
                                $misc->date =$nextdate;
                                $misc->balance =  $newbalance;
                                $misc->misc_fee = $amountdue;
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
                                $misc = new Misc;
                                $misc->client_id = $client_id;
                                $misc->property_id = $property_id;
                                $misc->date =$nextdate;
                                $misc->balance =  $newbalance;
                                $misc->misc_fee = $amountdue;
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

                                       
                                            $misc = new Misc;
                                            $misc->client_id = $client_id;
                                            $misc->property_id = $property_id;
                                            $misc->date =$nextdate;
                                            $misc->balance =  $newbalance;
                                            $misc->misc_fee = $amountdue;
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


                                            $misc = new Misc;
                                            $misc->client_id = $client_id;
                                            $misc->property_id = $property_id;
                                            $misc->date =$nextdate;
                                            $misc->balance =  $newbalance;
                                            $misc->misc_fee = $amountdue;
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

                                            $misc = new Misc;
                                            $misc->client_id = $client_id;
                                            $misc->property_id = $property_id;
                                            $misc->date =$nextdate;
                                            $misc->balance =  $newbalance;
                                            $misc->misc_fee = $amountdue;
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


                                            $misc = new Misc;
                                            $misc->client_id = $client_id;
                                            $misc->property_id = $property_id;
                                            $misc->date =$nextdate;
                                            $misc->balance =  $newbalance;
                                            $misc->misc_fee = $amountdue;
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
                                                     $misc = new Misc;
                                                    $misc->client_id = $client_id;
                                                    $misc->property_id = $property_id;
                                                    $misc->date =$nextdate;
                                                    $misc->balance =  $newbalance;
                                                    $misc->misc_fee = $amountdue;
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
                                                        
                                                        $misc = new Misc;
                                                        $misc->client_id = $client_id;
                                                        $misc->property_id = $property_id;
                                                        $misc->date =$nextdate;
                                                        $misc->balance =  $newbalance;
                                                        $misc->misc_fee = $amountdue;
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
                                             $misc = new Misc;
                                            $misc->client_id = $client_id;
                                            $misc->property_id = $property_id;
                                            $misc->date =$nextdate;
                                            $misc->balance =  $newbalance;
                                            $misc->misc_fee = $amountdue;
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
                                                
                                                $misc = new Misc;
                                                $misc->client_id = $client_id;
                                                $misc->property_id = $property_id;
                                                $misc->date =$nextdate;
                                                $misc->balance =  $newbalance;
                                                $misc->misc_fee = $amountdue;
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
                                             $misc = new Misc;
                                            $misc->client_id = $client_id;
                                            $misc->property_id = $property_id;
                                            $misc->date =$nextdate;
                                            $misc->balance =  $newbalance;
                                            $misc->misc_fee = $amountdue;
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
                                              $misc = new Misc;
                                            $misc->client_id = $client_id;
                                            $misc->property_id = $property_id;
                                            $misc->date =$nextdate;
                                            $misc->balance =  $newbalance;
                                            $misc->misc_fee = $amountdue;
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
        $log->module="Miscellaneous";
        $log->description="Set miscellaneous paid";
        $log->save();



         $path = "admin-misc/".$buy_id."/edit";
            // return redirect($path)->with('success','Successfully add payment.'); 

        }else if($process=="UNPAID"){

                    $misc = Misc::find($id);
                    $client_id = $misc->client_id;
                    $property_id = $misc->property_id;

                     $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
                    $buy_id=$buy[0]->id;
                    $misc_penalty = (($buy[0]->misc_penalty)/100);
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
                    $misc = new Misc;
                    $misc->client_id = $client_id;
                    $misc->property_id = $property_id;
                    $misc->date =$nextdate;
                    $misc->balance =  $balance;
                    $misc->misc_fee = $amountdue;
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
        $log->module="Miscellaneous";
        $log->description="Set miscellaneous unpaid";
        $log->save();



         $path = "admin-misc/".$buy_id."/edit";
            return redirect($path)->with('success','Successfully set unpaid payment.'); 
        }else{
            $this->validate($request,[
            'pin'=>'required'
            ]);
            $pins = Pin::all();
            $pin_id = $pins[0]->id;
            $pin = Pin::find($pin_id);

            $pin_password = $pin->pin;
            if($pin_password==$request->input('pin')){
                    $misc = Misc::find($id);

                    $client_id = $misc->client_id;
                    $property_id = $misc->property_id;

                    $miscall = Misc::where('client_id',$client_id)->where('property_id',$property_id)->get();

                    $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
                    $buy_id=$buy[0]->id;
                    $misc_penalty = (($buy[0]->misc_penalty)/100);
                    $balance = $misc->balance;
                    $amountdue = $misc->amountdue;
                    $totaldues = $misc->totaldues;
                    $payment = $request->input('payment');
                    $olddate =$misc->date;

                    
                    $misc->status = "VOID";
                    $misc->save();


                    $misc_number =count($miscall);
                    $misc_id = $miscall[$misc_number-1]->id;

                    $miscs = Misc::find($misc_id);
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
                $misc = Misc::find($id);
                $miscs = Misc::all();
                $client_id = $misc->client_id;
                $property_id = $misc->property_id;
                $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
                $buy_id=$buy[0]->id;

                    $path = "admin-misc/".$buy_id."/edit";
                return redirect($path)->with('error','Wrong pin password.');
            }
              $admin_id=session('Data')[0]->id;

        $log = new Log;
        $log->admin_id=$admin_id;
        $log->module="Miscellaneous";
        $log->description="Set miscellaneous void";
        $log->save();



         $path = "admin-misc/".$buy_id."/edit";
            return redirect($path)->with('success','Successfully void payment.'); 
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
