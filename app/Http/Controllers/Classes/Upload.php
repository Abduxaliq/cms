<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 18.04.2019
 * Time: 5:18 PM
 */

namespace App\Http\Controllers\Classes;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Upload
{
    protected $path;
    protected $options;
    private $allowedExtentions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'gif', 'GIF', 'png', 'PNG', 'pdf', 'swf'];

    public function __construct()
    {
        $this->options = [
            'disk' => 'uploads',
            'small' => true,
            'medium' => true,
            'original' => true
        ];
    }

    public function setOptions($options)
    {
        $this->options = $options;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function delete($path)
    {
        Storage::disk($this->options['disk'])->delete($path);
    }

    public function saveAndUpload($savedObj, $path)
    {
        $this->delete($path);
        return $this->save($savedObj);
    }

    public function save($savedObj)
    {
        // set path
        $image_dir_name = $this->path;

        // making unique name of image
        $image_ext = $savedObj->getClientOriginalExtension();
        $image_original_name = $savedObj->getClientOriginalName();
        $image_name = str_replace('.', '', $image_original_name) . '-' . time() . '.' . $image_ext;

        // check extentions
        if (!in_array($image_ext, $this->allowedExtentions)) {
            return false;
        }

        // saving process
        Storage::disk($this->options['disk'])->makeDirectory($image_dir_name);

        if ($this->options['original']) {
            Storage::disk($this->options['disk'])->put($image_dir_name . '/' . $image_name, file_get_contents($savedObj));
        }
        if ($this->options['small']) {
            Storage::disk($this->options['disk'])->makeDirectory($image_dir_name . '/small/');
            Image::make($savedObj->getRealPath())
                ->resize(80, 55)
                ->save($this->options['disk'] . '/' . $image_dir_name . '/small/' . $image_name);
        }
        if ($this->options['medium']) {
            Storage::disk($this->options['disk'])->makeDirectory($image_dir_name . '/medium/');
            Image::make($savedObj->getRealPath())
                ->resize(241, 160)
                ->save($this->options['disk'] . '/' . $image_dir_name . '/medium/' . $image_name);
        }

        // return image name with path
        return $image_dir_name . '/' . $image_name;
    }

}