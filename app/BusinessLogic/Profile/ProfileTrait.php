<?php

namespace App\BusinessLogic\Profile;

trait ProfileTrait
{
	public function setEnabledAttribute($input)
	{
		if ($input === 'true')
		{
			$input = 1;
		}

		$this->attributes['enabled'] = $input;
	}
}
