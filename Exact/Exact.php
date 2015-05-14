<?php
	namespace Exact;

	/**
	 * Class Exact
	 *
	 * @package Exact
	 */
	class Exact
	{
		/**
		 * @var string
		 */
		private $apiUrl = 'https://start.exactonline.{tld}/api/{version}';

		/**
		 * @var string
		 */
		private $apiUrlTld = 'nl';

		/**
		 * @var string
		 */
		private $apiVersion = 'v1';

		/**
		 * @var string
		 */
		private $authUrl = 'https://start.exactonline.{tld}/api/oauth2/auth';

		/**
		 * @var string
		 */
		protected $clientId = 'b81cc4de-d192-400e-bcb4-09254394c52a';

		/**
		 * @var string
		 */
		protected $clientSecret = 'n3G7KAhcv8OH';

		/**
		 * @var string
		 */
		protected $callbackUri = '';

		/**
		 * @param $clientId
		 * @param $clientSecret
		 */
		public function __construct($clientId, $clientSecret)
		{
			$this->clientId     = $clientId;
			$this->clientSecret = $clientSecret;

			$this->setApiUrl();
			$this->setAuthUrl();
		}

		/**
		 * @param $endpoint
		 * @param $data
		 *
		 * @return mixed
		 */
		public function get($endpoint, $data)
		{
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $endpoint . '?' . http_build_query($data));
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			$response = curl_exec($ch);

			curl_close($ch);

			return $response;
		}

		/**
		 * @param $endpoint
		 * @param $data
		 *
		 * @return mixed
		 */
		public function put($endpoint, $data)
		{
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $endpoint);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);

			$response = curl_exec($ch);

			curl_close($ch);

			return $this->parseResponse($response);
		}

		/**
		 * @param $endpoint
		 * @param $data
		 *
		 * @return mixed
		 */
		public function post($endpoint, $data)
		{
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $endpoint);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);

			$response = curl_exec($ch);

			curl_close($ch);

			return $this->parseResponse($response);
		}

		/**
		 * @param $endpoint
		 * @param $data
		 *
		 * @return mixed
		 */
		public function delete($endpoint, $data)
		{
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $endpoint);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);

			$response = curl_exec($ch);

			curl_close($ch);

			return $this->parseResponse($response);
		}

		/**
		 * @param $response
		 *
		 * @return mixed
		 */
		private function parseResponse($response)
		{
			$parsed = json_decode($response);

			return $parsed;
		}

		/**
		 * @param $callbackUri
		 *
		 * @return string
		 */
		public function getAuthUrl($callbackUri)
		{
			$data = [
				'client_id'     => $this->clientId,
				'redirect_url'  => $callbackUri,
				'response_type' => 'code',
				'force_login'   => 1
			];

			return $this->authUrl . '?' . http_build_query($data);
		}

		/**
		 * @param $code
		 * @param $callbackUri
		 */
		public function getAuthToken($code, $callbackUri)
		{

		}

		/**
		 *
		 */
		private function setApiUrl()
		{
			$this->apiUrl = str_replace(
				[
					'{tld}',
					'{version}'
				],
				[
					$this->apiUrlTld,
					$this->apiVersion
				],
				$this->apiUrl);
		}

		/**
		 *
		 */
		private function setAuthUrl()
		{
			$this->authUrl = str_replace(
				[
					'{tld}'
				],
				[
					$this->apiUrlTld
				],
				$this->authUrl);
		}
	}