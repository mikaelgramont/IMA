<?php
/*
	Timestamp
	Email Address
	Web page address (URL)
	Description or comment (optional)
	Category (optional)
	Used in the past
	IMA comment
	Hide this content
*/
class NewsletterContentEntry
{
	public static $firstColumn = "A";
	public static $lastColumn = "H";
	public static $firstRow = "2";
	
	public static $markAsUsedColumn = "G";
	public static $discardedColumn = "H";

	public function __construct($values, $ogInfo)
	{
		// $i refers to the columns
		$i = 0;

		// Spreadsheet fields
		$id = isset($values[$i]) ? $values[$i] + 2 : ''; $i++; // Offset of 2 because we start counting at 1, and then there's a header row in the spreadsheet.
		$timestamp = isset($values[$i]) ? $values[$i] : ''; $i++;
		$email = isset($values[$i]) ? $values[$i] : ''; $i++;
		$url = isset($values[$i]) ? $values[$i] : ''; $i++;
		$description = isset($values[$i]) ? $values[$i] : ''; $i++;
		$category = isset($values[$i]) ? $values[$i] : ''; $i++;
		$IMAComment = isset($values[$i]) ? $values[$i] : ''; $i++;
		
		if (isset($values[$i])) {
			$markAsUsed = empty(trim($values[$i])) ? false : true;
		} else {
			$markAsUsed = false;	
		}
		$i++;

		if (isset($values[$i])) {
			$discarded = empty(trim($values[$i])) ? false : true;
		} else {
			$discarded = false;	
		}
		$i++;
				
		// Computed fields
		if ($ogInfo->hasEntryFor($url)) {
			$entry = $ogInfo->getEntryFor($url);
			$title = $entry->title;
			$image = $entry->image;
		} else {
			$OGMeta = Utils::getOGMetaFromUrl($url);
			if ($OGMeta) {
				$title = $OGMeta->title;
				$image = $OGMeta->image;
				$ogInfo->setEntryFor($url, $title, $image);
			} else {
				// For some reason, could not get info.
				$title = $url;
				$image = "";
			}			
		}


		$this->metadata = new stdClass();
		$this->metadata->id = $id;
		$this->metadata->category = $category;
		
		$this->actions = new stdClass();
		$this->actions->markAsUsed = $markAsUsed;
		$this->actions->discarded = $discarded;

		$this->preview = new stdClass();
		$this->preview->timestamp = $timestamp;
		$this->preview->email = $email;
		$this->preview->url = $url;
		$this->preview->title = $title;
		$this->preview->image = $image;
		$this->preview->description = $description;
		$this->preview->IMAComment = $IMAComment;
	}
}