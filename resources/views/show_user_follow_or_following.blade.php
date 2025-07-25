@extends('layouts.master')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-center mb-4">
            <button class="btn btn-primary mx-2" onclick="showSection('following')">Following</button>
            <button class="btn btn-primary mx-2" onclick="showSection('followers')">Followers</button>
        </div>
        <div id="following" class="section">
            <h2 class="mb-4">Following</h2>
            @if($following->isEmpty())
                <div class="alert alert-info">
                    No following users.
                </div>
            @else
                @foreach($following as $user)
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset($user->image) }}" class="rounded-circle mr-3" style="width: 50px; height: 50px; object-fit: cover;" alt="User Image">
                                <div>
                                    <h5 class="mb-0">{{ $user->name }}</h5>
                                    <p class="mb-0">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div id="followers" class="section" style="display: none;">
            <h2 class="mb-4">Followers</h2>
            @if($followers->isEmpty())
                <div class="alert alert-info">
                    No followers.
                </div>
            @else
                @foreach($followers as $user)
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset($user->image) }}" class="rounded-circle mr-3" style="width: 50px; height: 50px; object-fit: cover;" alt="User Image">
                                <div>
                                    <h5 class="mb-0">{{ $user->name }}</h5>
                                    <p class="mb-0">{{ $user->email }}</p>
                                </div>
                                    <a href="{{ route('follow', $user->id) }}" class="btn btn-sm warn btn-rounded m-b">Follower</a>

                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <script>
        function showSection(section) {
            document.getElementById('following').style.display = 'none';
            document.getElementById('followers').style.display = 'none';
            document.getElementById(section).style.display = 'block';
        }
    </script>
@endsection
