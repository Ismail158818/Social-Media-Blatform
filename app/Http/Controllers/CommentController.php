<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Fun_Services\Fun_Comment;
use App\Http\Requests\CommentRequset;
use App\Models\Comment;
use Illuminate\Http\Request;
class CommentController extends Controller
{
    public function store(CommentRequset $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        $store=new Fun_Comment();
        $store->store_services($validated);

        return redirect()->back();
    }
}
