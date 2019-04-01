@extends('master')
@section('title', 'Create Domestic Flight')
@section('content')

<main>  
    <div class="container">
        <section>
            <h3>Tạo chuyến bay nội địa</h3>
            @if ($message = Session::get('fail_create'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $message }}</strong>
            </div>
            @endif
            @if ($message = Session::get('success_create'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $message }}</strong>
            </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-body">
                    <form role="form" method="POST" action="{{ url('admin/post-domestic-flight') }}" id="form_domestic" onsubmit="return validateForm();">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-sm-3">
                                <h4 class="form-heading">1. Chuyến bay</h4>
                                <div class="form-group">
                                    <label class="control-label">From: </label>
                                    <select class="form-control" name="from" id="from">
                                        <option required value="" selected disabled>--Thành phố đi--</option>
                                        @foreach ($data['city'] as $key)
                                            <option value="{{$key->id}}">{{$key->city_name}} ({{$key->city_code}})</option>
                                        @endforeach
                                    </select>                                       
                                </div>
                                <div class="form-group">
                                    <label class="control-label">To: </label>
                                    <select class="form-control" name="to" id="to">
                                        <option disabled value="" selected>--Thành phố đến--</option>
                                        @foreach ($data['city'] as $key)
                                            <option value="{{$key->id}}">{{$key->city_name}} ({{$key->city_code}})</option>
                                        @endforeach
                                    </select>       
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Hãng bay: </label>
                                    <select required class="form-control" name="airline" id="airline">
                                        <option  disabled value="" selected>--Hãng bay--</option>
                                        @foreach ($data['getAirline_by_country_code'] as $key)
                                            <option value="{{$key->id}}">{{$key->airline_name}} ({{$key->airline_code}})</option>
                                        @endforeach
                                    </select>       
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <h4 class="form-heading">2. Sân bay</h4>
                                <div class="form-group">
                                    <label class="control-label">Sân bay từ: </label>
                                    <select class="form-control" name="airport_from" id="airport_from">
                                        <option selected disabled>--Sân bay--</option>
                        
                                    </select>                                       
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Sân bay đến: </label>
                                    <select class="form-control" name="airport_to" id="airport_to">
                                        <option selected disabled>--Sân bay--</option>
                                    </select>       
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <h4 class="form-heading">3. Thời gian bay</h4>
                                <div class="form-group">
                                    <label class="control-label">Bắt đầu: (dd/mm/yyy H:i SA/CH)</label>
                                    <input type="datetime-local" value="{{ old('time_departure') }}" required min="{{ date('Y-m-d')}}T00:00"  name="time_departure" id="time_departure" class="form-control" placeholder="Choose Departure Date">
                                </div>

                                <div class="form-group" >
                                    <label class="control-label">Đến: (dd/mm/yyy H:i SA/CH)</label>
                                    <input type="datetime-local" value="{{ old('time_landing') }}" min="{{ date('Y-m-d')}}T00:00"  required name="time_landing" id="time_landing" class="form-control" placeholder="Choose Landing Date">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <h4 class="form-heading">4. Thêm chuyến bay</h4>
                                <div class="form-group">
                                    <label class="control-label">Số ghế tối đa: </label>
                                    <input type="number" value="{{ old('total_seat_limit') }}" required placeholder="1" name="total_seat_limit" id="total_seat_limit" min="30" max="600" class="form-control">
                                </div>
                               
                                <div class="form-group">
                                    <label class="control-label">Khoảng cách: </label>
                                    <input type="number" value="{{ old('distance') }}" name="distance" id="distance" min="1" required placeholder="Km" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Thêm chuyến bay</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <div id="flight_success">

        </div>
    </div>
</main>
<script>

    // validate
    function validateForm() {
    //& validateTime()
        if (validateCity()) {
            return true;
        }
        else {
            return false;
        }
    }
    
     //validate city
     function validateCity() {
        var from = $('#from').val();
        var to = $('#to').val();

        if (from == "" || to == ""){
            alert("Vui lòng chọn đủ thành phố!");         
            return false; 
        }
        if(from == to)
        {
            alert("Thành phố đến và đi phải khác nhau!");         
            return false;
        }
        else
        {
            return true;
        }   
    }
</script>
@endsection