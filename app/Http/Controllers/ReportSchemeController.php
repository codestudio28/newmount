<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Client;
use App\Property;
use App\Buy;
use App\Misc;
use App\Equity;
use Codedge\Fpdf\Fpdf\Fpdf;
class ReportSchemeController extends Controller
{
    private $fpdf;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $sfiltered = session('filtered');
        if(strlen($sfiltered)<=0){
            session()->put('filtered','ALL');
          
        }
        $srecords = session('records');
        if(strlen($srecords)<=0){
            session()->put('records','10');
          
        }

         $ssearch = session('search');
        if(strlen($ssearch)<=0){
            session()->put('search','');
          
        }
        $filtered = session('filtered');
        $records = session('records');
        $search = session('search');
        $filters = array("ALL", "LAST NAME", "FIRST NAME", "PAYMENT SCHEME");
        $display = array("1", "5", "10", "50", "100", "500");

        $buys = Buy::orderBy('id','desc')->get();
        $count= count($buys);
        $client=array();
        $property=array();
        $tcp=array();
        $status=array();
        $equity_bal=array();
        $misc_bal=array();
        $equity_pen=array();
        $misc_pen=array();
     
        foreach ($buys as $key => $buy) {
            $misc_count = count($buy->property->misc);
            $equity_count = count($buy->property->equity);
            array_push($client,$buy->client->firstname." ".$buy->client->lastname);
            array_push($status,$buy->paymentscheme->paymentname);
            array_push($property,"Block: ".$buy->property->block." Lot: ".$buy->property->lot);
            array_push($tcp,"Php. ".number_format($buy->tcp,2));
            array_push($equity_bal,"Php. ".number_format($buy->property->equity[$equity_count-1]->balance,2));
            array_push($misc_bal,"Php. ".number_format($buy->property->misc[$misc_count-1]->balance,2));


            if($misc_count<=1){
                  array_push($misc_pen,"Php. ".number_format('0',2));
             }else{
                 array_push($misc_pen,"Php. ".number_format($buy->property->misc[$misc_count-2]->penalty,2));
             }
               
             if($equity_count<=1){
                 array_push($equity_pen,"Php. ".number_format('0',2));
             }else{
                 array_push($equity_pen,"Php. ".number_format($buy->property->equity[$equity_count-2]->penalty,2));
             } 
            


        }
   $buys = Buy::orderBy('id','desc')->paginate($records);
         return view('report.scheme')
         ->with('buys',$buys)
         ->with('client',$client)
         ->with('property',$property)
         ->with('tcp',$tcp)
         ->with('status',$status)
         ->with('equity_bal',$equity_bal)
         ->with('equity_pen',$equity_pen)
         ->with('misc_bal',$misc_bal)
         ->with('misc_pen',$misc_pen)
         ->with('filtered',$filtered)
         ->with('records',$records)
         ->with('search',$search)
         ->with('filters',$filters)
         ->with('display',$display);



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
        $filtered = $request->input('filter');
        $records = $request->input('records');
        $search = $request->input('search');

        session()->put('filtered',$filtered);
        session()->put('records',$records);
        session()->put('search',$search);

        $filtered = session('filtered');
        $records = session('records');
        $search = session('search');
        $filters = array("ALL", "LAST NAME", "FIRST NAME", "PAYMENT SCHEME");
        $display = array("1", "5", "10", "50", "100", "500");
       
        if($filtered=="ALL"){
            $buys = Buy::orderBy('id','desc')->get();
            $count= count($buys);  
            $client=array();
            $property=array();
            $tcp=array();
          
            $status=array();
            $equity_bal=array();
            $misc_bal=array();
            $equity_pen=array();
            $misc_pen=array();
         
            foreach ($buys as $key => $buy) {
                $misc_count = count($buy->property->misc);
                $equity_count = count($buy->property->equity);
                array_push($status,$buy->paymentscheme->paymentname);
                array_push($client,$buy->client->firstname." ".$buy->client->lastname);
                array_push($property,"Block: ".$buy->property->block." Lot: ".$buy->property->lot);
                array_push($tcp,"Php. ".number_format($buy->tcp,2));
                array_push($equity_bal,"Php. ".number_format($buy->property->equity[$equity_count-1]->balance,2));
                array_push($misc_bal,"Php. ".number_format($buy->property->misc[$misc_count-1]->balance,2));
                if($misc_count<=1){
                  array_push($misc_pen,"Php. ".number_format('0',2));
             }else{
                 array_push($misc_pen,"Php. ".number_format($buy->property->misc[$misc_count-2]->penalty,2));
             }
               
             if($equity_count<=1){
                 array_push($equity_pen,"Php. ".number_format('0',2));
             }else{
                 array_push($equity_pen,"Php. ".number_format($buy->property->equity[$equity_count-2]->penalty,2));
             } 
               


            }
        }else if($filtered=="LAST NAME"){
            $buys = Buy::orderBy('id','desc')->get();
            $count= count($buys);  
            $client=array();
            $property=array();
            $tcp=array();
          
            $status=array();
            $equity_bal=array();
            $misc_bal=array();
            $equity_pen=array();
            $misc_pen=array();
         
            foreach ($buys as $key => $buy) {
                $misc_count = count($buy->property->misc);
                $equity_count = count($buy->property->equity);
                if(strtoupper($search)==strtoupper($buy->client->lastname)){
                    array_push($status,$buy->paymentscheme->paymentname);
                    array_push($client,$buy->client->firstname." ".$buy->client->lastname);
                    array_push($property,"Block: ".$buy->property->block." Lot: ".$buy->property->lot);
                    array_push($tcp,"Php. ".number_format($buy->tcp,2));
                    array_push($equity_bal,"Php. ".number_format($buy->property->equity[$equity_count-1]->balance,2));
                    array_push($misc_bal,"Php. ".number_format($buy->property->misc[$misc_count-1]->balance,2));
                  if($misc_count<=1){
                  array_push($misc_pen,"Php. ".number_format('0',2));
             }else{
                 array_push($misc_pen,"Php. ".number_format($buy->property->misc[$misc_count-2]->penalty,2));
             }
               
             if($equity_count<=1){
                 array_push($equity_pen,"Php. ".number_format('0',2));
             }else{
                 array_push($equity_pen,"Php. ".number_format($buy->property->equity[$equity_count-2]->penalty,2));
             } 
                }
              
               


            }
        }else if($filtered=="FIRST NAME"){
            $buys = Buy::orderBy('id','desc')->get();
            $count= count($buys);  
            $client=array();
            $property=array();
            $tcp=array();
          
            $status=array();
            $equity_bal=array();
            $misc_bal=array();
            $equity_pen=array();
            $misc_pen=array();
         
            foreach ($buys as $key => $buy) {
                $misc_count = count($buy->property->misc);
                $equity_count = count($buy->property->equity);
                if(strtoupper($search)==strtoupper($buy->client->firstname)){
                    array_push($status,$buy->paymentscheme->paymentname);
                    array_push($client,$buy->client->firstname." ".$buy->client->lastname);
                    array_push($property,"Block: ".$buy->property->block." Lot: ".$buy->property->lot);
                    array_push($tcp,"Php. ".number_format($buy->tcp,2));
                    array_push($equity_bal,"Php. ".number_format($buy->property->equity[$equity_count-1]->balance,2));
                    array_push($misc_bal,"Php. ".number_format($buy->property->misc[$misc_count-1]->balance,2));
                   if($misc_count<=1){
                  array_push($misc_pen,"Php. ".number_format('0',2));
             }else{
                 array_push($misc_pen,"Php. ".number_format($buy->property->misc[$misc_count-2]->penalty,2));
             }
               
             if($equity_count<=1){
                 array_push($equity_pen,"Php. ".number_format('0',2));
             }else{
                 array_push($equity_pen,"Php. ".number_format($buy->property->equity[$equity_count-2]->penalty,2));
             } 
                }
              
               


            }
        }
         $buys = Buy::orderBy('id','desc')->paginate($records);
         return view('report.scheme')
         ->with('buys',$buys)
         ->with('client',$client)
         ->with('property',$property)
         ->with('tcp',$tcp)
         ->with('status',$status)
         ->with('equity_bal',$equity_bal)
         ->with('equity_pen',$equity_pen)
         ->with('misc_bal',$misc_bal)
         ->with('misc_pen',$misc_pen)
         ->with('filtered',$filtered)
         ->with('records',$records)
         ->with('search',$search)
         ->with('filters',$filters)
         ->with('display',$display);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $filtered = session('filtered');
        $records = session('records');
        $search = session('search');
        $filters = array("ALL", "LAST NAME", "FIRST NAME", "PAYMENT SCHEME");
        $display = array("1", "5", "10", "50", "100", "500");

        $total_tcp=0;
        $total_equity_bal=0;
        $total_misc_bal=0;
        $total_equity_pen=0;
        $total_misc_pen=0;
         if($filtered=="ALL"){
            $buys = Buy::orderBy('id','desc')->get();
            $count= count($buys);  
            $client=array();
            $property=array();
            $tcp=array();
          
            $status=array();
            $equity_bal=array();
            $misc_bal=array();
            $equity_pen=array();
            $misc_pen=array();
         
            foreach ($buys as $key => $buy) {
                $misc_count = count($buy->property->misc);
                $equity_count = count($buy->property->equity);
                   $total_tcp=$total_tcp+$buy->tcp;
                $total_equity_bal=$total_equity_bal+$buy->property->equity[$equity_count-1]->balance;
                $total_misc_bal=$total_misc_bal+$buy->property->misc[$misc_count-1]->balance;
                $total_equity_pen=$total_equity_pen+$buy->property->equity[$equity_count-2]->penalty;
                $total_misc_pen=$total_misc_pen+$buy->property->misc[$misc_count-2]->penalty;
                array_push($status,$buy->paymentscheme->paymentname);
                array_push($client,$buy->client->firstname." ".$buy->client->lastname);
                array_push($property,"Block: ".$buy->property->block." Lot: ".$buy->property->lot);
                array_push($tcp,"Php. ".number_format($buy->tcp,2));
                array_push($equity_bal,"Php. ".number_format($buy->property->equity[$equity_count-1]->balance,2));
                array_push($misc_bal,"Php. ".number_format($buy->property->misc[$misc_count-1]->balance,2));
               if($misc_count<=1){
                  array_push($misc_pen,"Php. ".number_format('0',2));
             }else{
                 array_push($misc_pen,"Php. ".number_format($buy->property->misc[$misc_count-2]->penalty,2));
             }
               
             if($equity_count<=1){
                 array_push($equity_pen,"Php. ".number_format('0',2));
             }else{
                 array_push($equity_pen,"Php. ".number_format($buy->property->equity[$equity_count-2]->penalty,2));
             } 
               


            }
        }else if($filtered=="LAST NAME"){
            $buys = Buy::orderBy('id','desc')->get();
            $count= count($buys);  
            $client=array();
            $property=array();
            $tcp=array();
          
            $status=array();
            $equity_bal=array();
            $misc_bal=array();
            $equity_pen=array();
            $misc_pen=array();
         
            foreach ($buys as $key => $buy) {
                $misc_count = count($buy->property->misc);
                $equity_count = count($buy->property->equity);
                if(strtoupper($search)==strtoupper($buy->client->lastname)){
                       $total_tcp=$total_tcp+$buy->tcp;
                $total_equity_bal=$total_equity_bal+$buy->property->equity[$equity_count-1]->balance;
                $total_misc_bal=$total_misc_bal+$buy->property->misc[$misc_count-1]->balance;
                $total_equity_pen=$total_equity_pen+$buy->property->equity[$equity_count-2]->penalty;
                $total_misc_pen=$total_misc_pen+$buy->property->misc[$misc_count-2]->penalty;
                    array_push($status,$buy->paymentscheme->paymentname);
                    array_push($client,$buy->client->firstname." ".$buy->client->lastname);
                    array_push($property,"Block: ".$buy->property->block." Lot: ".$buy->property->lot);
                    array_push($tcp,"Php. ".number_format($buy->tcp,2));
                    array_push($equity_bal,"Php. ".number_format($buy->property->equity[$equity_count-1]->balance,2));
                    array_push($misc_bal,"Php. ".number_format($buy->property->misc[$misc_count-1]->balance,2));
                  if($misc_count<=1){
                  array_push($misc_pen,"Php. ".number_format('0',2));
             }else{
                 array_push($misc_pen,"Php. ".number_format($buy->property->misc[$misc_count-2]->penalty,2));
             }
               
             if($equity_count<=1){
                 array_push($equity_pen,"Php. ".number_format('0',2));
             }else{
                 array_push($equity_pen,"Php. ".number_format($buy->property->equity[$equity_count-2]->penalty,2));
             } 
                }
              
               


            }
        }else if($filtered=="FIRST NAME"){
            $buys = Buy::orderBy('id','desc')->get();
            $count= count($buys);  
            $client=array();
            $property=array();
            $tcp=array();
          
            $status=array();
            $equity_bal=array();
            $misc_bal=array();
            $equity_pen=array();
            $misc_pen=array();
         
            foreach ($buys as $key => $buy) {
                $misc_count = count($buy->property->misc);
                $equity_count = count($buy->property->equity);
                if(strtoupper($search)==strtoupper($buy->client->firstname)){
                       $total_tcp=$total_tcp+$buy->tcp;
                $total_equity_bal=$total_equity_bal+$buy->property->equity[$equity_count-1]->balance;
                $total_misc_bal=$total_misc_bal+$buy->property->misc[$misc_count-1]->balance;
                $total_equity_pen=$total_equity_pen+$buy->property->equity[$equity_count-2]->penalty;
                $total_misc_pen=$total_misc_pen+$buy->property->misc[$misc_count-2]->penalty;
                    array_push($status,$buy->paymentscheme->paymentname);
                    array_push($client,$buy->client->firstname." ".$buy->client->lastname);
                    array_push($property,"Block: ".$buy->property->block." Lot: ".$buy->property->lot);
                    array_push($tcp,"Php. ".number_format($buy->tcp,2));
                    array_push($equity_bal,"Php. ".number_format($buy->property->equity[$equity_count-1]->balance,2));
                    array_push($misc_bal,"Php. ".number_format($buy->property->misc[$misc_count-1]->balance,2));
                   if($misc_count<=1){
                  array_push($misc_pen,"Php. ".number_format('0',2));
             }else{
                 array_push($misc_pen,"Php. ".number_format($buy->property->misc[$misc_count-2]->penalty,2));
             }
               
             if($equity_count<=1){
                 array_push($equity_pen,"Php. ".number_format('0',2));
             }else{
                 array_push($equity_pen,"Php. ".number_format($buy->property->equity[$equity_count-2]->penalty,2));
             } 
                }
              
            }
        }else if($filtered=="PAYMENT SCHEME"){
            $buys = Buy::orderBy('id','desc')->get();
            $count= count($buys);  
            $client=array();
            $property=array();
            $tcp=array();
          
            $status=array();
            $equity_bal=array();
            $misc_bal=array();
            $equity_pen=array();
            $misc_pen=array();
         
            foreach ($buys as $key => $buy) {
                $misc_count = count($buy->property->misc);
                $equity_count = count($buy->property->equity);
                if(strtoupper($search)==strtoupper($buy->paymentscheme->paymentname)){
                       $total_tcp=$total_tcp+$buy->tcp;
                $total_equity_bal=$total_equity_bal+$buy->property->equity[$equity_count-1]->balance;
                $total_misc_bal=$total_misc_bal+$buy->property->misc[$misc_count-1]->balance;
                $total_equity_pen=$total_equity_pen+$buy->property->equity[$equity_count-2]->penalty;
                $total_misc_pen=$total_misc_pen+$buy->property->misc[$misc_count-2]->penalty;
                    array_push($status,$buy->paymentscheme->paymentname);
                    array_push($client,$buy->client->firstname." ".$buy->client->lastname);
                    array_push($property,"Block: ".$buy->property->block." Lot: ".$buy->property->lot);
                    array_push($tcp,"Php. ".number_format($buy->tcp,2));
                    array_push($equity_bal,"Php. ".number_format($buy->property->equity[$equity_count-1]->balance,2));
                    array_push($misc_bal,"Php. ".number_format($buy->property->misc[$misc_count-1]->balance,2));
                if($misc_count<=1){
                  array_push($misc_pen,"Php. ".number_format('0',2));
             }else{
                 array_push($misc_pen,"Php. ".number_format($buy->property->misc[$misc_count-2]->penalty,2));
             }
               
             if($equity_count<=1){
                 array_push($equity_pen,"Php. ".number_format('0',2));
             }else{
                 array_push($equity_pen,"Php. ".number_format($buy->property->equity[$equity_count-2]->penalty,2));
             } 
                }
              
               


            }
        }

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
        $this->fpdf->Cell(250,7,"List of Clients (Payment Scheme)",0,0,'C');
        $this->fpdf->SetFont('Arial','',8);
        $this->fpdf->Cell(28,7,$today,0,0,'R');

        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->Cell(11.16,7,"#",1,0,'C');
        $this->fpdf->Cell(40.8,7,"CLIENT NAME",1,0,'C');
        $this->fpdf->Cell(27.9,7,"PROPERTY",1,0,'C');
        $this->fpdf->Cell(33.48,7,"TCP",1,0,'C');
        $this->fpdf->Cell(33.48,7,"EQ BAL",1,0,'C');
        $this->fpdf->Cell(33.48,7,"MF BAL",1,0,'C');
        $this->fpdf->Cell(27.9,7,"EQ PENALTY",1,0,'C');
        $this->fpdf->Cell(27.9,7,"MF PENALTY",1,0,'C');
        $this->fpdf->Cell(42.9,7,"PAYMENT SCHEME",1,0,'C');

         $this->fpdf->SetFont('Arial','',8);
        foreach ($client as $key => $cl) {
            $this->fpdf->Cell(0,7,'',0,1);
            $this->fpdf->Cell(11.16,7,$key+1,1,0,'C');
            $this->fpdf->Cell(40.8,7,$cl,1,0,'C');
            $this->fpdf->Cell(27.9,7,$property[$key],1,0,'C');
            $this->fpdf->Cell(33.48,7,$tcp[$key],1,0,'R');
            $this->fpdf->Cell(33.48,7,$equity_bal[$key],1,0,'R');
            $this->fpdf->Cell(33.48,7,$misc_bal[$key],1,0,'R');
            $this->fpdf->Cell(27.9,7,$equity_pen[$key],1,0,'R');
            $this->fpdf->Cell(27.9,7,$misc_pen[$key],1,0,'R');
            $this->fpdf->Cell(42.9,7,$status[$key],1,0,'C');
        }
            $this->fpdf->Cell(0,7,'',0,1);
            $this->fpdf->Cell(80,7,'Total',0,0,'R');
            $this->fpdf->Cell(33.48,7,'Php. '.number_format($total_tcp,2),0,0,'R');
            $this->fpdf->Cell(33.48,7,'Php. '.number_format($total_equity_bal,2),0,0,'R');
            $this->fpdf->Cell(33.48,7,'Php. '.number_format($total_misc_bal,2),0,0,'R');
            $this->fpdf->Cell(27.9,7,'Php. '.number_format($total_equity_pen,2),0,0,'R');
            $this->fpdf->Cell(27.9,7,'Php. '.number_format($total_misc_pen,2),0,0,'R');
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
