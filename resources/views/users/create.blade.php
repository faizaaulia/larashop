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
            <input type="text" name="name" id="name" class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}" placeholder="Full Name"> 
            <div class="invalid-feedback">
                {{ $errors->first('name') }}    
            </div><br>
    
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control {{ $errors->first('username') ? 'is-invalid' : '' }}" value="{{ old('username') }}" placeholder="Username"> 
            <div class="invalid-feedback">
                {{ $errors->first('username') }}    
            </div><br>
    
            <label for="roles">Roles</label> <br>
            <input type="checkbox" name="roles[]" id="ADMIN" value="ADMIN" class="form-control {{ $errors->first('roles') ? 'is-invalid' : '' }}">
            <label for="ADMIN">Administrator</label>
    
            <input type="checkbox" name="roles[]" id="STAFF" value="STAFF" class="form-control {{ $errors->first('roles') ? 'is-invalid' : '' }}">
            <label for="STAFF">Staff</label>
            
            <input type="checkbox" name="roles[]" id="CUSTOMER" value="CUSTOMER" class="form-control {{ $errors->first('roles') ? 'is-invalid' : '' }}">
            <label for="CUSTOMER">Customer</label> 
            <div class="invalid-feedback">
                {{ $errors->first('roles') }}    
            </div><br><br>
    
            <label for="phone">Phone Number</label> <br>
            <input type="text" name="phone" id="phone" class="form-control {{ $errors->first('phone') ? 'is-invalid' : '' }}" value="{{ old('phone') }}">
            <div class="invalid-feedback">
                {{ $errors->first('phone') }}    
            </div><br>
    
            <label for="address">Address</label>
            <textarea name="address" id="address" class="form-control {{ $errors->first('address') ? 'is-invalid' : '' }}">{{ old('address') }}</textarea>
            <div class="invalid-feedback">
                {{ $errors->first('address') }}    
            </div><br>
    
            <label for="avatar">Avatar Image</label>
            <input type="file" name="avatar" id="avatar" class="form-control {{ $errors->first('avatar') ? 'is-invalid' : '' }}">
            <div class="invalid-feedback">
                {{ $errors->first('avatar') }}    
            </div>
    
            <hr class="my-3">
    
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}" placeholder="user@mail.com" value="{{ old('email') }}">
            <div class="invalid-feedback">
                {{ $errors->first('email') }}    
            </div><br>
    
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control {{ $errors->first('password') ? 'is-invalid' : '' }}" placeholder="Password">
            <div class="invalid-feedback">
                {{ $errors->first('password') }}    
            </div><br>
    
            <label for="password_confirmation">Password Confirmation</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control {{ $errors->first('password_confirmation') ? 'is-invalid' : '' }}" placeholder="Password Confirmation">
            <div class="invalid-feedback">
                {{ $errors->first('password_confirmation') }}    
            </div><br>
    
            <input type="submit" value="Save" class="btn btn-primary">
        </form>
    </div>
@endsection