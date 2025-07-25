<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::redirect('/', 'posts');

    // User Routes
    Route::controller(UserController::class)->prefix('user')->group(function () {
        Route::get('follow/{id}', 'follow')->name("follow");
        Route::get('followers', 'followers');
        Route::get('show-users', 'show_users')->middleware('Check:1,2')->name('show.users');
        Route::get('user-add-admin', 'user_add_admin')->name("user.add.admin");
        Route::post('edit-info', 'edit_info')->name("edit.info");
        Route::post('/add-members',  'addMembers')->name('add.members');
        Route::get('show-user-following-or-follower',  'show_user_following_or_follower')->name('show.user.following.or.follower');
    });

    // Post Routes
    Route::controller(PostController::class)->prefix('posts')->group(function () {
        Route::get('/', 'index')->name('posts');
        Route::get('create', 'create')->name('posts.create');
        Route::get('show/{id}', 'show')->name('posts.show');
        Route::post('store', 'post_store')->name('posts.store');
        Route::get('up-vote/{id}', 'upVote')->name('posts.upVote');
        Route::get('down-vote/{id}', 'downVote')->name('posts.downVote');
        Route::get('/tag-search', 'dataAjax')->name('search1');
        Route::post('delete-post-or-comment-or-account',  'delete_post_or_comment_or_account')->name('delete.post.or.comment');
        Route::post('posts-report/{post}', 'report')->name('posts.report');
        Route::post('posts-search', 'search')->name('posts.search');
        Route::post('edit-post', 'edit_post')->name('post.edit');
    });

    Route::controller(CommentController::class)->prefix('comments')->group(function () {
        Route::post('store', 'store')->name('comments.store');
    });

    Route::get('profile/{id}', [UserController::class, 'profile'])->name("profile");

    Route::controller(TagsController::class)->group(function () {
        Route::get('posts_tag', 'filter')->name('posts.filter');
        Route::get('up-vote/{id}', 'upVote')->name('upVote');
        Route::get('down-vote/{id}', 'downVote')->name('downVote');
        Route::post('tags-user', 'tags_user')->name('tags.user');
        Route::post('search', 'search')->name('search1');
    });

    // Admin Routes
    Route::controller(AdminController::class)->group(function () {
        Route::get('page-tags-admin', 'page_tags_admin')->middleware('Check:1,2')->name('show.tags');
        Route::get('show-report-to-admin', 'show_report_to_admin')->middleware('Check:1,2')->name('show.report.to.admin');
        Route::post('tags-users-add', 'add_users_tag')->name('tags.users.add');
        Route::post('tags.add', 'add_tag')->name('tags.add');
        Route::delete('tags.delete/{name}', 'delete_tag')->name('tags.delete');
        Route::post('group-report','group_report')->name('group.report');
        Route::post('accept-report-group','accept_report_group')->name('accept.report.group');
        Route::post('reject-report-group','reject_report_group')->name('reject.report.group');
        Route::post('accept-report-post', 'accept_report_post')->name('accept.report.post');
        Route::post('reject-report-post', 'reject_report_post')->name('reject.report.post');
        Route::get('user-or-demote-or-delete-or-block', 'user_or_demote_or_delete_or_block')->name('add.or.demote.or.delete.or.block');
    });

    Route::controller(GroupController::class)->group(function () {
        Route::post('creat-group','creat_group')->name('creat.group');
        Route::post('join-group/{id}','join_group')->name('join.group');
        Route::get('group/{id}', 'group')->name('group.show');
        Route::get('show-groups','show_groups')->name('show.groups');
        Route::post('store', 'post_store_group')->name('posts.store.group');
        Route::post('posts-report-group/{post}', 'report_admin_groupe')->name('posts.report.admin.groupe');
        Route::get('show-reports-admin-group', 'show_reports')->middleware('CheckGroupAdmin:1')->name('show.reports');
        Route::get('posts_tag_group', 'filter_tag_posts_group')->name('posts.filter.group');
        Route::get('show-all/{id}','show_all_subscribers')->middleware('CheckGroupAdmin:1,2')->name('show.all.subscribers');
        Route::get('show-related/{id}','show_related_subscribers')->name('show.related.subscribers');
        Route::post('search', 'search')->name('tags.search');
        Route::post('search1', 'search_group')->name('tags.search.group');
        Route::post('tags-user-group', 'tags_user_group')->name('tags.user.group');
        Route::get('delete', 'delete_post')->name('delete.post.group');
        Route::post('delete-admin', 'delete_admin')->name('delete.admin');
        Route::get('add-or-delete-user-group', 'add_or_delete_user_group')->name('add.or.delete.user.group');
        Route::post('delete-user', 'delete_user')->name('delete.user');
        Route::get('delete-group/{group_id}', 'delete_group')->name('delete.group');
        Route::get('show-all-group', 'show_all_group')->name('show.all.group');
        Route::get('status-group', 'status_group')->name('status.group');
        Route::get('status-show-group', 'status_show_group')->name('status.show.group');
        Route::post('action-post-group', 'action_post_group')->name('action.post.group');
        Route::get('login1', function () {
            return view('login1');
        })->name('login1');
    });

    // Block/Unblock User Routes
    Route::get('/block-user/{id}', [UserController::class, 'blockUser'])->name('block.user');
    Route::get('/unblock-user/{id}', [UserController::class, 'unblockUser'])->name('unblock.user');
    Route::delete('delete-user',[UserController::class, 'Delete_user'])->name('delete_user');
});

require __DIR__.'/auth.php';
