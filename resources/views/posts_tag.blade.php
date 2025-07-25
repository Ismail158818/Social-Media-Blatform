@extends('layouts.master')
@section('content')

    @if($posts->isEmpty())
        <div class="alert alert-info" role="alert">
            No posts found matching your search criteria.
        </div>
    @else
        <div class="container my-5">
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-md-12 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        @if($post->user->image)
                                            <img src="{{ asset($post->user->image) }}" class="rounded-circle mr-2" style="width: 50px; height: 50px; object-fit: cover;" alt="User Image">
                                        @endif
                                        <div>
                                            <p class="mb-0"><strong>{{ $post->user->name }}</strong></p>
                                            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="{{route('posts.upVote', $post->id)}}" class="btn btn-icon @if($post->authedRating?->pivot->type == 'upVote') bg-primary @endif white">
                                            <i class="fa fa-thumbs-up text-success"></i>
                                        </a>
                                        <span class="mx-2">{{$post->upVotesCount}}</span>
                                        <a href="{{route('posts.downVote', $post->id)}}" class="btn btn-icon @if($post->authedRating?->pivot->type == 'downVote') bg-primary @endif white">
                                            <i class="fa fa-thumbs-down text-danger"></i>
                                        </a>
                                        <span>{{$post->downVotesCount}}</span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div>
                                        <strong>Tags:</strong>
                                        @foreach($post->tags as $tag)
                                            <a href="{{ route('posts.filter', ['tags' => [$tag->id]]) }}" class="badge badge-info">{{ $tag->tag_name }}</a>
                                        @endforeach
                                    </div>
                                    <h5 class="card-title text-center">
                                        <a href="{{route('posts.show', $post->id)}}" class="text-dark">{{ $post->title }}</a>
                                    </h5>
                                    <p class="card-text">{{ $post->content }}</p>
                                    @if($post->image)
                                        <div class="text-center my-3">
                                            <img src="{{ asset($post->image) }}" alt="Post Image" class="img-fluid img-square w-50">
                                        </div>
                                    @endif

                                    <div class="mt-3">
                                        <a href="#" data-toggle="collapse" data-target="#reply-{{ $post->id }}" class="card-link">
                                            <i class="fa fa-fw fa-mail-reply text-muted"></i> Reply
                                        </a>
                                        <div class="collapse mt-2" id="reply-{{ $post->id }}">
                                            <form action="{{route('comments.store')}}" method="POST">
                                                @csrf
                                                <input name="post_id" value="{{$post->id}}" hidden>
                                                <div class="form-group">
                                                    <label for="content">Add Comment</label>
                                                    <input type="text" name="content" class="form-control" placeholder="Enter Content">
                                                </div>
                                                <button type="submit" class="btn btn-info btn-sm">Comment</button>
                                            </form>
                                        </div>
                                    </div>
                                    @if($post->comments)
                                        <div class="mt-3 p-3" style="background-color: #f8f9fa;">
                                            @foreach($post->comments as $comment)
                                                <div class="media mb-3">
                                                    @if($comment->user->image)
                                                        <img src="{{ asset($comment->user->image) }}" class="mr-3 rounded-circle" style="width: 35px; height: 35px; object-fit: cover;" alt="Commenter Image">
                                                    @endif
                                                    <div class="media-body">
                                                        <h6 class="mt-0">{{ $comment->user->name }}</h6>
                                                        <p>{{ $comment->content }}</p>
                                                        <small class="text-muted">{{$comment->created_at->diffForHumans()}}</small>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

@endsection

<style>
    .img-square {
        width: 100%;
        height: auto;
        max-width: 600px;
        max-height: 600px;
        object-fit: cover;
        border-radius: 0;
    }
</style>
