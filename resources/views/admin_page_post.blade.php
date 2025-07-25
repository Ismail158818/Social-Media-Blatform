@extends('layouts.master')

@section('content')
    <style>
        /* أنماط عامة */
        body {
            font-family: 'Segoe UI', Roboto, 'Open Sans', sans-serif;
            background-color: #f8f9fa;
        }
        
        .container {
            padding-top: 30px;
            padding-bottom: 50px;
        }
        
        /* بطاقات التقارير */
        .report-card {
            transition: box-shadow 0.3s;
            border-radius: 10px;
            border: 1px solid #e3e3e3;
            min-height: 420px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
            background: #fff;
            margin-bottom: 25px;
            position: relative;
        }
        
        .report-card:hover {
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.10);
            transform: translateY(-3px);
        }
        
        /* رأس وتذييل البطاقة */
        .report-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px 0 20px;
        }
        
        .reporter-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .reporter-info img {
            width: 38px;
            height: 38px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #e3e3e3;
        }
        
        .reporter-info .name {
            font-weight: 600;
            color: #222;
            font-size: 1rem;
        }
        
        .reported-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 20px 0 20px;
            margin-top: 10px;
        }
        
        .reported-info img {
            width: 34px;
            height: 34px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #e3e3e3;
        }
        
        .reported-info .name {
            font-weight: 500;
            color: #444;
            font-size: 0.97rem;
        }
        
        /* محتوى البطاقة */
        .card-body-content {
            flex: 1;
            padding: 18px 20px 10px 20px;
            display: flex;
            flex-direction: column;
        }
        
        .card-title {
            font-weight: 700;
            color: #2c3e50;
            font-size: 1.15rem;
            margin-bottom: 10px;
            text-align: left;
        }
        
        .card-text {
            color: #555;
            line-height: 1.7;
            margin-bottom: 16px;
            flex-grow: 1;
        }
        
        .note {
            background-color: #f6f6f6;
            padding: 10px 12px;
            border-radius: 7px;
            margin-bottom: 16px;
            font-weight: 500;
            border-left: 3px solid #bbb;
            text-align: left;
            color: #555;
        }
        
        /* الأزرار */
        .action-btns {
            display: flex;
            gap: 8px;
        }
        
        .action-btns .btn {
            min-width: 80px;
            border-radius: 7px;
            font-weight: 500;
            padding: 7px 14px;
            font-size: 0.95rem;
            border: 1px solid #e3e3e3;
            background: #f8f9fa;
            color: #333;
            transition: all 0.2s;
        }
        
        .action-btns .btn-success {
            background: #e8f5e9;
            color: #388e3c;
            border: 1px solid #c8e6c9;
        }
        
        .action-btns .btn-danger {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }
        
        .action-btns .btn:hover {
            background: #e0e0e0;
        }
        
        /* أزرار التبديل */
        .toggle-btns {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .toggle-btns .btn {
            flex: 1;
            max-width: 280px;
            border-radius: 12px;
            padding: 14px 24px;
            font-weight: 600;
            font-size: 1.05rem;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: none;
        }
        
        .toggle-btns .btn-primary {
            background: linear-gradient(135deg, #2196F3 0%, #0D47A1 100%);
        }
        
        .toggle-btns .btn-secondary {
            background: linear-gradient(135deg, #9E9E9E 0%, #424242 100%);
        }
        
        .toggle-btns .btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        .toggle-btns .btn.active {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        /* الصور */
        .img-fluid {
            border-radius: 10px;
            border: 1px solid #f0f0f0;
            margin-bottom: 15px;
            object-fit: cover;
            height: 180px;
            width: 100%;
            transition: transform 0.3s;
            box-shadow: 0 2px 6px rgba(0,0,0,0.07);
        }
        
        .img-fluid:hover {
            transform: scale(1.03);
        }
        
        /* التاجات */
        .badge-info {
            background: #e3eafc;
            color: #2c3e50;
            padding: 7px 13px;
            border-radius: 16px;
            font-weight: 500;
            font-size: 0.85rem;
            margin: 3px 2px;
            display: inline-block;
        }
        
        /* زر عرض المزيد */
        .show-more {
            color: #1976d2;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 0.98em;
            padding: 0;
            font-weight: 500;
            margin-top: 5px;
        }
        
        .show-more:hover {
            color: #0d47a1;
            text-decoration: underline;
        }
        
        /* التأثيرات */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        /* التكيف مع الشاشات الصغيرة */
        @media (max-width: 767px) {
            .report-card {
                margin-bottom: 18px;
                min-height: auto;
            }
            
            .toggle-btns {
                flex-direction: column;
                gap: 12px;
            }
            
            .toggle-btns .btn {
                max-width: 100%;
            }
            
            .action-btns {
                flex-direction: column;
                gap: 10px;
            }
            
            .action-btns .btn {
                width: 100%;
            }
            
            .img-fluid {
                height: 120px;
            }
            
            .report-header, .reported-info, .card-body-content {
                padding-left: 10px;
                padding-right: 10px;
            }
        }
    </style>
    
    <div class="container">
        @if (session('report_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('report_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('report'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('report') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- أزرار التبديل -->
        <div class="mb-4 toggle-btns">
            <button type="button" class="btn btn-primary active" id="showPostReports">
                Post Reports: {{$reportsCount}}
            </button>
            <button type="button" class="btn btn-secondary" id="showGroupReports">
                Group Reports: {{$ReportsGroupsCount}}
            </button>
        </div>

        <!-- تقارير المنشورات -->
        <div id="postReports">
            <h4 class="mb-4">Post Reports</h4>
            @if($reports->isNotEmpty())
                <div class="row">
                @foreach($reports as $report)
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                        <div class="card report-card w-100">
                            <div class="report-header">
                                <div class="reporter-info">
                                    <img src="{{ asset($report->user->image) }}" alt="Reporter Image">
                                    <span class="name">{{ $report->user->name }}</span>
                                </div>
                                <div class="action-btns">
                                    <form action="{{ route('accept.report.post', ['id' => $report->id, 'post_id' => $report->post_id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to accept this report? If confirmed, the reported post will be deleted.');">Accept</button>
                                    </form>
                                    <form action="{{ route('reject.report.post', ['id' => $report->id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to reject this report?');">Reject</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body card-body-content">
                                <p class="note mb-3">{{ $report->note }}</p>
                                <div class="reported-info mb-2">
                                    <img src="{{ asset($report->post->user->image ) }}" alt="Post Owner Image">
                                    <span class="name">{{ $report->post->user->name }}</span>
                                </div>
                                <div class="mb-3">
                                    @if($report->post->tags->isEmpty())
                                        <span class="text-muted">No tags</span>
                                    @else
                                        @foreach($report->post->tags as $tag)
                                            <a href="{{ route('posts.filter', ['tags' => [$tag->id]]) }}" class="badge badge-info">{{ $tag->tag_name }}</a>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="card-title">{{ $report->post->title }}</div>
                                <p class="card-text post-content" style="text-align:justify;">
                                    <span class="post-short">{{ \Illuminate\Support\Str::limit($report->post->content, 120, '...') }}</span>
                                    @if(strlen($report->post->content) > 120)
                                        <button class="show-more" onclick="showMore(this, @json($report->post->content)); return false;">Show more</button>
                                    @endif
                                </p>
                                @if(!empty($report->post->image))
                                    <div class="text-center my-2">
                                        <img src="{{ asset($report->post->image) }}" alt="Post Image" class="img-fluid">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            @else
                <div class="alert alert-info text-center py-4">
                    <h5>There are currently no reports about posts</h5>
                </div>
            @endif
        </div>

        <!-- تقارير المجموعات -->
        <div id="groupReports" style="display: none;">
            <h4 class="mb-4">Group Reports</h4>
            @if($ReportsGroups->isNotEmpty())
                <div class="row">
                    @foreach($ReportsGroups as $ReportsGroup)
                        <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                            <div class="card report-card w-100">
                                <div class="report-header">
                                    <div class="reporter-info">
                                        <img src="{{ asset($ReportsGroup->user->image) }}" alt="Reporter Image">
                                        <span class="name">{{$ReportsGroup->user->name }}</span>
                                    </div>
                                    <div class="action-btns">
                                        <form action="{{ route('accept.report.group', ['id' => $ReportsGroup->group_id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to accept this report? If confirmed, the reported group will be deleted.');">Accept</button>
                                        </form>
                                        <form action="{{ route('reject.report.group', ['id' => $ReportsGroup->group_id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to reject this report?');">Reject</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="reported-info">
                                    <img src="{{ asset($ReportsGroup->group->image ) }}" alt="Group Image">
                                    <span class="name">{{$ReportsGroup->group->name}}</span>
                                </div>
                                <div class="card-body card-body-content">
                                    <p class="note mb-3">{{ $ReportsGroup->note }}</p>
                                    <div class="mb-3">
                                        <a href="{{ route('group', ['id' => $ReportsGroup->group_id]) }}" class="badge badge-info">View Group</a>
                                    </div>
                                    <div class="card-title">{{ $ReportsGroup->group->name }}</div>
                                    @if(!empty($ReportsGroup->group->image))
                                        <div class="text-center my-2">
                                            <img src="{{ asset($ReportsGroup->group->image) }}" alt="Group Image" class="img-fluid">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info text-center py-4">
                    <h5>There are currently no reports about groups</h5>
                </div>
            @endif
        </div>
    </div>

    <script>
        function showMore(btn, fullText) {
            let sibling = btn.previousElementSibling;
            while (sibling && !(sibling.classList && sibling.classList.contains('post-short'))) {
                sibling = sibling.previousElementSibling;
            }
            if (sibling) {
                sibling.innerText = fullText;
                btn.style.display = 'none';
            }
        }

        document.getElementById('showPostReports').onclick = function() {
            this.classList.add('active');
            document.getElementById('showGroupReports').classList.remove('active');
            document.getElementById('postReports').style.display = '';
            document.getElementById('groupReports').style.display = 'none';
        };

        document.getElementById('showGroupReports').onclick = function() {
            this.classList.add('active');
            document.getElementById('showPostReports').classList.remove('active');
            document.getElementById('postReports').style.display = 'none';
            document.getElementById('groupReports').style.display = '';
        };
    </script>
@endsection