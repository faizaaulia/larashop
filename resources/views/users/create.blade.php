@extends('layouts.global')

@section('title', 'Create New User')

@section('content')
    <div class="col-md-8">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-sm p-3">
            @csrf
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Full Name"> <br>
    
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Username"> <br>
    
            <label for="roles">Roles</label> <br>
            <input type="checkbox" name="roles[]" id="ADMIN" value="ADMIN">
            <label for="ADMIN">Administrator</label>
    
            <input type="checkbox" name="roles[]" id="STAFF" value="STAFF">
            <label for="STAFF">Staff</label>
            
            <input type="checkbox" name="roles[]" id="CUSTOMER" value="CUSTOMER">
            <label for="CUSTOMER">Customer</label> <br> <br>
    
            <label for="phone">Phone Number</label> <br>
            <input type="text" name="phone" id="phone" class="form-control"> <br>
    
            <label for="address">Address</label>
            <textarea name="address" id="address" class="form-control"></textarea> <br>
    
            <label for="avatar">Avatar Image</label>
            <input type="file" name="avatar" id="avatar" class="form-control">
    
            <hr class="my-3">
    
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control" placeholder="user@mail.com"> <br>
    
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password"> <br>
    
            <label for="password_confirmation">Password Confirmation</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Password Confirmation"> <br>
    
            <input type="submit" value="Save" class="btn btn-primary">
        </form>
    </div>
@endsection