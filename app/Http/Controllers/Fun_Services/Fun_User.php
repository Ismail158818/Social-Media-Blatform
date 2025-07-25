<?php
namespace  App\Http\Controllers\Fun_Services;

use App\Models\Group;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class Fun_User
{
    public function follow_User_Services($user, $id)
    {
        $name = User::find($id);
        $following = $user->followings()->where('following_id', $id)->first();

        if ($user->id == $id) {
            $user->followings()->detach($id);
        } else {
            $user->followings()->toggle($id);
        }
        return $name;
    }

    public function get_User_With_Followers_And_Followings_Services()
    {
        return User::with('followers', 'followings')->get();
    }

    public function get_Profile_Info_Services($id)
    {
        $name = User::find($id);

        $info = Post::where('user_id', $id)
            ->whereNull('group_id')
            ->with(['tags', 'comments' => function ($query) {
                $query->take(4);
            }]) ->withCount([
                'usersRatings as upVotesCount' => function ($q) {
                    $q->where('type', 'upVote');
                },
                'usersRatings as downVotesCount' => function ($q) {
                    $q->where('type', 'downVote');
                }
            ])
            ->paginate(4);
        // جلب المنشورات التي قمت بالتعليق عليها سواء كانت منشوراتي او منشورات احد غيري

// جلب المنشورات التي قام المستخدم بالتعليق عليها
        $infocom = Post::whereHas('comments', function ($query) use ($id) {
            $query->where('user_id', $id);
        })
            ->with(['tags', 'comments' => function ($query) {
                $query->take(4);
            }])
            ->paginate(4);
        //استخراج معلومات عن المستخدم الذي دخلت الى حسابه مع متابعيه
        $user = User::with('followers')->find($id);
        $isFollowing = false;
        $my_profile = false;
        // لحتى ما اعمل متابعة لحالي لازم قارن الid المرسل مع id اللي عامل تسجيل دخول
        if (auth()->user()->id) {
            $my_profile = auth()->user()->id == $id;
            $isFollowing = !$my_profile && auth()->user()->followings->contains($id);
        }
//  اقتراح 3 حسابات لم اقم بمتابعتهم
        $unfollowing = User::whereDoesntHave('followers', function ($query) use ($id) {
            $query->where('follower_id', $id);
        })->where('id', '!=', $id)->inRandomOrder()->take(3)->get();

        //عرض 3 حسابات قام صاحب الحساب (الذي قمت بتمرير id الخاص به) بمتابعتهم
        $following = User::whereHas('followers', function ($query) use ($id) {
            $query->where('follower_id', $id);
        })->inRandomOrder()->take(3)->get();
        // مثلا في الـ Controller
        $user1 = User::where('id', $id)->first();

        $group_count = $user->groups()->count();
// حساب عدد المستخدمين الذين يتابعهم المستخدم الذي قمت بتمرير الid الخاص به
        $followingCount = User::whereHas('followings', function ($query) use ($id) {
            $query->where('following_id', $id);
        })->count();

        // حساب عدد متابعي المستخدم الذي دخلت الى حسابه
        $followersCount = User::whereHas('followers', function ($query) use ($id) {
            $query->where('follower_id', $id);
        })->count();


        // جلب المنشورات التي قام المستخدم  س بعمل upvote
        $postupvote = Post::whereHas('usersRatings', function ($query) use ($id) {
            $query->where('user_id', $id)->where('type', 'upVote');
        })->withCount([
            'usersRatings as upVotesCount' => function ($q) {
                $q->where('type', 'upVote');
            }
        ])->get();

        //  استعلام عن المنشورات التي قام المستخدم المحدد بعمل downvote
        //شرح : استعملنا whereHas لكي نجلب البوستات
        $postdownvote = Post::whereHas('usersRatings', function ($query) use ($id) {
            $query->where('user_id', $id)->where('type', 'downVote');
        })->withCount([
            'usersRatings as downVotesCount' => function ($q) {
                $q->where('type', 'downVote');
            }
        ])->get();

        return compact(
            'name', 'group_count', 'info', 'infocom', 'user', 'user1', 'isFollowing', 'my_profile',
            'unfollowing', 'following', 'followingCount', 'followersCount',
            'postupvote', 'postdownvote'
        );
            }
    public function addMembers_services($request)
    {
        $group = Group::find($request->group_id);
        $group->users()->attach($request->members);
        return redirect()->back()->with('success', 'Members added successfully.');
    }


    public function show_user_following_or_follower_services()
    {
        $user_id = auth()->user()->id;

        $following = User::whereHas('followings', function ($query) use ($user_id) {
            $query->where('following_id', $user_id);
        })->get();

        $followers = User::whereHas('followers', function ($query) use ($user_id) {
            $query->where('follower_id', $user_id);
        })->get();

        return [
            'following' => $following,
            'followers' => $followers
        ];
    }

    public function Show_Users_Services($request)
    {
        $roleId = $request->role_id;

        // تحديد المستخدمين بناءً على role_id
        if ($roleId!=0) {
            $users = User::where('role_id', $roleId)->get();
        } else {
            $users = User::all();
        }

        // تعريف مصفوفة الأدوار
        $roles = [
            0=> 'All users',
            1 => 'Superadmin',
            2 => 'Admins',
            3 => 'Coaches',
            4 => 'Trainees'
        ];
        if($roleId)
        {
            $NameRole = $roles[$roleId];
        }
        else
        {
            $NameRole = $roles[0];
        }

        return [
            'users' => $users,
            'NameRole' => $NameRole
        ];
    }


    public function Edit_Info_Services($request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string|max:255',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'google' => 'nullable|url',
        ]);

        $user = User::find($request->id);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profile_pictures', $filename, 'public');

            // اسم الصورة الافتراضية
            $defaultImage = 'images/Default_image.jpg';

            // التحقق مما إذا كانت الصورة الحالية للمستخدم ليست الصورة الافتراضية قبل محاولة حذفها
            if ($user->image && $user->image != $defaultImage) {
                if (Storage::disk('public')->exists($user->image)) {
                    Storage::disk('public')->delete($user->image);
                }
            }

            // Store the full path
            $user->image = 'profile_pictures/' . $filename;
        }

        $user->name = $request->name;
        $user->facebook = $request->facebook;
        $user->twitter = $request->twitter;
        $user->linkedin = $request->linkedin;
        $user->google = $request->google;
        $user->save();
    }



}
