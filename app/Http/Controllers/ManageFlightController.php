<?php 

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Airline;
use App\Airport;
use App\FlightBooking;
use App\FlightClass;
use App\FlightList;
use App\Transit;
use App\Customer;
use App\CountryRelationship;
use Request;
use Carbon\Carbon;
use Auth;
use DB;

class ManageFlightController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Flight Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
        $this->middleware('is_admin');

	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */


	public function get_create_transnational_flight()
	{
		$req = Request::all();
		
		$data['city'] = City::getCity();
		$data['country'] = Country::getCountries();
		
		$data['airport'] = Airport::getAirport();
		$data['fclass'] = FlightClass::getFClass();

		return  view('admin/create-transnational-flight', ['data'=>$data]);
	}

	public function get_create_domestic_flight()
	{
		$data['city'] = City::where('country_id',1)->get();

		$data['getAirline_by_country_code'] = Airline::getAirline_by_country_code(1,"");

		$data['airport'] = Airport::getAirport();

		$data['fclass'] = FlightClass::getFClass();

		return  view('admin/create-domestic-flight', ['data'=>$data]);
	}

	public function get_ticket_list()
	{
		$data['ticket_list'] = FlightBooking::paginate(5);
		
		return  view('admin/manage-tickets', ['data'=>$data]);
	}

	public function get_revenue_airlines()
	{
		$data['ticket_list'] = FlightBooking::all();
		$data['airlines'] = Airline::orderBy('airline_revenue', 'desc')->paginate(5);
		return  view('admin/revenue-airlines', ['data'=>$data]);
	}

	public function update_customer()
	{
		$request = Request::all();
		
		$data['get_customer_by_book_id'] = Customer::getCus_by_book_id($request['book_id']);

		$i = 1;

		foreach ($data['get_customer_by_book_id'] as $key) {

			$tile = $request['title'.$i.''];

			$first_name = $request['first_name'.$i.''];;

			$last_name = $request['last_name'.$i.''];
			Customer::where('id', $key->id)->update(['customer_title' => $tile]);
			Customer::where('id', $key->id)->update(['customer_first_name' => $first_name]);
			Customer::where('id', $key->id)->update(['customer_last_name' => $last_name]);
		
			$i++;
		}
		
		return redirect()->back()->with('success', "Cập nhật thông tin hành khách thành công!");;
	}

	public function cancel_ticket()
    {
		$request = Request::all();

		$id_book = $request['id'];

		$book_by_id = FlightBooking::find($id_book);

		$date_from = strtotime($book_by_id->flight_to->fl_departure_date);

		$date_now = strtotime(date('Y-m-d H:i:s')); 
		
		if($date_now > $date_from){

			return redirect()->back()->with('error', "Chuyến bay đã cất cánh không thể hủy vé!");
		}

		$customer = Customer::getCus_by_book_id($id_book);

		$airline_to = Airline::find($request['airline_id_to']);

		if ($airline_to->airline_revenue != 0){
			$airline_to->airline_revenue -= $book_by_id->fb_total_cost_to;
			$airline_to->save();
		}

		$airline_return = Airline::find($request['airline_id_return']);

		if ($airline_return != null){

			if ($airline_return->airline_revenue != 0){

				$airline_return->airline_revenue -= $book_by_id->fb_total_cost_return;
				$airline_return->save();
			}
		}

		foreach($customer as $row){
			
			DB::table('customers')->where('id', $row->id)->delete();
		}

        $book_by_id->delete();

        return redirect()->back()->with('success', "Hủy chuyến bay thành công!");
    }

	public function get_detail_ticket()
    {
		$request = Request::all();
        $data['get_detail_flight'] = FlightList::getFlightDetail($request['id_flight_to']);
        $data['get_detail_book'] = FlightBooking::getFlightBook_Detail($request['id']);
        $data['get_transit_by_id'] = Transit::getTransitById_FLight($request['id_flight_to']);

        $data['get_detail_flight_return'] = FlightList::getFlightDetail($request['id_flight_return']);

		$data['get_transit_by_id_return'] = Transit::getTransitById_FLight($request['id_flight_return']);
		
		$data['get_customer_by_user_id'] = Customer::getCus_by_book_id($request['id']);

        return view('admin/detail-ticket-flight', ['data' => $data]);
	}

	//tao chuyen bay noi dia
	public function post_domestic_flight()
	{
		$req = Request::all();
		//ngày hiện tại
		$date_now = date('Y-m-d H:i:s');

		$date_now = strtotime($date_now);

		////Chuyển đổi ngày thành Y-m-d h:i:s
		$date_from = FlightList::edit_time($req['time_departure']);

		$date_landing = FlightList::edit_time($req['time_landing']);

		//Ngày bay đến -> int
		$date_from = strtotime($date_from);

		$date_landing = strtotime($date_landing);

		//Không được phép tạo chuyến bay cách giờ bay 1 tháng
		if ($date_from - $date_now < (30*24*60*60)){

			return redirect('admin/create-domestic-flight')->withInput()->with('fail_create','Không được phép tạo chuyến bay cách giờ bay 1 tháng!');
		}

		//Giá vé máy bay
		$cost = FlightList::update_price_distane($req['distance']);

		// tạo chuyến bay đột xuất, trước giờ bay gần 3 tháng, giá vé sẽ tăng lên 5%
		if ($date_from - $date_now < 3*(30*24*60*60)){
			$cost = $cost + ($cost * 0.05);
		}

		//Chuyen doi ngay
		$date_from = date('Y-m-d H:i:s', $date_from);

		$date_landing = date('Y-m-d H:i:s', $date_landing);

		//Insert flight
		$flight = new FlightList();

		$flight->fl_city_from_id  = $req['from'];
		$flight->fl_city_to_id  = $req['to'];
		$flight->fl_departure_date  = $date_from;
		$flight->fl_landing_date  = $date_landing;
		$flight->fl_airline_id  = $req['airline'];
		$flight->fl_seat_limit  = $req['total_seat_limit'];
		$flight->fl_distance  = $req['distance'];
		$flight->fl_cost  = $cost;


		$update_attempt_airline_from = Airport::get_airport_by_id_city($req['from']);
		$update_attempt_airline_from->amount_airline_from += 1;
		$update_attempt_airline_from->save();

		$update_attempt_airline_to = Airport::get_airport_by_id_city($req['to']);
		$update_attempt_airline_to->amount_airline_to += 1;
		$update_attempt_airline_to->save();

		$flight->save();

		return redirect('admin/create-domestic-flight')->with('success_create','Tạo chuyến bay nội địa thành công!');
	}

	//Tạo chuyến bay xuyên quốc gia
	public function post_transnational_flight()
	{
		$req = Request::all();
		//ngày hiện tại
		$date_now = date('Y-m-d H:i:s');

		$date_now = strtotime($date_now);

		////Chuyển đổi ngày thành Y-m-d h:i:s
		$date_from = FlightList::edit_time($req['time_departure']);

		$date_landing = FlightList::edit_time($req['time_landing']);

		//Ngày bay đến -> int
		$date_from = strtotime($date_from);

		$date_landing = strtotime($date_landing);

		//Kiếm tra đối tác 2 quốc gia
		$check_relationship = CountryRelationship::getCountries_relationship($req['country_from'], $req['country_to']);

		if ($check_relationship == null || $check_relationship->relationship != 1){
			return redirect('admin/create-transnational-flight')->withInput()->with('fail_create','Không thể tạo chuyến bay! Do hai quốc gia không phải là đối tác của nhau!');
		}

		//Không được phép tạo chuyến bay cách giờ bay 1 tháng
		if ($date_from - $date_now < (30*24*60*60)){

			return redirect('admin/create-transnational-flight')->withInput()->with('fail_create','Không được phép tạo chuyến bay cách giờ bay 1 tháng!');
		}

		//Giá vé máy bay
		$cost = FlightList::update_price_distane($req['distance']);

		// tạo chuyến bay đột xuất, trước giờ bay gần 3 tháng, giá vé sẽ tăng lên 5%
		if ($date_from - $date_now < 3*(30*24*60*60)){
			$cost = $cost + ($cost * 0.05);
		}

		//Chuyen doi ngay
		$date_from = date('Y-m-d H:i:s', $date_from);

		$date_landing = date('Y-m-d H:i:s', $date_landing);

		//Insert flight
		$flight = new FlightList();

		$flight->fl_city_from_id  = $req['city_from'];
		$flight->fl_city_to_id  = $req['city_to'];
		$flight->fl_departure_date  = $date_from;
		$flight->fl_landing_date  = $date_landing;
		$flight->fl_airline_id  = $req['airline'];
		$flight->fl_seat_limit  = $req['total_seat_limit'];
		$flight->fl_distance  = $req['distance'];
		$flight->fl_cost  = $cost;

		$update_attempt_airline_from = Airport::get_airport_by_id_city($req['city_from']);
		$update_attempt_airline_from->amount_airline_from += 1;
		$update_attempt_airline_from->save();

		$update_attempt_airline_to = Airport::get_airport_by_id_city($req['city_to']);
		$update_attempt_airline_to->amount_airline_to += 1;
		$update_attempt_airline_to->save();

		$flight->save();

		return redirect('admin/create-transnational-flight')->with('success_create','Tạo chuyến xuyên quốc gia thành công!');
	}

	public function get_airline_by_country_code()
	{
		$req = Request::all();

		$country_id1 = $req['country_id1'];
		$country_id2 = $req['country_id2'];
	
		$data['airline_by_country_code'] = Airline::getAirline_by_country_code($country_id1,$country_id2);

		return  view('admin/load-airline', ['data'=>$data]);
	}

	public function get_city_by_id_country()
	{
		$req = Request::all();
		
		$data['city_by_id_country'] = City::get_city_by_id_country($req['country_id']);
		
		return  view('admin/load-city', ['data'=>$data]);
	}

	public function get_aiport_by_id_city()
	{
		$req = Request::all();
		
		$data['airport_by_id_city'] = Airport::getAirport_by_id_city($req['city_id']);
		
		return  view('admin/load-airport', ['data'=>$data]);
	}

	public function get_aiport_paginate()
	{
		$data['get_aiport_to_paginate'] = Airport::orderBy('amount_airline_to', 'desc')->paginate(5);

		$data['get_aiport_from_paginate'] = Airport::orderBy('amount_airline_from', 'desc')->paginate(5);
		
		return  view('admin/airport-manager', ['data'=>$data]);
	}
}
