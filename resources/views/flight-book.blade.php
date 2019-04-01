@extends('master')
@section('title', 'Flight Booking')
@section('content')
    <main>
        <div class="container">
            <h2>Booking</h2>
            <div class="row">
                <div class="col-md-8">
                    <form role="form" action="{{url('postBooking')}}" id="myForm" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <section>
                            <h3>Contact Information</h3>
                             @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                First Name:
                                            </label>
                                            <input type="text" name="first_name" value="{{Auth::user()->first_name}}" class="form-control">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                Last Name:
                                            </label>
                                            <input type="text" name="last_name" value="{{Auth::user()->last_name}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                Contact's Mobile phone number
                                            </label>
                                            <input type="tel" id="phone" name="phone" value="{{Auth::user()->phone}}" class="form-control">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                Contact's email address
                                            </label>
                                            <input disabled type="email" value="{{Auth::user()->email}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="text-right">
										<button type="reset" onclick="return clearForm(this.form);" class="btn btn-default">Clear all</button>
                                        <button type="button" onclick="return location.reload();" class="btn btn-default">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section>
                            <h3>Passenger(s) Details</h3>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    @for($i = 1; $i <= $_POST['flight_person']; $i++)
                                    <h4>Passenger #{{$i}}</h4>
                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <label class="control-label">Title:</label>
                                            <select class="form-control" name="title[{{$i}}]">
                                                <option value="mr">Mr.</option>
                                                <option value="mrs">Mrs.</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label class="control-label">First Name:</label>
                                            <input type="text" required name="first_name[{{$i}}]" class="form-control">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="control-label">Last Name:</label>
                                            <input type="text" required name="last_name[{{$i}}]" class="form-control">
                                        </div>
                                    </div>
                                      @endfor
                                </div>
                            </div>
                        </section>
                        <section>
                            <h3>Price Details</h3>
                            <div>
                                <h5>
                                    <strong class="airline">{{ $data['get_detail_to']->airline->airline_name }}</strong>
                                    <?php $fly_class = $_POST['flight_class']; ?>
                                     @if($fly_class == 1)
                                        <p><span class="flight-class">Economy</span></p>
                                    @elseif ($fly_class == 2)
                                        <p><span class="flight-class">Business</span></p>
                                    @elseif ($fly_class == 3)
                                        <p><span class="flight-class">Premium Economy</span></p>
                                    @else 
                                         <p><span class="flight-class">Economy</span></p>
                                    @endif
                                </h5>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="pull-left">
                                            <strong>Giá lượt đi : (x{{$_POST['flight_person']}} person)</strong>

                                        </div>

                                         <div class="pull-right">
                                            <?php

                                                Session::put('flight_to', $_POST['flight_to']);
                                                Session::put('flight_class', $fly_class);
                                               
                                                $person = $_POST['flight_person'];
                                                $cost_to =  $data['get_detail_to']->fl_cost;
                                                if ($fly_class == 2)
                                                {
                                                    $cost_to = $cost_to + ($cost_to * 0.1);
                                                }
                                                elseif ($fly_class == 3)
                                                {
                                                    $cost_to = $cost_to + ($cost_to * 0.3);
                                                }

                                                Session::put('total_cost_to', ($cost_to * $person));
                                                ?>

                                            <strong>{{number_format($cost_to * $person)}} VNĐ</strong>
                                        </div>
                                        <div class="clearfix"></div>
                                    </li>
                                        
                                        @if(isset($_POST['flight_return']))
                                        <li class="list-group-item">
                                            <div class="pull-left">
                                                <strong>Giá lượt về : (x{{$_POST['flight_person']}} person)</strong>
                                            </div>

                                            <div class="pull-right">
                                                <?php
                                                    Session::put('flight_return', $_POST['flight_return']);

                                                    $cost_return = $data['get_detail_return']->fl_cost;
                                                    if ($fly_class == 2)
                                                    {
                                                        $cost_return = $cost_return + ($cost_return * 0.1);
                                                    }
                                                    elseif ($fly_class == 3)
                                                    {
                                                        $cost_return = $cost_return + ($cost_return * 0.3);
                                                    }
                                                     Session::put('total_cost_return', ($cost_return * $person));
                                                    ?>
                                                <strong>{{number_format($cost_return * $person)}} VNĐ</strong>
                                            </div>
                                            <div class="clearfix"></div>
                                        </li>
                                        @endif

                                        <div class="clearfix"></div>
                                   
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
                                             @if (isset($_POST['flight_return']))
                                            <strong>{{number_format(($cost_to + $cost_return) * $person)}} VND</strong>
                                            @else
                                             <strong>{{number_format($cost_to * $person)}} VND</strong>
                                            @endif
                                        </div>
                                        <div class="clearfix"></div>
                                    </li>
                                </ul>
                            </div>
                        </section>
                        <section>
                            <h3>Payment</h3>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Payment Method:
                                        </label>
                                        <select id="payment" name="payment" class="form-control" onchange="choosePayment()">
                                            <option selected value="transfer">Transfer</option>
                                            <option  value="credit_card">Credit Card</option>
                                            <option value="paypal">Paypal</option>
                                        </select>
                                        <input type="hidden" name="total_person" value="{{$person}}">
                                    </div>
                                    <div id="you_choose" style="display: none;">
                                        <h4>Credit Card</h4>
                                        <div class="form-group">
                                            <label class="control-label">Card Number</label>
                                            <input type="number" maxlength="10" id="credit_card_number" name="credit_card_number" class="form-control" placeholder="Digit card number" onkeyup="validate_credit_number()">
                                             <span class="help-block"></span>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <label class="control-label">Name on card:</label>
                                                <input type="text" id="credit_card_name" name="credit_card_name" class="form-control" onkeyup="validate_credit_name()">
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="control-label">CCV Code:</label>
                                                <input type="number" id="ccv_code" maxlength="4" name="ccv_code" class="form-control" placeholder="Digit CCV" onkeyup="validate_ccv_code()">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">
                                    Continue to Booking
                                </button>
                            </div>
                        </section>
                    </form>
                </div>
                <div class="col-md-4">
                    <h3>Flights</h3>
                    <aside>
                        <article>
                            <div>
                                @if($data['get_detail_to']->fl_transit_count == 0)
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <h5>
                                            <strong class="airline">{{$data['get_detail_to']->airline->airline_name}} {{$data['get_detail_to']->airline->airline_code}}-{{$data['get_detail_to']->id}}</strong>
                                            <?php Session::put('airline_id_to', $data['get_detail_to']->airline->id);  ?>
                                            @if($fly_class == 1)
                                                <p><span class="flight-class">Economy</span></p>
                                            @elseif ($fly_class == 2)
                                                <p><span class="flight-class">Business</span></p>
                                            @elseif ($fly_class == 3)
                                                <p><span class="flight-class">Premium Economy</span></p>
                                            @else 
                                                 <p><span class="flight-class">Economy</span></p>
                                            @endif
                                        </h5>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <?php 
                                                        Session::put('date_departure', $data['get_detail_to']->fl_departure_date);
                                                        $fl_departure_date = strtotime($data['get_detail_to']->fl_departure_date); 

                                                         ?>
                                                        <div><big class="time">{{ date('H:i',$fl_departure_date) }}</big></div>
                                                        <div><small class="date">{{ date('d M Y',$fl_departure_date) }}</small></div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div><span class="place">{{$data['get_detail_to']->city_from->city_name }} ({{$data['get_detail_to']->city_from->city_code}})</span></div>
                                                        <div><small class="airport">{{$data['get_detail_to']->city_from->airport->airport_name }}</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <i class="glyphicon glyphicon-arrow-down"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                         <?php $fl_landing_date = strtotime($data['get_detail_to']->fl_landing_date); 
                                                                     ?>
                                                        <div><big class="time">{{ date('H:i',$fl_landing_date) }}</big></div>
                                                        <div><small class="date">{{ date('d M Y',$fl_landing_date) }}</small></div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div><span class="place">{{$data['get_detail_to']->city_to->city_name }} ({{$data['get_detail_to']->city_to->city_code}})</span></div>
                                                        <div><small class="airport">{{$data['get_detail_to']->city_to->airport->airport_name }}</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                @else
                                <?php $i = 1; ?>
                                @foreach ($data['get_transit_by_id_flight_to'] as $key)
                                <ul class="list-group">
                                    <li class="list-group-item">
                                         <h5 class="alert alert-success">Transit {{$i++}}</h5>
                                        <h5>
                                            <strong class="airline">{{$data['get_detail_to']->airline->airline_name}} {{$data['get_detail_to']->airline->airline_code}}-{{$data['get_detail_to']->id}}</strong>
                                            <?php Session::put('airline_id_to', $data['get_detail_to']->airline->id);  ?>
                                            @if($fly_class == 1)
                                                <p><span class="flight-class">Economy</span></p>
                                            @elseif ($fly_class == 2)
                                                <p><span class="flight-class">Business</span></p>
                                            @elseif ($fly_class == 3)
                                                <p><span class="flight-class">Premium Economy</span></p>
                                            @else 
                                                 <p><span class="flight-class">Economy</span></p>
                                            @endif
                                        </h5>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <?php $transit_departure_date = strtotime($key->transit_fl_departure_date); 
                                                                     ?>
                                                        <div><big class="time">{{ date('H:i',$transit_departure_date) }}</big></div>
                                                        <div><small class="date">{{ date('d M Y',$transit_departure_date) }}</small></div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div><span class="place">{{$key->city_fl_from->city_name}} ({{$key->city_fl_from->city_code}})</span></div>
                                                        <div><small class="airport">{{$key->city_fl_from->airport->airport_name}}</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <i class="glyphicon glyphicon-arrow-down"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
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
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-warning">
                                        <ul>
                                            <?php 
                                                
                                                $transit_time = strtotime($key->transit_time);
                                                
                                            ?>
                                            <li>Transit for {{date('H:i',$transit_time)}} {{$key->city->city_name}}  ({{$key->city->city_code}})</li>
                                        </ul>
                                    </li>
                                    <li class="list-group-item">
                                        <h5>
                                            <strong class="airline">{{$data['get_detail_to']->airline->airline_name}} {{$data['get_detail_to']->airline->airline_code}}-{{$data['get_detail_to']->id}}</strong>

                                            @if($fly_class == 1)
                                                <p><span class="flight-class">Economy</span></p>
                                            @elseif ($fly_class == 2)
                                                <p><span class="flight-class">Business</span></p>
                                            @elseif ($fly_class == 3)
                                                <p><span class="flight-class">Premium Economy</span></p>
                                            @else 
                                                 <p><span class="flight-class">Economy</span></p>
                                            @endif
                                        </h5>
                                        <div class="row">
                                            <div class="col-sm-12">
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
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <i class="glyphicon glyphicon-arrow-down"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
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
                                        </div>
                                    </li>
                                </ul>
                                @endforeach
                                @endif
                            </div>
                        </article>
                    </aside>
                </div>
                @if (isset($_POST['flight_return']))
                <div class="col-md-4">
                    <h3>Flights Return</h3>
                    <aside>
                        <article>
                            <div>
                                @if($data['get_detail_return']->fl_transit_count == 0)
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <h5>
                                            <strong class="airline">{{$data['get_detail_return']->airline->airline_name}} {{$data['get_detail_return']->airline->airline_code}}-{{$data['get_detail_return']->id}}</strong>
                                            <?php Session::put('airline_id_return', $data['get_detail_return']->airline->id);  ?>
                                            @if($fly_class == 1)
                                                <p><span class="flight-class">Economy</span></p>
                                            @elseif ($fly_class == 2)
                                                <p><span class="flight-class">Business</span></p>
                                            @elseif ($fly_class == 3)
                                                <p><span class="flight-class">Premium Economy</span></p>
                                            @else 
                                                 <p><span class="flight-class">Economy</span></p>
                                            @endif
                                        </h5>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <?php 
                                                        Session::put('date_return', $data['get_detail_return']->fl_departure_date);
                                                        $fl_departure_date = strtotime($data['get_detail_return']->fl_departure_date); 

                                                        ?>
                                                        <div><big class="time">{{ date('H:i',$fl_departure_date) }}</big></div>
                                                        <div><small class="date">{{ date('d M Y',$fl_departure_date) }}</small></div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div><span class="place">{{$data['get_detail_return']->city_from->city_name }} ({{$data['get_detail_return']->city_from->city_code}})</span></div>
                                                        <div><small class="airport">{{$data['get_detail_return']->city_from->airport->airport_name }}</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <i class="glyphicon glyphicon-arrow-down"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                         <?php $fl_landing_date = strtotime($data['get_detail_return']->fl_landing_date); 
                                                                     ?>
                                                        <div><big class="time">{{ date('H:i',$fl_landing_date) }}</big></div>
                                                        <div><small class="date">{{ date('d M Y',$fl_landing_date) }}</small></div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div><span class="place">{{$data['get_detail_return']-> city_to->city_name }} ({{$data['get_detail_return']-> city_to->city_code}})</span></div>
                                                        <div><small class="airport">{{$data['get_detail_return']->city_to->airport->airport_name }}</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                @else
                                <?php $i = 1; ?>
                                @foreach ($data['get_transit_by_id_flight_to'] as $key)
                                <ul class="list-group">
                                    <li class="list-group-item">
                                         <h5 class="alert alert-success">Transit {{$i++}}</h5>
                                        <h5>
                                            <strong class="airline">{{$data['get_detail_return']->airline->airline_name}} {{$data['get_detail_return']->airline->airline_code}}-{{$data['get_detail_return']->id}}</strong>
                                            <?php Session::put('airline_id_return', $data['get_detail_return']->airline->id);  ?>
                                            @if($fly_class == 1)
                                                <p><span class="flight-class">Economy</span></p>
                                            @elseif ($fly_class == 2)
                                                <p><span class="flight-class">Business</span></p>
                                            @elseif ($fly_class == 3)
                                                <p><span class="flight-class">Premium Economy</span></p>
                                            @else 
                                                 <p><span class="flight-class">Economy</span></p>
                                            @endif
                                        </h5>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <?php $transit_departure_date = strtotime($key->transit_fl_departure_date); 
                                                                     ?>
                                                        <div><big class="time">{{ date('H:i',$transit_departure_date) }}</big></div>
                                                        <div><small class="date">{{ date('d M Y',$transit_departure_date) }}</small></div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div><span class="place">{{$key->city_fl_from->city_name}} ({{$key->city_fl_from->city_code}})</span></div>
                                                        <div><small class="airport">{{$key->city_fl_from->airport->airport_name}}</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <i class="glyphicon glyphicon-arrow-down"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
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
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-warning">
                                        <ul>
                                            <?php 
                                                
                                                $transit_time = strtotime($key->transit_time);
                                                
                                            ?>
                                            <li>Transit for {{date('H:i',$transit_time)}} {{$key->city->city_name}}  ({{$key->city->city_code}})</li>
                                        </ul>
                                    </li>
                                    <li class="list-group-item">
                                        <h5>
                                            <strong class="airline">{{$data['get_detail_return']->airline->airline_name}} {{$data['get_detail_return']->airline->airline_code}}-{{$data['get_detail_return']->id}}</strong>

                                            @if($fly_class == 1)
                                                <p><span class="flight-class">Economy</span></p>
                                            @elseif ($fly_class == 2)
                                                <p><span class="flight-class">Business</span></p>
                                            @elseif ($fly_class == 3)
                                                <p><span class="flight-class">Premium Economy</span></p>
                                            @else 
                                                 <p><span class="flight-class">Economy</span></p>
                                            @endif
                                        </h5>
                                        <div class="row">
                                            <div class="col-sm-12">
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
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <i class="glyphicon glyphicon-arrow-down"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
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
                                        </div>
                                    </li>
                                </ul>
                                @endforeach
                                @endif
                            </div>
                        </article>
                    </aside>
                </div>
                @endif
            </div>
        </div>
        <br>
    </main>
    <script type="text/javascript">
    function clearForm(form) {
        var $f = $(form);
        var $f = $f.find(':input').not(':button, :submit, :reset, :hidden');
        $f.val('').attr('value','').removeAttr('checked').removeAttr('selected');
    }

    function choosePayment() {
        var x = document.getElementById("payment").value;
        if(x == "credit_card"){
            document.getElementById("you_choose").style.display = "block";
            document.getElementById("credit_card_number").setAttribute("required", "required");
            document.getElementById("credit_card_name").setAttribute("required", "required");
            document.getElementById("ccv_code").setAttribute("required", "required");
        }
        else{
            document.getElementById("you_choose").style.display = "none";
            document.getElementById("credit_card_number").removeAttribute("required", "required");
            document.getElementById("credit_card_name").removeAttribute("required", "required");
            document.getElementById("ccv_code").removeAttribute("required", "required");
        }
    }

     function validateForm() {
            if (validatePhone() & validate_credit_number() & validate_ccv_code() & validate_credit_name()) {
                return true;
            }
            else {
                return false;
            }
        }

    function validate_credit_name() {
        var field = $('#credit_card_name').val();
        var filter = /^[A-Z]{1,20}$/;

        if (!filter.test(field)) {
            $('#credit_card_name').parent().addClass('has-error');
            $('#credit_card_name').parent().removeClass('has-success');
            $('#credit_card_name').next().html('Card Name phải viết Hoa liền không dấu tối đa 20 ký tự!');
            return false;
        }
        else {
            $('#credit_card_name').parent().removeClass('has-error');
            $('#credit_card_name').parent().addClass('has-success');
            $('#credit_card_name').next().html('');
            return true;
        }
    }


    function validate_credit_number() {
        var field = $('#credit_card_number').val();
        var filter = /^\d{16}$/;

        if (!filter.test(field)) {
            $('#credit_card_number').parent().addClass('has-error');
            $('#credit_card_number').parent().removeClass('has-success');
            $('#credit_card_number').next().html('Card Number có 16 chữ số!');
            return false;
        }
        else {
            $('#credit_card_number').parent().removeClass('has-error');
            $('#credit_card_number').parent().addClass('has-success');
            $('#credit_card_number').next().html('');
            return true;
        }
    }

    function validate_ccv_code() {
        var field = $('#ccv_code').val();
        var filter = /^\d{4}$/;

        if (!filter.test(field)) {
            $('#ccv_code').parent().addClass('has-error');
            $('#ccv_code').parent().removeClass('has-success');
            $('#ccv_code').next().html('CCV CODE có 4 chữ số!');
            return false;
        }
        else {
            $('#ccv_code').parent().removeClass('has-error');
            $('#ccv_code').parent().addClass('has-success');
            $('#ccv_code').next().html('');
            return true;
        }
    }

    function validatePhone() {
      var field = $('#phone').val();
      var filter = /^(0)\d{9,10}$/;

      if (!filter.test(field)) {
        $('#phone').parent().addClass('has-error');
        $('#phone').parent().removeClass('has-success');
        $('#phone').next().html('Điện thoại có từ 10 đến 11 số và bắt đầu bằng số 0.');
        return false;
      }
      else {
        $('#phone').parent().removeClass('has-error');
        $('#phone').parent().addClass('has-success');
        $('#phone').next().html('');
        return true;
      }
    }
    </script>
   @endsection