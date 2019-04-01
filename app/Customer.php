<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Customer extends Model {

	protected $table = 'customers';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','customer_user_id', 'customer_first_name', 'customer_last_name', 'customer_title', 'customer_transfer', 'customer_paypal', 'customer_credit_card', 'customer_credit_name', 'customer_credit_ccv', 'token'];

	public function user()
    {
        return $this->hasOne('App\City', 'id', 'customer_user_id');
	}
	
	public static function getCus_by_book_id($book_id)
    {
		return DB::table('customers')->where('customer_book_id' , $book_id)->get();
	}
}
