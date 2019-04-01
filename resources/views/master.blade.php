<?php date_default_timezone_set('Asia/Ho_Chi_Minh'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <base href="{{asset('')}}">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="wrapper">
    <header>
        <nav class="navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="{{url('index')}}" class="navbar-brand">Worldskills Travel</a>
                </div>
                <div class="collapse navbar-collapse" id="main-navbar">
                    <ul class="nav navbar-nav navbar-right">
                    @if (Auth::check())
                        @if (Auth::user()->type == "default")
                            <li><a href="{{url('/')}}">Search Flight</a></li>
                            <li><a href="{{url('profile')}}">Welcome : <i class="fa fa-user"></i> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a></li>
                            <li><a href="{{url('auth/logout')}}">Log Out</a></li>

                        @elseif (Auth::user()->type == "admin")
                            <li><a href="{{url('/')}}">Search Flight</a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Manager
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{url('admin/manage-tickets')}}">Quản lý vé đặt</a></li>
                                <li><a href="{{url('admin/create-domestic-flight')}}">Thêm chuyến bay nội địa</a></li>
                                <li><a href="{{url('admin/create-transnational-flight')}}">Thêm chuyến bay xuyên quốc gia</a></li>
                                <li><a href="{{url('admin/revenue-airlines')}}">Doanh thu theo hãng bay</a></li>
                                <li><a href="{{url('admin/airport-manager')}}">Thống kê lưu lượng máy bay đến - đi</a></li>
                            </ul>
                            </li>
                            <li><a href="{{url('profile')}}">Welcome : <i class="fa fa-user"></i> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a></li>
                            <li><a href="{{url('auth/logout')}}">Log Out</a></li>
                        @endif
                   
                    @else
                    
                        <li><a href="#">Welcome message</a></li>
                        <li><a href="{{url('auth/login')}}">Log In</a></li>
                        <li><a href="{{url('auth/register')}}">Register</a></li>
                    @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    @yield('content')

    <footer>
        <div class="container">
            <p class="text-center">
                Copyright &copy; 2017 | All Right Reserved
            </p>
        </div>
    </footer>
</div>
<!--scripts-->
<script type="text/javascript" src="jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script>

    $(document).ready(function($){

        //update_customer
        $("#form_customer").submit(function (e) {
            $('#customer_input').load("{{ url('update-customer') }}");
        });

        //load city from
        $('#country_from').change(function(){
            var country_id = $('#country_from').val();
            $('#city_from').load("{{ url('admin/load-city') }}?country_id="+country_id);
        });

        //load city to
        $('#country_to').change(function(){
            var country_id = $('#country_to').val();
            $('#city_to').load("{{ url('admin/load-city') }}?country_id="+country_id);
        });

        //load airport from
        $('#city_from').change(function(){
            var city_id = $('#city_from').val();
            $('#airport_from').load("{{ url('admin/load-airport') }}?city_id="+city_id);
        });

        //load airport to
        $('#city_to').change(function(){
            var city_id = $('#city_to').val();
            $('#airport_to').load("{{ url('admin/load-airport') }}?city_id="+city_id);
        });

        //load airline
        $('#city_to').change(function(){
            
            var ct_code = {
                    country_id1: $('#country_from').val(),
                    country_id2: $('#country_to').val(),
                    };

            $.ajax({
                url:"{{ url('admin/load-airline') }}",
                type: "get",
                data:ct_code,
                success:function(result){
                    $('#airline').html(result);
                }
            });
            return false; 
        })

        //get airport by city from
        $('#from').change(function(){
            $id_city_from = $('#from').val();

            $.ajax({
                url:"{{ url('airport-by-city-from') }}",
                type: "get",
                data:"id_city_from="+$id_city_from,
                success:function(result){
                    $('#airport_from').html(result);
                    }
            });
            return false; 
        });

        //get airport by city to
        $('#to').change(function(){
            $id_city_to = $('#to').val();

            $.ajax({
                url:"{{ url('airport-by-city-to') }}",
                type: "get",
                data:"id_city_to="+$id_city_to,
                success:function(result){
                    $('#airport_to').html(result);
                    }
                });
            return false; 
        });
    });
</script>
</body>
</html>