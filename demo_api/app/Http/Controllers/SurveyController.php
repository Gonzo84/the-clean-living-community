<?php

namespace App\Http\Controllers;

use App\Answers;
use App\Questions;
use App\Survey;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    use ApiResponser;

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Create a new survey instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Return the list of surveys.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        return $this->successResponse(Survey::all(), Response::HTTP_OK);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Show one survey.
     * @param $id Survey
     * @return JsonResponse
     * @throws
     */
    public function show($id) : JsonResponse
    {
        return $this->successResponse(Survey::findOrFail($id), Response::HTTP_OK);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Show survey categories.
     * @param $id Survey
     * @return JsonResponse
     * @throws
     */
    public function categories($id) : JsonResponse
    {
        $survey = Survey::findOrFail($id);
        return $this->successResponse($survey->categories, Response::HTTP_OK);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Show category questions.
     * @param $id Survey
     * @return JsonResponse
     * @throws
     */
    public function questions($id) : JsonResponse
    {
        $category = Categories::findOrFail($id);
        return $this->successResponse($category->questions, Response::HTTP_OK);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Store user answers.
     * @param $request Request
     * @param $id Survey
     * @return JsonResponse
     * @throws
     */
    public function storeQuestions(Request $request, $id) : JsonResponse
    {
        $data = $this->validate($request, [
            'user_id' => 'required|integer',
            'answers' => 'required|array'
        ]);

        foreach ($data['answers'] as $id => $user_answer) {
            $attributes = [
                'user_id' => $data['user_id'],
                'question_id' => $id,
                'answer' => $user_answer
            ];

            $this->saveQuestion($attributes);
        }

        return $this->successResponse(['success' => true]);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Store user answers.
     * @param $request Request
     * @param $id Survey
     * @return JsonResponse
     * @throws
     */
    public function storeQuestion(Request $request) : JsonResponse
    {
        $data = $this->validate($request, [
            'user_id' => 'required|integer',
            'question_id' => 'required|integer',
            'answer' => 'required|integer'
        ]);

        $this->saveQuestion($data);

        return $this->successResponse(['success' => true]);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Finish survey.
     * @param $id Survey
     * @return JsonResponse
     * @throws
     */
    public function finish($id) : JsonResponse
    {
        $surveyScore = 0;
        $survey = Survey::find($id)->first();

        foreach ($survey->categories as $category) {

            $category_questions = array_column($category->questions->toArray(), 'id');

            foreach ($category->questions as $question) {

                $answers = $question->answers->toArray();

                $category_answers = array_column($answers, 'id');

                if (count(array_diff($category_questions, $category_answers)) > 0)
                {
                    return $this->errorResponse('All survey questions not answered.', Response::HTTP_FORBIDDEN);
                }

                $surveyScore += array_sum(array_column($answers, 'answer'));
            }
        }

        return $this->successResponse(['survey_score' => $surveyScore]);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Finish survey.
     * @param $data
     * @throws
     */
    public function saveQuestion($data)
    {
        $answer = Answers::where([
            'user_id' => $data['user_id'],
            'question_id' => $data['question_id']
        ])->first();

        if (empty($answer)) {
            Answers::create($data);
        } else {
            $answer->answer = $data['answer'];
            $answer->save();
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
