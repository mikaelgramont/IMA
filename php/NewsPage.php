<?php
class NewsPage
{
  protected $_baseUrl;
  protected $_separator;
  protected $_path;
  protected $_filename;
  protected $_name;
  protected $_extension;
  protected $_isStatic;
  protected $_url;

  protected $_meta;
  protected $_snippet;
  protected $_content;
  protected $_date;

  const DATE_REGEX = '/article:published_time\"\ content\=\"([0-9\-]*)\"/i';

  public function __construct($baseUrl, $separator, $path, $filename) {
    $this->_baseUrl = $baseUrl;
    $this->_separator = $separator;
    $this->_path = $path;
    $this->_filename = $filename;

    $pathParts = pathinfo($filename);
    $this->_name = $pathParts['filename'];
    $this->_extension = $pathParts['extension'];
    $this->_isStatic = $this->_extension != 'php';

    $this->_url = $this->_baseUrl. 'news/' . $this->_name;
  }

  public function parse() {
    $fileContent = file_get_contents($this->_path . '/' . $this->_filename);
    $parts = explode($this->_separator, $fileContent);
    $this->_meta = $parts[0];
    $this->_snippet = $parts[1];
    $this->_content = $parts[2];

    preg_match(self::DATE_REGEX, $this->_meta,$dates);
    $this->_date = $dates[1];

    return $this;
  }

  public function isStatic() {
    return $this->_isStatic;
  }

  public function getName() {
    return $this->_name;
  }

  public function getMeta() {
    return $this->_meta;
  }

  public function getSnippet() {
    return $this->_snippet;
  }

  public function getContent() {
    return $this->_content;
  }

  public function getUrl() {
    return $this->_url;
  }

  public function getDate() {
    return $this->_date;
  }

  public function getHomePageMarkup() {
    $html = <<<HTML
      <li>
        <a class="news-link" href="{$this->_url}">
          {$this->_snippet}
        </a>
      </li>
HTML;
    return $html;
  }

/*
  public function getTitle() {}
  public function getDescription() {}
  public function getPreviewImage() {}
*/
}