@extends('test.layout')

{{-- メインコンテンツ --}}
@section('contets')

        @if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
        @endif
        <form action="/test/input" method="post">
            @csrf
            email：<input name="email" value="{{ old('email') }}"><br>
            パスワード：<input name="password" type="password"><br>
            <button>送信する</button>
        </form>
@endsection