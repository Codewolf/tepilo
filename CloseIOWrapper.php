<?php
/**
 * Copyright (c) Matt Nunn - All Rights Reserved
 * Unauthorized copying of this file via any medium is strictly prohibited
 * Written by Matt Nunn <MH.Nunn@gmail.com> 2018.
 */

namespace core;


/**
 * Class CloseIOWrapper
 * @package core
 */
class CloseIOWrapper
{
	/**
	 * API KEY
	 */
	private const APIKEY = '0c3edeead013e65fd17a7fcebd4d18e4cbccd96bcae73da84e79c6b5';

	/**
	 * API URI
	 */
	private const URI = 'https://app.close.io/api/v1/';

	/**
	 * Organisation ID
	 */
	private const ORGID = 'orga_ewP1OMNH1nVGxAjRM1S5j6ATb8hikpIyCmYBJmIFcHM';

	/**
	 * Check to see if this email already exists for a lead.
	 *
	 * @param string $email Lead's Email
	 * @return array Leads data if exists, or empty array otherwise.
	 */
	public static function checkEmailExists(string $email): array
	{
		try {
			// This is the query being submitted to the close.io endpoint.
			$query = '?' . http_build_query(
					[
						"organization_id" => self::ORGID,
						"query" => $email,
						"_limit" => 200
					]
				);

			// Process the returned result.
			return self::_processReturnedLeads(json_decode(CURL::GET(self::URI . "lead/" . $query, [CURLOPT_USERPWD => self::APIKEY . ':'])->result));
		} catch(\Exception $e) {
			return ["error" => "Sorry, there was an error: " . $e->getMessage()];
		}
	}

	/**
	 * Process the returned Leads and return Lead Data if it exists or an empty array otherwise.
	 * @param \object $result Result from CURL call.
	 * @return array
	 */
	private static function _processReturnedLeads($result)
	{
		return ($result->total_results && $result->total_results > 0) ? $result->data : [];
	}

	/**
	 * Update the valuation count.
	 * @param string $id Custom field ID.
	 * @param int $newValuations Valuation count.
	 */
	public static function updateValuations(string $id, int $newValuations)
	{
		try {
			echo CURL::PUT(self::URI . "lead/" . $id, ["custom.lcf_GEg9856gXoijAlF67G7ZXDtjSlycfNDxTaSyM6labnW" => $newValuations]);
		} catch(\Exception $e) {
			echo "Unable to update endpoint: " . $e->getMessage();
		}
	}

	/**
	 * Add A lead
	 *
	 * @param Lead $lead A Lead Object.
	 */
	public static function addLead(Lead $lead)
	{
		$leadJson = json_encode($lead);
		$header = [
			'Content-Type: application/json',
			'Content-Length: ' . strlen($leadJson),
		];
		try {

			$result = CURL::POST(self::URI . "lead/", $leadJson, [], $header);
			echo($result->result ?? $result);
		} catch(\Exception $e) {
			echo "Unable to Add new Lead: " . $e->getMessage();
		}
	}
}