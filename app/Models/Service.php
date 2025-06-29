<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class service extends Model
{
    protected $table = 'services_annonce';

    protected $fillable = [
        'annonce_id', 'type'
    ];

    public function annonce()
    {
        return $this->belongsTo(annonces::class);
    }
}
