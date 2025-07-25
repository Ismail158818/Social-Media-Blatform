<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Fun_Services\Fun_User;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function follow($id)
    {
        $user = auth()->user();
        $profile = new Fun_User();
        $data = $profile->follow_User_Services($user, $id);
        return redirect()->back();
    }

    public function followers()
    {
        $user = auth()->user();
        $profile = new Fun_User();
        $data = $profile->get_User_With_Followers_And_Followings_Services();
        return redirect()->back();

    }

public function addMembers_services(Request $request)
{
    $add=new Fun_User();
    $add->addMembers_services($request);
    return redirect()->back();
}
    public function show_user_following_or_follower()
    {
        $show = new Fun_User();
        $data = $show->show_user_following_or_follower_services();

        return view('show_user_follow_or_following', [
            'following' => $data['following'],
            'followers' => $data['followers']
        ]);
    }

    public function profile($id)
    {
        $auth = auth()->user();
        $profile = new Fun_User();
        $data = $profile->get_Profile_Info_Services($id);

        return view('pages.profile', [
            'name' => $data['name'],
            'info' => $data['info'],
            'infocom' => $data['infocom'],
            'user' => $data['user'],
            'user1' => $data['user1'],
            'isFollowing' => $data['isFollowing'],
            'my_profile' => $data['my_profile'],
            'unfollowing' => $data['unfollowing'],
            'following' => $data['following'],
            'followingCount' => $data['followingCount'],
            'followersCount' => $data['followersCount'],
            'postupvote' => $data['postupvote'],
            'postdownvote' => $data['postdownvote'],
            'group_count' => $data['group_count']
        ]);
    }
    public function show_users(Request $request)
    {
        $show=new Fun_User();
        $data=$show->Show_Users_Services($request);
        return view('show_all_user', ['users' => $data['users'],'NameRole'=>$data['NameRole']]);
    }

    public function edit_info(Request $request)
    {
        $edit = new Fun_User();
        $edit->Edit_Info_Services($request);
        return redirect()->back();
    }

    public function blockUser($id)
    {
        // Check if the authenticated user is admin or superadmin
        if (auth()->user()->role_id != 1 && auth()->user()->role_id != 2) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        
        // Prevent blocking admins or superadmins
        if ($user->role_id == 1 || $user->role_id == 2) {
            return redirect()->back()->with('error', 'Cannot block administrators.');
        }

        $user->block = true;
        $user->save();

        return redirect()->back()->with('success', 'User has been blocked successfully.');
    }

    public function unblockUser($id)
    {
        // Check if the authenticated user is admin or superadmin
        if (auth()->user()->role_id != 1 && auth()->user()->role_id != 2) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        $user->block = false;
        $user->save();

        return redirect()->back()->with('success', 'User has been unblocked successfully.');
    }

}
