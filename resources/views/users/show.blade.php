@extends('layouts.global')

@section('title', 'User Detail')

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <b>Name:</b> <br>
                {{ $user->name }} <br><br>

                @if ($user->avatar)
                    <img src="{{ asset('storage/'. $user->avatar) }}" alt="avatar" width="128px">
                @else
                    No Avatar
                @endif <br> <br>

                <b>Email:</b> <br>
                {{ $user->email }} <br> <br>

                <b>Phone Number:</b> <br>
                {{ $user->phone }} <br> <br>

                <b>Address:</b> <br>
                {{ $user->address }} <br> <br>

                <b>Roles:</b> <br>
                @foreach (json_decode($user->roles) as $role)
                    &middot; {{ $role }} <br>
                @endforeach
            </div>
        </div>
    </div>
@endsection