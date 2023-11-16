@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user_information.css') }}">
@endsection

@section('content')
<div class="user__alert">
<!-- 　メッセージ機能 -->
</div>


<div class="user__content">
    <div class="user-form__heading">
        <h2>{{$user_name}}</h2>
    </div>
    <div class="attendance-table">
        <table class="attendance-table__inner">
            <tr class="attendance-table__row">
                <th class="attendance-table__header">勤務日</th>
                <th class="attendance-table__header">勤務開始</th>
                <th class="attendance-table__header">勤務終了</th>
                <th class="attendance-table__header">休憩時間</th>
                <th class="attendance-table__header">勤務時間</th>
            </tr>
            @foreach ($user_dates as $user_date)
                <tr class="attendance-table__row">
                    <td class="attendance-table__item">{{$user_date->stamp_date}}</td>
                    <td class="attendance-table__item">{{$user_date->start_work}}</td>
                    <td class="attendance-table__item">{{$user_date->end_work}}</td>
                    <td class="attendance-table__item">{{$user_date->total_rest}}</td>
                    <td class="attendance-table__item">{{$user_date->total_work}}</td>
                </tr>
            @endforeach
        </table>
        <div class="paginate">
            {{ $user_dates->links('vendor.pagination.tailwind2') }}
            <!-- ページネーションのリンクにクエリ文字列が付与されていない場合、ページ遷移後に入力された値がクリアされる -->
            <!-- appendsに追加した文字列がページネーションの各リンクに追加 query()でクエリ文字のみ取得-->
        </div>
    </div>
</div>
@endsection