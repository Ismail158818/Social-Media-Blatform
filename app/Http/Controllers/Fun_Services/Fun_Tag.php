<?php


namespace  App\Http\Controllers\Fun_Services;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Models\Utag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Fun_Tag
{



    public function filter_services($request)
    {
        $tagIds = $request->tags;
        $posts = Post::where('group_id', null)->whereHas('tags', function ($query) use ($tagIds) {
            $query->whereIn('tag_id', $tagIds);
        })
            ->with(['comments' => function ($query) {
                return $query->take(3);
            }, 'authedRating'])
            ->withCount([
                'usersRatings as upVotesCount' => function ($q) {
                    return $q->where('type', 'upVote');
                },
                'usersRatings as downVotesCount' => function ($q) {
                    return $q->where('type', 'downVote');
                }
            ])
            ->get();

        return $posts;
    }

    public function tags_user_services($validated)
    {
        $users = User::all()->count();
        $PercentUsers = $users * 0.3;
        $utag = Utag::select('tag_name', DB::raw('count(*) as count'))
            ->groupBy('tag_name')->having('count', '>', $PercentUsers)->get();

        $existing_Utag = Utag::where('tag_name', $validated['newtag'])->where('user_id', auth()->id())->first();
        $existing_tag = Tag::where('tag_name', $validated['newtag'])->first();

        if (!$existing_tag) {
            if (!$existing_Utag) {
                $new_tag = Utag::create([
                    'tag_name' => $validated['newtag'],
                    'user_id' => auth()->id(),
                ]);
                if ($utag->isNotEmpty()) {
                    $new_tag = Tag::create([
                        'tag_name' => $validated['newtag'],
                        'user_id' => auth()->id(),
                    ]);
                    Utag::where('tag_name', $validated['newtag'])->delete();
                }
            }
        }
    }

}
