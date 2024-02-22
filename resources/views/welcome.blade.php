@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4">Welcome</h1>
            <p class="lead">Start your shopping journey now!</p>
            <a class="btn btn-primary btn-lg" href="/product">Go Shopping</a>
        </div>
    </div>
</div>
@endsection

@section('my_menu')
    <li class="nav-item">
        <a class="nav-link" href="/home">Home</a>
    </li>
    @parent
@stop


