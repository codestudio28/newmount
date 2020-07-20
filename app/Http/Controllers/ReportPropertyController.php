<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Property;
use App\PropertyType;
use Codedge\Fpdf\Fpdf\Fpdf;
class ReportPropertyController extends Controller
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

        $filters = array("ALL", "BLOCK", "LOT", "TYPE", "AREA", "STATUS");
        $display = array("1", "5", "10", "50", "100", "500");
        $properties = Property::orderBy('id','desc')->paginate($records);
       return view('report.property')->with('properties',$properties)->with('filtered',$filtered)->with('records',$records)->with('search',$search)->with('filters',$filters)->with('display',$display);
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

        $filters = array("ALL", "BLOCK", "LOT", "TYPE", "AREA", "STATUS");
        $display = array("1", "5", "10", "50", "100", "500");
        if($filtered=="ALL"){
            session()->put('records','10');
            session()->put('search','');
            $records = session('records');
            $search = session('search');

             $filters = array("ALL", "BLOCK", "LOT", "TYPE", "AREA", "STATUS");
            $display = array("1", "5", "10", "50", "100", "500");
            $properties = Property::orderBy('id','desc')->paginate($records);
         
        }else if($filtered=="BLOCK"){
            $properties = Property::where('block',$search)->orderBy('id','desc')->paginate($records);
        }else if($filtered=="LOT"){
            $properties = Property::where('lot',$search)->orderBy('id','desc')->paginate($records);
        }else if($filtered=="TYPE"){
            $proptype = PropertyType::where('description',$search)->first();
            if(strlen($proptype)>0){
                $properties = Property::where('proptype_id',$proptype->id)->orderBy('id','desc')->paginate($records);
            }else{
                 $properties = Property::where('proptype_id','0')->orderBy('id','desc')->paginate($records);
            }
           
        }else if($filtered=="AREA"){
            $properties = Property::where('area',$search)->orderBy('id','desc')->paginate($records);
        }else if($filtered=="STATUS"){
            if(strtoupper($search)=="AVAILABLE"){
                $search ="ACTIVE";
            }
            $properties = Property::where('status',strtoupper($search))->orderBy('id','desc')->paginate($records);
        }
          return view('report.property')->with('properties',$properties)->with('filtered',$filtered)->with('records',$records)->with('search',$search)->with('filters',$filters)->with('display',$display);
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
        if($filtered=="ALL"){
             $properties = Property::orderBy('id','desc')->get();
            
        }else{
             if(strlen($search)<=0){
            $properties = Property::orderBy('id','desc')->get();
            }else{
                if($filtered=="BLOCK"){
                    $properties = Property::where('block',$search)->orderBy('id','desc')->get();
                }else if($filtered=="LOT"){
                    $properties = Property::where('lot',$search)->orderBy('id','desc')->get();
                }else if($filtered=="TYPE"){
                    $proptype = PropertyType::where('description',$search)->first();
                        if(strlen($proptype)>0){
                            $properties = Property::where('proptype_id',$proptype->id)->orderBy('id','desc')->paginate($records);
                        }else{
                             $properties = Property::where('proptype_id','0')->orderBy('id','desc')->paginate($records);
                        }
                   
                }else if($filtered=="AREA"){
                    $properties = Property::where('area',$search)->orderBy('id','desc')->get();
                }else if($filtered=="STATUS"){
                    if(strtoupper($search)=="AVAILABLE"){
                        $search ="ACTIVE";
                    }
                    $properties = Property::where('status',strtoupper($search))->orderBy('id','desc')->paginate($records);
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
        $this->fpdf->Cell(250,7,"List of Properties",0,0,'C');
        $this->fpdf->SetFont('Arial','',8);
        $this->fpdf->Cell(28,7,$today,0,0,'R');

        $this->fpdf->SetFont('Arial','',13);
        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->Cell(13.9,7,"#",1,0,'C');
        $this->fpdf->Cell(27.9,7,"BLOCK",1,0,'C');
        $this->fpdf->Cell(27.9,7,"LOT",1,0,'C');
        $this->fpdf->Cell(41.85,7,"TYPE",1,0,'C');
        $this->fpdf->Cell(27.9,7,"AREA",1,0,'C');
        $this->fpdf->Cell(55.8,7,"TCP",1,0,'C');
        $this->fpdf->Cell(55.8,7,"MF",1,0,'C');
        $this->fpdf->Cell(27.9,7,"STATUS",1,0,'C');

        $this->fpdf->SetFont('Arial','',12);

        foreach($properties as $key=>$property){
            $this->fpdf->Cell(0,7,'',0,1);
            $this->fpdf->Cell(13.9,7,$key+1,1,0,'C');
            $this->fpdf->Cell(27.9,7,$property->block,1,0,'C');
            $this->fpdf->Cell(27.9,7,$property->lot,1,0,'C');
            $this->fpdf->Cell(41.85,7,$property->proptype->description,1,0,'C');
            $this->fpdf->Cell(27.9,7,$property->area,1,0,'C');
            $this->fpdf->Cell(55.8,7,'Php. '.number_format($property->price,2),1,0,'R');
            $this->fpdf->Cell(55.8,7,'Php. '.number_format(($property->price)*(($property->proptype->misc)/100),2),1,0,'R');
            if($property->status=="ACTIVE"){
                $this->fpdf->Cell(27.9,7,'AVAILABLE',1,0,'C');
            }else{
                $this->fpdf->Cell(27.9,7,$property->status,1,0,'C');
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
