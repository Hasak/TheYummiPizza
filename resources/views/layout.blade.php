<?php
/**
 * Created by PhpStorm.
 * Project: pizza
 * User: Hasak
 * Date: 6. 9. 2020.
 * Time: 15:27
 */
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{asset("favicon.ico")}}">
    <link rel="stylesheet" href="{{asset("css/icons.min.css")}}">
    <link rel="stylesheet" href="{{asset("css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{asset("css/my.css")}}">

    <title>@yield('title',"Pizza") · The Yummi Pizza</title>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <div class="mx-auto d-sm-flex d-block flex-sm-nowrap">
        <a id="logo" class="navbar-brand" href="{{asset("/")}}"><span class="fas fa-home fa-fw"></span> Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
                aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link for-active" href="{{asset("/order")}}"><span
                            class="fas fa-pizza-slice fa-fw"></span> Order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link for-active" href="{{asset("/history")}}"><span class="fas fa-history fa-fw"></span>
                        History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link for-active" href="{{asset("/account")}}"><span
                            class="fas fa-user fa-fw"></span> Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link for-active" href="{{asset("/cart")}}"><span
                            class="fas fa-shopping-cart fa-fw"></span> Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link for-active" href="{{asset("/about")}}"><span
                            class="fas fa-question-circle fa-fw"></span> About</a>
                </li>
                @if(Auth::id())
                <li class="nav-item">
                        <a class="nav-link for-active" href="{{route('logout')}}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <span class="fas fa-fw fa-sign-out-alt"></span> {{ __('Logout') }}
                        </a>
                </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link for-active" href="{{route('login')}}">
                            <span class="fas fa-fw fa-sign-in-alt"></span> {{ __('Login') }}
                        </a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link for-active" href="{{route('register')}}">
                            <span class="fas fa-fw fa-check-circle"></span> {{ __('Register') }}
                        </a>
                    </li>
                @endif
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
        </div>
    </div>
</nav>

<main role="main" class="container-fluid">
    @yield('content')
</main>
<div class="mt-5">

</div>
<footer class="bold">
    Pasteleft <span class="fa-fw fas fa-copyright"></span> {{date("Y")}}<br>
    Designed <span class="fa-fw fas fa-pencil-alt"></span> and programmed <span class="fa-fw fas fa-code"></span> by: <a
        href="https://hasak.ba" target="_blank">Himzo Hasak</a>{{--By Ananaslı--}}
</footer>

<script src="{{asset("js/jq.min.js")}}"></script>
<script src="{{asset("js/bootstrap.bundle.min.js")}}"></script>
<script src="{{asset("js/number.min.js")}}"></script>
<script src="{{asset("js/my.js")}}"></script>
</body>
</html>
