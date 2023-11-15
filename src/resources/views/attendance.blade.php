@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<div class="attendance__alert">
<!-- 　メッセージ機能 -->
</div>


<div class="attendance__content">
    <div class="attendance__date">
        <form class="attendance__button-left" action="/attendance/next_date" method="get">
            @csrf
            <input name="next_date" type="hidden" value={{$date}}>
            <button class="attendance__date__button-left"></button>
        </form>
        <p class="attendance__date-middle">{{$date}}</p>
        <form class="attendance__button-right" action="/attendance/previous_date" method="get">
            @csrf
            <input name="previous_date" type="hidden" value={{$date}}>
            <button class="attendance__date__button-right"></button>
        </form>
    </div>

    <div class="attendance-table">
        <table class="attendance-table__inner">
            <tr class="attendance-table__row">
                <th class="attendance-table__header">名前</th>
                <th class="attendance-table__header">勤務開始</th>
                <th class="attendance-table__header">勤務終了</th>
                <th class="attendance-table__header">休憩時間</th>
                <th class="attendance-table__header">勤務時間</th>
            </tr>
            @foreach ($users as $user)
                <tr class="attendance-table__row">
                    <td class="attendance-table__item">{{$user->name}}</td>
                    <td class="attendance-table__item">{{$user->start_work}}</td>
                    <td class="attendance-table__item">{{$user->end_work}}</td>
                    <td class="attendance-table__item">{{$user->total_rest}}</td>
                    <td class="attendance-table__item">{{$user->total_work}}</td>
                </tr>
            @endforeach
        </table>
        <div class="paginate">
            {{ $users->appends(request()->query())->links('vendor.pagination.tailwind2') }}
            <!-- ページネーションのリンクにクエリ文字列が付与されていない場合、ページ遷移後に入力された値がクリアされる -->
            <!-- appendsに追加した文字列がページネーションの各リンクに追加 query()でクエリ文字のみ取得-->
        </div>
    </div>
</div>
@endsection