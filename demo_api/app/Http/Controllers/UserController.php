<?php


namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use Illuminate\Support\Facades\Hash;
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
    public function __construct() {
        //
        DB::enableQueryLog();

    }

    /**
     * Return the list of users.
     *
     * @return JsonResponse
     */
    public function index() {
        return $this->successResponse(User::all(), Response::HTTP_OK);
    }

    /**
     * Create one new user.
     * @param $request Request
     * @return JsonResponse
     * @throws
     */
    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|'
        ]);

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);

        return $this->successResponse($user, Response::HTTP_CREATED);

    }

    /**
     * Show one new user.
     *
     * @return JsonResponse
     * @throws
     */
    public function show($id) {
        return $this->successResponse(User::findOrFail($id));
    }

    /**
     * Update one new user.
     * @param $request Request
     * @param $id string
     * @return JsonResponse
     * @throws
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'max:255'
        ]);

        $user = User::findOrFail($id);
        $user->fill($request->all());

        if ($user->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();

        return $this->successResponse($user);

    }

    /**
     * Delete one new user.
     * @param string $id
     * @return JsonResponse
     * @throws
     */
    public function destroy($id) {
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
    public function resetPasswordRequest(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users'
        ]);

        $user = User::where('email', $request->input('email'))->firstOrFail();
        $user->reset_password_token = Str::random(32);
        $user->save();

        return $this->successResponse($user, Response::HTTP_OK);
    }

    /**
     * Reset user password.
     *
     * @param  $request Request
     * @return JsonResponse
     * @throws
     */
    public function resetPassword(Request $request) {
        $user = User::where('reset_password_token', $request->get('reset_password_token'))->firstOrFail();
        $this->validate($request, [
            'password' => 'required_with:password_confirm|same:password_confirm|min:'. env('PASSWORD_MIN_CHARACTERS'),
            'password_confirm' => 'min:6'
        ]);

        if (Hash::check($request->get('password'), $user->password)) {
            return $this->errorResponse('Cannot use the old password.', Response::HTTP_UNAUTHORIZED);
        } else {
            $user->fill([
                'password' => Hash::make($request->get('password')),
                'reset_password_token' => null
            ])->save();

            return $this->successResponse($user, Response::HTTP_OK);
        }
    }

    /**
     * Activate User.
     *
     * @param  $request Request
     * @return JsonResponse
     * @throws
     */
    public function verifyEmail(Request $request)
    {
        return $this->successResponse([], Response::HTTP_OK);
    }
}
