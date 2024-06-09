<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Collection;

class Advert extends Model
{
    use HasFactory;
    const ISRENTAL_COLUMN_NAME = "is_rental";
    private const DAYS_UNTIL_EXPIRATION = 30;
    private const DEFAULT_STATUS_NAME = 'available';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Title',
        'Description',
        'owner_id',
        'current_borrower_id',
        'is_rental',
        'expiration_date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($advert) {
            $advert->expiration_date = now()->addDays(Advert::DAYS_UNTIL_EXPIRATION);

            $defaultStatus = PostStatus::where('name', self::DEFAULT_STATUS_NAME)->first();

            if ($defaultStatus) {
                $advert->postStatus()->associate($defaultStatus);
            }
        });
    }

    public function owner() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currentBorrower() : BelongsTo
    {
        return $this->belongsTo(User::class, 'current_borrower_id');
    }

    public function hasCustomUrl() : bool
    {
        return $this->landingspageUrl()->exists();
    }

    public function landingspageUrl() : HasOne
    {
        return $this->hasOne(LandingspageUrl::class);
    }

    public function postStatus() : BelongsTo
    {
        return $this->belongsTo(PostStatus::class);
    }

    public static function getToBeExpiredPosts() : Collection
    {
        $posts = Advert::all()->where('expiratio_date' , '===', now()->toDate())->where('name','===', 'available');

        return $posts;
    }
}
