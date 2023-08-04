<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    /**
     * トップページ を表示する
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('welcome');
    }

    /**2ndページ　を表示する
     *
     * @return \Illuminate\View\View
     */
    public function second()
    {
        return view('welcome_second');
    }
}
