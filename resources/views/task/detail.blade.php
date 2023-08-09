@extends('layout')

{{-- タイトル --}}
@section('title')(詳細画面)@endsection

{{-- メインコンテンツ --}}
@section('contets')
        <h1>タスク詳細閲覧</h1>
        タスク名:{{ $task->name }}<br>
        期限:{{ $task->period}}<br>
        重要度:{{ $task->getPriorityString() }}<br>
        タスク詳細: <pre>{{ $task->detail }}</pre><br>
        <hr>
        <menu label="リンク">
        <a href="/task/list">タスク一覧</a>
        <a href="/logout">ログアウト</a><br>
        </menu>
@endsection