@extends('include.bootstrap')

@section('content')
    <div class="container">
        <h1>Create New User</h1>

        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email"></input>
            </div>
            <div class="form-group">    
                <label for="password">Pass:</label>
                <input type="password" class="form-control" name="password">
            </div>    
            <button type="submit" class="form-control btn btn-outline-info">Create User</button>
        </form>
    </div>
@endsection    