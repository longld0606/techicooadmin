<?php

/**
 * Created by PhpStorm.
 * User: TRUNGNT
 */

namespace App\Common;

use App\Models\UserConfig;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Class Utility
 * @package App\Commons
 */
class ApiInputModel
{
    public string $title;
    public string $name;
    /*
        val = input,
        number = input type = number
        email = 
        ckeditor = 
        text = 
        select =  
        selectlist =  
        select =  
    */
    public string $type = 'input';
    public string $col = '6';
    public bool $isRequired = false;
    public int $minlength;
    public int $maxlength;
    public string $all_title;
    public mixed $array;
    public string $id_field = 'id';
    public string $val_field = 'title';
    public bool $multiple = false;

    public function __construct() {}

    public static function input($title, $name, $type = 'val', $col = 6,  $isRequired = false, $minlength = 3, $maxlength = 255,)
    {
        $instance = new self();
        $instance->type = $type;
        $instance->title = $title;
        $instance->name = $name;
        $instance->isRequired = $isRequired;
        $instance->minlength = $minlength;
        $instance->maxlength = $maxlength;
        $instance->col = $col;
        return $instance;
    }

    public static function select($title, $name,  $col = 6,  $array = [], $all_title = '',$isRequired = false, $multiple = false)
    {
        $instance = new self();
        $instance->type = 'select';
        $instance->title = $title;
        $instance->name = $name;
        $instance->array = $array;
        $instance->isRequired = $isRequired;
        $instance->all_title = $all_title;
        $instance->multiple = $multiple;
        $instance->col = $col;
        return $instance;
    }
    public static function selectList($title, $name,  $col = 6, $array = [], $all_title = 'Chọn', $id_field = 'id', $val_field = 'title',  $isRequired = false, $multiple = false)
    {
        $instance = new self();
        $instance->type = 'selectlist';
        $instance->title = $title;
        $instance->name = $name;
        $instance->array = $array;
        $instance->isRequired = $isRequired;
        $instance->all_title = $all_title;
        $instance->multiple = $multiple;
        $instance->col = $col;
        $instance->id_field = $id_field;
        $instance->val_field = $val_field;
        return $instance;
    }

    public static function getView($type)
    {
        $view = '_input_val';
        switch ($type) {
            case 'select':
                $view =  '_input_select2';
                break;
            case 'selectlist':
                $view =  '_input_select2_list';
                break;

            case 'date':
                $view =  '_input_date';
                break;
            case 'ckeditor':
                $view =  '_input_ckeditor';
                break;
            case 'text':
                $view =  '_input_text';
                break;
            case 'check':
                $view =  '_input_check';
                break;
            case 'radio':
                $view =  '_input_radio';
                break;
            default:
                $view =  '_input_val';
        }
        return  $view;
    }
 
}
