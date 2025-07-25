<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/csbootstrap.min.css" rel="stylesheet">

    <meta charset="utf-8" />
    <title>syriabook</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <!-- build:css ../assets/styles/app.min.css -->
    <link rel="stylesheet" href="../assets/styles/app.css" type="text/css" />
    <!-- endbuild -->
    <link rel="stylesheet" href="../assets/styles/font.css" type="text/css" />

</head>
<body>
<div class="app" id="app">
    <!-- ############ LAYOUT START-->
    <!-- aside -->
    <div id="aside" class="app-aside modal nav-dropdown">
        <div class="left navside dark dk" data-layout="column">
            <div class="navbar no-radius">
                <!-- brand -->
                <a class="navbar-brand">
                    <span class="hidden-folded inline">Flatkit</span>
                </a>
            </div>
        
            <div class="" data-flex>
                <nav class="nav-light">
                    <ul class="nav" ui-nav>
                        <li class="nav-header hidden-folded">
                            <small class="text-muted">Main</small>
                        </li>
                        <li>
                            <a href="{{ route('posts') }}">
                                <span class="nav-icon">
                                    <i class="material-icons">&#xe3fc;</i>
                                    <span ui-include="'../assets/images/i_0.svg'"></span>
                                </span>
                                <span class="nav-text">Feeds</span>
                            </a>
        
                            <!-- روابط خاصة بالدور الإداري -->
                            @if(Auth::user()->role_id == '1' || Auth::user()->role_id == '2')
                                <a class="nav-text" href="{{ route('show.tags') }}">Admin Page Tags</a>
                                <a class="nav-text" href="{{ route('show.report.to.admin') }}">Admin Page Report</a>
                                <a class="nav-text" href="{{ route('show.users') }}">Users Page</a>
                            @endif
        
                            <!-- رابط المجموعات -->
                            <a class="nav-text" href="{{ route('show.all.group') }}">Groups Page</a>
        
                            <!-- رابط الخروج -->
                            <a class="nav-text" href="{{ route('logout') }}">logout</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        
            <div class="b-t">
                <div class="nav-fold">
                    <a href="profile.html">
                        @if(!empty(auth()->user()->image))
                            <div class="mr-3">
                                <img src="{{ asset(auth()->user()->image) }}" class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;" alt="Post Image">
                            </div>
                        @endif
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
        <div class="app-header white box-shadow">

            <div class="navbar navbar-toggleable-sm flex-row align-items-center">
                <!-- Open side - Naviation on mobile -->

                <a data-toggle="modal" data-target="#aside" class="hidden-lg-up mr-3">
                    <i class="material-icons">&#xe5d2;</i>
                </a>
                <div class="mb-0 h5 no-wrap" ng-bind="$state.current.data.title" id="pageTitle"></div>


                <ul class="nav navbar-nav ml-auto flex-row">

                    <li class="nav-item dropdown">
                        <a class="nav-link p-0 clear" href="#" data-toggle="dropdown">

                            <span class="avatar w-32">
                    <img src="../assets/images/a0.jpg" alt="...">
                    <i class="on b-white bottom"></i>
                  </span>

                        </a>

                        <div ui-include="'../views/blocks/dropdown.user.html'"></div>
                    </li>

                    <li class="nav-item hidden-md-up">
                        <a class="nav-link pl-2" data-toggle="collapse" data-target="#collapse">
                            <i class="material-icons">&#xe5d4;</i>
                        </a>
                    </li>
                </ul>
                @yield('c')
                </div> </div> </div>
        
    
    

    <!-- theme switcher -->
    <div id="switcher">
        <div class="switcher box-color dark-white text-color" id="sw-theme">
            <a href ui-toggle-class="active" target="#sw-theme" class="box-color dark-white text-color sw-btn">
                <i class="fa fa-gear"></i>
            </a>

            <div class="box-header">
                <a href="https://themeforest.net/item/flatkit-app-ui-kit/13231484?ref=flatfull" class="btn btn-xs rounded danger pull-right">BUY</a>
                <h2>Theme Switcher</h2>
            </div>
            
            <div class="box-divider"></div>
            <div class="box-body">
                <p class="hidden-md-down">
                    <label class="md-check m-y-xs"  data-target="folded">
                        <input type="checkbox">
                        <i class="green"></i>
                        <span class="hidden-folded">Folded Aside</span>
                    </label>
                    <label class="md-check m-y-xs" data-target="boxed">
                        <input type="checkbox">
                        <i class="green"></i>
                        <span class="hidden-folded">Boxed Layout</span>
                    </label>
                    <label class="m-y-xs pointer" ui-fullscreen>
                        <span class="fa fa-expand fa-fw m-r-xs"></span>
                        <span>Fullscreen Mode</span>
                    </label>
                </p>
                <p>Colors:</p>
                <p data-target="themeID">
                    <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'primary', accent:'accent', warn:'warn'}">
                        <input type="radio" name="color" value="1">
                        <i class="primary"></i>
                    </label>
                    <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'accent', accent:'cyan', warn:'warn'}">
                        <input type="radio" name="color" value="2">
                        <i class="accent"></i>
                    </label>
                    <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'warn', accent:'light-blue', warn:'warning'}">
                        <input type="radio" name="color" value="3">
                        <i class="warn"></i>
                    </label>
                    <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'success', accent:'teal', warn:'lime'}">
                        <input type="radio" name="color" value="4">
                        <i class="success"></i>
                    </label>
                    <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'info', accent:'light-blue', warn:'success'}">
                        <input type="radio" name="color" value="5">
                        <i class="info"></i>
                    </label>
                    <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'blue', accent:'indigo', warn:'primary'}">
                        <input type="radio" name="color" value="6">
                        <i class="blue"></i>
                    </label>
                    <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'warning', accent:'grey-100', warn:'success'}">
                        <input type="radio" name="color" value="7">
                        <i class="warning"></i>
                    </label>
                    <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'danger', accent:'grey-100', warn:'grey-300'}">
                        <input type="radio" name="color" value="8">
                        <i class="danger"></i>
                    </label>
                </p>
                <p>Themes:</p>
                <div data-target="bg" class="row no-gutter text-u-c text-center _600 clearfix">
                    <label class="p-a col-sm-6 light pointer m-0">
                        <input type="radio" name="theme" value="" hidden>
                        Light
                    </label>
                    <label class="p-a col-sm-6 grey pointer m-0">
                        <input type="radio" name="theme" value="grey" hidden>
                        Grey
                    </label>
                    <label class="p-a col-sm-6 dark pointer m-0">
                        <input type="radio" name="theme" value="dark" hidden>
                        Dark
                    </label>
                    <label class="p-a col-sm-6 black pointer m-0">
                        <input type="radio" name="theme" value="black" hidden>
                        Black
                    </label>
                </div>
            </div>
        </div>

        <div class="switcher box-color black lt" id="sw-demo">
            <a href="#" id="toggleButton" class="box-color black lt text-color sw-btn">
                <i class="fa fa-bars text-white"></i>
            </a>

            @if($isMember || auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                <div id="sideMenu" style="display: none; position: fixed; left: 0; top: 0; height: 100%; width: 250px; background-color: #f8f9fa; box-shadow: 2px 0px 5px rgba(0,0,0,0.5); padding-top: 20px; padding-left: 15px;">
                    <div class="d-flex flex-column mb-3 p-3">
                        <!-- زر إضافة مشاركة -->
                        <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#addPostModal" id="addPostButton">
                            <i class="fa fa-plus"></i> Add Post
                        </button>

                        <!-- زر إضافة وسوم -->
                        <button type="button" class="btn btn-info btn-sm mb-2" data-toggle="modal" data-target="#addTagModal" id="addTagButton">
                            <i class="fa fa-tags"></i> Add Tags
                        </button>

                        @if($isAdmin == 1 || auth()->user()->role_id == 2 || auth()->user()->role_id == 1)
                            <!-- زر صفحة الإدارة -->
                            <a href="{{ route('show.reports', ['id' => $group->id]) }}" class="btn btn-success btn-sm mb-2">
                                <i class="fa fa-cog"></i> Page Admin
                            </a>
                        @endif

                        @if($isAdmin || auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                            <!-- زر حذف المجموعة -->
                            <a href="{{ route('delete.group', ['group_id' => $group->id]) }}" class="btn btn-danger btn-sm" onclick="return confirmDelete()">
                                <i class="fa fa-trash"></i> Delete Group
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var toggleButton = document.getElementById('toggleButton');
                    var sideMenu = document.getElementById('sideMenu');

                    toggleButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (sideMenu.style.display === 'none') {
                            sideMenu.style.display = 'block';
                        } else {
                            sideMenu.style.display = 'none';
                        }
                    });
                });
            </script>






            <div class="box-header">
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
    function toggleForm() {
        var form = document.getElementById('newTagForm');
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    }
</script>
<script>
    $('#tags').select2({
        ajax: {
            url: '{{ route('tags.search.group') }}',
            type: 'post',
            delay: 250,
            dataType: 'json',
            data: function(params) {
                return {
                    name: params.term,
                    "_token": "{{ csrf_token() }}",
                    "group_id": "{{ $group->id }}"
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
</script>
<script>
    function toggleJoinedGroups() {
        const joinedGroups = document.getElementById('joinedGroups');
        const notJoinedGroups = document.getElementById('notJoinedGroups');
        const CreateGroupForm = document.getElementById('CreateGroupForm');

        if (joinedGroups.style.display === 'block') {
            joinedGroups.style.display = 'none';
        } else {
            joinedGroups.style.display = 'block';
            notJoinedGroups.style.display = 'none';
            CreateGroupForm.style.display = 'none';
        }
    }

    function toggleNotJoinedGroups() {
        const joinedGroups = document.getElementById('joinedGroups');
        const notJoinedGroups = document.getElementById('notJoinedGroups');
        const CreateGroupForm = document.getElementById('CreateGroupForm');

        if (notJoinedGroups.style.display === 'block') {
            notJoinedGroups.style.display = 'none';
        } else {
            notJoinedGroups.style.display = 'block';
            joinedGroups.style.display = 'none';
            CreateGroupForm.style.display = 'none';
        }
    }

    function toggleCreateGroupForm() {
        const CreateGroupForm = document.getElementById('CreateGroupForm');
        const joinedGroups = document.getElementById('joinedGroups');
        const notJoinedGroups = document.getElementById('notJoinedGroups');

        if (CreateGroupForm.style.display === 'block') {
            CreateGroupForm.style.display = 'none';
        } else {
            CreateGroupForm.style.display = 'block';
            joinedGroups.style.display = 'none';
            notJoinedGroups.style.display = 'none';
        }
    }
</script>
<script>
    function toggleReportForm(postId) {
        const modalHtml = document.getElementById('reportPostModalTemplate').innerHTML.replace(/<%= postId %>/g, postId);
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        $('#reportPostModal-' + postId).modal('show');
    }
</script>
<script>
    document.getElementById("showForm").addEventListener("click", function() {
        const form1 = document.getElementById("myForm");
        form1.style.display = form1.style.display === "none" ? "block" : "none";
    });

    document.getElementById("showForm1").addEventListener("click", function() {
        const form2 = document.getElementById("myForm1");
        form2.style.display = form2.style.display === "none" ? "block" : "none";
    });
</script>
<script>
    function toggleReportForm(postId) {
        var form = document.getElementById('reportForm-' + postId);
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    }
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
<script src="../libs/jquery/jquery-pjax/jquery.pjax.js"></script>
<script src="scripts/ajax.js"></script>
<script src="../libs/jquery/jquery/dist/jquery.js"></script>
<script src="../libs/jquery/tether/dist/js/tether.min.js"></script>
<script src="../libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
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
<script src="../libs/jquery/jquery-pjax/jquery.pjax.js"></script>
<script src="scripts/ajax.js"></script>
</body>
</html>
