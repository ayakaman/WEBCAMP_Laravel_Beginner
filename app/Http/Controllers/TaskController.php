<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRegisterPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Task as TaskModel;

class TaskController extends Controller
{
    /**
     * タスク一覧ページ を表示する
     *
     * @return \Illuminate\View\View
     */
    public function list()
    {
        //1Pageあたり表示アイテム数を設定
        $per_page = 5;

        //一覧取得
        $list = TaskModel::where('user_id', Auth::id())
                         ->orderBy('priority', 'DESC')
                         ->orderBy('period')
                         ->orderBy('created_at')
                         ->paginate($per_page);
                         // ->get();
/*
$sql = TaskModel::where('user_id', Auth::id())
                ->orderBy('priority', 'DESC')
                ->orderBy('period')
                ->orderBy('created_at')
                ->toSql();
//echo "<pre>\n"; var_dump($sql, $list); exit;
var_dump($sql);
*/

        //
        return view('task.list', ['list' => $list]);
    }
     /**
     * タスクの新規登録
     */
     public function register(TaskRegisterPostRequest $request)
     {
         // validate済みのデータの取得
        $datum = $request->validated();
        //
        //$user = Auth::user();
        //$id = Auth::id();
        //var_dump($datum, $user, $id); exit;

        //user_id追加
        $datum['user_id'] = Auth::id();

        //テーブルへのINSERT
        try {
            $r = TaskModel::create($datum);
        } catch(\Throwable $e) {
            //XX　本当はログに書く等の処理。今回は一端のみ出力
            echo $e->getMessage();
            exit;
        }

        //タスク登録成功
        $request->session()->flash('front.task_register_success', true);

        //
        return redirect('/task/list');

     }

     /**
      * タスク詳細閲覧
      */
     public function detail($task_id)
     {
         //task_id レコード取得
         $task = TaskModel::find($task_id);
         if ($task === null) {
             return redirect('/task/list');
         }
         //本人以外のタスクならNGに
         if ($task->user_id !== Auth::id()) {
             return redirect('/task/list');
         }


         //テンプレートに「取得したレコード」情報渡す
         return view('task.detail', ['task' => $task]);

     }
}