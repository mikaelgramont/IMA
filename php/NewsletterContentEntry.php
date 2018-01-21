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
	public function __construct($values, $ogInfo)
	{
		// $i refers to the columns
		$i = 0;

		// Spreadsheet fields
		$id = isset($values[$i]) ? $values[$i] + 2 : ''; $i++; // Offset of 2 because we would start at 1, and then there's a header row in the spreadsheet.
		$timestamp = isset($values[$i]) ? $values[$i] : ''; $i++;
		$email = isset($values[$i]) ? $values[$i] : ''; $i++;
		$url = isset($values[$i]) ? $values[$i] : ''; $i++;
		$description = isset($values[$i]) ? $values[$i] : ''; $i++;
		$category = isset($values[$i]) ? $values[$i] : ''; $i++;
		$used = isset($values[$i]) ? $values[$i] : ''; $i++;
		$IMAComment = isset($values[$i]) ? $values[$i] : ''; $i++;
		$hidden = isset($values[$i]) ? $values[$i] : ''; $i++;
		
		// Computed fields
		if (!$ogInfo->hasEntryFor($url)) {
			$OGMeta = Utils::getOGMetaFromUrl($url);
			if ($OGMeta) {
				$title = $OGMeta->title;
				$image = $OGMeta->image;
				$ogInfo->setEntryFor($url, $OGMeta->title, $OGMeta->image);
			} else {
				// For some reason, could not get info.
				$title = $url;
				$image = "";
			}			
		} else {
			$entry = $ogInfo->getEntryFor($url);
			$title = $entry->title;
			$image = $entry->image;			
		}


		$this->metadata = new stdClass();
		$this->metadata->id = $id;
		$this->metadata->timestamp = $timestamp;
		$this->metadata->category = $category;
		
		$this->actions = new stdClass();
		$this->actions->used = $used;
		$this->actions->hidden = $hidden;

		$this->preview = new stdClass();
		$this->preview->email = $email;
		$this->preview->url = $url;
		$this->preview->title = $title;
		$this->preview->image = $image;
		$this->preview->description = $description;
		$this->preview->IMAComment = $IMAComment;
	}
}