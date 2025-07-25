<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Fun_Services\Admin_Services;
use App\Http\Controllers\Fun_Services\Fun_Admin;
use App\Http\Controllers\Fun_Services\Fun_User;
use App\Http\Requests\AddTagRequest;
use App\Http\Requests\TagRequest;
use App\Http\Requests\ReportPostRequest;
use App\Http\Requests\ReportGroupRequest;
use App\Models\Group;
use App\Models\Post;
use App\Models\Report;
use App\Models\ReportGroup;
use App\Models\Tag;
use App\Models\User;
use App\Models\Utag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{
    public function page_tags_admin()
    {
        $services = new fun_Admin();
        $data = $services->page_tags_admin_services();
        $utag = $data['utag'];
        return view('admin_page_tags', compact('utag'));
    }


    public function add_users_tag(TagRequest $request)
    {
        $validated = $request->validated();
        $add=new Fun_Admin();
        $add->add_users_tag_services($request);
        $addsuccess = 'تم الإضافة بنجاح';
        return redirect()->back()->with('add_success', $addsuccess);
    }

    public function add_tag(TagRequest $request)
    {
        $validated = $request->validated();
        $add=new Fun_Admin();
        $add->add_tag_services($request);
        return redirect()->back();
    }

    public function delete_tag($name)
    {
        $add=new Fun_Admin();
        $add->delete_tag_services($name);
        return redirect()->back();
    }

    public function show_report_to_admin()
    {
        $accept = new Fun_Admin();
        $data = $accept->show_report_to_admin_services();


        return view('admin_page_post', [
            'reports' =>  $data['reports'],
            'ReportsGroups' =>  $data['ReportsGroups'],
            'reportsCount' => $data['reportsCount'],
            'ReportsGroupsCount' =>$data['ReportsGroupsCount']

        ]);
    }

    public function group_report(ReportGroupRequest $request)
    {
        $validated = $request->validated();
        $report = new Fun_Admin();
        $report->group_report_services($validated,$request);
        return redirect()->back();

    }

    public function accept_report_group(Request $request)
    {
        $accept = new Fun_Admin();
        $accept->accept_report_group_services($request->id);

        return redirect()->back();
    }

    public function reject_report_group(Request $request)
    {
        $reject = new Fun_Admin();
        $reject->reject_report_group_services($request->id);
        return redirect()->back();
    }

    public function reject_report_post(Request $request)
    {
        $reject = new Fun_Admin();
        $reject->reject_report_post_services($request->id);
        return redirect()->back();
    }

    public function accept_report_post(Request $request)
    {
        $reject = new Fun_Admin();
        $reject->accept_report_post_services($request->id,$request->post_id);
        return redirect()->back();
    }
    public function user_or_demote_or_delete_or_block(Request $request)
    {
        $add=new Fun_Admin();
        $add->Add_Or_Demote_Delete_Or_Block_Services($request);
        if($request->view=='profile')
        {
            return redirect()->route('posts');
        }
        return redirect()->back();
    }

}

