<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */
class Role extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = [
        'name',
        'slug'
    ];

    public function scopeOfAdmin(Builder $query): Builder
    {
        return $query->where('slug', 'admin');
    }

    public function scopeOfUser(Builder $query): Builder
    {
        return $query->where('slug', 'user');
    }
}
