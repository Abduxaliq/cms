<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $key = 0;

    /**
     * Check submenu yes/no
     * @param $array
     * @param $id
     * @return int 1/0
     */
    protected function checkParent( $array, $id ) {
        foreach ($array as $elem) {
            if($elem['parent_id'] == $id)
                return 1;
        }
        return 0;
    }

    /**
     * Make manu for Admin
     * @param $data
     * @param int $parent_id
     * @param int $key
     * @param string $level
     * @return string
     */
    protected function makeMenu($data, $parent_id=0, $level=0) {
        $str = '';
        if(strlen($level) > 100)
            return '';

        foreach ($data as $item) {
            if($parent_id == $item['parent_id']) {
                $tab = 'margin-left: '.$level.'%; width:'.(100-$level).'%;';
                $str .= '
                <li style="background-color: #f9f9f9; border: 1px solid #ddd; '.$tab.'">
                    <span class="item" style="width:70%;">' . $item->name . '</span>
                    <span class="item" style="width:10%;">';
                    if ($item->active == 1) {
                        $str .= '<span class="btn btn-xs btn-success p-0 btn-circle" style="border-radius:50%;">&#10004;</span>';
                    }else{
                        $str .= '<span class="btn btn-xs btn-danger p-0 btn-circle" style="border-radius:50%;">x</span>';
                    }
                $str .= '</span>
                    <span class="item" style="width:10%;">
                        <a href="/admin/menus/edit/'.$item->slug.'" class="btn btn-info btn-xs p-0"><i class="fa fa-edit"></i> Edit</a>
                    </span>
                    <span class="item" style="width:10%;">
                        <button onclick="delete_item(this, \''.$item->slug.'\')" class="btn btn-info btn-xs p-0">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </span>
                </li>
                ';
                if($this->checkParent($data, $item['id'])) {
                    $str .= $this->makeMenu($data, $item['id'], $level+3);
                }
            }
        }

        return $str;
    }
}
