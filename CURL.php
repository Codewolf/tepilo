<?php

namespace core;

/**
 * Class CURL
 *
 * This class facilitates CURL requests
 */
class CURL
{

	/**
	 * CURL Default Options.
	 *
	 * VerifyPeer is set to false to deal with self signed certificates, in production this would be set to TRUE.
	 */
	const DEFAULT_CURL = [
		CURLOPT_RETURNTRANSFER => TRUE,
		CURLOPT_SSL_VERIFYPEER => FALSE,
	];

	/**
	 * Execute the cURL Request.
	 *
	 * @param array $curlOpts cURL Options.
	 *
	 * @return mixed
	 * @throws \Exception On cURL error.
	 */
	private static function _exec(array $curlOpts)
	{
		$c = curl_init();
		curl_setopt_array($c, (self::DEFAULT_CURL + $curlOpts));
		$result = curl_exec($c);
		if(FALSE === $result) {
			throw new \Exception(curl_error($c), curl_errno($c));
		}
		if(curl_getinfo($c, CURLINFO_CONTENT_TYPE) === "application/json") {
			if(!json_decode($result)) {
				throw new \Exception("Returned Data is not valid JSON:{$result}", 400);
			}
			$code = curl_getinfo($c, CURLINFO_HTTP_CODE);
			curl_close($c);
			return (object)[
				"result" => $result,
				"code" => $code,
			];
		} else {
			curl_close($c);
			return $result;
		}
	}

	/** Send  cURL POST request.
	 *
	 * @param  string $uri URL to post data to.
	 * @param  mixed $postFields POST parameters.
	 * @param  array $curlOpts CURL Additional Options.
	 * @param  array $header HTTP Header to send.
	 *
	 * @return object
	 * @throws \Exception If no URL is set.
	 */
	public static function POST($uri, $postFields, array $curlOpts = [], array $header = [])
	{
		if(trim($uri) != '') {
			$curlOpts += (
				[
					CURLOPT_URL => $uri,
					CURLOPT_POST => TRUE,
					CURLOPT_POSTFIELDS => (is_array($postFields)) ? http_build_query($postFields) : $postFields,
				] + $header
			);
			return self::_exec($curlOpts);
		} else {
			throw new \Exception("URI can not be empty", 400);
		}
	}

	/** Send  cURL PUT request.
	 *
	 * @param  string $uri URL to post data to.
	 * @param  array $postFields PUT parameters.
	 * @param  array $curlOpts CURL Additional Options.
	 * @param  array $header HTTP Header to send.
	 *
	 * @return object
	 * @throws \Exception If no URL is set.
	 */
	public static function PUT($uri, array $postFields, array $curlOpts = [], array $header = [])
	{
		if(trim($uri) != '') {
			$curlOpts += (
				[
					CURLOPT_URL => $uri,
					CURLOPT_CUSTOMREQUEST => "PUT",
					CURLOPT_POSTFIELDS => (is_array($postFields)) ? http_build_query($postFields) : $postFields,
				] + $header
			);
			return self::_exec($curlOpts);
		} else {
			throw new \Exception("URI can not be empty", 400);
		}
	}

	/** Send  cURL GET request.
	 *
	 * @param  string $uri URL to post data to.
	 * @param  array $curlOpts CURL Additional Options.
	 * @param  array $header HTTP Header to send.
	 *
	 * @return object
	 * @throws \Exception If no URL is set.
	 */
	public static function GET($uri, array $curlOpts = [], array $header = [])
	{
		if(trim($uri) != '') {
			$curlOpts += ([CURLOPT_URL => $uri] + $header);
			return self::_exec($curlOpts);
		} else {
			throw new \Exception("URI can not be empty", 400);
		}
	}
}