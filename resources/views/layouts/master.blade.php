<!DOCTYPE html>
<html lang="en">
<head>

<style>
    .card-title a {
        color: #17a2b8;
        text-decoration: none;
    }
    .btn-outline-success {
        border-radius: 50px;
    }
    .card-img-top {
        object-fit: cover;
        height: 200px;
    }
    .d-flex {
        gap: 20px;
    }
    .avatar {
        position: relative;
        display: inline-block;
        width: 100px;
        height: 100px;
    }

    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .on {
        position: absolute;
        bottom: 0;
        right: 0;
        background-color: white;
        border-radius: 50%;
        padding: 5px;
        font-size: 20px;
        color: #007bff;
        cursor: pointer;
    }

    .bottom {
        position: absolute;
        bottom: 10px;
    }
    .create-group-btn, .create-post-btn {
        width: auto;
        margin: 5px;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 50px;
    }

    .create-group-btn {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .create-post-btn {
        background-color: #007bff;
        border-color: #007bff;
    }

    .dropdown-menu-left {
        left: auto;
        right: 0;
        transform: translateX(-100%);
    }

</style>

    <meta charset="utf-8" />
    <title>syriabook</title>
    <!-- Include CSS for Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Include jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <meta name="description" content="Admin, Dashboard, Bootstrap, Bootstrap 4, Angular, AngularJS" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
    <!-- for ios 7 style, multi-resolution icon of 152x152 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
    <link rel="apple-touch-icon" href="../assets/images/logo.png">
    <meta name="apple-mobile-web-app-title" content="Flatkit">
    <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" sizes="196x196" href="../assets/images/logo.png">

    <!-- style -->
    <link rel="stylesheet" href="../assets/animate.css/animate.min.css" type="text/css" />
    <link rel="stylesheet" href="../assets/glyphicons/glyphicons.css" type="text/css" />
    <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="../assets/material-design-icons/material-design-icons.css" type="text/css" />

    <link rel="stylesheet" href="../assets/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="../assets/styles/app.css" type="text/css" />
    <link rel="stylesheet" href="../assets/styles/font.css" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
    
<div class="app" id="app">
    <div id="aside" class="app-aside modal nav-dropdown">
        <div class="left navside dark dk" data-layout="column">
            <div class="navbar no-radius">
                <a class="navbar-brand">
                    <img src="../assets/images/logo.png" alt="." class="hide">
                </a>
            </div>
            <div class="" data-flex>
                <nav class="nav-light">
                    <ul class="nav" ui-nav>
                        <li class="nav-header hidden-folded">
                            <small class="text-muted">Main</small>
                        </li>
                        <li>
                            <a href="{{route('posts')}}">
                   
                                <span class="nav-text">Feeds</span>
                            </a>
                            @if(Auth::user()->role_id == '1' || Auth::user()->role_id == '2')
                                <a class="nav-text" href="{{ route('show.tags') }}">Admin Page Tags</a>
                                <a class="nav-text" href="{{ route('show.report.to.admin') }}">Admin Page Report</a>
                            @endif
                            @if(Auth::user()->role_id == '1'||Auth::user()->role_id == '2')
                            <a class="nav-text" href="{{ route('show.users') }}">Users Page</a>
                            @endif
                            <a class="nav-text" href="{{ route('show.all.group') }}">Groups Page</a>
                        @if(Auth::user()->role_id =='3'|| Auth::user()->role_id == '2')
                            @endif
                            <a class="nav-text" href="{{route('logout')}}">logout</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="b-t">
                <div class="nav-fold">
                    <a href="profile.html">
                        <img src="{{asset('storage/' . auth()->user()->image)  }}" 
                                     class="rounded-circle mr-3" 
                                     width="50" 
                                     height="50" 
                                     alt="User"
                                     onerror="this.src='{{ asset('images/Default_image.jpg') }}'">
                    
                        <span class="clear hidden-folded p-x">
                            <a href="{{ route('profile', ['id' => auth()->user()->id]) }}">{{ auth()->user()->name }}</a>
        	      <small class="block text-muted"><i class="fa fa-circle text-success m-r-sm"></i>online</small>
        	    </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="content" class="app-content box-shadow-z0" role="main">
        <br>
        <br>
        @yield('content2')
        <div class="app-header white box-shadow">
            <div class="navbar navbar-toggleable-sm flex-row align-items-center">
                <a data-toggle="modal" data-target="#aside" class="hidden-lg-up mr-3">

                    <i class="material-icons">&#xe5d2;</i>
                </a>
                <div class="collapse navbar-collapse" id="collapse">
                    <form action="{{ route('posts.search') }}" method="POST" class="form-inline my-2 my-lg-0">
                        @csrf
                        <input class="form-control mr-sm-2" type="search" name="content[]" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                            <i class="material-icons"></i>
                        </button>
                    </form>
                    
                  
                    @if(Route::currentRouteName() == 'show.all.group'&&auth()->user()->block!=1)

                        @endif
                </div>

                <!-- ضع هذا الكود في الهيدر العلوي (app-header أو navbar) -->
                <div class="dropdown d-inline-block ml-3">
                  <div class="dropdown">
                    <!-- Removed the settings (gear) button and its dropdown -->
                  </div>
                </div>
            </div>

        </div>
        <div class="align-content-center">
            <div class="content-section">
            </div>
            <div class="content-section">
                @yield('content3')
            </div>
            <div class="content-section">
                @yield('content8')
            </div>
        </div> @yield('content')
        <div ui-view class="app-body" id="view">
            <div class="padding">

                <div class="row">
                    @yield('content7')
                    @section('content6')
                </div>
            </div>
        </div>
    </div>
    @yield('content1')
    
        <!-- theme switcher -->
        <div id="switcher">
            <div class="switcher box-color dark-white text-color" id="sw-theme">
                <div class="dropdown">
                    <a href="#" class="box-color dark-white text-color sw-btn dropdown-toggle" id="gearDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-gear"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="gearDropdown">
                        @if(Route::currentRouteName() == 'profile')
                          @if(auth()->user()->id == ($user->id ?? null))
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editProfileModal">
                              <i class="fas fa-edit mr-2"></i> Edit Profile
                            </a>
                            <a class="dropdown-item" href="delete_user" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                              <i class="fas fa-trash-alt mr-2"></i> Delete Account
                            </a>
                          @elseif(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                            @if(isset($user) && $user->block)
                              <a class="dropdown-item" href="{{ route('unblock.user', $user->id) }}">
                                <i class="fas fa-unlock mr-2"></i> Unblock Account
                              </a>
                            @else
                              <a class="dropdown-item" href="{{ route('block.user', $user->id) }}">
                                <i class="fas fa-lock mr-2"></i> Block Account
                              </a>
                            @endif
                          @endif
                        @else
                          @if(Route::currentRouteName() != 'show.all.group')
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#createPostModal">
                              <i class="fas fa-plus mr-2"></i> Add Post
                            </a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addTagModal">
                              <i class="fas fa-tag mr-2"></i> Add Tag
                            </a>
                          @endif
                          @if(Route::currentRouteName() == 'show.all.group')
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#createGroupModal">
                              <i class="fas fa-users mr-2"></i> Add Group
                            </a>
                          @endif
                        @endif
                        @if(($isMember ?? false) || auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                        <div class="dropdown-divider"></div>
                        <div class="d-flex flex-column mb-3 p-3">
                            <!-- زر إضافة مشاركة -->
                            <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#addPostModal" id="addPostButton">
                                <i class="fa fa-plus"></i> Add Post
                            </button>

                            <!-- زر إضافة وسوم -->
                            <button type="button" class="btn btn-info btn-sm mb-2" data-toggle="modal" data-target="#addTagModal" id="addTagButton">
                                <i class="fa fa-tags"></i> Add Tags
                            </button>

                            @if(($isAdmin ?? false) == 1 || auth()->user()->role_id == 2 || auth()->user()->role_id == 1)
                                <!-- زر صفحة الإدارة -->
                                @if(isset($group))
                                <a href="{{ route('show.reports', ['id' => $group->id]) }}" class="btn btn-success btn-sm mb-2">
                                    <i class="fa fa-cog"></i> Page Admin
                                </a>
                                @endif
                            @endif

                            @if(($isAdmin ?? false) || auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                <!-- زر حذف المجموعة -->
                                @if(isset($group))
                                <a href="{{ route('delete.group', ['group_id' => $group->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this group?')">
                                    <i class="fa fa-trash"></i> Delete Group
                                </a>
                                @endif
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                <div class="box-header">
                    <a href="https://themeforest.net/item/flatkit-app-ui-kit/13231484?ref=flatfull" class="btn btn-xs rounded danger pull-right">BUY</a>
                    <h2>Theme Switcher</h2>
                </div>
            </div>

            <div class="switcher box-color black lt" id="sw-demo">
                <a href="{{ url('/chatify') }}"class="btn btn-success sw-btn"ui-toggle-class="active"target="#sw-demo"><i class="fa fa-whatsapp"></i></a>                <div class="box-header">
                    <h2>Demos</h2>
                </div>
                <div class="box-divider"></div>
                <div class="box-body">
                    <div class="row no-gutter text-u-c text-center _600 clearfix">
                        <a href="dashboard.html"
                           class="p-a col-sm-6 primary">
                            <span class="text-white">Default</span>
                        </a>
                        <a href="dashboard.0.html"
                           class="p-a col-sm-6 success">
                            <span class="text-white">Zero</span>
                        </a>
                        <a href="dashboard.1.html"
                           class="p-a col-sm-6 blue">
                            <span class="text-white">One</span>
                        </a>
                        <a href="dashboard.2.html"
                           class="p-a col-sm-6 warn">
                            <span class="text-white">Two</span>
                        </a>
                        <a href="dashboard.3.html"
                           class="p-a col-sm-6 danger">
                            <span class="text-white">Three</span>
                        </a>
                        <a href="dashboard.4.html"
                           class="p-a col-sm-6 green">
                            <span class="text-white">Four</span>
                        </a>
                        <a href="dashboard.5.html"
                           class="p-a col-sm-6 info">
                            <span class="text-white">Five</span>
                        </a>
                        <div
                            class="p-a col-sm-6 lter">
                            <span class="text">...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / -->

        <!-- ############ LAYOUT END-->

    </div>
    <!-- build:js scripts/app.html.js -->
    <!-- jQuery -->
<script>
    function toggleJoinedGroups() {
        document.getElementById("joinedGroups").style.display = "block";
        document.getElementById("notJoinedGroups").style.display = "none";
        document.getElementById("CreateGroupForm").style.display = "none";
    }


    function toggleNotJoinedGroups() {
        document.getElementById("joinedGroups").style.display = "none";
        document.getElementById("notJoinedGroups").style.display = "block";
        document.getElementById("CreateGroupForm").style.display = "none";
    }

    function toggleCreateGroupForm() {
        document.getElementById("joinedGroups").style.display = "none";
        document.getElementById("notJoinedGroups").style.display = "none";
        document.getElementById("CreateGroupForm").style.display = "block";
    }
</script>
<script>
    function toggleForm() {
        var form = document.getElementById('newTagForm');
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    }
</script>

<script>
    $(document).ready(function() {
        $('.tags').select2({
            allowClear: true,
        });
        $('#tags').select2({
            ajax: {
                url: '{{route('tags.search') }}',
                type: 'post',
                delay: 250,
                dataType: 'json',
                data: function(params) {
                    return {
                        name: params.term,
                        "_token": "{{ csrf_token() }}",
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.tag_name,
                                id: item.id
                            }
                        })
                    };
                },
            }
        });
    });
</script>

<script>
    // Toggle function for joinedGroups
    function toggleJoinedGroups() {
        const joinedGroups = document.getElementById('joinedGroups');
        const notJoinedGroups = document.getElementById('notJoinedGroups');
        const CreateGroupForm = document.getElementById('CreateGroupForm');

        // Toggle visibility for joinedGroups
        if (joinedGroups.style.display === 'none' || joinedGroups.style.display === '') {
            joinedGroups.style.display = 'block';
            notJoinedGroups.style.display = 'none';
            CreateGroupForm.style.display = 'none';
        } else {
            joinedGroups.style.display = 'none';
        }
    }

    // Toggle function for notJoinedGroups
    function toggleNotJoinedGroups() {
        const joinedGroups = document.getElementById('joinedGroups');
        const notJoinedGroups = document.getElementById('notJoinedGroups');
        const CreateGroupForm = document.getElementById('CreateGroupForm');

        // Toggle visibility for notJoinedGroups
        if (notJoinedGroups.style.display === 'none' || notJoinedGroups.style.display === '') {
            notJoinedGroups.style.display = 'block';
            joinedGroups.style.display = 'none';
            CreateGroupForm.style.display = 'none';
        } else {
            notJoinedGroups.style.display = 'none';
        }
    }

    // Toggle function for CreateGroupForm
    function toggleCreateGroupForm() {
        const CreateGroupForm = document.getElementById('CreateGroupForm');
        const joinedGroups = document.getElementById('joinedGroups');
        const notJoinedGroups = document.getElementById('notJoinedGroups');

        // Toggle visibility for CreateGroupForm
        if (CreateGroupForm.style.display === 'none' || CreateGroupForm.style.display === '') {
            CreateGroupForm.style.display = 'block';
            joinedGroups.style.display = 'none';
            notJoinedGroups.style.display = 'none';
        } else {
            CreateGroupForm.style.display = 'none';
        }
    }
</script>

<script>
    document.getElementById("showForm").addEventListener("click", function() {
        const form = document.getElementById("myForm");
        form.style.display = form.style.display === "none" ? "block" : "none";
    });
</script>
<script>
    $(document).ready(function() {
        $('#users').select2({
            placeholder: "Select users",  // Placeholder text
            allowClear: true              // Allow clearing the selection
        });
    });

</script>



</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function submitEdit() {
        const title = document.getElementById("title").value;
        const content = document.getElementById("content").value;
        const image = document.getElementById("image").files[0];

        if (title && content) {
            alert("Form submitted with title: " + title + " and content: " + content);
            var modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
            modal.hide();
        } else {
            alert("Please fill in all fields.");
        }
    }
</script>


<script>
    document.getElementById('showPostReports').addEventListener('click', function () {
        document.getElementById('postReports').style.display = 'block';
        document.getElementById('groupReports').style.display = 'none';
    });

    document.getElementById('showGroupReports').addEventListener('click', function () {
        document.getElementById('postReports').style.display = 'none';
        document.getElementById('groupReports').style.display = 'block';
    });
</script>
</div>
<!-- build:js scripts/app.html.js -->
<!-- jQuery -->
<script src="../libs/jquery/jquery/dist/jquery.js"></script>
<!-- Bootstrap -->
<script src="../libs/jquery/tether/dist/js/tether.min.js"></script>
<script src="../libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
<!-- core -->
<script src="../libs/jquery/underscore/underscore-min.js"></script>
<script src="../libs/jquery/jQuery-Storage-API/jquery.storageapi.min.js"></script>
<script src="../libs/jquery/PACE/pace.min.js"></script>

<script src="scripts/config.lazyload.js"></script>

<script src="scripts/palette.js"></script>
<script src="scripts/ui-load.js"></script>
<script src="scripts/ui-jp.js"></script>
<script src="scripts/ui-include.js"></script>
<script src="scripts/ui-device.js"></script>
<script src="scripts/ui-form.js"></script>
<script src="scripts/ui-nav.js"></script>
<script src="scripts/ui-screenfull.js"></script>
<script src="scripts/ui-scroll-to.js"></script>
<script src="scripts/ui-toggle-class.js"></script>

<script src="scripts/app.js"></script>

<!-- ajax -->
<script src="../libs/jquery/jquery-pjax/jquery.pjax.js"></script>
<script src="scripts/ajax.js"></script>
<!-- endbuild -->
<script src="../libs/jquery/jquery/dist/jquery.js"></script>
<!-- Bootstrap -->
<script src="../libs/jquery/tether/dist/js/tether.min.js"></script>
<script src="../libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
<!-- core -->
<script src="../libs/jquery/underscore/underscore-min.js"></script>
<script src="../libs/jquery/jQuery-Storage-API/jquery.storageapi.min.js"></script>
<script src="../libs/jquery/PACE/pace.min.js"></script>

<script src="scripts/config.lazyload.js"></script>

<script src="scripts/palette.js"></script>
<script src="scripts/ui-load.js"></script>
<script src="scripts/ui-jp.js"></script>
<script src="scripts/ui-include.js"></script>
<script src="scripts/ui-device.js"></script>
<script src="scripts/ui-form.js"></script>
<script src="scripts/ui-nav.js"></script>
<script src="scripts/ui-screenfull.js"></script>
<script src="scripts/ui-scroll-to.js"></script>
<script src="scripts/ui-toggle-class.js"></script>

<script src="scripts/app.js"></script>

<script>

</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- ajax -->
<script src="../libs/jquery/jquery-pjax/jquery.pjax.js"></script>
<script src="scripts/ajax.js"></script>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>

<!-- Add Tag Modal -->
<div class="modal fade" id="addTagModal" tabindex="-1" role="dialog" aria-labelledby="addTagModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('tags.user') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for="tag_name">Tag Name</label>
            <input type="text" name="tag_name" class="form-control" id="tag_name" placeholder="Enter tag name" required>
          </div>
          <button type="submit" class="btn btn-primary">Add Tag</button>
        </form>
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
            @isset($users)
            <div class="form-group">
              <label for="users">Select Users:</label>
              <select name="users[]" id="users" class="form-control select2" multiple required>
                @foreach($users as $user)
                  <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
              </select>
            </div>
            @endisset
          @endif
          <button type="submit" class="btn btn-info mt-2">Create</button>
        </form>
      </div>
    </div>
  </div>
</div>
