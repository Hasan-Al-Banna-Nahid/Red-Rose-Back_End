<?php

namespace App\Http\Controllers\Api\v2\Utility;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\Profile;
use App\Models\SendRequest;
use App\Models\SocialLink;
use App\Models\User;
use App\Traits\AppResponse;
use App\Traits\HttpAppResponse;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiProfileController extends Controller
{
    use HttpAppResponse;
    // View My Profile start
    public function my_profile()
    {
        $user = User::with('profile', 'sociallink')->find(Auth::user()->id);

        // $user = User::select(['id', 'user_type', 'redrose_id', 'name', 'email'])
        //     ->with([
        //         'profile' => function ($query) {
        //             $query->select(['id', 'user_id', 'date', 'once', 'points', 'bio', 'designation', 'birthday', 'gender', 'about', 'phone', 'class_id', 'institute', 'address', 'upazila', 'city', 'division', 'country', 'company_name']);
        //         },
        //         'sociallink' => function ($query) {
        //             $query->select(['id', 'user_id', 'whatsapp', 'facebook', 'twitter', 'instagram', 'linkedin', 'pinterest', 'tiktok', 'wechat']);
        //         },
        //     ])
        //     ->find(Auth::user()->id);

        $interval = (new DateTime($user->profile->date))->diff(new DateTime());
        $final_days = $interval->format('%a'); //and then print do whatever you like with $final_days
        $redrose_id = 'off';
        if ($final_days > 365 || $user->profile->once == 'no') {
            $redrose_id = 'on';
        }
        return $this->apiresponse(
            [
                'redrose_id_edit' => $redrose_id,
                'user' => $user,
            ],
            true,
            'Profile data read succesfull.',
            200,
        );
    }
    // Update Profile start
    public function update_info(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
        ];
        $roules = [
            'name' => 'required',
        ];
        if ($this->request_validator($data, $roules)) {
            return $this->apiresponse('', false, 'Make sure you need to fill all the required parametter.', 200);
        } else {
            $user = Auth::user();
            if ($request->has('redrose_id')) {
                $interval = (new DateTime($user->profile->date))->diff(new DateTime());
                $final_days = $interval->format('%a'); //and then print do whatever you like with $final_days
                if ($final_days > 365 || $user->profile->once == 'no') {
                    $is_redrose_id = User::where('redrose_id', $request->redrose_id)->first();
                    if ($is_redrose_id) {
                        return $this->apiresponse('', false, 'Redrose Id arready taken, please try another', 402);
                    } else {
                        $image = '';
                        if ($request->profile_photo) {
                            $image = url('/') . '/storage/profiles/' . now()->toDateString() . '-' . time() . '-' . str_replace(' ', '', Auth::user()->name) . '.' . $request->profile_photo->extension();
                            $request->profile_photo->move(public_path('storage/profiles/'), $image);
                        } else {
                            $image = Auth::user()->profile_photo_path;
                        }
                        User::where('id', $user->id)->update([
                            'name' => $request['name'],
                            'redrose_id' => $request['redrose_id'],
                            'profile_photo_path' => $image,
                        ]);
                        $redrose_id = [
                            'date' => now()->toDateString(),
                            'once' => 'yes',
                        ];
                        Profile::where('user_id', $user->id)->update($redrose_id);
                        return $this->apiresponse(User::with('profile', 'sociallink')->find($user->id), true, 'Update Information with redrose id', AppResponse::HTTP_OK);
                    }
                } else {
                    $image = '';
                    if ($request->profile_photo) {
                        $image = url('/') . '/storage/profiles/' . now()->toDateString() . '-' . time() . '-' . str_replace(' ', '', Auth::user()->name) . '.' . $request->profile_photo->extension();
                        $request->profile_photo->move(public_path('storage/profiles/'), $image);
                    } else {
                        $image = Auth::user()->profile_photo_path;
                    }
                    User::where('id', $user->id)->update([
                        'name' => $request['name'],
                        'profile_photo_path' => $image,
                    ]);
                    return $this->apiresponse(User::with('profile', 'sociallink')->find($user->id), true, 'Update Information without redrose id', AppResponse::HTTP_OK);
                }
            } else {
                $image = '';
                if ($request->profile_photo) {
                    $image = url('/') . '/storage/profiles/' . now()->toDateString() . '-' . time() . '-' . str_replace(' ', '', Auth::user()->name) . '.' . $request->profile_photo->extension();
                    $request->profile_photo->move(public_path('storage/profiles/'), $image);
                } else {
                    $image = Auth::user()->profile_photo_path;
                }
                User::where('id', $user->id)->update([
                    'name' => $request['name'],
                    'profile_photo_path' => $image,
                ]);
                return $this->apiresponse(User::with('profile', 'sociallink')->find($user->id), true, 'Update Information without redrose id', AppResponse::HTTP_OK);
            }
        }
    }
    public function update_profile(Request $request)
    {
        $data = [
            'country_id' => $request->input('country_id'),
            'division_id' => $request->input('division_id'),
            'city_id' => $request->input('city_id'),
            'upazila_id' => $request->input('upazila_id'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'class_id' => $request->input('class_id'),
            'institute' => $request->input('institute'),
        ];
        $roules = [
            'country_id' => ['required'],
            'division_id' => 'required',
            'city_id' => 'required',
            'upazila_id' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'class_id' => 'required',
            'institute' => 'required',
        ];
        if ($this->request_validator($data, $roules)) {
            return $this->apiresponse('', false, 'Make sure you need to fill all the required parametter.', 200);
        } else {
            $id = Auth::user()->id;
            Profile::where('user_id', $id)->update([
                'bio' => $request['bio'],
                'designation' => $request['designation'],
                'birthday' => $request['birthday'],
                'gender' => $request['gender'],
                'about' => $request['about'],
                'phone' => $request['phone'],
                'class_id' => $request['class_id'],
                'institute' => $request['institute'],
                'address' => $request['address'],
                'upazila_id' => $request['upazila_id'],
                'city_id' => $request['city_id'],
                'division_id' => $request['division_id'],
                'country_id' => $request['country_id'],
                'company_name' => $request['company_name'],
            ]);
            return $this->apiresponse(User::with('profile', 'sociallink')->find($id), true, 'User Profile update successfull', AppResponse::HTTP_OK);
        }
    }
    public function update_social_profile(Request $request)
    {
        $id = Auth::user()->id;
        SocialLink::where('user_id', $id)->update([
            'whatsapp' => $request['whatsapp'],
            'facebook' => $request['facebook'],
            'twitter' => $request['twitter'],
            'instagram' => $request['instagram'],
            'linkedin' => $request['linkedin'],
            'pinterest' => $request['pinterest'],
            'tiktok' => $request['tiktok'],
            'wechat' => $request['wechat'],
        ]);
        return $this->apiresponse(User::with('profile', 'sociallink')->find($id), true, 'Social info Update successfull...!', AppResponse::HTTP_OK);
    }
    public function old_update_profile(Request $request)
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
    // View Public Profile start
    public function public_profile($id)
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
}
