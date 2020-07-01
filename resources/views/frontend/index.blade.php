@extends('layouts.home')

@section('content')
<!-- ======= Intro Section ======= -->
  <div class="intro intro-carousel">
    <div id="carousel" class="owl-carousel owl-theme">
      @foreach($banners as $key=>$banner)
      <div class="carousel-item-a intro-item bg-image" style="background-image: url('{{asset('banner_photo')}}/{{$banner->cover_photo}}')">
        <div class="overlay overlay-a"></div>
        <div class="intro-content display-table">
          <div class="table-cell">
            <div class="container">
              <div class="row">
                <div class="col-lg-8">
                  <div class="intro-body">
                    <h1 class="intro-title mb-4">
                    {{$banner->title}}
                     </h1>
                    
                    <p class="intro-subtitle intro-price">
                    
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
   
    </div>
  </div><!-- End Intro Section -->
    <main id="main">

  

    <!-- ======= Latest Properties Section ======= -->
    <section class="section-property section-t8">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">Latest Properties</h2>
              </div>
              <div class="title-link">
                <a href="property-grid.html">  All Property
                  <span class="ion-ios-arrow-forward"></span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div id="property-carousel" class="owl-carousel owl-theme">
          <!-- Start -->

          @foreach($listings as $key=>$listing)
          @if($listing->status=="LATEST")
          <div class="carousel-item-b">
            <div class="card-box-a card-shadow">
              <div class="img-box-a">
                <img style="height:500px;" src="{{asset('listings_photo')}}/{{$listing->listings_photo}}" alt="" class="img-a img-fluid">
              </div>
              <div class="card-overlay">
                <div class="card-overlay-a-content">
                  <div class="card-header-a">
                    <h2 class="card-title-a">
                      <a href="/property-single/{{$listing->id}}">
                        {{$listing->name}}
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
                        <span>{{$listing->area}} m
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
      </div>
    </section><!-- End Latest Properties Section -->


    <!-- ======= Latest News Section ======= -->
    <section class="section-news section-t8">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">Listings</h2>
              </div>
              <div class="title-link">
                <a href="blog-grid.html">All News
                  <span class="ion-ios-arrow-forward"></span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div id="new-carousel" class="owl-carousel owl-theme">
          <!-- Start -->
          @foreach($listings as $key=>$listing)
           @if($listing->status=="PUBLISHED")
          <div class="carousel-item-c">
            <div class="card-box-b card-shadow news-box">
              <div class="img-box-b">
                <img style="height:300px;" src="{{asset('listings_photo')}}/{{$listing->listings_photo}}" alt="" class="img-b img-fluid">
              </div>
              <div class="card-overlay">
                <div class="card-header-b">
                  <div class="card-category-b">
                    <a href="#" class="category-b">{{$listing->proptype->description}}
                    </a>
                  </div>
                  <div class="card-title-b">
                    <h2 class="title-2">
                      <a href="blog-single.html">{{$listing->name}}</a>
                    </h2>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
          @endif
          @endforeach
          <!-- end -->
       
       
        </div>
      </div>
    </section><!-- End Latest News Section -->


  </main><!-- End #main -->
  @endsection