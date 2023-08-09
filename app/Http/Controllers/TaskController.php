<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRegisterPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Task as TaskModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CompletedTask as CompletedTaskModel;

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
         //
         return $this->singleTaskRender($task_id, 'task.detail');
     }

     /**
      * タスク編集画面
      */
     public function edit($task_id)
     {
         //task_idレコード取得(引数)
         //テンプレートへ「取得コード」情報渡す
         return $this->singleTaskRender($task_id, 'task.edit');
     }

     /**
      * 単一タスクModel取得
      */
     protected function getTaskModel($task_id)
     {
          //task_idレコード取得
         $task = TaskModel::find($task_id);
         if ($task === null) {
             return null;
         }

         //本人以外のタスクならNGに
         if ($task->user_id !== Auth::id()) {
             return null;
         }

         //
         return $task;
     }

     /**
      * 「単一のタスク」表示
      */
    protected function singleTaskRender($task_id, $template_name)
    {
        //task_idレコード取得
        $task = $this->getTaskModel($task_id);
        if ($task === null){
             return redirect('/task/list');
        }

       //テンプレートに「取得したコード」情報を渡す
       return view($template_name, ['task' => $task]);

    }

     /**
      * タスク編集処理
      */
     public function editSave(TaskRegisterPostRequest $request, $task_id)
     {
         //formからの情報取得
         $datum = $request->validated();

          //task_idレコード取得
         $task = $this->getTaskModel($task_id);
         if ($task === null) {
             return redirect('/task/list');
         }

         //レコード内容UPDATE
         $task->name = $datum['name'];
         $task->period = $datum['period'];
         $task->detail = $datum['detail'];
         $task->priority = $datum['priority'];

         //可変変数を使用した書き方
         foreach($datum as $k => $v) {
             $task->$k = $v;
         }

         //レコード更新
         $task->save();

         //タスク編集成功
         $request->session()->flash('front.task_edit_success', true);

         //詳細閲覧画面にリダイレクト
         return redirect(route('detail', ['task_id' => $task->id]));
     }

     /**
      * 削除処理
      */
     public function delete(Request $request, $task_id)
     {
         //task_idレコード取得
         $task = $this->getTaskModel($task_id);

         //タスク削除
         if ($task !== null) {
             $task->delete();
             $request->session()->flash('front.task_delete_success', true);
             }
         //一覧遷移
         return redirect('/task/list');
     }

     /**
      * タスク完了
      */
     public function complete(Request $request, $task_id)
     {
         /*タスクを完了テーブルに移動*/
         try {
             //トランザクション開始
             DB::beginTransaction();

              //task_idレコード取得
              $task = $this->getTaskModel($task_id);
              if ($task === null) {
                  //task_id不正の場合トランザクション終了
                  throw new \Exception('');
              }

              //tasks側削除
              $task->delete();
//var_dump($task->toArray()); exit;

              //complete_tasks側にinsert
              $dask_datum = $task->toArray();
              unset($dask_datum['created_at']);
              unset($dask_datum['updated_at']);
              $r = CompletedTaskModel::create($dask_datum);
              if ($r === null) {
                  //insert失敗時のトランザクション終了
                  throw new \Exception('');
              }
//echo '処理成功'; exit;

              //トランザクション終了
             DB::commit();
             
             //完了メッセージ出力
             $request->session()->flash('front.task_completed_success', true);
         } catch(\Throwable $e) {
//var_dump($e->getMessage()); exit;

             //トランザクション異常終了
             DB::rollBack();
             
             //完了失敗メッセージ出力
             $request->session()->flash('front.task_completed_failure', true);
         }

         //一覧遷移
         return redirect('/task/list');
     }

}