@extends('layouts.master')
@section('content')
    <!-- ملف admin_page_post.blade.php -->
    @if (session('add_success'))
        <div class="alert alert-success">
            {{ session('add_success') }}
        </div>
    @endif
    @if (session('delete_success'))
        <div class="alert alert-success">
            {{ session('delete_success') }}
        </div>
    @endif

    <div class="container mt-5">
        <h2 class="mb-4">Tags Table</h2>
        <button class="btn btn-primary mb-4" onclick="toggleForm()">Add New Tag</button>
        <div id="newTagForm" style="display: none;">
            <form action="{{ route('tags.add') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="newtag">Tag Name:</label>
                    <input type="text" name="newtag" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Add Tag</button>
            </form>
        </div>
        @if($utag->isEmpty())
            <h3>No tags suggested</h3>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Add</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($utag as $tag)
                    <tr>
                        <td>{{ $tag->tag_name }}</td>
                        <td>
                            <form action="{{ route('tags.users.add', ['newtag' => $tag->tag_name]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Accept</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('tags.delete', ['name' => $tag->tag_name]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <script>
        function toggleForm() {
            var form = document.getElementById('newTagForm');
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
        }
    </script>
@endsection
