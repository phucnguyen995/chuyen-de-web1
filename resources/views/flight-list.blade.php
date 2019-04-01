@extends('master')
@section('title', 'FLight List')
@section('content')
    <main>
        <div class="container">
            <section>

                <?php             
                    $from = $_GET['from'];
                    $to = $_GET['to'];
                    $departure_date = $_GET['departure_date'];
                    $return_date = $_GET['return_date'];
                    $flight_type =  $_GET['flight_type'];
                    $fly_class = $_GET['fly_class'];
                    $person = $_GET['person'];
                    $airline = $_GET['airline'];
                 ?>
            
                <h2>Các chuyến bay lượt đi : {{$data['get_city_from']->city_name }} ({{$data['get_city_from']->city_code}}) <i class="glyphicon glyphicon-arrow-right"></i> {{$data['get_city_to']->city_name }} ({{$data['get_city_to']->city_code}})</h2>
                @if ($message = Session::get('fly_fail'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                            <strong>{{ $message }}</strong>
                    </div>
                @endif
              
                @if ($data['get_fl']->isEmpty())
                <div class="alert alert-warning alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>Hiện tại không có chuyến bay phù hợp với tìm kiếm của bạn. Vui lòng tìm kiếm lại! </strong><a class="btn btn-primary" href="{{url('/')}}">Tìm kiếm</a>
                </div>
                @endif

                @foreach ($data['get_fl'] as $key)
                <article>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4><strong><a>{{ $key->airline->airline_name }}</a></strong></h4>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="control-label">From:</label>
                                             <?php $timeFrom = strtotime($key->fl_departure_date) ?>
                                            <div><big class="time">{{ date('H:i',$timeFrom) }}</big></div>
                                            <div><span class="place">{{$data['get_city_from']->city_name }} ({{$data['get_city_from']->city_code}})</span></div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="control-label">To:</label>
                                            <?php $timeTo = strtotime($key->fl_landing_date) ?>
                                            <div><big class="time">{{ date('H:i',$timeTo) }} </big></div>
                                            <div><span class="place">{{$data['get_city_to']->city_name }} ({{$data['get_city_to']->city_code}})</span></div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="control-label">Duration:</label>
                                            <?php $duration = $timeTo - $timeFrom ?>
                                            <div><big class="time">{{ date('h:i',$duration) }}</big></div>
                                            @if ($key->fl_transit_count > 0)
                                            <div><strong class="text-danger">{{$key->fl_transit_count}} Transit</strong></div>
                                            @else
                                                <div><strong class="text-danger">Direct Flight</strong></div>
                                            @endif
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <h3 class="price text-danger"><strong>
                                                <?php
                                                $cost = $key->fl_cost;
                                               
                                                if ($fly_class == 1)
                                                {
                                                    $cost = $cost;
                                                }
                                                elseif ($fly_class == 2)
                                                {
                                                    $cost = $cost + ($cost * 0.1);
                                                }
                                                elseif ($fly_class == 3)
                                                {
                                                    $cost = $cost + ($cost * 0.3);
                                                }
                                            
                                                ?>
                                            {{number_format($cost)}} VNĐ</strong></h3>
                                            <div>
                                               
                                                <a href="{{url('flight-detail')}}?from={{$from}}&to={{$to}}&departure_date={{$departure_date}}&airline={{$airline}}&id_flight_to={{$key->id}}&return_date={{$return_date}}&flight_type={{$flight_type}}&fly_class={{$fly_class}}&person={{$person}}" class="btn btn-link">See Detail</a>
                                                <?php $return_d = $_GET['return_date']; ?>
                                                @if (Auth::check())
                                                    @if($return_d != '')
                                                     <a href="{{url('flight-list-return')}}?to={{$from}}&from={{$to}}&airline={{$airline}}&departure_date={{$departure_date}}&id_flight_to={{$key->id}}&return_date={{$return_date}}&flight_type={{$flight_type}}&fly_class={{$fly_class}}&person={{$person}}" class="btn btn-primary">Choose</a>
                                                    @else
                                                    <form method="POST" action="{{url('flight-book')}}">
                                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                      <input type="hidden" name="flight_to" value="{{ $key->id }}">
                                                      <input type="hidden" name="flight_class" value="{{ $fly_class }}">
                                                      <input type="hidden" name="flight_person" value="{{ $person }}">
                                                      <button class="btn btn-primary" type="submit"> Choose </button>  
                                                    </form>
                                                    @endif
                                                @else
                                                    <a onclick="return confirm('Bạn cần đăng nhập trước?');" href="{{url('auth/login')}}" class="btn btn-primary">Choose</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach


                <div class="text-center">

                    <?php 
                    $data['get_fl']->appends(

                        [   'from' => $from,
                            'to' => $to,
                            'departure_date' => $departure_date,
                            'return_date' => $return_date,
                            'flight_type' => $flight_type,
                            'fly_class' => $fly_class,
                            'person' => $person,
                            'airline' => $airline,
                                        ]);
                    echo $data['get_fl']->render();
                    ?>
                   
                </div>
            </section>
        </div>
    </main>
@endsection