
@extends('user-page.layouts.user_main')

<style>
  .item img.img-small {
    position: absolute;
    margin-top: 20px;
    margin-left: 20px;
    height: 100px !important;
    width: auto;
    opacity: 0; /* Start with 0 opacity */
    animation: fadeIn 3.5s ease-in-out infinite ;
    /* animation: bounce 1s infinite alternate; */
  }
  @keyframes fadeIn {
      0% {
        /* top: 0; */
        opacity: 0;
      }
      50% {
        opacity: 1;
        /* top: 20px; */
      }
      100% {
        opacity: 0;
        /* top: 10px; */
      }
  }
</style>

@section('header-pages')

<div class="banner">
  
  <div id="carouselExampleIndicators" class="carousel slide">
      {{-- <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      </div> --}}
      <div class="carousel carousel-inner">
        <div class="carousel-item item active" style="height: 380px;">
            {{-- <img src="{{ asset('img/digi.png') }}" class="img-small">
            <img src="{{ asset('img/PJBUPATI1.jpg') }}" class="d-block w-100 px-0 bg-white" alt="header1"> --}}
            <img src="{{ asset('img/header.png') }}" class="d-block w-100 px-1 bg-white" alt="header2">
        </div>
        {{-- <div class="carousel-item item">
          <img src="{{ asset('img/header2.png') }}" class="d-block w-100" alt="header2">
        </div>  --}}
      </div>
      {{-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button> --}}
  </div>
</div>
@endsection

@section('content-pages')

<div class="row service-panel my-4 mx-5 rounded-4 bg-white shadow-sm" >
  <div class="col">
    <div class="text-left ms-3">
      <div class="mt-3">
        <span style="font-size: 26px;"><b>PROFILE {{$brand_name}}</b></span>
        <br>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet, consectetur eligendi nesciunt nam dolores odit accusantium minus mollitia, facilis voluptatum blanditiis totam, perspiciatis delectus esse provident tempore? Magni, incidunt nesciunt.</p>
      </div>
    </div>
  </div>

</div>


@endsection