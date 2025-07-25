<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Http\Controllers\Fun_Services\Fun_Tag;
use App\Http\Controllers\Fun_Services\Fun_Post;
use Illuminate\Http\Request;

class TagsController extends Controller
{

    public function filter(Request $request)
    {
        $filter = new Fun_Tag();
        $posts = $filter->filter_services($request);
        return view('posts_tag', compact('posts'));
    }

    public function tags_user(TagRequest $request)
    {
        $validated = $request->validated();
        $tags = new Fun_Tag();
        $tags->tags_user_services($validated);

        return redirect()->back();
    }

    public function upVote($id)
    {
        $upvote = new Fun_Post();
        $upvote->upVote_services($id);
        return redirect()->back();
    }

    public function downVote($id)
    {
        $downvote = new Fun_Post();
        $downvote->downVote_services($id);
        return redirect()->back();
    }
}
