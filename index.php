<?php

use core\CloseIOWrapper;
use core\Contact;
use core\Email;
use core\Lead;
use core\Phone;

// These would normally be autoloaded, but i am including them here for the purposes of this exercise.
require_once "CURL.php";
require_once "CloseIOWrapper.php";
require_once "Email.php";
require_once "Phone.php";
require_once "Contact.php";
require_once "Lead.php";

// This would normally be validated/cleansed before being processed, but for the purposes of this exercise i'm just passing it straight through.
$email = $_GET['email'];

$emailCheck = CloseIOWrapper::checkEmailExists($email);

// If data was returned.
if(!empty($emailCheck)) {
	foreach($emailCheck as $lead) {
		// Increase Valuation Count.
		$valuation = (isset($lead->{'custom.lcf_GEg9856gXoijAlF67G7ZXDtjSlycfNDxTaSyM6labnW'})) ? ++$lead->{'custom.lcf_GEg9856gXoijAlF67G7ZXDtjSlycfNDxTaSyM6labnW'} : 1;
		CloseIOWrapper::updateValuations($lead->id, $valuation);
	}
} else {
	// We're Creating a new contact, for the purposes of this exercise we're using the data provided in the dev test document, and the email provided above.
	$contactEmail = new Email("office", $email);
	$contactPhone = new Phone("office", "012345123123");
	$contact = (new Contact("Example"))->addEmail($contactEmail)->addPhone($contactPhone);
	$lead = new Lead("Example Lead", "www.tepilo.com", '', 'stat_yE4J4QxxowV6IKNI931O7RrbtTn3iQtYwS9u52l4D2P', $contact);
	CloseIOWrapper::addLead($lead);
}