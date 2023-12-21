<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ModelTestController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\SAdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('landing.index');
    return view('front.index');
});
Route::get('/aboutus', [HomeController::class, 'front_about'])->name('front.about');
Route::get('/contactus', [HomeController::class, 'front_contact'])->name('front.contact');
Route::get('/our-course', [HomeController::class, 'front_course'])->name('front.course');
Route::get('/our-blog', [HomeController::class, 'front_blog'])->name('front.blog');

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {

    Route::get('/dashboard', function () {
        if (Auth::user()->user_type == 1) {
            return redirect('superadmin');
        } elseif (Auth::user()->user_type == 2) {
            return redirect('home');
        } else {
            return redirect('admin');
        }
    })->name('dashboard');

    // Superadmin & admin start
    Route::get('/clear-cash', [HomeController::class, 'clear_cash']);
    Route::get('/home', [HomeController::class, 'dashboard'])->name('home');
    Route::get('/admin', [HomeController::class, 'admin'])->name('admin');
    Route::get('/superadmin', [HomeController::class, 'superadmin'])->name('superadmin');
    Route::get('/question/create/{id}', [HomeController::class, 'create_question']);

    Route::get('/adminlist', [SAdminController::class, 'adminlist'])->name('adminlist');
    Route::get('/alluser', [SAdminController::class, 'alluser']);
    Route::get('/adminlist/{id}', [SAdminController::class, 'adminview']);
    Route::delete('/adminlist/{id}', [SAdminController::class, 'admindelete']);
    Route::post('/createadmin', [SAdminController::class, 'createadmin'])->name('createadmin');
    Route::get('/slider', [SAdminController::class, 'slider']);
    Route::post('/slider', [SAdminController::class, 'slider_store']);
    Route::get('/event/result', [SAdminController::class, 'event_result'])->name('event.result');
    Route::get('/admin/result/{id}', [SAdminController::class, 'admin_result'])->name('admin.result');
    Route::get('/modeltest/result', [SAdminController::class, 'modeltest_result'])->name('modeltest.result');

    // Bolg Panel Super Admin
    Route::get('/blog/create', [SAdminController::class, 'blog_create'])->name('blog.create');
    Route::post('/blog/store', [SAdminController::class, 'blog_store'])->name('blog.store');
    Route::get('/blog/show/{id}', [SAdminController::class, 'blog_show'])->name('blog.show');
    Route::get('/blog/edit/{id}', [SAdminController::class, 'blog_edit'])->name('blog.edit');
    Route::put('/blog/update/{id}', [SAdminController::class, 'blog_update'])->name('blog.update');
    Route::delete('/blog/delete/{id}', [SAdminController::class, 'blog_delete'])->name('blog.delete');

    // Bolg Panel Super Admin
    Route::get('/page/create', [SAdminController::class, 'page_create'])->name('page.create');
    Route::post('/page/store', [SAdminController::class, 'page_store'])->name('page.store');
    Route::get('/page/show/{id}', [SAdminController::class, 'page_show'])->name('page.show');
    Route::get('/page/edit/{id}', [SAdminController::class, 'page_edit'])->name('page.edit');
    Route::put('/page/update/{id}', [SAdminController::class, 'page_update'])->name('page.update');
    Route::delete('/page/delete/{id}', [SAdminController::class, 'page_delete'])->name('page.delete');

    // Route::get(md5('/event'), [EventController::class, 'event_index'])->name('event.index');
    Route::get('/all-event', [EventController::class, 'event_index'])->name('event.index');
    Route::get('/create-event', [EventController::class, 'event_create'])->name('event.create');
    Route::post('/event/store', [EventController::class, 'event_store'])->name('event.store');
    Route::get('/event/show/{id}', [EventController::class, 'event_show'])->name('event.show');
    Route::get('/event/edit/{id}', [EventController::class, 'event_edit'])->name('event.edit');
    Route::put('/event/update/{id}', [EventController::class, 'event_update'])->name('event.update');
    Route::delete('/event/delete/{id}', [EventController::class, 'event_delete'])->name('event.delete');

    Route::get('/syllabus', [EventController::class, 'syllabus_index'])->name('syllabus.index');
    Route::post('/syllabus', [EventController::class, 'syllabus_store'])->name('syllabus.store');
    Route::get('/syllabus/{id}', [EventController::class, 'syllabus_show'])->name('syllabus.show');
    Route::get('/syllabus/{id}/edit', [EventController::class, 'syllabus_edit'])->name('syllabus.edit');
    Route::put('/syllabus/{id}', [EventController::class, 'syllabus_update'])->name('syllabus.update');
    Route::delete('/syllabus/{id}', [EventController::class, 'syllabus_delete'])->name('syllabus.delete');

    Route::get('/question', [EventController::class, 'question_index'])->name('question.index');
    Route::post('/question', [EventController::class, 'question_store'])->name('question.store');
    Route::get('/question/{id}', [EventController::class, 'question_show'])->name('question.show');
    Route::get('/question/{id}/edit', [EventController::class, 'question_edit'])->name('question.edit');
    Route::put('/question/{id}', [EventController::class, 'question_update'])->name('question.update');
    Route::delete('/question/{id}', [EventController::class, 'question_delete'])->name('question.delete');

    Route::get('/e-syllabus/{id}', [EventController::class, 'e_syllabus']);
    Route::get('/e-question/{id}', [EventController::class, 'e_question']);
    Route::get('/participant', [EventController::class, 'participant']);
    Route::get('/admin/event/participant/{id}', [EventController::class, 'admin_participant'])->name('admin.participant');

    // user
    Route::get('/events', [EventController::class, 'events']);
    Route::get('/myevents', [EventController::class, 'myevents']);
    Route::get('/enroll/{id}', [EventController::class, 'enroll']);
    Route::get('/eventsyllabus/{id}', [EventController::class, 'eventsyllabus']);
    Route::get('/eventparticipant/{id}', [EventController::class, 'eventparticipant']);
    Route::get('/exam/{id}', [EventController::class, 'exam']);
    Route::get('/result/{id}', [EventController::class, 'result'])->name('user.result');
    Route::post('/examresult/{id}', [EventController::class, 'examresult']);
    Route::get('/pointhistory', [EventController::class, 'pointhistory']);

    // admin
    // country
    Route::get('/countries', [PageController::class, 'country_index'])->name('country.index');
    Route::post('/country', [PageController::class, 'country_store'])->name('country.store');
    Route::put('/country/active/{id}', [PageController::class, 'country_active'])->name('country.active');
    Route::put('/country/inactive/{id}', [PageController::class, 'country_inactive'])->name('country.inactive');
    Route::get('/country/edit/{id}', [PageController::class, 'country_edit'])->name('country.edit');
    Route::put('/country/update/{id}', [PageController::class, 'country_update'])->name('country.update');
    Route::delete('/country/delete/{id}', [PageController::class, 'country_delete'])->name('country.delete');

    Route::get('/divisions/{id}', [PageController::class, 'division_index'])->name('division.index');
    Route::get('/division/create/{id}', [PageController::class, 'division_create'])->name('division.create');
    Route::post('/division', [PageController::class, 'division_store'])->name('division.store');
    Route::get('/division/edit/{id}', [PageController::class, 'division_edit'])->name('division.edit');
    Route::put('/division/update/{id}', [PageController::class, 'division_update'])->name('division.update');
    Route::delete('/division/delete/{id}', [PageController::class, 'division_delete'])->name('division.delete');

    Route::get('/cities/{id}', [PageController::class, 'city_index'])->name('city.index');
    Route::get('/city/create/{id}', [PageController::class, 'city_create'])->name('city.create');
    Route::post('/city/store', [PageController::class, 'city_store'])->name('city.store');
    Route::get('/city/edit/{id}', [PageController::class, 'city_edit'])->name('city.edit');
    Route::put('/city/update/{id}', [PageController::class, 'city_update'])->name('city.update');
    Route::delete('/city/delete/{id}', [PageController::class, 'city_delete'])->name('city.delete');

    Route::get('/upazilas/{id}', [PageController::class, 'upazila_index'])->name('upazila.index');
    Route::get('/upazila/create/{id}', [PageController::class, 'upazila_create'])->name('upazila.create');
    Route::post('/upazila/store', [PageController::class, 'upazila_store'])->name('upazila.store');
    Route::get('/upazila/edit/{id}', [PageController::class, 'upazila_edit'])->name('upazila.edit');
    Route::put('/upazila/update/{id}', [PageController::class, 'upazila_update'])->name('upazila.update');
    Route::delete('/upazila/delete/{id}', [PageController::class, 'upazila_delete'])->name('upazila.delete');

    Route::get('/allclass', [PageController::class, 'allclass']);
    Route::post('/class', [PageController::class, 'class']);
    Route::post('/class', [PageController::class, 'class'])->name('');

    Route::get('/all-modeltest', [ModelTestController::class, 'modeltest_index'])->name('modeltest.index');
    Route::get('/modeltest/create', [ModelTestController::class, 'modeltest_create'])->name('modeltest.create');
    Route::get('/model/test/{id}', [ModelTestController::class, 'modeltest_show'])->name('modeltest.show');
    Route::get('/model/test/{id}/edit', [ModelTestController::class, 'modeltest_edit'])->name('modeltest.edit');
    Route::delete('/model/test/{id}', [ModelTestController::class, 'modeltest_delete'])->name('modeltest.delete');
    Route::post('/modeltest/store', [ModelTestController::class, 'modeltest_store'])->name('modeltest.store');
    Route::put('/modeltest/update/{id}', [ModelTestController::class, 'modeltest_update'])->name('modeltest.update');

    Route::get('/modeltest/syllabus/create/{id}', [ModelTestController::class, 'm_syllabus'])->name('msyllabus.create');
    Route::get('/modeltest/syllabus', [ModelTestController::class, 'msyllabus_index'])->name('msyllabus.index');
    Route::post('/modeltest/syllabus/store', [ModelTestController::class, 'msyllabus_store'])->name('msyllabus.store');
    Route::delete('/modeltest/syllabus/delete/{id}', [ModelTestController::class, 'msyllabus_delete'])->name('msyllabus.delete');

    Route::get('/modeltest/question/create/{id}', [ModelTestController::class, 'mquestion_create'])->name('mquestion.create');
    Route::get('/modeltest/question', [ModelTestController::class, 'mquestion_index'])->name('mquestion.index');
    Route::post('/modeltest/question/store', [ModelTestController::class, 'mquestion_store'])->name('mquestion.store');
    Route::delete('/modeltest/question/delete/{id}', [ModelTestController::class, 'mquestion_delete'])->name('mquestion.delete');

    // user
    Route::get('/modeltest', [ModelTestController::class, 'modeltest']);
    Route::get('/my-modeltest', [ModelTestController::class, 'my_modeltest']);
    Route::get('/model/test/syllabus/{id}', [ModelTestController::class, 'umsyllabus_show'])->name('umsyllabus.show');
    Route::get('/modeltest/exam/{id}', [ModelTestController::class, 'mtest_exam'])->name('mtest.exam');
    Route::post('/modeltest/examresult/{id}', [ModelTestController::class, 'mtest_examresult'])->name('mtest.result');
    Route::get('/modeltest/result/{id}', [ModelTestController::class, 'mtest_result'])->name('mtestresult.show');

    Route::get('/notification', [HomeController::class, 'all_notification']);
    Route::put('/notification/{id}', [HomeController::class, 'read_notification']);
    Route::get('/supportlist', [HomeController::class, 'supportlist']);
    Route::get('/support', [HomeController::class, 'support']);
    Route::get('/supportcreate', [HomeController::class, 'support_create']);
    Route::post('/support', [HomeController::class, 'support_store']);
    Route::get('/supportreplay/{id}', [HomeController::class, 'support_replay_create']);
    Route::post('/supportreplay/{id}', [HomeController::class, 'support_replay_store']);
    // Superadmin & admin end

    // user profile data start
    Route::get('/viewprofile/{id}', [ProfileController::class, 'view_profile']);

    Route::get('/profile', [ProfileController::class, 'profile']); //

    Route::post('/profile', [ProfileController::class, 'store_profile']);
    // user profile data end

    Route::get('/find-friend', [ProfileController::class, 'find_friend']);
    Route::get('/my-friend', [ProfileController::class, 'friends']);
    Route::get('/add-friend/{id}', [ProfileController::class, 'add_friend']);
    Route::get('/unfriend/{id}', [ProfileController::class, 'unfriend']);
    Route::get('/cancelrequest/{id}', [ProfileController::class, 'cancelrequest']);
    Route::get('/confirmrequest/{id}', [ProfileController::class, 'confirmrequest']);
    Route::get('/allrequest', [ProfileController::class, 'allrequest']);
    Route::get('/allsend', [ProfileController::class, 'allsend']);

    Route::post('/makemessage/{id}', [ProfileController::class, 'makemessage']);
    Route::get('/chat', [ProfileController::class, 'chat']);
    Route::get('/chatmessage/{id}', [ProfileController::class, 'chatmessage']);
    Route::POST('/chatmessage/{id}', [ProfileController::class, 'chatmessage_store']);
    Route::POST('/sendpoints/{id}', [ProfileController::class, 'sendpoints']);
    Route::POST('/sendcard/{id}', [ProfileController::class, 'sendcard']);

});

Route::get('/about-us', [HomeController::class, 'about'])->name('about.show');
Route::get('/privacy-policy', [HomeController::class, 'policy']);
Route::get('/terms-condition', [HomeController::class, 'terms']);
Route::get('/contact-us', [HomeController::class, 'contact']);

Route::get('/all-blogs', [SAdminController::class, 'blog_index'])->name('blog.index');
Route::get('/blogs/{id}', [SAdminController::class, 'ublog_show'])->name('ublog.show');
