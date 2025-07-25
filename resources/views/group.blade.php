@extends('layouts.m')
@section('c')
    <div class="app" id="app">
        <!-- App Aside Section -->
        <div id="aside" class="app-aside modal nav-dropdown">
            <div class="b-t">
                <div class="nav-fold">

                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div id="content" class="app-content box-shadow-z0" role="main">
            <div class="app-header white box-shadow">
                <div class="navbar navbar-toggleable-sm flex-row align-items-center">
                    <a data-toggle="modal" data-target="#aside" class="hidden-lg-up mr-3">
                        <i class="material-icons">&#xe5d2;</i>
                    </a>
                    
            </div>

            <div ui-view class="app-body" id="view">
                <div class="item">
                    <div class="item-bg">
                        <img src="{{ asset($group->image) }}" alt="{{ $group->name }}" class="card-img-top" style="width: 50px; height: 50px;">
                    </div>
                    <div class="p-a-md">

                        <div class="row m-t">

                            <div class="col-sm-7">


                                <script>
                                    function confirmDelete() {
                                        return confirm('Are you sure you want to delete this group? This action cannot be undone.');
                                    }
                                </script>

                                <a href class="pull-left m-r-md">
                                    <div class="avatar-container">
                                    <span class="avatar w-96">
                                        <img src="{{ asset($group->image) }}" alt="{{ $group->name }}" class="card-img-top" style="width: 100px; height: 100px;">
                                        <i class="on b-white"></i>
                                    </span>
                                    </div>
                                </a>
                                <div class="clear m-b">
                                    <h3 class="m-0 m-b-xs">{{$group->first()->name}}</h3>
                                    @if(auth()->user()->role_id != 1 && auth()->user()->role_id != 2 && $isAdmin != 1)
                                    @if ($buttonText == 'joined')
                                            <form action="{{ route('join.group', ['id' => $group->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm warn btn-rounded m-b">Leave</button>
                                            </form>
                                        @else
                                            <form action="{{ route('join.group', ['id' => $group->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm warn btn-rounded m-b">Join</button>
                                            </form>
                                        @endif
                                    @endif
                                </div>

                                @if($isAdmin==1 || auth()->user()->role_id==2 || auth()->user()->role_id==1)
                                    <div class="btn-group">
                                        <a href="{{ route('status.group', ['group_id' => $group->id]) }}"
                                           class="btn btn-sm btn-{{ $group->status == 1 ? 'success' : 'danger' }} btn-rounded m-b"
                                           title="{{ $group->status == 1 ? 'Allow posting without approval' : 'Prevent posting without approval' }}">
                                            <i class="fas fa-{{ $group->status == 1 ? 'lock-open' : 'lock' }}">
                                                {{ $group->status == 1 ? 'Unrestricted Posting' : 'Restricted Posting' }}
                                            </i>
                                        </a>

                                        <a href="{{ route('status.show.group', ['group_id' => $group->id]) }}"
                                           class="btn btn-sm btn-{{ $group->status_show == 1 ? 'danger' : 'success' }} btn-rounded m-b"
                                           title="{{ $group->status_show == 1 ? 'Allow group visibility to non-members' : 'Restrict group visibility to members only' }}">
                                            <i class="fas fa-{{ $group->status_show == 1 ? 'lock' : 'lock-open' }}">
                                                {{ $group->status_show == 1 ? 'Private Group' : 'Public Group' }}
                                            </i>
                                        </a>
                                    </div>
                                @else
                                    <button class="btn btn-sm btn-{{ $group->status_show == 0 ? 'success' : 'danger' }} btn-rounded m-b" disabled>
                                        <i class="fas fa-{{ $group->status_show == 0 ? 'lock-open' : 'lock' }}">
                                            {{ $group->status_show == 0 ? 'Public Group' : 'Private Group' }}
                                        </i>
                                    </button>

                                    <button class="btn btn-sm btn-{{ $group->status == 1 ? 'success' : 'danger' }} btn-rounded m-b" disabled>
                                        <i class="fas fa-{{ $group->status == 1 ? 'lock-open' : 'lock' }}">
                                            {{ $group->status == 1 ? 'Unrestricted Posting' : 'Restricted Posting' }}
                                        </i>
                                    </button>
                                @endif
                                @if(!$isAdmin && (auth()->user()->role_id == 3 || auth()->user()->role_id == 4))
                                    @if($group->status_show == 0 || $group->status_show == 1)
                                        <!-- Button to trigger the report modal -->
                                        <button type="button" class="btn btn-warning btn-sm btn-rounded m-b" data-toggle="modal" data-target="#reportModal">
                                            Report Group
                                        </button>

                                    @endif
                                @endif
                            </div>

                            <div class="col-sm-5">
                                <h3>{{ $group->description }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="dker p-x">
                        <div class="row">
                            <div class="col-sm-6 push-sm-6">
                                <div class="p-y text-center text-sm-right">
                                    @if($isAdmin==1||auth()->user()->role_id==1||auth()->user()->role_id==2)
                                        <a class="inline p-x text-center" href="{{ route('show.all.subscribers', $group->id) }}">
                                            <span class="h4 block m-0">{{ $allsubscribers }}</span>
                                            <small class="text-xs text-muted">All subscribers</small>
                                        </a>
                                    @else
                                        <a class="inline p-x text-center">
                                            <span class="h4 block m-0">{{ $allsubscribers }}</span>
                                            <small class="text-xs text-muted">All subscribers</small>
                                        </a>
                                    @endif

                                    <a class="inline p-x b-l b-r text-center" href="{{ route('show.related.subscribers', $group->id) }}">
                                        <span class="h4 block m-0">{{ $relatedSubscribers }}</span>
                                        <small class="text-xs text-muted">Related Subscribers</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <!-- Modal for Add Post -->
                    <div class="modal fade" id="addPostModal" tabindex="-1" role="dialog" aria-labelledby="addPostModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addPostModalLabel">Add New Post</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <form action="{{ route('posts.store.group', ['role' => $isAdmin]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" name="title" class="form-control" placeholder="Enter Title">
                                            </div>
                                            <div class="form-group">
                                                <label for="content">Content</label>
                                                <textarea name="content" class="form-control" placeholder="Enter Content"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="tags">Tags</label>
                                                <select class="tags form-control" id="tags" name="tags[]" multiple="multiple"></select>
                                            </div>
                                            <div class="form-group">
                                                <label for="photos">Post images:</label>
                                                <input class="form-control" name="photos[]" type="file" id="photos" multiple accept="image/*">
                                            </div>
                                            <input type="hidden" name="group_id" value="{{ $group->id }}">
                                            <button type="submit" class="btn btn-success btn-block">Submit</button>
                                        </form>
                                    </div>

                                </div>
                        </div>
                    </div>

                    <!-- Modal for Adding Tag -->
                    <div class="modal fade" id="addTagModal" tabindex="-1" role="dialog" aria-labelledby="addTagModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addTagModalLabel">Add New Tag</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('tags.user.group') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="newtag">Add new tag</label>
                                            <input type="text" name="newtag" class="form-control" placeholder="Enter New Tag">
                                            <input type="hidden" name="group_id" value="{{ $group->id }}">
                                        </div>
                                        <button type="submit" class="btn btn-info btn-block">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($group->status_show == 0 || ($group->status_show == 1 && $isMember||$group->status_show==1&& auth()->user()->role_id == 1||$group->status_show==1&& auth()->user()->role_id == 2))
                    <div class="box">
                        @foreach($posts as $post)
                            @if($post->status == 1)
                                <div class="card mb-4 shadow-sm post-card">
                                    <div class="card-body">
                                        <small class="text-muted d-block">{{ $post->created_at->diffForHumans() }}</small>
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex">
                                                @if(!empty($post->user->image))
                                                    <img src="{{ asset($post->user->image) }}" class="rounded-circle mr-2" style="width: 32px; height: 32px; object-fit: cover;" alt="User Image">
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
                                                <div class="mr-2">
                                                    @if($isMember || auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                                        <a href="{{route('posts.upVote', $post->id)}}" class="like-btn @if($post->authedRating?->pivot->type == 'upVote') active @endif" title="Like">
                                                            <i class="fa fa-thumbs-up"></i>
                                                        </a>
                                                        <span>{{$post->upVotesCount}}</span>
                                                        <a href="{{route('posts.downVote', $post->id)}}" class="dislike-btn @if($post->authedRating?->pivot->type == 'downVote') active @endif" title="Dislike">
                                                            <i class="fa fa-thumbs-down"></i>
                                                        </a>
                                                        <span>{{$post->downVotesCount}}</span>
                                                    @endif
                                                </div>
                                                @if($post->user->id == auth()->user()->id || auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                                    <a href="{{ route('delete.post.group', ['id' => $post->id]) }}" class="btn btn-sm btn-danger btn-rounded shadow-lg animate__animated animate__pulse ml-2">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <h5 class="card-title text-center mt-3">
                                            <a href="{{route('posts.show', $post->id)}}" class="text-dark">{{ $post->title }}</a>
                                        </h5>
                                        <p class="card-text">{{ $post->content }}</p>
                                        @if(!empty($post->image))
                                            <div class="text-center my-3">
                                                <img src="{{ asset($post->image) }}" alt="Post Image" class="img-fluid img-square" style="max-width: 100%; width: 400px; height: auto; border-radius: 10px;">
                                            </div>
                                        @endif
                                        @if($isMember || auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                            <a href="#" data-toggle="collapse" data-target="#reply-{{ $post->id }}" class="card-link">
                                                <i class="fa fa-fw fa-mail-reply text-muted"></i> Reply
                                            </a>
                                        @endif
                                        <div class="collapse mt-2" id="reply-{{ $post->id }}">
                                            <form action="{{ route('comments.store') }}" method="POST">
                                                @csrf
                                                <input name="post_id" value="{{ $post->id }}" hidden>
                                                <div class="form-group">
                                                    <label for="content">Add Comment</label>
                                                    <input type="text" name="content" class="form-control" placeholder="Enter Content">
                                                </div>
                                                <button type="submit" class="btn btn-info btn-sm">Comment</button>
                                            </form>
                                        </div>
                                        @if($post->comments != null)
                                            <div class="mt-3">
                                                @foreach($post->comments as $comment)
                                                    <div class="comment-card d-flex align-items-start">
                                                        @if(!empty($comment->user->image))
                                                            <img src="{{ asset($comment->user->image) }}" alt="User Image">
                                                        @endif
                                                        <div class="media-body">
                                                            <div class="comment-meta">
                                                                <span class="comment-user">{{ $comment->user->name }}</span>
                                                                <span>{{ $comment->created_at->diffForHumans() }}</span>
                                                            </div>
                                                            <div class="comment-content">{{ $comment->content }}</div>
                                                        </div>
                                                        @if($post->user->id == auth()->user()->id ||$comment->user->id == auth()->user()->id|| auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                                            <a href="{{ route('delete.post.or.comment', ['id' => $post->id, 'type' => 'comment']) }}" class="btn btn-sm btn-danger ml-auto" style="margin-left:10px;">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif


                <!-- Report Group Modal -->
                <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reportModalLabel">Report Group</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('group.report') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="note">Note about:</label>
                                        <textarea name="note" class="form-control" rows="3" placeholder="Enter your note..." required></textarea>
                                    </div>
                                    <input type="hidden" name="id" value="{{ $group->id }}">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-danger">Submit Report</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Report Post Modal Template -->
                <script type="text/template" id="reportPostModalTemplate">
                    <div class="modal fade" id="reportPostModal-<%= postId %>" tabindex="-1" role="dialog" aria-labelledby="reportPostModalLabel-<%= postId %>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="reportPostModalLabel-<%= postId %>">Report Post</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('posts.report.admin.groupe', ['post' => '<%= postId %>']) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="note">Note:</label>
                                            <textarea name="note" class="form-control" rows="3" placeholder="Enter your note..." required></textarea>
                                        </div>
                                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-danger">Submit Report</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </script>



                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
            </div>
        </div>
        <style>
            /* تصغير حجم البوست */
            .card.post-card, .card.mb-4.shadow-sm {
                max-width: 1000px;
                margin: 0 0 1.5rem 0;
                border-radius: 16px;
                box-shadow: 0 4px 16px rgba(67, 97, 238, 0.07);
                padding: 0.5rem 0.7rem 0.7rem 0.7rem;
            }
            .card-body {
                padding: 0.7rem 1rem 1rem 1rem;
            }
            .card-title {
                font-size: 1.1rem;
                margin-bottom: 0.5rem;
            }
            .card-text {
                font-size: 0.97rem;
                margin-bottom: 0.5rem;
            }
            /* زر اللايك والديسلايك */
            .like-btn, .dislike-btn {
                width: 38px;
                height: 38px;
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: none;
                font-size: 1.2rem;
                margin-right: 7px;
                transition: background 0.2s, color 0.2s, box-shadow 0.2s;
                box-shadow: 0 2px 8px rgba(67, 97, 238, 0.07);
            }
            .like-btn {
                background: #e3f6f5;
                color: #2196f3;
            }
            .like-btn.active, .like-btn:hover {
                background: #2196f3;
                color: #fff;
            }
            .dislike-btn {
                background: #fff0f3;
                color: #f44336;
            }
            .dislike-btn.active, .dislike-btn:hover {
                background: #f44336;
                color: #fff;
            }
            /* شكل التعليقات */
            .comment-card {
                background: linear-gradient(135deg, #f8fafc 60%, #e0e7ff 100%);
                border-radius: 12px;
                padding: 12px 16px;
                margin-bottom: 10px;
                box-shadow: 0 2px 8px rgba(67, 97, 238, 0.04);
                font-size: 0.97rem;
                border-left: 4px solid #4361ee;
                position: relative;
            }
            .comment-card .media-body {
                font-size: 0.97rem;
            }
            .comment-card .comment-meta {
                font-size: 0.85rem;
                color: #888;
                margin-bottom: 2px;
            }
            .comment-card .comment-user {
                font-weight: bold;
                color: #3f37c9;
                margin-right: 8px;
            }
            .comment-card .comment-content {
                color: #333;
                margin-bottom: 0;
            }
            .comment-card:not(:last-child) {
                border-bottom: 1px dashed #bdbdbd;
            }
            .comment-card img {
                width: 32px;
                height: 32px;
                object-fit: cover;
                border-radius: 50%;
                margin-right: 10px;
                border: 1.5px solid #e3e6ea;
            }
        </style>
        <style>
            html, body {
                height: auto !important;
                min-height: 100%;
                overflow-y: auto !important;
            }
            .app,
            #content,
            .app-content {
                min-height: 100vh;
                height: auto !important;
                overflow: visible !important;
            }
        </style>
    </div>
@endsection