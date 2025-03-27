<?php

namespace Modules\Users\App\Dash\Resources;

use Dash\Resource;
use Illuminate\Validation\Rule;
use Modules\Users\App\Models\User;
use App\Dash\Metrics\Values\AllAdmins;
use Modules\Users\App\Policies\Dash\AdminPolicy;
use Modules\Countries\App\Dash\Resources\Countries;

/**
 * @property int|string|null $id
 * @property string|null $password
 */
class Admins extends Resource
{

    /**
     * @var string
     */
    public static $model              = User::class;
    /**
     * @var string
     */
    public static $policy             = AdminPolicy::class;
    /**
     * @var string
     */
    public static $group              = 'Settings.users';
    /**
     * @var bool
     */
    public static $displayInMenu      = true;
    /**
     * @var string
     */
    public static $icon               = '<i class="fa fa-users"></i>';
    /**
     * @var string
     */
    public static $title              = 'name';
    /**
     * @var bool
     */
    public static $appendToMainSearch = false;
    /**
     * @var array <string>
     */
    public static $search             = [
        'id',
        'name',
        'email',
    ];

    /**
     * @return string
     */
    public static function customName()
    {
        return __('dash.admins');
    }

    /**
     * @var array <int>
     */
    public static $lengthMenu        = [50, 10, 15, 20, 25, 50, 100];

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
     * @param User $model
     * 
     * @return object
     */
    public function query($model)
    {
        return $model->where('account_type', 'admin');
    }

    /**
     * @return string []
     */
    public static function vertex()
    {
        return [
            (new AllAdmins)->render(),
        ];
    }

    /**
     * @return array <mixed>
     */
    public function fields()
    {
        return [
            text()->make(__('users::main.user_name'), 'full_name')
                ->orderable(false)
                ->ruleWhenCreate('required', 'string', 'min:4')
                ->ruleWhenUpdate('sometimes', 'nullable', 'string', 'min:4')
                ->column(6)
                ->showInShow(),

            email()->make(__('users::main.email_address'), 'email')
                ->column(6)
                ->ruleWhenUpdate([
                    'required',
                    'email' => [Rule::unique('users')->ignore($this->id)],
                ])->ruleWhenCreate('required', 'unique:users', 'email'),

            password()->make(__('users::main.password'), 'password')
                ->column(6)
                ->whenStore(function () {
                    $password = request('password');
                    return is_string($password) ? bcrypt($password) : null;
                })->whenUpdate(function () {
                    return !empty(request('password')) ? bcrypt(request('password')) : $this->makeVisible('password')->password; 
                })
                ->ruleWhenCreate('required', 'string')
                ->hideInShow()
                ->hideInIndex(),

            tel(__('users::main.mobile'), 'mobile')
                ->ruleWhenCreate('required', 'string', 'unique:users,mobile')
                ->ruleWhenUpdate([
                    'required',
                    'string',
                    'mobile' => [Rule::unique('users')->ignore($this->id)],
                ])
                ->column(6),

            select()->make(__('users::main.account_type'), 'account_type')
                ->selected('admin')
                ->options([
                    'user'  => __('users::main.user'),
                    'admin' => __('users::main.admin'),
                ])
                ->rule('required')
                ->column(6),

            image()->make(__('users::main.photo'), 'photo')
                ->path('users/{id}')
                ->column(6)
                ->accept('image/png', 'image/jpeg'),

            belongsTo()->make(__('users::main.group'), 'admingroup', AdminGroups::class)
                ->rule('required'),

            belongsTo()
                ->make(__('users::main.country'), 'country', Countries::class)
                ->rule('required')
                ->f('name')
                ->columnWhenCreate(6),

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
