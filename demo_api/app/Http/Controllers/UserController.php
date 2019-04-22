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

class UserController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
    }

    /**
     * Return the list of users.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse {
        return $this->successResponse(User::all(), Response::HTTP_OK);
    }

    /**
     * User login.
     * @param $request Request
     * @return JsonResponse
     * @throws
     */
    public function login(Request $request) : JsonResponse {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6|'
        ]);

        $user = User::where('email', $request->input('email'))->firstOrFail();
        if (Hash::check($request->get('password'), $user->password)) {
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

    /**
     * User logout.
     * @param $request Request
     * @return JsonResponse
     * @throws
     */
    public function logout(Request $request) : JsonResponse {
        $this->validate($request, [
            'user_id' => 'required',
        ]);

        $token = DB::table('oauth_access_tokens')->where('user_id', '=', $request->input('user_id'))->get();
        $req = Request::create('/oauth/personal-access-tokens/' . $token->id, 'DELETE');
        $res = app()->handle($req);
        $data = json_decode($res->getContent());

        return $this->successResponse($data);
    }

    /**
     * Create one new user.
     * @param $request Request
     * @return JsonResponse
     * @throws
     */
    public function store(Request $request) : JsonResponse {
        $user = $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|'
        ]);

        $user['password'] = Hash::make($request->get('password'));
        $user = User::create($user);
        $this->createClient($user);
        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    /**
     * Show one new user.
     *
     * @param $id
     * @return JsonResponse
     * @throws
     */
    public function show($id) : JsonResponse {
        return $this->successResponse(User::findOrFail($id));
    }

    /**
     * Update one new user.
     * @param $request Request
     * @param $id string
     * @return Response|JsonResponse
     * @throws
     */
    public function update(Request $request, $id) {
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

        $user = User::findOrFail($id);
        $user->fill($data);
        $user->save();

        return $this->successResponse($user);
    }

    /**
     * Delete one new user.
     * @param string $id
     * @return JsonResponse
     * @throws
     */
    public function destroy($id) : JsonResponse {
        $user = User::findOrFail($id);
        $user->delete();
        return $this->successResponse($user);
    }

    /**
     * Request user password reset.
     *
     * @param  $request Request
     * @return JsonResponse
     * @throws
     */
    public function resetPassword(Request $request) {
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

    /**
     * Create token client.
     *
     * @param  $user User
     * @return OauthClient
     * @throws
     */
    public function createClient(User $user) {
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
}
