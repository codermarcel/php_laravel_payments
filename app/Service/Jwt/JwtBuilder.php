<?php

namespace App\Service\Jwt;

use App\Exceptions\ClientException\JwtException;
use App\Service\Time\Time;
use Lcobucci\JWT\Builder;

class JwtBuilder extends Jwt
{
	private $subject = false;
	private $builder;
	private $time;

	public function __construct($setDefaultTimes = true, $setIdentifier = true)
	{
		$this->builder = new Builder();
		$this->time = Time::now();

		if ($setDefaultTimes)
		{
			$this->setTimes();	
		}

		if ($setIdentifier)
		{
			$this->setIdentifiers();	
		}
	}

	/**
	 * Required Public setters
	 */
	public function setSubject($subject)
	{
		$this->subject = true;

		return $this->set('sub', $subject);
	}

	public function setAudience($audience)
	{
		return $this->set('aud', $audience);
	}

	/**
	 * Generate the token
	 * @return string
	 */
	public function getToken()
	{
		$this->checkRequiredFields();

		$this->builder->sign($this->getSigner(), $this->getSecret());

		return (string) $this->builder->getToken();
	} 

	/**
	 * Set identifiers to invalidate jwts.
	 */
	private function setIdentifiers()
	{
		$this->set('jpk', $this->getPublic());

		return $this;
	}

	/**
	 * Check if owner and subject are set.
	 */
	private function checkRequiredFields()
	{
		if ( ! $this->subject)
		{
			throw JwtException::noSubject();
		}
	}

	/**
	 * Fluent
	 */
	public function setIssuedAt($time)
	{
		$this->builder->setIssuedAt($time);

		return $this;
	}

	/**
	 * Fluent
	 */
	public function setIssuedAtIn($minutes)
	{
		$minutes = 60 * $minutes; //in minutes

		return $this->setIssuedAt($this->time + $minutes);
	}

	/**
	 * Fluent
	 */
	public function setNotBefore($time)
	{
		$this->builder->setNotBefore($time);

		return $this;
	}

	/**
	 * Fluent
	 */
	public function setNotBeforeIn($minutes)
	{
		$minutes = 60 * $minutes; //in minutes

		return $this->setNotBefore($this->time + $minutes);
	}

	/**
	 * Fluent
	 */
	public function setExpiration($time)
	{
		$this->builder->setExpiration($time);

		return $this;
	}

	/**
	 * Fluent
	 */
	public function setExpirationIn($minutes)
	{
		$minutes = 60 * $minutes; //in minutes

		return $this->setExpiration($this->time + $minutes);
	}

	/**
	 * Set iat, nbf and exp
	 */
	private function setTimes($time = null)
	{
		$time = $this->time;

		$this->setIssuedAt($time);
		$this->setNotBefore($time);
		$this->setExpiration($time + $this->getExpireDuration());

		return $this;
	}

	/**
	 * Set a key value pair
	 */
	public function set($key, $value)
	{
		$this->builder->set($key, $value);

		return $this;
	}
}