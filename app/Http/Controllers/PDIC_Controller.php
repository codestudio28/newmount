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
use Excel;
class PDIC_Controller extends Controller
{
      private $fpdf;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         date_default_timezone_set("Asia/Manila");
            $year =date('Y');
            $month=date('m');
            $day=date('d');
        $today=$year."-".$month."-".$day;

        $totalrecords = session('totalrecords');
        if(strlen($totalrecords)<=0){
            session()->put('totalrecords',0);
          
        }
        $startrecords = session('startrecords');
        if(strlen($startrecords)<=0){
            session()->put('startrecords',1);
          
        }
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
         $sdatefrom = session('datefrom');
        if(strlen($sdatefrom)<=0){
            session()->put('datefrom',$today);
          
        }
        $sdateto = session('dateto');
        if(strlen($sdateto)<=0){
            session()->put('dateto',$today);
          
        }

        $datefrom =session('datefrom');
        $dateto =session('dateto');
        $filtered = session('filtered');
        $records = session('records');
        $search = session('search');
        $filters = array("ALL", "LAST NAME", "FIRST NAME", "BLOCK","LOT");
        $display = array("1", "5", "10", "50", "100", "500");

      
        $equities = Equity::where("status",'PAID')->orderBy('id','desc')->take($records)->get();
        $count1= count($equities);
        $client_misc=array();
        $client_equity=array();
        $prop_misc=array();
        $prop_equity=array();
        $equity_block=array();
        $equity_lot=array();
        $misc_block=array();
        $misc_lot=array();
        $tcp=array();
        $status=array();
        $equity_payment=array();
        $equity_date=array();
        $misc_date=array();
         $equity_due=array();
        $misc_due=array();
        $misc_payment=array();
        $equity_date=array();
        $equity_payment=array();
        $equity_pen=array();
        $misc_pen=array();
        $misc_pay=array();
        $equity_pay=array();
        $m=0;
        $e=0;
        $buys = Buy::where("status",'ACTIVE')->orderBy('id','desc')->take($records)->get();
        $miscs = Misc::where("status",'PAID')->orderBy('id','desc')->take($records)->get();
        $count= count($miscs);
        

      
          return view('report.pdic')
        ->with('buys',$buys)
        ->with('miscs',$miscs)
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         date_default_timezone_set("Asia/Manila");
            $year =date('Y');
            $month=date('m');
            $day=date('d');
        $today=$year."-".$month."-".$day;
        $filtered = $request->input('filter');
        $records = $request->input('records');
        $search = $request->input('search');
        $datefrom = $request->input('date_from');
        $dateto = $request->input('date_to');

        session()->put('filtered',$filtered);
        session()->put('records',$records);
        session()->put('search',$search);
        session()->put('datefrom',$datefrom);
        session()->put('dateto',$dateto);

        $filtered = session('filtered');
        $records = session('records');
        $search = session('search');
        $filters = array("ALL", "LAST NAME", "FIRST NAME", "BLOCK","LOT");
        $display = array("1", "5", "10", "50", "100", "500");
         date_default_timezone_set("Asia/Manila");
            $year =date('Y');
            $month=date('m');
            $day=date('d');
        $today=$year."-".$month."-".$day;

        $totalrecords = session('totalrecords');
       

        $datefrom =session('datefrom');
        $dateto =session('dateto');
        $filtered = session('filtered');
        $records = session('records');
        $search = session('search');
        $filters = array("ALL", "LAST NAME", "FIRST NAME", "BLOCK","LOT");
        $display = array("1", "5", "10", "50", "100", "500");

      
        $equities = Equity::where("status",'PAID')->orderBy('id','desc')->take($records)->get();
        $count1= count($equities);
        $client_misc=array();
        $client_equity=array();
        $prop_misc=array();
        $prop_equity=array();
        $equity_block=array();
        $equity_lot=array();
        $misc_block=array();
        $misc_lot=array();
        $tcp=array();
        $status=array();
        $equity_payment=array();
        $equity_date=array();
        $misc_date=array();
         $equity_due=array();
        $misc_due=array();
        $misc_payment=array();
        $equity_date=array();
        $equity_payment=array();
        $equity_pen=array();
        $misc_pen=array();
        $misc_pay=array();
        $equity_pay=array();
        $m=0;
        $e=0;

        if($filtered=="ALL"){
              $buys = Buy::where("status",'ACTIVE')->orderBy('id','desc')->take($records)->get();
        }else if ($filtered=="LAST NAME"){
              $buys = Buy::where("status",'ACTIVE')->orderBy('id','desc')->take($records)->get();
        }else if ($filtered=="FIRST NAME"){
              $buys = Buy::where("status",'ACTIVE')->orderBy('id','desc')->take($records)->get();
        }

      
     
        

          return view('report.pdic')
        ->with('buys',$buys)
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
        date_default_timezone_set("Asia/Manila");
            $year =date('Y');
            $month=date('m');
            $day=date('d');
        $today=$year."-".$month."-".$day;

        $totalrecords = session('totalrecords');
        if(strlen($totalrecords)<=0){
            session()->put('totalrecords',0);
          
        }
        $startrecords = session('startrecords');
        if(strlen($startrecords)<=0){
            session()->put('startrecords',1);
          
        }
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
         $sdatefrom = session('datefrom');
        if(strlen($sdatefrom)<=0){
            session()->put('datefrom',$today);
          
        }
        $sdateto = session('dateto');
        if(strlen($sdateto)<=0){
            session()->put('dateto',$today);
          
        }

        $datefrom =session('datefrom');
        $dateto =session('dateto');
        $filtered = session('filtered');
        $records = session('records');
        $search = session('search');
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
        $this->fpdf->AddPage('L','Legal');
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
        $this->fpdf->Cell(250,7,"PDIC Reports",0,0,'C');
        $this->fpdf->SetFont('Arial','',8);
        $this->fpdf->Cell(28,7,$today,0,0,'R');

        $this->fpdf->SetFont('Arial','',8);
        $this->fpdf->Cell(0,10,'',0,1);
        // 337
        $this->fpdf->Cell(10,7,"#",1,0,'C');
        $this->fpdf->Cell(45,7,"Client Name",1,0,'C');
        $this->fpdf->Cell(30,7,"Block and Lot",1,0,'C');
        $this->fpdf->Cell(20,7,"CTS",1,0,'C');
            $this->fpdf->Cell(25,7,"Type",1,0,'C');
            $this->fpdf->Cell(30,7,"TCP",1,0,'C');
            $this->fpdf->Cell(30,7,"MF",1,0,'C');
            $this->fpdf->Cell(30,7,"EQUITY",1,0,'C');
            $this->fpdf->Cell(30,7,"MF PAYMENT",1,0,'C');
            $this->fpdf->Cell(30,7,"EQUITY PAYMENT",1,0,'C');
            $this->fpdf->Cell(30,7,"BALANCE MF",1,0,'C');
            $this->fpdf->Cell(30,7,"BALANCE EQUITY",1,0,'C');

        $buys = Buy::where("status",'ACTIVE')->orderBy('id','desc')->take($records)->get();
         $this->fpdf->SetFont('Arial','',7);
         $totaltcp=0;
         $totalmf=0;
         $totaleq=0;
         $totalpaymentmf=0;
         $totalpaymenteq=0;
          $totalbalancemf=0;
         $totalbalanceeq=0;
        foreach ($buys as $key => $buy) {
            $totalmisc=0;
            $totalequity=0;
             $this->fpdf->Cell(0,7,'',0,1);
            // 337
            $this->fpdf->Cell(10,7,$key+1,1,0,'C');
            $this->fpdf->Cell(45,7,$buy->client->firstname.' '.$buy->client->lastname,1,0,'C');
            $this->fpdf->Cell(30,7,'Block: '.$buy->property->block.' Lot: '.$buy->property->lot,1,0,'C');
            $this->fpdf->Cell(20,7,$buy->cts,1,0,'C');
            $this->fpdf->Cell(25,7,$buy->property->proptype->typename,1,0,'C');
            $this->fpdf->Cell(30,7,'Php. '.number_format($buy->tcp,2),1,0,'R');
            $this->fpdf->Cell(30,7,'Php. '.number_format($buy->totalmisc,2),1,0,'R');
            $this->fpdf->Cell(30,7,'Php. '.number_format($buy->totalequity,2),1,0,'R');

            foreach ($buy->client->misc as $key => $mic) {
                 if(($buy->client_id==$mic->client_id)&&($buy->property_id==$mic->property_id)){
                      if($mic->payment!=""){
                    $totalmisc=$totalmisc+$mic->payment;
                    }    
                 }
              
            }

            foreach ($buy->client->equity as $key => $eq) {
                 if(($buy->client_id==$eq->client_id)&&($buy->property_id==$eq->property_id)){
                     if($eq->payment!=""){
                        $totalequity=$totalequity+$eq->payment;
                    }
                 }
               
            }
            $mfbalance = $buy->totalmisc - $totalmisc;
            $eqbalance = $buy->totalequity - $totalequity;
            $this->fpdf->Cell(30,7,'Php. '.number_format($totalmisc,2),1,0,'R');
            $this->fpdf->Cell(30,7,'Php. '.number_format($totalequity,2),1,0,'R');
            $this->fpdf->Cell(30,7,'Php. '.number_format($mfbalance,2),1,0,'R');
            $this->fpdf->Cell(30,7,'Php. '.number_format($eqbalance,2),1,0,'R');

            $totaltcp = $totaltcp+$buy->tcp;
            $totalmf = $totalmf+$buy->totalmisc;
            $totaleq = $totaleq+$buy->totalequity;
            $totalpaymentmf=$totalpaymentmf+$totalmisc;
            $totalpaymenteq=$totalpaymenteq+$totalequity;
            $totalbalancemf=$totalbalancemf+$mfbalance;
            $totalbalanceeq=$totalbalanceeq+$eqbalance;
        }

              $this->fpdf->Cell(0,7,'',0,1);
            $this->fpdf->Cell(130,7,'TOTAL',0,0,'R');
            $this->fpdf->Cell(30,7,'Php. '.number_format($totaltcp,2),1,0,'R');
            $this->fpdf->Cell(30,7,'Php. '.number_format($totalmf,2),1,0,'R');
            $this->fpdf->Cell(30,7,'Php. '.number_format($totaleq,2),1,0,'R');
            $this->fpdf->Cell(30,7,'Php. '.number_format($totalpaymentmf,2),1,0,'R');
            $this->fpdf->Cell(30,7,'Php. '.number_format($totalpaymenteq,2),1,0,'R');
            $this->fpdf->Cell(30,7,'Php. '.number_format($totalbalancemf,2),1,0,'R');
            $this->fpdf->Cell(30,7,'Php. '.number_format($totalbalanceeq,2),1,0,'R');

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
        date_default_timezone_set("Asia/Manila");
            $year =date('Y');
            $month=date('m');
            $day=date('d');
        $today=$year."-".$month."-".$day;

        $totalrecords = session('totalrecords');
        if(strlen($totalrecords)<=0){
            session()->put('totalrecords',0);
          
        }
        $startrecords = session('startrecords');
        if(strlen($startrecords)<=0){
            session()->put('startrecords',1);
          
        }
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
         $sdatefrom = session('datefrom');
        if(strlen($sdatefrom)<=0){
            session()->put('datefrom',$today);
          
        }
        $sdateto = session('dateto');
        if(strlen($sdateto)<=0){
            session()->put('dateto',$today);
          
        }

        $datefrom =session('datefrom');
        $dateto =session('dateto');
        $filtered = session('filtered');
        $records = session('records');
        $search = session('search');
           date_default_timezone_set("Asia/Manila");
        $year =date('Y');
        $month=date('m');
        $day=date('d');
        $hour=date('G');
        $min=date('i');
        $sec=date('s');

        $dates=$year."-".$month."-".$day;
        $times=$hour.":".$min.":".$sec;
         $buys = Buy::where("status",'ACTIVE')->orderBy('id','desc')->take($records)->get();
         
         // $pdic_array[]=array('#','Client Name','Block and Lot','CTS','Type','TCP','MF','Equity','MF Payment','Equity Payment','Unpaid MF','Unpaid Equity','Balance MF','Balance Equity');

          $pdic_array[]=array('No','Client Name','Block','Lot','CTS','Type','TCP','MF','Equity','MF Payment','Equity Payment','MF Unpaid','Equity Unpaid','MF Penalty','Equity Penalty','MF Balance','Equity Balance');

        $count=1;
         foreach ($buys as $key => $buy) {
            $totalmisc=0;
            $unpaidmisc=0;
            
            $misc_penalty=0;
            $equity_penalty=0;

            $client_id = $buy->client_id;
            $property_id=$buy->property_id;

            $miscpen = Misc::where('property_id',$property_id)->where('client_id',$client_id)->orderBy('date','ASC')->get();
            $misccount = count($miscpen);

            if($misccount>1){
                $misc_penalty=$miscpen[$misccount-2]->penalty;
            }else{
                $misc_penalty=0;
            }
          
            $eqpen = Equity::where('property_id',$property_id)->where('client_id',$client_id)->orderBy('date','ASC')->get();
            $eqcount = count($eqpen);

             if($eqcount>1){
                $equity_penalty=$eqpen[$eqcount-2]->penalty;
            }else{
               $equity_penalty=0;
            }

            foreach ($buy->client->misc as $key => $mic) {
                if(($buy->client_id==$mic->client_id)&&($buy->property_id==$mic->property_id)){
                       if($mic->payment!=""){
                            $totalmisc=$totalmisc+$mic->payment;
                        }

                        if($mic->status=='UNPAID'){
                            $unpaidmisc=$unpaidmisc+$mic->misc_fee;
                        }
                }
             
            }
             $totalequity=0;
              $unpaidequity=0;
            foreach ($buy->client->equity as $key => $eq) {
                if(($buy->client_id==$eq->client_id)&&($buy->property_id==$eq->property_id)){
                     if($eq->payment!=""){
                        $totalequity=$totalequity+$eq->payment;
                    }
                    if($eq->status=='UNPAID'){
                            $unpaidequity=$unpaidequity+$eq->equity_fee;
                    }
                }
               
            }

            $mfbalance = $buy->totalmisc - $totalmisc;
            $eqbalance = $buy->totalequity - $totalequity;

             $pdic_array[]=array(
                'No' => $count,
                'Client Name' => $buy->client->firstname.''.$buy->client->lastname,
                'Block'=> $buy->property->block,
                'Lot'=>$buy->property->lot,
                'CTS' => $buy->cts,
                'Type' => $buy->property->proptype->typename,
                'TCP' => $buy->tcp,
                'MF' => $buy->totalmisc,
                'Equity' => $buy->totalequity,
                'MF Payment' => $totalmisc,
                'Equity Payment' => $totalequity,
                'MF Unpaid' => $unpaidmisc,
                'Equity Unpaid' => $unpaidequity,
                'MF Penalty' => $misc_penalty,
                'Equity Penalty' => $equity_penalty,
                'MF Balance' => $mfbalance,
                'Equity Balance' => $eqbalance,
              
             );
               $count++;    
         }

         Excel::create('PDIC Reports', function($excel) use ($pdic_array){
            $excel->setTitle('PDIC Report');
            $excel->sheet('PDIC Report', function($sheet) use ($pdic_array){
                $sheet->fromArray($pdic_array,null,'A1',false,false);
            });
         })->download('xlsx');
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
