<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Inhouse;
use App\Penalty;
use App\Transfer;
use App\Client;
use Codedge\Fpdf\Fpdf\Fpdf;
class InHouseCollectionController extends Controller
{
    private $fpdf;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inhouses = Inhouse::groupBy('property_id')->get();
       
        return view('inhouse.index')->with('inhouses',$inhouses);
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

       

        $inhouses = Inhouse::where('property_id',$id)->where('status','!=','PENDING')->get();


        $this->fpdf = new Fpdf;
        $this->fpdf->AddPage('L');
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
        $this->fpdf->Cell(250,7,"List of Payment (Inhouse Collections)",0,0,'C');
        $this->fpdf->SetFont('Arial','',8);
        $this->fpdf->Cell(28,7,$today,0,0,'R');

        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->SetFont('Arial','',12);
        $this->fpdf->Cell(250,7,'Client Name: '.$inhouses[0]->client->lastname.', '.$inhouses[0]->client->firstname,0,0,'L');
        $this->fpdf->Cell(28,7,'',0,0,'R');

        $this->fpdf->Cell(0,7,'',0,1);
        $this->fpdf->SetFont('Arial','',12);
        $this->fpdf->Cell(250,7,'Property: Block: '.$inhouses[0]->property->block.', Lot: '.$inhouses[0]->property->lot,0,0,'L');
        $this->fpdf->Cell(28,7,'',0,0,'R');

        $transfer = Transfer::where('property_id',$id)->orderBy('id','desc')->get();

        if(count($transfer)>0){
            $oldclient = $transfer[0]->oldclient_id;
            $client = Client::find($oldclient);
             
            $this->fpdf->Cell(0,7,'',0,1);
            $this->fpdf->SetFont('Arial','',12);
            $this->fpdf->Cell(250,7,'Transfer from: '.$client->firstname.' '.$client->lastname,0,0,'L');
            $this->fpdf->Cell(28,7,'',0,0,'R');
        }
      




        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->Cell(11.16,7,"#",1,0,'C');
        $this->fpdf->Cell(17,7,"Date",1,0,'C');
        $this->fpdf->Cell(36.48,7,"Amount Due",1,0,'C');
        $this->fpdf->Cell(36.48,7,"Unpaid Dues",1,0,'C');
        $this->fpdf->Cell(35.9,7,"Penalty",1,0,'C');
        $this->fpdf->Cell(33.8,7,"Total Dues",1,0,'C');
        $this->fpdf->Cell(34.9,7,"Payments",1,0,'C');
        $this->fpdf->Cell(40,7,"Balance",1,0,'C');
        $this->fpdf->Cell(34,7,"O.R.",1,0,'C');

         $this->fpdf->SetFont('Arial','',8);
        foreach ($inhouses as $key => $inhouse) {
            $this->fpdf->Cell(0,7,'',0,1);
            $this->fpdf->Cell(11.16,7,$key+1,1,0,'C');
            $this->fpdf->Cell(17,7,$inhouse->date_due,1,0,'C');
            $this->fpdf->Cell(36.48,7,'Php. '.number_format($inhouse->amount_due,2),1,0,'C');
            $this->fpdf->Cell(36.48,7,'Php. '.number_format($inhouse->unpaid_due,2),1,0,'C');
            $this->fpdf->Cell(35.9,7,'Php. '.number_format($inhouse->penalty,2),1,0,'C');
            $this->fpdf->Cell(33.8,7,'Php. '.number_format($inhouse->total_due,2),1,0,'C');
            $this->fpdf->Cell(34.9,7,'Php. '.number_format($inhouse->payment,2),1,0,'C');
            $this->fpdf->Cell(40,7,'Php. '.number_format($inhouse->balance,2),1,0,'C');
            $this->fpdf->Cell(34,7,$inhouse->or,1,0,'C');
        }
       
       

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

        $inhouses = Inhouse::where('property_id',$id)->get();

        $count = count($inhouses);
        return view('inhouse.edit')->with('inhouses',$inhouses)->with('count',$count);
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
          
            
            $payment = $request->input('payment');
            $or = $request->input('or');
            $inhouseor=Inhouse::where('or',$or)->get();

            if(count($inhouseor)<=0){
            $inhouse = Inhouse::find($id);
            $penal = ($inhouse->percentage)/100;
            $client_id=$inhouse->client_id;
            $property_id=$inhouse->property_id;
            $buy_id=$inhouse->buy_id;
            $paymentscheme_id=$inhouse->paymentscheme_id;
            $loanable=$inhouse->loanable;
            $today = $inhouse->date_due;
            $monthly_amort = round($inhouse->monthly_amort,2);
            $old_balance = $inhouse->balance;
            $cts = $inhouse->cts;
            $penalty = $inhouse->percentage;


            if($payment<=$old_balance){
                if($payment==$old_balance){
                    $newbalance = $old_balance-$payment;
                        if($newbalance<=0){
                            $newbalance=0;
                    }
                    $inhouse->payment=$payment;
                    $inhouse->balance=$newbalance;
                    $inhouse->status="PAID";
                    $inhouse->or=$or;
                    $inhouse->save();
                    $dt = strtotime($today);

                    $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                    $date_due=$nextdate;
                    $inhouse = new Inhouse;
                    $inhouse->client_id=$client_id;
                    $inhouse->property_id=$property_id;
                    $inhouse->buy_id = $buy_id;
                    $inhouse->paymentscheme_id=$paymentscheme_id;
                    $inhouse->monthly_amort=$monthly_amort;
                    $inhouse->loanable=$loanable;
                    $inhouse->date_due=$date_due;
                    $inhouse->amount_due=$monthly_amort;
                    $inhouse->unpaid_due=$newbalance;

                    $newpenalty = $newbalance*$penal;
                    $inhouse->penalty=$newpenalty;
                    $inhouse->total_due=$newbalance+$newpenalty+$monthly_amort;
                    $inhouse->payment=0;
                    $inhouse->balance=$newbalance+$newpenalty+$monthly_amort;
                    $inhouse->status="PENDING";
                    $inhouse->cts=$cts;
                    $inhouse->percentage=$penalty;
                    $inhouse->save();
                    $path="/admin-inhouse/".$property_id."/edit";
                return redirect($path)->with('success','Successfully set payment to paid.');
                }else{

                    $newbalance = $old_balance-$payment;
                        if($newbalance<=0){
                            $newbalance=0;
                    }

                    $inhouse->payment=$payment;
                    $inhouse->balance=$newbalance;
                    $inhouse->status="PAID";
                    $inhouse->or=$or;
                    $inhouse->save();
                    $dt = strtotime($today);

                    $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                    $date_due=$nextdate;
                    $inhouse = new Inhouse;
                    $inhouse->client_id=$client_id;
                    $inhouse->property_id=$property_id;
                    $inhouse->buy_id = $buy_id;
                    $inhouse->paymentscheme_id=$paymentscheme_id;
                    $inhouse->monthly_amort=$monthly_amort;
                    $inhouse->loanable=$loanable;
                    $inhouse->date_due=$date_due;
                    $inhouse->amount_due=$monthly_amort;
                    $inhouse->unpaid_due=$newbalance;
                    
                    $newpenalty = $newbalance*$penal;
                    $inhouse->penalty=$newpenalty;
                    $inhouse->total_due=$newbalance+$newpenalty+$monthly_amort;
                    $inhouse->payment=0;
                    $inhouse->balance=$newbalance+$newpenalty+$monthly_amort;
                    $inhouse->status="PENDING";
                    $inhouse->cts=$cts;
                     $inhouse->percentage=$penalty;
                    $inhouse->save();
                    $path="/admin-inhouse/".$property_id."/edit";
                 return redirect($path)->with('success','Successfully set payment to paid.');
                }
            }else{
                $i=0;
                $change = $payment;
                while(true){
                       
                    

                   // print_r($change.' '.$old_balance.'\n');
                    if(round($change,2)>=$old_balance){
                        $change=$change-$old_balance;
                            $newbalance = 0;
                        $inhouse->payment=$old_balance;
                        $inhouse->balance=$newbalance;
                        $inhouse->status="PAID";
                        $inhouse->or=$or;
                        $inhouse->save();
                        $dt = strtotime($today);

                        $nextdate = date("Y-m-d", strtotime("+1 month", $dt));
                        $date_due=$nextdate;
                        $inhouse = new Inhouse;
                        $inhouse->client_id=$client_id;
                        $inhouse->property_id=$property_id;
                        $inhouse->buy_id = $buy_id;
                        $inhouse->paymentscheme_id=$paymentscheme_id;
                        $inhouse->monthly_amort=$monthly_amort;
                        $inhouse->loanable=$loanable;
                        $inhouse->date_due=$date_due;
                        $inhouse->amount_due=$monthly_amort;

                        $inhouse->unpaid_due=$newbalance;
                        $newpenalty = $newbalance*$penal;
                        $inhouse->penalty=$newpenalty;
                        $inhouse->total_due=$newbalance+$newpenalty+$monthly_amort;
                        $inhouse->payment=0;
                        $inhouse->balance=$newbalance+$newpenalty+$monthly_amort;
                        $inhouse->cts=$cts;
                         $inhouse->percentage=$penalty;
                        $inhouse->status="PENDING";
                        $inhouse->save();   


                        $inhouse = Inhouse::where('client_id',$client_id)->where('property_id',$property_id)->orderBy('id', 'desc')->first();
                        $client_id=$inhouse->client_id;
                        $property_id=$inhouse->property_id;
                        $buy_id=$inhouse->buy_id;
                        $paymentscheme_id=$inhouse->paymentscheme_id;
                        $loanable=$inhouse->loanable;
                        $today = $inhouse->date_due;
                        $monthly_amort = round($inhouse->monthly_amort,2);
                        $old_balance = $inhouse->balance;
                        $cts = $inhouse->cts;

                        
                    }else{
                        break;
                    }

                }
                  
                $path="/admin-inhouse/".$property_id."/edit";
                return redirect($path)->with('success','Successfully add payment');
                
            }//end

           
            }else{
                 $inhouse = Inhouse::find($id);
            $client_id=$inhouse->client_id;
            $property_id=$inhouse->property_id;
                    $path="/admin-inhouse/".$property_id."/edit";
                return redirect($path)->with('error','O.R. number is already in the system.');
            }

          

                
        }else if($process=="UNPAID"){
          
          
            $inhouse_id = Inhouse::where('id',$id)->get();
            if(count($inhouse_id)<=1){
                $inhouse = Inhouse::find($id);
                 $penal = ($inhouse->percentage)/100;
                $client_id=$inhouse->client_id;
                $property_id=$inhouse->property_id;
                $buy_id=$inhouse->buy_id;
                $paymentscheme_id=$inhouse->paymentscheme_id;
                $loanable=$inhouse->loanable;
                $today = $inhouse->date_due;
                $cts = $inhouse->cts;
                $monthly_amort = $inhouse->monthly_amort;
                $balance=$inhouse->balance;
                $unpaid_due = $inhouse->unpaid_due;
                $penalties = $unpaid_due*$penal;
                $penalty = $inhouse->percentage;
                $total_due=$monthly_amort+$unpaid_due+$penalties;
                $payments=0;
               
                $status="UNPAID";
                $inhouse->payment = $payments;
                $inhouse->status = $status; 
                $inhouse->save();


                $dt = strtotime($today);
                    $nextdate = date("Y-m-d", strtotime("+1 month", $dt));

                    $date_due=$nextdate;

                    $inhouse = new Inhouse;
                    $inhouse->client_id=$client_id;
                    $inhouse->property_id=$property_id;
                    $inhouse->buy_id = $buy_id;
                    $inhouse->paymentscheme_id=$paymentscheme_id;
                    $inhouse->monthly_amort=$monthly_amort;
                    $inhouse->loanable=$loanable;
                    $inhouse->date_due=$date_due;
                    $inhouse->amount_due=$monthly_amort;

                    $inhouse->unpaid_due=$balance;

                    $newpenalty = $balance*$penal;

                    $inhouse->penalty=$newpenalty;
                    $inhouse->total_due=$balance+$newpenalty+$monthly_amort;
                    $inhouse->payment=0;
                    $inhouse->balance=$balance+$newpenalty+$monthly_amort;;
                    $inhouse->status="PENDING";
                     $inhouse->cts=$cts;
                      $inhouse->percentage=$penalty;
                    $inhouse->save();
                    $path="/admin-inhouse/".$property_id."/edit";
                return redirect($path)->with('success','Successfully set payment to unpaid.');
            }else{
                $inhouse = Inhouse::find($id);
                $client_id=$inhouse->client_id;
                 $penal = ($inhouse->percentage)/100;
                $property_id=$inhouse->property_id;
                $buy_id=$inhouse->buy_id;
                $paymentscheme_id=$inhouse->paymentscheme_id;
                $loanable=$inhouse->loanable;
                $today = $inhouse->date_due;
                $cts = $inhouse->cts;
                $monthly_amort = $inhouse->monthly_amort;
                $balance=$inhouse->balance;
                $unpaid_due = $inhouse->unpaid_due;
                $penalties = $unpaid_due*$penal;
                
                $total_due=$monthly_amort+$unpaid_due+$penalties;
                $payments=0;
               
                $status="UNPAID";
                $inhouse->payment = $payments;
                $inhouse->status = $status; 
                $inhouse->save();


                $dt = strtotime($today);
                    $nextdate = date("Y-m-d", strtotime("+1 month", $dt));

                    $date_due=$nextdate;

                    $inhouse = new Inhouse;
                    $inhouse->client_id=$client_id;
                    $inhouse->property_id=$property_id;
                    $inhouse->buy_id = $buy_id;
                    $inhouse->paymentscheme_id=$paymentscheme_id;
                    $inhouse->monthly_amort=$monthly_amort;
                    $inhouse->loanable=$loanable;
                    $inhouse->date_due=$date_due;
                    $inhouse->amount_due=$monthly_amort;

                    $inhouse->unpaid_due=$balance;

                    $newpenalty = $balance*$penal;

                    $inhouse->penalty=$newpenalty;
                    $inhouse->total_due=$balance+$newpenalty+$monthly_amort;
                    $inhouse->payment=0;
                    $inhouse->balance=$balance+$newpenalty+$monthly_amort;;
                    $inhouse->status="PENDING";
                     $inhouse->cts=$cts;
                      $inhouse->percentage=$penalty;
                    $inhouse->save();
                    $path="/admin-inhouse/".$property_id."/edit";
                return redirect($path)->with('success','Successfully set payment to unpaid.');
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
