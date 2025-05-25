<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ab_articles extends Model
{

    public $timestamps = false;

    protected $table = 'ab_article';
    protected $primaryKey = 'id';


    protected $fillable = [
        'ab_name',
        'ab_price',
        'ab_description',
        'ab_creator_id',
        'ab_createdate',
    ];

}
