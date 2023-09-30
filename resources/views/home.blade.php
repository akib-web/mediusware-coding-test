@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row justify-content-start">
        <div class="col-md-3">
            <nav class="navbar bg-light">
                <ul class="navbar-nav">
                  <li class="nav-item trnsaction_btn pb-2">
                    <a class="btn btn-primary" href="{{route('transactions')}}">Transactions</a>
                  </li>
                  <li class="nav-item pb-2">
                    <a class="btn btn-primary" href="{{route('deposit')}}">Deposit</a>
                  </li>
                  <li class="nav-item pb-2">
                    <a class="btn btn-primary" href="{{route('withdraw')}}">Withdraw</a>
                  </li>
                </ul>
              </nav>
        </div>
        <div class="col-md-9">
            @yield('page_content')
        </div>
    </div>
</div>
@endsection
