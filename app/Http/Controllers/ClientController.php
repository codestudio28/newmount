<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Client;
use App\Log;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(strlen(session('Data'))<=0){
            return redirect('/');
        }else{
            $clients = Client::where('status','ACTIVE')->get();

          return view('client.index')->with('clients',$clients);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         if(strlen(session('Data'))<=0){
            return redirect('/');
        }else{
             return view('client.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         $this->validate($request,[
            'firstname'=>'required',
            'lastname'=>'required',
            'birthdate'=>'required',
            'address1'=>'required',
            'address2'=>'required',
            'city'=>'required',
            'zipcode'=>'required',
            'mobilenumber'=>'required',
            'emailadd'=>'required',
        ]);

       
            
             $client = Client::where('firstname',$request->input('firstname'))->where('lastname',$request->input('lastname'))->get();
             if(count($client)>0){
                 return redirect('/admin-client/create')->with('error','This client is already in the system.');
             }else{

             }
         
            $status="ACTIVE";
            $client = new Client;
            $client->firstname = $request->input('firstname');
            $client->middlename= $request->input('middlename');
            $client->lastname= $request->input('lastname');
            $client->contactnumber= $request->input('mobilenumber');
            $client->address1= $request->input('address1');
            $client->city= $request->input('city');
            $client->status= $status;
            $client->sales_rep= $request->input('sales_rep');
            $client->birthdate= $request->input('birthdate');
            $client->civilstatus= $request->input('civilstatus');
            $client->spouse= $request->input('spouse');
            $client->work= $request->input('spouse_work');
            $client->dependent= $request->input('dependent_study');
            $client->address2= $request->input('address2');
            $client->zipcode= $request->input('zipcode');
            $client->emailadd= $request->input('emailadd');
            $client->employementstatus= $request->input('employmentstatus');
            $client->employername= $request->input('employer');
            $client->naturebusiness= $request->input('nature');
            $client->officeaddress= $request->input('officeaddress');
            $client->officenumber= $request->input('officenumber');
            $client->position= $request->input('position');
            $client->basicsalary= $request->input('salary');
            $client->allowance= $request->input('allowance');
            $client->yearsemployed= $request->input('years');
            $client->othersource= $request->input('othersource');
            $client->living= $request->input('livingwith');
            $client->finance= $request->input('finance');
            $client->tin= $request->input('tin');
            $client->sss= $request->input('sss');
            $client->passport= $request->input('passport');
            $client->passportvalid= $request->input('passportvalid');
            $client->driver= $request->input('driver');
            $client->drivervalid= $request->input('drivervalid');
            $client->prc= $request->input('prc');
            $client->prcvalid= $request->input('prcvalid');
            $client->rental= $request->input('monthlyrental');
             $client->save();

      
        // $status="ACTIVE";
        // $client = new Client;
        // $client->firstname = $request->input('firstname');
        // $client->middlename = $request->input('middlename');
        // $client->lastname = $request->input('lastname');
        // $client->contactnumber = $request->input('contactnumber');
        // $client->address1 = $request->input('address1');
        // $client->barangay = $request->input('barangay');
        // $client->city = $request->input('city');
        // $client->province = $request->input('province');
        // $client->sales_rep = $request->input('sales_rep');
        // $client->status = $status;


          $admin_id=session('Data')[0]->id;

        $log = new Log;
         $log->admin_id=$admin_id;
        $log->module="Client";
        $log->description="Add client";
        $log->save();


        return redirect('/admin-client')->with('success','New client successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         if(strlen(session('Data'))<=0){
            return redirect('/');
        }else{
             $client = Client::find($id);
         return view('client.edit')->with('client',$client);
        }
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
        
         $this->validate($request,[
             'firstname'=>'required',
            'lastname'=>'required',
            'birthdate'=>'required',
            'address1'=>'required',
            'address2'=>'required',
            'city'=>'required',
            'zipcode'=>'required',
            'mobilenumber'=>'required',
            'emailadd'=>'required',
        ]);

       
            
             $client = Client::where('firstname',$request->input('firstname'))->where('lastname',$request->input('lastname'))->get();
             if(count($client)>0){
                 $clientid = Client::where('id',$id)->where('firstname',$request->input('firstname'))->where('lastname',$request->input('lastname'))->get();
                   if(count($clientid)>0){

                   }else{
                    $path="/admin-client/".$id."/edit";
                    return redirect($path)->with('error','This client is already in the system.');
                   }
               
             }else{

             }
        
     
        $client = Client::find($id);
        $client->firstname = $request->input('firstname');
            $client->middlename= $request->input('middlename');
            $client->lastname= $request->input('lastname');
            $client->contactnumber= $request->input('mobilenumber');
            $client->address1= $request->input('address1');
            $client->city= $request->input('city');
            $client->sales_rep= $request->input('sales_rep');
            $client->birthdate= $request->input('birthdate');
            $client->civilstatus= $request->input('civilstatus');
            $client->spouse= $request->input('spouse');
            $client->work= $request->input('spouse_work');
            $client->dependent= $request->input('dependent_study');
            $client->address2= $request->input('address2');
            $client->zipcode= $request->input('zipcode');
            $client->emailadd= $request->input('emailadd');
            $client->employementstatus= $request->input('employmentstatus');
            $client->employername= $request->input('employer');
            $client->naturebusiness= $request->input('nature');
            $client->officeaddress= $request->input('officeaddress');
            $client->officenumber= $request->input('officenumber');
            $client->position= $request->input('position');
            $client->basicsalary= $request->input('salary');
            $client->allowance= $request->input('allowance');
            $client->yearsemployed= $request->input('years');
            $client->othersource= $request->input('othersource');
            $client->living= $request->input('livingwith');
            $client->finance= $request->input('finance');
            $client->tin= $request->input('tin');
            $client->sss= $request->input('sss');
            $client->passport= $request->input('passport');
            $client->passportvalid= $request->input('passportvalid');
            $client->driver= $request->input('driver');
            $client->drivervalid= $request->input('drivervalid');
            $client->prc= $request->input('prc');
            $client->prcvalid= $request->input('prcvalid');
            $client->rental= $request->input('monthlyrental');
             $client->save();


            $admin_id=session('Data')[0]->id;

        $log = new Log;
         $log->admin_id=$admin_id;
        $log->module="Client";
        $log->description="Update client";
        $log->save();

        return redirect('/admin-client')->with('success','Client information successfully updated');
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
