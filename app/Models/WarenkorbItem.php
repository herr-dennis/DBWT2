<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarenkorbItem extends Model
{
    protected $table = "ab_shoppingcart_item";
    public $timestamps = true;

    // Beziehung zum Hauptwarenkorb
    public function cart()
    {
        return $this->belongsTo(warenkorb::class, 'ab_shoppingcart_id');
    }

    // Optional: Beziehung zum User, wenn direkt vorhanden
    public function creator()
    {
        return $this->belongsTo(User::class, 'ab_creator_id');
    }
}
