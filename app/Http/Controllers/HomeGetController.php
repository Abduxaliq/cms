<?php

namespace App\Http\Controllers;

use App\ModelAds;
use App\ModelCategory;
use App\ModelPostImages;
use App\ModelPosts;
use App\Http\Helpers;
use App\ModelQuestions;
use App\ModelVotingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeGetController extends HomeController
{
    /**
     * index page
     */
    public function get_home()
    {
        $showNewsList = false;
        $centerAds = ModelAds::where('position', 'home_center')->select('script_text')->get();
        $slider = $this->get_posts_with_position([
            "position_id" => 1,
            "limit" => $this->sliderLimit,
            'datetimestr' => Carbon::now()->toDateTimeString()
        ]);
        $newsActual = $this->get_posts_with_position([
            "position_id" => 2,
            "limit" => 5,
            'datetimestr' => Carbon::now()->toDateTimeString()
        ]);
        $underSlider = $this->get_posts_with_position([
            "position_id" => 3,
            "limit" => 4,
            'datetimestr' => Carbon::now()->toDateTimeString()
        ]);

        $postsList = $this->centerPosts;
        $centerPostsList = [
            isset($postsList[19]) ? $postsList[19] : [], // Политика
            isset($postsList[30]) ? $postsList[30] : [], // ОБЩЕСТВО
            isset($postsList[21]) ? $postsList[21] : [], // Экономика
            isset($postsList[34]) ? $postsList[34] : [], // Социум
            isset($postsList[29]) ? $postsList[29] : [], // происшествия
            isset($postsList[33]) ? $postsList[33] : [], // КАРАБАХ
            isset($postsList[22]) ? $postsList[22] : [], // В мире
            isset($postsList[32]) ? $postsList[32] : [], // Интересно
            isset($postsList[35]) ? $postsList[35] : [], // ТЕХНОЛОГИЯ
        ];

        $rightPostsList = [
            isset($postsList[20]) ? $postsList[20] : [], // Интервью
            isset($postsList[23]) ? $postsList[23] : [], // Спорт
            isset($postsList[24]) ? $postsList[24] : [], // Шоу-бизнес
            isset($postsList[26]) ? $postsList[26] : [], // Фото
            isset($postsList[25]) ? $postsList[25] : [], // Видео
        ];

        return view(self::$prefix . '.home', compact(
            'slider', 'underSlider', 'newsActual', 'centerPostsList', 'rightPostsList', 'centerAds', 'showNewsList'
        ));
    }

    public function get_all_category_list()
    {
        $categoryData = ModelCategory::where('active', 1)->select('category.*')->first();
        $categoryData->name = "подробнее";
        $categoryPostsList = ModelPosts::whereDate('date', '<=', Carbon::now()->toDateTimeString())
            ->where('active', 1)->orderBy('date', 'DESC')->where('id', '>', 90000)->simplePaginate($this->paginationLimit);

        $postsList = $this->centerPosts;
        $rightPostsList = [
            isset($postsList[20]) ? $postsList[20] : [],
            isset($postsList[23]) ? $postsList[23] : [],
            isset($postsList[24]) ? $postsList[24] : [],
            isset($postsList[26]) ? $postsList[26] : [],
            isset($postsList[25]) ? $postsList[25] : []
        ];


        return view(self::$prefix . '.category_list', compact(
            'rightPostsList', 'categoryPostsList', 'categoryData'
        ));
    }

    public function get_category_list($slug)
    {
        $categoryData = ModelCategory::where('slug', $slug)->where('active', 1)->select('category.*')->first();
        if ($categoryData == null) {
            return redirect('/');
        }

        $categoryPostsList = ModelPosts::where('category', $categoryData->id)->whereDate('date', '<=', Carbon::now()->toDateTimeString())->where('active', 1)->where('id', '>', 90000)->latest('id')->simplePaginate($this->paginationLimit);

        $postsList = $this->centerPosts;
        $rightPostsList = [
            isset($postsList[20]) ? $postsList[20] : [],
            isset($postsList[23]) ? $postsList[23] : [],
            isset($postsList[24]) ? $postsList[24] : [],
            isset($postsList[26]) ? $postsList[26] : [],
            isset($postsList[25]) ? $postsList[25] : []
        ];


        return view(self::$prefix . '.category_list', compact(
            'rightPostsList', 'categoryPostsList', 'categoryData'
        ));
    }

    public function get_posts_details($slug)
    {
        //$postData = ModelPosts::where('slug', $slug)->where('active', 1)->where('date', '<=', 'NOW()')->first();
        $postData = DB::select(DB::raw("
            SELECT id, category, title, short_title, description, content, author, date, tags, image, created_at, slug, views
            FROM posts WHERE slug = :slug AND active = 1 AND date <= :datetimestr 
            LIMIT 1
        "), ['slug' => $slug, 'datetimestr' => Carbon::now()->toDateTimeString()]);

        if ($postData == NULL)
            return redirect('/');
        $postData = $postData[0];
        $postAds = ModelAds::where('position', 'post_details')->select('script_text')->get();

        $postData->title = trim(strip_tags($postData->title));

        $categoryData = ModelCategory::where('id', $postData->category)->where('active', 1)->first();
        $postImages = DB::select(DB::raw("
            SELECT id, url FROM post_images WHERE post = :post AND active=1
        "), ['post' => $postData->id]);

        $postsList = $this->centerPosts;
        $rightPostsList = [
            isset($postsList[20]) ? $postsList[20] : [],
            isset($postsList[23]) ? $postsList[23] : [],
            isset($postsList[24]) ? $postsList[24] : [],
            isset($postsList[26]) ? $postsList[26] : [],
            isset($postsList[25]) ? $postsList[25] : []
        ];

        $this->post_views($postData->id);
        return view(self::$prefix . '.post_details', compact(
            'postData', 'categoryData', 'rightPostsList', 'postImages', 'postAds'
        ));
    }

    public function get_calendar($date = "")
    {
        if (!empty($date)) {
            try {
                $date = Carbon::parse($date)->toDateString();
                $categoryData = (object)['name' => Carbon::parse($date)->format('d-m-Y')];

                $categoryPostsList = ModelPosts::whereDate('date', '=', $date)
                    ->whereDate('date', '<=', Carbon::now()->toDateTimeString())
                    ->where('active', 1)
                    ->simplePaginate($this->paginationLimit);

                $postsList = $this->centerPosts;
                $rightPostsList = [
                    isset($postsList[20]) ? $postsList[20] : [],
                    isset($postsList[23]) ? $postsList[23] : [],
                    isset($postsList[24]) ? $postsList[24] : [],
                    isset($postsList[26]) ? $postsList[26] : [],
                    isset($postsList[25]) ? $postsList[25] : []
                ];

                return view(self::$prefix . '.category_list', compact(
                    'rightPostsList', 'categoryPostsList', 'categoryData'
                ));
                //dd($date);
            } catch (\Exception $e) {
                return redirect('/');
            }
        }
    }

    public function get_counters()
    {
        return view('counter');
    }

    public function get_banner()
    {
        $out = true;
        $underSlider = $this->get_posts_with_position([
            "position_id" => 3,
            "limit" => 4,
            'datetimestr' => Carbon::now()->toDateTimeString()
        ]);
        return view('banner', compact('out', 'underSlider'));
    }

    public function get_voting(Request $request)
    {
        $votingData = ModelQuestions::where('active', 1)->orderBy('id', 'desc')->first();
        $ip = $request->ip();

        $firstTime = ModelVotingHistory::where('voting_id', $votingData->id)->where('address', $ip)->first();

        if ($firstTime) {
            return view('voting_result', compact('votingData'));
        }

        return view('voting', compact('votingData'));
    }

}
