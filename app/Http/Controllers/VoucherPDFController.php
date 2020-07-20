<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Voucher;
use App\Admin;

class VoucherPDFController extends Controller
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
        $logo = url('logo/logo.png');
        $voucher = Voucher::find($id);
        $app_id =  $voucher->prepared_admin_id;
        $app = Admin::find($app_id);
        $prepared = $app->firstname." ".$app->lastname;
        $superid = $voucher->approved_admin_id;
        $noteid =  $voucher->noted_admin_id;
        $note = Admin::find($noteid);
        $noted = $note->firstname." ".$note->lastname;
        $supername = Admin::find($superid);
        $approved = $supername->firstname." ".$supername->lastname;
        
       
        $amount_word = strtoupper($this->convert_number_to_word($voucher->amount));
      

        $this->fpdf = new Fpdf;
        $this->fpdf->AddPage();
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
        $this->fpdf->Cell(180,5,"Cash / Check Voucher",0,0,'C');
        $this->fpdf->SetFont('Arial','',12);
        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->Cell(35,5,"Payee: ",0,0,'L');
        $this->fpdf->Cell(60,5,$voucher->payee->payee_name,0,0,'L');
         $this->fpdf->Cell(0,7,'',0,1);
        $this->fpdf->Cell(35,5,"Date: ",0,0,'L');
        $this->fpdf->Cell(60,5,$voucher->dates,0,0,'L');
        $this->fpdf->Cell(0,7,'',0,1);
        $this->fpdf->Cell(35,5,"Amount: ",0,0,'L');
        $this->fpdf->Cell(60,5,'Php. '.number_format($voucher->amount, 2),0,0,'L');
        $this->fpdf->Cell(35,5,"C.V.#: ",0,0,'L');
        $this->fpdf->Cell(60,5,$voucher->cv,0,0,'L');
        $this->fpdf->Cell(0,7,'',0,1);
        $this->fpdf->Cell(35,5,"Bank: ",0,0,'L');
        $this->fpdf->Cell(60,5,$voucher->bank,0,0,'L');
        $this->fpdf->Cell(35,5,"Cheque #: ",0,0,'L');
        $this->fpdf->Cell(60,5,$voucher->cheque,0,0,'L');
        $this->fpdf->Cell(0,7,'',0,1);
        $this->fpdf->Cell(35,5,"Terms: ",0,0,'L');
        $this->fpdf->Cell(60,5,$voucher->terms,0,0,'L');
        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->Cell(35,5,"Amount in Words: ",0,0,'L');
        $this->fpdf->MultiCell(155,5,'*** '.$amount_word.' ONLY ***');
        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->Cell(35,5,"Explanation: ",0,0,'L');

       
        $this->fpdf->Cell(0,7,'',0,1);
        $this->fpdf->Cell(35,5,"",0,0,'L');
        $this->fpdf->Cell(60,5,$voucher->summary,0,0,'L');
        
       
        $this->fpdf->Cell(0,15,'',0,1);
        $this->fpdf->Cell(70,5,"GL Account ",0,0,'C');
        $this->fpdf->Cell(60,5,"DEBIT ",0,0,'C');
        $this->fpdf->Cell(60,5,"CREDIT ",0,0,'C');

        foreach($voucher->explain as $key=>$expl){
        $this->fpdf->Cell(0,5,'',0,1);
        $this->fpdf->Cell(70,5,$expl->explain,0,0,'C');
        $this->fpdf->Cell(60,5,'Php. '.number_format($expl->amount,2),0,0,'C');
        $this->fpdf->Cell(60,5,"",0,0,'C');
       }
      
        $this->fpdf->Cell(0,5,'',0,1);
        $this->fpdf->Cell(70,5,$voucher->bank,0,0,'C');
        $this->fpdf->Cell(60,5,"",0,0,'C');
        $this->fpdf->Cell(60,5,'Php. '.number_format($voucher->amount,2),0,0,'C');
        $this->fpdf->Cell(0,15,'',0,1);
        $this->fpdf->Cell(70,5,"Prepared By",0,0,'C');
        $this->fpdf->Cell(60,5,"Noted By",0,0,'C');
        $this->fpdf->Cell(60,5,"Approved By",0,0,'C');
        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->Cell(70,5,$prepared,0,0,'C');
        $this->fpdf->Cell(60,5,$noted,0,0,'C');
        $this->fpdf->Cell(60,5,$approved,0,0,'C');
        $this->fpdf->Output();

    }

    public function convert_number_to_word($number) {
        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';

         $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }
     if ($number < 0) {
        return $negative . $this->convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . $this->convert_number_to_word($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = $this->convert_number_to_word($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= $this->convert_number_to_word($remainder);
            }
            break;
    }
     if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
        
        
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
