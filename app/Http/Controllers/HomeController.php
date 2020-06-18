<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helpers;
use App\ModelAds;
use App\ModelDocuments;
use App\ModelMenus;
use App\ModelPosts;
use App\ModelQuestions;
use App\ModelSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    protected static $prefix = 'frontend';
    protected static $isMobile = false;
    protected static $menus = NULL;
    protected static $settings = NULL;
    protected static $helpers = NULL;
    protected static $newsList = NULL;
    protected static $pdfList = NULL;

    protected $rightAds = NULL;
    protected $paginationLimit = 40;
    protected $sliderLimit = 10;
    protected $newsListLimit = 15;
    protected $centerPosts = [];
    protected $top5 = [];

    public function __construct(Request $request)
    {
        $share = [];
        $agent = new Agent;

        if (self::$helpers == NULL) {
            self::$helpers = new Helpers();
        }

        if (self::$settings == NULL) {
            self::$settings = ModelSettings::where('id', 1)->select('settings.*')->first();
        }

        if (self::$menus == NULL) {
            self::$menus = ModelMenus::where('active', 1)->select('menus.*')->orderBy('menus.rank', 'asc')->limit(15)->get();
        }

        if (self::$pdfList == NULL) {
            self::$pdfList = ModelDocuments::where('active', 1)->orderBy('id', 'desc')->limit(8)->get();
        }

        self::$newsList = ModelPosts::select('posts.*')->where('date', '<=', date('Y-m-d H:i:s'))
            ->where('active', 1)->orderBy('date', 'DESC')->limit($this->newsListLimit)->get();

        $this->centerPosts = $this->get_home_posts();

        $votingCheck = ModelQuestions::where('active', 1)->orderBy('id', 'desc')->count();

        $share = [
            'helpers' => self::$helpers,
            'settings' => self::$settings,
            'menus' => self::$menus,
            'newsList' => self::$newsList,
            'pdfList' => self::$pdfList,
            'votingCheck' => $votingCheck
        ];

        if ($agent->isMobile() && $request->status != 'desktop') {
            self::$prefix = 'mobile';
            self::$isMobile = true;
        } else {
            $this->rightAds = ModelAds::where('position', 'home_right')->select('script_text')->first();

            $this->top5 = DB::select("
                SELECT tb1.*, tb2.slug as category_slug, tb2.name as category_name
                FROM posts tb1 
                LEFT JOIN category tb2 ON tb2.id=tb1.category
                WHERE tb1.active='1' AND tb2.active='1' 
                    AND tb1.date BETWEEN '" . date('Y-m-d H:i:s', time() - (7 * 86400)) . "' AND '" . date('Y-m-d H:i:s') . "'
                ORDER BY tb1.views DESC 
                LIMIT 0,5
            ");

            $share['rightAds'] = $this->rightAds;
            $share['top5'] = $this->top5;
        }

        View::share($share);
    }

    protected function get_home_posts()
    {
        $result = [];
        $categoryData = DB::select("SELECT id FROM category WHERE active=1");

        foreach ($categoryData as $rows) {
            $postData = DB::select(DB::raw("
                SELECT tb1.*, tb2.slug as category_slug, tb2.name as category_name
                FROM posts tb1 
                LEFT JOIN category tb2 ON tb2.id=tb1.category
                LEFT JOIN post_position tb3 ON tb3.posts_id = tb1.id
                WHERE tb1.active='1' AND tb2.active='1' AND tb3.position_id='4' AND category=:category_id
                    AND tb1.date <= :datetimestr
                ORDER BY tb1.date DESC
                LIMIT 0,4
            "), ['category_id' => $rows->id, 'datetimestr' => Carbon::now()->toDateTimeString()]);
            $result[$rows->id] = $postData;
        }

        return $result;
    }

    protected function get_posts_with_position($bindings = [], $object = true)
    {
        $sql = "SELECT tb1.*, tb3.name as position_name, tb3.slug as position_slug
            FROM posts tb1
            LEFT JOIN post_position tb2 ON tb2.posts_id = tb1.id
            LEFT JOIN position tb3 ON tb3.id=tb2.position_id
            WHERE tb2.position_id = :position_id AND tb1.active=1 AND tb3.active=1 AND tb1.date <= :datetimestr
            ORDER BY tb1.date DESC
            LIMIT :limit";

        $modelData = DB::select(DB::raw($sql), $bindings);

        return ($object) ? $modelData : Helpers::objectToArray($modelData);
    }

    protected function post_views($postId)
    {
        if (!$postId || isset($_COOKIE["post_$postId"])) {
            return false;
        }

        $views = ModelPosts::where('id', $postId)->select('posts.views')->first();

        $inc = ($views->views > 0) ? rand(10, 60) : 1;

        setcookie("post_$postId", $postId, time() + (60 * 60 * 24));
        DB::select("UPDATE posts SET views = views+$inc WHERE id = :id", ['id' => $postId]);
    }

    public function get_sitemap()
    {
        $categories = DB::select("SELECT id, slug FROM category WHERE active=1");
        $posts = ModelPosts::where('date', '<=', date('Y-m-d H:i:s'))
            ->where('active', 1)->orderBy('date', 'DESC')->limit(1000)->get(['slug', 'date']);

        // dd([$categories, $posts]);
        return response()->view('sitemap', [
            'posts' => $posts,
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml');
    }

}
