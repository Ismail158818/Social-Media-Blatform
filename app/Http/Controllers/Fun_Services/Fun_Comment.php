<?php
namespace  App\Http\Controllers\Fun_Services;

use App\Models\Comment;
class Fun_Comment{
    public function store_services($validated)
    {
        Comment::create($validated);
    }
}
