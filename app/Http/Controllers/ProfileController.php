<?php

namespace App\Http\Controllers;

use App\Models\AllClass;
use App\Models\City;
use App\Models\Upozila;
use App\Models\Chat;
use App\Models\Country;
use App\Models\Division;
use App\Models\Message;
use App\Traits\HttpWebResponse;
use App\Models\Friend;
use App\Models\User;
use App\Models\SocialLink;
use App\Models\Profile;
use App\Models\Notification;
use App\Models\ReceiveRequest;
use App\Models\SendRequest;
use App\Models\Upazila;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use HttpWebResponse;
    public function view_profile($id)
    {
        $user = User::find($id);
        $is_friend = Friend::where('user_id', Auth::user()->id)
            ->where('friend_id', $id)
            ->get()
            ->first();
        $is_request = SendRequest::where('user_id', Auth::user()->id)
            ->where('request_id', $id)
            ->get()
            ->first();

        // dd($is_friend);

        return view('frontend.profile.public', [
            'user' => $user,
            'is_friend' => $is_friend,
            'is_request' => $is_request
        ]);
    }
    public function profile()
    {
        $id = Auth::user()->id;
        // dd($id);
        $user = User::find($id);
        $interval = (new DateTime($user->profile->date))->diff(new DateTime());
        $final_days = $interval->format('%a'); //and then print do whatever you like with $final_days

        $redrose_id = 'off';
        if ($final_days > 365 || $user->profile->once == 'no') {
            $redrose_id = 'on';
        }

        if ($user->user_type == 2) {
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
            // 01704205569 -> dhaka dsb mithapukur 01785696368
        } else {
            if ($user->user_type == 1) {
                session()->put('notificationlist', Notification::paginate(5));
                return view('admin.profile.show', [
                    'user' => $user,
                    'redrose_id_edit' => $redrose_id
                ]);
            } else {
                return view('admin.profile.show', [
                    'user' => $user,
                    'redrose_id_edit' => $redrose_id
                ]);
            }
        }
    }
    public function store_profile(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'address' => 'required',
            'country' => 'required',
            'phone' => 'required',
        ]);
        $image = '';
        if ($request->profile_photo) {
            $image = url('/') . '/storage/profiles/' . now()->toDateString() . '-' . time() . '-' . str_replace(' ', '', Auth::user()->name) . '.' . $request->profile_photo->extension();
            $request->profile_photo->move(public_path('storage/profiles/'), $image);
        } else {
            $image = Auth::user()->profile_photo_path;
        }
        $user = [
            'name' => $request['name'],
            'profile_photo_path' => $image
        ];
        $profile = [
            'bio' => $request['bio'],
            'designation' => $request['designation'],
            'birthday' => $request['birthday'],
            'gender' => $request['gender'],
            'about' => $request['about'],
            'phone' => $request['phone'],
            'class' => $request['class'],
            'institute' => $request['institute'],
            'address' => $request['address'],
            'city' => $request['city'],
            'upazila' => $request['upazila'],
            'division' => $request['division'],
            'country' => $request['country'],
            'company_name' => $request['company_name']
        ];

        $socialLink = [
            'whatsapp' => $request['whatsapp'],
            'facebook' => $request['facebook'],
            'twitter' => $request['twitter'],
            'instagram' => $request['instagram'],
            'linkedin' => $request['linkedin'],
            'pinterest' => $request['pinterest'],
            'tiktok' => $request['tiktok'],
            'wechat' => $request['wechat']
        ];

        if ($request->redrose_id) {
            $is_redrose_id = Profile::where('redrose_id', $request->redrose_id)
                ->get()
                ->first();
            if (Auth::user()->profile->redrose_id == $request->redrose_id) {
                User::where('id', $id)->update($user);
                Profile::where('user_id', $id)->update($profile);
                SocialLink::where('user_id', $id)->update($socialLink);
                return redirect('/profile')->with('success', 'Profile update successfull.!');
            } elseif ($is_redrose_id) {
                return back()->with('warning', 'Redrose Id arready taken, please try another');
            } else {
                User::where('id', $id)->update($user);
                Profile::where('user_id', $id)->update($profile);
                $redrose_id = [
                    'redrose_id' => $request->redrose_id,
                    'date' => now()->toDateString(),
                    'once' => 'yes',
                ];
                Profile::where('user_id', $id)->update($redrose_id);
                SocialLink::where('user_id', $id)->update($socialLink);
                return redirect('/profile')->with('success', 'Profile update successfull.!');
            }
        } else {
            User::where('id', $id)->update($user);
            Profile::where('user_id', $id)->update($profile);
            SocialLink::where('user_id', $id)->update($socialLink);
            return redirect('/profile')->with('success', 'Profile update successfull.!');
        }
    }
    public function friends()
    {
        $friendsList = Friend::where('user_id', Auth::user()->id)
            ->where('friend_id', '!=', 1)
            ->get();
        // dd($friendsList);
        return view('frontend.profile.mfriend', [
            'friendsList' => $friendsList,
        ]);
    }
    public function find_friend()
    {
        $userList = User::where('user_type', 2)
            ->where('id', '!=', Auth::user()->id)
            ->get();
        $friendList = Friend::where('user_id', Auth::user()->id)->get();
        return view('frontend.profile.ffriend', [
            'userList' => $userList,
            'friendList' => $friendList,
        ]);
    }
    public function allrequest()
    {
        $receiveRequestList = ReceiveRequest::where('user_id', Auth::user()->id)->get();
        // dd($receiveRequestList);
        return view('frontend.profile.request', [
            'receiveRequestList' => $receiveRequestList,
        ]);
    }
    public function allsend()
    {
        $sendRequestList = SendRequest::where('user_id', Auth::user()->id)->get();
        // dd($receiveRequestList);
        return view('frontend.profile.send', [
            'sendRequestList' => $sendRequestList,
        ]);
    }
    public function add_friend($id)
    {
        // if ($id != Auth::user()->id) {
        //     SendRequest::create([
        //         'user_id' => Auth::user()->id,
        //         'request_id' => $id,
        //     ]);
        //     ReceiveRequest::create([
        //         'user_id' => $id,
        //         'request_id' => Auth::user()->id,
        //     ]);
        //     $user = User::find($id);
        //     $this->notification(Auth::user()->id, '"' . Auth::user()->name . '" send friend request, to "' . $user->name . '" send successful.!', now()->toDateString(), now()->toTimeString(), 'request', '1');
        //     return redirect('/profile')->with('success', 'Friend request send successfull');
        // }

        $sendrequest = SendRequest::where('user_id', Auth::user()->id)
            ->where('request_id', $id)
            ->get()
            ->first();
        $receiverequest = ReceiveRequest::where('request_id', Auth::user()->id)
            ->where('user_id', $id)
            ->get()
            ->first();
        if ($sendrequest && $receiverequest) {
            return $this->apiresponse(['sendrequest' => $sendrequest], 'Already friend request sended.!', 200);
        } else {
            if ($id != Auth::user()->id) {
                SendRequest::create([
                    'user_id' => Auth::user()->id,
                    'request_id' => $id,
                ]);
                ReceiveRequest::create([
                    'user_id' => $id,
                    'request_id' => Auth::user()->id,
                ]);
                $user = User::find($id);
                $this->notification(Auth::user()->id, '"' . Auth::user()->name . '" send friend request, to "' . $user->name . '" send successful.!', now()->toDateString(), now()->toTimeString(), 'request', '1');
                return redirect('/profile')->with('success', 'Friend request send successfull');
            }
        }
    }
    public function unfriend($id)
    {
        $friend = Friend::where('friend_id', $id)
            ->where('user_id', Auth::user()->id)
            ->get()
            ->first();
        $this->notification(Auth::user()->id, '"' . Auth::user()->name . '" unfriend, "' . $friend->user->name . '" successful.!', now()->toDateString(), now()->toTimeString(), 'unfriend', '1');
        $friend->delete();
        return redirect('/profile')->with('success', 'Unfriend successfull');
    }
    public function cancelrequest($id)
    {
        $sendrequest = SendRequest::where('user_id', Auth::user()->id)
            ->where('request_id', $id)
            ->get()
            ->first();
        $receiverequest = ReceiveRequest::where('request_id', Auth::user()->id)
            ->where('user_id', $id)
            ->get()
            ->first();
        $user = User::find($id);
        // dd($friendrequest);
        $this->notification(Auth::user()->id, '"' . Auth::user()->name . '" cancel friend request, "' . $user->name . '" successful.!', now()->toDateString(), now()->toTimeString(), 'cancelrequest', '1');
        $sendrequest->delete();
        $receiverequest->delete();
        return redirect('/profile')->with('success', 'Friend request cancel successfull');
    }
    public function confirmrequest($id)
    {
        $sendrequest = SendRequest::where('user_id', $id)
            ->where('request_id', Auth::user()->id)
            ->get()
            ->first();
        $receiverequest = ReceiveRequest::where('request_id', $id)
            ->where('user_id', Auth::user()->id)
            ->get()
            ->first();
        $user = User::find($receiverequest->request_id);
        $this->confirm_request($receiverequest->request_id, Auth::user()->id, '1');
        $this->notification(Auth::user()->id, '"' . Auth::user()->name . '" Confirm friend request, "' . $user->name . '" successful.!', now()->toDateString(), now()->toTimeString(), 'confirmrequest', '1');
        $sendrequest->delete();
        $receiverequest->delete();
        return redirect('/profile')->with('success', 'Friend request confirm successfull');
    }

    public function makemessage(Request $request, $id)
    {
        // dd($id);
        $my_id = Auth::user()->id;
        $chat = Chat::where('receiver_id', $id)
            ->where('sender_id', $my_id)
            ->get()
            ->first();
        if ($chat) {
            Chat::where('id', $chat->id)->update([
                'lastmessage' => $request->input('message'),
            ]);
            $this->message($chat->id, $request->input('message'), $my_id, $id, false, 'text');
            return back()->with('success', 'Message send successful');
        } else {
            $chat1 = Chat::where('receiver_id', $my_id)
                ->where('sender_id', $id)
                ->get()
                ->first();
            if ($chat1) {
                Chat::where('id', $chat1->id)->update([
                    'lastmessage' => $request->input('message'),
                ]);
                $this->message($chat1->id, $request->input('message'), $my_id, $id, false, 'text');
                return back()->with('success', 'Message send successful');
            } else {
                $chat_id = Chat::create([
                    'user_id' => $my_id,
                    'sender_id' => $my_id,
                    'receiver_id' => $id,
                    'lastmessage' => $request->input('message'),
                ])->id;
                $this->message($chat_id, $request->input('message'), $my_id, $id, false, 'text');
                return back()->with('success', 'Message send successful');
            }
        }
    }
    public function chat()
    {
        $chatList = Chat::orderby('updated_at', 'desc')
            ->where('user_id', Auth::user()->id)
            ->where('sender_id', Auth::user()->id)
            ->orwhere('receiver_id', Auth::user()->id)
            ->get();

        // dd($chatList);
        return view('frontend.profile.message', [
            'chatList' => $chatList,
            'messagelist' => '',
            'user' => 'off',
        ]);
    }
    public function chatmessage($id)
    {
        $my_id = Auth::user()->id;
        $chatList = Chat::orderby('updated_at', 'desc')
            ->where('user_id', $my_id)
            ->where('sender_id', $my_id)
            ->orwhere('receiver_id', $my_id)
            ->get();
        $messagelist = Message::where('chat_id', $id)->get();
        $chat = Chat::find($id);
        $user = '';
        if ($my_id == $chat->receiver_id) {
            $user = User::find($chat->sender_id);
        } elseif ($my_id == $chat->sender_id) {
            $user = User::find($chat->receiver_id);
        }

        $friendsList = Friend::where('user_id', $my_id)
            ->where('friend_id', '!=', 1)
            ->get();

        return view('frontend.profile.message', [
            'chatList' => $chatList,
            'chatid' => $id,
            'friendsList' => $friendsList,
            'messagelist' => $messagelist,
            'user' => $user,
        ]);
    }
    public function chatmessage_store(Request $request, $id)
    {
        Chat::where('id', $id)->update([
            'lastmessage' => $request->input('message'),
        ]);
        $this->message($id, $request->input('message'), Auth::user()->id, $request->input('receiver_id'), false, 'text');
        return back();
    }
    public function sendpoints(Request $request, $id)
    {
        $my_id = Auth::user()->id;
        $receiver = User::find($id);
        $sender = User::find($my_id);

        if ($sender->profile->points >= (int) $request->input('message')) {
            $totalplus = $receiver->profile->points + $request->input('message');
            $totalminus = $sender->profile->points - $request->input('message');

            Chat::where('id', $request->input('chatid'))->update([
                'lastmessage' => 'Point Sharing',
            ]);

            $this->pointupdate($id, $totalplus);
            $this->pointupdate($my_id, $totalminus);
            $this->history($id, 'You received ' . $request->input('message') . ' points from ' . $sender->name, 'points');
            $this->history($my_id, 'You send ' . $request->input('message') . ' points to ' . $receiver->name, 'points');

            $this->message($request->input('chatid'), $request->input('message'), $my_id, $id, false, 'points');
            $this->notification(Auth::user()->id, '"' . $sender->name . '" send ' . $request->input('message') . ' points to "' . $receiver->name . '" successfully.!', now()->toDateString(), now()->toTimeString(), 'points', '1');
            return back();
        } else {
            return back()->with('warning', 'Insufficient points for sharing.!');
        }
    }
    public function sendcard(Request $request, $id)
    {
        $my_id = Auth::user()->id;
        $receiver = User::find($id);
        $sender = User::find($my_id);
        $message = $request->input('message');
        $cardname = User::find($message);

        Chat::where('id', $request->input('chatid'))->update([
            'lastmessage' => 'Contact card Sharing',
        ]);

        $this->history($id, 'You received an contact card ' . $message . ' from ' . $sender->name, 'contactcard');
        $this->history($my_id, 'You send an contact card ' . $message . ' to ' . $receiver->name, 'contactcard');

        $this->message($request->input('chatid'), $message, $my_id, $id, false, 'contactcard');
        $this->notification(Auth::user()->id, '"' . $sender->name . '" send contact card of ' . $cardname->name . ' to "' . $receiver->name . '" successfully.!', now()->toDateString(), now()->toTimeString(), 'contactcard', '1');
        return back();
    }
}
