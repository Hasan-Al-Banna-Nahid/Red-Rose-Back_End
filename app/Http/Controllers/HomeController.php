<?php

namespace App\Http\Controllers;

use App\Models\AllClass;
use App\Models\City;
use App\Models\Country;
use App\Models\Division;
use App\Models\Enroll;
use App\Models\User;
use App\Models\Event;
use App\Models\Blog;
use App\Models\Question;
use App\Models\Syllabus;
use App\Models\Notification;
use App\Models\Support;
use App\Models\SupportReplay;
use App\Models\Upazila;
use App\Traits\HttpWebResponse;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    use HttpWebResponse;
    public function superadmin()
    {
        session()->put(
            'adminCount',
            User::where('user_type', '!=', 1)
                ->where('user_type', '!=', 2)
                ->count(),
        );
        session()->put('blogCount', Blog::count());
        session()->put('eventCount', Event::count());
        session()->put('syllabusCount', Syllabus::count());
        session()->put('questionCount', Question::count());
        session()->put('notificationCount', Notification::count());
        session()->put('userCount', User::where('user_type', '2')->count());
        session()->put('participantCount', Enroll::count());
        session()->put('notificationlist', Notification::orderby('created_at', 'desc')->paginate(5));
        if (Auth::user()->user_type == 1) {
            return view('admin.index');
        } elseif (Auth::user()->user_type == 2) {
            return redirect('/home');
        } else {
            return redirect('/admin');
        }
    }
    public function admin()
    {
        session()->put('eventCount', Event::count());
        session()->put('syllabusCount', Syllabus::count());
        session()->put('questionCount', Question::count());
        if (Auth::user()->user_type == 1) {
            return redirect('/superadmin');
        } elseif (Auth::user()->user_type == 2) {
            return redirect('/home');
        } else {
            return view('admin.index');
        }
    }
    public function dashboard()
    {
        if (Auth::user()->user_type == 2) {
            $id = Auth::user()->id;
            // dd($id);
            $user = User::find($id);
            $interval = (new DateTime($user->profile->date))->diff(new DateTime());
            $final_days = $interval->format('%a'); //and then print do whatever you like with $final_days

            $redrose_id = 'off';
            if ($final_days > 365 || $user->profile->once == 'no') {
                $redrose_id = 'on';
            }
            $allclasslist = AllClass::get();
            $countrylist = Country::get();
            $divisionlist = Division::get();
            $citylist = City::get();
            $upazilalist = Upazila::get();
            return view('frontend.profile.show', [
                'user' => $user,
                'redrose_id_edit' => $redrose_id,
                'allclasslist' => $allclasslist,
                'countrylist' => $countrylist,
                'divisionlist' => $divisionlist,
                'citylist' => $citylist,
                'upazilalist' => $upazilalist
            ]);
        } elseif (Auth::user()->user_type == 1) {
            return redirect('/superadmin');
        } else {
            return redirect('/admin');
        }
    }
    public function clear_cash()
    {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        return back()->with('success', 'Cache cleared successfully!');
    }
    public function create_question($id)
    {
        $event = Event::find($id);
        $questionlist = Question::paginate(10);
        return view('admin.question.index', [
            'questionlist' => $questionlist,
            'event' => $event,
        ]);
    }
    public function all_notification()
    {
        $notificationlist = Notification::orderby('created_at', 'desc')->paginate(20);
        return view('admin.pages.notification', [
            'notificationlist' => $notificationlist,
        ]);
    }
    public function read_notification($id)
    {
        $notification = Notification::find($id);
        Notification::where('id', $id)->update([
            'status' => '2',
        ]);
        return back()->with('success', '"' . $notification->name . '" marked as read');
    }
    public function supportlist()
    {
        $userlist = Support::where('user_id', '2')->paginate(15);
        $adminlist = Support::where('user_id', '!=', 1)
            ->where('user_id', '!=', 2)
            ->paginate(15);
        return view('admin.support.saindex', [
            'userlist' => $userlist,
            'adminlist' => $adminlist,
        ]);
    }

    public function support()
    {
        $support = Support::where('user_id', Auth::user()->id)
            ->get()
            ->first();
        $support_user_id = SupportReplay::where('support_id', $support->id)
            ->get()
            ->first();
        $support_replaylist = SupportReplay::where('support_id', $support->id)->get();
        // dd($support_replaylist);
        return view('admin.support.aindex', [
            'support_replaylist' => $support_replaylist,
            'support_user_id' => $support_user_id,
        ]);
    }
    public function support_create()
    {
        $support = Support::where('user_id', Auth::user()->id)
            ->get()
            ->first();
        // dd($support);
        if ($support) {
            return 'You already submited an request, please visit my support. thank you';
        } else {
            // return view('admin.support.create', [
            //     'support_create' => 'on'
            // ]);
            return view('admin.support.create', [
                'support_create' => 'off',
            ]);
        }
    }
    public function support_store(Request $request)
    {
        $request->validate([
            'message' => 'required',
        ]);
        $support_id = Support::create([
            'user_id' => Auth::user()->id,
        ])->id;
        SupportReplay::create([
            'support_id' => $support_id,
            'sender_id' => Auth::user()->id,
            'receiver_id' => $request['receiver_id'],
            'message' => $request['message'],
        ]);
        $this->notification(Auth::user()->id, 'An admin request for support please see this as soon as possible.!', now()->toDateString(), now()->toTimeString(), 'support', '1');
        return redirect('/support')->with('success', 'You have successfully submited an support request.!');
    }
    public function support_replay_create($id)
    {
        $support_user_id = SupportReplay::where('support_id', $id)
            ->get()
            ->first();
        $support_replaylist = SupportReplay::where('support_id', $id)->get();
        return view('admin.support.aindex', [
            'support_replaylist' => $support_replaylist,
            'support_user_id' => $support_user_id,
        ]);
    }
    public function support_replay_store(Request $request, $id)
    {
        $request->validate([
            'message' => 'required',
        ]);
        SupportReplay::create([
            'support_id' => $id,
            'sender_id' => Auth::user()->id,
            'receiver_id' => $request['receiver_id'],
            'message' => $request['message'],
        ]);
        return back()->with('success', 'You have successfully submited an support request.!');
    }

    public function about()
    {
        return view('frontend.partial.about');
    }
    public function policy()
    {
        return view('frontend.partial.policy');
    }
    public function terms()
    {
        return view('frontend.partial.terms');
    }
    public function contact()
    {
        return view('frontend.partial.contact');
    }
}
