<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Fun_Services\Fun_Post;
use App\Http\Controllers\Fun_Services\Fun_Tag;
use App\Http\Requests\PostRequest;
use App\Http\Requests\ReportGroupRequest;
use App\Http\Requests\ReportPostRequest;
use App\Models\Comment;
use App\Models\Group;
use App\Models\Post;
use App\Models\Rating;
use App\Models\User;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Utag;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class PostController extends Controller
{
    public function index()
    {
        $index = new Fun_Post();
        $data = $index->index_services();
        if(auth()->user()->block==0)
        {
            return view('pages.posts.index', [
                'posts' => $data['posts'],
                'groupsJoined' => $data['groupsJoined'],
                'groupsNotJoined' => $data['groupsNotJoined'],
                'users' => $data['users'],
            ]);
        }else{
            return view('pages.posts.index_block', [
                'posts' => $data['posts'],
                'groupsJoined' => $data['groupsJoined'],
                'groupsNotJoined' => $data['groupsNotJoined'],
                'users' => $data['users'],
            ]);
        }

    }

    public function upVote($id)
    {
        $up = new Fun_Post();
        $up->upvote_services($id);
        return redirect()->back();
    }

    public function downVote($id)
    {
        $down = new Fun_Post();
        $down->downvote_services($id);
        return redirect()->back();

    }

    public function report(Request $request)
    {
       $report=new Fun_Post();
       $report->report_services($request);

            return redirect()->back();
        }



    public function delete_post_or_comment_or_account(Request $request)
    {
        $delete = new Fun_Post();
        $delete->delete_post_or_comment_or_account_services($request);
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $search = new Fun_Post();
        $posts = $search->search_services($request);
        return view('posts_tag', compact('posts'));
    }

    // PostController.php

    public function edit_post(Request $request)
    {
        $edit = new Fun_Post();
        $edit->Edit_Post_Services($request);
        return redirect()->back();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (auth()->user()->id !== $post->user_id) {
            return redirect()->back()->with('error', 'You are not authorized to edit this post.');
        }
        return view('pages.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if (auth()->user()->id !== $post->user_id) {
            return redirect()->back()->with('error', 'You are not authorized to update this post.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $post->title = $request->title;
        $post->content = $request->content;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image) {
                Storage::delete('public/' . $post->image);
            }
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->save();

        return redirect()->route('posts.show', $post->id)->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (auth()->user()->id !== $post->user_id) {
            return redirect()->back()->with('error', 'You are not authorized to delete this post.');
        }

        // Delete post image if exists
        if ($post->image) {
            Storage::delete('public/' . $post->image);
        }

        $post->delete();

        return redirect()->route('posts')->with('success', 'Post deleted successfully.');
    }

  
}

