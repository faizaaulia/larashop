@extends('layouts.global')

@section('title', 'Users List')
    
@section('content')
    <table class="table shadow-0">
        <thead>
            <tr>
                <th><b>Name</b></th>
                <th><b>Username</b></th>
                <th><b>Email</b></th>
                <th><b>Avatar</b></th>
                <th><b>Actions</b></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->avatar }}" width="70px">                            
                        @else
                            No Photo
                        @endif
                    </td>
                    <td>TODO: actions</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection