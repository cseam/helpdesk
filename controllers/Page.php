<?php

class Page {

  private $_template = null;
  private $_data = null;
  public $_left = null;

  public function __construct($template = null, $data = null)
  {
    //load content for left side of page.
    $this->_left = new leftpageController();
    //set defaults if provided
    $this->_template = $template;
    $this->_data = $data;
  }

  public function setTemplate($templatename) {
    $this->_template = $templatename;
  }

  public function setDataSrc($data) {
    $this->_data = $data;
  }

  public function render() {
    $left = $this->_left;
    $pagedata = $this->_data;
    require_once VIEWS_LOC . $this->_template .".php";
  }
}
