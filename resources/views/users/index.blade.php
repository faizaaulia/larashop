@extends('layouts.global')

@section('title', 'Users List')
    
@section('content')
    @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('users.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="keyword" id="keyword" value="{{ Request::get('keyword') }}" class="form-control" placeholder="Filter by email">
                    </div>
                    <div class="col-md-4">
                        <input type="radio" name="status" id="active" value="ACTIVE" {{ Request::get('status') == 'ACTIVE' ? 'checked' : '' }} class="form-control">
                        <label for="active">Active</label>
        
                        <input type="radio" name="status" id="inactive" value="INACTIVE" {{ Request::get('status') == 'INACTIVE' ? 'checked' : '' }} class="form-control">
                        <label for="inactive">Inactive</label>
        
                        <input type="submit" value="Filter" class="btn btn-primary">
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('users.create') }}" class="btn btn-primary">Create User</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr class="my-3">
    <div class="row">
        <div class="col-md-12">
            <table class="table shadow-0">
                <thead>
                    <tr>
                        <th><b>Name</b></th>
                        <th><b>Username</b></th>
                        <th><b>Email</b></th>
                        <th><b>Avatar</b></th>
                        <th><b>Status</b></th>
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
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar" width="70px">                            
                                @else
                                    No Photo
                                @endif
                            </td>
                            <td>
                                <span class="badge badge{{ $user->status == 'ACTIVE' ? '-success' : '-danger' }}">{{ $user->status }}</span>
                            </td>
                            <td>
                                <a href="{{ route('users.show', [$user->id]) }}" class="btn btn-primary btn-sm">Detail</a>
                                <a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-info text-white btn-sm">Edit</a>
                                <form action="{{ route('users.destroy', [$user->id]) }}" method="post" class="d-inline" onsubmit="return confirm('Delete user permanently?')">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        {{-- {{$users->links()}} --}}
                        <td colspan="10"> {{ $users->appends(Request::all())->links() }} </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection