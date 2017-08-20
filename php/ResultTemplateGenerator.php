<?php
class ResultTemplateGenerator
{
	private $_resultYear;
	private $_outputPath;
	private $_outputHeaderParts = array();
	private $_outputBodyParts = array();
	private $_fullOutput = "";

	const  LAST_INITIALLY_DISPLAYED_RANK = 3;

	public function __construct(ResultYear $resultYear, $path)
	{
		$this->_year = $resultYear->getYear();
		if (!is_numeric($this->_year)) {
			throw new Exception("Non numeric year: '$this->_year'");
		}
		$this->_resultYear = $resultYear;
		$this->_outputPath = $path;
	}

	public function buildHTML()
	{
		foreach ($this->_resultYear->getEntries() as $resultEntry) {
			list($header, $body) = self::_renderEntry($resultEntry);
			$this->_outputHeaderParts[] = $header;
			$this->_outputBodyParts[] = $body;
		}

		$this->_fullOutput = implode("\n", $this->_outputHeaderParts) . "\n" . implode("\n", $this->_outputBodyParts);
	}

	public function getFullOutput()
	{
		return $this->_fullOutput;
	}

	public function saveToDisk()
	{
		$fullPath = $this->_outputPath . $this->_year . '.php';
		file_put_contents($fullPath, $this->_fullOutput);
	}

	private function _renderEntry(ResultEntry $resultEntry) 
	{
		$entryName = Utils::escape($resultEntry->getName());
		$entryAnchorName = $this->_getAnchorName($resultEntry->getName());
		$entryDescription = Utils::escape($resultEntry->getDescription());

		$header = "";
		$body = "<div class=\"results-entry\">\n";
		$body .= "\t<h2 id=\"{$entryAnchorName}\" class=\"display-font entry-title\">{$entryName}</h2>\n";
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

		return array($header, $body);
	}

	private function _renderCategory(ResultCategory $category, $entryAnchorName)
	{
		$categoryName = Utils::escape($category->getName());
		$categoryAnchorName = $entryAnchorName . "-" . $this->_getAnchorName($category->getName());

		$rankings = array();
		foreach ($category->getRankings() as $ranking) {
			$rankings[$ranking->getPosition()] = $ranking;
		}
		ksort($rankings);

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

		if ($country) {
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