<?php
class NewsletterContentParser
{
	public static function buildContentList(Google_Service_Drive $driveService, Google_Service_Sheets $sheetsService, Logger $logger, $spreadsheetId, $ogInfo, $startTime, $showUsed = false, $showDiscarded = false)
	{
		$spreadsheetResponse = $sheetsService->spreadsheets->get($spreadsheetId);
		$sheet = $spreadsheetResponse->sheets[0];
            $sheetTitle = $sheet['properties']['title'];
      	$range = sprintf("'%s'!A2:H", $sheetTitle);
      	$sheetContentResponse = $sheetsService->spreadsheets_values->get($spreadsheetId, $range);
      	$rows = $sheetContentResponse->getValues();

      	$contentList = array();

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

                  $contentList[] = $entry;
      	}

            $issues = self::_buildIssuesList($startTime);

      	// TODO: set filters on object so it can be re-rendered.
      	return new NewsletterContentList($contentList, $issues);
	}

      private static function _buildIssuesList($startMonth = 0)
      {
            if (empty($startMonth)) {
                  throw new Exception("Start month must be set in order to build the list of issues.");
            }
            $thisMonth = date("Y-M");
            $months = self::_getMonths(strtotime($startMonth), strtotime($thisMonth));
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
      private static function _getMonths($start, $end)
      {

            // -1 to force inclusion of start month
            $current = $start - 1;

            // +1 to force inclusion of last month
            $end = $end + 1;
            $ret = array();

            while( $current < $end ){
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