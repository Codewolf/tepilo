<?php
/**
 * Copyright (c) Matt Nunn - All Rights Reserved
 * Unauthorized copying of this file via any medium is strictly prohibited
 * Written by Matt Nunn <MH.Nunn@gmail.com> 2018.
 */

namespace core;


/**
 * Class Emails
 * @package core
 */
class Email implements \JsonSerializable
{
	/**
	 * @var string Email Type.
	 */
	private $_type;
	/**
	 * @var string Email Address.
	 */
	private $_email;

	/**
	 * Emails constructor.
	 * @param string $type Email type comment.
	 * @param string $email Email address.
	 */
	public function __construct(string $type, string $email)
	{
		$this->_type = $type;
		$this->_email = $email;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->_type;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->_email;
	}

	/**
	 * Specify data which should be serialized to JSON
	 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */
	public function jsonSerialize()
	{
		return [
			"type" => $this->_type,
			"email" => $this->_email,
		];
	}
}