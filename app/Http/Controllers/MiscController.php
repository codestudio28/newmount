<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Client;
use App\Property;
use App\Buy;
use App\Misc;
use App\Pin;
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
                $miscs = Misc::all();
                $misc = Misc::find($id);
            
                $client_id = $misc->client_id;
                $property_id = $misc->property_id;
                $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
                $buy_id=$buy[0]->id;
                 $nummisc=Misc::where('client_id',$client_id)->where('property_id',$property_id)->get();
                $len_misc= count($nummisc);

                $misc_penalty = (($buy[0]->misc_penalty)/100);
                $lastpenalty =$nummisc[$len_misc-2]->penalty;
               
                $last_payment = $misc->payment;
                $payment_penalty = $last_payment * $misc_penalty;
                $total_penalty = $payment_penalty +  $lastpenalty;

                $balance = $nummisc[$len_misc-1]->balance;

                $newbalance = $balance+$last_payment;


        
                $misc_id = $nummisc[$len_misc-2]->id;
                $miscpenalty = Misc::find($misc_id);
                $miscpenalty->penalty= $total_penalty;
                $miscpenalty->balance = $newbalance;
                $miscpenalty->save();

                $misc_void =  Misc::find($id);
                $misc_void->status="VOID";
                $misc_void->save();
                
                $newbal_id = $nummisc[$len_misc-1]->id;
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
            $nummisc=Misc::where('client_id',$client_id)->where('property_id',$property_id)->get();
            $len_misc= count($nummisc);
            $balance = $nummisc[$len_misc-1]->balance;
            $misc_fee = $misc->misc_fee;
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
                $nummisc=Misc::where('client_id',$client_id)->where('property_id',$property_id)->get();
                $len_misc= count($nummisc);
                $balance = $nummisc[$len_misc-1]->balance;
                $misc_fee = $misc->misc_fee;
                $payment = $request->input('payment');

                $olddate = $misc->date;

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
                }else if($misc_fee==$payment){
                    if($len_misc<=1){
                        $penalty = 0;
                    }else{
                        $bal = $nummisc[$len_misc-2]->penalty;
                        $penalty = $bal + ($bal  *  $misc_penalty);
                    }
                }else if($misc_fee<$payment){
                if($len_misc<=1){
                    $penalty = 0;
                }else{
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
                    }
                }

                // Saving
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

                    if($newbalance<=0){

                    }else{
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

                    }

                // End saving
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
                $nummisc=Misc::where('client_id',$client_id)->where('property_id',$property_id)->get();
                $len_misc= count($nummisc);
                $balance = $nummisc[$len_misc-1]->balance;
                $misc_fee = $misc->misc_fee;
                $payment = $request->input('payment');

                $olddate = $misc->date;

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
                }else if($misc_fee==$payment){
                    if($len_misc<=1){
                        $penalty = 0;
                    }else{
                        $bal = $nummisc[$len_misc-2]->penalty;
                        $penalty = $bal + ($bal  *  $misc_penalty);
                    }
                }else if($misc_fee<$payment){
                if($len_misc<=1){
                    $penalty = 0;
                }else{
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
                    }
                }

                // Saving
                    $newbalance = $balance - $payment;
                    $misc->balance = $newbalance;
                    $misc->penalty = $penalty;
                    $misc->payment = $payment;
                    $misc->payment_type = $paymenttype;
                    $misc->datepaid = $request->input('paymentdate');
                    $misc->aror =$request->input('orar');
                    $misc->status = "PAID";
                    $misc->save();

                    if($newbalance<=0){

                    }else{
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

                    }
                   
                // End saving
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
