<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produit extends Model
{
     protected $table = 'produits';

    protected $fillable = [
        'annonce_id', 'type', 'designation', 'quantite', 'valeur'
    ];

    public function annonce()
    {
        return $this->belongsTo(annonces::class);
    }
}
