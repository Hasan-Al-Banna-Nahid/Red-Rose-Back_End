<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AllClass;
use App\Models\ModelTestResult;
use App\Models\Blog;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\SocialLink;
use App\Models\Notification;
use App\Models\Result;
use App\Models\Slider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Traits\HttpWebResponse;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Jetstream;
use Laravel\Fortify\Rules\Password;

class SAdminController extends Controller
{
    use HttpWebResponse;
    public function adminlist()
    {
        // $adminlist = User::paginate(10);
        $adminlist = User::get();
        $allclasslist = AllClass::get();
        session()->put('notificationCount', Notification::count());
        return view('admin.admin.index', [
            'adminlist' => $adminlist,
            'allclasslist' => $allclasslist,
        ]);
    }
    public function adminview($id)
    {
        // $adminlist = User::paginate(10);
        $admin = User::find($id);
        $adminlist = User::get();
        return view('admin.admin.show', [
            'admin' => $admin,
            'adminlist' => $adminlist,
        ]);
    }

    public function admindelete($id)
    {
        // $adminlist = User::paginate(10);
        $admin = User::find($id);
        $admin->delete();
        session()->put(
            'adminCount',
            User::where('user_type', '!=', 1)
                ->where('user_type', '!=', 2)
                ->count(),
        );
        return redirect('/adminlist')->with('warning', 'Admin deleted successful.!');
    }
    public function createadmin(Request $request)
    {
        $request->validate([
            'user_type' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', new Password(), 'confirmed'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ]);
        $user = User::create([
            'user_type' => $request['user_type'],
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ])->id;
        $redrose_id = str_replace(' ', '', Str::lower($request['name']) . rand(100, 99999));
        Profile::create([
            'user_id' => $user,
            'redrose_id' => $redrose_id,
            'date' => now()->toDateString(),
            'once' => 'no',
            'points' => '10',
            'class' => $request['class'],
        ]);
        $this->notification($user, $request['name'] . ' Admin Created successful.!', now()->toDateString(), now()->toTimeString(), 'admin', '1');
        SocialLink::create([
            'user_id' => $user,
        ]);
        session()->put('notificationCount', Notification::count());
        session()->put(
            'adminCount',
            User::where('user_type', '!=', 1)
                ->where('user_type', '!=', 2)
                ->count(),
        );
        return redirect('/adminlist')->with('success', $request['name'] . ' - Admin Created successfull.!');
    }

    public function alluser()
    {
        $userlist = User::where('user_type', '2')->paginate(20);
        return view('admin.pages.user', [
            'userlist' => $userlist,
        ]);
    }
    public function slider()
    {
        $sliderlist = Slider::get();
        return view('admin.pages.slider', [
            'sliderlist' => $sliderlist,
        ]);
    }
    public function slider_store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'image_path' => 'required',
        ]);
        $image = url('/') . '/storage/sliders/' . time() . '-' . $request->type . '.' . $request->image_path->extension();
        $request->image_path->move(public_path('storage/sliders'), $image);
        Slider::create([
            'type' => $request['type'],
            'image_path' => $image,
        ]);
        $this->notification(Auth::user()->id, $request['type'] . ' slider added successful.!', now()->toDateString(), now()->toTimeString(), 'slider', '1');
        session()->put('notificationCount', Notification::count());
        return back()->with('success', $request['type'] . ' - slider added successful.!');
    }
    public function event_result()
    {
        $resultlist = Result::orderby('total_mark', 'desc')->paginate(20);
        return view('admin.pages.result', [
            'resultlist' => $resultlist,
        ]);
    }
    public function admin_result($id)
    {
        $resultlist = Result::where('event_id', $id)->orderby('total_mark', 'desc')->paginate(20);
        return view('admin.pages.result', [
            'resultlist' => $resultlist,
        ]);
    }
    public function modeltest_result()
    {
        $modeltestresultlist = ModelTestResult::orderby('total_mark', 'desc')->paginate(20);
        return view('admin.pages.mresult', [
            'modeltestresultlist' => $modeltestresultlist,
        ]);
    }
    public function blog_index()
    {
        $bloglist = Blog::get();
        return view('frontend.pages.blog', [
            'bloglist' => $bloglist
        ]);
    }
    public function ublog_show($id)
    {
        $blog = Blog::find($id);
        Blog::where('id', $id)->update([
            'pageview' => $blog->pageview + 1
        ]);
        return view('frontend.pages.bshow', [
            'blog' => $blog
        ]);
    }
    public function ublog_index()
    {
        $bloglist = Blog::get();
        return view('frontend.pages.blog', [
            'bloglist' => $bloglist
        ]);
    }

    public function blog_create()
    {
        session()->put('blogCount', Blog::count());
        $bloglist = Blog::paginate(20);
        return view('admin.blog.index', [
            'bloglist' => $bloglist
        ]);
    }
    public function blog_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image_path' => 'required'
        ]);
        $image = url('/') . '/storage/blogs/' . time() . '-' . $request->name . '.' . $request->image_path->extension();
        $request->image_path->move(public_path('storage/blogs'), $image);
        $user = Auth::user();
        $this->notification($user->id, '"' . $user->name . '" create new blog "' . $request['name'] . '" successful.!', now()->toDateString(), now()->toTimeString(), 'blog', '1');
        $this->blog_make($user->id, $request['name'], $image, $request['description'], 0);
        session()->put('blogCount', Blog::count());
        return back()->with('success', 'New blog "' . $request['name'] . '" created successfull.!');
    }
    public function blog_show($id)
    {
        $blog = Blog::find($id);
        $bloglist = Blog::paginate(20);
        return view('admin.blog.show', [
            'bloglist' => $bloglist,
            'blog' => $blog
        ]);
    }
    public function blog_edit(Request $request, $id)
    {
        $blog = Blog::find($id);
        $bloglist = Blog::paginate(20);
        return view('admin.blog.edit', [
            'bloglist' => $bloglist,
            'blog' => $blog
        ]);
    }
    public function blog_update(Request $request, $id)
    {
        $user = Auth::user();
        $blog = Blog::find($id);
        $image = '';
        if ($request->image_path) {
            $image = url('/') . '/storage/blogs/' . time() . '-' . $request->name . '.' . $request->image_path->extension();
            $request->image_path->move(public_path('storage/blogs'), $image);
        }else {
            $image = $blog->image_path;
        }
        Blog::where('id', $id)->update([
            'name' => $request['name'],
            'image_path' => $image,
            'description' => $request['description']
        ]);
        $this->notification($user->id, '"' . $user->name . '" update blog "' . $blog->name . '" successful.!', now()->toDateString(), now()->toTimeString(), 'blog', '1');
        return redirect(route('blog.show', $id))->with('success', 'blog "' . $blog->name . '" update successfull.!');
    }
    public function blog_delete($id)
    {
        $user = Auth::user();
        $blog = Blog::find($id);
        $blog->delete();
        $this->notification($user->id, '"' . $user->name . '" delete blog "' . $blog->name . '" successful.!', now()->toDateString(), now()->toTimeString(), 'blog', '1');
        return redirect(route('blog.create'))->with('warning', 'blog "' . $blog->name . '" delete successfull.!');
    }
    public function page_create()
    {
        session()->put('pageCount', Page::count());
        $pagelist = Page::paginate(20);
        return view('admin.page.index', [
            'pagelist' => $pagelist
        ]);
    }
    public function page_store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $user = Auth::user();
        $this->notification($user->id, '"' . $user->name . '" create new page "' . $request['name'] . '" successful.!', now()->toDateString(), now()->toTimeString(), 'page', '1');
        session()->put('pageCount', Page::count());
        Page::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
        ]);
        return back()->with('success', 'New page "' . $request['title'] . '" created successfull.!');
    }
    public function page_show($id)
    {
        $page = Page::find($id);
        $pagelist = Page::paginate(20);
        return view('admin.page.show', [
            'pagelist' => $pagelist,
            'page' => $page
        ]);
    }
    public function page_edit(Request $request, $id)
    {
        $page = Page::find($id);
        $pagelist = Page::paginate(20);
        return view('admin.page.edit', [
            'pagelist' => $pagelist,
            'page' => $page
        ]);
    }
    public function page_update(Request $request, $id)
    {
        $user = Auth::user();
        $page = Page::find($id);
        Page::where('id', $id)->update([
            'title' => $request['title'],
            'description' => $request['description']
        ]);
        $this->notification($user->id, '"' . $user->name . '" update page "' . $page->name . '" successful.!', now()->toDateString(), now()->toTimeString(), 'page', '1');
        return redirect(route('page.show', $id))->with('success', 'page "' . $page->name . '" update successfull.!');
    }
    public function page_delete($id)
    {
        $user = Auth::user();
        $page = Page::find($id);
        $page->delete();
        $this->notification($user->id, '"' . $user->name . '" delete page "' . $page->name . '" successful.!', now()->toDateString(), now()->toTimeString(), 'page', '1');
        return redirect(route('page.create'))->with('warning', 'page "' . $page->name . '" delete successfull.!');
    }



}
