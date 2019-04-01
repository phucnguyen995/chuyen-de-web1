<?php 

namespace App\Http\Controllers;
use DB;
use App\Http\Controllers\Controller;
use App\User;
use App\City;
use App\Airline;
use App\Airport;
use App\FlightClass;
use App\FlightList;
use App\FlightBooking;
use App\Customer;
use App\Transit;
use Validator;
use Request;
use Auth;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function profile()
	{
		$user = Auth::user();

		$data['get_profile_fl'] = FlightBooking::getFlightBook_List($user->id);

		return view('/profile', ['data'=>$data]);
	}
	
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update_user()
	{
		$data = Request::all();
		$validatedData = Validator::make($data,[
			'first_name' => 'required|max:50',
			'last_name' => 'required|max:50',
			'email' => 'email|max:100|unique:users',
			'password' => 'confirmed|max:100|min:6',
			'phone' => 'required|regex:/^(0)\d{9,10}$/|max:11|min:10',
			'birthdate' => 'after:today',
			'address' => 'required|max:255',
		]);

		if ($validatedData->fails()) {
			return redirect()->back()->withInput()->withErrors($validatedData);
		}
		else
		{
			$user = Auth::user();
	        $user->first_name = $data['first_name'];
	        $user->last_name =  $data['last_name'];
			$user->gender = $data['gender'];
			$user->phone =  $data['phone'];
			$user->birthdate =  $data['birthdate'];
			$user->address =  $data['address'];

			if(!$data['password'] == ''){
				 $user->password = bcrypt($data['user_password']);
			}

			$user->save();
			return redirect('/profile')->with('success','Update successfully!');
		}
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
		
		return redirect('/profile')->with('success','Update customer successfully!');
	}

	//Xem chi tiết chuyến bay đã đặt của user
    public function postDetail_book_profile()
    {
		$request = Request::all();
        $data['get_detail_flight'] = FlightList::getFlightDetail($request['id_flight_to']);
        $data['get_detail_book'] = FlightBooking::getFlightBook_Detail($request['id']);
        $data['get_transit_by_id'] = Transit::getTransitById_FLight($request['id_flight_to']);

        $data['get_detail_flight_return'] = FlightList::getFlightDetail($request['id_flight_return']);

		$data['get_transit_by_id_return'] = Transit::getTransitById_FLight($request['id_flight_return']);
		
		$data['get_customer_by_user_id'] = Customer::getCus_by_book_id($request['id']);

        return view('detail-book-profile', ['data' => $data]);
	}
	
	
    public function cancel_ticket()
    {
		$request = Request::all();

		$id_book = $request['id'];

		$book_by_id = FlightBooking::find($id_book);

		$date_from = strtotime($book_by_id->flight_to->fl_departure_date);

		$date_now = strtotime(date('Y-m-d H:i:s')); 
		
		if($date_now > $date_from){

			return redirect()->back()->with('error_cancel', "Chuyến bay đã cất cánh không thể hủy vé!");
		}
		
        if (!isset($book_by_id) || $book_by_id == null || $book_by_id->fb_user_id != Auth::user()->id) {

			return redirect()->back()->with('error_cancel', "Bạn cần chọn đúng chuyến bay cần hủy!");
			
        } else {

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

			$customer = Customer::getCus_by_book_id($id_book);

			foreach($customer as $row){
				
				DB::table('customers')->where('id', $row->id)->delete();
			}

            $book_by_id->delete();

            return redirect()->back()->with('success', "Hủy chuyến bay thành công!");
        }
        return redirect('profile');
    }

}
