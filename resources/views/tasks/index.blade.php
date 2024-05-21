@extends('include.bootstrap')

@section('content')

    <div class="container">
        <h2 class="mt-4">Laravel Ajax CRUD with Bootstrap Modal</h2>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#taskModal">Create New Task</button>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr id="task_{{ $task->id }}">
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>
                            <button data-id="{{ $task->id }}" class="btn btn-info edit-btn">Edit</button>
                            <button data-id="{{ $task->id }}" class="btn btn-danger delete-btn">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="taskForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="taskModalLabel">Create Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="task_id" name="task_id">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    $(document).ready(function() {
        // CSRF Token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Open modal for creating a new task
        $('#taskModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
            var id = button.data('id')

            if (id) {
                $.get('tasks/' + id, function (data) {
                    modal.find('.modal-title').text('Edit Task')
                    modal.find('#task_id').val(data.id)
                    modal.find('#title').val(data.title)
                    modal.find('#description').val(data.description)
                })
            } else {
                modal.find('.modal-title').text('Create Task')
                modal.find('#task_id').val('')
                modal.find('#taskForm')[0].reset()
            }
        });

        // Save task
        $('#taskForm').submit(function (event) {
            event.preventDefault()
            var formData = $(this).serialize()
            var id = $('#task_id').val()

            if (id) {
                // Update existing task
                $.ajax({
                    url: 'tasks/' + id,
                    type: 'PUT',
                    data: formData,
                    success: function (data) {
                        $('#taskModal').modal('hide')
                        $('#task_' + id).html(`
                            <td>${data.id}</td>
                            <td>${data.title}</td>
                            <td>${data.description}</td>
                            <td>
                                <button data-id="${data.id}" class="btn btn-info edit-btn">Edit</button>
                                <button data-id="${data.id}" class="btn btn-danger delete-btn">Delete</button>
                            </td>
                        `)
                    }
                })
            } else {
                // Create new task
                $.post('tasks', formData, function (data) {
                    $('#taskModal').modal('hide')
                    $('table tbody').append(`
                        <tr id="task_${data.id}">
                            <td>${data.id}</td>
                            <td>${data.title}</td>
                            <td>${data.description}</td>
                            <td>
                                <button data-id="${data.id}" class="btn btn-info edit-btn">Edit</button>
                                <button data-id="${data.id}" class="btn btn-danger delete-btn">Delete</button>
                            </td>
                        </tr>
                    `)
                })
            }
        });

        // Edit task
        $(document).on('click', '.edit-btn', function () {
            var id = $(this).data('id')
            $('#taskModal').modal('show')
            $('#taskForm').trigger('reset')
            $('#task_id').val(id)
        });

        // Delete task
        $(document).on('click', '.delete-btn', function () {
            var id = $(this).data('id')
            $.ajax({
                url: 'tasks/' + id,
                type: 'DELETE',
                success: function () {
                    $('#task_' + id).remove()
                }
            })
        });
    });
    </script>
@endsection
