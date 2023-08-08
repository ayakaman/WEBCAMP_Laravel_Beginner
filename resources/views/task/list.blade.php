@extends('layout')

{{-- タイトル --}}
@section('title')(詳細画面)@endsection

{{-- メインコンテンツ --}}
@section('contets')
        <h1>タスクの登録</h1>
            @if (session('front.task_register_success') == true)
                タスク登録しました！<br>
            @endif
            @if ($errors->any())
                 <div>
                 @foreach ($errors->all() as $error)
                      {{ $error }}<br>
                 @endforeach
                 </div>
            @endif
            <form action="/task/register" method="post">
                @csrf
                タスク名:<input name="name" value="{{ old('name') }}"><br>
                期限:<input name="period" type="date" value="{{ old('period') }}"><br>
                タスク詳細:<textarea name="detail">{{ old('detail') }}</textarea><br>
                重要度:<label><input type="radio" name="priority" value="1" @if (old('priority') == 1) checked @endif>低い</label> /
                    <label><input type="radio" name="priority" value="2" @if (old('priority', 2) == 2) checked @endif>普通</label> /
                    <label><input type="radio" name="priority" value="3" @if (old('priority') == 3) checked @endif>高い</label><br>
                <button>タスクを登録する</button>
            </form>

        <h1>タスクの一覧(未実装)</h1>
        <a href="./top.html">CSVダウンロード(未実装)</a><br>
        <table border="1">
        <tr>
            <th>タスク名
            <th>期限
            <th>重要度
        <tr>
            <td>HTML formの学習
            <td>2022/01/01
            <td>普通
            <td><a href="./detail.html">詳細閲覧</a>
            <td><a href="./edit.html">編集</a>
            <td><form action="./top.html"><button>完了</button></form>
        <tr>
            <td>PHPの学習
            <td>2022/01/15
            <td>普通
            <td><a href="./detail.html">詳細閲覧</a>
            <td><a href="./edit.html">編集</a>
            <td><form action="./top.html"><button>完了</button></form>
        <tr>
            <td>RDBの学習
            <td>2022/02/01
            <td>普通
            <td><a href="./detail.html">詳細閲覧</a>
            <td><a href="./edit.html">編集</a>
            <td><form action="./top.html"><button>完了</button></form>
        <tr>
            <td>Laravelの学習
            <td>2022/02/15
            <td>普通
            <td><a href="./detail.html">詳細閲覧</a>
            <td><a href="./edit.html">編集</a>
            <td><form action="./top.html"><button>完了</button></form>
        </table>
        <!-- ページネーション -->
        現在 1 ページ目<br>
        <a href="./top.html">最初のページ(未実装)</a> /
        <a href="./top.html">前に戻る(未実装)</a> /
        <a href="./top.html">次に進む(未実装)</a>
        <br>
        <hr>
        <menu label="リンク">
        <a href="/logout">ログアウト</a><br>
        </menu>
@endsection