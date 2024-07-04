<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create(array $all)
 * @method static find($id)
 */
class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'ci',
        'name',
        'last_name',
        'address',
        'date_birth',
        'gender',
        'nationality',
        'email',
        'phone',
        'district_id',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'client_user');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}
