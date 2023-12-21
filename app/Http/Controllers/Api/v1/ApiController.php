<?php
namespace App\Http\Controllers\Api\v1\ApiController;
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
use Laravel\Jetstream\Jetstream;
use App\Traits\HttpAppResponse;
use DateTime;
use Illuminate\Support\Facades\Auth;
class ApiController extends Controller
{
    use HttpAppResponse;
    // old user handaling,
    public function old_user_create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => 'required',
            'password_confirmation' => 'required',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ]);
        $user = User::create([
            'user_type' => '2',
            'redrose_id' => $request['redrose_id'],
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        if ($user) {
            $redrose_id = str_replace(' ', '', Str::lower($request['name']) . rand(100, 99999));
            Profile::create([
                'user_id' => $user->id,
                'date' => now()->toDateString(),
                'once' => 'no',
                'phone' => $request['phone'],
                'points' => $request['points'],
            ]);
            SocialLink::create([
                'user_id' => $user->id,
            ]);
            Friend::create([
                'user_id' => $user->id,
                'friend_id' => '2',
                'type' => '1',
            ]);
            Notification::create([
                'user_id' => $user->id,
                'name' => $request['name'] . ' User Create from app successful.!',
                'date' => now()->toDateString(),
                'time' => now()->toTimeString(),
                'type' => 'user',
                'status' => '1',
            ]);
            return $this->apiresponse($user, true, 'User Created Successfull.!', AppResponse::HTTP_OK);
        } else {
            return $this->apiresponse('', false, "User can't Create.!", AppResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
    // old user handaling end
    // Login in function start
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                // if (!Auth::attempt($request->only(['email', 'password']))) {
                Notification::create([
                    'user_id' => $user->id,
                    'name' => $user->name . ' Login by email.!',
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                    'type' => 'login',
                    'status' => '1',
                ]);
                return $this->apiresponse(
                    [
                        'user' => $user,
                        'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken,
                    ],
                    true,
                    'You have successfully logged in.!',
                    AppResponse::HTTP_OK,
                );
                // } else {
                //     return $this->error('', '1Credentials does not match', 422);
                // }
            } else {
                return $this->apiresponse('', false, 'Credentials does not match', AppResponse::HTTP_UNAUTHORIZED);
            }
        } else {
            $redrose_id = Profile::where('redrose_id', $request->email)->first();
            $userbyprofile = User::where('id', (int) $redrose_id->user_id)
                ->get()
                ->first();
            if ($redrose_id && Hash::check($request->password, $userbyprofile->password)) {
                // if (!Auth::attempt($request->only(['email', 'password']))) {
                Notification::create([
                    'user_id' => $userbyprofile->id,
                    'name' => $userbyprofile->name . ' Login by redrose_id.!',
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                    'type' => 'login',
                    'status' => '1',
                ]);
                return $this->apiresponse(
                    [
                        'user' => $userbyprofile,
                        'token' => $userbyprofile->createToken('API Token of ' . $userbyprofile->name)->plainTextToken,
                    ],
                    true,
                    'You have successfully logged in.!',
                    AppResponse::HTTP_OK,
                );
                // } else {
                //     return $this->error('', '1Credentials does not match', 422);
                // }
            } else {
                return $this->apiresponse('', false, 'Credentials does not match', AppResponse::HTTP_UNAUTHORIZED);
            }
        }
    }
    // Register function start
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => 'required',
            'password_confirmation' => 'required',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ]);
        $redrose_id = str_replace(' ', '', Str::lower($request['name']) . rand(100, 99999));
        $user = User::create([
            'user_type' => '2',
            'redrose_id' => $redrose_id,
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        if ($user) {Profile::create([
                'user_id' => $user->id,
                'date' => now()->toDateString(),
                'once' => 'no',
                'phone' => $request['phone'],
                'points' => '10',
            ]);
            SocialLink::create([
                'user_id' => $user->id,
            ]);
            Friend::create([
                'user_id' => $user->id,
                'friend_id' => '2',
                'type' => '1',
            ]);
            Notification::create([
                'user_id' => $user->id,
                'name' => $request['name'] . ' User Create from app successful.!',
                'date' => now()->toDateString(),
                'time' => now()->toTimeString(),
                'type' => 'user',
                'status' => '1',
            ]);
            return $this->apiresponse(
                [
                    'user' => $user,
                    'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken,
                ],
                true,
                'Congratulation, you have successfully created your account. Thank you for choosing RedRose Academy.!',
                AppResponse::HTTP_CREATED,
            );
        } else {
            return $this->apiresponse('', false, "User can't Create.!", 401);
        }
    }
    // Logout start
    public function logout(Request $request)
    {
        $request
            ->user()
            ->currentAccessToken()
            ->delete();
        return $this->apiresponse('', true, 'You have successfully logout', 200);
    }

    // All Class start
    public function all_class()
    {
        $allclass = AllClass::get();
        return $this->apiresponse(
            [
                'allclass' => $allclass,
            ],
            true,
            'All Class read succesfull.',
            AppResponse::HTTP_OK,
        );
    }
    // All Class start
    public function all_city()
    {
        $cities = City::get();
        return $this->apiresponse(
            [
                'cities' => $cities,
            ],
            true,
            'All Cities read succesfull.',
            AppResponse::HTTP_OK,
        );
    }
    // All Upazila start
    public function all_upazila()
    {
        $upazilas = Upazila::get();
        return $this->apiresponse(
            [
                'upazilas' => $upazilas,
            ],
            true,
            'All Upazila read succesfull.',
            AppResponse::HTTP_OK,
        );
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
