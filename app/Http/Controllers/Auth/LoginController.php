<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use DB;
use Auth;
use Session;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function username()
    {
        return 'email';
    }

    public function checkLogin(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $data=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        $email = $request->email;
        $user = User::getUserByEmail($email);

        $now = date('Y-m-d H:i:s');

        $now = strtotime($now);

        if ($user != ""){
            $checkEmail = $user->count();
            $attempt =  $user->attempt;
            $timeLastAccess =  strtotime($user->last_access);
                
            if ($attempt < 3) {
                if(Auth::attempt($data)){
                    User::updateLast_Access($email);
                    User::updateAttempt($email, 0);
                    return redirect('/');

                    //return redirect(Session::get('url.intended'));
                }
                else{
                    if ($checkEmail > 0){
                        $attempt++;
                        User::updateAttempt($email, $attempt);
                        User::updateLast_Access($email);
                        return redirect('/auth/login')->withInput()->with('fail','Sai mật khẩu vui lòng nhập lại!');
                    }
                    return redirect('/auth/login')->withInput()->with('fail','Sai mật khẩu vui lòng nhập lại!');
                }
            }
            elseif ($attempt >= 3 && ($now - $timeLastAccess) < 1800){
                $t = (1800 - ($now - $timeLastAccess))/60;
                return redirect('/auth/login')->withInput()->with('fail','Bạn đã đăng nhập sai nhiều lần. Thử lại sau '. round($t,0).' phút!');
            }
            elseif ($attempt >= 3 && ($now - $timeLastAccess) > 1800){
                if(Auth::attempt($data)){
                    User::updateLast_Access($email);
                    User::updateAttempt($email, 0);
                    return redirect('/');
                    //return redirect()->back();
                }
                else{
                    if ($checkEmail > 0){
                        $attempt = 1;
                        User::updateAttempt($email, $attempt);
                        User::updateLast_Access($email);
                        return redirect('/auth/login')->withInput()->with('fail','Sai mật khẩu vui lòng nhập lại!');
                    }
                    return redirect('/auth/login')->withInput()->with('fail','Sai mật khẩu vui lòng nhập lại!');
                }
            }
        }
        else
        {
            return redirect('/auth/login')->with('fail','Sai email hoặc mật khẩu vui lòng nhập lại!');  
        }
        
    }

    public function getLogin()
    {
        return view('auth/login');
    }

}
