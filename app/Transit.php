<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Transit extends Model {

	protected $table = 'transits';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','transit_city_id', 'transit_departure_date', 'transit_landing_date', 'transit_fl_id'];

	public function flight_transit()
	{
	    return $this->hasMany('App\FlightList', 'id', 'transit_fl_id');
	}

    public function city()
    {
        return $this->hasOne('App\City', 'id', 'transit_city_id');
    }

    public function city_to()
    {
        return $this->hasOne('App\City', 'id', 'transit_city_to_id');	
    }

    public function city_fl_from()
    {
        return $this->hasOne('App\City', 'id', 'transit_fl_city_from_id');	
    }

    public static function getTransitById_FLight($id)
    {
        return Transit::where('transit_fl_id', $id)->get();
    }

    public static function getTransitById($id)
    {
        return Transit::where('id', $id)->first();
    }
}
