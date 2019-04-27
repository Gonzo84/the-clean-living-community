<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\Http\OauthClient;
use App\Mail\RequestResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Return the list of users.
     *
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        $name = $request->input('name');

        return $this->successResponse(User::WithData()
            ->where('name', 'like', '%' . $name . '%')
            ->paginate(20), Response::HTTP_OK);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Create one new user.
     * @param $request Request
     * @return JsonResponse
     * @throws
     */
    public function store(Request $request) : JsonResponse
    {
        $user = $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|',
            'type' => 'in:friend,mentor'
        ]);

        $user['password'] = Hash::make($user['password']);

        $user = User::create($user);
        $this->createClient($user);
        return $this->successResponse(['success' => true], Response::HTTP_CREATED);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * User login.
     * @param $request Request
     * @return JsonResponse
     * @throws
     */
    public function login(Request $request) : JsonResponse
    {
        $data = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6|'
        ]);

        $user = User::withData()->where('email', $data['email'])->firstOrFail();

        if (Hash::check($data['password'], $user->password)) {
            $client = OauthClient::where('user_id', $user->id)->first();
            if (!$client) {
                $client = $this->createClient($user);
            }

            $params = [
                'grant_type' => 'client_credentials',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'scope' => '*'
            ];

            $req = Request::create('/oauth/token', 'POST', $params);
            $res = app()->handle($req);
            $user->token = json_decode($res->getContent());

            return $this->successResponse($user);
        } else {
            return $this->errorResponse('Wrong password.', Response::HTTP_UNAUTHORIZED);
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * User logout.
     * @param $request Request
     * @return JsonResponse
     * @throws
     */
    public function logout(Request $request) : JsonResponse
    {
        $data = $this->validate($request, [
            'user_id' => 'required',
        ]);

        $token = DB::table('oauth_access_tokens')->where('user_id', '=', $data['user_id'])->get();
        $req = Request::create('/oauth/personal-access-tokens/' . $token->id, 'DELETE');
        $res = app()->handle($req);

        return $this->successResponse(json_decode($res->getContent()));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Show one new user.
     *
     * @param $id
     * @return JsonResponse
     * @throws
     */
    public function show($id) : JsonResponse
    {
        $user = User::WithData()->where('id', $id)->first();

        return $this->successResponse($user);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Set user data.
     * @param $request Request
     * @param $id string
     * @return Response|JsonResponse
     * @throws
     */
    public function data(Request $request, $id) : JsonResponse
    {
        $data = $this->validate($request, [
            'age' => 'integer',
            'married' => 'boolean',
            'children' => 'boolean',
            'pet' => 'boolean',
            'education' => 'string|max:255',
            'religion' => 'string|max:255',
            'gender' => 'string|max:255',
            'sex_orientation' => 'string|max:255',
            'last_relapse' => 'integer',
            'smoker' => 'boolean',
            'support_groups' => 'boolean',
            'city' => 'string|max:255',
            'zip_code' => 'integer',
            'state' => 'string|max:255',
        ]);

        $user = DB::table('users_data')->where('user_id', $id)->get();

        if ($user->first()) {
            DB::table('users_data')
                ->where("user_id", $id)
                ->update($data);
        } else {
            $data['user_id'] = $id;
            DB::table('users_data')->insert($data);
        }

        return $this->successResponse($data);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Update user.
     * @param $request Request
     * @param $id string
     * @return Response|JsonResponse
     * @throws
     */
    public function update(Request $request, $id)
    {
        $userdata = array_filter($this->validate($request, [
            'name' => 'string',
            'email' => 'email|unique:users',
            'type' => 'string|in:friend,mentor',
            'status' => 'in:pending,regular,deleted'
        ]));

        $additional = array_filter($this->validate($request, [
            'age' => 'integer',
            'married' => 'boolean',
            'children' => 'boolean',
            'pet' => 'boolean',
            'education' => 'string|max:255',
            'religion' => 'string|max:255',
            'gender' => 'string|max:255',
            'sex_orientation' => 'string|max:255',
            'last_relapse' => 'integer',
            'smoker' => 'boolean',
            'support_groups' => 'boolean',
            'city' => 'string|max:255',
            'zip_code' => 'integer',
            'state' => 'string|max:255',
        ]));

        if (isset($userdata) && !empty($userdata)) {
            $user = User::findOrFail($id);
            $user->fill($userdata);
            $user->save();
        }

        if (isset($additional) && !empty($additional)) {
            DB::table('users_data')
                ->where("user_id", $id)
                ->update($additional);
        }

        return $this->successResponse(['success' => true]);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Delete one new user.
     * @param string $id
     * @return JsonResponse
     * @throws
     */
    public function destroy($id) : JsonResponse
    {
        User::findOrFail($id)->delete();

        return $this->successResponse(['success' => true]);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Request user password reset.
     *
     * @param  $request Request
     * @return JsonResponse
     * @throws
     */
    public function resetPassword(Request $request) : JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users'
        ]);

        $user = User::where('email', $request->input('email'))->firstOrFail();

        $user->reset_password_token = Str::random(16);
        $user->password = Hash::make($user->reset_password_token);
        $user->save();

        Mail::to($user->email)->send(new RequestResetPassword($user));

        return $this->successResponse($user, Response::HTTP_OK);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Reset user password.
     *
     * @param  $request Request
     * @return JsonResponse
     * @throws
     */
//    public function resetPassword(Request $request) {
//        $user = User::where('reset_password_token', $request->get('reset_password_token'))->firstOrFail();
//        $this->validate($request, [
//            'password' => 'required_with:password_confirm|same:password_confirm|min:'. env('PASSWORD_MIN_CHARACTERS'),
//            'password_confirm' => 'min:6'
//        ]);
//
//        if (Hash::check($request->get('password'), $user->password)) {
//            return $this->errorResponse('Cannot use the old password.', Response::HTTP_UNAUTHORIZED);
//        } else {
//            $user->fill([
//                'password' => Hash::make($request->get('password')),
//                'reset_password_token' => null
//            ])->save();
//
//            return $this->successResponse($user, Response::HTTP_OK);
//        }
//    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Create token client.
     *
     * @param  $user User
     * @return OauthClient
     * @throws
     */
    public function createClient(User $user)
    {
        return OauthClient::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'secret' => base64_encode(hash_hmac('sha256', $user->password . 'secret', true)),
            'password_client' => 1,
            'personal_access_client' => 0,
            'redirect' => '',
            'revoked' => 0
        ]);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
