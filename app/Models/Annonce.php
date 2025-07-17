<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;

    protected $table = 'annonces';
    protected $guarded = [];
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    public function services()
    {
        return $this->hasMany(service::class);
    }
      const DIRECTIONS = [
        'chine-burundi' => 'Chine → Burundi',
        'burundi-chine' => 'Burundi → Chine'
    ];

    const URGENCES = [
        'normale' => 'Normale',
        'urgent' => 'Urgent',
        'tres-urgent' => 'Très Urgent'
    ];

    const STATUTS = [
        'en_attente' => 'En Attente',
        'en_cours' => 'En Cours',
        'livre' => 'Livré',
        'annule' => 'Annulé'
    ];
        public function scopeActive($query)
    {
        return $query->where('active', true);
    }
        public function scopeDirection($query, $direction)
    {
        return $query->where('direction', $direction);
    }
    public function scopeStatut($query, $statut)
    {
        return $query->where('statut', $statut);
        
    }
        public function scopeUrgent($query)
    {
        return $query->whereIn('urgence', ['urgent', 'tres-urgent']);
    }
        public function getDirectionLabelAttribute()
    {
        return self::DIRECTIONS[$this->direction] ?? $this->direction;
    }
        public function getUrgenceLabelAttribute()
    {
        return self::URGENCES[$this->urgence] ?? $this->urgence;
    }
        public function getStatutLabelAttribute()
    {
        return self::STATUTS[$this->statut] ?? $this->statut;
    }
        public function getStatutClassAttribute()
    {
        $classes = [
            'en_attente' => 'warning',
            'en_cours' => 'primary',
            'livre' => 'success',
            'annule' => 'danger'
        ];

        return $classes[$this->statut] ?? 'secondary';
    }
        public function getUrgenceClassAttribute()
    {
        $classes = [
            'normale' => 'success',
            'urgent' => 'warning',
            'tres-urgent' => 'danger'
        ];

        return $classes[$this->urgence] ?? 'secondary';
    }
        public function getIsExpiredAttribute()
    {
        return false;
    }
        public function getJoursRestantsAttribute()
    {
        if (!$this->date_limite) {
            return null;
        }

        $diff = now()->diffInDays($this->date_limite, false);
        return $diff >= 0 ? $diff : 0;
    }
        public function getPoidsFormateAttribute()
    {
        return $this->poids . ' kg';
    }
        public function getValeurFormateAttribute()
    {
        return $this->valeur ? number_format($this->valeur, 2) . ' USD' : 'Non spécifiée';
    }
        public function getBudgetFormateAttribute()
    {
        return $this->budget ? number_format($this->budget, 2) . ' USD' : 'Non spécifié';
    }


    public function isPast()
    {
        return $this->date_depart < now();
    }


}

