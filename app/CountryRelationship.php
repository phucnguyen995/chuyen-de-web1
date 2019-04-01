<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class CountryRelationship extends Model {

	protected $table = 'countries_relationship';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'country_id_one', 'country_id_two', 'relationship'];

	public static function getCountries_relationship($country_one, $country_two){
    	return DB::table('countries_relationship')->where('country_id_one', $country_one)->where('country_id_two', $country_two)->first();
	}

}