<?php

namespace Modules\Users\App\Dash\Resources;

use Dash\Resource;
use Illuminate\Validation\Rule;
use Modules\Users\App\Models\User;
use App\Dash\Metrics\Values\AllUsers;
use Modules\Users\App\Policies\Dash\UserPolicy;
use Modules\Countries\App\Dash\Resources\Countries;
use Modules\Campaigns\App\Dash\Resources\DonorCampaignDonations;

/**
 * @property int|string|null $id
 * @property string|null $password
 */
class Users extends Resource
{

    /**
     * @var string
     */
    public static $model = User::class;
    /**
     * @var string
     */
    public static $policy = UserPolicy::class;
    /**
     * @var string
     */
    public static $group = 'Settings.users';
    /**
     * @var bool
     */
    public static $displayInMenu = true;
    /**
     * @var string
     */
    public static $icon = '<i class="fa fa-users"></i>';
    /**
     * @var string
     */
    public static $title = 'full_name';
    /**
     * @var array <string>
     */
    public static $search = [
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
        'country_id',
        'account_status',
        'verification_code',
        'user_type',
    ];

    /**
     * @var array <mixed>
     */
    public static $searchWithRelation = [
        'translation' => ['charity_name'],

    ];

    /**
     * @var array <int>
     */
    public static $lengthMenu = [50, 10, 15, 20, 25, 50, 100];


    /**
     * @return array <string>
     */
    public static function dtButtons()
    {
        return [
            'csv',
            'print',
            'pdf',
            'excel',

        ];
    }

    /**
     * @return string
     */
    public static function customName()
    {
        return __('dash.dooner');
    }

    /**
     * @param User $model
     * 
     * @return object
     */
    public function query($model)
    {
        return $model->where('account_type', 'user')->where('user_type', 'dooner');
    }

    /**
     * @return string []
     */
    public static function vertex()
    {
        return [
            (new AllUsers)->render(),
        ];
    }

    /**
     * @return array <mixed>
     */
    public function fields()
    {
        return [
            //id()->make('ID', 'id')->showInShow(),
            text()->make(__('users::main.user_name'), 'full_name')
                ->ruleWhenCreate('required', 'string', 'min:4')
                ->ruleWhenUpdate('sometimes', 'nullable', 'string', 'min:4')
                ->columnWhenCreate(6)
                ->showInShow(),

            // text
            text()->make(__('users::main.first_name'), 'first_name')
                ->ruleWhenCreate('required', 'string')
                ->ruleWhenUpdate('sometimes', 'nullable', 'string')
                ->columnWhenCreate(6)
                ->showInShow(),

            text()->make(__('users::main.last_name'), 'last_name')
                ->ruleWhenCreate('required', 'string')
                ->ruleWhenUpdate('sometimes', 'nullable', 'string')
                ->columnWhenCreate(6)
                ->showInShow(),


            email()->make(__('users::main.email_address'), 'email')
                ->ruleWhenUpdate([
                    'required',
                    'email' => [Rule::unique('users')->ignore($this->id)],
                ])->ruleWhenCreate('unique:users', 'email')
                ->columnWhenCreate(6),

            tel(__('users::main.mobile'), 'mobile')
                ->ruleWhenCreate('required', 'string', 'unique:users,mobile')
                ->ruleWhenUpdate([
                    'required',
                    'string',
                    'mobile' => [Rule::unique('users')->ignore($this->id)],
                ])
                ->column(4),

            select(__('users::main.account_status'), 'account_status')
                ->options([
                    'pending' => __('users::main.pending'),
                    'active' => __('users::main.active'),
                    'ban' => __('users::main.ban')
                ])
                ->column(6)
                ->f()
                ->rule('required', 'in:pending,active,ban'),

            text(__('users::main.user_type'), 'user_type')
                ->value('dooner')
                ->readonly()
                ->column(6)
                ->f(),

            password()->make(__('users::main.password'), 'password')
                ->whenStore(function () {
                    $password = request('password');
                    return is_string($password) ? bcrypt($password) : null;
                })->whenUpdate(function () {
                    return !empty(request('password')) ? bcrypt(request('password')) : $this->makeVisible('password')->password;  
                })
                ->ruleWhenCreate('required', 'string')
                ->hideInShow()
                ->hideInIndex()
                ->columnWhenCreate(6),

            belongsTo()
                ->make(__('users::main.country'), 'country', Countries::class)
                ->rule('required')
                ->f('name')
                ->columnWhenCreate(6),

            image()->make(__('users::main.photo'), 'photo')
                ->rule('nullable')
                ->path('users/{id}')
                ->column(6)
                ->accept('image/png', 'image/jpeg'),
            // custom()->make('user_type')
            //     ->assign([
            //         'user_type' => [
            //             'name'  => 'dooner'
            //         ]
            //     ])->hideInAll()->view('users::Users.user_type'),

            hasMany(__('users::main.campaignDonations'), 'donorCampaignDonations', DonorCampaignDonations::class)
                ->use('user')
                ->hideInIndex(),
        ];
    }

    /**
     * @return string []
     */
    public function actions()
    {
        return [];
    }

    /**
     * @return string []
     */
    public function filters()
    {
        return [];
    }
}
