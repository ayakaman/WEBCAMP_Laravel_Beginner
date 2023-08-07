<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;

class AuthController extends Controller
{
    /**
     * トップページ を表示する
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('index');
    }

    /**
     * ログイン処理
     *
     */
    public function login(LoginPostRequest $request)
    {
        //validate済

        //データ取得
        $datum = $request->validated();

        //
        var_dump($datum); exit;
    }
}