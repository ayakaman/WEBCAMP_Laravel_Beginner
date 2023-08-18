<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRegisterPost;
use App\Models\User as UserModel;


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
        $datum['password'] = Hash::make($datum['password']);
        //$user = Auth::user();
        //$id = Auth::id();
        //var_dump($datum, $user, $id); exit;

        //INSERT
        try {
            $r = UserModel::create($datum);
        } catch(\Throwable $e) {
            echo $e->getMessage();
            exit;
        }

        // 認証
        if (Auth::attempt($datum) === false) {
            return back()
                   ->withInput() // 入力値の保持
                   ;
        }

         //登録成功
         $request->session()->flash('front.user_register_success', true);
         return redirect('/');
    }

}