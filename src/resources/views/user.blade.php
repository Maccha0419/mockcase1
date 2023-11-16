@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('content')
<div class="user__alert">
<!-- 　メッセージ機能 -->
</div>


<div class="user__content">
    <div class="user-form__heading">
        <h2>ユーザー一覧</h2>
    </div>
    <div class="user-table">
        <div class="user__inner">
            @foreach ($users as $user)
            <form class="card__button" action="/user_information" method="post">
                @csrf
                <button class="card">
                    <div class="card__inner">
                        <p class="id">{{ $user->id }}</p>
                        <input name="id" type="hidden" value="{{ $user->id }}">
                        <p class="name">{{ $user->name }}</p>
                        <input name="name" type="hidden" value="{{ $user->name }}">
                        <p class="email">{{ $user->email }}</p>
                        <input name="email" type="hidden" value="{{ $user->email }}">
                    </div>
                </button>
            </form>
            @endforeach
        </div>
        <div class="paginate">
            {{ $users->appends(request()->query())->links('vendor.pagination.tailwind2') }}
            <!-- ページネーションのリンクにクエリ文字列が付与されていない場合、ページ遷移後に入力された値がクリアされる -->
            <!-- appendsに追加した文字列がページネーションの各リンクに追加 query()でクエリ文字のみ取得-->
        </div>
    </div>
</div>
@endsection