@extends('layouts.master')

@section('content')
    <div class="container">



        <h1 class="my-4">
            <h1 class="my-4">{{ $NameRole }}</h1>
        </h1>
        <div class="dropdown">
            <button class="dropdown-btn">Select Role</button>
            <div class="dropdown-content">
                <a href="{{ route('show.users', ['role_id' => 0]) }}">All Users</a>
                <a href="{{ route('show.users', ['role_id' => 1]) }}">Superadmin</a>
                <a href="{{ route('show.users', ['role_id' => 2]) }}">Admins</a>
                <a href="{{ route('show.users', ['role_id' => 3]) }}">Coaches</a>
                <a href="{{ route('show.users', ['role_id' => 4]) }}">Trainees</a>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="usersTableBody">
            @if($users->isEmpty())
                <tr>
                    <td colspan="4" class="text-center text-muted">No users found for the selected role.</td>
                </tr>
            @else
                @foreach($users as $user)
                    @if(Auth::user()->role_id == 1)
                        <tr data-role-id="{{ $user->role_id }}">
                            <td>{{ $user->id }}</td>
                            <td>
                                {{ $user->name }}
                                <div class="mt-2">
                                    <a href="{{ route('profile', $user->id) }}" class="btn btn-info btn-sm" title="Visit Profile">
                                        <i class="bi bi-person"></i> Visit
                                    </a>
                                </div>
                            </td>
                            <td>
                                @switch($user->role_id)
                                    @case(1)
                                    Superadmin
                                    @break
                                    @case(2)
                                    Admin
                                    @break
                                    @case(3)
                                    Coach
                                    @break
                                    @case(4)
                                    Trainer
                                    @break
                                    @default
                                    Unknown
                                @endswitch
                            </td>
                            <td>
                                <div class="btn-group">
                                    @if($user->role_id == 3 )
                                        <a href="{{ route('add.or.demote.or.delete.or.block', ['id'=>$user->id,"task_id"=>2]) }}" class="btn btn-primary btn-sm" title="Add as Admin" onclick="return confirm('Are you sure you want to promote this user to Admin? This action will change their role.');">
                                            <i class="bi bi-person-plus"></i> Add as Admin
                                        </a>
                                        <a href="{{ route('add.or.demote.or.delete.or.block',['id'=>$user->id,"task_id"=>4]) }}" class="btn btn-primary btn-sm" title="Demote to Trainee" onclick="return confirm('Are you sure you want to demote this user to Trainee? This action will change their role.');">
                                            <i class="bi bi-person-dash"></i> Demote to Trainee
                                        </a>
                                    @endif
                                    @if($user->role_id == 4)
                                        <a href="{{ route('add.or.demote.or.delete.or.block',['id'=>$user->id,"task_id"=>3]) }}" class="btn btn-primary btn-sm" title="Add as Coach" onclick="return confirm('Are you sure you want to promote this user to Coach? This action will change their role.');">
                                            <i class="bi bi-person-plus"></i> Add as Coach
                                        </a>
                                    @endif
                                    @if($user->role_id == 2)
                                        <a href="{{ route('add.or.demote.or.delete.or.block',['id'=>$user->id,"task_id"=>3]) }}" class="btn btn-primary btn-sm" title="Demote to Coach" onclick="return confirm('Are you sure you want to demote this user to Coach? This action will change their role.');">
                                            <i class="bi bi-person-dash"></i> Demote to Coach
                                        </a>
                                    @endif
                                    @if($user->role_id == 2 || $user->role_id == 3 || $user->role_id == 4)
                                        <a href="{{ route('add.or.demote.or.delete.or.block', ['id'=>$user->id,"task_id"=>0]) }}">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </a>
                                        @if($user->role_id != 1 && $user->block == 0)
                                            <a href="{{ route('add.or.demote.or.delete.or.block', ['id' => $user->id, 'task_id' => -1]) }}" class="btn btn-warning btn-sm" title="Block User" onclick="return confirm('Are you sure you want to block this user? This action will prevent the user from accessing their account.');">
                                                <i class="bi bi-slash-circle"></i> Block
                                            </a>
                                            @elseif($user->role_id != 1 && $user->block == 1)
                                                <a href="{{ route('add.or.demote.or.delete.or.block', ['id' => $user->id, 'task_id' => -2]) }}" class="btn btn-warning btn-sm" title="Block User" onclick="return confirm('Are you sure you want to block this user? This action will prevent the user from accessing their account.');">
                                                    <i class="bi bi-slash-circle"></i> UnBlock
                                                </a>
                                        @endif

                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endif
                    @if(Auth::user()->role_id == 2)
                        <tr data-role-id="{{ $user->role_id }}">
                            <td>{{ $user->id }}</td>
                            <td>
                                {{ $user->name }}
                                <div class="mt-2">
                                    <a href="{{ route('profile', $user->id) }}" class="btn btn-info btn-sm" title="Visit Profile">
                                        <i class="bi bi-person"></i> Visit
                                    </a>
                                </div>
                            </td>
                            <td>
                                @switch($user->role_id)
                                    @case(1)
                                    Superadmin
                                    @break
                                    @case(2)
                                    Admin
                                    @break
                                    @case(3)
                                    Coach
                                    @break
                                    @case(4)
                                    Trainer
                                    @break
                                    @default
                                    Unknown
                                @endswitch
                            </td>
                            <td>
                                <div class="btn-group">
                                    @if($user->role_id == 4)
                                        <a href="{{ route('add.or.demote.or.delete.or.block', $user->id) }}" class="btn btn-primary btn-sm" title="Add as Coach" onclick="return confirm('Are you sure you want to promote this user to Coach? This action will change their role.');">
                                            <i class="bi bi-person-plus"></i> Add as Coach
                                        </a>
                                    @elseif($user->role_id == 3)
                                        <a href="{{ route('add.or.demote.or.delete.or.block',['id'=>$user->id,"task_id"=>4]) }}" class="btn btn-primary btn-sm" title="Demote to Trainee" onclick="return confirm('Are you sure you want to demote this user to Trainee? This action will change their role.');">
                                            <i class="bi bi-person-dash"></i> Demote to Trainee
                                        </a>
                                    @endif

                                    @if($user->role_id != 2 && ($user->role_id == 3 || $user->role_id == 4))
                                            <a href="{{ route('add.or.demote.or.delete.or.block', ['id'=>$user->id,"task_id"=>0]) }}">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </a>
                                            @if($user->role_id != 1 && $user->block == 0)
                                                <a href="{{ route('add.or.demote.or.delete.or.block', ['id' => $user->id, 'task_id' => -1]) }}" class="btn btn-warning btn-sm" title="Block User" onclick="return confirm('Are you sure you want to block this user? This action will prevent the user from accessing their account.');">
                                                    <i class="bi bi-slash-circle"></i> Block
                                                </a>
                                            @elseif($user->role_id != 1 && $user->block == 1)
                                                <a href="{{ route('add.or.demote.or.delete.or.block', ['id' => $user->id, 'task_id' => -2]) }}" class="btn btn-warning btn-sm" title="Block User" onclick="return confirm('Are you sure you want to block this user? This action will prevent the user from accessing their account.');">
                                                    <i class="bi bi-slash-circle"></i> UnBlock
                                                </a>
                                            @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection
