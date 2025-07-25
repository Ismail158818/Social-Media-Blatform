<?php
namespace App\Http\Controllers;
use App\Http\Requests\GroupRequest;
use App\Http\Requests\TagGroupRequest;
use App\Http\Controllers\Fun_Services\Fun_Group;
use App\Http\Requests\PostRequest;
use App\Http\Requests\TagRequest;
use App\Models\Group;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function creat_group(GroupRequest $request)
    {
        $validated = $request->validated();
        $create = new Fun_Group();
        $create->creat_group_services($validated);
        return redirect()->back();
    }

    public function join_group(Request $request)
    {
        $create = new Fun_Group();
        $create->join_group_services($request);
        return redirect()->back();
    }

    public function group($id)
    {
        $create = new Fun_Group();
        $data = $create->group_services($id);
        
        return view('group', [
            'group' => $data['group'],
            'isMember' => $data['isMember'],
            'buttonText' => $data['buttonText'],
            'posts' => $data['posts'],
            'isAdmin' => $data['isAdmin'],
            'allsubscribers' => $data['allsubscribers'],
            'relatedSubscribers' => $data['relatedSubscribers']
        ]);
    }

    public function post_store_group(PostRequest $request)
    {
        $validated = $request->validated();
        $store = new Fun_Group();
        $store->Post_Store_Group_Services($validated, $request);
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $tags = [];
        if ($searchTags = $request->input('name')) {
            $tags = Tag::where('tag_name', 'LIKE', "%$searchTags%")
                ->where('group_id', null)
                ->get();
        }
        return response()->json($tags);
    }

    public function search_group(Request $request)
    {
        $searchTags = $request->input('name');
        $tags = Tag::where('tag_name', 'LIKE', "%{$searchTags}%")
            ->where('group_id', $request->input('group_id'))
            ->get();
        return response()->json($tags);
    }

    public function filter_tag_posts_group(Request $request)
    {
        $filter = new Fun_Group();
        $data = $filter->filter_tag_posts_group_services($request);
        return view('posts_tag', ['posts' => $data['posts']]);
    }

    public function report_admin_groupe(Request $request)
    {
        $request->validate([
            'post' => 'required|integer|exists:posts,id',
            'note' => 'required|string|max:255',
            'group_id' => 'required|integer|exists:groups,id',
        ]);

        $post_id = $request->post;
        $post = Post::find($post_id);

        if (!$post) {
            return redirect()->back()->with('error', 'Post not found.');
        }

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

            return redirect()->back()->with('success', 'The report has been submitted successfully.');
        } else {
            return redirect()->back()->with('info', 'You have already reported this post.');
        }
    }
    public function show_reports(Request $request)
    {
        $show = new Fun_Group();

        $data = $show->show_reports_services($request);
        return view('admin_page_post_group', [
            'reports' => $data['reports'],
            'posts' => $data['posts'],
            'postscount' => $data['postscount'],
            'users' => $data['users'],
            'reportscount' => $data['reportscount']
        ]);
    }


    public function show_all_subscribers($id)
    {
        $show = new Fun_Group();
        $data = $show->show_all_subscribers_services($id);

        return view('show_subscribers_group', [
            'allSubscribers' => $data['allSubscribers'],
            'group' => $data['group'],
        ]);
    }


    public function show_related_subscribers($id)
    {
        $show = new Fun_Group();
        $data = $show->show_related_subscribers_services($id);
        return view('show_subscribers_related_group', ['relatedSubscribers' => $data['relatedSubscribers']]);
    }

    public function tags_user_group(TagGroupRequest $request)
    {
        $validated = $request->validated();
        $tags = new Fun_Group();
        $tags->tags_user_group_services($validated, $request);
        return redirect()->back();
    }

    public function delete_post(Request $request)
    {
        $delete = new Fun_Group();
        $delete->delete_post_services($request);
        return redirect()->back();
    }

    public function delete_admin(Request $request)
    {
        $delete = new Fun_Group();
        $delete->Delete_Admin_Services($request);
        return redirect()->back();
    }



    public function add_or_delete_user_group(Request $request)
    {
        $add = new Fun_Group();
        $add->Add_Or_Delete_User_Group_Services($request);
        return redirect()->back();
    }

    public function delete_user(Request $request)
    {
        $delete = new Fun_Group();
        $delete->delete_user_services($request);
        return redirect()->back();
    }

    public function delete_group($group_id)
    {
        $delete = new Fun_Group();
        $data = $delete->delete_group_services($group_id);
            return redirect()->route('show.all.group');

    }


    public function show_all_group()
    {
        $show = new Fun_Group();
        $data = $show->show_all_group_services();

        // فلترة المجموعات التي المستخدم الحالي أدمن فيها
        $adminGroups = $data['groupsJoined']->getCollection()->filter(function($group) {
            $user = $group->users->firstWhere('id', auth()->id());
            return $user && isset($user->pivot) && $user->pivot->is_admin == 1;
        });

        return view('show_all_group', [
            'allGroups'=>$data['allGroups'],
            'groupsJoined' => $data['groupsJoined'],
            'adminGroups' => $adminGroups,
        ]);
    }
    public function status_group(Request $request)
    {
        $status=new Fun_Group();
        $status->Status_Group_Services($request);
        return redirect()->back();
    }
    public function status_show_group(Request $request)
    {
        $status=new Fun_Group();
        $status->Status_Show_Group_Services($request);
        return redirect()->back();
    }
    public function action_post_group(Request $request)
    {
        $status=new Fun_Group();
        $status->Action_Post_Group_Services($request);
        return redirect()->back();
    }
}
