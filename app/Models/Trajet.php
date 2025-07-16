<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trajet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pays_depart_id',
        'pays_arrivee_id',
        'ville_depart',
        'ville_arrivee',
        'date_depart',
        'date_arrivee',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'pays_depart_id' => 'integer',
            'pays_arrivee_id' => 'integer',
            'date_depart' => 'date',
            'date_arrivee' => 'date',
        ];
    }

    public function paysDepart(): BelongsTo
    {
        return $this->belongsTo(Pay::class);
    }

    public function paysArrivee(): BelongsTo
    {
        return $this->belongsTo(Pay::class);
    }
}
