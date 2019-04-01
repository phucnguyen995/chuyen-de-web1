<?php 

namespace App\Http\Controllers;

use App\City;
use App\Airline;
use App\Airport;
use App\FlightClass;
use App\FlightList;
use App\Transit;
use App\FlightBooking;
use Request;
use Carbon\Carbon;
use DB;

class FlightController extends Controller {

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
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$data['city'] = City::getCity();

		$data['airline'] = Airline::getAirline();
		
		$data['airport'] = Airport::getAirport();

		$data['fclass'] = FlightClass::getFClass();

		return  view('index', ['data'=>$data]);
	}
	
	//Chi tiết chuyến bay lượt đi
	public function flightDetail()
	{
		$search = Request::all();

		$data['get_detail'] = FlightList::getFlightDetail($search['id_flight_to']);

        $date_departure = strtotime($data['get_detail']->fl_departure_date);

		$update_cost = FlightBooking::update_price($date_departure, $data['get_detail']->fl_cost);

        $data['get_detail']->fl_cost =  $update_cost;

		$data['get_city_from'] = City::getNameCityTo($search['from']);

		$data['get_city_to'] = City::getNameCityFrom($search['to']);

		$data['get_transit_by_id'] = Transit::getTransitById_FLight($search['id_flight_to']);

		return  view('flight-detail', ['data'=>$data]);
	}

	//Chi tiết chuyến bay lượt về
	public function flightDetail_Return()
	{
		$search = Request::all();

		$data['get_detail'] = FlightList::getFlightDetail($search['id_flight_return']);

		$date_departure = $data['get_detail']->fl_departure_date;

		$update_cost = FlightBooking::update_price($date_departure, $data['get_detail']->fl_cost);

        $data['get_detail']->fl_cost = $update_cost;;

        $data['get_detail']->fl_cost =  $update_cost;

		$data['get_city_from'] = City::getNameCityTo($search['from']);

		$data['get_city_to'] = City::getNameCityFrom($search['to']);

		$data['get_transit_by_id'] = Transit::getTransitById_FLight($search['id_flight_return']);

		return  view('flight-detail-return', ['data'=>$data]);
	}

	//Tìm kiếm chuyến bay lượt đi
	public function searchFlightList()
	{
		$search = Request::all();

		$data['get_fl'] = FlightList::getFlightList($search['from'], $search['to'], $search['airline'], 5);
		
		foreach ($data['get_fl'] as $row){

			$date_departure = strtotime($row->fl_departure_date);

			$update_cost = FlightBooking::update_price($date_departure, $row->fl_cost);

			$row->fl_cost =  $update_cost;

		}

		$data['get_city_from'] = City::getNameCityTo($search['from']);
		
		$data['get_city_to'] = City::getNameCityFrom($search['to']);

		return  view('flight-list', ['data'=>$data]);
	}

	//Tìm kiếm chuyến bay lượt về
	public function searchFlightList_Return()
	{
		$search = Request::all();

		$data['get_fl'] = FlightList::getFlightList($search['from'], $search['to'], $search['airline'], 5);

		foreach ($data['get_fl'] as $row){

			$date_departure = strtotime($row->fl_departure_date);

			$update_cost = FlightBooking::update_price($date_departure, $row->fl_cost);

			$row->fl_cost =  $update_cost;

		}
		
		$data['get_city_from'] = City::getNameCityTo($search['from']);

		$data['get_city_to'] = City::getNameCityFrom($search['to']);

		return  view('flight-list-return', ['data'=>$data]);
	}

	public function airport_city_from(){

		$req = Request::all();

		$data['airport_by_id_city_from'] = Airport::getAirport_by_id_city($req['id_city_from']);

		return view('airport-by-city-from', ['data'=>$data]);
	}

	public function airport_city_to(){
		$req = Request::all();

		$data['airport_by_id_city_to'] = Airport::getAirport_by_id_city($req['id_city_to']);

		return view('airport-by-city-to', ['data'=>$data]);
	}

}
