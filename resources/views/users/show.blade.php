@extends('include.bootstrap')

@section('content')
    <h1>User Details</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Name: {{ $user->name }}</h5>
                    <p class="card-text">Email: {{ $user->email }}</p>
                    <p class="card-text">Password: {{ $user->password }}</p>
                    <a href="{{ route('users.index') }}" class="btn btn-primary">Back to Users</a>
                </div>
            </div>
        </div>
    </div>
@endsection    