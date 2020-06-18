<?php

/**
 * Help functions used at project
 */

namespace App\Http;

class Helpers
{
    /**
     * get youtube link, return embed link
     * @param $url
     * @return string
     */
    public static function createEmbedStrin($url)
    {
        $urlParts = explode('/', $url);
        $videoid = explode('&', str_replace('watch?v=', '', end($urlParts)));

        return 'https://www.youtube.com/embed/' . $videoid[0];
    }

    public static function get_category_name($array)
    {
        return (isset($array[0])) ? $array[0]->category_data->name : '';
    }

    public static function get_category_url($array)
    {
        return (isset($array[0])) ? '/category/' . $array[0]->category_data->slug : '';
    }

    public static function getImageUrl($baseUrl, $type = 'original')
    {
        $path = $baseUrl;
        $url = explode('/', $baseUrl);
        if (count($url) == 0)
            return '/uploads/img/no_image.png';

        if (in_array($type, ['small', 'medium'])) {
            $path = '';
            for ($i = 0; $i < count($url); $i++) {
                $path .= (isset($url[$i + 1])) ? $url[$i] . '/' : $type . '/' . $url[$i];
            }
        }

        if (!file_exists('uploads/' . $path)) {
             $handle = @fopen('http://photos.novoye-vremya.com/photos/nv/' . $baseUrl ,'r');
             if ($handle) {
                 return 'http://photos.novoye-vremya.com/photos/nv/' . $baseUrl;
             } else {
                $path = 'img/no_image.png';
             }
        }

        return '/uploads/'.$path;
    }

    public static function objectToArray(&$object, $type = 0, $field = 'id')
    {
        if ($type == 0) {
            $object = @json_decode(json_encode($object), true);
        } else if ($type == 1) {
            $response = [];
            foreach ($object as $rows) {
                $response[] = $rows->{$field};
            }
            $object = $response;
        }
    }

    public static function sortPostsByCategory($object, $category = false)
    {
        $result = [];
        $categoryId = 0;

        foreach ($object as $item) {
            $categoryId = ($categoryId != $item->category) ? $item->category : $categoryId;

            if (!isset($result[$categoryId])) {
                $result[$categoryId] = [];
            }

            if ($categoryId == $item->category) {
                $result[$categoryId][] = $item;
            }
        }

        return ($category) ? (isset($result[$category]) ? $result[$category] : []) : $result;
    }
}
