<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Airline extends Model {

	protected $table = 'airlines';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','airline_name', 'airline_code', 'airline_country_id'];

  public static function getAirline(){
    return DB::table('airlines')->get();
	}
	
	public static function getAirline_by_country_code($country_id1, $country_id2){
		if ($country_id2 != "")
		{
			$airport = DB::table('airlines')->where('airline_country_id' , $country_id1)->orWhere('airline_country_id' , $country_id2)->get();
		}
		else{
			$airport = DB::table('airlines')->where('airline_country_id' , $country_id1)->get();
		}
		return $airport;
		
    }

}
