<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class City extends Model {

	protected $table = 'cities';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','city_name', 'city_code' ,'city_airport_id', 'country_id'];

	public static function getCity(){
    	return DB::table('cities')->get();
    }
  

    public function flight_list_city()
    {
        return $this->belongsTo('App\FlightList');
    }

     public function airport()
    {
        return $this->hasOne('App\Airport', 'id','city_airport_id');
    }

    public static function  get_city_by_id_country($country_id)
    {
        return City::where('country_id', $country_id)->get();
    }

    public static function getNameCityFrom($from)
    {
        return City::where('id', $from)->first();
    }

    public static function getNameCityTo($to)
    {
        return City::where('id', $to)->first();
    }


}
