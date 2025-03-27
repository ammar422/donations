<?php

namespace Modules\Users\App\Models;


use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Modules\Users\Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

/**
 * @property int|null        $id
 * @property string          $charity_name
 * @property string          $full_name
 * @property string          $first_name
 * @property string          $last_name
 * @property string|null     $email
 * @property string|null     $password
 * @property int|null        $reset_token
 * @property string|null     $mobile
 * @property string          $account_type
 * @property int|null        $admin_group_id
 * @property string|null     $photo
 * @property string|null     $created_at
 * @property string|null     $updated_at
 * @property string|null     $deleted_at
 * @property int|null        $country_id
 * @property string          $account_status
 * @property string|int|null $verification_code
 * @property string          $user_type
 * @property string          $pay_type
 * @property string|int      $total_donations
 * @property string|int      $total_donations_amount
 * @property string|int      $successful_donations
 * @property string|int      $faild_donations
 * @property string|int      $total_campaigns
 * @property string|int      $active_campaigns
 * @property string|int      $pending_donations
 */

class User extends Authenticatable implements MustVerifyEmail, JWTSubject, TranslatableContract
{
    use  HasFactory, Notifiable, SoftDeletes, HasUuids, Translatable;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return      $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return string []
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Translatable attributes.
     *
     * @var array<int, string>
     */
    public $translatedAttributes = [
        //    
    ];


    protected $fillable = [
        'id',
        'full_name',
        'first_name',
        'last_name',
        'email',
        'password',
        'reset_token',
        'mobile',
        'account_type', // admin | user
        'admin_group_id', // admin_group_id
        'photo',
        'created_at',
        'updated_at',
        'deleted_at',
        'account_status',
        'verification_code',
    ];
    /**
     * @var string
     */
    protected $deleted_at = 'deleted_at';


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

        'total_donations'        => 'integer',
        'total_donations_amount' => 'decimal:2',
        'successful_donations'   => 'integer',
        'faild_donations'        => 'integer',
        'total_campaigns'        => 'integer',
        'active_campaigns'       => 'integer',
        'pending_donations'      => 'integer',
    ];



    /**
     * @param string $date
     *
     * @return string|null
     */
    public function getCreatedAtAttribute(?string $date): ?string
    {
        if (!$date) {
            return null;
        }

        $timestamp = strtotime($date);
        return $timestamp !== false ? date('Y-m-d', $timestamp) : null;
    }

    /**
     * Format the updated at date.
     *
     * @param string|null $date
     * @return string|null
     */
    public function getUpdatedAtAttribute(?string $date): ?string
    {
        if (!$date) {
            return null;
        }

        $timestamp = strtotime($date);
        return $timestamp !== false ? date('Y-m-d', $timestamp) : null;
    }

    /**
     * Format the deleted at date.
     *
     * @param string|null $date
     * @return string|null
     */
    public function getDeletedAtAttribute(?string $date): ?string
    {
        if (!$date) {
            return null;
        }

        $timestamp = strtotime($date);
        return $timestamp !== false ? date('Y-m-d', $timestamp) : null;
    }

    /**
     * Format the email verified at date.
     *
     * @param string|null $date
     * @return string|null
     */
    public function getEmailVerifiedAtAttribute(?string $date): ?string
    {
        if (!$date) {
            return null;
        }

        $timestamp = strtotime($date);
        return $timestamp !== false ? date('Y-m-d', $timestamp) : null;
    }


    /**
     * @return HasMany<Model>
     */
    public function translations(): HasMany
    {
        return $this->hasMany(\Modules\Users\App\Models\UserTranslation::class);
    }


    /**
     * @return MorphMany<\Dash\Models\FileManagerModel , self>
     */
    public function files(): MorphMany
    {
        return $this->morphMany(\Dash\Models\FileManagerModel::class, 'file');
    }

    /**
     * @return BelongsTo<AdminGroup,User>
     */
    public function admingroup(): BelongsTo
    {
        return $this->belongsTo(AdminGroup::class, 'admin_group_id');
    }


    /**
     * @return UserFactory
     */
    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
