<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterPost;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * トップページ を表示する
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('/user/register');
    }


     /**
     * 入力受取
     */
    public function register(UserRegisterPost $request)
    {
        // validate済

        // データの取得
        $datum = $request->validated();
        //var_dump($datum); exit;

        // 認証
        if (Auth::attempt($datum) === false) {
            return back()
                   ->withInput() // 入力値の保持
                   ;
        }

        //
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

}