<?php

namespace App\Http\Controllers;

use App\Gathering;
use App\Traits\ApiResponser;
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

    }
}
