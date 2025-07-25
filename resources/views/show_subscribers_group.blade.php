@extends('layouts.master')

@section('content')
    <div class="container">
        <h1 class="my-4">All Subscribers</h1>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Group Name</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($allSubscribers as $all)
                <tr>
                    <td>{{ $all->id }}</td>
                    <td>
                        {{ $all->name }}
                        <div class="mt-2">
                            <a href="{{ route('profile', $all->id) }}" class="btn btn-info btn-sm" title="Visit Profile">
                                Visit
                            </a>
                        </div>
                    </td>
                    <td>
                        @if($group)
                            {{ $group->name }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if($all->groups->first()->pivot->is_admin == 1)
                            Admin
                        @else
                            Member
                        @endif
                    </td>
                    @if($all->groups->first()->pivot->is_admin == 0)
                        <td>
                            @if($all->groups->first()->pivot->is_admin == 1)
                                <a href="{{ route('delete.admin', ['id' => $all->id, 'group_id' => $all->groups->first()->pivot->group_id]) }}"
                                   onclick="event.preventDefault(); if(confirm('Are you sure?')) { window.location.href='{{ route('delete.admin', ['id' => $all->id, 'group_id' => $all->groups->first()->pivot->group_id]) }}'; }"
                                   class="btn btn-warning btn-sm">Revoke Admin</a>
                            @else
                                <a href="{{ route('add.or.delete.user.group', ['id' => $all->id, 'group_id' => $all->groups->first()->pivot->group_id, 'task_id' => 1]) }}"
                                   onclick="event.preventDefault(); if(confirm('Are you sure?')) { window.location.href='{{ route('add.or.delete.user.group', ['id' => $all->id, 'group_id' => $all->groups->first()->pivot->group_id, 'task_id' => 1]) }}'; }"
                                   class="btn btn-success btn-sm">Add as Admin</a>
                            @endif
                            @if($all->groups->first()->pivot->is_admin == 0)
                                <a href="{{ route('add.or.delete.user.group', ['id' => $all->id, 'group_id' => $all->groups->first()->pivot->group_id, 'task_id' => 0]) }}"
                                   onclick="event.preventDefault(); if(confirm('Are you sure?')) { window.location.href='{{ route('add.or.delete.user.group', ['id' => $all->id, 'group_id' => $all->groups->first()->pivot->group_id, 'task_id' => 0]) }}'; }"
                                   class="btn btn-danger btn-sm">Delete User</a>
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
