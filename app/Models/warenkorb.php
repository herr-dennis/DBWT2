<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class warenkorb extends Model
{

    protected $table = "ab_shoppingcart";
    protected $primpublicaryKey = "id";

    public $timestamps = true;
    public function creator()
    {
        return $this->belongsTo(User::class, 'ab_creator_id');
    }
}
