<?php

namespace App\Models\Budvar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected  $connection='no';
    //use HasFactory;
    public function getId()
    {
        return $this->_id;
    }
}
