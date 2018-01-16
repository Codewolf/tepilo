<?php
/**
 * Copyright (c) Matt Nunn - All Rights Reserved
 * Unauthorized copying of this file via any medium is strictly prohibited
 * Written by Matt Nunn <MH.Nunn@gmail.com> 2018.
 */

namespace core;


/**
 * Class Lead
 * @package core
 */
class Lead implements \JsonSerializable
{
	/**
	 * @var string Lead Name.
	 */
	private $_name;

	/**
	 * @var string Lead URL.
	 */
	private $_url;

	/**
	 * @var string Lead Description.
	 */
	private $_description;

	/**
	 * @var string Lead Status ID.
	 */
	private $_statusId;

	/**
	 * @var Contact[] Array of contacts.
	 */
	private $_contacts;

	/**
	 * Lead constructor.
	 * @param string $name Lead Name.
	 * @param string $url (optional) Lead URL.
	 * @param string $description (optional) Lead Description.
	 * @param string $statusId (optional) Lead Status ID.
	 * @param array $contacts (optional) Array of contacts.
	 */
	public function __construct(string $name, string $url = '', string $description = '', string $statusId = '', $contacts = [])
	{
		$this->_name = $name;
		$this->_url = $url;
		$this->_description = $description;
		$this->_statusId = $statusId;
		$this->_contacts = $contacts;
	}

	/**
	 * @param Contact $contact
	 * @return Lead
	 */
	public function addContact(Contact $contact)
	{
		$this->_contacts += $contact;
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
			"url" => $this->_url,
			"description" => $this->_description,
			"status_id" => $this->_statusId,
			"contacts" => $this->_contacts,
		];
	}
}