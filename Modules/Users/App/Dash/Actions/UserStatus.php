<?php

namespace Modules\Users\App\Dash\Actions;
//Modules\Users\App\Dash\Actions\UserStatus

use Dash\Extras\Inspector\Action;

class UserStatus extends Action
{

	/**
	 * @return array<string, array<string, array<string, string>>>
	 */
	public static function options()
	{
		//Example
		return [
			'account_status' => [
				'active' => [
					'success' => __('users::main.active_done'),
				],
				'pending' => [
					'warning' => __('users::main.pending_done'),
				],
				'ban' => [
					'danger' => __('users::main.banned_done'),
				]
			],
		];
	}
}
