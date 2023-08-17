<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CompletedTask as CompletedTaskModel;


class CompletedTaskController extends Controller
{
    /**
     * 一覧用インスタンス取得（Illuminate\Database\Eloquent\Builder）
     */
    protected function getListBuilder()
    {
        return CompletedTaskModel::where('user_id', Auth::id())
                         ->orderBy('priority', 'DESC')
                         ->orderBy('period')
                         ->orderBy('created_at');
    }

    /**
     *  タスク一覧ページ表示
     *
     * @return \Illuminate\View\View
     */
    public function list()
    {
        //page
        $per_page = 5;

        //一覧取得
        $list = $this->getListBuilder()
                     ->paginate($per_page);
/*
$sql = $this->getListBuilder()
              ->toSql();
echo "<pre>\n"; var_dump($sql, $list); exit;
var_dump($sql);
*/
        return view('task.completed_list', ['list' => $list]);
    }
}