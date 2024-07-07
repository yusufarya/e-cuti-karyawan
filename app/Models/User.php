<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $primaryKey = 'nip';
    public $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'nip',
        'fullname',
        'username',
        'gender',
        'phone', 
        'place_of_birth',
        'date_of_birth',
        'address',
        'level_id',
        'is_active',
        'email',
        'password',
        'images',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function user_level(): BelongsTo
    {
        return $this->belongsTo(UserLevel::class, 'level_id', 'id');
    }
}
