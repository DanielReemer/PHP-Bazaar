<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    const ROLE_BUSINESS_ADVERTISER = 'Business advertiser';

    protected $table = 'roles';

    protected $fillable = [
        'value',
        'translation_key'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
