<?php
class Helpers
{
	const MIME_TYPE_FOLDER = 'application/vnd.google-apps.folder';
	const MIME_TYPE_SPREADSHEET = 'application/vnd.google-apps.spreadsheet';

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

	/**
	 * Builds and returns a list of files in the folder identified by its id in $parentId.
	 *
	 * @param Google_Service_Drive $service The service object.
	 * @param string $parentId The id of the parent.
	 * @return Google_Client the authorized client object
	 */
	public static function getFileList(Google_Service_Drive $service, $parentId, $foldersOnly = false)
	{
		// Print the names and IDs for up to 10 files.
		$query = "'$parentId' IN parents AND NOT trashed";
		if ($foldersOnly) {
			$query .= " AND mimeType = '" . self::MIME_TYPE_FOLDER . "'";
		}
		$optParams = array(
		  'pageSize' => 10,
		  'fields' => 'nextPageToken, files(id, mimeType, webViewLink, iconLink, modifiedTime, name)',
		  'q' => $query
		);
		$results = $service->files->listFiles($optParams);
		return $results;
	}

	/**
	 * Builds and returns an array of detailed information for the files passed in $files.
	 *
	 * @param Google_Service_Drive $service The service object.
	 * @param array $files The list of files to get details for.
	 * @return Google_Client the authorized client object
	 */
	public static function getDetailedFileList(Google_Service_Drive $service, $files)
	{
		$detailedInfo = array();
		$optParams = array(
			"fields" => "*"
		);
		$properties = array(
			"id",
			"mimeType",
			"webViewLink",
			"iconLink",
			"modifiedTime",
			"name",
		);
		foreach ($files->getFiles() as $file) {
			$results = $service->files->get($file->getId(), $optParams);
			
			$info = array();
			foreach ($properties as $k) {
				if($k == "modifiedTime") {
					$info[$k] = date("Y-m-d H:i:s", strtotime($results[$k]));
				} else {
					$info[$k] = $results[$k];
				}
			}
			$detailedInfo[] = $info;
		}
		return $detailedInfo;
	}

	public static function getFoldersFromFileList($files)
	{
		$folders = array();
		foreach ($files as $file) {
			if ($file["mimeType"] == self::MIME_TYPE_FOLDER) {
				$folders[] = $file;
			}
		}
		return $folders;
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

	public static function isSpreadsheet($file) {
		return $file["mimeType"] == self::MIME_TYPE_SPREADSHEET;
	}

}