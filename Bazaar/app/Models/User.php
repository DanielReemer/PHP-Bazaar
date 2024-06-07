<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            if ($user->role->value == Role::ROLE_BUSINESS_ADVERTISER) {
                $user->is_admin = true;
                $user->api_key = bin2hex(random_bytes(30));
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'api_key',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_key',
        'is_admin',
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

    public function adverts() : HasMany
    {
        return $this->hasMany(Advert::class, 'owner_id');
    }

    public function countAdverts(bool $isRental = false) : int
    {
        $numOfAdverts = $this->adverts()->where(Advert::ISRENTAL_COLUMN_NAME, (int) $isRental)->count();

        return $numOfAdverts;
    }

    public function deleteAllAdverts() : void
    {
        $this->adverts()->delete();

        return;
    }

    public function deleteRentalAdverts() : void
    {
        $this->adverts()->where(Advert::ISRENTAL_COLUMN_NAME, 1)->delete();

        return;
    }

    public function deleteNormalAdverts() : void
    {
        $this->adverts()->where(Advert::ISRENTAL_COLUMN_NAME, 0)->delete();

        return;
    }

    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPostRights() : bool
    {
        $role = $this->role()->first();
        return $role ? (bool)$role->hasPostRights : false;
    }

    public function userReviews()
    {
        return $this->hasMany(UserReview::class);
    }
}
