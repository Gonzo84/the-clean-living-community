<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;

class LocationController extends Controller
{
    use ApiResponser;

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
     * Get User location.
     * @param $id User
     * @return JsonResponse
     * @throws ExceptionHandler
     */
    public function getLocation($id) : JsonResponse
    {
        $user = User::select('latitude', 'longitude')
            ->where('id', '=', $id)
            ->get();
        return $this->successResponse($user, Response::HTTP_OK);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Set User location.
     * @param $request Request
     * @return JsonResponse
     * @throws
     */
    public function storeLocation(Request $request) : JsonResponse
    {
        $data = $this->validate($request, [
            'user_id' => 'required|integer',
            'longitude' => 'required',
            'latitude' => 'required'
        ]);

        $user = User::findOrFail($data['user_id']);
        $user->latitude = $data['latitude'];
        $user->longitude = $data['longitude'];
        $user->save();

        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Search for users.
     * @param $request Request
     * @return JsonResponse
     * @throws
     */
    public function search(Request $request) : JsonResponse
    {
        $data = $this->validate($request, [
            'user_id' => 'required|integer',
            'type' => 'required',
            'name' => 'string'
        ]);

        $user = User::find($data['user_id'])->first();

        $map = User::ofType($data['type'])
            ->WithName($data['name'])
            ->Active()
            ->MapSearch($user)
            ->paginate(8);

        return $this->successResponse($map, Response::HTTP_CREATED);
    }
}
