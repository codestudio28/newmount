<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Client;
use App\Property;
use App\Buy;
use App\Misc;
use App\Equity;
use App\Voucher;
use App\Payee;
use Codedge\Fpdf\Fpdf\Fpdf;
class ReportPayableController extends Controller
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
        $filters = array("ALL", "PAYEE", "BANK","CV");
        $display = array("1", "5", "10", "50", "100", "500");

        $vouchers = Voucher::where("status",'APPROVED')->orderBy('id','desc')->take($records)->get();
        $count= count($vouchers);
        return view('report.payable')
         ->with('vouchers',$vouchers)
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

        $datefrom =date(session('datefrom'));
        $dateto =date(session('dateto'));
        $filtered = session('filtered');
        $records = session('records');
        $search = session('search');
        $filters = array("ALL", "PAYEE", "BANK","CV");
        $display = array("1", "5", "10", "50", "100", "500");
     
     
        if($filtered=="ALL"){
            $vouchers = Voucher::where("status",'APPROVED')->whereBetween('dates',[$datefrom, $dateto])->orderBy('id','desc')->take($records)->get();
            $count= count($vouchers);
        }else if($filtered=="PAYEE"){
            $payee = Payee::where('payee_name', $search)->get();
            $payee_id = $payee[0]->id;
            $vouchers = Voucher::where("payee_id",$payee_id)->whereBetween('dates',[$datefrom, $dateto])->where("status",'APPROVED')->orderBy('id','desc')->take($records)->get();
            $count= count($vouchers);
        }else if($filtered=="BANK"){
            $vouchers = Voucher::where("bank",$search)->whereBetween('dates',[$datefrom, $dateto])->where("status",'APPROVED')->orderBy('id','desc')->take($records)->get();
            $count= count($vouchers);
        }else if($filtered=="CV"){
            $vouchers = Voucher::where("cv",$search)->whereBetween('dates',[$datefrom, $dateto])->where("status",'APPROVED')->orderBy('id','desc')->take($records)->get();
            $count= count($vouchers);
        }

          return view('report.payable')
         ->with('vouchers',$vouchers)
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
         $datefrom =date(session('datefrom'));
        $dateto =date(session('dateto'));
        $filtered = session('filtered');
        $records = session('records');
        $search = session('search');
        $filters = array("ALL", "PAYEE", "BANK","CV");
        $display = array("1", "5", "10", "50", "100", "500");
     
     
        if($filtered=="ALL"){
            $vouchers = Voucher::where("status",'APPROVED')->whereBetween('dates',[$datefrom, $dateto])->orderBy('id','desc')->take($records)->get();
            $count= count($vouchers);
        }else if($filtered=="PAYEE"){
            $payee = Payee::where('payee_name', $search)->get();
            $payee_id = $payee[0]->id;
            $vouchers = Voucher::where("payee_id",$payee_id)->whereBetween('dates',[$datefrom, $dateto])->where("status",'APPROVED')->orderBy('id','desc')->take($records)->get();
            $count= count($vouchers);
        }else if($filtered=="BANK"){
            $vouchers = Voucher::where("bank",$search)->whereBetween('dates',[$datefrom, $dateto])->where("status",'APPROVED')->orderBy('id','desc')->take($records)->get();
            $count= count($vouchers);
        }else if($filtered=="CV"){
            $vouchers = Voucher::where("cv",$search)->whereBetween('dates',[$datefrom, $dateto])->where("status",'APPROVED')->orderBy('id','desc')->take($records)->get();
            $count= count($vouchers);
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
        $this->fpdf->Cell(250,7,"List of Account Payables",0,0,'C');
        $this->fpdf->SetFont('Arial','',8);
        $this->fpdf->Cell(28,7,$today,0,0,'R');

        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->Cell(11.16,7,"#",1,0,'C');
        $this->fpdf->Cell(20,7,"Date",1,0,'C');
        $this->fpdf->Cell(30.8,7,"Payee",1,0,'C');
        $this->fpdf->Cell(32.9,7,"C.V. #",1,0,'C');
        $this->fpdf->Cell(33.48,7,"BANK",1,0,'C');
        $this->fpdf->Cell(33.48,7,"TERMS",1,0,'C');
        $this->fpdf->Cell(36.9,7,"CHEQUE # ",1,0,'C');
        $this->fpdf->Cell(37,7,"PREPARED BY",1,0,'C');
        $this->fpdf->Cell(37,7,"AMOUNT",1,0,'C');

         $this->fpdf->SetFont('Arial','',8);
         $total=0;
       foreach ($vouchers as $key => $voucher) {
            $this->fpdf->Cell(0,7,'',0,1);
            $this->fpdf->Cell(11.16,7,$key+1,1,0,'C');
            $this->fpdf->Cell(20,7,$voucher->dates,1,0,'C');
            if(strlen($voucher->payee->payee_name)>=20){
                 $this->fpdf->Cell(30.8,7,substr($voucher->payee->payee_name,0,20).'...',1,0,'C');
            }else{
                 $this->fpdf->Cell(30.8,7,$voucher->payee->payee_name,1,0,'C');
            }
           
            $this->fpdf->Cell(32.9,7,$voucher->cv,1,0,'C');
            $this->fpdf->Cell(33.48,7,$voucher->bank,1,0,'C');
            $this->fpdf->Cell(33.48,7,$voucher->terms,1,0,'C');
            $this->fpdf->Cell(36.9,7,$voucher->cheque,1,0,'C');
            $this->fpdf->Cell(37,7,$voucher->prepared->firstname." ".$voucher->prepared->lastname,1,0,'C');
            $this->fpdf->Cell(37,7,'Php. '.number_format($voucher->amount,2),1,0,'R');
            $total = $total+$voucher->amount;
       }    
            $this->fpdf->Cell(0,7,'',0,1);
            $this->fpdf->Cell(235.7,7,'Total',0,0,'R');
            $this->fpdf->Cell(37,7,'Php. '.number_format($total,2),1,0,'R');
            

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
