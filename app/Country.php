<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Country extends Model {

	protected $table = 'countries';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','country_name', 'country_code'];

	public static function getCountries(){
    	return DB::table('countries')->get();
	}

}