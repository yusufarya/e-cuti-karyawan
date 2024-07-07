<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLevel extends Model
{
    use HasFactory;

    public $table = 'user_levels';
    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     * Get all of the Users for the UserLevel
     *
     * @return HasMany
     */
    // public function Users(): HasMany
    // {
    //     return $this->hasMany(User::class, 'level_id', 'id');
    // }
}
