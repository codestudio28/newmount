@extends('layouts.home')

@section('content')
  <main id="main">

    <!-- ======= Intro Single ======= -->
    <section class="intro-single">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-8">
            <div class="title-single-box">
              <h1 class="title-single">{{$listing->name}}</h1>
             
            </div>
          </div>
          <div class="col-md-12 col-lg-4">
            <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="/property">Property</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                 {{$listing->name}}
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section><!-- End Intro Single-->

    <!-- ======= Property Single ======= -->
    <section class="property-single nav-arrow-b">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div id="property-single-carousel" class="owl-carousel owl-arrow gallery-property">
              <div class="carousel-item-b">
                <img src="{{asset('listings_photo')}}/{{$listing->listings_photo}}" alt="">
              </div>
             
            </div>
            <div class="row justify-content-between">
              <div class="col-md-5 col-lg-4">
               
              
                  <div class="row">
                    <div class="col-sm-12" style="margin-top:-60px;">
                      <div class="title-box-d section-t4">
                        <h3 class="title-d">Quick Summary</h3>
                      </div>
                    </div>
                  </div>
                  <div class="summary-list">
                    <ul class="list">
                    
                      <li class="d-flex justify-content-between">
                        <strong>Property Type:</strong>
                        <span>{{$listing->proptype->description}}</span>
                      </li>
                      <li class="d-flex justify-content-between">
                        <strong>Area:</strong>
                        <span>{{$listing->area}}m
                          <sup>2</sup>
                        </span>
                      </li>
                      <li class="d-flex justify-content-between">
                        <strong>Beds:</strong>
                        <span>{{$listing->bed}}</span>
                      </li>
                      <li class="d-flex justify-content-between">
                        <strong>Baths:</strong>
                        <span>{{$listing->bath}}</span>
                      </li>
                      <li class="d-flex justify-content-between">
                        <strong>Garage:</strong>
                        <span>{{$listing->garage}}</span>
                      </li>
                    </ul>
                  </div>
               
              </div>
              <div class="col-md-7 col-lg-7 section-md-t3">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="title-box-d">
                      <h3 class="title-d">Property Description</h3>
                    </div>
                  </div>
                </div>
                <div class="property-description">
                  <p class="description color-text-a">
                   {{$listing->description}}
                  </p>
                 
                </div>
            
              </div>
            </div>
          </div>
         
          <div class="col-md-12">
            <div class="row section-t3">
              <div class="col-sm-8">
                <div class="title-box-d">
                  <h3 class="title-d">Map</h3>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="title-box-d">
                  <h3 class="title-d">Inquire Now</h3>
                </div>
              </div>
            </div>
            <div class="row">
               <div class="col-md-12 col-lg-8">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3871.9273065683583!2d121.19398991469059!3d13.962932496128019!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd6b0a8453dae9%3A0xfbfec5b0c9b6793a!2sMount%20Malarayat%20Avenue%2C%20Lipa%2C%20Batangas!5e0!3m2!1sen!2sph!4v1593492182314!5m2!1sen!2sph" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
               </div>
               
              <div class="col-md-12 col-lg-4">
                  {{ Form::open(['action' => 'SingleController@store','method'=>'POST'])}}
                <div class="property-contact">
                  <form class="form-a">
                    <div class="row">
                      <div class="col-md-12 mb-1">
                        <div class="form-group">
                          <input type="text" class="form-control form-control-lg form-control-a" id="inputName" placeholder="Name *" name="fullname" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-1">
                        <div class="form-group">
                          <input type="email" class="form-control form-control-lg form-control-a" id="inputEmail1" placeholder="Email *" name="email" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-1">
                        <div class="form-group">
                          <textarea id="textMessage" class="form-control" placeholder="Comment *" name="message" cols="45" rows="8" name="message" required></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-a">Send Message</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
                 {{ Form::close() }}
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Property Single-->

  </main><!-- End #main -->
    
  @endsection