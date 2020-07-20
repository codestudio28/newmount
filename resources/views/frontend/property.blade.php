@extends('layouts.home')

@section('content')
 <!-- ======= Intro Single ======= -->
    <section class="intro-single">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-8">
            <div class="title-single-box">
              <h1 class="title-single">Our Amazing Properties</h1>
              <span class="color-text-a">Mount Malarayat</span>
            </div>
          </div>
          <div class="col-md-12 col-lg-4">
            <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  Property
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section><!-- End Intro Single-->
     <section class="property-grid grid">
      <div class="container">
        <div class="row">
         <!-- Start -->
         @foreach($listings as $key =>$listing)
         @if(($listing->status=="LATEST")||($listing->status=="PUBLISHED"))
          <div class="col-md-4">
            <div class="card-box-a card-shadow">
              <div class="img-box-a">
                <img style="width:100%;height:500px;" src="{{asset('listings_photo')}}/{{$listing->listings_photo}}" alt="" class="img-a img-fluid">
              </div>
              <div class="card-overlay">
                <div class="card-overlay-a-content">
                  <div class="card-header-a">
                    <h2 class="card-title-a">
                       <a href="/property-single/{{$listing->id}}">{{$listing->name}}
                       </a>
                      
                    </h2>
                  </div>
                  <div class="card-body-a">
                   
                     <a href="/property-single/{{$listing->id}}" class="link-a">Click here to view
                      <span class="ion-ios-arrow-forward"></span>
                    </a>
                  </div>
                  <div class="card-footer-a">
                    <ul class="card-info d-flex justify-content-around">
                      <li>
                        <h4 class="card-info-title">Area</h4>
                        <span>{{$listing->area}}m
                          <sup>2</sup>
                        </span>
                      </li>
                      <li>
                        <h4 class="card-info-title">Beds</h4>
                        <span>{{$listing->bed}}</span>
                      </li>
                      <li>
                        <h4 class="card-info-title">Baths</h4>
                        <span>{{$listing->bath}}</span>
                      </li>
                      <li>
                        <h4 class="card-info-title">Garages</h4>
                        <span>{{$listing->garage}}</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif
          @endforeach
          <!-- End -->
         
        
        </div>
        <div class="row">
         
        </div>
      </div>
    </section><!-- End Property Grid Single-->
  @endsection