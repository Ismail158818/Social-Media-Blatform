@extends('layouts.master')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="groups-page">
    <div class="container py-5">
        <div class="row g-4">
            <!-- Sidebar Filters -->
            <div class="col-lg-3">
                <div class="filters-card">
                    <div class="filters-header">
                        <h4>Filter Groups</h4>
                        <p class="text-muted">Find groups that interest you</p>
                    </div>
                    <form action="{{ route('show.all.group') }}" method="GET" class="filters-form">
                        <div class="filter-group">
                            <label>Sort By</label>
                            <select name="sort" class="form-select">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                <option value="members" {{ request('sort') == 'members' ? 'selected' : '' }}>Number of Members</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Group Type</label>
                            <select name="type" class="form-select">
                                <option value="">All</option>
                                <option value="public" {{ request('type') == 'public' ? 'selected' : '' }}>Public</option>
                                <option value="private" {{ request('type') == 'private' ? 'selected' : '' }}>Private</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Apply Filters
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Tabs Navigation -->
                <div class="tabs-wrapper mb-4">
                    <ul class="nav nav-pills" id="groupsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button">
                                <i class="fas fa-globe me-2"></i>All Groups
                            </button>
                        </li>
                        @if(!in_array(auth()->user()->role_id, [1,2]))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="my-tab" data-bs-toggle="pill" data-bs-target="#my" type="button">
                                <i class="fas fa-users me-2"></i>My Groups
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="admin-tab" data-bs-toggle="pill" data-bs-target="#admin" type="button">
                                <i class="fas fa-user-shield me-2"></i>Groups I Admin
                            </button>
                        </li>
                        @endif
                    </ul>
                </div>
                <!-- Tab Content -->
                <div class="tab-content" id="groupsTabsContent">
                    <!-- All Groups Tab -->
                    <div class="tab-pane fade show active" id="all" role="tabpanel">
                        <div class="row g-4">
                            @foreach($allGroups as $group)
                                <div class="col-md-6 col-lg-4">
                                    <div class="group-card">
                                        <div class="group-header position-relative">
                                        @if(
    auth()->user()->role_id == 1 || 
    auth()->user()->role_id == 2 || 
    (isset($group->pivot) && $group->pivot->is_admin == 1)
)
    <div class="dropdown position-absolute top-0 end-0 m-2">
        <button class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px;"
                type="button"
                id="groupDropdown{{ $group->id }}"
                data-bs-toggle="dropdown"
                aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end text-end" style="min-width: 120px; left: auto; right: 0;" aria-labelledby="groupDropdown{{ $group->id }}">
            <li>
                <a class="dropdown-item text-danger"
                   href="{{ route('delete.group', ['group_id' => $group->id]) }}"
                   onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا الغروب؟')">
                    <i class="fas fa-trash me-2"></i> حذف الغروب
                </a>
            </li>
        </ul>
    </div>
@endif

                                            <img 
                                                src="{{ $group->image ? asset('storage/' . $group->image) : asset('images/Default_image.jpg') }}"
                                                alt="{{ $group->name }}"
                                                class="group-cover"
                                                onerror="this.src='{{ asset('images/Default_image.jpg') }}'">
                                            <div class="group-type">
                                                <span class="badge {{ $group->status_show == 1 ? 'bg-success' : 'bg-warning' }}">
                                                    {{ $group->status_show == 1 ? 'Public' : 'Private' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="group-body">
                                            <div class="group-info">
                                                <h5 class="group-name">{{ $group->name }}</h5>
                                                <p class="group-description">{{ $group->description }}</p>
                                                <div class="group-meta">
                                                    <span class="members-count">
                                                        <i class="fas fa-users"></i> {{ $group->users_count }} Members
                                                    </span>
                                                    <div class="group-actions mt-2">
                                                        <a href="{{ route('group.show', ['id' => $group->id]) }}" class="btn btn-outline-primary btn-sm me-2">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                        @if(!in_array(auth()->user()->role_id, [1,2]))
                                                            @if($group->users->contains(auth()->user()->id))
                               leave                             <form action="{{ route('leave.group', ['id' => $group->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد أنك تريد مغادرة المجموعة؟');">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-outline-warning btn-sm">
                                                                        <i class="fas fa-sign-out-alt"></i> مغادرة
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <form action="{{ route('join.group', ['id' => $group->id]) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-outline-primary btn-sm">
                                                                        <i class="fas fa-sign-in-alt"></i> انضمام
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- روابط التصفح لتبويب All Groups --}}
                        <div class="d-flex justify-content-center mt-4">
                            {{ $allGroups->links() }}
                        </div>
                    </div>

                    @if(!in_array(auth()->user()->role_id, [1,2]))
                    <!-- My Groups Tab -->
                    <div class="tab-pane fade" id="my" role="tabpanel">
                        <div class="row g-4">
                            @forelse($groupsJoined as $group)
                            <div class="col-md-6 col-lg-4">
                                <div class="group-card">
                                    <div class="group-header position-relative">
                                        @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2 || (isset($group->pivot) && $group->pivot->is_admin == 1))
                                            <div class="dropdown position-absolute top-0 end-0 m-2" style="z-index:10;">
                                                <button class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center dropdown-toggle"
                                                        type="button" id="dropdownMenuButton-{{ $group->id }}" data-bs-toggle="dropdown" aria-expanded="false"
                                                        style="width: 40px; height: 40px;">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton-{{ $group->id }}">
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="{{route('delete.group', ['group_id' => $group->id])}}"
                                                           onclick="return confirm('Are you sure you want to delete this group?')">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </a>
                                                    </li>
                                                    <!-- يمكنك إضافة خيارات أخرى هنا -->
                                                </ul>
                                            </div>
                                        @endif
                                        <img 
                                            src="{{ $group->image ? asset('storage/' . $group->image) : asset('images/Default_image.jpg') }}"
                                            alt="{{ $group->name }}"
                                            class="group-cover"
                                            onerror="this.src='{{ asset('images/Default_image.jpg') }}'">
                                        <div class="group-type">
                                            <span class="badge {{ $group->status_show == 1 ? 'bg-success' : 'bg-warning' }}">
                                                {{ $group->status_show == 1 ? 'Public' : 'Private' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="group-body">
                                        <div class="group-info">
                                            <h5 class="group-name">{{ $group->name }}</h5>
                                            <p class="group-description">{{ $group->description }}</p>
                                            <div class="group-meta">
                                                <span class="members-count">
                                                    <i class="fas fa-users"></i> {{ $group->users_count }} Members
                                                </span>
                                                <div class="group-actions mt-2">
                                                    <a href="{{ route('group.show', ['id' => $group->id]) }}" class="btn btn-outline-primary btn-sm me-2">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                <form action="{{ route('join.group', ['id' => $group->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to leave this group?');">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-warning btn-sm">
                                                            <i class="fas fa-sign-out-alt"></i> Leave
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="empty-state">
                                    <i class="fas fa-users-slash"></i>
                                    <h4>No Groups Joined</h4>
                                    <p>Explore available groups and join the ones that interest you</p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                        {{-- روابط التصفح لتبويب My Groups --}}
                        <div class="d-flex justify-content-center mt-4">
                            {{ $groupsJoined->links() }}
                        </div>
                    </div>

                    <!-- Admin Groups Tab -->
                    <div class="tab-pane fade" id="admin" role="tabpanel">
                        <div class="row g-4">
                            @forelse($adminGroups as $group)
                            <div class="col-md-6 col-lg-4">
                                <div class="group-card">
                                    <div class="group-header">
                                        <img 
                                            src="{{ $group->image ? asset('storage/' . $group->image) : asset('images/Default_image.jpg') }}"
                                            alt="{{ $group->name }}"
                                            class="group-cover"
                                            onerror="this.src='{{ asset('images/Default_image.jpg') }}'">
                                        <div class="group-type">
                                            <span class="badge {{ $group->status_show == 1 ? 'bg-success' : 'bg-warning' }}">
                                                {{ $group->status_show == 1 ? 'Public' : 'Private' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="group-body">
                                        <div class="group-info">
                                            <h5 class="group-name">{{ $group->name }}</h5>
                                            <p class="group-description">{{ $group->description }}</p>
                                            <div class="group-meta">
                                                <span class="members-count">
                                                    <i class="fas fa-users"></i> {{ $group->users_count ?? $group->users->count() }} Members
                                                </span>
                                                <div class="group-actions mt-2">
                                                    <a href="{{ route('group.show', ['id' => $group->id]) }}" class="btn btn-outline-primary btn-sm me-2">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="empty-state">
                                    <i class="fas fa-user-shield"></i>
                                    <h4>No groups you admin</h4>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.groups-page {
    background-color: #f8f9fa;
    min-height: 100vh;
}

/* Filters Card */
.filters-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 2px 15px rgba(0,0,0,0.05);
}

.filters-header {
    margin-bottom: 1.5rem;
}

.filters-header h4 {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.filter-group {
    margin-bottom: 1.25rem;
}

.filter-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #495057;
}

.form-select {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    padding: 0.625rem;
    font-size: 0.95rem;
}

/* Tabs */
.tabs-wrapper {
    background: white;
    padding: 1rem;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.05);
}

.nav-pills {
    gap: 0.5rem;
}

.nav-pills .nav-link {
    border-radius: 8px;
    padding: 0.75rem 1.25rem;
    font-weight: 500;
    color: #6c757d;
    transition: all 0.3s ease;
}

.nav-pills .nav-link.active {
    background-color: #0d6efd;
    color: white;
}

/* Group Cards */
.group-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.group-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.group-header {
    position: relative;
    height: 180px;
    overflow: hidden;
    border-radius: 12px 12px 0 0;
}

.group-cover {
    width: 100%;
    height: 220px;
    object-fit: cover;
    aspect-ratio: 1/1;
    display: block;
    border-radius: 12px 12px 0 0;
}

.group-type {
    position: absolute;
    top: 1rem;
    right: 1rem;
    z-index: 2;
}

.badge {
    padding: 0.5em 1em;
    font-weight: 500;
    border-radius: 6px;
}

.group-body {
    padding: 1.5rem;
}

.group-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.group-name {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: #2c3e50;
}

.group-description {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.group-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.members-count {
    color: #6c757d;
    font-size: 0.9rem;
}

.group-actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.group-actions .btn {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 0.25rem;
    transition: all 0.2s ease;
}

.group-actions .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.group-actions .btn-outline-primary {
    border-color: #0d6efd;
    color: #0d6efd;
}

.group-actions .btn-outline-primary:hover {
    background-color: #0d6efd;
    color: white;
}

.group-actions .btn-outline-danger {
    border-color: #dc3545;
    color: #dc3545;
}

.group-actions .btn-outline-danger:hover {
    background-color: #dc3545;
    color: white;
}

.group-actions .btn-outline-secondary {
    border-color: #6c757d;
    color: #6c757d;
}

.group-actions .btn-outline-secondary:hover {
    background-color: #6c757d;
    color: white;
}

.group-actions-dropdown {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 10;
}

.group-actions-dropdown .btn {
    background: rgba(255, 255, 255, 0.9);
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 0.25rem 0.5rem;
}

.group-actions-dropdown .btn:hover {
    background: white;
}

.dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-radius: 0.5rem;
    min-width: 120px;
    background: white;
    margin-top: 0.5rem;
    z-index: 9999;
}

.dropdown-menu.show {
    display: block;
}

.dropdown-item {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #333;
    text-decoration: none;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.dropdown-item.text-danger:hover {
    background-color: #dc3545;
    color: white !important;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.05);
}

.empty-state i {
    font-size: 3rem;
    color: #dee2e6;
    margin-bottom: 1rem;
}

.empty-state h4 {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #6c757d;
    margin: 0;
}

/* أضف هذا للـ CSS لجعل الزر دائماً دائري وبارز */
.group-card .position-absolute.top-0.end-0 {
    z-index: 10;
}

[id^="action-btn-"] {
    position: absolute;
    right: 0;
    top: 45px; /* أو حسب الحاجة أسفل الزر */
    z-index: 9999;
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border-radius: 8px;
    min-width: 120px;
}
</style>

@push('scripts')
<script>
function toggleActionBtn(id) {
    // إغلاق كل القوائم المفتوحة أولاً
    document.querySelectorAll('[id^="action-btn-"]').forEach(el => {
        if (el.id !== 'action-btn-' + id) el.style.display = 'none';
    });
    // تبديل ظهور القائمة المطلوبة
    const el = document.getElementById('action-btn-' + id);
    el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'block' : 'none';

    // إغلاق عند النقر خارج الزر (بعد التأكد أن النقر الأول انتهى)
    setTimeout(() => {
        document.addEventListener('click', function closeMenu(e) {
            if (!el.contains(e.target) && !e.target.closest('.btn-outline-secondary')) {
                el.style.display = 'none';
                document.removeEventListener('click', closeMenu);
            }
        });
    }, 10);
}
</script>
@endpush

<!-- Add Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
