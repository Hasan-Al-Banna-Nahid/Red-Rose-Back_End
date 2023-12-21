<?php
namespace App\Http\Controllers;
use App\Models\AllClass;
use App\Models\ModelQuestion;
use App\Models\ModelSyllabus;
use App\Models\ModelTestAll;
use App\Models\ModelTestResult;
use App\Models\User;
use App\Traits\HttpWebResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class ModelTestController extends Controller
{
    use HttpWebResponse;
    public function modeltest()
    {
        $user = Auth::user();
        $modeltestlist = ModelTestAll::where('class_id', $user->profile->class)->get();
        if ($modeltestlist) {
            return view('frontend.pages.modeltest', [
                'modeltestlist' => $modeltestlist,
            ]);
        } else {
            return back()->with('warning', 'Currently you do not select your class, please select your class and try again.!');
        }
    }
    public function my_modeltest(Request $request)
    {
        $id = $request['id'];
        $user = Auth::user();
        $modeltestresult = ModelTestResult::where('modeltest_id', $id)->where('user_id', (int)$user->id)->get()->first();
        if ($modeltestresult) {
            $modeltests = ModelTestAll::where('class_id', $user->profile->class)->where('type', '=', 'on')->get();
            if ($user->profile->class != '') {

            } else {

            }
        } else {

        }
    }
    public function umsyllabus_show($id)
    {
        $modeltestSyllabus = ModelSyllabus::where('modeltest_id', $id)
            ->get()
            ->first();
        // dd($modeltestlist);
        return view('frontend.pages.msyllabus', [
            'modeltestSyllabus' => $modeltestSyllabus,
        ]);
    }
    public function modeltest_show($id)
    {
        $modeltest = ModelTestAll::find($id);
        $modeltestlist = ModelTestAll::paginate(20);
        return view('admin.model_test.sindex', [
            'modeltestlist' => $modeltestlist,
            'modeltest' => $modeltest,
        ]);
    }
    public function modeltest_edit($id)
    {
        $modeltest = ModelTestAll::find($id);
        $classlist = AllClass::get();
        $modeltestlist = ModelTestAll::paginate(20);
        return view('admin.model_test.eindex', [
            'modeltestlist' => $modeltestlist,
            'modeltest' => $modeltest,
            'classlist' => $classlist,
        ]);
    }
    public function modeltest_delete($id)
    {
        $modeltest = ModelTestAll::find($id);
        $modeltest->delete();
        // session()->put('eventCount', Event::count());
        $this->notification(Auth::user()->id, '"' . Auth::user()->name . '" delete Model test "' . $modeltest->name . '" successfully.!', now()->toDateString(), now()->toTimeString(), 'modeltest', '1');
        return redirect('/modeltestcreate')->with('warning', 'Model Test deleted successful.!');
    }
    public function modeltest_index()
    {
        $classlist = AllClass::get();
        $modeltestlist = ModelTestAll::paginate(20);
        return view('admin.model_test.index', [
            'modeltestlist' => $modeltestlist,
            'classlist' => $classlist,
        ]);
    }
    public function modeltest_create()
    {
        $classlist = AllClass::get();
        $modeltestlist = ModelTestAll::paginate(20);
        return view('admin.model_test.index', [
            'modeltestlist' => $modeltestlist,
            'classlist' => $classlist,
        ]);
    }
    public function modeltest_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'class_id' => 'required',
            'subject' => 'required',
        ]);
        ModelTestAll::create([
            'name' => $request['name'],
            'class_id' => $request['class_id'],
            'subject' => $request['subject'],
            'type' => 'off',
        ]);
        $this->notification(Auth::user()->id, '"' . Auth::user()->name . '" create Model test "' . $request['name'] . '" successfully.!', now()->toDateString(), now()->toTimeString(), 'modeltest', '1');
        return back()->with('success', 'Model test created successfull.!');
    }
    public function modeltest_update(Request $request, $id)
    {
        ModelTestAll::where('id', $id)->update([
            'name' => $request['name'],
            'class_id' => $request['class_id'],
            'subject' => $request['subject'],
            'type' => $request['type'],
        ]);
        $this->notification(Auth::user()->id, '"' . Auth::user()->name . '" update Model test "' . $request['name'] . '" successfully.!', now()->toDateString(), now()->toTimeString(), 'modeltest', '1');
        return back()->with('success', 'Model test update successfull.!');
    }
    public function msyllabus_index()
    {
        $modeltestlist = ModelTestAll::get();
        $modelsyllabuslist = ModelSyllabus::paginate(20);
        return view('admin.model_test.syllabus', [
            'modelsyllabuslist' => $modelsyllabuslist,
            'modeltestlist' => $modeltestlist,
        ]);
    }
    public function m_syllabus($id)
    {
        $modeltest = ModelTestAll::find($id);
        $modeltestlist = ModelTestAll::paginate(20);
        return view('admin.model_test.msyllabus', [
            'modeltestlist' => $modeltestlist,
            'modeltest' => $modeltest,
        ]);
    }
    public function msyllabus_store(Request $request)
    {
        $request->validate([
            'modeltest_id' => 'required',
            'name' => 'required',
            'description' => 'required',
        ]);
        ModelSyllabus::create([
            'name' => $request->input('name'),
            'modeltest_id' => $request->input('modeltest_id'),
            'description' => $request->input('description'),
        ]);
        $this->notification(Auth::user()->id, '"' . Auth::user()->name . '" create Modeltest Syllabus "' . $request->input('name') . '" successfully.!', now()->toDateString(), now()->toTimeString(), 'modelsyllabus', '1');
        return back()->with('success', 'Model test syllabus created successfull.!');
    }
    public function msyllabus_delete($id)
    {
        $modeltestSyllabus = ModelSyllabus::find($id);
        $modeltestSyllabus->delete();
        $this->notification(Auth::user()->id, '"' . Auth::user()->name . '" delete Modeltest Syllabus "' . $modeltestSyllabus->name . '" successfully.!', now()->toDateString(), now()->toTimeString(), 'modelsyllabus', '1');
        return back()->with('success', 'Model test syllabus created successfull.!');
    }
    public function mquestion_create($id)
    {
        $modeltest = ModelTestAll::find($id);
        $modelquestionlist = ModelQuestion::paginate(20);
        return view('admin.model_test.mquestion', [
            'modelquestionlist' => $modelquestionlist,
            'modeltest' => $modeltest,
        ]);
    }
    public function mquestion_index()
    {
        $modeltestlist = ModelTestAll::get();
        $modelquestionlist = ModelQuestion::paginate(20);
        return view('admin.model_test.question', [
            'modelquestionlist' => $modelquestionlist,
            'modeltestlist' => $modeltestlist,
        ]);
    }
    public function mquestion_store(Request $request)
    {
        $request->validate([
            'modeltest_id' => 'required',
            'name' => 'required',
            'option1' => 'required',
            'option2' => 'required',
            'option3' => 'required',
            'option4' => 'required',
            'option5' => 'required',
        ]);
        ModelQuestion::create([
            'modeltest_id' => $request['modeltest_id'],
            'name' => $request['name'],
            'option1' => $request['option1'],
            'option2' => $request['option2'],
            'option3' => $request['option3'],
            'option4' => $request['option4'],
            'option5' => $request['option5'],
        ]);
        $this->notification(Auth::user()->id, '"' . $request['name'] . '" Model Question Created successful.!', now()->toDateString(), now()->toTimeString(), 'question', '1');
        return back()->with('success', $request['name'] . ' - added new question.!');
    }
    public function mquestion_delete($id)
    {
        $modeltestQuestion = ModelQuestion::find($id);
        $modeltestQuestion->delete();
        $this->notification(Auth::user()->id, '"' . Auth::user()->name . '" delete Modeltest Question "' . $modeltestQuestion->name . '" successfully.!', now()->toDateString(), now()->toTimeString(), 'modelquestion', '1');
        return back()->with('success', 'Model test syllabus created successfull.!');
    }
    public function mtest_exam($id)
    {
        $modeltest = ModelTestAll::find($id);
        $question = ModelQuestion::where('modeltest_id', $id)->get();
        $totalquestion = ModelQuestion::where('modeltest_id', $id)->count();
        // dd($totalquestion);
        return view('frontend.pages.mexam', [
            'modeltest' => $modeltest,
            'question' => $question,
            'totalquestion' => $totalquestion,
        ]);
    }
    public function mtest_examresult(Request $request, $id)
    {
        // dd($request->all());
        $user = User::find(Auth::user()->id);
        $modeltest = ModelTestAll::find($id);
        $right = 0;
        $wrong = 0;
        foreach ($request->input('ans') as $ans) {
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
        // dd($id, $my_id, $totalquestion, $right, $wrong, $mark, $negative);
        // return redirect('/result'/$id);
        return redirect(route('mtestresult.show', $id));
    }
    public function model_result($id)
    {
        $modeltestresult = ModelTestResult::where('modeltest_id', $id)
            ->where('user_id', Auth::user()->id)
            ->get();

    }
}
