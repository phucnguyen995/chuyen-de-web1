<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class FlightBooking extends Model {

	protected $table = 'flight_booking';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','fb_user_id','fb_fl_to_id' ,'fb_fl_return_id', 'fb_class_id', 'fb_total_person', 'fb_total_cost_to', 'fb_total_cost_return', 'fb_time_book'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'fb_user_id');
    }

    public function flight_to()
    {
        return $this->hasOne('App\FlightList', 'id', 'fb_fl_to_id');
    }

    public function flight_return()
    {
        return $this->hasOne('App\FlightList', 'id', 'fb_fl_return_id');
    }

    public static function getFlightBook_List($user_id)
    {
        return FlightBooking::where('fb_user_id', $user_id)->get();
    }

    public static function getFlightBook_Detail($book_id)
    {
        return FlightBooking::where('id', $book_id)->first();
    }

    
    //update cost đặt vé theo ngày đặt
    public static function update_price($date_departure, $cost)
    {
        $date_now = date('Y-m-d H:i:s');

        $date_now = strtotime($date_now);

        //Khoảng cách giữa ngày bay và ngày hiện tại
        $date_compare = ($date_departure - $date_now);

        //Thời gian 1 ngày
        $one_day = (24 * 60 * 60);
        
        //Đặt vé trước 2 tháng: giảm 10% so với giá đơn vị
        if ( $date_compare > (60 * $one_day))
        {
            $cost = $cost - ($cost * 0.1);
        }
        //Đặt vé trước 1 tháng: giảm 5% so với giá đơn vị
        elseif ($date_compare > (30 * $one_day) && $date_compare <  60 * $one_day)
        {
            $cost = $cost - ($cost * 0.05);
        }
        
        //Đặt vé cách ngày bay 2 tuần: tăng 10% so với giá đơn vị
        elseif ($date_compare >= (14 * $one_day) && $date_compare < (30 * $one_day))
        {
             $cost = $cost * 1.1;
        }
        //Đặt vé cách ngày bay 1 tuần: tăng 20% so với giá đơn vị
        elseif ($date_compare >= (7 * $one_day) && $date_compare < (14 * $one_day))
        {
             $cost = $cost * 1.2;
        }
        //Đặt vé cách ngày bay 1 ngày: tăng 50% so với giá đơn vị
        elseif ($date_compare >=  $one_day && $date_compare < (7 * $one_day))
        {
             $cost = $cost * 1.5;
        }
        else
        {
           $cost = $cost; 
        }
        return $cost;
    }
}
