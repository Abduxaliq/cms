<?php

namespace App\Http\Controllers;

use App\Http\Helpers;
use App\ModelAds;
use App\ModelAnswers;
use App\ModelDocuments;
use App\ModelPosition;
use App\ModelPostImages;
use App\ModelPostPosition;
use App\ModelQuestions;
use Illuminate\Http\Request;
use App\ModelSettings;
use App\ModelCategory;
use App\ModelPosts;
use App\ModelMenus;
use App\ModelPage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminGetController extends AdminController
{
    public function get_new_slug()
    {
        /*$posts = ModelPosts::all(['id','title','short_title']);

        foreach ($posts as $post) {
            if (
                count(explode('<span', $post->title)) > 1
                || count(explode('<strong', $post->title)) > 1
                || count(explode('<em', $post->title)) > 1
            ) {
                $slug = str_slug(strip_tags($post->title != "" ? $post->title : $post->short_title)) . '-' . $post->id;
                print $post->id . ' === ' . $slug . "<br>\n";
                ModelPosts::updateOrCreate(['id' => $post->id], [
                    'slug' => $slug
                ]);
            }
        }*/

        die();
    }
    
    public function get_home()
    {
        return view('backend.home');
    }

    public function get_login()
    {
        return view('backend.login');
    }

    public function get_logout()
    {
        auth()->logout();
        return view('backend.login');
    }

    public function get_settings()
    {
        $settings = ModelSettings::where('id', 1)->first();
        return view('backend.settings')->with('settings', $settings);
    }

    // menus
    public function get_menus()
    {
        $menus = ModelMenus::where('active', '>=', '0')->select('menus.*')->orderBy('parent_id', 'desc')->orderBy('rank')->get();
        $menuStr = $this->makeMenu($menus);
        return view('backend.menus')->with('menuStr', $menuStr);
    }

    public function get_add_menu()
    {
        $menus = ModelMenus::where('active', '1')->select('menus.*')->get();
        $forUrl[0] = ModelPage::where('active', '1')->select('page.title as name', 'page.id')->get();
        $forUrl[1] = ModelCategory::where('active', '1')->select('category.name', 'category.id')->get();
        return view('backend.add_menu')->with('menus', $menus)->with('forUrl', $forUrl);
    }

    public function get_edit_menu($slug)
    {
        $baseMenu = ModelMenus::where('slug', $slug)->first();
        if (!isset($baseMenu)) return redirect('/admin/menus');
        $menus = ModelMenus::where('active', '1')->select('menus.*')->get();
        $forUrl[0] = ModelPage::where('active', '1')->select('page.title as name', 'page.id')->get();
        $forUrl[1] = ModelCategory::where('active', '1')->select('category.name', 'category.id')->get();
        return view('backend.edit_menu')->with('menus', $menus)->with('baseMenu', $baseMenu)->with('forUrl', $forUrl);
    }

    // category
    public function get_category()
    {
        $categories = ModelCategory::where('active', '>=', '0')->select('category.*')->orderBy('id', 'desc')->get();
        return view('backend.category')->with('categories', $categories);
    }

    public function get_add_category()
    {
        $categories = ModelCategory::where('active', '1')->select('category.*')->get();
        return view('backend.add_category')->with('categories', $categories);
    }

    public function get_edit_category($slug)
    {
        $baseCategory = ModelCategory::where('slug', $slug)->first();
        if (!isset($baseCategory)) return redirect('/admin/category');
        $categories = ModelCategory::where('active', '1')->select('category.*')->get();
        return view('backend.edit_category')->with('categories', $categories)->with('baseCategory', $baseCategory);
    }

    // position
    public function get_position()
    {
        $positions = ModelPosition::where('active', '>=', '0')->select('*')->orderBy('id', 'desc')->get();
        return view('backend.position')->with('positions', $positions);
    }

    public function get_add_position()
    {
        $positions = ModelPosition::where('active', '1')->select('*')->get();
        return view('backend.add_position')->with('positions', $positions);
    }

    public function get_edit_position($slug)
    {
        $basePosition = ModelPosition::where('slug', $slug)->first();
        if (!isset($basePosition)) return redirect('/admin/position');
        return view('backend.edit_position')->with('basePosition', $basePosition);
    }

    // posts
    public function get_posts()
    {
        $posts = ModelPosts::where('active', '>=', '0')->select('posts.*')->orderBy('id', 'desc')->limit(100)->get();
        return view('backend.posts')->with('posts', $posts)->with('date', date('m/d/Y'));
    }

    public function get_posts_date($date)
    {
        try {
            $date = Carbon::parse($date)->toDateString();

            $posts = ModelPosts::whereDate('date', '=', $date)
                ->where('active', 1)
                ->limit(500)->get();
            return view('backend.posts')->with('posts', $posts)->with('date', Carbon::parse($date)->format('m/d/Y'));
        } catch (\Exception $e) {
            return redirect('/admin/posts/');
        }
    }

    public function get_add_posts()
    {
        $categories = ModelCategory::where('active', '1')->select('category.*')->get();
        $positions = ModelPosition::where('active', '1')->select('position.*')->get();
        $date = Carbon::now();
        return view('backend.add_posts', [
            'categories' => $categories,
            'positions' => $positions,
            'date' => $date,
        ]);
    }

    public function get_edit_posts($slug)
    {
        $basePosts = ModelPosts::where('slug', $slug)->first();
        if (!isset($basePosts)) return redirect('/admin/posts');
        $categories = ModelCategory::where('active', '1')->select('category.*')->get();
        $positions = ModelPosition::where('active', '1')->select('position.*')->get();
        $basePostsPositions = ModelPostPosition::select('position_id')->where('posts_id', $basePosts->id)->get();
        Helpers::objectToArray($basePostsPositions, 1, "position_id");
        $images = ModelPostImages::where('post', $basePosts->id)->get();
        $count = (is_array($images)) ? count($images) : 0;
        return view('backend.edit_posts')
            ->with('categories', $categories)
            ->with('positions', $positions)
            ->with('basePosts', $basePosts)
            ->with('basePostsPositions', $basePostsPositions)
            ->with('images', $images)
            ->with('count', $count);
    }

    // page
    public function get_page()
    {
        $pages = ModelPage::where('active', '>=', '0')->select('page.*')->orderBy('id', 'desc')->get();
        return view('backend.page')->with('pages', $pages);
    }

    public function get_add_page()
    {
        return view('backend.add_page');
    }

    public function get_edit_page($slug)
    {
        $basePage = ModelPage::where('slug', $slug)->first();
        if (!isset($basePage)) return redirect('/admin/page');
        return view('backend.edit_page')->with('basePage', $basePage);
    }

    // ads
    public function get_ads()
    {
        $ads = ModelAds::select('*')->orderBy('id', 'desc')->get();
        return view('backend.ads')->with('ads', $ads);
    }

    public function get_add_ads()
    {
        return view('backend.add_ads');
    }

    public function get_edit_ads($id)
    {
        $baseAds = ModelAds::where('id', $id)->first();
        if (!isset($baseAds)) return redirect('/admin/ads');
        return view('backend.edit_ads')->with('baseAds', $baseAds);
    }

    // voting
    public function get_voting()
    {
        $voting = ModelQuestions::select('*')->orderBy('id', 'desc')->get();
        return view('backend.voting')->with('voting', $voting);
    }

    public function get_add_voting()
    {
        return view('backend.add_voting');
    }

    public function get_edit_voting($id)
    {
        $baseVoting = ModelQuestions::where('id', $id)->first();
        if (!isset($baseVoting)) return redirect('/admin/voting');

        return view('backend.edit_voting')->with('baseVoting', $baseVoting);
    }

    // document
    public function get_document()
    {
        $document = ModelDocuments::select('*')->orderBy('id', 'desc')->get();
        return view('backend.document')->with('document', $document);
    }

    public function get_add_document()
    {
        return view('backend.add_document');
    }

    public function get_edit_document($id)
    {
        if ((int)$id == 0) return redirect('/admin/document');
        $baseDocument = ModelDocuments::where('id', $id)->first();
        if (!isset($baseDocument)) return redirect('/admin/document');
        return view('backend.edit_document')->with('baseDocument', $baseDocument);
    }

}
