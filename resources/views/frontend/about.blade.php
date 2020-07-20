@extends('layouts.home')

@section('content')
 <!-- ======= About Section ======= -->
  <!-- ======= Intro Single ======= -->
    <section class="intro-single">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-8">
            <div class="title-single-box">
              <h1 class="title-single">About Us</h1>
            </div>
          </div>
          <div class="col-md-12 col-lg-4">
            <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  About
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section><!-- End Intro Single-->
    <section class="section-about">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="about-img-box">
                @if(count($about)<=0)
                      <img src="{{asset('img/noimage.png')}}" alt="" class="img-fluid">
                  @else
                        <img src="{{asset('about_photo/')}}/{{$about[0]->headbanner}}" alt="" class="img-fluid">
                  @endif
            
            </div>
            <div class="sinse-box">
              <h3 class="sinse-title">Mount Malarayat
                
                <br> Since 2016</h3>
              <p>Property Development</p>
            </div>
          </div>
          <div class="col-md-12 section-t8">
            <div class="row">
              <div class="col-md-6 col-lg-5">
                  @if(count($about)<=0)
                      <img style="width:100%;height:500px;" src="{{asset('img/noimage.png')}}" alt="" class="img-fluid">
                  @else
                      <img style="width:100%;height:500px;" src="{{asset('about_photo/')}}/{{$about[0]->banner}}" alt="" class="img-fluid">
                  @endif
              
              </div>
              <div class="col-lg-2  d-none d-lg-block">
                
              </div>
              <div class="col-md-6 col-lg-5 section-md-t3">
                <div class="title-box-d">
                  <h3 class="title-d">About Us
                   
                  
                </div>
                <p class="color-text-a">
                  @if(count($about)<=0)

                  @else
                     {{$about[0]->content}}
                  @endif
               
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  @endsection