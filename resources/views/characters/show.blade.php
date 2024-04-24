@extends('layouts.main')
@section('content')
    @foreach ($chracters as $c)
        {{$c -> name}}
    @endforeach
@show