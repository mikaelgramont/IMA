<?php
class ResultTemplateGenerator
{
	private $_resultYear;
	private $_outputPath;
	private $_outputHeaderParts = array();
	private $_outputBodyParts = array();
	private $_fullOutput = "";


	public function __construct(ResultYear $resultYear, $path)
	{
		$this->_year = $resultYear->getYear();
		$this->_resultYear = $resultYear;
		$this->_outputPath = $path;
	}

	public function buildHTML()
	{
		foreach ($this->_resultYear->getEntries() as $resultEntry) {
			list($header, $body) = self::_processEntry($resultEntry);
			$this->_outputHeaderParts[] = $header;
			$this->_outputBodyParts[] = $body;
		}

		$this->_fullOutput = implode("\n", $this->_outputHeaderParts) . "\n<hr>\n" . implode("\n", $this->_outputBodyParts);
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

	private function _processEntry(ResultEntry $resultEntry) 
	{
		$entryName = $resultEntry->getName();
		$entryAnchorName = $this->_getAnchorName($entryName);

		$header = "";
		if ($this->_hasMultipleEntries()) {
			// Only add an anchor if it makes sense.
			$header .= "<a href='#{$entryAnchorName}'>{$entryName}</a>\n";
		}
		$header .= "<ul>\n";

		$body = "<h1 id='{$entryAnchorName}'>{$entryName}</h1>\n";
		$body .= "<a name='{$entryAnchorName}'></a>\n";
		
		$categories = array();
		foreach ($resultEntry->getCategories() as $category) {
			$categories[$category->getName()] = $category;
		}
		ksort($categories);

		foreach ($categories as $i => $category) {
			$categoryName = $category->getName();
			$categoryAnchorName = $this->_getAnchorName($categoryName);

			$header .= "<li><a href='#{$categoryAnchorName}'>{$categoryName}</a></li>\n";
			$body .= $this->_renderCategory($category);
		}
		$header .= "</ul>\n";

		return array($header, $body);
	}

	private function _renderCategory(ResultCategory $category)
	{
		$categoryName = $category->getName();
		$categoryAnchorName = $this->_getAnchorName($categoryName);

		$rankings = array();
		foreach ($category->getRankings() as $ranking) {
			$rankings[$ranking->getPosition()] = $ranking;
		}
		ksort($rankings);

		$out = "<a name='{$categoryAnchorName}'></a>\n";
		$out .= "<table>\n";
		$out .= "\t<caption>{$categoryName}</caption>\n";
		foreach ($rankings as $ranking) {
			$out .= "\t<tr>\n\t\t<td>{$ranking->getPosition()}</td>\n\t\t<td>{$ranking->getFullName()}</td>\n\t</tr>\n";
		}
		$out .= "</table>\n";

		return $out;
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