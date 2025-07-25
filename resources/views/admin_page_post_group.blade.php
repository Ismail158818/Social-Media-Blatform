@extends('layouts.master')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-4">
            <button class="btn btn-primary" onclick="showSection('postRequests')">Post Requests: {{$postscount}}</button>
            <button class="btn btn-primary" onclick="showSection('reports')">Reports: {{$reportscount}}</button>
            <!-- Button to trigger the add members modal -->
            <button class="btn btn-primary" data-toggle="modal" data-target="#addMembersModal">Add Members</button>
        </div>

        <!-- Post Requests Section -->
        <div id="postRequests" class="section">
            <h2 class="mb-4">Post Requests</h2>
            @if($posts->isEmpty())
                <div class="alert alert-info">
                    No post requests available.
                </div>
            @else
                @foreach($posts as $post)
                    <div class="card mb-4 shadow-sm post-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset($post->user->image) }}" class="rounded-circle mr-3" style="width: 50px; height: 50px; object-fit: cover;" alt="User Image">
                                <div>
                                    <h5 class="mb-0">{{ $post->user->name }}</h5>
                                    <div>
                                        <strong>Tags:</strong>
                                        @if($post->tags->isEmpty())
                                            <span>No tags.</span>
                                        @else
                                            @foreach($post->tags as $tag)
                                                <span class="badge badge-info">{{ $tag->tag_name }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <h5 class="card-title text-center">{{ $post->title }}</h5>
                            <p class="card-text">{{ $post->content }}</p>
                            @if(!empty($post->image))
                                <div class="text-center my-3">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="img-fluid rounded">
                                </div>
                            @endif
                            <div class="d-flex justify-content-between">
                                <form action="{{ route('action.post.group', ['id' => $post->id, 'status' => 1]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Accept</button>
                                </form>
                                <form action="{{ route('action.post.group', ['id' => $post->id, 'status' => 2]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Reports Section -->
        <div id="reports" class="section" style="display: none;">
            <h2 class="mb-4">Reports</h2>
            @if($reports->isEmpty())
                <div class="alert alert-info">
                    No reports available.
                </div>
            @else
                @foreach($reports as $report)
                    <div class="card mb-4 shadow-sm report-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset($report->user->image) }}" class="rounded-circle mr-3" style="width: 50px; height: 50px; object-fit: cover;" alt="Post Image">
                                <div>
                                    <h5 class="mb-0">{{ $report->user->name }}</h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset($report->post->user->image) }}" class="rounded-circle mr-3" style="width: 50px; height: 50px; object-fit: cover;" alt="Reporter Image">
                                <div>
                                    <h5 class="mb-0">{{ $report->post->user->name }}</h5>
                                    <strong>Tags:</strong>
                                    @if(empty($report->tags))
                                        <span>No tags.</span>
                                    @else
                                        @foreach($report->tags as $tag)
                                            <span class="badge badge-info">{{ $tag->tag_name }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <h5 class="card-title text-center">{{ $report->title }}</h5>
                            <p class="card-text">{{ $report->content }}</p>
                            @if(!empty($report->image))
                                <div class="text-center my-3">
                                    <img src="{{ asset('storage/' . $report->image) }}" alt="Report Image" class="img-fluid rounded">
                                </div>
                            @endif
                            <p class="text-danger"><strong>Report Note:</strong> {{ $report->note }}</p>
                            <div class="d-flex justify-content-between">
                                <form action="{{ route('accept.report.post', ['id' => $report->id, 'post_id' => $report->post_id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to accept this report? If confirmed, the reported post will be deleted.');">Accept</button>
                                </form>
                                <form action="{{ route('reject.report.post', ['id' => $report->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to reject this report?');">Reject</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

            @endif
        </div>
    </div>

    <!-- Add Members Modal -->
    <div class="modal fade" id="addMembersModal" tabindex="-1" role="dialog" aria-labelledby="addMembersModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMembersModalLabel">Add Members</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add.members') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="members">Select Members</label>
                            <select class="form-control select2" id="members" name="members[]" multiple>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Members</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showSection(section) {
            document.getElementById('postRequests').style.display = 'none';
            document.getElementById('reports').style.display = 'none';
            document.getElementById(section).style.display = 'block';
        }

        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select Members",
                allowClear: true
            });
        });
    </script>

    <!-- Include Select2 CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
