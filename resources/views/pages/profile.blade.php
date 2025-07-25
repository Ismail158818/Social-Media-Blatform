@extends('layouts.master')

@section('content2')
    <div class="app" id="app">
    <!-- Header Section -->
    <div class="profile-header bg-gradient-primary py-4">
        <div class="container">
            <div class="d-flex align-items-center">
                <div class="mr-4">
                    <div class="avatar-container">
                        <span class="avatar w-96 shadow-lg">
                        <img src="{{asset('storage/' . $name->image)  }}" 
                                     class="rounded-circle mr-3" 
                                     width="50" 
                                     height="50" 
                                     alt="User"
                                     onerror="this.src='{{ asset('images/Default_image.jpg') }}'">
                    
                    </div>
                </div>
                <div class="profile-info text-white">
                    <h2 class="mb-1 font-weight-bold">{{ $name->name }}</h2>
                    <p class="mb-2">
                        <i class="fas fa-circle text-success mr-2"></i>
                        <span class="font-weight-light">Online</span>
                    </p>
                    <div class="social-links mb-3">
                        @if($name->facebook)
                        <a href="{{ $name->facebook }}" class="text-white mr-3" target="_blank">
                            <i class="fab fa-facebook-f fa-lg"></i>
                        </a>
                        @endif
                        @if($name->twitter)
                        <a href="{{ $name->twitter }}" class="text-white mr-3" target="_blank">
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                        @endif
                        @if($name->linkedin)
                        <a href="{{ $name->linkedin }}" class="text-white mr-3" target="_blank">
                            <i class="fab fa-linkedin-in fa-lg"></i>
                        </a>
                        @endif
                        @if($name->google)
                        <a href="{{ $name->google }}" class="text-white" target="_blank">
                            <i class="fab fa-google fa-lg"></i>
                        </a>
                        @endif
            </div>
                    <div class="profile-actions d-flex align-items-center">
                        @if ($isFollowing && auth()->user()->block!=1)
                            <a href="{{ route('follow', $user->id) }}" class="btn btn-light btn-sm rounded-pill px-3 mr-2">
                                <i class="fas fa-user-check mr-1"></i> Following
                            </a>
                        @elseif(!$my_profile && auth()->user()->block!=1)
                            <a href="{{ route('follow', $user->id) }}" class="btn btn-light btn-sm rounded-pill px-3 mr-2">
                                <i class="fas fa-user-plus mr-1"></i> Follow
                            </a>
                            @endif

                        @if(auth()->user()->id != $user->id && auth()->user()->block!=1)
                            <a href="{{ url('/chatify/' . $user->id) }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                                <i class="fas fa-envelope mr-1"></i> Message
                                </a>
                            @endif
                        
                            @if(auth()->user()->id == $user->id)
                        <!-- Profile Actions Dropdown -->
                        <div class="profile-actions-dropdown dropdown">
                            
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileActionsDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editProfileModal">
                                    <i class="fas fa-user-edit"></i> Edit Profile
                                </a>
                                <form action="{{ route('delete.user') }}" method="POST" class="d-inline">
                                            @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                                        <i class="fas fa-trash-alt"></i> Delete Account
                                    </button>
                                        </form>
                                    </div>
                                </div>
                        @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Stats Section -->
    <div class="container mt-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body py-3">
                <div class="row text-center">
                    <div class="col-4 border-right">
                        <div class="h4 font-weight-bold text-primary">{{ $followersCount }}</div>
                                    <small class="text-muted">Followers</small>
                                    @if(auth()->user()->id == $user->id)
                        <a href="{{ route('show.user.following.or.follower') }}" class="d-block small text-primary mt-1">View all</a>
                                    @endif
                                </div>
                    <div class="col-4 border-right"></br>

                        <div class="h4 font-weight-bold text-primary">{{ $followingCount }}</div>
                                    <small class="text-muted">Following</small>
                                    @if(auth()->user()->id == $user->id)
                        <a href="{{ route('show.user.following.or.follower') }}" class="d-block small text-primary mt-1">View all</a>
                                    @endif
                                </div>
                    @if($user->role_id == 3 || $user->role_id == 4)
                    <div class="col-4">
                        <div class="h4 font-weight-bold text-primary">{{ $group_count }}</div>
                                        <small class="text-muted">Groups</small>
                        @if(auth()->user()->id == $user->id)
                        <a href="{{ route('show.all.group') }}" class="d-block small text-primary mt-1">View all</a>
                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

        <!-- Content Tabs -->
        <div class="container py-4">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body p-0">
                            <ul class="nav nav-tabs nav-justified" id="profileTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab">
                                        <i class="far fa-newspaper mr-1"></i> Posts
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="comments-tab" data-toggle="tab" href="#comments" role="tab">
                                        <i class="far fa-comments mr-1"></i> Comments
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="upvotes-tab" data-toggle="tab" href="#upvotes" role="tab">
                                        <i class="fas fa-thumbs-up mr-1"></i> Upvotes
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="downvotes-tab" data-toggle="tab" href="#downvotes" role="tab">
                                        <i class="fas fa-thumbs-down mr-1"></i> Downvotes
                                    </a>
                                </li>
                            </ul>
                            
                            <div class="tab-content p-3" id="profileTabsContent">
                                <!-- Posts Tab -->
                                <div class="tab-pane fade show active" id="posts" role="tabpanel">
                                    @forelse($info as $in)
                                    <div class="card post-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="user-info">
                                                    
                                                    <img src="{{ asset('storage/' . $in->user->image) }}"
                                                         class="rounded-circle"
                                                         width="50"
                                                         height="50"
                                                         alt="User"
                                                         onerror="this.onerror=null;this.src='{{ asset('images/Default_image.jpg') }}';">
                                                    <div>
                                                        <a href="{{ route('profile', $in->user->id) }}" class="user-name">{{ $in->user->name }}</a>
                                                        <small class="text-muted d-block">{{ $in->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                                @if(auth()->user() && auth()->user()->id === $in->user->id)
                                                <div class="post-actions-dropdown">
                                                    <button class="btn btn-link text-muted dropdown-toggle btn-icon" type="button" id="postActionsDropdown{{ $in->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="postActionsDropdown{{ $in->id }}">
                                                        <a class="dropdown-item" href="{{ route('post.edit', $in->id) }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('delete.post.or.comment', $in->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <h5 class="card-title mb-2">
                                                <a href="{{route('posts.show', $in->id)}}" class="text-dark">{{ $in->title }}</a>
                                            </h5>
                                            <p class="card-text mb-3">{{ $in->content }}</p>
                                            @if(!empty($in->image))
                                            <div class="post-image mb-3 rounded overflow-hidden">
                                                <img src="{{ asset($in->image) }}" class="img-fluid w-100" alt="Post Image">
                                            </div>
                                            @endif
                                            <div class="interaction-bar">
                                                <div class="interaction-buttons">
                                                    <a href="{{route('posts.upVote', $in->id)}}" class="interaction-btn @if($in->authedRating?->pivot->type == 'upVote') active @endif">
                                                        <i class="fa fa-thumbs-up"></i>
                                                        <span class="count">{{$in->upVotesCount}}</span>
                                                    </a>
                                                    <a href="{{route('posts.downVote', $in->id)}}" class="interaction-btn @if($in->authedRating?->pivot->type == 'downVote') active @endif">
                                                        <i class="fa fa-thumbs-down"></i>
                                                        <span class="count">{{$in->downVotesCount}}</span>
                                                    </a>
                                                </div>
                                                <button type="button" class="comment-btn" onclick="toggleCommentForm('{{ $in->id }}')">
                                                    <i class="far fa-comment"></i>
                                                    <span>{{ $in->comments_count }} Comments</span>
                                                </button>
                                            </div>

                                            <!-- Comment Form -->
                                            <div class="comment-form-container" id="comment-form-{{ $in->id }}" style="display: none;">
                                                <form action="{{ route('comments.store', $in->id) }}" method="POST" class="comment-form mt-3">
                                                    @csrf
                                                    <div class="form-group">
                                                        <textarea name="content" class="form-control" rows="2" placeholder="Write a comment..."></textarea>
                                                    </div>
                                                    <div class="text-right mt-2">
                                                        <button type="submit" class="btn btn-primary btn-sm">Post Comment</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Comments List -->
                                            @if($in->comments && $in->comments->count() > 0)
                                            <div class="comments-section mt-3">
                                                @foreach($in->comments as $comment)
                                                <div class="media mb-3 p-3 bg-light rounded">
                                                    @if(!empty($comment->user->image))
                                                        <img src="{{ asset('storage/' . $comment->user->image) }}"
                                                             class="rounded-circle"
                                                             width="50"
                                                             height="50"
                                                             alt="User"
                                                             onerror="this.onerror=null;this.src='{{ asset('images/Default_image.jpg') }}';">
                                                    @else
                                                        <img src="{{ asset('images/Default_image.jpg') }}" class="rounded-circle mr-3" width="40" height="40" alt="Default User">
                                                    @endif
                                                    <div class="media-body">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mt-0 mb-1 font-weight-bold">{{ $comment->user->name }}</h6>
                                                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                        </div>
                                                        <p class="mb-0">{{ $comment->content }}</p>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-5">
                                        <i class="far fa-newspaper fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No posts yet</p>
                                    </div>
                                    @endforelse
                                </div>

                                <!-- Comments Tab -->
                                <div class="tab-pane fade" id="comments" role="tabpanel">
                                    @forelse($infocom as $post)
                                    <div class="card post-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="user-info">
                                                    <img src="{{ asset('storage/' . $post->user->image) }}"
                                                         class="rounded-circle"
                                                         width="50"
                                                         height="50"
                                                         alt="User"
                                                         onerror="this.onerror=null;this.src='{{ asset('images/Default_image.jpg') }}';">
                                                    <div>
                                                        <a href="{{ route('profile', $post->user->id) }}" class="user-name">{{ $post->user->name }}</a>
                                                        <small class="text-muted d-block">{{ $post->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                                @if(auth()->user() && auth()->user()->id === $post->user->id)
                                                <div class="post-actions-dropdown">
                                                    <button class="btn btn-link text-muted dropdown-toggle btn-icon" type="button" id="postActionsDropdown{{ $post->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="postActionsDropdown{{ $post->id }}">
                                                        <a class="dropdown-item" href="{{ route('post.edit', $post->id) }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('delete.post.or.comment', $post->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <h5 class="card-title mb-2">
                                                <a href="{{route('posts.show', $post->id)}}" class="text-dark">{{ $post->title }}</a>
                                            </h5>
                                            <p class="card-text mb-3">{{ $post->content }}</p>
                                            @if(!empty($post->image))
                                            <div class="post-image mb-3 rounded overflow-hidden">
                                                <img src="{{ asset($post->image) }}" class="img-fluid w-100" alt="Post Image">
                                            </div>
                                            @endif
                                            <div class="interaction-bar">
                                                <div class="interaction-buttons">
                                                    <a href="{{route('posts.upVote', $post->id)}}" class="interaction-btn @if($post->authedRating?->pivot->type == 'upVote') active @endif">
                                                        <i class="fa fa-thumbs-up"></i>
                                                        <span class="count">{{$post->upVotesCount}}</span>
                                                    </a>
                                                    <a href="{{route('posts.downVote', $post->id)}}" class="interaction-btn @if($post->authedRating?->pivot->type == 'downVote') active @endif">
                                                        <i class="fa fa-thumbs-down"></i>
                                                        <span class="count">{{$post->downVotesCount}}</span>
                                                    </a>
                                                </div>
                                                <button type="button" class="comment-btn" onclick="toggleCommentForm('{{ $post->id }}')">
                                                    <i class="far fa-comment"></i>
                                                    <span>{{ $post->comments_count }} Comments</span>
                                                </button>
                                            </div>

                                            <!-- Comment Form -->
                                            <div class="comment-form-container" id="comment-form-{{ $post->id }}" style="display: none;">
                                                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="comment-form mt-3">
                                                    @csrf
                                                    <div class="form-group">
                                                        <textarea name="content" class="form-control" rows="2" placeholder="Write a comment..."></textarea>
                                                    </div>
                                                    <div class="text-right mt-2">
                                                        <button type="submit" class="btn btn-primary btn-sm">Post Comment</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Comments List -->
                                            @if($post->comments && $post->comments->count() > 0)
                                            <div class="comments-section mt-3">
                                                @foreach($post->comments as $comment)
                                                <div class="media mb-3 p-3 bg-light rounded">
                                                    @if(!empty($comment->user->image))
                                                        <img src="{{ asset('storage/' . $comment->user->image) }}"
                                                             class="rounded-circle"
                                                             width="50"
                                                             height="50"
                                                             alt="User"
                                                             onerror="this.onerror=null;this.src='{{ asset('images/Default_image.jpg') }}';">
                                                    @else
                                                        <img src="{{ asset('images/Default_image.jpg') }}" class="rounded-circle mr-3" width="40" height="40" alt="Default User">
                                                    @endif
                                                    <div class="media-body">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mt-0 mb-1 font-weight-bold">{{ $comment->user->name }}</h6>
                                                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                        </div>
                                                        <p class="mb-0">{{ $comment->content }}</p>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-5">
                                        <i class="far fa-comments fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No comments yet</p>
                                    </div>
                                    @endforelse
                                </div>

                                <!-- Upvotes Tab -->
                                <div class="tab-pane fade" id="upvotes" role="tabpanel">
                                    @forelse($postupvote as $upvote)
                                    <div class="card post-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="user-info">
                                                    <img src="{{ asset('storage/' . $upvote->user->image) }}"
                                                         class="rounded-circle"
                                                         width="50"
                                                         height="50"
                                                         alt="User"
                                                         onerror="this.onerror=null;this.src='{{ asset('images/Default_image.jpg') }}';">
                                                    <img src="{{ asset('storage/' . auth()->user()->image) }}"
                                                         class="rounded-circle"
                                                         width="50"
                                                         height="50"
                                                         alt="User"
                                                         onerror="this.onerror=null;this.src='{{ asset('images/Default_image.jpg') }}';">
                                                    <div>
                                                        <a href="{{ route('profile', $upvote->user->id) }}" class="user-name">{{ $upvote->user->name }}</a>
                                                        <small class="text-muted d-block">{{ $upvote->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <h5 class="card-title mb-2">
                                                <a href="{{route('posts.show', $upvote->id)}}" class="text-dark">{{ $upvote->title }}</a>
                                            </h5>
                                            <p class="card-text mb-3">{{ $upvote->content }}</p>
                                            @if(!empty($upvote->image))
                                            <div class="post-image mb-3 rounded overflow-hidden">
                                                <img src="{{ asset($upvote->image) }}" class="img-fluid w-100" alt="Post Image">
                                            </div>
                                            @endif
                                            <div class="interaction-bar">
                                                <div class="interaction-buttons">
                                                    <a href="{{route('posts.upVote', $upvote->id)}}" class="interaction-btn active">
                                                        <i class="fa fa-thumbs-up"></i>
                                                        <span class="count">{{$upvote->upVotesCount}}</span>
                                                    </a>
                                                    <a href="{{route('posts.downVote', $upvote->id)}}" class="interaction-btn">
                                                        <i class="fa fa-thumbs-down"></i>
                                                        <span class="count">{{$upvote->downVotesCount}}</span>
                                                    </a>
                                                </div>
                                                <button type="button" class="comment-btn" onclick="toggleCommentForm('{{ $upvote->id }}')">
                                                    <i class="far fa-comment"></i>
                                                    <span>{{ $upvote->comments_count }} Comments</span>
                                                </button>
                                            </div>

                                            <!-- Comment Form -->
                                            <div class="comment-form-container" id="comment-form-{{ $upvote->id }}" style="display: none;">
                                                <form action="{{ route('comments.store', $upvote->id) }}" method="POST" class="comment-form mt-3">
                                                    @csrf
                                                    <div class="form-group">
                                                        <textarea name="content" class="form-control" rows="2" placeholder="Write a comment..."></textarea>
                                                    </div>
                                                    <div class="text-right mt-2">
                                                        <button type="submit" class="btn btn-primary btn-sm">Post Comment</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Comments List -->
                                            @if($upvote->comments && $upvote->comments->count() > 0)
                                            <div class="comments-section mt-3">
                                                @foreach($upvote->comments as $comment)
                                                <div class="media mb-3 p-3 bg-light rounded">
                                                    @if(!empty($comment->user->image))
                                                        <img src="{{ asset('storage/' . $comment->user->image) }}"
                                                             class="rounded-circle"
                                                             width="50"
                                                             height="50"
                                                             alt="User"
                                                             onerror="this.onerror=null;this.src='{{ asset('images/Default_image.jpg') }}';">
                                                    @else
                                                        <img src="{{ asset('images/Default_image.jpg') }}" class="rounded-circle mr-3" width="40" height="40" alt="Default User">
                                                    @endif
                                                    <div class="media-body">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mt-0 mb-1 font-weight-bold">{{ $comment->user->name }}</h6>
                                                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                        </div>
                                                        <p class="mb-0">{{ $comment->content }}</p>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-5">
                                        <i class="fas fa-thumbs-up fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No upvoted posts yet</p>
                                    </div>
                                    @endforelse
                                </div>

                                <!-- Downvotes Tab -->
                                <div class="tab-pane fade" id="downvotes" role="tabpanel">
                                    @forelse($postdownvote as $downvote)
                                    <div class="card post-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="user-info">
                                                <img src="{{ $downvote->user->image ? asset('storage/' . $downvote->user->image) : asset('images/default-avatar.png') }}"
                                                         class="rounded-circle"
                                                         width="50"
                                                         height="50"
                                                         alt="User"
                                                         onerror="this.onerror=null;this.src='{{ asset('images/default-avatar.png') }}';">
                                                    <div class="user-details">
                                                        <h4 class="user-name">{{ $downvote->user->name }}</h4>
                                                        <span class="post-time">{{ $downvote->created_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <h5 class="card-title mb-2">
                                                <a href="{{route('posts.show', $downvote->id)}}" class="text-dark">{{ $downvote->title }}</a>
                                            </h5>
                                            <p class="card-text mb-3">{{ $downvote->content }}</p>
                                            @if(!empty($downvote->image))
                                            <div class="post-image mb-3 rounded overflow-hidden">
                                                <img src="{{ asset($downvote->image) }}" class="img-fluid w-100" alt="Post Image">
                                            </div>
                                            @endif
                                            <div class="interaction-bar">
                                                <div class="interaction-buttons">
                                                    <a href="{{route('posts.upVote', $downvote->id)}}" class="interaction-btn">
                                                        <i class="fa fa-thumbs-up"></i>
                                                        <span class="count">{{$downvote->upVotesCount}}</span>
                                                    </a>
                                                    <a href="{{route('posts.downVote', $downvote->id)}}" class="interaction-btn active">
                                                        <i class="fa fa-thumbs-down"></i>
                                                        <span class="count">{{$downvote->downVotesCount}}</span>
                                                    </a>
                                                </div>
                                                <button type="button" class="comment-btn" onclick="toggleCommentForm('{{ $downvote->id }}')">
                                                    <i class="far fa-comment"></i>
                                                    <span>{{ $downvote->comments_count }} Comments</span>
                                                </button>
                                            </div>

                                            <!-- Comment Form -->
                                            <div class="comment-form-container" id="comment-form-{{ $downvote->id }}" style="display: none;">
                                                <form action="{{ route('comments.store', $downvote->id) }}" method="POST" class="comment-form mt-3">
                                                    @csrf
                                                    <div class="form-group">
                                                        <textarea name="content" class="form-control" rows="2" placeholder="Write a comment..."></textarea>
                                                    </div>
                                                    <div class="text-right mt-2">
                                                        <button type="submit" class="btn btn-primary btn-sm">Post Comment</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Comments List -->
                                            @if($downvote->comments && $downvote->comments->count() > 0)
                                            <div class="comments-section mt-3">
                                                @foreach($downvote->comments as $comment)
                                                <div class="media mb-3 p-3 bg-light rounded">
                                                    @if(!empty($comment->user->image))
                                                        <img src="{{ asset('storage/' . $comment->user->image) }}"
                                                             class="rounded-circle"
                                                             width="50"
                                                             height="50"
                                                             alt="User"
                                                             onerror="this.onerror=null;this.src='{{ asset('images/Default_image.jpg') }}';">
                                                    @else
                                                        <img src="{{ asset('images/Default_image.jpg') }}" class="rounded-circle mr-3" width="40" height="40" alt="Default User">
                                                    @endif
                                                    <div class="media-body">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mt-0 mb-1 font-weight-bold">{{ $comment->user->name }}</h6>
                                                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                        </div>
                                                        <p class="mb-0">{{ $comment->content }}</p>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-5">
                                        <i class="fas fa-thumbs-down fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No downvoted posts yet</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div></div></div>
                    

                <!-- Sidebar -->
                <div class="col-md-4">
                @if(auth()->user()->block != 1 && auth()->user()->id == $user->id)
    <div class="container mt-4">
        <!-- Who to follow card -->
        <div class="card shadow-sm mb-4 w-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-user-plus mr-2"></i>Who to follow
                </h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($unfollowing as $un)
                        <li class="list-group-item">
                            <div class="d-flex align-items-center">
                                <img src="{{asset('storage/' . $un->image)  }}" 
                                     class="rounded-circle mr-3" 
                                     width="50" 
                                     height="50" 
                                     alt="User"
                                     onerror="this.src='{{ asset('images/Default_image.jpg') }}'">
                                <div class="flex-grow-1">
                                    <a href="{{ route('profile', $un->id) }}" class="font-weight-bold text-dark">
                                        {{ $un->name }}
                                    </a>
                                </div>
                                <a href="{{ route('follow', $un->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                    Follow
                                </a>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted py-4">
                            No users to follow at the moment
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
        <!-- Following card -->
        <div class="card shadow-sm mb-4 w-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-users mr-2"></i>Following
                </h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($following as $follow)
                        <li class="list-group-item">
                            <div class="d-flex align-items-center">
                                <img src="{{ !empty($follow->image) ? asset('storage/' . $follow->image) : asset('images/Default_image.jpg') }}" 
                                     class="rounded-circle mr-3" 
                                     width="50" 
                                     height="50" 
                                     alt="User"
                                     onerror="this.src='{{ asset('images/Default_image.jpg') }}'">
                                <div class="flex-grow-1">
                                    <a href="{{ route('profile', $follow->id) }}" class="font-weight-bold text-dark">
                                        {{ $follow->name }}
                                    </a>
                                </div>
                                <a href="{{ route('follow', $follow->id) }}" class="btn btn-sm btn-primary rounded-pill">
                                    Following
                                </a>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted py-4">
                            You're not following anyone yet
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endif

                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('edit.info') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="form-group">
                            <label for="editName">Name</label>
                            <input type="text" class="form-control" id="editName" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="editImage">Profile Image</label>
                            <input type="file" class="form-control-file" id="editImage" name="image">
                        </div>
                        <div class="form-group">
                            <label for="editFacebook">Facebook</label>
                            <input type="url" class="form-control" id="editFacebook" name="facebook" value="{{ $user->facebook }}">
                        </div>
                        <div class="form-group">
                            <label for="editTwitter">Twitter</label>
                            <input type="url" class="form-control" id="editTwitter" name="twitter" value="{{ $user->twitter }}">
                        </div>
                        <div class="form-group">
                            <label for="editLinkedin">LinkedIn</label>
                            <input type="url" class="form-control" id="editLinkedin" name="linkedin" value="{{ $user->linkedin }}">
                        </div>
                        <div class="form-group">
                            <label for="editGoogle">Google</label>
                            <input type="url" class="form-control" id="editGoogle" name="google" value="{{ $user->google }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Post Modals -->
    @foreach($info as $in)
    <div class="modal fade" id="editPostModal{{ $in->id }}" tabindex="-1" role="dialog" aria-labelledby="editPostModalLabel{{ $in->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPostModalLabel{{ $in->id }}">Edit Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('post.edit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $in->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editPostTitle{{ $in->id }}">Title</label>
                            <input type="text" class="form-control" id="editPostTitle{{ $in->id }}" name="title" value="{{ $in->title }}" required>
                        </div>
                        <div class="form-group">
                            <label for="editPostContent{{ $in->id }}">Content</label>
                            <textarea class="form-control" id="editPostContent{{ $in->id }}" name="content" rows="3" required>{{ $in->content }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="editPostImage{{ $in->id }}">Post Image</label>
                            <input type="file" class="form-control-file" id="editPostImage{{ $in->id }}" name="image">
                            @if($in->image)
                                <small class="form-text text-muted">Current image: <a href="{{ asset($in->image) }}" target="_blank">View</a></small>
    @endif
                </div>
            </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

        <style>
        /* Main Styles */
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 0 0 20px 20px;
            margin-bottom: 30px;
        }
        
        .avatar-container {
            position: relative;
        }
        
        .avatar.w-96 {
            width: 120px;
            height: 120px;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .profile-info h2 {
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .social-links a {
            opacity: 0.8;
            transition: all 0.3s;
        }
        
        .social-links a:hover {
            opacity: 1;
            transform: translateY(-2px);
        }
        
        /* Tabs */
        .nav-tabs .nav-link {
            color: #6c757d;
            font-weight: 500;
            border: none;
            padding: 12px 15px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-tabs .nav-link:hover {
            color: #4e73df;
            background: rgba(78, 115, 223, 0.05);
        }
        
        .nav-tabs .nav-link.active {
            color: #4e73df;
            background: transparent;
            border-bottom: 3px solid #4e73df;
        }
        
        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 100%;
            height: 3px;
            background: #4e73df;
            animation: tabHighlight 0.3s ease;
        }
        
        @keyframes tabHighlight {
            0% {
                transform: scaleX(0);
                opacity: 0;
            }
            100% {
                transform: scaleX(1);
                opacity: 1;
            }
        }
        
        .tab-pane {
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Cards */
        .card {
            border: none;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        /* Avatar Upload */
        .avatar-upload {
            position: relative;
            max-width: 150px;
            margin: 0 auto;
        }
        
        .avatar-edit {
            position: absolute;
            right: 10px;
            bottom: 10px;
            z-index: 1;
        }
        
        .avatar-edit input {
            display: none;
        }
        
        .avatar-edit label {
            display: inline-block;
            width: 34px;
            height: 34px;
            background: #4e73df;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 34px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .avatar-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid #f8f9fa;
            overflow: hidden;
        }
        
        .avatar-preview > div {
                width: 100%;
            height: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .profile-header {
                text-align: center;
            }
            
            .profile-info {
                margin-top: 20px;
            }
            
            .avatar.w-96 {
                width: 100px;
                height: 100px;
            }
        }

        .profile-page .nav-tabs .nav-link.active {
            border-bottom: 3px solid #667eea; /* Highlight active tab */
            color: #667eea;
            font-weight: 600;
        }

        /* General Styles for Post Cards */
        .card.post-card {
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            border: none;
            margin-bottom: 25px; /* Add margin between cards */
        }

        .card.post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        .card-body {
            padding: 25px;
        }

        .text-muted.d-block {
            font-size: 0.85rem;
            color: #888 !important;
            margin-bottom: 15px;
        }

        /* User Info (within post card) */
        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
                object-fit: cover;
            margin-right: 12px;
            border: 2px solid #667eea;
        }

        .user-name {
            font-weight: 600;
            color: #333;
            font-size: 1.1rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .user-name:hover {
            color: #764ba2;
        }

        /* Tags */
        .post-tags .badge {
            background-color: #e0f2f7; /* Light blue background */
            color: #0288d1; /* Darker blue text */
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-right: 5px;
            margin-bottom: 5px;
            transition: all 0.2s ease;
        }

        .post-tags .badge:hover {
            background-color: #cce9f4;
            transform: translateY(-1px);
        }

        /* Vote Buttons */
        .vote-buttons .btn-icon {
            background-color: #f5f5f5;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .vote-buttons .btn-icon:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .vote-buttons .btn-icon i {
            font-size: 1.1rem;
        }

        .vote-buttons .btn-icon.bg-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: #fff !important;
        }

        .vote-buttons .btn-icon.bg-primary i {
            color: #fff !important;
        }

        .vote-counts {
            font-weight: 600;
            color: #555;
            font-size: 0.95rem;
            margin: 0 8px;
        }

        /* Action Buttons (Delete/Report/Edit - dropdown) */
        .post-actions-dropdown .dropdown-toggle::after {
            display: none; /* Hide default caret */
        }

        .post-actions-dropdown .btn-icon {
            background-color: #f5f5f5;
                border-radius: 50%;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .post-actions-dropdown .btn-icon:hover {
            background-color: #e0e0e0;
        }

        .post-actions-dropdown .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .post-actions-dropdown .dropdown-item {
            padding: 10px 15px;
            font-size: 0.95rem;
            color: #555;
        }

        .post-actions-dropdown .dropdown-item:hover {
            background-color: #f0f0f0;
            color: #333;
        }

        .post-actions-dropdown .dropdown-item i {
            margin-right: 8px;
            font-size: 1rem;
        }

        /* Post Content Styling (to match index.blade.php) */
        .post-content .post-title-link {
            color: #333 !important;
            text-decoration: none;
            font-size: 1.4rem;
            transition: color 0.3s ease;
        }

        .post-content .post-title-link:hover {
            color: #667eea !important;
        }

        .post-content .post-text {
            font-size: 1rem;
            line-height: 1.6;
            color: #555;
            margin-top: 15px;
            text-align: justify;
        }

        .post-image-container img {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
                width: 100%;
                height: auto;
            max-height: 400px; /* Optional: limit image height */
            object-fit: contain; /* or 'cover' depending on preference */
        }

        /* Comments Section (within post card) */
        .comment-card {
            background-color: #f8f9fa !important;
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .comment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .comment-user-avatar {
            width: 40px;
            height: 40px;
                border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
            border: 2px solid #bbb;
        }

        .comment-user-name {
            font-weight: 600;
            color: #444;
            font-size: 1rem;
        }

        .comment-content {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Reply Form */
        .reply-form .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 10px 15px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .reply-form .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .reply-form .btn-info {
            background-color: #667eea;
            border-color: #667eea;
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .reply-form .btn-info:hover {
            background-color: #764ba2;
            border-color: #764ba2;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(102, 126, 234, 0.2);
        }
        .vote-counts {
            font-weight: 600;
            color: #555;
            font-size: 0.95rem;
            margin: 0 8px;
        }
        .interaction-btn .count {
            font-weight: 600;
            font-size: 0.9rem;
        }
        /* General layout adjustments */
        #profile-content {
            padding-top: 30px;
        }

        .interaction-bar {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 0.75rem;
            margin-top: 1rem;
            border: 1px solid #e9ecef;
        }

        .interaction-buttons {
            display: flex;
            align-items: center;
            gap: 10px; /* Adjusted gap */
        }

        .interaction-btn,
        .comment-btn {
            background: white;
            border: 1px solid #dee2e6;
            color: #6c757d;
            padding: 0.5rem 1rem;
            border-radius: 25px; /* Pill shape */
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            text-decoration: none; /* Ensure no underline */
        }

        .interaction-btn:hover,
        .comment-btn:hover {
            background-color: #e9ecef;
            color: #495057;
            border-color: #e9ecef;
        }

        .interaction-btn.active {
            background: linear-gradient(to right, #6f42c1, #8a2be2); /* Purple gradient */
            color: white;
            border-color: transparent;
        }

        .interaction-btn.active.dislike {
            background: white;
            color: #6c757d; /* Keep gray for dislike even if active to match image */
            border-color: #dee2e6;
        }

        .comment-btn {
            margin-left: auto; /* Push to right */
        }

        /* Interaction Bar */
        .interaction-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-top: 1px solid #eee;
        }

        .interaction-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .interaction-btn {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 8px 15px;
            border-radius: 20px;
            background: #f5f5f5;
            color: #555;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .interaction-btn:hover {
            background: #e9ecef;
            color: #333;
        }

        .interaction-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
        }

        .interaction-btn i {
            font-size: 1.1rem;
        }

        .interaction-btn .count {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .comment-btn {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 8px 15px;
            border-radius: 20px;
            background: #f5f5f5;
            color: #555;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .comment-btn:hover {
            background-color: #f8f9fa;
        }

        .comment-btn i {
            font-size: 1.1rem;
        }

        .comment-btn span {
            font-weight: 500;
            font-size: 0.95rem;
        }

        /* Comment Form */
        .comment-form {
            margin-top: 15px;
        }

        .comment-form .form-control {
            border-radius: 20px;
            padding: 10px 15px;
            border: 1px solid #e9ecef;
            resize: none;
        }

        .comment-form .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .comment-form .btn-primary {
            border-radius: 20px;
            padding: 5px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .comment-form .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        /* Comments List */
        .comment-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .comment-item:last-child {
            border-bottom: none;
        }

        .comment-item .comment-content {
            margin-top: 5px;
            color: #555;
        }

        .comment-item .comment-meta {
            font-size: 0.85rem;
            color: #888;
        }

        .comments-section {
            margin-top: 15px;
        }

        .comment-form {
            margin-bottom: 15px;
        }

        .comment-form .form-control {
            border-radius: 20px;
            padding: 10px 15px;
            border: 1px solid #e9ecef;
            resize: none;
        }

        .comment-form .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .comment-form .btn-primary {
            border-radius: 20px;
            padding: 5px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .comment-form .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .comment-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .comment-item:last-child {
            border-bottom: none;
        }

        /* Add these styles to fix spacing and improve comments display */
        .card {
            margin-bottom: 1rem !important;
        }

        .comments-list {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .comment-item {
            padding: 0.5rem 0;
            border-bottom: 1px solid #f8f9fa;
        }

        .comment-item:last-child {
            border-bottom: none;
        }

        .comment-form-container {
            display: none;
            margin-top: 1rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .comment-form-container.show {
            display: block;
        }

        .comment-form textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
            resize: vertical;
        }

        .comment-form .btn-primary {
            margin-top: 0.5rem;
        }

        .suggested-users {
            position: static !important;
            top: auto !important;
            right: auto !important;
            width: 100% !important;
            max-width: 100% !important;
            margin-bottom: 0 !important;
            z-index: auto !important;
        }

        .following-section {
            position: static !important;
            top: auto !important;
            right: auto !important;
            width: 100% !important;
            max-width: 100% !important;
            margin-bottom: 0 !important;
            z-index: auto !important;
        }

   
        .sidebar-section {
            position: static !important;
            top: auto !important;
            right: auto !important;
            width: 100% !important;
            max-width: 100% !important;
            margin-bottom: 0 !important;
            z-index: auto !important;
        }

        @media (max-width: 1200px) {
            .sidebar-section {
                position: relative;
                top: auto;
                right: auto;
                width: 100%;
                max-height: none;
            }
        }
    
        </style>
    
    <script>
        // Image preview for profile edit
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        $("#image-upload").change(function() {
            readURL(this);
        });

        function toggleCommentForm(postId) {
            const formContainer = document.getElementById(`comment-form-${postId}`);
            if (formContainer) {
                if (formContainer.style.display === 'none') {
                    formContainer.style.display = 'block';
                } else {
                    formContainer.style.display = 'none';
                }
            }
        }

        // Add this script for smooth tab transitions
        document.addEventListener('DOMContentLoaded', function() {
            // Get all tab links
            const tabLinks = document.querySelectorAll('.nav-link');
            
            // Add click event listener to each tab
            tabLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all tabs
                    tabLinks.forEach(tab => {
                        tab.classList.remove('active');
                        const tabPane = document.querySelector(tab.getAttribute('href'));
                        if (tabPane) {
                            tabPane.classList.remove('show', 'active');
                        }
                    });
                    
                    // Add active class to clicked tab
                    this.classList.add('active');
                    
                    // Show the corresponding tab pane
                    const targetPane = document.querySelector(this.getAttribute('href'));
                    if (targetPane) {
                        targetPane.classList.add('show', 'active');
                    }
                });
            });
        });
    </script>
    </div>
@endsection
