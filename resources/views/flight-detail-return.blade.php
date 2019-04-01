@extends('master')
@section('title', 'Flight Detail')
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
                    $id_flight_to = $_GET['id_flight_to'];
                 ?>

               <h2>Chi tiết chuyến bay lượt về : {{$data['get_city_from']->city_name }} ({{$data['get_city_from']->city_code}}) <i class="glyphicon glyphicon-arrow-right"></i> {{$data['get_city_to']->city_name }} ({{$data['get_city_to']->city_code}})</h2>

               @if ($message = Session::get('fly_fail'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                            <strong>{{ $message }}</strong>
                    </div>
                    @endif
                <article>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                   
                                    <h4><strong>{{ $data['get_detail']->airline->airline_name }}</strong></h4>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="control-label">From:</label>
                                             <?php $timeFrom = strtotime($data['get_detail']->fl_departure_date) ?>
                                            <div><big class="time">{{ date('H:i',$timeFrom) }}</big></div>
                                            <div><span class="place">{{$data['get_city_from']->city_name }} ({{$data['get_city_from']->city_code}})</span></div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="control-label">To:</label>
                                            <?php $timeTo = strtotime($data['get_detail']->fl_landing_date) ?>
                                            <div><big class="time">{{ date('H:i',$timeTo) }} </big></div>
                                            <div><span class="place">{{$data['get_city_to']->city_name }} ({{$data['get_city_to']->city_code}})</span></div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="control-label">Duration:</label>
                                            <?php $duration = $timeTo - $timeFrom ?>
                                            <div><big class="time">{{ date('h:i',$duration) }}</big></div>
                                            @if ($data['get_detail']->fl_transit_count > 0)
                                            <div><strong class="text-danger">{{$data['get_detail']->fl_transit_count}} Transit</strong></div>
                                            @else
                                                <div><strong class="text-danger">Direct Flight</strong></div>
                                            @endif
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <h3 class="price text-danger"><strong>
                                                <?php
                                                $person = $_GET['person'];
                                                $cost = $data['get_detail']->fl_cost;
                                                $fly_class = $_GET['fly_class'];
                                                if ($fly_class == 2)
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
                                                @if(Auth::check())
                                                
                                                <form method="POST" action="{{url('flight-book')}}">
                                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                  <input type="hidden" name="flight_to" value="{{ $id_flight_to }}">

                                                  <input type="hidden" name="flight_return" value="{{  $data['get_detail']->id }}">
                                                  <input type="hidden" name="flight_class" value="{{ $fly_class }}">
                                                  <input type="hidden" name="flight_person" value="{{ $person }}">
                                                  <button class="btn btn-primary" type="submit"> Choose </button>  
                                                </form>

                                                @else
                                                    <a onclick="return confirm('Bạn cần đăng nhập trước?');" href="{{url('auth/login')}}" class="btn btn-primary">Choose</a>
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#flight-detail-tab">Flight Details</a></li>
                                        <li><a data-toggle="tab" href="#flight-price-tab">Price Details</a></li>
                                    </ul>
                                    <div class="tab-content">
                                       
                                            @if ($data['get_detail']->fl_transit_count == 0)
                                        <div id="flight-detail-tab" class="tab-pane fade in active">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <h5> 
                                                        <strong class="airline">{{$data['get_detail']->airline->airline_name}} {{$data['get_detail']->airline->airline_code}}-{{$data['get_detail']->id}}
                                                        </strong>
                                                        
                                                        
                                                        @if($_GET['fly_class'] == 1)
                                                            <p><span class="flight-class">Economy</span></p>
                                                        @elseif ($_GET['fly_class'] == 2)
                                                            <p><span class="flight-class">Business</span></p>
                                                        @elseif ($_GET['fly_class'] == 3)
                                                            <p><span class="flight-class">Premium Economy</span></p>
                                                        @else 
                                                             <p><span class="flight-class">Economy</span></p>
                                                        @endif

                                                    </h5>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <?php $fl_departure_date = strtotime($data['get_detail']->fl_departure_date);
                                                                       
                                                                     ?>
                                                                    <div><big class="time">{{ date('H:i',$fl_departure_date) }}</big></div>
                                                                    <div><small class="date">{{ date('d M Y',$fl_departure_date) }}</small></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div><span class="place">{{$data['get_city_from']->city_name }} ({{$data['get_city_from']->city_code}})</span></div>
                                                                    <div><small class="airport">{{$data['get_city_from']->airport->airport_name }}</small></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-1">
                                                            <i class="glyphicon glyphicon-arrow-right"></i>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="row">
                                                                <div class="col-sm-4">

                                                                    <?php $fl_landing_date = strtotime($data['get_detail']->fl_landing_date);
                                                                    ?>

                                                                    <div><big class="time">{{ date('H:i',$fl_landing_date) }}</big></div>
                                                                    <div><small class="date">{{ date('d M Y',$fl_landing_date) }}</small></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div><span class="place">{{$data['get_city_to']->city_name }} ({{$data['get_city_to']->city_code}})</span></div>
                                                                    <div><small class="airport">{{$data['get_city_to']->airport->airport_name }} </small></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3 text-right">
                                                            <?php 
                                                                $duration_fl = $fl_landing_date - $fl_departure_date;
                                                                
                                                                
                                                            ?>
                                                            <label class="control-label">Duration:</label>
                                                            <div><strong class="time">{{ date('H:i',$duration_fl) }}</strong></div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        
                                            @else
                                       
                                        <?php $i = 1; ?>
                                        <div id="flight-detail-tab" class="tab-pane fade in active">
                                        @foreach ($data['get_transit_by_id'] as $key)
                                        
                                            <ul class="list-group">
                                                <h4 class="alert alert-success">Transit {{$i++}}</h4>
                                                <li class="list-group-item">
                                                    <h5> 
                                                        <strong class="airline">{{$data['get_detail']->airline->airline_name}} {{$data['get_detail']->airline->airline_code}}-{{$data['get_detail']->id}}
                                                        </strong>
                                                        
                                                        
                                                        @if($_GET['fly_class'] == 1)
                                                            <p><span class="flight-class">Economy</span></p>
                                                        @elseif ($_GET['fly_class'] == 2)
                                                            <p><span class="flight-class">Business</span></p>
                                                        @elseif ($_GET['fly_class'] == 3)
                                                            <p><span class="flight-class">Premium Economy</span></p>
                                                        @else 
                                                             <p><span class="flight-class">Economy</span></p>
                                                        @endif

                                                    </h5>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <?php $transit_fl_departure_date = strtotime($key->transit_fl_departure_date);
                                                                       
                                                                     ?>
                                                                    <div><big class="time">{{ date('H:i',$transit_fl_departure_date) }}</big></div>
                                                                    <div><small class="date">{{ date('d M Y',$transit_fl_departure_date) }}</small></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div><span class="place">{{$key->city_fl_from->city_name}} ({{$key->city_fl_from->city_code}})</span></div>
                                                                    <div><small class="airport">{{$key->city_fl_from->airport->airport_name}}</small></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-1">
                                                            <i class="glyphicon glyphicon-arrow-right"></i>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="row">
                                                                <div class="col-sm-4">

                                                                    <?php $transit_date = strtotime($key->transit_date);
                                                                    ?>

                                                                    <div><big class="time">{{ date('H:i',$transit_date) }}</big></div>
                                                                    <div><small class="date">{{ date('d M Y',$transit_date) }}</small></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div><span class="place">{{$key->city->city_name}} ({{$key->city->city_code}})</span></div>
                                                                    <div><small class="airport">{{$key->city->airport->airport_name}}</small></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3 text-right">
                                                            <?php 
                                                                $duration_transit = $transit_date - $transit_fl_departure_date;
                                                                $transit_time = strtotime($key->transit_time);
                                                                
                                                            ?>
                                                            <label class="control-label">Duration:</label>
                                                            <div><strong class="time">{{ date('H:i',$duration_transit) }}</strong></div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item list-group-item-warning">
                                                    <ul>
                                                        <li>Transit for {{date('H:i',$transit_time)}} {{$key->city->city_name}}  ({{$key->city->city_code}})</li>
                                                    </ul>
                                                </li>
                                                <li class="list-group-item">
                                                    <h5>
                                                        <strong class="airline">{{$data['get_detail']->airline->airline_name}} {{$data['get_detail']->airline->airline_code}}-{{$data['get_detail']->id}}</strong>
                                                        
                                                         @if($_GET['fly_class'] == 1)
                                                            <p><span class="flight-class">Economy</span></p>
                                                        @elseif ($_GET['fly_class'] == 2)
                                                            <p><span class="flight-class">Business</span></p>
                                                        @elseif ($_GET['fly_class'] == 3)
                                                            <p><span class="flight-class">Premium Economy</span></p>
                                                        @else 
                                                             <p><span class="flight-class">Economy</span></p>
                                                        @endif
                                                    </h5>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <?php $timeTransit_departure = $transit_date + $transit_time;
                                                                    ?>

                                                                    <div><big class="time">{{ date('H:i',$timeTransit_departure) }}</big></div>
                                                                    <div><small class="date">{{ date('d M Y',$timeTransit_departure) }}</small></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div><span class="place">{{$key->city->city_name}} ({{$key->city->city_code}})</span></div>
                                                                    <div><small class="airport">{{$key->city->airport->airport_name}}</small></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-1">
                                                            <i class="glyphicon glyphicon-arrow-right"></i>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                     <?php $transit_landing_date = strtotime($key->transit_landing_date);
                                                                    ?>
                                                                    <div><big class="time">{{ date('H:i',$transit_landing_date) }}</big></div>
                                                                    <div><small class="date">{{ date('d M Y',$transit_landing_date) }}</small></div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div><span class="place">{{$key->city_to->city_name}} ({{$key->city_to->city_code}})</span></div>
                                                                    <div><small class="airport">{{$key->city_to->airport->airport_name}}</small></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3 text-right">
                                                            <?php $dttt =  $transit_landing_date - $timeTransit_departure;   ?>
                                                            <label class="control-label">Duration:</label>
                                                            <div><strong class="time">{{date('H:i',$dttt) }}</strong></div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        
                                   
                                        @endforeach

                                        @endif
                                         </div>
                                    
                                        <div id="flight-price-tab" class="tab-pane fade">
                                            <h5>
                                                <strong class="airline">{{$data['get_detail']->airline->airline_name}} {{$data['get_detail']->airline->airline_code}}-{{$data['get_detail']->id}}</strong>
                                                 @if($_GET['fly_class'] == 1)
                                                    <p><span class="flight-class">Economy</span></p>
                                                @elseif ($_GET['fly_class'] == 2)
                                                    <p><span class="flight-class">Business</span></p>
                                                @elseif ($_GET['fly_class'] == 3)
                                                    <p><span class="flight-class">Premium Economy</span></p>
                                                @else 
                                                     <p><span class="flight-class">Economy</span></p>
                                                @endif
                                            </h5>
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <div class="pull-left">
                                                        <strong>Passengers Fare (x{{$person}})</strong>
                                                    </div>
                                                    <div class="pull-right">
                                                        <strong>{{number_format($cost * $person)}} VND</strong>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="pull-left">
                                                        <span>Tax</span>
                                                    </div>
                                                    <div class="pull-right">
                                                        <span>Included</span>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </li>
                                                <li class="list-group-item list-group-item-info">
                                                    <div class="pull-left">
                                                        <strong>You Pay</strong>
                                                    </div>
                                                    <div class="pull-right">
                                                        <strong>{{number_format($cost * $person)}} VND</strong>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </li>
                                            </ul>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </section>
        </div>
    </main>
 @endsection