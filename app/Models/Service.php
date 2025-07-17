<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class service extends Model
{
    protected $table = 'services';

    protected $guarded = [];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }
}
