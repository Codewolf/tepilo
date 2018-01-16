<?php
/**
 * Copyright (c) Matt Nunn - All Rights Reserved
 * Unauthorized copying of this file via any medium is strictly prohibited
 * Written by Matt Nunn <MH.Nunn@gmail.com> 2018.
 */

namespace core;


class Contact implements \JsonSerializable
{
	/**
	 * @var string Name.
	 */
	private $_name;

	/**
	 * @var Email[] Array of Email Objects.
	 */
	private $_emails = [];

	/**
	 * @var Phone[] Array of Phone Objects.
	 */
	private $_phones = [];

	/**
	 * Contact constructor.
	 * @param string $name Contact Name.
	 */
	public function __construct(string $name)
	{
		$this->_name = $name;
	}

	/**
	 * @param Email $emails Email Object.
	 * @return Contact
	 */
	public function addEmail(Email $emails)
	{
		array_push($this->_emails, $emails);
		return $this;
	}

	/**
	 * @param Phone $phone Phone Object.
	 * @return Contact
	 */
	public function addPhone(Phone $phone)
	{
		array_push($this->_phones, $phone);
		return $this;
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
			"name" => $this->_name,
			"emails" => $this->_emails,
			"phones" => $this->_phones,
		];
	}
}
