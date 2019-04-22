<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class SurveySeeder extends Seeder
{
    protected $toTruncate = ['surveys','survey_answers','survey_categories','survey_questions'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Model::unguard();

        foreach ($this->toTruncate as $table) {
            DB::table($table)->truncate();
        }

        $positiveAnswers = json_encode([
            '2' => 'Strongly Disagree',
            '1' => 'Disagree',
            '0' => 'Neutral',
            '-1' => 'Agree',
            '-2' => 'Strongly Agree',
        ]);

        $negativeAnswers = json_encode([
            '-2' => 'Strongly Disagree',
            '-1' => 'Disagree',
            '0' => 'Neutral',
            '1' => 'Agree',
            '2' => 'Strongly Agree',
        ]);

        DB::table('surveys')->insert([
            [
                'title' => 'Survey',
                'created_at' =>  \Carbon\Carbon::now(), # \Datetime()
                'updated_at' => \Carbon\Carbon::now(),  # \Datetime()
            ],
        ]);

        DB::table('survey_categories')->insert([
//            [
//                'survey_id' => 1,
//                'title' => 'Individual',
//                /                'created_at' =>  \Carbon\Carbon::now(),
//                'updated_at' => \Carbon\Carbon::now(),
//            ],
            [
                'survey_id' => 1,
                'title' => 'Calculated',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'survey_id' => 1,
                'title' => 'Spontaneous',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'survey_id' => 1,
                'title' => 'Introvert',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'survey_id' => 1,
                'title' => 'Extrovert',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'survey_id' => 1,
                'title' => 'Healthy',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'survey_id' => 1,
                'title' => 'Unhealthy',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'survey_id' => 1,
                'title' => 'Mood Instability',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'survey_id' => 1,
                'title' => 'Mood Stability',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'survey_id' => 1,
                'title' => 'Communication Direct',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'survey_id' => 1,
                'title' => 'Communication Indirect',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        ]);

        DB::table('survey_questions')->insert([
//            [
//                'category_id' => 1,
//                'question' => 'Age',
//                'created_at' =>  \Carbon\Carbon::now(),
//                'updated_at' => \Carbon\Carbon::now(),
//            ], [
//                'category_id' => 1,
//                'question' => 'Married',
//                'created_at' => \Carbon\Carbon::now(),
//                'updated_at' => \Carbon\Carbon::now(),
//            ], [
//                'category_id' => 1,
//                'question' => 'Children',
//                'created_at' => \Carbon\Carbon::now(),
//                'updated_at' => \Carbon\Carbon::now(),
//            ], [
//                'category_id' => 1,
//                'question' => 'Pet',
//                'created_at' => \Carbon\Carbon::now(),
//                'updated_at' => \Carbon\Carbon::now(),
//            ], [
//                'category_id' => 1,
//                'question' => 'Education',
//                'created_at' => \Carbon\Carbon::now(),
//                'updated_at' => \Carbon\Carbon::now(),
//            ], [
//                'category_id' => 1,
//                'question' => 'Religion',
//                'created_at' => \Carbon\Carbon::now(),
//                'updated_at' => \Carbon\Carbon::now(),
//            ], [
//                'category_id' => 1,
//                'question' => 'Gender',
//                'created_at' => \Carbon\Carbon::now(),
//                'updated_at' => \Carbon\Carbon::now(),
//            ], [
//                'category_id' => 1,
//                'question' => 'Sexual orientation',
//                'created_at' => \Carbon\Carbon::now(),
//                'updated_at' => \Carbon\Carbon::now(),
//
//            ], [
//                'category_id' => 1,
//                'question' => 'Time since last relapse',
//                'created_at' => \Carbon\Carbon::now(),
//                'updated_at' => \Carbon\Carbon::now(),
//            ], [
//                'category_id' => 1,
//                'question' => 'Smoker',
//                'created_at' => \Carbon\Carbon::now(),
//                'updated_at' => \Carbon\Carbon::now(),
//            ], [
//                'category_id' => 1,
//                'question' => 'Attending support groups',
//                'created_at' => \Carbon\Carbon::now(),
//                'updated_at' => \Carbon\Carbon::now(),
//            ], [
//                'category_id' => 1,
//                'question' => 'Location',
//                'created_at' => \Carbon\Carbon::now(),
//                'updated_at' => \Carbon\Carbon::now(),
            [
                'category_id' => 1,
                'question' => 'I respond to e-mails as soon as possible and hate seeing unread emails.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 1,
                'question' => 'Being organized is better than being flexible.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 1,
                'question' => 'My personal and professional spaces are very well organized.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 1,
                'question' => 'When booking trips, I create a minute-by-minute itinerary.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 1,
                'question' => 'I know what I will eat for dinner 2 days before I have it.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 2,
                'question' => 'I improvise more than I plan.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 2,
                'question' => 'I accomplish most by working while motivated rather than systematically approaching the task.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 2,
                'question' => 'I wait until the night before to complete a task.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 2,
                'question' => 'I am witty and a quick thinker.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 2,
                'question' => 'I’d rather try a new restaurant than to return to my favorite spot.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 3,
                'question' => 'I typically wait for others to start conversations with me.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 3,
                'question' => 'I’d prefer to play video games or read a book than attend a social gathering.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 3,
                'question' => 'I’m the most quiet of my family/friends.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 3,
                'question' => 'I enjoy listening more than speaking',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 3,
                'question' => 'Being surrounded by others often leaves me feeling drained.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 4,
                'question' => 'I’m the most fun person while with family and friends.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 4,
                'question' => 'People tell me how funny I am.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 4,
                'question' => 'I’m the center of the dance circle.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 4,
                'question' => 'My best thinking happens when I am in a group.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 4,
                'question' => 'I enjoy making small talk.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 5,
                'question' => 'I exercise 2-3 times a week.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 5,
                'question' => 'I try to eat organic.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 5,
                'question' => 'I avoid foods that aren’t considered “healthy”.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 5,
                'question' => 'I prefer to drink water instead of other beverages.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 5,
                'question' => 'I take vitamins.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 6,
                'question' => 'I would like to be much healthier than I am.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 6,
                'question' => 'I don’t count calories or look at nutritional values.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 6,
                'question' => 'I eat fast food.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 6,
                'question' => 'The food I eat doesn’t impact how I feel.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 6,
                'question' => 'Sleep is not important to me.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 7,
                'question' => 'It is difficult for me to improve my mood if I’m feeling down.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 7,
                'question' => 'My mood can change very quickly.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 7,
                'question' => 'The weather heavily impacts my mood.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 7,
                'question' => 'Other people’s moods can heavily impact mine.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 7,
                'question' => 'I become irritable easily.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 8,
                'question' => 'I can easily control my emotions.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 8,
                'question' => 'I feel as though I am emotionally stable.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 8,
                'question' => 'Music can improve my mood.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 8,
                'question' => 'I feel comfortable expressing my emotions.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 8,
                'question' => 'I handle stressful situations well.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 9,
                'question' => 'I don’t beat around the bush when I have something to say.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 9,
                'question' => 'I’m more concerned about telling the truth than other’s feelings.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 9,
                'question' => 'Friends and family ask me for help making decisions.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 9,
                'question' => 'I try to deal with any and all issues as soon as possible.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 9,
                'question' => 'Others often tell me I can be abrasive.',
                'type' => 'checkbox',
                'options' => $negativeAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 10,
                'question' => 'I am open to hearing everyone’s opinions.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 10,
                'question' => 'I consider myself to be a people pleaser.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 10,
                'question' => 'I try to figure things out on my own rather than asking someone for help.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 10,
                'question' => 'I stay quiet when others are arguing because I don’t want to cause more problems',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 10,
                'question' => 'I have a difficult time expressing my opinions and myself.',
                'type' => 'checkbox',
                'options' => $positiveAnswers,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                ]
        ]);

        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
