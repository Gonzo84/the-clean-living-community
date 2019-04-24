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
        $survey = Survey::findOrFail($id);
        return $this->successResponse($survey, Response::HTTP_OK);
    }

    /**
     * Show survey categories.
     * @param $id Survey
     * @return JsonResponse
     * @throws
     */
    public function categories($id) {
        $survey = Survey::findOrFail($id);
        return $this->successResponse($survey->categories, Response::HTTP_OK);
    }

    /**
     * Show category questions.
     * @param $id Survey
     * @return JsonResponse
     * @throws
     */
    public function questions($id) {
        $category = Categories::findOrFail($id);
        return $this->successResponse($category->questions, Response::HTTP_OK);
    }

    /**
     * Store user answers.
     * @param $request Request
     * @param $id Survey
     * @return JsonResponse
     * @throws
     */
    public function storeQuestions(Request $request, $id) {

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

            $answer = $this->saveQuestion($attributes);

        }

        return $this->successResponse($data['answers']);
    }

    /**
     * Store user answers.
     * @param $request Request
     * @param $id Survey
     * @return JsonResponse
     * @throws
     */
    public function storeQuestion(Request $request) {

        $data = $this->validate($request, [
            'user_id' => 'required|integer',
            'question_id' => 'required|integer',
            'answer' => 'required|integer'
        ]);

        return $this->successResponse($this->saveQuestion($data));
    }

    /**
     * Finish survey.
     * @param $id Survey
     * @return JsonResponse
     * @throws
     */
    public function finish($id) {

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

    /**
     * Finish survey.
     * @param $data
     * @return $answer Answers
     * @throws
     */
    public function saveQuestion($data) {

//        $answer = Answers::firstOrNew([
//            'user_id' => $data['user_id'],
//            'question_id' => $data['question_id']
//        ]);

//        dd($answer);
//
//        if (isset($answer->first()->answer)) {
//
//        }

        $answer = Answers::where([
            'user_id' => $data['user_id'],
            'question_id' => $data['question_id']
        ])->first();

        if ($answer->isEmpty()) {
            $answer = Answers::create($data);
        } else {
            $answer->answer = $data['answer'];
            $answer->save();
        }

         return $answer;
    }
}
