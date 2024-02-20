@extends('layouts.app')
@section('content')
    <h1>Product</h1>
@endsection

@section('my_menu')
    <li class="nav-item">
        <a class="nav-link" href="/home">回控制台</a>
    </li>
    @parent
@stop