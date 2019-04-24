<?php

namespace App\Http\Controllers;

use App\Gathering;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GatheringController extends Controller
{
    use ApiResponser;
    private $creatorId = 1; //todo get user id from token

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
     * Create new gathering
     * @return JsonResponse
     * @param $request Request
     * @throws \Illuminate\Validation\ValidationException
     */

    public function createGathering(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'city' => 'required|max:255',
            'street' => 'required|max:255',
            'number' => 'required|max:25',
            'time' => 'required|max:25'
        ]);

        $gathering = array(
            'user_id' => $this->creatorId,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'city' => $request->input('city'),
            'street' => $request->input('street'),
            'number' => $request->input('number'),
            'time' => $request->input('time'),
            'active' => true
        );

        $newGathering = Gathering::create($gathering);
        return $this->successResponse($newGathering);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get all gatherings and search gatherings
     * @return JsonResponse
     * @param $request Request
     * @throws \Illuminate\Validation\ValidationException
     */

    public function getGatherings(Request $request)
    {
        $gaterings = Gathering::where('title', 'LIKE', "%{$request->input('search')}%")->get();

        return $this->successResponse($gaterings);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Join to gathering
     * @return JsonResponse
     * @param $request Request
     * @throws \Illuminate\Validation\ValidationException
     */

    public function joinGathering(Request $request)
    {
        $this->validate($request, [
            'gathering_id' => 'required',
            'user_id' => 'required'
        ]);

        $gathering = Gathering::findOrFail($request->input('gathering_id'));
        $user = User::findOrFail($request->input('user_id'));
        $gathering->users()->sync($user);

        return $this->successResponse(['success' => true]);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get one gathering details and all participants
     * @return JsonResponse
     * @param $id
     * @throws \Illuminate\Validation\ValidationException
     */

    public function getOneGathering($id)
    {
        $gathering = Gathering::with('user')->findOrFail($id);
        $gathering['users'] = $gathering->users;

        return $this->successResponse($gathering);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Leave gathering
     * @return JsonResponse
     * @param $request Request
     * @throws \Illuminate\Validation\ValidationException
     */

    public function leaveGathering(Request $request)
    {
        $this->validate($request, [
            'gathering_id' => 'required',
            'user_id' => 'required'
        ]);

        $gathering = Gathering::findOrFail($request->input('gathering_id'));
        $user = User::findOrFail($request->input('user_id'));
        $gathering->users()->detach($user);

        return $this->successResponse(['success' => true]);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
