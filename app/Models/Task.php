<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $date_start
 * @property string $date_finish
 * @property string $name
 * @property string $project
 * @property boolean $is_confirmed
 * @property int $user_id
 *
 * @property-read User $user
 *
 */
class Task extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = [
        'date_start',
        'date_finish',
        'name',
        'project',
        'is_confirmed',
        'user_id',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
