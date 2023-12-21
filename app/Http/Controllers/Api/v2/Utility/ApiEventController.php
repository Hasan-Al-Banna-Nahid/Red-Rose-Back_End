<?php

namespace App\Http\Controllers\Api\v2\Utility;

use App\Http\Controllers\Controller;
use App\Models\Enroll;
use App\Models\Event;
use App\Models\Question;
use App\Models\Result;
use App\Models\Syllabus;
use App\Models\User;
use App\Traits\AppResponse;
use App\Traits\HttpAppResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ApiEventController extends Controller
{
    use HttpAppResponse;
    public function all_event()
    {
        $events = Event::where('status', '!=', 'create')->get(['id', 'name', 'date', 'time', 'type', 'price', 'image_path', 'duration']);
        return $this->apiresponse(['events' => $events], true, 'All events read successful.!', AppResponse::HTTP_OK);
    }
    public function my_events()
    {
        $enrolls = Enroll::where('user_id', Auth::user()->id)->pluck('event_id');
        $events = Event::whereIn('id', $enrolls)->get(['id', 'name', 'date', 'time', 'type', 'price', 'image_path', 'duration']);
        return $this->apiresponse(['events' => $events], true, 'My events read successful.!', AppResponse::HTTP_OK);
    }
    public function event_enroll(Request $request)
    {
        $id = $request['event_id'];
        $event = Event::find($id);
        if ($event) {
            $user = Auth::user();
            $existEnroll = Enroll::where('event_id', $id)
                ->where('user_id', $user->id)
                ->first();
            if ($existEnroll) {
                return $this->apiresponse(['event' => $event], false, 'You already enroll this event.!', AppResponse::HTTP_UNPROCESSABLE_ENTITY);
            } else {
                if ($event->price == 'free') {
                    Enroll::create([
                        'event_id' => $id,
                        'user_id' => $user->id,
                    ]);
                    $this->notification($user->id, '"' . Auth::user()->name . '" successfully enroll in event "' . $event->name . '"', now()->toDateString(), now()->toTimeString(), 'enroll', '1');
                    return $this->apiresponse(['event' => $event], true, 'You have successfully enroll this free event "' . $event->name . '"', AppResponse::HTTP_OK);
                } else {
                    if ($user->profile->points >= $event->price) {
                        $update_points = $user->profile->points - $event->price;
                        Enroll::create([
                            'event_id' => $id,
                            'user_id' => $user->id,
                        ]);
                        $this->notification($user->id, '"' . Auth::user()->name . '" successfully enroll in event "' . $event->name . '"', now()->toDateString(), now()->toTimeString(), 'enroll', '1');
                        $this->pointupdate($user->id, $update_points);
                        $this->history($user->id, 'You enroll an event "' . $event->name . '", and reduce point "' . $update_points . '"', 'eventenroll');
                        return $this->apiresponse(['events' => $event], true, 'You have successfully enroll this paid event "' . $event->name . '"', AppResponse::HTTP_OK);
                    } else {
                        return $this->apiresponse('', false, 'You do not have enough points to enroll this event, please increase your point and try again, Thank you for stay with us.!', AppResponse::HTTP_INSUFFICIENT_STORAGE);
                    }
                }
            }
        } else {
            return $this->apiresponse(['event' => $event], false, 'Dear user, Event Can\'t find. Thank you.!', AppResponse::HTTP_NOT_FOUND);
        }
    }
    public function event_syllabus(Request $request, $id)
    {
        $event = Event::find($id);
        if ($event) {
            $syllabs = Syllabus::where('event_id', $id)->first();
            if ($syllabs) {
                return $this->apiresponse(['syllabs' => $syllabs], true, 'Read Event syllabus', AppResponse::HTTP_OK);
            } else {
                return $this->apiresponse('', false, 'Dear user, Please wait for upload event\'s syllabus. Thank you.!', AppResponse::HTTP_NOT_FOUND);
            }
        } else {
            return $this->apiresponse('', false, 'Dear user, Event Can\'t find. Thank you.!', AppResponse::HTTP_NOT_FOUND);
        }
    }
    public function event_participant(Request $request, $id)
    {
        // $id = $request['id'];

        $enrolls = Enroll::pluck('user_id');
        $uesrs = User::whereIn('id', $enrolls)->get(['id', 'name', 'redrose_id']);
        $event = Event::find($id);
        $enrolls = Enroll::orderby('created_at', 'desc')
            ->where('event_id', $id)
            ->get();
        return $this->apiresponse(['event' => $event, 'enrolls' => ['users' => $uesrs]], true, 'Event Participant list.!', AppResponse::HTTP_OK);
    }
    public function event_take_exam($id)
    {
        $event = Event::find($id);
        $question = Question::where('event_id', $id)
            ->inRandomOrder()
            ->get(['id', 'event_id', 'name', 'option1', 'option2', 'option3', 'option4', 'option5']);
        if ($event->status == 'start') {
            return $this->apiresponse(
                [
                    'event' => $event,
                    'totalquestion' => $question->count(),
                    'question' => $question,
                ],
                true,
                'Exam Question',
                AppResponse::HTTP_OK,
            );
        } else {
            return $this->apiresponse('', false, 'This exam not start right now...!', AppResponse::HTTP_NOT_FOUND);
        }
    }
    public function event_submit_exam_for_result(Request $request)
    {
        $data = [
            'event_id' => $request->input('event_id'),
            'totalquestion' => $request->input('totalquestion'),
            'ans' => $request->input('ans'),
        ];
        $roules = [
            'event_id' => 'required',
            'totalquestion' => 'required',
            'ans' => 'required',
        ];
        if ($this->request_validator($data, $roules)) {
            return $this->apiresponse('', false, 'Make sure you need to fill all the required parametter.', 200);
        } else {
            $id = $request['event_id'];
            $user = Auth::user();
            if (
                Result::where('event_id', $id)
                    ->where('user_id', Auth::user()->id)
                    ->exists()
            ) {
                return $this->apiresponse('', false, 'You already take this exam....!', AppResponse::HTTP_UNPROCESSABLE_ENTITY);
            } else {
                $event = Event::find($id);
                $right = 0;
                $wrong = 0;
                foreach ($request->input('ans') as $k => $ans) {
                    $question_id = Str::substr($ans, 0, 1);
                    $optopn = Str::substr($ans, 2, 1);
                    if ($this->getCurrectAns($question_id, $optopn)) {
                        $right++;
                    } else {
                        $wrong++;
                    }
                    $give_ans = $k + 1;
                }

                $negative = $wrong / 4;
                $mark = $right - $negative;
                $totalquestion = $request->input('totalquestion');
                $not_give_ans = $totalquestion - $give_ans;

                $totalpoint = $user->profile->points + $mark;
                // return 'R ' . $right . ', W ' . $wrong . ', N ' . $negative . ', M ' . $mark . ', TQ ' . $totalquestion . ', TP ' . $totalpoint . ', GA ' . $give_ans . ', NGA ' . $not_give_ans;
                $this->pointupdate($user->id, $totalpoint);
                $this->history($user->id, 'You get "' . $mark . '" points from "' . $event->name . '" Event Exam.! Where total question "' . $totalquestion . '", right answered "' . $right . '", wrong answered "' . $wrong . '", nagetive mark "' . $negative . '", total mark "' . $mark . '"', 'exam');
                $this->notification($user->id, '"' . $user->name . '" get ' . $mark . ' from Event "' . $event->name . '".!', now()->toDateString(), now()->toTimeString(), 'exam', '1');
                $this->result_make($id, $user->id, $totalquestion, $right, $wrong, $mark, $negative, $give_ans, $not_give_ans);
                $results = Result::where('event_id', $id)
                    ->where('user_id', $user->id)
                    ->get(['id', 'event_id', 'user_id', 'total_q', 'r_ans', 'w_ans', 'total_mark', 'neg_mark', 'give_ans', 'not_give_ans']);
                return $this->apiresponse(['results' => $results], true, 'Result of this event is.', AppResponse::HTTP_OK);
            }
        }
    }
    public function event_get_result($id)
    {
        $results = Result::latest()
            ->where('event_id', $id)
            ->get(['id', 'event_id', 'user_id', 'total_q', 'r_ans', 'w_ans', 'total_mark', 'neg_mark', 'give_ans', 'not_give_ans']);
        return $this->apiresponse(['results' => $results], true, 'The result of event exam is ready to display.!', AppResponse::HTTP_OK);
    }
}
