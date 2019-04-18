<?php

namespace App\Http\Controllers;

use App\Survey;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    use ApiResponser;

    /**
     * Create a new survey instance.
     *
     * @return void
     */
    public function __construct() {

    }

    /**
     * Return the list of surveys.
     *
     * @return JsonResponse
     */
    public function index() {
        return $this->successResponse(Survey::all(), Response::HTTP_OK);
    }


    /**
     * Show one survey.
     * @param $id Survey
     * @return JsonResponse
     * @throws
     */
    public function show($id) {
    }
}
