<?php

namespace App\Http\Controllers;

use App\Answers;
use App\Questions;
use App\Survey;
use App\Traits\ApiResponser;
use App\User;
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
     * @param $request Request
     * @return JsonResponse
     * @throws
     */
    public function finish(Request $request) : JsonResponse
    {
        $data = $this->validate($request, [
            'survey' => 'required|integer',
            'user' => 'required|integer'
        ]);

        $user = User::findOrFail($data['user']);

        $score = $this->unanswered($data, true);

        if ($score instanceof JsonResponse) {
            return $score;
        }

        $user->survey_score = $score;
        $user->save();

        return $this->successResponse(['survey_score' => $user->survey_score]);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get all unanswered questions.
     * @param $request Request
     * @return JsonResponse
     * @throws
     */
    public function all(Request $request) : JsonResponse
    {
        $data = $this->validate($request, [
            'survey' => 'required|integer',
            'user' => 'required|integer'
        ]);

        $question = $this->unanswered($data);

        return $this->successResponse(['survey_score' => $question]);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get unanswered questions.
     * @param $data
     * @param $returnSum boolean
     * @return
     * @throws
     */
    public function unanswered($data, $returnSum = false)
    {
        $surveyScore = 0;
        $allQuestions = array();

        $survey = Survey::find($data['survey'])->first();

        foreach ($survey->categories as $category) {
            $category_questions = $category->questions;
            $user_answers = Answers::all()->keyBy('question_id')->where('user_id', $data['user']);

            foreach ($category_questions as $question) {

                if ($returnSum) {
                    if (isset($user_answers[$question->id]['answer']) && $user_answers[$question->id]['answer'] != '') {
                        $surveyScore += $user_answers[$question->id]['answer'];
                    } else {
                        return $this->errorResponse('All survey questions not answered.', Response::HTTP_FORBIDDEN);
                    }
                } else {
                    if (!(isset($user_answers[$question->id]['answer']) && $user_answers[$question->id]['answer'] != '')) {


                        $allQuestions[] = array(
                            'id' => $question->id,
                            'question' => $question->question,
                            'options' => json_decode($question->options)
                        );
                    }
                }
            }
        }

        if ($returnSum) {
            return (int)$surveyScore;
        }

        return $allQuestions;
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
