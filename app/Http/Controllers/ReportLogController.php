<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Log;
use Codedge\Fpdf\Fpdf\Fpdf;
class ReportLogController extends Controller
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
        $datefrom =date(session('datefrom').' 00:00:00');
        $dateto =date(session('dateto').' 00:00:00');
        $filtered = session('filtered');
        $records = session('records');
        $search = session('search');
        $filters = array("ALL", "LAST NAME", "FIRST NAME");
        $display = array("1", "5", "10", "50", "100", "500");


        $logs = Log::whereBetween('created_at',[$datefrom, $dateto])->orderBy('id','desc')->take($records)->get();

       
        return view('report.log')
        ->with('logs',$logs)
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
         date_default_timezone_set("Asia/Manila");
            $year =date('Y');
            $month=date('m');
            $day=date('d');
        $today=$year."-".$month."-".$day;
        $records = $request->input('records');
        $datefrom = date($request->input('date_from').' 00:00:00');
        $dateto = date($request->input('date_to').' 00:00:00');

     
        session()->put('records',$records);
  
        session()->put('datefrom',$datefrom);
        session()->put('dateto',$dateto);

     
        $records = session('records');
         $filters = array("ALL", "LAST NAME", "FIRST NAME");
        $display = array("1", "5", "10", "50", "100", "500");

        $logs = Log::whereBetween('created_at',[$datefrom, $dateto])->orderBy('id','desc')->take($records)->get();

          return view('report.log')
          ->with('logs',$logs)
         ->with('records',$records)
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
       $datefrom =date(session('datefrom'));
        $dateto =date(session('dateto'));
        $records = session('records');

          $filters = array("ALL", "PAYEE", "BANK","CV");
        $display = array("1", "5", "10", "50", "100", "500");
      
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

       

         $logs = Log::whereBetween('created_at',[$datefrom, $dateto])->orderBy('id','desc')->take($records)->get();


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
        $this->fpdf->Cell(250,7,"Administrator Log",0,0,'C');
        $this->fpdf->SetFont('Arial','',8);
        $this->fpdf->Cell(28,7,$today,0,0,'R');

        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->Cell(11.16,7,"#",1,0,'C');
        $this->fpdf->Cell(40,7,"Date",1,0,'C');
        $this->fpdf->Cell(70,7,"Admin",1,0,'C');
        $this->fpdf->Cell(74,7,"Module",1,0,'C');
        $this->fpdf->Cell(85.9,7,"Description",1,0,'C');
      
         $this->fpdf->SetFont('Arial','',8);
         $total_payment=0;
         $total_penalty=0;
         $total_balance=0;
        foreach ($logs as $key => $log) {
            $this->fpdf->Cell(0,7,'',0,1);
            $this->fpdf->Cell(11.16,7,$key+1,1,0,'C');
            $this->fpdf->Cell(40,7,$log->created_at,1,0,'C');
            $this->fpdf->Cell(70,7,$log->admin->firstname.' '.$log->admin->lastname,1,0,'C');
            $this->fpdf->Cell(74,7,$log->module,1,0,'C');
            $this->fpdf->Cell(85.9,7,$log->description,1,0,'C');
            
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
