@extends('include.bootstrap')

@section('content')

    <div class="container">
        <h2 class="mt-4">User</h2>
        <a href="{{ route('users.create') }}" class="btn btn-success">Create New User</a>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->password }}</td>

                        <td>
                            <div class="btn-group">
                            <a class="btn btn-sm btn-info mr-3" href="{{ route('users.show', ['id' => $user->id]) }}">Detail</a>
                            <a class="btn btn-sm btn-primary mr-3" href="{{ route('users.edit', ['id' => $user->id]) }}">Edit</a>
                            <form method="POST" action="{{ route('users.destroy', ['id' => $user->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                        </td>
                    </tr>
                    <hr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection