<?php

namespace App\Http\Controllers\Api\v2\Auth;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\Notification;
use App\Models\Profile;
use App\Models\SocialLink;
use App\Models\User;
use App\Traits\AppResponse;
use App\Traits\HttpAppResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Str;

class AuthController extends Controller
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
}
