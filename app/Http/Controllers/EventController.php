<?php

namespace App\Http\Controllers;

use App\Models\Enroll;
use App\Models\Event;
use App\Models\History;
use App\Models\Notification;
use App\Models\Question;
use App\Models\Result;
use App\Models\Syllabus;
use App\Models\User;
use App\Traits\HttpWebResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    use HttpWebResponse;

    // Event
    public function event_index()
    {
        session()->put('eventCount', Event::count());
        session()->put('notificationlist', Notification::orderby('created_at', 'desc')->paginate(5));
        $eventlist = Event::paginate(10);
        return view('admin.event.index', [
            'eventlist' => $eventlist,
        ]);
    }
    public function event_create()
    {
        session()->put('eventCount', Event::count());
        session()->put('notificationlist', Notification::orderby('created_at', 'desc')->paginate(5));
        $eventlist = Event::paginate(10);
        return view('admin.event.create', [
            'eventlist' => $eventlist,
        ]);
    }

    public function event_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required',
            'time' => 'required',
            'type' => 'required',
            'price' => 'required',
            'duration' => 'required',
        ]);
        $image = '';
        if ($request->image_path) {
            $image = url('/') . '/storage/events/' . time() . '-' . $request->name . '.' . $request->image_path->extension();
            $request->image_path->move(public_path('storage/events'), $image);
        }
        Event::create([
            'name' => $request['name'],
            'date' => $request['date'],
            'time' => $request['time'],
            'type' => $request['type'],
            'status' => 'create',
            'price' => $request['price'],
            'image_path' => $image,
            'duration' => $request['duration'],
        ]);
        $this->notification(Auth::user()->id, $request['name'] . ' Event Created successful.!', now()->toDateString(), now()->toTimeString(), 'event', '1');
        session()->put('notificationCount', Notification::count());
        return redirect(route('event.index'))->with('success', $request['name'] . ' - added new event.!');
    }
    public function event_show($id)
    {
        $eventlist = Event::paginate(10);
        $event = Event::find($id);
        return view('admin.event.show', [
            'eventlist' => $eventlist,
            'event' => $event,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function event_edit($id)
    {
        $eventlist = Event::paginate(10);
        $event = Event::find($id);
        return view('admin.event.edit', [
            'eventlist' => $eventlist,
            'event' => $event,
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function event_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required',
            'time' => 'required',
            'type' => 'required',
            'status' => 'required',
            'price' => 'required',
            'duration' => 'required',
        ]);
        $event = Event::find($id);
        $image = '';
        if ($request->image_path) {
            $image = url('/') . '/storage/events/' . time() . '-' . $request->name . '.' . $request->image_path->extension();
            $request->image_path->move(public_path('storage/events/'), $image);
        } else {
            $image = $event->image_path;
        }
        $data = [
            'name' => $request['name'],
            'date' => $request['date'],
            'time' => $request['time'],
            'type' => $request['type'],
            'status' => $request['status'],
            'price' => $request['price'],
            'image_path' => $image,
            'duration' => $request['duration'],
        ];
        $this->notification(Auth::user()->id, $request['name'] . ' Event updated successful.!', now()->toDateString(), now()->toTimeString(), 'event', '1');
        session()->put('notificationCount', Notification::count());
        Event::where('id', $id)->update($data);
        return redirect(route('event.index'))->with('warning', $request['name'] . ' - event updated successful.!');
    }
    public function event_delete($id)
    {
        $event = Event::find($id);
        $event->delete();
        session()->put('eventCount', Event::count());
        return redirect(route('event.index'))->with('warning', 'Event deleted successful.!');
    }


    // Event Syllabus
    public function syllabus_index()
    {
        session()->put('syllabusCount', Syllabus::count());
        $eventlist = Event::get();
        $syllabuslist = Syllabus::paginate(10);
        session()->put('notificationlist', Notification::orderby('created_at', 'desc')->paginate(5));
        return view('admin.syllabus.index', [
            'eventlist' => $eventlist,
            'syllabuslist' => $syllabuslist,
        ]);
    }

    public function syllabus_store(Request $request)
    {
        $request->validate([
            'event_id' => 'required',
            'name' => 'required',
            'description' => 'required',
        ]);

        Syllabus::create([
            'event_id' => $request['event_id'],
            'name' => $request['name'],
            'description' => $request['description'],
        ]);
        $this->notification(Auth::user()->id, $request['name'] . ' Syllabus created successful.!', now()->toDateString(), now()->toTimeString(), 'syllabus', '1');
        session()->put('notificationCount', Notification::count());
        return back()->with('success', $request['name'] . ' - added new syllabus.!');
    }

    /**
     * Display the specified resource.
     */
    public function syllabus_show($id)
    {
        $syllabus = Syllabus::find($id);
        $syllabuslist = Syllabus::paginate(10);

        return view('admin.syllabus.show', [
            'syllabus' => $syllabus,
            'syllabuslist' => $syllabuslist,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function syllabus_edit($id)
    {
        $syllabus = Syllabus::find($id);
        $syllabuslist = Syllabus::paginate(10);

        return view('admin.syllabus.edit', [
            'syllabus' => $syllabus,
            'syllabuslist' => $syllabuslist,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function syllabus_update(Request $request, $id)
    {
        $request->validate([
            'event_id' => 'required',
            'name' => 'required',
            'description' => 'required',
        ]);

        Syllabus::where('id', $id)->update([
            'event_id' => $request['event_id'],
            'name' => $request['name'],
            'description' => $request['description'],
        ]);
        $this->notification(Auth::user()->id, $request['name'] . ' Syllabus updated successful.!', now()->toDateString(), now()->toTimeString(), 'syllabus', '1');
        session()->put('notificationCount', Notification::count());
        return redirect(route('syllabus.index'))->with('warning', $request['name'] . ' - updated syllabus.!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function syllabus_delete($id)
    {
        $syllabus = Syllabus::find($id);
        $syllabus->delete();
        session()->put('syllabusCount', Syllabus::count());
        return redirect('/syllabus')->with('warning', 'Syllabus deleted successful.!');
    }

    // Event Question
    public function question_index()
    {
        $eventlist = Event::get();
        $questionlist = Question::paginate(10);
        session()->put('questionCount', Question::count());
        session()->put('notificationlist', Notification::orderby('created_at', 'desc')->paginate(5));

        return view('admin.question.index', [
            'questionlist' => $questionlist,
            'eventlist' => $eventlist,
        ]);
    }

    public function question_store(Request $request)
    {
        $request->validate([
            'event_id' => 'required',
            'name' => 'required',
            'option1' => 'required',
            'option2' => 'required',
            'option3' => 'required',
            'option4' => 'required',
            'option5' => 'required',
        ]);

        Question::create([
            'event_id' => $request['event_id'],
            'name' => $request['name'],
            'option1' => $request['option1'],
            'option2' => $request['option2'],
            'option3' => $request['option3'],
            'option4' => $request['option4'],
            'option5' => $request['option5'],
        ]);
        $this->notification(Auth::user()->id, $request['name'] . ' Question Created successful.!', now()->toDateString(), now()->toTimeString(), 'question', '1');
        session()->put('notificationCount', Notification::count());
        return back()->with('success', $request['name'] . ' - added new question.!');
    }

    public function question_show($id)
    {
        $question = Question::find($id);
        $questionlist = Question::paginate(10);

        return view('admin.question.show', [
            'questionlist' => $questionlist,
            'question' => $question,
        ]);
    }

    public function question_edit($id)
    {
        $question = Question::find($id);
        $questionlist = Question::paginate(10);

        return view('admin.question.edit', [
            'questionlist' => $questionlist,
            'question' => $question,
        ]);
    }

    public function question_update(Request $request, $id)
    {
        $request->validate([
            'event_id' => 'required',
            'name' => 'required',
            'option1' => 'required',
            'option2' => 'required',
            'option3' => 'required',
            'option4' => 'required',
            'option5' => 'required',
        ]);

        Question::where('id', $id)->update([
            'event_id' => $request['event_id'],
            'name' => $request['name'],
            'option1' => $request['option1'],
            'option2' => $request['option2'],
            'option3' => $request['option3'],
            'option4' => $request['option4'],
            'option5' => $request['option5'],
        ]);
        $this->notification(Auth::user()->id, $request['name'] . ' Question updated successful.!', now()->toDateString(), now()->toTimeString(), 'question', '1');
        session()->put('notificationCount', Notification::count());
        return redirect('/question')->with('success', $request['name'] . ' - added new question.!');
    }

    public function question_delete($id)
    {
        $question = Question::find($id);
        $question->delete();
        session()->put('questionCount', Question::count());
        return redirect(route('question.index'))->with('warning', 'Question deleted successful.!');
    }

    public function e_syllabus($id)
    {
        $event = Event::find($id);
        $syllabuslist = Syllabus::where('event_id', $id)->paginate(10);
        return view('admin.event.syllabus', [
            'syllabuslist' => $syllabuslist,
            'event' => $event
        ]);
    }
    public function e_question($id)
    {
        session()->put('tempQuestion',Question::where('event_id', $id)->count());
        $event = Event::find($id);
        $questionlist = Question::where('event_id', $id)->paginate(10);
        return view('admin.event.question', [
            'questionlist' => $questionlist,
            'event' => $event
        ]);
    }

    public function events()
    {
        $eventList = Event::where('status', '!=', 'create')->get();
        return view('frontend.pages.event', [
            'eventList' => $eventList,
        ]);
    }
    public function myevents()
    {
        $eventList = Enroll::where('user_id', Auth::user()->id)->get();
        return view('frontend.pages.eevent', [
            'eventList' => $eventList,
        ]);
    }
    public function enroll($id)
    {
        $user = Auth::user();
        $existEnroll = Enroll::where('event_id', $id)
            ->where('user_id', $user->id)
            ->get()
            ->first();
        $event = Event::find($id);

        if ($existEnroll) {
            return redirect('/myevents')->with('warning', 'You already enroll this event ' . $event->name);
        } else {
            if ($event->price == 'free') {
                Enroll::create([
                    'event_id' => $id,
                    'user_id' => $user->id,
                ]);
                $this->notification($user->id, '"' . Auth::user()->name . '" successfully enroll in event "' . $event->name . '"', now()->toDateString(), now()->toTimeString(), 'enroll', '1');
                return back()->with('success', 'You have successfully enroll this free event "' . $event->name . '"');
            }else {
                if ($user->profile->points >= $event->price) {
                    $update_points = $user->profile->points - $event->price;
                    Enroll::create([
                        'event_id' => $id,
                        'user_id' => $user->id,
                    ]);
                    $this->notification($user->id, '"' . Auth::user()->name . '" successfully enroll in event "' . $event->name . '"', now()->toDateString(), now()->toTimeString(), 'enroll', '1');
                    $this->pointupdate($user->id, $update_points);
                    $this->history($user->id, 'You enroll an event "' . $event->name . '", and reduce point "' . $update_points .  '"', 'eventenroll');
                    return back()->with('success', 'You have successfully enroll ' . $event->name);
                }else {
                    return back()->with('warning', 'You do not have enough points to enroll this event, please increase your point and try again, Thank you for stay with us.!');
                }

            }
        }
    }
    public function eventsyllabus($id)
    {
        $syllabs = Syllabus::where('event_id', $id)
            ->get()
            ->first();
        if ($syllabs) {
            return view('frontend.pages.esyllabus', [
                'syllabs' => $syllabs,
            ]);
        } else {
            return back()->with('warning', 'Dear user, Please wait for upload ' . 'event\'s syllabus. Thank you.');
        }
    }
    public function eventparticipant($id)
    {
        $event = Event::find($id);
        $enrolllist = Enroll::orderby('created_at', 'desc')->where('event_id', $id)->paginate(20);
        // session()->put('enrollcount', Enroll::where('event_id', $id)->count());
        return view('frontend.pages.participant', [
            'event' => $event,
            'enrolllist' => $enrolllist,
        ]);
    }
    public function admin_participant($id)
    {
        $enrolllist = Enroll::where('event_id', )->orderby('created_at', 'desc')->where('event_id', $id)->paginate(20);
        // session()->put('enrollcount', Enroll::where('event_id', $id)->count());
        return view('admin.event.participant', [
            'enrolllist' => $enrolllist
        ]);
    }
    public function participant()
    {
        $enrolllist = Enroll::orderby('created_at', 'desc')->paginate(20);
        return view('admin.event.participant', [
            'enrolllist' => $enrolllist,
        ]);
    }
    public function exam($id)
    {
        $event = Event::find($id);
        $question = Question::where('event_id', $id)->get();
        $totalquestion = Question::where('event_id', $id)->count();
        // dd($totalquestion);

        return view('frontend.pages.exam', [
            'event' => $event,
            'question' => $question,
            'totalquestion' => $totalquestion,
        ]);
    }
    public function result($id)
    {
        $event = Event::find($id);
        $resultlist = Result::orderby('total_mark', 'desc')->where('event_id', $id)->paginate(20);
        session()->put('enrollcount', Enroll::where('event_id', $id)->count());
        return view('frontend.pages.result', [
            'event' => $event,
            'resultlist' => $resultlist,
        ]);
    }

    public function pointhistory()
    {
        $history = History::where('user_id', Auth::user()->id)->get();
        return json_encode($history);
    }
    public function examresult(Request $request, $id)
    {
        dd($request->all());
        $my_id = Auth::user()->id;
        $user = User::find($my_id);
        $event = Event::find($id);
        $right = 0;
        $wrong = 0;

        foreach ($request->input('ans') as $ans) {
            // dd($ans);

            $input = Str::substr($ans, 1, 1);
            $correct = Str::substr($ans, 2, 1);
            // dd($input . ', = ' . $correct);
            if ($input == $correct) {
                $right++;
                // dd($right . ', if, ' . $wrong);
            } else {
                $wrong++;
                // dd($right . ', else, ' . $wrong);
            }
        }
        // dd($right . ', ' . $wrong);

        $negative = $wrong / 4;
        $mark = $right - $negative;
        $totalquestion = $request->input('totalquestion');
        $totalpoint = $user->profile->points + $mark;
        // dd('totao q ' . $totalquestion . ', mark ' . $mark . ', right ' . $right . ', wrong ' . $wrong . ', negative ' . $negative . ', totalpoint ' . $totalpoint);
        $this->pointupdate($my_id, $totalpoint);
        $this->history($my_id, 'You get "' . $mark . '" points from "' . $event->name . '" Event Exam.! Where total question "' . $totalquestion . '", right answered "' . $right . '", wrong answered "' . $wrong . '", nagetive mark "' . $negative . '", total mark "' . $mark . '"', 'exam');
        $this->notification($my_id, '"' . $user->name . '" get ' . $mark . ' from Event "' . $event->name . '".!', now()->toDateString(), now()->toTimeString(), 'exam', '1');
        // dd($id, $my_id, $totalquestion, $right, $wrong, $mark, $negative);
        $this->result_make($id, $my_id, $totalquestion, $right, $wrong, $mark, $negative);

        // return redirect('/result'/$id);
        return redirect()->to('result/' . $id);
    }

}
