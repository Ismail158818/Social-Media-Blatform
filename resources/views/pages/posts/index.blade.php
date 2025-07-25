@extends('layouts.master')

@section('content')
    <style>
        /* General Styles for Post Cards */
        .card.post-card {
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            border: none;
            margin-bottom: 1.5rem;
        }

        .card.post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        .card-body {
            padding: 1rem;
        }

        .text-muted.d-block {
            font-size: 0.85rem;
            color: #888 !important;
            margin-bottom: 15px;
        }

        /* User Info */
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

        /* User Role Badge */
        .user-role-badge {
            font-size: 0.6rem;
            padding: 0.1rem 0.3rem;
            border-radius: 6px;
            font-weight: 500;
            margin-top: 0.15rem;
            display: inline-flex;
            align-items: center;
            gap: 0.2rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);
            color: #666;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .user-role-badge i {
            font-size: 0.55rem;
            color: #888;
        }

        .role-super-admin {
            background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);
            color: #666;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .role-admin {
            background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);
            color: #666;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .role-coach {
            background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);
            color: #666;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .role-trainer {
            background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);
            color: #666;
            border: 1px solid rgba(0,0,0,0.05);
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

        /* Voting Buttons */
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

        /* Action Buttons (Delete/Report) */
        .action-buttons .btn {
            border-radius: 25px;
            padding: 8px 15px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-left: 10px;
        }

        .action-buttons .btn-danger {
            background-color: #ff4757;
            border-color: #ff4757;
            transition: all 0.3s ease;
        }

        .action-buttons .btn-danger:hover {
            background-color: #e63946;
            border-color: #e63946;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(255, 71, 87, 0.2);
        }

        .action-buttons .badge-info {
            background-color: #667eea !important;
            border-radius: 25px;
            padding: 8px 15px;
            font-size: 0.9rem;
            color: #fff;
            transition: all 0.3s ease;
        }

        .action-buttons .badge-info:hover {
            background-color: #764ba2 !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(102, 126, 234, 0.2);
        }

        /* Post Content */
        .card-title a {
            color: #333 !important;
            text-decoration: none;
            font-size: 1.4rem;
            transition: color 0.3s ease;
        }

        .card-title a:hover {
            color: #667eea !important;
        }

        .card-text {
            font-size: 1rem;
            line-height: 1.6;
            color: #555;
            margin-top: 15px;
            text-align: justify;
        }

        /* Post Image */
        .post-image-container img {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            max-height: 300px;
            width: auto;
            margin: 0 auto;
        }

        /* Comments Section */
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

        /* Modals */
        .modal-content {
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border: none;
            transform: none !important;
            transition: none !important;
        }

        .modal-header {
            border-bottom: none;
            padding: 20px 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .modal-title {
            font-weight: 600;
            color: #fff;
            font-size: 1.3rem;
        }

        .modal-body {
            padding: 25px;
        }

        .modal .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 10px 15px;
            font-size: 0.95rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 15px;
        }

        .modal .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .modal .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            color: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .modal .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .modal .btn-light {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            color: #333;
            transition: background-color 0.3s ease;
        }

        .modal .btn-light:hover {
            background: #e9ecef;
        }

        .modal .btn-close {
            opacity: 1;
            filter: brightness(0) invert(1);
            transition: opacity 0.3s ease;
        }

        .modal .btn-close:hover {
            opacity: 0.8;
        }

        .input-group {
            transition: none !important;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            transition: none !important;
        }

        .form-label {
            transition: none !important;
        }

        /* Pagination */
        .pagination {
            justify-content: center;
            margin-top: 30px;
        }

        .page-item .page-link {
            border-radius: 50% !important;
            margin: 0 5px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #667eea;
            border: 1px solid #667eea;
            transition: all 0.3s ease;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-color: #667eea !important;
            color: #fff !important;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .page-item .page-link:hover {
            background-color: #f0f0f0;
            color: #764ba2;
        }

        .page-item.active .page-link:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%) !important;
        }

        /* Streamline */
        .streamline.b-l {
            border-left: 3px solid #eee;
            padding-left: 25px;
            margin-left: 15px;
        }

        .streamline .card {
            position: relative;
        }

        .streamline .card::before {
            content: '';
            position: absolute;
            left: -33px; /* Adjust based on streamline b-l padding-left and border-width */
            top: 30px;
            width: 15px;
            height: 15px;
            background-color: #667eea;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px #667eea;
            z-index: 1;
        }

        .streamline .card:hover::before {
            background-color: #764ba2;
            box-shadow: 0 0 0 3px #764ba2;
        }

        /* Dropdown Menu */
        .dropdown-menu {
    position: absolute;
    left: 0; /* بدلاً من right: 0; */
    top: 100%;
    min-width: 100px;
    padding: 0.3rem 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: none;
    border-radius: 6px;
    background: white;
    z-index: 1000;
}

        .dropdown-item {
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            color: #666;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
            color: #333;
        }

        .dropdown-item i {
            width: 16px;
            text-align: center;
            margin-right: 0.4rem;
            font-size: 0.75rem;
        }

        .dropdown-item.text-danger:hover {
            background: #fff5f5;
            color: #dc3545;
        }

        .dropdown-item.text-primary:hover {
            background: #f0f7ff;
            color: #0d6efd;
        }

        .btn-options {
            background: none;
            border: none;
            padding: 0.25rem 0.5rem;
            color: #6c757d;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn-options:hover {
            color: #495057;
        }

        .dropdown-toggle::after {
            display: none;
        }

        /* Sidebar */
        .sidebar-card {
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            border: none;
        }

        .trending-post-item {
            padding: 0.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .trending-post-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        .trending-post-item h6 {
            font-size: 0.95rem;
            line-height: 1.4;
        }

        .popular-tags .badge {
            font-size: 0.85rem;
            padding: 0.5rem 0.8rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .popular-tags .badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        /* Interaction Bar */
        .interaction-bar {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 0.8rem;
            margin: 1rem 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #e9ecef;
        }

        .interaction-buttons {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .interaction-btn {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            background: white;
            border: 1px solid #e9ecef;
            color: #6c757d;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .interaction-btn:hover {
            background: #f1f3f5;
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            text-decoration: none;
        }

        .interaction-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }

        .interaction-btn i {
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        .interaction-btn .count {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .comment-btn {
            color: #6c757d;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            background: white;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .comment-btn:hover {
            background: #f1f3f5;
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            text-decoration: none;
            color: #495057;
        }

        .comment-btn i {
            margin-right: 0.5rem;
            font-size: 1rem;
        }

    </style>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-8">
                <div class="streamline b-l m-l-md">
                    @foreach($posts as $post)
                        @php $showReportId = request('show_report') == $post->id; @endphp
                        @if($showReportId)
                        <div class="card mb-2 p-3 border border-danger" id="reportForm-{{ $post->id }}">
                          <form action="{{ route('posts.report', ['post' => $post->id]) }}" method="POST">
                            @csrf
                            <div class="form-group mb-2">
                              <label for="note">Why are you reporting this post?</label>
                              <textarea name="note" class="form-control" rows="3" placeholder="Write your reason here..." required></textarea>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                              <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa fa-paper-plane me-2"></i> Send Report
                              </button>
                              <a href="{{ url()->current() }}" class="btn btn-light btn-sm">Cancel</a>
                            </div>
                          </form>
                        </div>
                        @endif
                        <div class="card post-card">
                            <div class="card-body">
                                <small class="text-muted d-block">{{ $post->created_at->diffForHumans() }}</small>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="user-info">
                                    <img src="{{asset('storage/' . $post->user->image)  }}" 
                                     class="rounded-circle mr-3" 
                                     width="50" 
                                     height="50" 
                                     alt="User"
                                     onerror="this.src='{{ asset('images/Default_image.jpg') }}'">
                    
                                        <div>
                                            <h6 class="mb-0">{{ $post->user->name }}</h6>
                                            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center action-buttons">
                                    <div class="dropdown">
    <button class="btn btn-options dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-ellipsis-h"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right">

        {{-- تعديل وحذف --}}
        @if(($post->user->id == auth()->user()->id || auth()->user()->role_id == 1 || auth()->user()->role_id == 2) && $post->user->role_id != 1)
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editPostModal{{ $post->id }}">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDeleteModal{{ $post->id }}">
                <i class="fas fa-trash-alt"></i> Delete
            </a>
        @endif

        {{-- تبليغ --}}
        @if($post->user->id != auth()->user()->id && auth()->user()->role_id != 1 && auth()->user()->role_id != 2)
            <a class="dropdown-item text-danger" href="?show_report={{ $post->id }}#reportForm-{{ $post->id }}">Report</a>
        @endif

    </div>
</div>

                                    </div>
                                </div>
                                <div class="post-tags text-left mb-2">
                                    <span class="text-muted" style="font-size:0.95em;font-weight:600;">Tags:</span>
                                    @if($post->tags->isEmpty())
                                        <span class="text-muted" style="font-size:0.9em;">No tags</span>
                                    @else
                                        @foreach($post->tags as $tag)
                                            <a href="{{ route('posts.filter', ['tags' => [$tag->id]]) }}" class="badge">{{ $tag->tag_name }}</a>
                                        @endforeach
                                    @endif
                                </div>
                                <h5 class="card-title text-center mt-3">
                                    <a href="{{route('posts.show', $post->id)}}">{{ $post->title }}</a>
                                </h5>
                                <p class="card-text">{{ $post->content }}</p>
                                <div class="mt-2">
                                    @if(!empty($post->image))
                                        <div class="text-center my-2 post-image-container">
                                            <img src="{{ asset($post->image) }}" alt="Post Image" class="img-fluid" style="max-height: 380px; width: 100%;">
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
                                        <button type="button" class="comment-btn" data-bs-toggle="collapse" data-bs-target="#reply-{{ $post->id }}" aria-expanded="false" aria-controls="reply-{{ $post->id }}">
                                            <i class="far fa-comment"></i>
                                            <span>Comment</span>
                                        </button>
                                    </div>

                                    <div class="collapse mt-3" id="reply-{{ $post->id }}">
                                        <form action="{{route('comments.store')}}" method="POST" class="comment-form">
                                            @csrf
                                            <input name="post_id" value="{{$post->id}}" hidden>
                                            <div class="form-group">
                                                <textarea name="content" class="form-control" placeholder="Write a comment..." rows="3"></textarea>
                                            </div>
                                            <div class="text-right mt-2">
                                                <button type="submit" class="btn btn-primary btn-sm">Post Comment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @if($post->comments != null)
                                    <div class="mt-3 comments-section">
                                        @foreach($post->comments as $comment)
                                            <div class="media mb-3 comment-card">
                                                <div class="d-flex w-100 align-items-center mt-2">
                                                <img src="{{asset('storage/' . $comment->user->image)  }}" 
                                     class="rounded-circle mr-3" 
                                     width="50" 
                                     height="50" 
                                     alt="User"
                                     onerror="this.src='{{ asset('images/Default_image.jpg') }}'">
                    
                                                    <div class="media-body flex-grow-1">
                                                        <div class="d-flex align-items-center">
                                                            <h6 class="mt-0 font-weight-bold comment-user-name mb-0">{{ $comment->user->name }}</h6>
                                                            <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                                                        </div>
                                                        <p class="comment-content">{{ $comment->content }}</p>
                                                    </div>
                                                    @if($post->user->id == auth()->user()->id || auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                                        <a href="{{ route('delete.post.or.comment', ['id' => $comment->id, 'type' => 'comment']) }}" class="btn btn-sm btn-danger ms-2">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editPostModal{{ $post->id }}" tabindex="-1" aria-labelledby="editPostModalLabel{{ $post->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-gradient-primary text-white">
                                                <h5 class="modal-title" id="editPostModalLabel{{ $post->id }}">
                                                    <i class="fas fa-edit me-2"></i>Edit Post
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <form id="editForm-{{ $post->id }}" action="{{ route('post.edit') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                    
                                                    <div class="mb-4">
                                                        <label for="title" class="form-label fw-bold text-primary">Title</label>
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text bg-light">
                                                                <i class="fas fa-heading text-primary"></i>
                                                            </span>
                                                            <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-4">
                                                        <label for="content" class="form-label fw-bold text-primary">Content</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light">
                                                                <i class="fas fa-align-left text-primary"></i>
                                                            </span>
                                                            <textarea name="content" class="form-control" rows="6" required>{{ $post->content }}</textarea>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-4">
                                                        <label for="image" class="form-label fw-bold text-primary">Image</label>
                                                        @if(!empty($post->image))
                                                            <div class="mb-3">
                                                                <div class="position-relative d-inline-block">
                                                                    <img src="{{ asset($post->image) }}" alt="Current Post Image" class="img-thumbnail rounded" style="max-height: 200px;">
                                                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle" onclick="document.getElementById('removeImage-{{ $post->id }}').value = '1'">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light">
                                                                <i class="fas fa-image text-primary"></i>
                                                            </span>
                                                            <input type="file" name="image" class="form-control" accept="image/*">
                                                        </div>
                                                        <input type="hidden" name="remove_image" id="removeImage-{{ $post->id }}" value="0">
                                                        <small class="text-muted mt-2 d-block">
                                                            <i class="fas fa-info-circle me-1"></i>
                                                            Leave empty to keep the current image
                                                        </small>
                                                    </div>

                                                    <div class="alert alert-danger d-none" id="error-{{ $post->id }}"></div>
                                                    <div class="alert alert-success d-none" id="success-{{ $post->id }}"></div>
                                                    
                                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                                                            <i class="fas fa-times me-2"></i>Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-primary px-4">
                                                            <i class="fas fa-save me-2"></i>Save Changes
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="confirmDeleteModal{{ $post->id }}" tabindex="-1" aria-labelledby="confirmDeleteLabel{{ $post->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmDeleteLabel{{ $post->id }}">Confirm Delete</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this post?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <a href="{{ route('delete.post.or.comment',['id'=>$post->id,'type'=>'post']) }}" class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        $('#editForm-{{ $post->id }}').on('submit', function(e) {
                                            e.preventDefault();
                                            
                                            const formData = new FormData(this);
                                            const errorDiv = $('#error-{{ $post->id }}');
                                            const successDiv = $('#success-{{ $post->id }}');
                                            
                                            // Reset alerts
                                            errorDiv.addClass('d-none');
                                            successDiv.addClass('d-none');
                                            
                                            $.ajax({
                                                url: '{{ route('post.edit') }}',
                                                type: 'POST',
                                                data: formData,
                                                processData: false,
                                                contentType: false,
                                                success: function(response) {
                                                    if (response.success) {
                                                        successDiv.text('Post updated successfully!').removeClass('d-none');
                                                        
                                                        // Update the post content on the page
                                                        const postTitle = $(`a[href="{{route('posts.show', $post->id)}}"]`);
                                                        const postContent = postTitle.closest('.card').find('.card-text');
                                                        const postImage = postTitle.closest('.card').find('.post-image-container');
                                                        
                                                        postTitle.text(formData.get('title'));
                                                        postContent.text(formData.get('content'));
                                                        
                                                        // Handle image update
                                                        if (formData.get('remove_image') === '1') {
                                                            postImage.remove();
                                                        } else if (formData.get('image')) {
                                                            const reader = new FileReader();
                                                            reader.onload = function(e) {
                                                                if (postImage.length) {
                                                                    postImage.find('img').attr('src', e.target.result);
                                                                } else {
                                                                    const newImage = `
                                                                        <div class="text-center my-3 post-image-container">
                                                                            <img src="${e.target.result}" alt="Post Image" class="img-fluid rounded">
                                                                        </div>
                                                                    `;
                                                                    postTitle.closest('.card').find('.mt-3').prepend(newImage);
                                                                }
                                                            };
                                                            reader.readAsDataURL(formData.get('image'));
                                                        }
                                                        
                                                        // Close modal after 2 seconds
                                                        setTimeout(() => {
                                                            $('#editPostModal{{ $post->id }}').modal('hide');
                                                        }, 2000);
                                                    } else {
                                                        errorDiv.text(response.message || 'An error occurred while updating the post.').removeClass('d-none');
                                                    }
                                                },
                                                error: function(xhr) {
                                                    errorDiv.text('An error occurred while updating the post.').removeClass('d-none');
                                                }
                                            });
                                        });
                                    });
                                </script>

                            </div>
                        </div>
                    @endforeach
                    {{ $posts->links() }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="card sidebar-card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-fire text-danger me-2"></i>
                            Trending Posts
                        </h5>
                        <div class="trending-posts">
                            @foreach($posts->sortByDesc('upVotesCount')->take(5) as $trendingPost)
                                <div class="trending-post-item">
                                    <a href="{{route('posts.show', $trendingPost->id)}}" class="text-decoration-none">
                                        <h6 class="mb-1 text-dark">{{ $trendingPost->title }}</h6>
                                    </a>
                                    <div class="d-flex align-items-center">
                                        <small class="text-muted me-2">
                                            <i class="fas fa-thumbs-up text-success"></i> {{ $trendingPost->upVotesCount }}
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-comments text-primary"></i> {{ $trendingPost->comments_count }}
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card sidebar-card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-tags text-primary me-2"></i>
                            Popular Tags
                        </h5>
                        <div class="popular-tags">
                            @foreach($posts->pluck('tags')->flatten()->unique('id')->take(10) as $tag)
                                <a href="{{ route('posts.filter', ['tags' => [$tag->id]]) }}" class="badge badge-info">
                                    {{ $tag->tag_name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Group Modal -->
    <div class="modal fade" id="createGroupModal" tabindex="-1" role="dialog" aria-labelledby="createGroupModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createGroupModalLabel">Create Group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('creat.group') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Group Name:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Group Description:</label>
                            <input type="text" name="description" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="photo">Group image:</label>
                            <input class="form-control" name="photo" type="file" id="photo" required>
                        </div>
                        @if(auth()->user()->role_id == 2 || auth()->user()->role_id == 1)
                            <div class="form-group">
                                <label for="users">Select Users:</label>
                                <select name="users[]" id="users" class="form-control select2" multiple required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-info mt-2">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Post Modal -->
    <div class="modal fade" id="createPostModal" tabindex="-1" role="dialog" aria-labelledby="createPostModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPostModalLabel">Create Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('posts.store.group') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter Title">
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <input type="text" name="content" class="form-control" placeholder="Enter Content">
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <select class="tags form-control" id="tags" name="tags[]" multiple="multiple"></select>
                        </div>
                        <div class="form-group">
                            <label for="photos">Post images:</label>
                            <input class="form-control" name="photos[]" type="file" id="photos" multiple accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
    <script>
    function showReportPopup(postId) {
      document.getElementById('reportPopup-' + postId).style.display = 'block';
    }
    function hideReportPopup(postId) {
      document.getElementById('reportPopup-' + postId).style.display = 'none';
    }
    </script>
@endsection
