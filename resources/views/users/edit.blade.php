@extends('layouts.global')

@section('title', 'Edit User')
    
@section('content')
    <div class="col-md-8">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('users.update',[$user->id]) }}" method="post" enctype="multipart/form-data" class="bg-white shadow-sm p-3">
            @csrf
            <input type="hidden" name="_method" value="put">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}" placeholder="Full Name" value="{{ old('name') ? old('name') : $user->name }}"> 
                <div class="invalid-feedback">
                    {{ $errors->first('name') }}
                </div><br>
        
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="{{ $user->username }}" disabled> <br>

                <label for="status">Status</label> <br>
                <input type="radio" name="status" id="active" class="form-control" value="ACTIVE" {{ $user->status == 'ACTIVE' ? 'checked' : '' }}>
                <label for="active">Active</label>

                <input type="radio" name="status" id="inactive" class="form-control" value="INACTIVE" {{ $user->status == 'INACTIVE' ? 'checked' : '' }}>
                <label for="inactive">Inctive</label> <br> <br>
        
                <label for="roles">Roles</label> <br>
                <input type="checkbox" name="roles[]" id="ADMIN" value="ADMIN" {{ in_array('ADMIN', json_decode($user->roles)) ? 'checked' : '' }} class="form-control {{ $errors->first('roles') ? 'is-invalid' : '' }}">
                <label for="ADMIN">Administrator</label>
        
                <input type="checkbox" name="roles[]" id="STAFF" value="STAFF" {{ in_array('STAFF', json_decode($user->roles)) ? 'checked' : '' }} class="form-control {{ $errors->first('roles') ? 'is-invalid' : '' }}">
                <label for="STAFF">Staff</label>
                
                <input type="checkbox" name="roles[]" id="CUSTOMER" value="CUSTOMER" {{ in_array('CUSTOMER', json_decode($user->roles)) ? 'checked' : '' }} class="form-control {{ $errors->first('roles') ? 'is-invalid' : '' }}">
                <label for="CUSTOMER">Customer</label> 
                <div class="invalid-feedback">
                    {{ $errors->first('roles') }}
                </div><br> <br>
        
                <label for="phone">Phone Number</label> <br>
                <input type="text" name="phone" id="phone" class="form-control {{ $errors->first('phone') ? 'is-invalid' : '' }}" value="{{ old('phone') ? old('phone') : $user->phone }}"> 
                <div class="invalid-feedback">
                    {{ $errors->first('phone') }}
                </div><br>
        
                <label for="address">Address</label>
                <textarea name="address" id="address" class="form-control {{ $errors->first('address') ? 'is-invalid' : '' }}">{{ old('address') ? old('address') : $user->address }}</textarea> 
                <div class="invalid-feedback">
                    {{ $errors->first('address') }}
                </div><br>
        
                <label for="avatar">Avatar Image</label><br>
                Current Avatar: <br>
                @if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar" width="120px">
                @else
                    No Avatar
                @endif <br>
                <input type="file" name="avatar" id="avatar" class="form-control">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah avatar</small>
        
                <hr class="my-3">
        
                <label for="email">Email</label>
                <input type="text" name="email" id="email" class="form-control" placeholder="user@mail.com" value="{{ $user->email }}" disabled> <br>

                <input type="submit" value="Update" class="btn btn-primary">
        </form>
    </div>
@endsection