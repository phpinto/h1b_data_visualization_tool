@extends('layouts.app')

@section('content')
<div class="container">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="/get_home_image/international_students" alt="First slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Velkommen, Bem-vindo, Bienvenue, 	स्वागत हे, 欢迎 and Welcome!</h5>
                <p>H-1B is the first data-driven job search platfrom specifically focused on international students.</p>
              </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="/get_home_image/job_search" alt="Second slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Work smarter, not harder!</h5>
                <p>Job search can be very stressful, let us help you along the way.</p>
              </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="/get_home_image/h1b_approved" alt="Third slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Raise your chances of H-1B approval!</h5>
                <p>Take full advangage our data-driven tools to increase your chances of getting an H-1B visa.</p>
              </div>
        </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
        </a>
    </div>
</div>
@endsection