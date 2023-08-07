@extends('test.layout')

{{-- メインコンテンツ --}}
@section('contets')

        email：{{ $datum['email'] }}<br>
        パスワード：{{ $datum['password'] }}<br>

@endsection