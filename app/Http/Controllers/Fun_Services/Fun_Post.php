<?php
namespace App\Http\Controllers\Fun_Services;
use App\Http\Requests\PostRequest;
use App\Http\Requests\ReportPostRequest;
use App\Models\Group;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class Fun_Post
   {
    public function index_services()
    {
        $user = auth()->user()->id;

        $posts = Post::whereNull('group_id')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user)
                    ->orWhereHas('user.followers', function ($query) use ($user) {
                        $query->where('follower_id', $user);
                    })
                    ->orWhere(function ($query) {
                        $query->whereHas('user', function ($query) {
                            $query->whereIn('role_id', [1, 2]);
                        });
                    });
            })
            ->with([
                'comments' => function ($query) {
                    $query->take(3);
                },
                'authedRating',
                'tags',
                'user'
            ])
            ->withCount([
                'usersRatings as upVotesCount' => function ($q) {
                    $q->where('type', 'upVote');
                },
                'usersRatings as downVotesCount' => function ($q) {
                    $q->where('type', 'downVote');
                }
            ])
            ->paginate(4);


        // جلب المجموعات التي انضم إليها المستخدم
        $groupsJoined = Group::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user);
        })
            ->inRandomOrder()
            ->take(4)
            ->get();

        // جلب المجموعات التي لم ينضم إليها المستخدم
        $groupsNotJoined = Group::whereDoesntHave('users', function ($query) use ($user) {
            $query->where('user_id', $user);
        })
            ->inRandomOrder()
            ->take(4)
            ->get();
        $users = User::where('role_id', '!=', 2)
            ->where('role_id', '!=', 1)
            ->get();

        return [
            'users' => $users,
            'groupsNotJoined' => $groupsNotJoined,
            'groupsJoined' => $groupsJoined,
            'posts' => $posts,
        ];
    }


//        foreach ($posts as $post)
//        {
//            $post['upVotesCount'] = Rating::where('post_id', $post->id)->where('type', 'upVote')->count();
//        }
//            dd($ratingsCount);

    public function upVote_services($id)
    {
        $user = User::with('postsRatings')->where('id', auth()->user()->id)->first();
        $ratings = $user->postsRatings()->where('post_id', $id)->get();

        if ($ratings->isEmpty() || $ratings->first()->pivot->type == 'downVote') {
            $user->postsRatings()->syncWithoutDetaching([$id => ['type' => 'upVote']]);
        } elseif ($ratings->first()->pivot->type == 'upVote') {
            $user->postsRatings()->detach($id);
        }
//        if (!$ratings->isEmpty()) {
//            if ($ratings->first()->pivot->type == 'upVote') {
//                $user->postsRatings()->detach($id);
//            } elseif ($ratings->first()->pivot->type == 'downVote') {
//                //Method 1
//               // $user->postsRatings()->detach($id);
//               // $user->postsRatings()->attach($id, ['type' => 'upVote']);
//
//                //Method 2
//                // $user->postsRatings()->syncWithoutDetaching([$id => ['type' => 'upVote']]);
//
//                //Method 3
//                $user->postsRatings()->updateExistingPivot($id, ['type' => 'upVote']);
//            }
//        }else {
//            $user->postsRatings()->attach($id, ['type' => 'upVote']);
//        }
    }
    public function downVote_services($id)
    {
        $user = User::with('postsRatings')->where('id', auth()->user()->id)->first();
        $ratings = $user->postsRatings()->where('post_id', $id)->get();

        if ($ratings->isEmpty() || $ratings->first()->pivot->type == 'upVote') {
            $user->postsRatings()->syncWithoutDetaching([$id => ['type' => 'downVote']]);
        } elseif ($ratings->first()->pivot->type == 'downVote') {
            $user->postsRatings()->detach($id);
        }
    }
        public function delete_post_or_comment_or_account_services($request)
        {
            $post = Post::find($request->id);
            
            if($request->type=='post')
            {
                $post->comments()->delete();
                $post->Reports()->delete();
                $post->authedRating()->detach();
                $post->tags()->detach();
                $post->delete();
            }
            elseif($request->type=='comment'){
                $post->comments()->delete();
            }
        }
    public function report_services($request){
        $post = Post::where('id', $request->post)->first();
        $existing_report = Report::where('post_id', $request->post)->where('user_id', auth()->user()->id)->first();

        if (!$existing_report) {
            Report::create([
                'post_id' => $post->id,
                'title' => $post->title,
                'note' => $request->note,
                'content' => $post->content,
                'user_id' => auth()->user()->id,
            ]);
        }
    }


    public function search_services($request)
    {
        $content = $request->content;
        $user = auth()->user(); // الحصول على المستخدم الحالي
        $posts = Post::where(function ($query) use ($user) {
            $query->whereHas('group', function ($query) use ($user) {
                $query->whereHas('users', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            })
                ->orWhereNull('group_id');
        })
            ->where(function ($query) use ($content) {
                foreach ($content as $item) {
                    $query->orWhere('content', 'LIKE', '%' . $item . '%')
                        ->orWhere('title', 'LIKE', '%' . $item . '%');
                }
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

    public function Edit_Post_Services(Request $request)
    {
        $post = Post::find($request->id);

        if ($post) {
            $post->update([
                'title' => $request->title,
                'content' => $request->con,
            ]);

            $post->tags()->sync($request->tags);

            if ($request->hasFile('image')) {
                if ($post->image && Storage::exists('public/images/' . $post->image)) {
                    Storage::delete('public/images/' . $post->image);
                }

                $imageName = time() . '.' . $request->image->extension();
                $request->image->storeAs('public', $imageName);

                $post->update(['image' => $imageName]);
            }
        }
    }



}
