@extends('layouts.master')

@section('content')
    <div class="container my-5">


        <div class="mt-5 pt-5">
            @if(auth()->user()->role_id == 3 || auth()->user()->role_id == 4)
                <div class="d-flex justify-content-between mb-3">
                    <button class="btn btn-info" onclick="toggleJoinedGroups()">Groups you've joined</button>
                    <button class="btn btn-info" onclick="toggleNotJoinedGroups()">Groups not joined</button>
                </div>
            @endif

            <div id="joinedGroups" style="display: none;">
                <div class="row">
                    @foreach($groupsJoined as $group)
                        <div class="col-md-4 col-lg-3 mb-3">
                            <div class="card h-100">
                                <img src="{{ asset($group->image) }}" class="card-img-top" alt="{{ $group->name }}">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><a href="{{ route('group', ['id' => $group->id]) }}" class="text-info">{{ $group->name }}</a></h5>
                                    <div class="mt-auto">
                                        <a href="{{ route('join.group',  ['id' => $group->id]) }}" class="btn btn-sm btn-outline-warning rounded-pill">Joined</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="notJoinedGroups" style="display: none;">
                <div class="row">
                    @foreach($groupsNotJoined as $group)
                        <div class="col-md-4 col-lg-3 mb-3">
                            <div class="card h-100">
                                <img src="{{ $group->image }}" class="card-img-top" alt="{{ $group->name }}">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><a href="{{ route('group', ['id' => $group->id]) }}" class="text-info">{{ $group->name }}</a></h5>
                                    <div class="mt-auto">
                                        <a href="{{ route('join.group',  ['id' => $group->id]) }}" class="btn btn-sm btn-outline-success rounded-pill">Join</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="container mt-4">
                <div class="row">
                    <div class="col-12">
                        <div class="streamline b-l m-l-md">
                            @foreach($posts as $post)
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-body">
                                        <small class="text-muted d-block">{{ $post->created_at->diffForHumans() }}</small>
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex">
                                                @if(!empty($post->user->image))
                                                    <img src="{{ asset($post->user->image) }}" class="rounded-circle mr-2" style="width: 35px; height: 35px; object-fit: cover;" alt="User Image">
                                                @endif
                                                <div>
                                                    <a href="{{ route('profile', $post->user->id) }}" class="text-primary">{{ $post->user->name }}</a>
                                                    <div>
                                                        <strong>Tags:</strong>
                                                        @if($post->tags->isEmpty())
                                                            <span>No tags.</span>
                                                        @else
                                                            @foreach($post->tags as $tag)
                                                                <a href="{{ route('posts.filter', ['tags' => [$tag->id]]) }}" class="badge badge-info">{{ $tag->tag_name }}</a>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                @if($post->user->id == auth()->user()->id || auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                                    @if($post->user->role_id != 1)
                                                        <a href="{{ route('delete.post.or.comment',['id'=>$post->id,'type'=>'post']) }}" class="btn btn-sm btn-danger btn-rounded shadow-lg animate__animated animate__pulse">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @elseif($post->user->role_id ==1 )
                                                        @if(auth()->user()->role_id==1)
                                                            <a href="{{ route('delete.post.or.comment',['id'=>$post->id,'type'=>'post']) }}" class="btn btn-sm btn-danger btn-rounded shadow-lg animate__animated animate__pulse">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        @endif
                                                    @endif
                                                @endif
                                                @if($post->user->id != auth()->user()->id && auth()->user()->role_id != 1 && auth()->user()->role_id != 2)
                                                    <button class="badge badge-info" onclick="toggleReportForm({{ $post->id }})">
                                                        <i class="fa fa-flag"></i> Report
                                                    </button>
                                                    <div id="reportForm-{{ $post->id }}" style="display: none;">
                                                        <form action="{{ route('posts.report', ['post' => $post->id]) }}" method="POST">
                                                            @csrf
                                                            <label for="note">Note:</label>
                                                            <input type="text" name="note" class="form-control" required>
                                                            <button type="submit" class="badge badge-info mt-2">Send</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <h5 class="card-title text-center mt-3">
                                            <a href="{{route('posts.show', $post->id)}}" class="text-dark">{{ $post->title }}</a>
                                        </h5>
                                        <p class="card-text" style="text-indent: 40px;">{{ $post->content }}</p>
                                        <div class="mt-3">
                                            @if(!empty($post->image))
                                                <div class="text-center my-3">
                                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="img-fluid img-square">
                                                </div>
                                            @endif
                                        </div>
                                        @if($post->comments != null)
                                            <div class="mt-3">
                                                @foreach($post->comments as $comment)
                                                    <small class="text-muted">{{$comment->created_at->diffForHumans()}}</small>

                                                    <div class="media mb-3 p-3" style="background-color: #f8f9fa;">
                                                        <div class="d-flex w-100 align-items-center">
                                                            @if(!empty($comment->user->image))
                                                                <img src="{{ asset($comment->user->image) }}" class="mr-3 rounded-circle" style="width: 50px; height: 50px; object-fit: cover;" alt="Commenter Image">
                                                            @endif
                                                            <div class="media-body flex-grow-1">
                                                                <h5 class="mt-0">{{ $comment->user->name }}</h5>
                                                                {{ $comment->content }}
                                                            </div>
                                                            @if($post->user->id == auth()->user()->id || auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                                                <a href="{{ route('delete.post.or.comment', ['id' => $post->id, 'type' => 'comment']) }}" class="btn btn-sm btn-danger btn-rounded shadow-lg animate__animated animate__pulse ml-auto">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            @endif
                                                        </div>


                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            {{ $posts->links() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function toggleJoinedGroups() {
                var groups = document.getElementById('joinedGroups');
                if (groups.style.display === "none") {
                    groups.style.display = "block";
                } else {
                    groups.style.display = "none";
                }
            }

            function toggleNotJoinedGroups() {
                var groups = document.getElementById('notJoinedGroups');
                if (groups.style.display === "none") {
                    groups.style.display = "block";
                } else {
                    groups.style.display = "none";
                }
            }


        </script>
    </div>
    <style>
        /* تعديل الأزرار */
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        /* تعديل الصور لتكون مربعة وأصغر */
        .img-square {
            width: 100%;
            height: auto;
            max-width: 600px; /* أقصى عرض للصورة */
            max-height: 600px; /* أقصى ارتفاع للصورة */
            object-fit: cover;
            border-radius: 0; /* إزالة الحواف المستديرة */
        }
    </style>
@endsection
