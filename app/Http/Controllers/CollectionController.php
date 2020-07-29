<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Buy;
use App\Misc;
use App\Equity;
use App\Property;
use App\PaymentScheme;
use App\Transfer;
use App\Client;
use Codedge\Fpdf\Fpdf\Fpdf;
class CollectionController extends Controller
{
    private $fpdf;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buys = Buy::where('status','ACTIVE')->get();
        $paymentscheme = PaymentScheme::where('status','ACTIVE')->get();

        return view('collection.index')->with('buys',$buys)->with('paymentscheme',$paymentscheme);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\m_responsekeys(conn, identifier)
     */
    public function create()
    {
        
    }

    public function misc($id){
        return $id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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

        $buys = Buy::find($id);
        $property_id = $buys->property_id;

        $miscs = Misc::where('property_id',$property_id)->where('status','!=','PENDING')->get();
       

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
        $this->fpdf->Cell(250,7,"List of Payment (Miscellaneous)",0,0,'C');
        $this->fpdf->SetFont('Arial','',8);
        $this->fpdf->Cell(28,7,$today,0,0,'R');
         if(count($miscs)>0){
        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->SetFont('Arial','',12);
        $this->fpdf->Cell(250,7,'Client Name: '.$miscs[0]->client->lastname.', '.$miscs[0]->client->firstname,0,0,'L');
        $this->fpdf->Cell(28,7,'',0,0,'R');

         $this->fpdf->Cell(0,7,'',0,1);
        $this->fpdf->SetFont('Arial','',12);
        $this->fpdf->Cell(250,7,'Property: Block: '.$miscs[0]->property->block.', Lot: '.$miscs[0]->property->lot,0,0,'L');
        $this->fpdf->Cell(28,7,'',0,0,'R');

         $transfer = Transfer::where('property_id',$property_id)->orderBy('id','desc')->get();

        if(count($transfer)>0){
            $oldclient = $transfer[0]->oldclient_id;
            $client = Client::find($oldclient);
             
            $this->fpdf->Cell(0,7,'',0,1);
            $this->fpdf->SetFont('Arial','',12);
            $this->fpdf->Cell(250,7,'Transfer from:  '.$client->firstname.' '.$client->lastname,0,0,'L');
            $this->fpdf->Cell(28,7,'',0,0,'R');
        }



        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->Cell(11.16,7,"#",1,0,'C');
        $this->fpdf->Cell(17,7,"Date",1,0,'C');
        $this->fpdf->Cell(36.48,7,"Balance",1,0,'C');
        $this->fpdf->Cell(36.48,7,"Misc Fee",1,0,'C');
        $this->fpdf->Cell(35.9,7,"Penalty",1,0,'C');
        $this->fpdf->Cell(33.8,7,"Payment",1,0,'C');
        $this->fpdf->Cell(34.9,7,"Payment Type",1,0,'C');
        $this->fpdf->Cell(40,7,"OR/AR",1,0,'C');
        $this->fpdf->Cell(34,7,"Status",1,0,'C');

       
             $this->fpdf->SetFont('Arial','',8);
            foreach ($miscs as $key => $misc) {
                $this->fpdf->Cell(0,7,'',0,1);
                $this->fpdf->Cell(11.16,7,$key+1,1,0,'C');
                $this->fpdf->Cell(17,7,$misc->date,1,0,'C');
              if($misc->balance<=0){
                  $this->fpdf->Cell(36.48,7,"0.00",1,0,'C');
            }else{
                  $this->fpdf->Cell(36.48,7,$misc->balance,1,0,'C');
            }
                $this->fpdf->Cell(36.48,7,$misc->misc_fee,1,0,'C');
                $this->fpdf->Cell(35.9,7,$misc->penalty,1,0,'C');
                $this->fpdf->Cell(33.8,7,$misc->payment,1,0,'C');
                $this->fpdf->Cell(34.9,7,$misc->payment_type,1,0,'C');
                $this->fpdf->Cell(40,7,$misc->aror,1,0,'C');
                $this->fpdf->Cell(34,7,$misc->status,1,0,'C');
            }
        }
       

         $equities = Equity::where('property_id',$property_id)->where('status','!=','PENDING')->get();

       
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
        $this->fpdf->Cell(250,7,"List of Payment (Equity)",0,0,'C');
        $this->fpdf->SetFont('Arial','',8);
        $this->fpdf->Cell(28,7,$today,0,0,'R');
          if(count($equities)>0){
        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->SetFont('Arial','',12);
        $this->fpdf->Cell(250,7,'Client Name: '.$equities[0]->client->lastname.', '.$equities[0]->client->firstname,0,0,'L');
        $this->fpdf->Cell(28,7,'',0,0,'R');

         $this->fpdf->Cell(0,7,'',0,1);
        $this->fpdf->SetFont('Arial','',12);
        $this->fpdf->Cell(250,7,'Property: Block: '.$equities[0]->property->block.', Lot: '.$equities[0]->property->lot,0,0,'L');
        $this->fpdf->Cell(28,7,'',0,0,'R');

         $transfer = Transfer::where('property_id',$property_id)->orderBy('id','desc')->get();

        if(count($transfer)>0){
            $oldclient = $transfer[0]->oldclient_id;
            $client = Client::find($oldclient);
             
            $this->fpdf->Cell(0,7,'',0,1);
            $this->fpdf->SetFont('Arial','',12);
            $this->fpdf->Cell(250,7,'Transfer from:  '.$client->firstname.' '.$client->lastname,0,0,'L');
            $this->fpdf->Cell(28,7,'',0,0,'R');
        }

        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->Cell(11.16,7,"#",1,0,'C');
        $this->fpdf->Cell(17,7,"Date",1,0,'C');
        $this->fpdf->Cell(36.48,7,"Balance",1,0,'C');
        $this->fpdf->Cell(36.48,7,"Misc Fee",1,0,'C');
        $this->fpdf->Cell(35.9,7,"Penalty",1,0,'C');
        $this->fpdf->Cell(33.8,7,"Payment",1,0,'C');
        $this->fpdf->Cell(34.9,7,"Payment Type",1,0,'C');
        $this->fpdf->Cell(40,7,"OR/AR",1,0,'C');
        $this->fpdf->Cell(34,7,"Status",1,0,'C');

        $this->fpdf->SetFont('Arial','',8);

       
             foreach ($equities as $key => $misc) {
            $this->fpdf->Cell(0,7,'',0,1);
            $this->fpdf->Cell(11.16,7,$key+1,1,0,'C');
            $this->fpdf->Cell(17,7,$misc->date,1,0,'C');
            if($misc->balance<=0){
                  $this->fpdf->Cell(36.48,7,"0.00",1,0,'C');
            }else{
                  $this->fpdf->Cell(36.48,7,$misc->balance,1,0,'C');
            }
          
            $this->fpdf->Cell(36.48,7,$misc->equity_fee,1,0,'C');
            $this->fpdf->Cell(35.9,7,$misc->penalty,1,0,'C');
            $this->fpdf->Cell(33.8,7,$misc->payment,1,0,'C');
            $this->fpdf->Cell(34.9,7,$misc->payment_type,1,0,'C');
            $this->fpdf->Cell(40,7,$misc->aror,1,0,'C');
            $this->fpdf->Cell(34,7,$misc->status,1,0,'C');
        }
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
