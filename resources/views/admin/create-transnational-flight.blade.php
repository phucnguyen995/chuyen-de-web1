@extends('master')
@section('title', 'Create Transnational Flight')
@section('content')

<main>  
    <div class="container">
        <section>
            <h3>Tạo chuyến bay xuyên quốc gia</h3>
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
                    <form role="form" method="POST" action="{{ url('admin/post-transnational-flight') }}" id="form_transnational" onsubmit="return validateForm();">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-sm-3">
                                <h4 class="form-heading">1. Chuyến bay</h4>
                                <div class="form-group">
                                    <label class="control-label">From: </label>

                                        <select class="form-control" name="country_from" id="country_from">
                                            <option required value="" selected disabled>--Quốc gia đi--</option>
                                            @foreach ($data['country'] as $key)
                                                <option value="{{$key->id}}">{{$key->country_name}} ({{$key->country_code}})</option>
                                            @endforeach
                                        </select> 

                                        <br>

                                        <select class="form-control" name="city_from" id="city_from">

                                            <option required value="" selected disabled>--Thành phố đi--</option>
                                           
                                        </select>                                      
                                </div>
                                <div class="form-group">
                                    <label class="control-label">To: </label>

                                    <select class="form-control" name="country_to" id="country_to">
                                        <option required value="" selected disabled>--Quốc gia đến--</option>
                                        @foreach ($data['country'] as $key)
                                            <option value="{{$key->id}}">{{$key->country_name}} ({{$key->country_code}})</option>
                                        @endforeach
                                    </select> 

                                        <br>
                                    <select class="form-control" name="city_to" id="city_to">
                                        <option disabled value="" selected>--Thành phố đến--</option>
                                        
                                    </select>       
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Hãng bay: </label>
                                    <select required class="form-control" name="airline" id="airline">
                                        <option  disabled value="" selected>--Hãng bay--</option>
                                       
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
        if (validateCity() & validateCountry()) {
            return true;
        }
        else {
            return false;
        }
    }

    //validate country
    function validateCountry() {
        var from = $('#country_from').val();
        var to = $('#country_to').val();

        if(from == to)
        {
            alert("Quốc gia đến và đi phải khác nhau!");         
            return false;
        }
        
        return true;

    }
    
     //validate city
     function validateCity() {
        var from = $('#city_from').val();
        var to = $('#city_to').val();

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