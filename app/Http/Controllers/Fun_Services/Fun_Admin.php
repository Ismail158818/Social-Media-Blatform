<?php
namespace  App\Http\Controllers\Fun_Services;
use App\Models\Group;
use App\Models\Post;
use App\Models\Report;
use App\Models\ReportGroup;
use App\Models\ReportGroupRequestPostRequest;
use App\Models\Tag;
use App\Models\User;
use App\Models\Utag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Fun_Admin
{
    public function page_tags_admin_services ()
    {
        $users = User::all()->count();
        $PercentUsers = $users * 0.1;
        $utag = Utag::select('tag_name', DB::raw('count(*) as counttag'))
            ->groupBy('tag_name')->having('counttag', '>', $PercentUsers)->get();
        return ['utag'=>$utag];
    }
    public function add_tag_services ($validated)
    {
        $existing_tag = Tag::where('tag_name', $validated['newtag'])->first();
        if ($existing_tag) {
            return redirect()->back();
        }
        else
            $new_tag = Tag::create([
                'tag_name' => $validated['newtag'],
                'user_id' => auth()->id(),
            ]);

    }
    public function add_users_tag_services ($validated)
    {
        $new_tag = Tag::create([
            'tag_name' => $validated['newtag'],
            'user_id' => auth()->id(),
        ]);

        Utag::where('tag_name', $validated['newtag'])->delete();

    }
    public function delete_tag_services($name)
    {
        Utag::where('tag_name', $name)->delete();
    }
    public function show_report_to_admin_services()
    {
        $reports = Report::with('post')
        ->where('group_id', null)
        ->get();

        $reportsCount = $reports->count();

        $ReportsGroups = ReportGroup::all();

        $ReportsGroupsCount = $ReportsGroups->count();
        return [
            'reports' => $reports,
            'reportsCount' => $reportsCount,
            'ReportsGroups' => $ReportsGroups,
            'ReportsGroupsCount' => $ReportsGroupsCount,
        ];
    }


    public function group_report_services($validated,$request)
            {
            $group_id = $request->id;
            $group = Group::where('id', $group_id)->first();
            $existing_report = ReportGroup::where('group_id', $group_id)
                ->where('user_id', auth()->id())
                ->first();
            if (!$existing_report) {
                ReportGroup::create([
                'note' => $validated['note'],
                'group_id' => $group->id,
                'user_id' => auth()->user()->id,

            ]);

            $reportsuccess = 'تم تقديم شكوى';
            return redirect()->back()->with('report_success', $reportsuccess);
        } else {
            $report = 'تم تقديم شكوى من قبلك مسبقا';
            return redirect()->back()->with('report', $report);
        }
    }
    public function accept_report_group_services($groupId)
    {
        Group::where('id',$groupId)->delete();
        ReportGroup::where('group_id',$groupId)->delete();
    }
    public function reject_report_group_services($groupId)
    {
        ReportGroup::where('group_id',$groupId)->delete();

    }
    public function reject_report_post_services($id)
    {
        Report::where('id', $id)->delete();

    }
    public function accept_report_post_services($id,$post_id)
    {
        Report::where('id',$id)->delete();
        Post::where('id', $post_id)->delete();
    }

    public function Add_Or_Demote_Delete_Or_Block_Services($request)
    {
        $user = User::find($request->id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        if ($request->task_id == 2) {
            $user->update(['role_id' => 2]);
        }
        if ($request->task_id == 3) {
            $user->update(['role_id' => 3]);
        }
        if ($request->task_id == 4) {
            $user->update(['role_id' => 4]);
        }
        if ($request->task_id == 0) {
            $posts = Post::where('user_id', $request->id)->get();
            foreach ($posts as $post) {
                $post->comments()->delete();
                $post->delete();
            }
            $user->report()->delete();
            $user->postsRatings()->delete();
            $user->followings()->detach();
            $user->followers()->detach();
            $user->delete();
        }
        if ($request->task_id == -1) {
            $user->update(['block' => 1]);
        } elseif ($request->task_id == -2) {
            $user->update(['block' => 0]);
        }

        return redirect()->back()->with('success', 'Operation completed successfully.');
    }



}
