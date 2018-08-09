<?php
class NewsPage
{
  protected $_baseUrl;
  protected $_separator;
  protected $_path;
  protected $_filename;
  protected $_isStatic = true;

  public function __construct($baseUrl, $separator, $path, $filename) {
    $this->_baseUrl = $baseUrl;
    $this->_separator = $separator;
    $this->_path = $path;
    $this->_filename = $filename;

    $pathParts = pathinfo($filename);
    $this->_name = $pathParts['filename'];
    $this->_extension = $pathParts['extension'];
    $this->_isStatic = $this->_extension != 'php';
    $this->_isStatic = $this->_extension != 'php';

    $this->_url = $this->_baseUrl. 'news/' . $this->_filename;

    $fileContent = file_get_contents($this->_path . '/' . $this->_filename);
    $parts = explode($this->_separator, $fileContent);

    if ($this->_isStatic) {
      $this->_meta = $parts[0];
      $this->_snippet = $parts[1];
      $this->_content = $parts[2];
    }
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
  public function getDate() {}
*/
}