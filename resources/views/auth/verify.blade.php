@extends('layout')
@section('title')Verify Email @endsection
@section('content')
    <div class="row">
        <div class="col c">
            <h1 class="display-4"><span class="fas fa-unlock fa-fw"></span> Verify Email</h1>
            <p class="lead">To continue please verify your email address</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="mt-5" class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
</div>
@endsection
