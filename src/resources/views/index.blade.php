@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="attendance__alert">
<!-- 　メッセージ機能 -->
</div>

<div class="attendance__content">
    <div class="attendance-form__heading">
        <h2>{{ $user->name }}さんお疲れ様です！</h2>
    </div>
    <div class="attendance__panel">
        <form class="attendance__button" action="/start_work" method="post" id="form1">
            @csrf
            <button class="attendance__button-submit" @if($disabled_start_work) disabled='disabled' @endif>勤務開始</button>
        </form>
        <form class="attendance__button" action="/end_work" method="post" id="form2">
            @csrf
            <button class="attendance__button-submit" type="submit" @if($disabled_end_work) disabled='disabled' @endif>勤務終了</button>
        </form>
        <form class="attendance__button" action="/start_rest" method="post" id="form3">
            @csrf
            <button class="attendance__button-submit" type="submit" @if($disabled_start_rest) disabled='disabled' @endif>休憩開始</button>
        </form>
        <form class="attendance__button" action="/end_rest" method="post" id="form4">
            @csrf
            <button class="attendance__button-submit" type="submit" @if($disabled_end_rest) disabled='disabled' @endif>休憩終了</button>
        </form>
    </div>
</div>
@endsection