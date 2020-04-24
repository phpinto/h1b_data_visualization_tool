<style>

    path {
    
      stroke: #fff;
      stroke-width: .5;
      stroke-dasharray: 1;
      
    }
    
    #neighborhoodPopover { 
      position: absolute;     
      text-align: center;         
      padding: 2px;       
      font: 12px sans-serif;   
      background: #fff; 
      border: 0px;    
      border-radius: 8px;     
      pointer-events: none;
      opacity: 0;  
    }
    
</style>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://d3js.org/d3.v4.min.js"></script>
    <script src="https://d3js.org/topojson.v1.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-social.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-item nav-link" href="/job_search/">Job Search</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item nav-link" href="/heat_map/">Heat Map</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item nav-link" href="/dataviz/">Graphs/Figures</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item nav-link" href="/top_companies/">Top Companies</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->first_name  }} {{ Auth::user()->last_name  }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <div class="container">
            <select></select>
    </div>
    <br>
    <div class="container">
            <svg width="800" height="540" style="background-color:white"></svg>
            <div id='neighborhoodPopover'> </div>
  </div>

<script>

    var map_types = ["Salaries", "# of Filings"];
    var current_type = "Salaries";

    var dropdownChange = function() {
        if(d3.select(this).property('value') != current_type) {
            current_type = d3.select(this).property('value')
            update_map();
        }     
    };


    var dropdown = d3.select("select")
        .on("change", dropdownChange);

    dropdown.selectAll("option")
        .data(map_types)
        .enter().append("option")
            .attr("value", function (d) { return d; })
            .text(function (d) {
                return d;
        });

    var svg = d3.select("svg"),
        width = +svg.attr("width"),
        height = +svg.attr("height");

    var update_map = function() {

    svg.selectAll("*").remove();


d3.json('/get_map_json', function(error, usa) {
  if (error) throw error;

  var path = d3.geoPath()
      .projection(d3.geoConicConformal()
      .parallels([33, 45])
      .rotate([96, -39])
      .fitSize([width, height], usa));


  svg.selectAll("path")
      .data(usa.features)
      .enter().append("path")
      .attr("d", path)
      .style("fill", function(d) { 
          if (current_type == "Salaries") {
          if (d.properties.salary <= 50000) {
            return "#E1FFD7";
          }
          else if (d.properties.salary <= 75000) {
            return "#C5E8B7";
          }
          else if (d.properties.salary <= 100000) {
            return "#ABE098";
          }
          else if (d.properties.salary <= 125000) {
            return "#83D475";
          }
          else if (d.properties.salary <= 150000) {
            return "#57C84D";
          }
          else if (d.properties.salary <= 200000) {
            return "#2EB62C";
          }
          else {
            return "#239623";
          }
          }
          else if (current_type == "# of Filings") {
          var avg_filings = d.properties.filings/7
          if (avg_filings <= 500) {
            return "#F6BDC0";
          }
          else if (avg_filings <= 2500) {
            return "#F1959B";
          }
          else if (avg_filings <= 5000) {
            return "#FF7373";
          }
          else if (avg_filings <= 10000) {
            return "#EB3935";
          }
          else if (avg_filings <= 25000) {
            return "#C31F17";
          }
          else if (avg_filings <= 50000) {
            return "#86120C";
          }
          else {
            return "#510B07";
          }
          }
        })
      .on("mouseenter", function(d) {
        console.log(d);
      d3.select(this)
      .style("stroke-width", 1.5)
      .style("stroke-dasharray", 0)
     
    if (current_type == "Salaries") {
        d3.select("#neighborhoodPopover")
            .transition()
            .style("opacity", 1)
            .style("left", (d3.event.pageX) + "px")
            .style("top", (d3.event.pageY) + "px")
            .text(d.properties.name + ": $" + Math.trunc(d.properties.salary).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
    }
    else if (current_type == "# of Filings") {
        d3.select("#neighborhoodPopover")
            .transition()
            .style("opacity", 1)
            .style("left", (d3.event.pageX) + "px")
            .style("top", (d3.event.pageY) + "px")
            .text(d.properties.name + ": " + Math.trunc(d.properties.filings/7).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " filings")
    }
    })
    .on("mouseleave", function(d) { 
      d3.select(this)
      .style("stroke-width", .25)
      .style("stroke-dasharray", 1)
      d3.select("#neighborhoodPopover")
        .transition()
        .style("opacit0", 1)
        .style("left", 0)
        .style("top", 0)
        .text("")

      d3.select("#cneighborhoodPopoverountyText")
      .transition()
      .style("opacity", 0);
    });

    if (current_type == "Salaries") {
        var myimage = svg.append('image')
            .attr('xlink:href', '/return_image/salaries')
            .attr('x', 600)
            .attr('y', 20) 
            .attr('width', 200)
            .attr('height', 200)
    }
    else if (current_type == "# of Filings") {
        var myimage = svg.append('image')
            .attr('xlink:href', '/return_image/filings')
            .attr('x', 600)
            .attr('y', 20) 
            .attr('width', 200)
            .attr('height', 200)
    }

    console.log(usa);
});  
    }

    update_map();


</script>

</body>
</html>
