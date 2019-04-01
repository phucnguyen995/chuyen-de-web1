<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class FlightClass extends Model {

	protected $table = 'flight_class';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','fc_name'];

	public function flight_list_class()
	{
	    return $this->belongsTo('App\FlightList');
	}

	public static function getFClass(){
    	return DB::table('flight_class')->get();
    }

}
