@extends('master')
@section('title', 'Index')
@section('content')
    <main>  
        <div class="container">
            <section>
                <h3>Search Flight Booking</h3>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form role="form" action="{{url('flight-list')}}" onsubmit="return validateForm();">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h4 class="form-heading">1. Flight Destination</h4>
                                    <div class="form-group">
                                        <label class="control-label">From: </label>
										<select class="form-control" name="from" id="from">
                                            <option value="" selected disabled>--Thành phố đi--</option>
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
                                        <label class="control-label">Airlines: </label>
                                        <select class="form-control" name="airline" id="airline">
                                            <option value="" selected>--Hãng bay--</option>
											@foreach ($data['airline'] as $key)
                                             <option value="{{$key->id}}">{{$key->airline_name}} ({{$key->airline_code}})</option>
                                            @endforeach
										</select>       
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <h4 class="form-heading">2. Flight Airport</h4>
                                    <div class="form-group">
                                        <label class="control-label">Airport From: </label>
										<select class="form-control" name="airport_from" id="airport_from">
                                            <option selected disabled>--Sân bay--</option>
                            
										</select>                                       
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Airport To: </label>
                                        <select class="form-control" name="airport_to" id="airport_to">
                                            <option selected disabled>--Sân bay--</option>
										</select>       
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <h4 class="form-heading">3. Date of Flight</h4>
                                     <?php  $dateNow = date('Y-m-d'); 
                                            $dateNow = strtotime($dateNow) + (24*60*60);
                                            $dateNow = date('Y-m-d',$dateNow)
                                     ?>
                                    <div class="form-group">
                                        <label class="control-label">Departure: </label>
                                        <input type="date" min="{{date('Y-m-d')}}" name="departure_date" id="departure" value="{{ $dateNow }}" class="form-control" placeholder="Choose Departure Date">
                                    </div>
                                    <div class="form-group">
                                        <div class="radio">
                                            <label><input type="radio" id="onway" name="flight_type" checked value="one-way" onclick="unCheckReturn()">One Way</label>
                                            <label><input type="radio" id="checkreturn" name="flight_type" value="return" onclick="checkReturn()">Return</label>
                                        </div>
                                    </div>
                                    <div class="form-group" name="flight_type" id="return" style="display: none;">
                                        <label class="control-label">Return: </label>
                                        <input type="date"  min="{{date('Y-m-d')}}" id="return_date" name="return_date" class="form-control" placeholder="Choose Return Date">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <h4 class="form-heading">4. Search Flights</h4>
                                    <div class="form-group">
                                        <label class="control-label">Total Person: </label>
                                        <select class="form-control" name="person">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Flight Class: </label>
                                        <select class="form-control" name="fly_class">

                                            @foreach ($data['fclass'] as $key)
                                             <option value="{{$key->id}}">{{$key->fc_name}}</option>
                                            @endforeach
                                            
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Search Flights</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script>
        
    function checkReturn() {
        document.getElementById("return").style.display = "block";
        }
    
        function unCheckReturn() {
        document.getElementById("return").style.display = "none";
        }

        // validate
        function validateForm() {
        //& validateTime()
            if (validateCity() &  validateTime() & validateDateReturn() ) {
                return true;
            }
            else {
                return false;
            }
        }
            
    //validate Date return
        function validateDateReturn() {
        var return_date = document.getElementById("return_date").value;

        var time_departure = $('#departure').val();
        var time_return = $('#return_date').val();

        var t_departure = new Date(time_departure);
        var t_return = new Date(time_return);
        

        if ($('#checkreturn').prop("checked") == false)
        {
            return true;
        }

        if ( ($('#checkreturn').prop("checked") == true)  && return_date != "" )
        {
            if(t_return.getTime() > t_departure.getTime())
            {                   
                return true;
            }
            else
            {
                alert("Ngày về phải lớn ngày đi!");  
                return false;
            }     
        }
        else {
            alert('Vui lòng chọn ngày về!');
            return false;
        }
    }
            
    //validate city
    function validateCity() {
        var form = $('#from').val();
        var to = $('#to').val();
        if (form == "" || to == ""){
            alert("Vui lòng chọn đủ thành phố!");         
            return false; 
        }
        if(form == to)
        {
            alert("Thành phố đến và đi phải khác nhau!");         
            return false;
        }
        else
        {
            return true;
        }   
    }
    //validate departure
    function validateTime() {
        var time_departure = $('#departure').val();
        var dateChoose = new Date(time_departure);
        var dateNow = new Date();

        if(dateChoose.getTime() >= dateNow.getTime())
        {                   
            return true;
        }
        else
        {
            alert("Ngày, tháng đặt vé phải lớn hoặc bằng ngày hiện tại!");  
            return false;
        }        
    }
    </script>
   @endsection