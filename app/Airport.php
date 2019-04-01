<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Airport extends Model {

	protected $table = 'airports';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'airport_name', 'city_id', 'amount_airline_from', 'amount_airline_to'];

	public static function getAirport(){
		
    	return DB::table('airports')->get();
	}
	
	public static function getAirport_by_id_city($city_id)
    {
        return Airport::where('city_id', $city_id)->get();
	}
	
	public static function get_airport_by_id_city($city_id)
    {
        return Airport::where('city_id', $city_id)->first();
    }

}