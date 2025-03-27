<?php

namespace Modules\Users\App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminGroup extends Model
{
    use HasFactory, HasUuids; 

    protected $fillable = [
        'id',
        'name',
    ];


    /**
     * @return HasMany<AdminGroupRole , self >
     */
    public function roles(): HasMany
    {
        return $this->hasMany(AdminGroupRole::class, 'admin_group_id', 'id'); 
    }
}
