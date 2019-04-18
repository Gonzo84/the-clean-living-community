<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
            [
                'category_id' => 1,
                'question' => 'Age',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 1,
                'question' => 'Married',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 1,
                'question' => 'Children',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 1,
                'question' => 'Pet',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 1,
                'question' => 'Education',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 1,
                'question' => 'Religion',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 1,
                'question' => 'Gender',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 1,
                'question' => 'Sexual orientation',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),

            ], [
                'category_id' => 1,
                'question' => 'Time since last relapse',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 1,
                'question' => 'Smoker',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 1,
                'question' => 'Attending support groups',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 1,
                'question' => 'Location',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 2,
                'question' => 'I respond to e-mails as soon as possible and hate seeing unread emails.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 2,
                'question' => 'Being organized is better than being flexible.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 2,
                'question' => 'My personal and professional spaces are very well organized.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 2,
                'question' => 'When booking trips, I create a minute-by-minute itinerary.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 2,
                'question' => 'I know what I will eat for dinner 2 days before I have it.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 3,
                'question' => 'I improvise more than I plan.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 3,
                'question' => 'I accomplish most by working while motivated rather than systematically approaching the task.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 3,
                'question' => 'I wait until the night before to complete a task.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 3,
                'question' => 'I am witty and a quick thinker.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 3,
                'question' => 'I’d rather try a new restaurant than to return to my favorite spot.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 4,
                'question' => 'I typically wait for others to start conversations with me.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 4,
                'question' => 'I’d prefer to play video games or read a book than attend a social gathering.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 4,
                'question' => 'I’m the most quiet of my family/friends.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 4,
                'question' => 'I enjoy listening more than speaking',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 4,
                'question' => 'Being surrounded by others often leaves me feeling drained.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 5,
                'question' => 'I’m the most fun person while with family and friends.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 5,
                'question' => 'People tell me how funny I am.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 5,
                'question' => 'I’m the center of the dance circle.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 5,
                'question' => 'My best thinking happens when I am in a group.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 5,
                'question' => 'I enjoy making small talk.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 6,
                'question' => 'I exercise 2-3 times a week.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 6,
                'question' => 'I try to eat organic.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 6,
                'question' => 'I avoid foods that aren’t considered “healthy”.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 6,
                'question' => 'I prefer to drink water instead of other beverages.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 6,
                'question' => 'I take vitamins.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 7,
                'question' => 'I would like to be much healthier than I am.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 7,
                'question' => 'I don’t count calories or look at nutritional values.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 7,
                'question' => 'I eat fast food.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 7,
                'question' => 'The food I eat doesn’t impact how I feel.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 7,
                'question' => 'Sleep is not important to me.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 8,
                'question' => 'It is difficult for me to improve my mood if I’m feeling down.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 8,
                'question' => 'My mood can change very quickly.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 8,
                'question' => 'The weather heavily impacts my mood.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 8,
                'question' => 'Other people’s moods can heavily impact mine.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 8,
                'question' => 'I become irritable easily.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 9,
                'question' => 'I can easily control my emotions.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 9,
                'question' => 'I feel as though I am emotionally stable.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 9,
                'question' => 'Music can improve my mood.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 9,
                'question' => 'I feel comfortable expressing my emotions.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 9,
                'question' => 'I handle stressful situations well.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 10,
                'question' => 'I don’t beat around the bush when I have something to say.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 10,
                'question' => 'I’m more concerned about telling the truth than other’s feelings.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 10,
                'question' => 'Friends and family ask me for help making decisions.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 10,
                'question' => 'I try to deal with any and all issues as soon as possible.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 10,
                'question' => 'Others often tell me I can be abrasive.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 11,
                'question' => 'I am open to hearing everyone’s opinions.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 11,
                'question' => 'I consider myself to be a people pleaser.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 11,
                'question' => 'I try to figure things out on my own rather than asking someone for help.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 11,
                'question' => 'I stay quiet when others are arguing because I don’t want to cause more problems',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ], [
                'category_id' => 11,
                'question' => 'I have a difficult time expressing my opinions and myself.',
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                ]
        ]);
    }
}
