<?php
class NewsletterContentParser
{
	public static function buildContentList(Google_Service_Drive $driveService, Google_Service_Sheets $sheetsService, Logger $logger, $spreadsheetId, $ogInfo, $currentTime, $showUsed = false, $showDiscarded = false, $useCacheForRead = false)
	{
            $pool = Cache::getPool();
            $cacheItem = $pool->getItem(NEWSLETTER_CONTENT_CACHE_PATH);

            $rows = null;
		if ($useCacheForRead) {
                  $logger->log("Using cache.\n");
                  if ($cacheItem->isMiss()) {
                        $logger->log("Cache miss.\n");
                        $rows = self::_fetchData($sheetsService, $spreadsheetId, $logger);
                        $cacheItem->set($rows);
                        $cacheItem->expiresAfter(3600);     
                        $pool->save($cacheItem);
                  } else {
                        $logger->log("Cache hit.\n");
                        $rows = $cacheItem->get();      
                  }                  
            } else {
                  $rows = self::_fetchData($sheetsService, $spreadsheetId, $logger);
                  $cacheItem->set($rows);
                  $pool->save($cacheItem);
            }

            $size = sizeof($rows);
            $logger->log("Got $size rows.\n");

      	$contentList = array();

            // Shift everything by one month because we prepare things a month ahead:
            // Things listed during January are for the February newsletter.
            $actualMonthEndTime = $currentTime;
            $actualMonthStartTime = strtotime(@date('Y-M-01', $currentTime) . "-1 month");

            $dateEnd = date('Y-M-01', $actualMonthEndTime);
            $dateStart = date('Y-M-01', $actualMonthStartTime);

            $logger->log("Start of month: $actualMonthStartTime or $dateStart\n");
            $logger->log("End of month: $actualMonthEndTime or $dateEnd\n");

      	foreach($rows as $index => $rowValues) {
      		// Insert index as React will need a key to work with.
      		array_unshift($rowValues, $index);
                  $entry = new NewsletterContentEntry($rowValues, $ogInfo);

                  if (!$showUsed && $entry->actions->markAsUsed) {
                        continue;
                  }

                  if (!$showDiscarded && $entry->actions->discarded) {
                        continue;
                  }

                  $entryTime = strtotime($entry->preview->timestamp);

                  if ($entryTime < $actualMonthStartTime || $entryTime > $actualMonthEndTime) {
                        continue;
                  }

                  $contentList[] = $entry;
      	}

      	return new NewsletterContentList($contentList,$currentTime);
	}

      private static function _fetchData($sheetsService, $spreadsheetId, $logger)
      {
            $logger->log("Fetching rows from Google Sheets.\n");

            $spreadsheetResponse = $sheetsService->spreadsheets->get($spreadsheetId);
            $sheet = $spreadsheetResponse->sheets[0];
            $sheetTitle = $sheet['properties']['title'];
            $range = sprintf("'%s'!A2:H", $sheetTitle);
            $sheetContentResponse = $sheetsService->spreadsheets_values->get($spreadsheetId, $range);
            $rows = $sheetContentResponse->getValues();
            return $rows;            
      }

      public static function buildIssuesList($monthStartTime = null)
      {
            if (empty($monthStartTime)) {
                  throw new Exception("Start month time must be set in order to build the list of issues.");
            }
            $thisMonthTime = strtotime(date("Y-M"));
            $months = self::_getMonths($thisMonthTime, $monthStartTime);
            return $months;
      }

      /*
        $StartDate = @strtotime("Jan 2003");
        $StopDate = @strtotime("Apr 2004");
      */
      /**
       * Gets list of months between two dates
       * @param  int $start Unix timestamp
       * @param  int $end Unix timestamp
       * @return array
       */
      private static function _getMonths($thisMonthTime, $firstMonthTime)
      {
            //die("$thisMonthTime, $firstMonthTime");
            // -1 to force inclusion of start month
            $current = $firstMonthTime - 1;

            // +1 to force inclusion of end month
            $end = $thisMonthTime + 1;
            $ret = array();

            while($current < $end){
                  $next = @date('Y-M-01', $current) . "+1 month";
                  $current = @strtotime($next);
                  $ret[] = array(
                        "name" => date('Y-M', $current),
                        "time" => $current
                  );
            }

            return array_reverse($ret);
      }      
}