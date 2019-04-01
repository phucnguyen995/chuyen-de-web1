<?php

namespace App\Http\Controllers;

use App\Customer;
use App\FlightBooking;
use App\FlightList;
use App\Transit;
use App\Airline;
use Auth;
use Illuminate\Http\Request;
use Session;

class FlightBookController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | FlightBook Controller
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
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */

    public function getFlightBook(Request $request)
    {
        $flight_id_to = $request->flight_to;

        $data['get_detail_to'] = FlightList::getFlightDetail($flight_id_to);

        if ($data['get_detail_to']->fl_total_seat + $request->flight_person > $data['get_detail_to']->fl_seat_limit) {
		   
			$seat = $data['get_detail_to']->fl_seat_limit - $data['get_detail_to']->fl_total_seat;
		   
			$mess = "Chuyến bay này chỉ còn " . $seat . " ghế vui lòng chọn chuyến bay khác!";
		   
			return redirect()->back()->with('fly_fail', $mess);
        }

        $date_book = date('Y-m-d H:i:s');

        $date_book = strtotime($date_book);

        $date_departure = strtotime($data['get_detail_to']->fl_departure_date);

        $update_cost = FlightBooking::update_price($date_departure, $data['get_detail_to']->fl_cost);

        $data['get_detail_to']->fl_cost = $update_cost;

        $data['get_transit_by_id_flight_to'] = Transit::getTransitById_FLight($flight_id_to);

        if (isset($request->flight_return)) {
            $flight_id_return = $request->flight_return;

            $data['get_detail_return'] = FlightList::getFlightDetail($flight_id_return);

            if ($data['get_detail_return']->fl_total_seat + $request->flight_person > $data['get_detail_return']->fl_seat_limit) {
                $seat_return = $data['get_detail_return']->fl_seat_limit - $data['get_detail_return']->fl_total_seat;
                $mess_r = "Chuyến bay này chỉ còn " . $seat_return . " ghế vui lòng chọn chuyến bay khác!";
                return redirect()->back()->with('fly_fail', $mess_r);
            }

            $date_departure = strtotime($data['get_detail_return']->fl_departure_date);

            $update_cost = FlightBooking::update_price($date_departure, $data['get_detail_return']->fl_cost);

            $data['get_detail_return']->fl_cost = $update_cost;

            $data['get_transit_by_id_flight_return'] = Transit::getTransitById_FLight($flight_id_return);
        }

        return view('flight-book', ['data' => $data]);
    }

    public function postBooking(Request $request)
    {

        $date_book = date('Y-m-d H:i:s');

        $date_book = strtotime($date_book);

        $person = $request->total_person;

        $user = Auth::user();

        //$user->first_name = $request->first_name;
        //$user->last_name = $request->last_name;
        //$user->phone = $request->phone;
        //$user->save();

        //add table FlightBooking
        $fl_booking = new FlightBooking();


        if (Session::get('flight_return')) {

            $id_flight_return = Session::get('flight_return');

            $airline_id_return = Session::get('airline_id_return');

            $update_cost_return = Session::get('total_cost_return');

            $date_return = Session::get('date_return');

            $fly_return = FlightList::getFlightDetail($id_flight_return);

            $fly_return->fl_total_seat += $person;

            $fly_return->save();

            $fl_booking->fb_fl_return_id = $id_flight_return;

            $airline_return = Airline::find($airline_id_return);

            $airline_return->airline_revenue += $update_cost_return;

            $airline_return->save();

            Session::forget('flight_return');

            Session::forget('total_cost_return');

            Session::forget('airline_id_return');

            Session::forget('date_return');

            $fl_booking->fb_total_cost_return = $update_cost_return;
        }

        $id_flight_to = Session::get('flight_to');

        $airline_id_to = Session::get('airline_id_to');

        $fly_class = Session::get('flight_class');

        $update_cost_to = Session::get('total_cost_to');

        $date_departure = Session::get('date_departure');

        $fly_to = FlightList::getFlightDetail($id_flight_to);

        $fly_to->fl_total_seat += $person;

        $fly_to->save();

        Session::forget('flight_to');
        Session::forget('flight_class');
        Session::forget('total_cost_to');
        Session::forget('date_departure');
        Session::forget('airline_id_to');

        $airline_to = Airline::find($airline_id_to);

        $airline_to->airline_revenue += $update_cost_to;

        $airline_to->save();

        $fl_booking->fb_user_id = $user->id;
        $fl_booking->fb_fl_to_id = $id_flight_to;
        $fl_booking->fb_class_id = $fly_class;
        $fl_booking->fb_total_person = $person;
        $fl_booking->fb_total_cost_to = $update_cost_to;
        $fl_booking->fb_time_book = date('Y-m-d H:i:s');
        $fl_booking->save();

        //Add table customer
        for ($i = 1; $i <= $person; $i++) {
            $customer = new Customer();
            if ($request->payment == "credit_card") {
                $customer->customer_user_id = $user->id;
                $customer->customer_book_id = $fl_booking->id;
                $customer->customer_first_name = $request->first_name[$i];
                $customer->customer_last_name = $request->last_name[$i];
                $customer->customer_title = $request->title[$i];
                $customer->customer_credit_card = 1;
                $customer->customer_credit_number = $request->credit_card_number;
                $customer->customer_credit_name = $request->credit_card_name;
                $customer->customer_credit_ccv = $request->ccv_code;
                $customer->token = $request->_token;

            } elseif ($request->payment == "transfer") {
                $customer->customer_user_id = $user->id;
                $customer->customer_book_id = $fl_booking->id;
                $customer->customer_first_name = $request->first_name[$i];
                $customer->customer_last_name = $request->last_name[$i];
                $customer->customer_title = $request->title[$i];
                $customer->customer_transfer = 1;
                $customer->token = $request->_token;

            } else {
                $customer->customer_user_id = $user->id;
                $customer->customer_book_id = $fl_booking->id;
                $customer->customer_first_name = $request->first_name[$i];
                $customer->customer_last_name = $request->last_name[$i];
                $customer->customer_title = $request->title[$i];
                $customer->customer_paypal = 1;
                $customer->token = $request->_token;
            }
            $customer->save();
        }

        return redirect('profile#fly_list');
    }

}
