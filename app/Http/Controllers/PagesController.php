<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Banner;
use App\Listings;
use App\Admin;
class PagesController extends Controller
{
    public function index(){
        $admins = Admin::all();
        if(count($admins)<=0){
            $admin = new Admin;
            $admin->profile="avatar.png";
            $admin->lastname="DelaCruz";
            $admin->firstname="Juan";
            $admin->middlename="Santos";
            $admin->usertype="superadmin";
            $admin->email="admin@mountmalarayatpdc.com";
            $admin->password=md5("1234567");
            $admin->status="ACTIVE";
            $admin->save();
        }
        
        $banners = Banner::where('status','PUBLISHED')->get();
        $listings = Listings::orWhere('status','PUBLISHED')->orWhere('status','LATEST')->get();
        // return $listings;
    // return view('pages.index',compact('title'));
    return view('frontend.index')->with('banners',$banners)->with('listings',$listings);
        
    }
    public function about(){
        $title = 'About Us';
        return view('frontend.about');
    }
    public function property(){
        $banners = Banner::where('status','PUBLISHED')->get();
        $listings = Listings::orWhere('status','PUBLISHED')->orWhere('status','LATEST')->get();
        return view('frontend.property')->with('banners',$banners)->with('listings',$listings);
    }
    public function single(){
       
        return view('frontend.single');
    }
     public function inquiry(){
       
        return view('frontend.inquire');
    }
    public function services(){
        $data =array(
            'title'=>'Services',
            'services'=>['Web design', 'Programming','SEO']
        );
        return view('pages.services')->with($data);
    }
   
}
