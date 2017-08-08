<?php
class Helpers
{
	/**
	 * Returns an authorized API client.
	 * @param string $accessToken The access token to be used.
	 * @return Google_Client the authorized client object
	 */
	public static function getGoogleClientForWeb($accessToken)
	{
		$client = self::_getGoogleClient();
		$client->setAccessToken($accessToken);

		// Refresh the token if it's expired.
		if ($client->isAccessTokenExpired()) {
			$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
			file_put_contents(CREDENTIALS_PATH, json_encode($client->getAccessToken()));
		}
		return $client;
	}

	public static function storeInitialAccessToken()
	{
		$client = self::_getGoogleClient();

		// Request authorization from the user.
		$authUrl = $client->createAuthUrl();
		printf("Open the following link in your browser:\n%s\n", $authUrl);
		print 'Enter verification code: ';
		$authCode = trim(fgets(STDIN));

		// Exchange authorization code for an access token.
		$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

		// Store the credentials to disk.
		if(!file_exists(dirname(CREDENTIALS_PATH))) {
		  	mkdir(dirname(CREDENTIALS_PATH), 0700, true);
		}
		file_put_contents(CREDENTIALS_PATH, json_encode($accessToken));
		printf("Credentials saved to %s\n", CREDENTIALS_PATH);
	}

	private static function _getGoogleClient()
	{
		$client = new Google_Client();
		$client->setApplicationName(APPLICATION_NAME);
		$client->setScopes(SCOPES);
		$client->setAuthConfig(CLIENT_SECRET_PATH);
		$client->setAccessType('offline');
		return $client;		
	}

}