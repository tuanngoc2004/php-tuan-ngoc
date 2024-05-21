@extends('include.bootstrap')

@section('content')
    <div class="container">
        <h1>Edit User</h1>
        <form method="POST" action="{{ route('users.update', ['id' => $user->id]) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name"> Name:</label>
                <input type="text" class="form-control" name="name" value="{{ $user->name }}">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" value="{{ $user->email }}" />
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" value="{{ $user->password }}">
            </div>
            <button type="submit" class="form-control btn btn-outline-info">Update User</button>
        </form>
    </div>
@endsection