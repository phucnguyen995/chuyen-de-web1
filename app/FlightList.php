<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class FlightList extends Model {

	protected $table = 'flight_lists';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','fl_city_from_id', 'fl_city_to_id', 'fl_departure_date', 'fl_landing_date' , 'fl_airline_id', 'fl_seat_limit', 'fl_total_seat' , 'fl_distance' , 'fl_cost'];

	public function airline()
    {
        return $this->hasOne('App\airline', 'id','fl_airline_id');
    }

    public function flight_class()
    {
        return $this->hasMany('App\FlightClass');
    }

    public function transit()
    {
        return $this->belongsTo('App\Transit');
    }

    public function city_to()
    {
        return $this->hasOne('App\City', 'id', 'fl_city_to_id');
    }

    public function city_from()
    {
        return $this->hasOne('App\City', 'id', 'fl_city_from_id');
    }

    //Tìm kiếm chuyến bay (Đã loại bỏ tìm ngày bay để dễ demo)
    public static function getFlightList($from, $to, $airline, $paginate)
    {
        if ($airline != "")
        {
            $flight_list = FlightList::where('fl_city_from_id', $from)
            ->where('fl_city_to_id', $to)->where('fl_airline_id', $airline)->paginate($paginate);
        }
        else {
            $flight_list = FlightList::where('fl_city_from_id', $from)
            ->where('fl_city_to_id', $to)->paginate($paginate);   
        }
        return $flight_list;
    }

    public static function getFlightDetail($id)
    {
        return FlightList::where('id', $id)->first();
    }

    //Giá vé theo khoảng cách
    public static function update_price_distane($distance)
    {
        //distance = km
        $cost = 0;
        if ( 0 < $distance && $distance <= 100){
            $cost = 500000;
        }
        elseif ( 101 <= $distance && $distance <= 200){
            $cost = 1000000;
        }
        elseif ( 201 <= $distance && $distance <= 500){
            $cost = 2000000;
        }
        elseif ( 501 <= $distance && $distance <= 1000){
            $cost = 3000000;
        }
        elseif ( 1001 <= $distance && $distance <= 2000){
            $cost = 6000000;
        }
        elseif ( 2001 <= $distance && $distance <= 5001){
            $cost = 20000000;
        }
        elseif ($distance > 5001){
            $cost = 30000000;
        }
        return $cost;
    }

    //Chuyển đổi ngày thành Y-m-d h:i:s
    public static function edit_time($date_edit)
	{
		$date_edit = str_replace("T"," ", $date_edit);

		// $date_edit = strtotime($date_edit);

        // $date_edit = date('Y-m-d H:i:s', $date_edit);
        
		return $date_edit;
	}

}
