@extends('layouts.app')
@section('panel-title')
    {{ Auth::User()->name }}'s family . | <span id="total-ip">@{{ Math.floor(totalIP) }}</span> IP | Influence per second: @{{ incrementPS.toFixed(2) }}
@endsection

@section('content')
    <h4>Family workers:</h4>
    <ul>
        <soldier-li token='{{ Session::token() }}' v-for="soldier in soldiersList | orderBy 'influence_per_minute' -1" :soldier="soldier">
        </soldier-li>
    </ul>

    <button-token token='{{ Session::token() }}'></button-token>

    <my-modal></my-modal>

@endsection


<template id="button-with-token">
    <button v-on:click="postNewSoldier()" class="btn btn-primary">New Soldier</button>
</template>

<template id="soldierLi">
    <li v-on:click="sendMessageToParent" role="button" data-toggle="modal" data-target="#myModal">
        @{{ soldier.name }} || Influence per minute: @{{ soldier.influence_per_minute }} <span v-on:click="deleteSoldier(soldier)" class="glyphicon glyphicon-remove removeSoldierGliph"></span>
    </li>
</template>

<template id="modal-template">
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 style="text-align: center" class="modal-title">@{{$parent.$data.activeSoldier.name}}</h4>
                </div>
                <div class="modal-body" style="text-align: center">
                    {!! Html::image('img/picciotto.jpg') !!}
                    <p>Influence per minute: @{{ $parent.$data.activeSoldier.influence_per_minute }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</template>