<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membre extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'image',
        'designation',
        'fb_link',
        'tw_link',
        'ig_link',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the full name attribute.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * Get the image URL attribute.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-avatar.png');
    }

    /**
     * Check if the member has social links.
     *
     * @return bool
     */
    public function hasSocialLinks()
    {
        return $this->fb_link || $this->tw_link || $this->ig_link;
    }

    /**
     * Get all social links as an array.
     *
     * @return array
     */
    public function getSocialLinks()
    {
        return [
            'facebook' => $this->fb_link,
            'twitter' => $this->tw_link,
            'instagram' => $this->ig_link,
        ];
    }

    /**
     * Scope a query to search members.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('nom', 'like', '%' . $search . '%')
                  ->orWhere('prenom', 'like', '%' . $search . '%')
                  ->orWhere('designation', 'like', '%' . $search . '%');
        });
    }

    /**
     * Scope a query to filter by designation.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $designation
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByDesignation($query, $designation)
    {
        return $query->where('designation', 'like', '%' . $designation . '%');
    }
}