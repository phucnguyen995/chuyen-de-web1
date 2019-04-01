@extends('master')
@section('title', 'Manage Ticket')
@section('content')
    <main>
        <div class="container">
            
            @if($data['ticket_list']->count() > 0)
             <h2 id="fly_list" class="alert alert-success" style="text-align: center; text-transform: uppercase">Các chuyến bay đang đặt </h2>
             @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                            <strong>{{ $message }}</strong>
                    </div>
                @endif
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ $message }}</strong>
                </div>
                @endif
                <?php $airline_id_return = 0 ?>
                @foreach ($data['ticket_list'] as $key)
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

                                              <a href="{{url('admin/detail-ticket-flight')}}?id_flight_to={{ $key->fb_fl_to_id}}&id_flight_return={{$key->fb_fl_return_id}}&id={{ $key->id }}&id_flight_class={{ $key->fb_class_id }}&person={{ $key->fb_total_person }}">See Detail </a>  
                                              <a href="{{url('admin/cancel-ticket')}}?id={{$key->id}}&airline_id_to={{$key->flight_to->airline->id}}&airline_id_return={{$airline_id_return}}"  class="btn btn-danger" onclick="return confirm('Bạn chắc chắc muốn hủy?');">Cancel Ticket</a>
                                            
                                            
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
                        echo $data['ticket_list']->render();
                    ?>
                </div>
            @else
            <h2 id="no_fly" class="alert alert-warning" style="text-align: center;">Hiện chưa có chuyến bay nào được đặt!</h2>
            @endif
        </div>
    </main>
@endsection
