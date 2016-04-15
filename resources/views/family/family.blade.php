@extends('layouts.app')
@section('panel-title')
    {{ Auth::User()->name }}'s family . | <span id="total-ip">@{{ Math.floor(totalIP) }}</span> IP | Influence per second: @{{ incrementPS.toFixed(2) }}
@endsection

@section('content')
    <h4>Family workers:</h4>
    <ul>
        <soldier-li token='{{ Session::token() }}' v-for="soldier in soldiersList | orderBy 'influence_per_minute' -1" :soldier="soldier"></soldier-li>
    </ul>

    <button-token token='{{ Session::token() }}'></button-token>

@endsection


<template id="button-with-token">
    <button v-on:click="postNewSoldier()" class="btn btn-primary">New Soldier</button>
</template>

<template id="soldierLi">
    <li>
        @{{ soldier.name }} || Influence per minute: @{{ soldier.influence_per_minute }} <span v-on:click="deleteSoldier(soldier)" class="glyphicon glyphicon-remove removeSoldierGliph"></span>
    </li>
</template>