@extends('layouts.main')
@section('content')
    @foreach ($contests as $contest)
        <div>{{$contest -> id}} - {{$contest -> user_id}} </div>    
    @endforeach
    <a href="./characters">Characters</a>    
@endsection