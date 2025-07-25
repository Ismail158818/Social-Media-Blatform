<?php
namespace  App\Http\Controllers\Fun_Services;
use App\Http\Requests\GroupRequest;
use App\Models\Comment;
use App\Models\Group;
use App\Models\Post;
use App\Models\Report;
use App\Models\ReportGroup;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Fun_Group
{
    public function creat_group_services($validated)
    {
        $imagePath = null;
        if (isset($validated['photo'])) {
            $imageName = time() . '.' . $validated['photo']->getClientOriginalExtension();
            $validated['photo']->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        }

        $group = Group::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image' => $imagePath,
        ]);
        if (isset($validated['users']) && !empty($validated['users'])) {
            $users = collect($validated['users']);
            foreach ($users as $userId) {
                $group->users()->syncWithoutDetaching([$userId => ['is_admin' => 1]]);
            }
        } else {
            // إذا لم يكن هناك مستخدمين، اجعل المستخدم الحالي هو المدير
            $group->users()->syncWithoutDetaching([auth()->user()->id => ['is_admin' => 1]]);
        }

        return $group;
    }


    public function join_group_services($request)
    {
        $userId = auth()->user()->id;
        $groupId = $request->id;
        $group = Group::findOrFail($groupId);
            $group->users()->toggle([$userId => ['is_admin' => 0]]);
    }

    public function group_services($id)
    {
        $group = Group::findOrFail($id);

        $auth = auth()->user();

        $isJoined = $group->users->contains($auth);


        $buttonText = $isJoined ? 'joined' : 'join';
        $isMember = $group->users->contains(auth()->user()->id);
        $posts = Post::where('group_id', $id)
            ->with([
                'comments' => function ($query) {
                    $query->take(3); // Limit comments to 3 per post
                },
                'authedRating',
                'tags'
            ])->get();
        $user = auth()->user();
        $isAdmin = $group->users()->where('user_id', $user->id)->value('is_admin');

        $allsubscribers = User::whereHas('groups', function ($query) use ($id) {
            $query->where('group_id', $id);
        })->count();
        $relatedSubscribers = User::whereHas('groups', function ($query) use ($id) {
            $query->where('group_id', $id);
        })->whereHas('followers', function ($query) {
            $query->where('follower_id', auth()->user()->id);
        })->count();

        return [
            'group' => $group,
            'isMember' => $isMember,
            'buttonText' => $buttonText,
            'posts' => $posts,
            'isAdmin' => $isAdmin,
            'allsubscribers' => $allsubscribers,
            'relatedSubscribers' => $relatedSubscribers
        ];
    }

    public function Post_Store_Group_Services($validated, $request)
    {
        $group_id = $request->group_id;

        $imagePaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $destinationPath = public_path('images');
                // Ensure the directory exists and is writable
                if (!file_exists($destinationPath)) {
                    // Attempt to create the directory with read/write permissions for owner, and read for others
                    // The 'true' argument enables recursive creation
                    mkdir($destinationPath, 0755, true);
                }
                // تخزين الصورة في مجلد public/images مع اسمها الأصلي
                $imageName = time() . '_' . $photo->getClientOriginalName();
                $photo->move($destinationPath, $imageName); // تخزين الصورة في مجلد public/images
                $imagePaths[] = 'images/' . $imageName;
            }
        }

        if ($request->role == 1 || auth()->user()->role_id == 1 || auth()->user()->role_id == 2) {
            $post = Post::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'group_id' => $group_id,
                'user_id' => auth()->id(),
                'status' => 1,
                'image' => $imagePaths[0] ?? null
            ]);
        } else {
            if ($group_id) {
                $group = Group::where('id', $group_id)->first();

                $post = Post::create([
                    'title' => $validated['title'],
                    'content' => $validated['content'],
                    'group_id' => $group_id,
                    'user_id' => auth()->id(),
                    'status' => $group->status == 1 ? 1 : 0,
                    'image' => $imagePaths[0] ?? null
                ]);
            } else {
                $post = Post::create([
                    'title' => $validated['title'],
                    'content' => $validated['content'],
                    'group_id' => null,
                    'user_id' => auth()->id(),
                    'status' => 1,
                    'image' => $imagePaths[0] ?? null
                ]);
            }
        }

        // ربط التاجات بالبوست
        $tags = $request->tags;
        $post->tags()->sync($tags);
    }






    public function filter_tag_posts_group_services($request)
    {
        $tagIds = (array)$request->tags;
        $posts = Post::where('group_id', '=', $request->id)->where('status', 1)
            ->whereHas('tags', function ($query) use ($tagIds) {
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
            ->paginate(4);
        return [
            'posts' => $posts,
        ];
    }

    public function report_admin_groupe_services($request)
    {
        $post_id = $request->post;
        $post = Post::where('id', $post_id)->first();
        $existing_report = Report::where('post_id', $post_id)->where('user_id', auth()->user()->id)->first();
        if (!$existing_report) {
            Report::create([
                'post_id' => $post->id,
                'title' => $post->title,
                'note' => $request->note,
                'content' => $post->content,
                'group_id' => $request->group_id,
                'user_id' => auth()->user()->id
            ]);

        }
    }

    public function show_reports_services($request)
    {
        $user_id=auth()->user()->id;
        $posts = Post::where('status', '0')->where('group_id', $request->id)->get();
        $postscount=$posts->count();
        $reports = Report::with('post')->where('group_id', $request->id)->get();
        $reportscount=$reports->count();
        $users = User::whereHas('followings', function ($query) use ($user_id) {
            $query->where('following_id', $user_id);
        })->whereDoesntHave('groups', function ($query) use ($request) {
            $query->where('group_id', $request->id);
        })->get();
        return ['reports' => $reports, 'posts' => $posts,'postscount'=>$postscount,'reportscount'=>$reportscount,'users'=>$users];
    }

    public function show_all_subscribers_services($id)
    {
        $group = Group::find($id);
        $allSubscribers = User::whereHas('groups', function ($query) use ($id) {
            $query->where('group_id', $id);
        })->get();

        return [
            'allSubscribers' => $allSubscribers,
            'group' => $group,
        ];
    }
    public function show_related_subscribers_services($id)
    {
        $relatedSubscribers = User::whereHas('groups', function ($query) use ($id) {
            $query->where('group_id', $id);
        })->whereHas('followers', function ($query) {
            $query->where('follower_id', auth()->user()->id);
        })->get();
        return ['relatedSubscribers' => $relatedSubscribers];
    }

    public function tags_user_group_services($validated, $request)
    {
        Tag::create([
            'tag_name' => $validated['newtag'],
            'group_id' => $request->group_id,
            'user_id' => auth()->id(),
        ]);
    }
    public function delete_post_services($request)
    {
        Post::where('id', $request->id)->delete();
    }
    public function Delete_Admin_Services($request)
    {
        $userId = $request->id;
        $groupId = $request->group_id;

        DB::table('group_user')
            ->where('user_id', $userId)
            ->where('group_id', $groupId)
            ->update(['is_admin' => 0]);
    }
    public function Add_Or_Delete_User_Group_Services($request)
    {
        if ($request->task_id == 1) {
            DB::table('group_user')
                ->where('user_id', $request->id)
                ->where('group_id', $request->group_id)
                ->update(['is_admin' => 1]);
        } elseif ($request->task_id == 0) {
            $user = User::find($request->id);
            if ($user) {
                $user->groups()->detach($request->group_id);
            } else {
                return response()->json(['error' => 'User not found'], 404);
            }
        }
    }
    public function delete_user_services($request)
    {
        $user = User::find($request->id);
        $user->groups()->detach($request->group_id);
    }

    public function delete_group_services($group_id)
    {
        $group = Group::findOrFail($group_id);
        $group->users()->detach();
        $posts = Post::where('group_id', $group_id)->get();
        foreach ($posts as $post) {
            $post->comments()->delete();
            $post->delete();
        }
        Tag::where('group_id', $group_id)->delete();
        ReportGroup::where('group_id', $group_id)->delete();

        $group->delete();
    }

    public function show_all_group_services()
    {
        $groupsJoined = Group::whereHas('users', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->withCount('users')->paginate(8);
        $allGroups = Group::withCount('users')->paginate(8);
        return [
            'allGroups' => $allGroups,
            'groupsJoined' => $groupsJoined
        ];
    }
     public function Status_Group_Services($request)
      {
          $group = Group::where('id', $request->group_id)->first();
          if ($group->status == 1) {
              $group->update(['status' => 2]);
          } else {
              $group->update(['status' => 1]);
          }

      }
    public function Status_Show_Group_Services($request)
    {
        $group = Group::where('id', $request->group_id)->first();
        if ($group->status_show == 1) {
            $group->update(['status_show' => 0]);
        } else {
            $group->update(['status_show' => 1]);
        }

    }
      public function Action_Post_Group_Services($request)
      {
          $post=Post::where('id',$request->id)->first();
          if($request->status==1)
          {
              $post->update(['status'=>1]);
          }
          else{
              $post->delete();
          }

      }

}
