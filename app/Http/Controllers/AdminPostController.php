<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\Upload;
use App\Http\Helpers;
use App\ModelAds;
use App\ModelAnswers;
use App\ModelCategory;
use App\ModelDocuments;
use App\ModelMenus;
use App\ModelPage;
use App\ModelPosition;
use App\ModelPostImages;
use App\ModelPostPosition;
use App\ModelPosts;
use App\ModelQuestions;
use App\ModelSettings;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AdminPostController extends AdminController
{
    public function post_login()
    {
        $this->validate(request(), [
            "email" => "required|email",
            "pass" => "required"
        ]);

        if (auth()->attempt(['email' => request('email'), 'password' => request('pass')], 0)) {
            request()->session()->regenerate();
            $userData = User::where('email', request('email'))->first();
            session(['email' => request('email'), 'fullname' => $userData->fullname]);
            return redirect()->intended('/admin');
        } else {
            $errors = ['email' => 'Məlumatları yoxlayın...'];
            return back()->withErrors($errors);
        }
    }

    public function post_settings(Request $request)
    {
        $logo_name = "";
        if (isset($request->logo)) {
            $validator = Validator::make($request->all(), [
                'logo' => 'mimes:jpg,jpeg,png,gif'
            ]);
            if ($validator->fails()) {
                return ['title' => 'Uğursuz!', 'description' => 'Şəkil formatı uyğun deyil!', 'status' => 'error'];
            }

            $logo = Input::file('logo');
            $logo_ext = Input::file('logo')->getClientOriginalExtension();
            $logo_name = 'logo.' . $logo_ext;
            Storage::disk('uploads')->makeDirectory('img');
            Image::make($logo->getRealPath())->save('uploads/img/' . $logo_name);
        }

        try {
            $last_logo = $request['last_logo'];
            unset($request['_token']);
            unset($request['last_logo']);
            $request['video'] = Helpers::createEmbedStrin($request['video']);

            if (!isset($request['logo']) || $request['logo'] == '') {
                $logo_name = $last_logo;
            }

            ModelSettings::where('id', 1)->update($request->all());
            ModelSettings::where('id', 1)->update(['logo' => $logo_name]);

            return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla sona çatdı!', 'status' => 'success', 'img' => $logo_name];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!' . $e->getMessage(), 'status' => 'error'];
        }
    }

    // menus
    public function post_menus_delete(Request $request)
    {
        try {
            ModelMenus::where('slug', $request->slug)->delete();

            return ['title' => 'Uğurlu!', 'description' => 'Silindi!', 'status' => 'success'];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Silmə zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    public function post_add_menu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'parent_id' => 'required'
        ]);
        if ($validator->fails()) {
            return ['title' => 'Uğursuz!', 'description' => 'Daxil etdiyiniz məlumatları yoxlayın!', 'status' => 'error'];
        }

        try {
            unset($request['_token']);
            $slug = str_slug($request['name']) . time();
            $foreign_key = 0;
            $type = 0;

            if ($request->foreign_key1 > 0) {
                $foreign_key = $request->foreign_key1;
                $type = 1;
            } else if ($request->foreign_key2 > 0) {
                $foreign_key = $request->foreign_key2;
                $type = 2;
            }

            $request->merge(['slug' => $slug, 'foreign_key' => $foreign_key, 'type' => $type]);

            ModelMenus::create($request->all());

            return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla sona çatdı!', 'status' => 'success'];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    public function post_edit_menu($slug, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'parent_id' => 'required'
        ]);
        if ($validator->fails()) {
            return ['title' => 'Uğursuz!', 'description' => 'Daxil etdiyiniz məlumatları yoxlayın!', 'status' => 'error'];
        }

        try {
            unset($request['_token']);
            $foreign_key = 0;
            $type = 0;

            if ($request->foreign_key1 > 0) {
                $foreign_key = $request->foreign_key1;
                $type = 1;
            } else if ($request->foreign_key2 > 0) {
                $foreign_key = $request->foreign_key2;
                $type = 2;
            }

            $request->merge(['foreign_key' => $foreign_key, 'type' => $type]);


            ModelMenus::where('slug', $slug)->update([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'foreign_key' => $foreign_key,
                'type' => $type,
                'rank' => $request->rank,
                'active' => $request->active
            ]);

            return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla dəyişdirildi!', 'status' => 'success'];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    // category
    public function post_category_delete(Request $request)
    {
        try {
            $category = ModelCategory::where('slug', $request->slug)->first();
            ModelCategory::where('slug', $request->slug)->delete();
            Storage::disk('uploads')->delete('img/category/' . $category->image);

            return ['title' => 'Uğurlu!', 'description' => 'Silindi!', 'status' => 'success'];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Silmə zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    public function post_add_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'parent_id' => 'required'
        ]);
        if ($validator->fails()) {
            return ['title' => 'Uğursuz!', 'description' => 'Daxil etdiyiniz məlumatları yoxlayın!', 'status' => 'error'];
        }

        $time = str_slug(Carbon::now());
        $slug = str_slug($request['name']) . '-' . $time;
        $image_name = '';

        if (isset($request->imageUpl)) {
            $image = Input::file('imageUpl');
            $image_ext = Input::file('imageUpl')->getClientOriginalExtension();
            $image_name = 'image_' . $time . '.' . $image_ext;
            Storage::disk('uploads')->makeDirectory('img/category');
            Image::make($image->getRealPath())->save('uploads/img/category/' . $image_name);
        }

        try {
            unset($request['_token']);

            $request->merge(['slug' => $slug, 'image' => $image_name]);

            ModelCategory::create($request->all());

            return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla sona çatdı!', 'status' => 'success'];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    public function post_edit_category($slug, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'parent_id' => 'required',
            'image' => 'mimes:jpg,jpeg,png,gif'
        ]);
        if ($validator->fails()) {
            return ['title' => 'Uğursuz!', 'description' => 'Daxil etdiyiniz məlumatları yoxlayın!', 'status' => 'error'];
        }
        if ($validator->fails()) {
            return ['title' => 'Uğursuz!', 'description' => 'Daxil etdiyiniz məlumatları yoxlayın!', 'status' => 'error'];
        }
        $image_name = '';
        $time = str_slug(Carbon::now());

        if (isset($request->imageUpl)) {
            $image = Input::file('imageUpl');
            $image_ext = Input::file('imageUpl')->getClientOriginalExtension();
            $image_name = 'image_' . $time . '.' . $image_ext;
            Storage::disk('uploads')->makeDirectory('img/category');
            Image::make($image->getRealPath())->save('uploads/img/category/' . $image_name);
        }

        try {
            $last_image = $request['last_image'];
            unset($request['last_image']);
            unset($request['_token']);

            if (!isset($request->imageUpl)) {
                $image_name = $last_image;
            }

            ModelCategory::where('slug', $slug)->update([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'image' => $image_name,
                'style' => $request->style,
                'active' => $request->active
            ]);

            return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla dəyişdirildi!', 'status' => 'success'];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    // position
    public function post_position_delete(Request $request)
    {
        try {
            ModelPosition::where('slug', $request->slug)->delete();

            return ['title' => 'Uğurlu!', 'description' => 'Silindi!', 'status' => 'success'];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Silmə zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    public function post_add_position(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return ['title' => 'Uğursuz!', 'description' => 'Daxil etdiyiniz məlumatları yoxlayın!', 'status' => 'error'];
        }

        $time = str_slug(Carbon::now());
        $slug = str_slug($request['name']) . '-' . $time;

        try {
            unset($request['_token']);

            $request->merge(['slug' => $slug]);

            ModelPosition::create($request->all());

            return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla sona çatdı!', 'status' => 'success'];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    public function post_edit_position($slug, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return ['title' => 'Uğursuz!', 'description' => 'Daxil etdiyiniz məlumatları yoxlayın!', 'status' => 'error'];
        }

        try {
            unset($request['_token']);

            ModelPosition::where('slug', $slug)->update([
                'name' => $request->name,
                'active' => $request->active
            ]);

            return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla dəyişdirildi!', 'status' => 'success'];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    // posts
    public function post_posts_delete(Request $request)
    {
        try {
            ModelPosts::where('slug', $request->slug)->delete();
            Storage::disk('uploads')->deleteDirectory('img/posts/' . $request->slug);

            return ['title' => 'Uğurlu!', 'description' => 'Silindi!', 'status' => 'success'];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Silmə zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function post_add_posts(Request $request, Upload $upload)
    {
        $validator = Validator::make($request->all(), [
            // 'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required'
        ]);
        if ($validator->fails()) {
            return ['title' => 'Uğursuz!', 'description' => 'Daxil etdiyiniz məlumatları yoxlayın!', 'status' => 'error'];
        }

        $time = str_slug(Carbon::now());
        $slug = str_slug(strip_tags($request['title'] != "" ? $request['title'] : $request['short_title'])) . '-' . $time;
        $image = [];

        try {
            unset($request['_token']);

            $request->merge(['slug' => $slug]);

            if ($request->file('base_image_file') && $request->file('base_image_file')->isValid()) {
                $base_image = $request->file('base_image_file');
                $upload->setPath('img/posts/' . date('Y') . '/' . date('m') . '/' . date('d'));
                $base_path = $upload->save($base_image);

                $request->merge(['image' => $base_path]);
            }

            $posts = ModelPosts::create($request->all());

            if ($request->hasFile('images') && $posts->id > 0) {
                $images = $request->file('images');

                foreach ($images as $image) {
                    $upload->setPath('img/posts/' . date('Y') . '/' . date('m') . '/' . date('d'));
                    $path = $upload->save($image);

                    $data = [
                        'post' => $posts->id,
                        'url' => $path,
                        'active' => 1
                    ];
                    ModelPostImages::create($data);
                }
            }

            if ($request->has('positions') && count($request->positions) > 0) {
                foreach ($request->positions as $position_id) {
                    $data = [
                        'posts_id' => $posts->id,
                        'position_id' => $position_id
                    ];
                    ModelPostPosition::create($data);
                }
            }

            return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla sona çatdı!', 'status' => 'success'];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!' . $e->getMessage(), 'status' => 'error'];
        }
    }

    public function post_edit_posts($slug, Request $request, Upload $upload)
    {
        if (isset($request->path)) {
            try {
                $upload->delete($request->path);

                return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla dəyişdirildi!', 'status' => 'success'];
            } catch (\Exception $e) {
                return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!', 'status' => 'error'];
            }
        } else {
            $validator = Validator::make($request->all(), [
                // 'title' => 'required|max:255',
                'content' => 'required',
                'category' => 'required'
            ]);
            if ($validator->fails()) {
                return ['title' => 'Uğursuz!', 'description' => 'Daxil etdiyiniz məlumatları yoxlayın!', 'status' => 'error'];
            }
            $baseImage = $request['base_image'];

            try {
                unset($request['_token']);

                if ($request->file('base_image_file') && $request->file('base_image_file')->isValid()) {
                    $base_image = $request->file('base_image_file');
                    $upload->setPath('img/posts/' . date('Y') . '/' . date('m') . '/' . date('d'));
                    $baseImage = $upload->save($base_image);
                }

                $posts = ModelPosts::updateOrCreate(['slug' => $slug], [
                    'category' => $request['category'],
                    'title' => $request['title'],
                    'short_title' => $request['short_title'],
                    'description' => $request['description'],
                    'content' => $request['content'],
                    'author' => $request['author'],
                    'image' => $baseImage,
                    'date' => $request['date'],
                    'tags' => $request['tags'],
                    'active' => 1
                ]);

                if ($request->hasFile('images') && $posts->id > 0) {
                    DB::delete('delete from post_images where post = ?', [$posts->id]);
                    $images = $request->file('images');

                    foreach ($images as $image) {
                        $upload->setPath('img/posts/' . date('Y') . '/' . date('m') . '/' . date('d'));
                        $path = $upload->save($image);

                        $data = [
                            'post' => $posts->id,
                            'url' => $path,
                            'active' => 1
                        ];
                        ModelPostImages::create($data);
                    }
                }

                if ($request->has('positions') && count($request->positions) > 0) {
                    DB::delete('delete from post_position where posts_id = ?', [$posts->id]);

                    foreach ($request->positions as $position_id) {
                        $data = [
                            'posts_id' => $posts->id,
                            'position_id' => $position_id
                        ];
                        ModelPostPosition::create($data);
                    }
                }

                return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla dəyişdirildi!', 'status' => 'success'];
            } catch (\Exception $e) {
                return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!' . $e->getMessage(), 'status' => 'error'];
            }
        }
    }

    // page
    public function post_page_delete(Request $request)
    {
        try {
            ModelPage::where('slug', $request->slug)->delete();

            return ['title' => 'Uğurlu!', 'description' => 'Silindi!', 'status' => 'success'];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Silmə zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    public function post_add_page(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'content' => 'required'
        ]);
        if ($validator->fails()) {
            return ['title' => 'Uğursuz!', 'description' => 'Daxil etdiyiniz məlumatları yoxlayın!', 'status' => 'error'];
        }

        $time = str_slug(Carbon::now());
        $slug = str_slug($request['title']) . '-' . $time;

        try {
            unset($request['_token']);

            $request->merge(['slug' => $slug]);

            ModelPage::create($request->all());

            return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla sona çatdı!', 'status' => 'success'];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    public function post_edit_page($slug, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'content' => 'required'
        ]);
        if ($validator->fails()) {
            return ['title' => 'Uğursuz!', 'description' => 'Daxil etdiyiniz məlumatları yoxlayın!', 'status' => 'error'];
        }
        try {
            unset($request['_token']);

            ModelPage::where('slug', $slug)->update([
                'title' => $request['title'],
                'content' => $request['content'],
                'active' => $request['active']
            ]);

            return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla dəyişdirildi!', 'status' => 'success'];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    // ads
    public function post_ads_delete(Request $request)
    {
        try {
            ModelAds::where('id', $request->id)->delete();

            return ['title' => 'Uğurlu!', 'description' => 'Silindi!', 'status' => 'success'];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Silmə zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    public function post_add_ads(Request $request)
    {
        try {
            unset($request['_token']);

            $ads = ModelAds::create($request->all());

            return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla sona çatdı!', 'status' => 'success', 'id' => $ads->id];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    public function post_edit_ads($id, Request $request)
    {
        try {
            unset($request['_token']);

            ModelAds::where('id', $id)->update([
                'position' => $request->position,
                'script_text' => $request->script_text
            ]);

            return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla dəyişdirildi!', 'status' => 'success', 'id' => $id];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!', 'status' => 'error', 'id' => $id];
        }
    }

    // voting
    public function post_voting_delete(Request $request)
    {
        try {
            if ($request->type == 'delete') {
                ModelAnswers::where('question_id', $request->id)->delete();
                ModelQuestions::where('id', $request->id)->delete();
            } else if ($request->type == 'change') {
                ModelQuestions::where('id', $request->id)->update(['active' => $request->active]);
            }

            return ['title' => 'Uğurlu!', 'description' => 'Silindi!', 'status' => 'success'];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Silmə zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    public function post_add_voting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|max:500'
        ]);
        if ($validator->fails()) {
            return ['title' => 'Uğursuz!', 'description' => 'Daxil etdiyiniz məlumatları yoxlayın!', 'status' => 'error'];
        }

        try {
            unset($request['_token']);

            $voting = ModelQuestions::create($request->all());

            if ($request->has('answer_text') && count($request->answer_text) > 0) {
                foreach ($request->answer_text as $answer) {
                    $data = [
                        'question_id' => $voting->id,
                        'text' => $answer
                    ];
                    ModelAnswers::create($data);
                }
            }

            return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla sona çatdı!', 'status' => 'success', 'id' => $voting->id];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    public function post_edit_voting($id, Request $request)
    {
        try {
            unset($request['_token']);

            ModelQuestions::find($id)->update([
                'text' => $request->text
            ]);

            if ($request->has('answer_text') && count($request['answer_text']) > 0) {
                foreach ($request->answer_text as $answer) {
                    $data = [
                        'question_id' => $id,
                        'text' => $answer['text']
                    ];
                    if ($answer['id'] > 0) {
                        ModelAnswers::find($answer['id'])->update($data);
                    } else {
                        ModelAnswers::create($data);
                    }
                }
            }

            return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla dəyişdirildi!', 'status' => 'success', 'id' => $id];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!',
                'status' => 'error', 'id' => $id
            ];
        }
    }

    // document
    public function post_document_delete(Request $request)
    {
        try {
            ModelDocuments::where('id', $request->id)->delete();

            return ['title' => 'Uğurlu!', 'description' => 'Silindi!', 'status' => 'success'];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Silmə zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    public function post_add_document(Request $request, Upload $upload)
    {
        $validator = Validator::make($request->all(), [
            'pdfUpl' => 'mimes:pdf'
        ]);
        if ($validator->fails()) {
            return ['title' => 'Uğursuz!', 'description' => 'Faylın formatı uyğun deyil!', 'status' => 'error'];
        }

        try {
            unset($request['_token']);

            if ($request->file('pdfUpl') && $request->file('pdfUpl')->isValid()) {
                $document = $request->file('pdfUpl');
                $upload->setOptions([
                    'disk' => 'documents',
                    'small' => false,
                    'medium' => false,
                    'original' => true
                ]);
                $upload->setPath('pdf');
                $base_path = $upload->save($document);

                $request->merge(['path' => $base_path]);
            } else {
                return ['title' => 'Uğursuz!', 'description' => 'Fayl seçin!', 'status' => 'error'];
            }

            $document = ModelDocuments::create($request->all());

            return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla sona çatdı!', 'status' => 'success', 'id' => $document->id];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!', 'status' => 'error'];
        }
    }

    public function post_edit_document($id, Request $request, Upload $upload)
    {
        try {
            unset($request['_token']);
            $base_path = ($request->has('path')) ? $request->path : "";
            if ($request->file('pdfUpl') && $request->file('pdfUpl')->isValid()) {
                $document = $request->file('pdfUpl');
                $upload->setOptions([
                    'disk' => 'documents',
                    'small' => false,
                    'medium' => false,
                    'original' => true
                ]);
                $upload->setPath('pdf');
                $base_path = $upload->save($document);

                if(!$base_path) {
                    return ['title' => 'Uğursuz!', 'description' => 'Faylın formatı uyğun deyil!', 'status' => 'error'];
                }
            }

            ModelDocuments::where('id', $id)->update([
                'path' => $base_path,
                'name' => $request->name,
                'active' => $request->active
            ]);

            return ['title' => 'Uğurlu!', 'description' => 'Əməliyyat uğurla dəyişdirildi!', 'status' => 'success', 'id' => $id];
        } catch (\Exception $e) {
            return ['title' => 'Uğursuz!', 'description' => 'Əməliyyat zamanı xəta baş verdi!', 'status' => 'error', 'id' => $id];
        }
    }

}
