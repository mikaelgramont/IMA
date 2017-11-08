<?php
class ResultTemplateGenerator
{
	private $_resultYear;
	private $_outputPath;
	private $_outputBodyParts = array();
	private $_resultsByPath = array();
	private $_fullOutput = "";
	private $_logger = "";	

	const  LAST_INITIALLY_DISPLAYED_RANK = 3;

	public function __construct(ResultYear $resultYear, $path, Logger $logger)
	{
		$this->_year = $resultYear->getYear();
		if (!is_numeric($this->_year)) {
			throw new Exception("Non numeric year: '$this->_year'");
		}
		$this->_resultYear = $resultYear;
		$this->_outputPath = $path;
		$this->_logger = $logger;
	}

	public function buildHTML()
	{
		foreach ($this->_resultYear->getEntries() as $resultEntry) {
			$body = self::_renderEntry($resultEntry);
			$this->_outputBodyParts[] = $body;

			$path = $this->_outputPath . Utils::cleanStringForUrl($resultEntry->getName()) . '.php';
			$this->_resultsByPath[$path] = $body;
		}

		$this->_fullOutput = implode("\n", $this->_outputBodyParts);
	}

	public function getFullOutput()
	{
		return $this->_fullOutput;
	}

	public function saveToDisk()
	{
		$fullPath = $this->_outputPath . $this->_year . '.php';
		file_put_contents($fullPath, $this->_fullOutput);

		foreach($this->_resultsByPath as $path => $content) {
			file_put_contents($path, $content);
		}
	}

	private function _renderEntry(ResultEntry $resultEntry) 
	{
		$entryName = Utils::escape($resultEntry->getName());
		$entryAnchorName = $this->_getAnchorName($resultEntry->getName());
		$url =  'results/' . $entryAnchorName;
		$entryDescription = Utils::escape($resultEntry->getDescription());

		$body = "<div class=\"results-entry\">\n";
		$body .= "\t<h2 id=\"{$entryAnchorName}\" class=\"display-font entry-title\">{$entryName}\n";
		$body .= "\t\t<a class=\"link-icon\" href=\"$url\"></a>\n";
		$body .= "\t</h2>\n";
		$body .= "\t<a name='{$entryAnchorName}'></a>\n";

		if ($entryDescription) {
			$body .= "\t<p class=\"event-description\">{$entryDescription}</p>\n";
		} else {
			$body .= "\t<!-- No description -->";
		}
		
		$categories = array();
		foreach ($resultEntry->getCategories() as $category) {
			$categories[$category->getName()] = $category;
		}
		ksort($categories);
		$body .= "<ol class=\"category-list\">\n";
		foreach ($categories as $i => $category) {
			$body .= $this->_renderCategory($category, $entryAnchorName);
		}
		$body .= "</ol>\n";
		$body .= "</div>\n";

		return $body;
	}

	private function _renderCategory(ResultCategory $category, $entryAnchorName)
	{
		$categoryName = Utils::escape($category->getName());
		$categoryAnchorName = $entryAnchorName . "-" . $this->_getAnchorName($category->getName());

		$rankings = $category->getRankings();
		uasort($rankings, function($a, $b) {
			if ($a->getPosition() == $b->getPosition()) {
				// If the position is the same, sort by name.
				return ($a->getFullName() < $b->getFullName()) ? -1 : 1;
			}
			// Otherwise sort by position.
			return ($a->getPosition() < $b->getPosition()) ? -1 : 1;
		});

		$out = "<li class=\"category\">\n<table>\n";
		$out .= "\t<caption>\n";
		$out .= "\t\t<a name=\"{$categoryAnchorName}\"></a>\n";
		$out .= "\t\t<span class=\"category-name\">{$categoryName}</span>\n";
		$out .= "\t\t<a class=\"link-icon\" href=\"?year={$this->_year}#$categoryAnchorName\"></a>\n";
		$out .= "\t</caption>\n";
		foreach ($rankings as $ranking) {
			$out .= $this->_renderRanking($ranking);
		}
		if ($ranking->getPosition() > self::LAST_INITIALLY_DISPLAYED_RANK) {
			$out .= $this->_renderExpandButtonRow();
		}
		$out .= "</table>\n</li>\n";

		return $out;
	}

	private function _renderRanking(ResultRanking $ranking)
	{
		$position = Utils::escape($ranking->getPosition());
		$fullName = Utils::escape($ranking->getFullName());
		$country = Utils::escape($ranking->getCountry());

		$rowClass = $position > self::LAST_INITIALLY_DISPLAYED_RANK ? "hidden-result no-highlight" : "";
		$out = "\t<tr class=\"$rowClass\">\n\t\t<td class=\"position\">{$position}</td>\n";
		$out .= "\t\t<td class=\"fullname\">{$fullName}";

		if ($country != null && $country != 'null') {
			$src = Utils::getFlagFileForCountry($country);
			if ($src) {
				$out .= "<img src=\"$src\" class=\"country-flag\">\n";
			}
		}
		$out .= "</td>\n\t</tr>\n";
		return $out;		
	}

	private function _renderExpandButtonRow()
	{
		return <<<HTML
		<tr>
			<td class="expand-cell" colspan="2">
				<button class="expand-cell-button" data-collapsed-text="Show more" data-expanded-text="Hide">Show more</button>
			</td>
		</tr>

HTML;
	}

	private function _hasMultipleEntries()
	{
		return sizeof($this->_resultYear->getEntries()) > 1;
	}

	private function _getAnchorName($name)
	{
		return Utils::cleanStringForUrl($name);
	}
}