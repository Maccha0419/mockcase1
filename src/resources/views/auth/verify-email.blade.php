@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<body>
    <div class="email-content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('メールアドレスを認証しました。') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('メールアドレスに新しい認証リンクが送信されました。') }}
                            </div>
                        @endif

                        <div class="first">{{ __('ログインするために、認証リンクのあるメールを確認してください。') }}</div>
                        <div class="second">{{ __('メールが届いていない場合は、再度送信してください。') }}</div>
                        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('メールを再送信') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection