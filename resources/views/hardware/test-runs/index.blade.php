@extends('layouts/default')
@section('title')
Test runs
@parent
@stop
@section('content')
<div class="container">
    <ul class="list-group">
        @foreach($runs as $run)
            <li class="list-group-item">
                {{ $run->created_at }} - {{ $run->status }}
            </li>
        @endforeach
    </ul>
</div>
@stop
