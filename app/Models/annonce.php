<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class annonces extends Model
{
    use HasFactory;

    protected $table = 'annonces';
    protected $fillable = [
        'nom', 'telephone', 'email', 'entreprise', 'type_transport', 'direction',
        'date_depart', 'date_limite', 'ville_depart', 'ville_arrivee',
        'adresse_collecte', 'adresse_livraison', 'poids', 'dimensions', 'valeur',
        'nombre_colis', 'description', 'budget', 'urgence', 'commentaires',
        'statut', 'active'
    ];
    public function produits()
    {
        return $this->hasMany(produit::class);
    }

    public function services()
    {
        return $this->hasMany(service::class);
    }
}
