<?php

namespace Modules\Users\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserTranslation extends Model
{
    use HasUuids;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'charity_name',
    ];

    /**
     * @return HasOne<Model,self>
     */
    public function translation(): HasOne
    {
        return $this->hasOne(\Modules\Users\App\Models\User::class); 
    }
}
