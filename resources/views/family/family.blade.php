@extends('layouts.app')

@section('panel-title')
    {{ Auth::User()->name }}'s family . | <span id="total-ip">@{{ Math.floor(totalIP) }}</span> IP
@endsection

@section('content')
We are family
    <h4>Family workers:</h4>
    <ul>
    @foreach(Auth::user()->soldiers->sortByDesc('influence_per_minute') as $soldier)
        <li>{{ $soldier->name }} || Influence per minute: {{ $soldier->influence_per_minute }}</li>
    @endforeach
    </ul>
    {!! Form::open(['url' => 'family/newSoldier']) !!}
        {!! Form::submit('Get new soldier', ['class' => 'btn btn-primary form-control']) !!}
    {!! Form::close() !!}

@endsection