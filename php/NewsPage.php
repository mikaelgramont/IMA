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
  protected $_body;

  protected $_date;
  protected $_previewImage;
  protected $_description;
  protected $_title;

  const DATE_REGEX = '/article:published_time\"\ content\=\"([0-9\-]*)\"/i';
  const IMAGE_REGEX = '/og:image\"\ content\=\"([^\"]*)\"/i';
  const TITLE_REGEX = '/og:title\"\ content\=\"([^\"]*)\"/i';
  const DESCRIPTION_REGEX = '/og:description\"\ content\=\"([^\"]*)\"/i';

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

  public function parse($ogUrl) {
    $fileContent = file_get_contents($this->_path . '/' . $this->_filename);
    $parts = explode($this->_separator, $fileContent);
    $this->_meta = $parts[0];
    $this->_body = $parts[1];

    // Date
    preg_match(self::DATE_REGEX, $this->_meta,$parts);
    $this->_date = $parts[1];

    // Image
    preg_match(self::IMAGE_REGEX, $this->_meta,$parts);
    $this->_previewImage = str_replace('$OG_URL/', $ogUrl, $parts[1]);

    // Description
    preg_match(self::DESCRIPTION_REGEX, $this->_meta,$parts);
    $this->_description = $parts[1];

    // Title
    preg_match(self::TITLE_REGEX, $this->_meta,$parts);
    $this->_title = $parts[1];

    return $this;
  }

  public function isStatic() {
    return $this->_isStatic;
  }

  public function getName() {
    return $this->_name;
  }

  public function getMeta() {
    $html = <<<HTML

        <meta property="og:title" content="{$this->getTitle()}"/>
        <meta property="og:description" content="{$this->getDescription()}"/>
        <meta property="og:image" content="{$this->getPreviewImage()}"/>
        <meta property="article:published_time" content="{$this->getDate()}"/>

HTML;
    return $html;
  }

  public function getSnippet() {
    $html = <<<HTML
    <h2 class="display-font">
      {$this->getTitle()}
    </h2>
    <p>{$this->getDescription()}</p>
HTML;
    return $html;
  }

  public function getBody() {
    return $this->_body;
  }

  public function getContent() {
    $html = <<<HTML
<div class="news-title-wrapper">
  <h1 class="display-font news-title">
    {$this->getTitle()}
  </h1>
  <time datetime="{$this->getDate()}" class="news-date">{$this->getFormattedDate()}</time>
</div>
<p>{$this->getDescription()}</p>
  
{$this->getBody()}
HTML;
    return $html;
  }

  public function getHomePageMarkup() {
    $html = <<<HTML
      <li>
        <a class="news-link news-title-wrapper" href="{$this->_url}">
            <h1 class="display-font news-title">
              {$this->getTitle()}
            </h1>
            <time datetime="{$this->getDate()}" class="news-date">({$this->getFormattedDate()})</time>
        </a>
        <p>{$this->getDescription()}</p>
      </li>
HTML;
    return $html;
  }

  public function getUrl() {
    return $this->_url;
  }

  public function getTitle() {
    return $this->_title;
  }

  public function getDate() {
    return $this->_date;
  }

  public function getFormattedDate() {
    $parts = explode('-', $this->_date);
    return date('M d Y', mktime(0, 0, 0, $parts[1], $parts[2], $parts[0]));
  }

  public function getPreviewImage() {
    return $this->_previewImage;
  }

  public function getDescription() {
    return $this->_description;
  }
}