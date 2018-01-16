<?php
/**
 * Copyright (c) Matt Nunn - All Rights Reserved
 * Unauthorized copying of this file via any medium is strictly prohibited
 * Written by Matt Nunn <MH.Nunn@gmail.com> 2018.
 */

namespace core;


/**
 * Class Phones
 * @package core
 */
class Phone implements \JsonSerializable
{
	/**
	 * @var string Phone Type.
	 */
	private $_type;
	/**
	 * @var string Phone Number.
	 */
	private $_phone;

	/**
	 * Phones constructor.
	 * @param string $type Phone type.
	 * @param string $phone Phone Number.
	 */
	public function __construct(string $type, string $phone)
	{
		$this->_type = $type;
		$this->_phone = $phone;
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
	public function getPhone(): string
	{
		return $this->_phone;
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
			"phone" => $this->_phone,
		];
	}
}