@extends('master')
@section('title', 'Profile')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-push-3">
                    <h2>Information : {{Auth::user()->first_name}} {{Auth::user()->last_name}}</h2>
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

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                            <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form role="form" method="POST" action="{{url('update_user')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label class="control-label">Email Address:</label>
                                    <input disabled type="email" class="form-control" placeholder="Enter your email address" name="email" value="{{ Auth::user()->email }}">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Password:</label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter your password">
                                </div>

                                 <div class="form-group">
                                    <label class="control-label">Confirm Password:</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Enter confirm password">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">First Name:</label>
                                    <input type="text" name="first_name" class="form-control" placeholder="Enter your name" value="{{Auth::user()->first_name}}">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Last Name:</label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Enter your name" value="{{Auth::user()->last_name}}">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Phone Number:</label>
                                    <input value="{{Auth::user()->phone}}" type="tel" name="phone" class="form-control" placeholder="Enter your phone number">
                                </div>

                                <div class="form-group">
	                                <label class="control-label">Birthdate</label>
	                               
	                                <input value="{{Auth::user()->birthdate}}" required="required" id="birthdate" name="birthdate" type="date" class="form-control" placeholder="BirthDate..">
                              
                            	</div>

                             <div class="form-group">
                                <label  class="control-label">Gender</label>
                                    <select name="gender">
                                        @if (Auth::user()->gender == 0)
                                            <option value="1">Male</option>
                                            <option selected value="0">Female</option>
                                        @else
                                            <option selected value="1">Male</option>
                                             <option value="0">Female</option>
                                        @endif
                                    </select>
                            </div>

                             <div class="form-group">
                                <label class="control-label">Address</label>

                                <input value="{{Auth::user()->address}}" type="text" name="address" id="address" placeholder="Address..." aria-required="true" required="required" class="form-control" >

                            </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           
            @if($data['get_profile_fl']->count() > 0)
             <h2 id="fly_list" class="alert alert-success" style="text-align: center;">Các chuyến bay đang đặt của bạn : </h2>
             @if ($message = Session::get('error_cancel'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                            <strong>{{ $message }}</strong>
                    </div>
                @endif
                <?php $airline_id_return = 0 ?>
                @foreach ($data['get_profile_fl'] as $key)
                <article>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4><strong><a>{{ $key->flight_to->airline->airline_name }} <?php if($key->fb_fl_return_id > 0) echo"(Return)"; ?> </a></strong></h4>
                                    <?php if(isset($key->flight_return->airline->id))
                                        {$airline_id_return = $key->flight_return->airline->id;}
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="control-label">From:</label>
                                             <?php $timeFrom = strtotime($key->flight_to->fl_departure_date) ?>
                                            <div><big class="time">{{ date('H:i',$timeFrom) }}</big></div>
                                            <div><span class="place">{{$key->flight_to->city_from->city_name }} ({{$key->flight_to->city_from->city_code}})</span></div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="control-label">To:</label>
                                            <?php $timeTo = strtotime($key->flight_to->fl_landing_date) ?>
                                            <div><big class="time">{{ date('H:i',$timeTo) }} </big></div>
                                            <div><span class="place">{{$key->flight_to->city_to->city_name }} ({{$key->flight_to->city_to->city_code}})</span></div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="control-label">Duration:</label>
                                            <?php $duration = $timeTo - $timeFrom ?>
                                            <div><big class="time">{{ date('h:i',$duration) }}</big></div>
                                            @if ($key->flight_to->fl_transit_count > 0)
                                            <div><strong class="text-danger">{{$key->flight_to->fl_transit_count}} Transit</strong></div>
                                            @else
                                                <div><strong class="text-danger">Direct Flight</strong></div>
                                            @endif
                                        </div>
                                        <div class="col-sm-4 text-right">
                                            <h3 class="price text-danger"><strong>
                                            
                                            {{number_format($key->fb_total_cost_to)}} VNĐ | {{$key->fb_total_person}} Person</strong></h3>
                                        <div>
                                        <form method="POST" action="{{url('detail-book-profile')}}">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                              <input type="hidden" name="id_flight_to" value="{{ $key->fb_fl_to_id }}">
                                              <input type="hidden" name="id" value="{{ $key->id }}">
                                              <input type="hidden" name="id_flight_return" value="{{ $key->fb_fl_return_id }}">
                                              <input type="hidden" name="id_flight_class" value="{{ $key->fb_class_id }}">
                                              <input type="hidden" name="person" value="{{ $key->fb_total_person }}">
                                             
                                              <button class="btn btn-link" type="submit"> See Detail </button> 
                                              
                                              <a href="{{url('cancel-ticket')}}?id={{$key->id}}&airline_id_to={{$key->flight_to->airline->id}}&airline_id_return={{$airline_id_return}}"  class="btn btn-danger" onclick="return confirm('Bạn chắc chắc muốn hủy?');">Hủy vé</a>
                                              
                                            </form>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            @else
            <h2 id="no_fly" class="alert alert-warning" style="text-align: center;">Bạn chưa đặt chuyến bay nào</h2>
            @endif
        </div>
    </main>
@endsection
