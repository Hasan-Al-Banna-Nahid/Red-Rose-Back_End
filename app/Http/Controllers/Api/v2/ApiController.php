<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Models\AllClass;
use App\Models\Chat;
use App\Models\City;
use App\Models\Enroll;
use App\Models\Event;
use App\Models\Friend;
use App\Models\History;
use App\Models\Message;
use App\Models\ModelQuestion;
use App\Models\ModelSyllabus;
use App\Models\ModelTestAll;
use App\Models\ModelTestResult;
use App\Models\Notification;
use App\Models\User;
use App\Models\Profile;
use App\Models\Question;
use App\Models\ReceiveRequest;
use App\Models\Result;
use App\Models\SendRequest;
use App\Models\SocialLink;
use App\Models\Syllabus;
use App\Models\Upazila;
use App\Traits\AppResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Traits\HttpAppResponse;
use DateTime;
use Illuminate\Support\Facades\Auth;
class ApiController extends Controller
{
    use HttpAppResponse;

    // View Public Profile start
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
        $profile = Profile::where('user_id', $id)
            ->get()
            ->first();
        $sociallink = SocialLink::where('user_id', $id)
            ->get()
            ->first();
        return $this->apiresponse(
            [
                'user' => $user,
                'profile' => $profile,
                'sociallink' => $sociallink,
                'is_friend' => $is_friend,
                'is_request' => $is_request,
            ],
            true,
            'View profile data succesfull.',
            AppResponse::HTTP_OK,
        );
    }

    // View My Profile start
    public function profile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $interval = (new DateTime($user->profile->date))->diff(new DateTime());
        $final_days = $interval->format('%a'); //and then print do whatever you like with $final_days
        $redrose_id = 'off';
        if ($final_days > 365 || $user->profile->once == 'no') {
            $redrose_id = 'on';
        }
        return $this->apiresponse(
            [
                'user' => $user,
                'redrose_id_edit' => $redrose_id,
            ],
            true,
            'Profile data read succesfull.',
            200,
        );
    }
    // Update Profile start
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
            'profile_photo_path' => $image,
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
            'city' => $request['city'],
            'upazila' => $request['upazila'],
            'address' => $request['address'],
            'company_name' => $request['company_name'],
            'country' => $request['country'],
        ];
        $socialLink = [
            'whatsapp' => $request['whatsapp'],
            'facebook' => $request['facebook'],
            'twitter' => $request['twitter'],
            'instagram' => $request['instagram'],
            'linkedin' => $request['linkedin'],
            'pinterest' => $request['pinterest'],
            'tiktok' => $request['tiktok'],
            'wechat' => $request['wechat'],
        ];
        if ($request->redrose_id) {
            $is_redrose_id = Profile::where('redrose_id', $request->redrose_id)
                ->get()
                ->first();
            if (Auth::user()->profile->redrose_id == $request->redrose_id) {
                User::where('id', $id)->update($user);
                Profile::where('user_id', $id)->update($profile);
                SocialLink::where('user_id', $id)->update($socialLink);
                return $this->make_profile_update($id);
            } elseif ($is_redrose_id) {
                return $this->apiresponse('', false, 'Redrose Id arready taken, please try another', 402);
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
                return $this->make_profile_update($id);
            }
        } else {
            User::where('id', $id)->update($user);
            Profile::where('user_id', $id)->update($profile);
            SocialLink::where('user_id', $id)->update($socialLink);
            return $this->make_profile_update($id);
        }
    }
    // Find Friend, all friend, send request, received request
    public function find_friend()
    {
        $users = User::where('user_type', 2)
            ->where('id', '!=', Auth::user()->id)
            ->get();
        $friends = Friend::where('user_id', Auth::user()->id)->get();
        return $this->apiresponse(
            [
                'users' => $users,
                'friends' => $friends,
            ],
            true,
            'Profile data read succesfull.',
            200,
        );
    }
    // all friend
    public function friends()
    {
        $friends = Friend::where('user_id', Auth::user()->id)
            ->where('friend_id', '!=', 1)
            ->get();
        // dd($friendsList);
        return $this->apiresponse(
            [
                'friends' => $friends,
            ],
            true,
            'Profile data read succesfull.',
            200,
        );
    }
    // add friend
    public function add_friend(Request $request)
    {
        $id = (int) $request['id'];
        $sendrequest = SendRequest::where('user_id', Auth::user()->id)
            ->where('request_id', $id)
            ->get()
            ->first();
        $receiverequest = ReceiveRequest::where('request_id', Auth::user()->id)
            ->where('user_id', $id)
            ->get()
            ->first();
        if ($sendrequest && $receiverequest) {
            return $this->apiresponse(['sendRequests' => $sendrequest], true, 'Already friend request sended.!', 422);
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
                $sendRequests = SendRequest::where('user_id', Auth::user()->id)->get();
                return $this->apiresponse(
                    [
                        'sendRequests' => $sendRequests,
                    ],
                    true,
                    'Friend request send successfull.!',
                    200,
                );
            }
        }
    }
    // unfriend
    public function unfriend(Request $request)
    {
        $id = (int) $request['id'];
        $friend = Friend::where('friend_id', $id)
            ->where('user_id', Auth::user()->id)
            ->get()
            ->first();
        $this->notification(Auth::user()->id, '"' . Auth::user()->name . '" unfriend, "' . $friend->user->name . '" successful.!', now()->toDateString(), now()->toTimeString(), 'unfriend', '1');
        $friend->delete();
        $friends = Friend::where('user_id', Auth::user()->id)->get();
        return $this->apiresponse(
            [
                'friends' => $friends,
            ],
            true,
            'Unfriend successfull.!',
            200,
        );
    }
    // cancel request
    public function cancel_request(Request $request)
    {
        $id = (int) $request['id'];
        $sendrequest = SendRequest::where('user_id', Auth::user()->id)
            ->where('request_id', $id)
            ->get()
            ->first();
        $receiverequest = ReceiveRequest::where('request_id', Auth::user()->id)
            ->where('user_id', $id)
            ->get()
            ->first();
        $user = User::find($id);
        if ($sendrequest && $receiverequest) {
            $this->notification(Auth::user()->id, '"' . Auth::user()->name . '" cancel friend request, "' . $user->name . '" successful.!', now()->toDateString(), now()->toTimeString(), 'cancelrequest', '1');
            $sendrequest->delete();
            $receiverequest->delete();
            $receiveRequests = ReceiveRequest::where('request_id', $id)
                ->where('user_id', Auth::user()->id)
                ->get();
            return $this->apiresponse(
                [
                    'receiveRequests' => $receiveRequests,
                ],
                true,
                'Friend request cancel successfull.!',
                200,
            );
        } else {
            return $this->apiresponse('', false, 'Could not find Friend Request', 200);
        }
        // return redirect('/profile')->with('success', 'Friend request cancel successfull');
    }
    // confirm request
    public function confirmrequest(Request $request)
    {
        $id = (int) $request['id'];
        $sendrequest = SendRequest::where('user_id', $id)
            ->where('request_id', Auth::user()->id)
            ->get()
            ->first();
        $receiverequest = ReceiveRequest::where('request_id', $id)
            ->where('user_id', Auth::user()->id)
            ->get()
            ->first();
        if ($sendrequest && $receiverequest) {
            $user = User::find($receiverequest->request_id);
            $this->confirm_request($receiverequest->request_id, Auth::user()->id, '1');
            $this->notification(Auth::user()->id, '"' . Auth::user()->name . '" Confirm friend request, "' . $user->name . '" successful.!', now()->toDateString(), now()->toTimeString(), 'confirmrequest', '1');
            $sendrequest->delete();
            $receiverequest->delete();
            $friends = Friend::where('user_id', Auth::user()->id)->get();
            return $this->apiresponse(
                [
                    'friends' => $friends,
                ],
                true,
                'Friend request confirm successfull.!',
                200,
            );
        } else {
            return $this->apiresponse('', false, 'Could not find Friend Request', 200);
        }
    }
    // all friend request recived
    public function allrequest()
    {
        $receiveRequests = ReceiveRequest::where('user_id', Auth::user()->id)->get();
        return $this->apiresponse(
            [
                'receiveRequests' => $receiveRequests,
            ],
            true,
            'All received request.!',
            200,
        );
    }
    // all friend request send
    public function allsend()
    {
        $sendRequests = SendRequest::where('user_id', Auth::user()->id)->get();
        return $this->apiresponse(
            [
                'sendRequests' => $sendRequests,
            ],
            true,
            'All send request.!',
            200,
        );
    }
    // Chat Start make message
    public function makemessage(Request $request)
    {
        $id = (int) $request['id'];
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
            return $this->make_message();
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
                return $this->make_message();
            } else {
                $chat_id = Chat::create([
                    'user_id' => $my_id,
                    'sender_id' => $my_id,
                    'receiver_id' => $id,
                    'lastmessage' => $request->input('message'),
                ])->id;
                $this->message($chat_id, $request->input('message'), $my_id, $id, false, 'text');
                return $this->make_message();
            }
        }
    }
    public function chats()
    {
        $chats = Chat::orderby('updated_at', 'desc')
            ->where('sender_id', Auth::user()->id)
            ->orwhere('receiver_id', Auth::user()->id)
            ->get();
        return $this->apiresponse(
            [
                'chats' => $chats,
            ],
            true,
            'All chat list.!',
            AppResponse::HTTP_OK,
        );
    }
    public function chatmessage($id)
    {
        $my_id = Auth::user()->id;
        $messages = Message::where('chat_id', $id)->get();
        $chat = Chat::find($id);
        $user = '';
        if ($my_id == $chat->receiver_id) {
            $user = User::find($chat->sender_id);
        } elseif ($my_id == $chat->sender_id) {
            $user = User::find($chat->receiver_id);
        }
        return $this->apiresponse(
            [
                'messages' => $messages,
                'user' => $user,
                'chat_id' => $id,
            ],
            true,
            'All messages.!',
            AppResponse::HTTP_OK,
        );
    }
    public function chatmessage_store(Request $request)
    {
        $id = (int) $request['id'];
        $my_id = Auth::user()->id;
        Chat::where('id', $id)->update([
            'lastmessage' => $request->input('message'),
        ]);
        $this->message($id, $request->input('message'), Auth::user()->id, $request->input('receiver_id'), false, 'text');
        $messages = Message::where('chat_id', $id)->get();
        $chat = Chat::find($id);
        $user = '';
        if ($my_id == $chat->receiver_id) {
            $user = User::find($chat->sender_id);
        } elseif ($my_id == $chat->sender_id) {
            $user = User::find($chat->receiver_id);
        }
        return $this->apiresponse(
            [
                'messages' => $messages,
                'user' => $user,
                'chat_id' => $id,
            ],
            true,
            'Messages send successful.!',
            AppResponse::HTTP_OK,
        );
    }
    public function sendpoints(Request $request)
    {
        $id = (int) $request['id'];
        $chat_id = (int) $request['chatid'];
        $my_id = Auth::user()->id;
        $receiver = User::find($id);
        $sender = User::find($my_id);
        if ($sender->profile->points >= (int) $request->input('message')) {
            $totalplus = $receiver->profile->points + $request->input('message');
            $totalminus = $sender->profile->points - $request->input('message');
            Chat::where('id', $chat_id)->update([
                'lastmessage' => 'Point Sharing',
            ]);
            $this->pointupdate($id, $totalplus);
            $this->pointupdate($my_id, $totalminus);
            $this->history($id, 'You received ' . $request->input('message') . ' points from ' . $sender->name, 'points');
            $this->history($my_id, 'You send ' . $request->input('message') . ' points to ' . $receiver->name, 'points');
            $this->message($chat_id, $request->input('message'), $my_id, $id, false, 'points');
            $this->notification(Auth::user()->id, '"' . $sender->name . '" send ' . $request->input('message') . ' points to "' . $receiver->name . '" successfully.!', now()->toDateString(), now()->toTimeString(), 'points', '1');
            $messages = Message::where('chat_id', $chat_id)->get();
            return $this->apiresponse(
                [
                    'messages' => $messages,
                    'chat_id' => $chat_id,
                ],
                true,
                'Points send successful.!',
                AppResponse::HTTP_OK,
            );
        } else {
            return $this->apiresponse('', false, 'Insufficient points for sharing.!', AppResponse::HTTP_INSUFFICIENT_STORAGE);
        }
    }
    public function sendcard(Request $request)
    {
        $id = (int) $request['id'];
        $chat_id = (int) $request['chatid'];
        $my_id = Auth::user()->id;
        $receiver = User::find($id);
        $sender = User::find($my_id);
        $message = $request->input('message');
        $cardname = User::find($message);
        if ($my_id == (int) $message) {
            return $this->apiresponse('', false, 'You can not send your contact card to others.!', AppResponse::HTTP_UNPROCESSABLE_ENTITY);
        } elseif ($receiver->id == (int) $message) {
            return $this->apiresponse('', false, 'You can not send ' . $receiver->name . '\'s contact card to ' . $receiver->name . '.!', AppResponse::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            Chat::where('id', $chat_id)->update([
                'lastmessage' => 'Contact card Sharing',
            ]);
            $this->history($id, 'You received an contact card ' . $message . ' from ' . $sender->name, 'contactcard');
            $this->history($my_id, 'You send an contact card ' . $message . ' to ' . $receiver->name, 'contactcard');
            $this->message($chat_id, $message, $my_id, $id, false, 'contactcard');
            $this->notification(Auth::user()->id, '"' . $sender->name . '" send contact card of ' . $cardname->name . ' to "' . $receiver->name . '" successfully.!', now()->toDateString(), now()->toTimeString(), 'contactcard', '1');
            $messages = Message::where('chat_id', $chat_id)->get();
            return $this->apiresponse(
                [
                    'messages' => $messages,
                    'chat_id' => $chat_id,
                ],
                true,
                'Contact card send successful.!',
                AppResponse::HTTP_OK,
            );
        }
    }
    public function pointhistory()
    {
        $history = History::where('user_id', Auth::user()->id)->get();
        return $this->apiresponse(
            [
                'history' => $history,
            ],
            true,
            'All of your Point history read successful.!',
            AppResponse::HTTP_OK,
        );
    }
    public function all_modeltest()
    {
        $user = Auth::user();
        $modeltests = ModelTestAll::where('allclass_id', $user->profile->class)->where('type', '=', 'on')->get();
        if ($user->profile->class != '') {
            return $this->apiresponse(
                [
                    'modeltests' => $modeltests,
                ],
                true,
                'All Modeltests accroding to selected clsass read successful.!',
                AppResponse::HTTP_OK,
            );
        } else {
            return $this->apiresponse('', false, 'Currently you do not select your class, please select your class and try again.!', AppResponse::HTTP_OK);
        }
    }
    public function my_modeltest(Request $request)
    {
        $id = $request['id'];
        $user = Auth::user();
        $modeltestresult = ModelTestResult::where('modeltest_id', $id)->where('user_id', (int)$user->id)->get()->first();
        if ($modeltestresult) {
            $modeltests = ModelTestAll::where('allclass_id', $user->profile->class)->where('type', '=', 'on')->get();
            if ($user->profile->class != '') {
                return $this->apiresponse(
                    [
                        'modeltests' => $modeltests,
                    ],
                    true,
                    'All Modeltests accroding to selected clsass read successful.!',
                    AppResponse::HTTP_OK,
                );
            } else {
                return $this->apiresponse('', false, 'Currently you do not select your class, please select your class and try again.!', AppResponse::HTTP_OK);
            }
        } else {
            return $this->apiresponse('', false, 'You can not take any model test exam, please select all modeltest and give exam one.!', AppResponse::HTTP_OK);
        }
    }
    public function model_syllabus(Request $request)
    {
        $id = $request['id'];
        $syllabs = ModelSyllabus::where('modeltest_id', $id)
            ->get()
            ->first();
        if ($syllabs) {
            return $this->apiresponse(
                [
                    'syllabs' => $syllabs,
                ],
                true,
                'Read Model test syllabus',
                AppResponse::HTTP_OK,
            );
        } else {
            return $this->apiresponse('', false, 'Dear user, Please wait for upload ' . 'Modeltest\'s syllabus. Thank you.!', AppResponse::HTTP_NOT_FOUND);
        }
    }
    public function model_exam(Request $request)
    {
        $id = $request['id'];
        $modeltest = ModelTestAll::find($id);
        $question = ModelQuestion::where('modeltest_id', $id)->get();
        $totalquestion = ModelQuestion::where('modeltest_id', $id)->count();
        return $this->apiresponse(
            [
                'modeltest' => $modeltest,
                'question' => $question,
                'totalquestion' => $totalquestion,
            ],
            true,
            'Modeltest Exam with total question.!',
            AppResponse::HTTP_OK,
        );
    }
    public function model_examresult(Request $request)
    {
        $id = $request['id'];
        $user = User::find(Auth::user()->id);
        $modeltest = ModelTestAll::find($id);
        $right = 0;
        $wrong = 0;
        foreach ($request->input('ans') as $ans) {
            $input = Str::substr($ans, 1, 1);
            $correct = Str::substr($ans, 2, 1);
            if ($input == $correct) {
                $right++;
            } else {
                $wrong++;
            }
        }
        $negative = $wrong / 4;
        $mark = $right - $negative;
        $totalquestion = $request->input('totalquestion');
        $totalpoint = $user->profile->points + $mark;
        $modeltestresult = ModelTestResult::where('modeltest_id', $id)
            ->where('user_id', $user->id)
            ->get()
            ->first();
        if ($modeltestresult) {
            $this->notification($user->id, '"' . $user->name . '" get ' . $mark . ' from repeat Modeltest "' . $modeltest->name . '".!', now()->toDateString(), now()->toTimeString(), 'modeltest', '1');
            $this->modeltestresult_make($id, $user->id, 'Repeat', $totalquestion, $right, $wrong, $mark, $negative);
        } else {
            $this->pointupdate($user->id, $totalpoint);
            $this->history($user->id, 'You get "' . $mark . '" points from "' . $modeltest->name . '" Modeltest Exam.! Where total question "' . $totalquestion . '", right answered "' . $right . '", wrong answered "' . $wrong . '", nagetive mark "' . $negative . '", total mark "' . $mark . '"', 'modeltest');
            $this->notification($user->id, '"' . $user->name . '" get ' . $mark . ' from Modeltest "' . $modeltest->name . '".!', now()->toDateString(), now()->toTimeString(), 'modeltest', '1');
            $this->modeltestresult_make($id, $user->id, '1st Time', $totalquestion, $right, $wrong, $mark, $negative);
        }
        $mtresults = ModelTestResult::where('modeltest_id', $id)
            ->where('user_id', Auth::user()->id)
            ->get();
        return $this->apiresponse(
            [
                'mtresults' => $mtresults
            ],
            true,
            'Modeltest result.!',
            AppResponse::HTTP_OK,
        );
    }
    public function model_result($id)
    {
        $results = ModelTestResult::where('modeltest_id', $id)
            ->where('user_id', Auth::user()->id)
            ->get();
        return $this->apiresponse(
            [
                'results' => $results,
            ],
            true,
            'The result of modeltest exam is ready to display.!',
            AppResponse::HTTP_OK,
        );
    }
    public function all_event()
    {
        $events = Event::where('status', '!=', 'create')->get();
        return $this->apiresponse(
            [
                'events' => $events,
            ],
            true,
            'All events read successful.!',
            AppResponse::HTTP_OK,
        );
    }
    public function my_events()
    {
        $events = Enroll::where('user_id', Auth::user()->id)->get();
        return $this->apiresponse(
            [
                'events' => $events,
            ],
            true,
            'My events read successful.!',
            AppResponse::HTTP_OK,
        );
    }
    public function event_enroll(Request $request)
    {
        $id = $request['id'];
        $user = Auth::user();
        $existEnroll = Enroll::where('event_id', $id)
            ->where('user_id', $user->id)
            ->get()
            ->first();
        $events = Event::find($id);
        if ($existEnroll) {
            return $this->apiresponse(
                [
                    'events' => $events,
                ],
                false,
                'You already enroll this event.!',
                AppResponse::HTTP_UNPROCESSABLE_ENTITY,
            );
        } else {
            if ($events->price == 'free') {
                Enroll::create([
                    'event_id' => $id,
                    'user_id' => $user->id,
                ]);
                $this->notification($user->id, '"' . Auth::user()->name . '" successfully enroll in event "' . $events->name . '"', now()->toDateString(), now()->toTimeString(), 'enroll', '1');
                return $this->apiresponse(
                    [
                        'events' => $events,
                    ],
                    true,
                    'You have successfully enroll this free event "' . $events->name . '"',
                    AppResponse::HTTP_OK,
                );
            } else {
                if ($user->profile->points >= $events->price) {
                    $update_points = $user->profile->points - $events->price;
                    Enroll::create([
                        'event_id' => $id,
                        'user_id' => $user->id,
                    ]);
                    $this->notification($user->id, '"' . Auth::user()->name . '" successfully enroll in event "' . $events->name . '"', now()->toDateString(), now()->toTimeString(), 'enroll', '1');
                    $this->pointupdate($user->id, $update_points);
                    $this->history($user->id, 'You enroll an event "' . $events->name . '", and reduce point "' . $update_points . '"', 'eventenroll');
                    return $this->apiresponse(
                        [
                            'events' => $events,
                        ],
                        true,
                        'You have successfully enroll this paid event "' . $events->name . '"',
                        AppResponse::HTTP_OK,
                    );
                } else {
                    return $this->apiresponse('', false, 'You do not have enough points to enroll this event, please increase your point and try again, Thank you for stay with us.!', AppResponse::HTTP_INSUFFICIENT_STORAGE);
                }
            }
        }
    }
    public function event_syllabus(Request $request)
    {
        $id = $request['id'];
        $syllabs = Syllabus::where('event_id', $id)
            ->get()
            ->first();
        if ($syllabs) {
            return $this->apiresponse(
                [
                    'syllabs' => $syllabs,
                ],
                true,
                'Read Event syllabus',
                AppResponse::HTTP_OK,
            );
        } else {
            return $this->apiresponse('', false, 'Dear user, Please wait for upload ' . 'event\'s syllabus. Thank you.!', AppResponse::HTTP_NOT_FOUND);
        }
    }
    public function event_participant(Request $request)
    {
        $id = (int) $request['id'];
        $event = Event::find($id);
        $enrolls = Enroll::orderby('created_at', 'desc')
            ->where('event_id', $id)
            ->get();
        return $this->apiresponse(
            [
                'event' => $event,
                'enrolls' => $enrolls,
            ],
            true,
            'Event Participant list.!',
            AppResponse::HTTP_OK,
        );
    }
    public function event_exam(Request $request)
    {
        $id = $request['id'];
        $existresult = Result::where('event_id', $id)
            ->where('user_id', Auth::user()->id)
            ->get()
            ->first();
        if ($existresult) {
            return $this->apiresponse('', true, 'You already take this exam.!', AppResponse::HTTP_ACCEPTED);
        } else {
            $event = Event::find($id);
            $question = Question::where('event_id', $id)->get();
            $totalquestion = Question::where('event_id', $id)->count();
            if ($event->status == 'start') {
                return $this->apiresponse(
                    [
                        'event' => $event,
                        'question' => $question,
                        'totalquestion' => $totalquestion,
                    ],
                    true,
                    'Event Exam with total question.!',
                    AppResponse::HTTP_OK,
                );
            } else {
                return $this->apiresponse('', true, 'This Event Exam not started right now.!', AppResponse::HTTP_OK);
            }
        }
    }
    public function event_result($id)
    {
        $results = Result::orderby('total_mark', 'desc')
            ->where('event_id', $id)
            ->get();
        return $this->apiresponse(
            [
                'results' => $results,
            ],
            true,
            'The result of event exam is ready to display.!',
            AppResponse::HTTP_OK,
        );
    }
    public function make_result(Request $request)
    {
        $id = $request['id'];
        $my_id = Auth::user()->id;
        $user = User::find($my_id);
        $event = Event::find($id);
        $right = 0;
        $wrong = 0;
        foreach ($request->input('ans') as $ans) {
            $input = Str::substr($ans, 1, 1);
            $correct = Str::substr($ans, 2, 1);
            if ($input == $correct) {
                $right++;
            } else {
                $wrong++;
            }
        }
        $negative = $wrong / 4;
        $mark = $right - $negative;
        $totalquestion = $request->input('totalquestion');
        $totalpoint = $user->profile->points + $mark;
        $this->pointupdate($my_id, $totalpoint);
        $this->history($my_id, 'You get "' . $mark . '" points from "' . $event->name . '" Event Exam.! Where total question "' . $totalquestion . '", right answered "' . $right . '", wrong answered "' . $wrong . '", nagetive mark "' . $negative . '", total mark "' . $mark . '"', 'exam');
        $this->notification($my_id, '"' . $user->name . '" get ' . $mark . ' from Event "' . $event->name . '".!', now()->toDateString(), now()->toTimeString(), 'exam', '1');
        $this->result_make($id, $my_id, $totalquestion, $right, $wrong, $mark, $negative);
        $results = Result::where('event_id', $id)->get();
        return $this->apiresponse(
            [
                'results' => $results,
            ],
            true,
            'Result of this event is.',
            200,
        );
    }
}
