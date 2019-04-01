<?php

namespace App;

use DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'email', 'password', 'phone', 'type'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    const ADMIN_TYPE = 'admin';
    const DEFAULT_TYPE = 'default';
    
    public function isAdmin()    {        
        return $this->type === self::ADMIN_TYPE;    
    }

    public static function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public static function updateLast_Access($email)
    {
        return DB::table('users')->where('email', $email)->update(['last_access' => date('Y-m-d H:i:s')]);
    }

    public static function updateAttempt($email , $num)
    {
        return DB::table('users')->where('email', $email)->update(['attempt' => $num]);
    }
}
