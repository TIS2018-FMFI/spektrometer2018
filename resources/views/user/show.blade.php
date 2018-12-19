@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="text-center col-sm-4">
                <h3> {{ $user->user_name }} </h3>
                <img class="img-fluid mb-4" src="{{ url('images/'.$user->image)}}"  alt="{{ $user->user_name }}">
                @if(\App\User::currentChallenge($user) && $currentAuthUser->id == $user->id)
                    <a class="btn btn-primary" href="/challenges/{{\App\User::currentChallenge($user)->id}}">Aktuálna výzva</a>
                @endif
                @if($currentAuthUser->id !== $user->id && $user->countOfChallengesAsAsked() < 3)
                    <a class="btn btn-secondary" href="/challenges/store">Vyzvať!</a>
                @endif

                <h5>Aktuálna pozícia: {{ $user->position }}.</h5>
                @if($currentAuthUser->isRedactor)
                    <p>
                        <strong>Meno: </strong>{{ $user->first_name }}<br>
                        <strong>Priezvisko: </strong>{{ $user->last_name }}<br>
                        <strong>e-mail: </strong>{{ $user->email }}<br>
                    </p>
                    @if($currentAuthUser->id !== $user->id)
                        @if($user->deleted_at == null)
                            <a href="/users/{{$user->id}}/destroy" class="btn btn-primary">Deaktivácia hráča!</a>
                        @endif
                    @endif
                @endif
            </div>
            <div class="col-sm-8">
                <div class="row">
                    <div class="offset-1 text-center col-sm-11">
                        <div class="row">
                            <div class="col-4 font-weight-bold">Súper</div>
                            <div class="col-8">
                                <div class="row mb-4">
                                    <div class="col-4 font-weight-bold">Dátum zápasu</div>
                                    <div class="col-2 font-weight-bold">Set1</div>
                                    <div class="col-2 font-weight-bold">Set2</div>
                                    <div class="col-2 font-weight-bold">Set3</div>
                                    <div class="col-2 font-weight-bold">Výherca</div>
                                </div>
                            </div>
                        </div>
                            @foreach($matches as $match)
                            <div class="row mb-4">
                                <div class="col-4">
                                    @if($user->id == $match->challenge->challenger->id)
                                        <a href="/users/{{$match->challenge->asked->id}}">{{$match->challenge->asked->user_name}}</a>
                                    @else
                                        <a href="/users/{{$match->challenge->challenger->id}}">{{$match->challenge->challenger->user_name}}</a>
                                    @endif
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        <div class="col-4">{{$match->date}}</div>
                                        @foreach($match->sets as $set)
                                            @if($user->id == $match->challenge->challenger->id)
                                                <div class="col-2">{{$set->score_1}}:{{$set->score_2}}</div>
                                            @else
                                                <div class="col-2">{{$set->score_2}}:{{$set->score_1}}</div>
                                            @endif
                                        @endforeach
                                        @if(sizeof($match->sets) == 2)
                                            <div class="col-2">0:0</div>
                                        @endif
                                        @if($user->id == $match->winner->id)
                                            <div class="col-2">✓</div>
                                        @else
                                            <div class="col-2">✗</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection