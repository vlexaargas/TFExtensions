<?php
  require('../common/Result.php');

  Class TFResult extends Result {
    private $tfSuccess;
    private $section;
    private $row;
    private $seat;
    private $confidence;
    private $tfError;
    private $version;

    function getTFSuccess() {
      return $this->tfSuccess;
    }

    function getSection() {
      return $this->section;
    }

    function getRow() {
      return $this->row;
    }

    function getSeat() {
      return $this->seat;
    }

    function getConfidence() {
      return $this->confidence;
    }

    function getTFError() {
      return $this->tfError;
    }

    function getVersion() {
      return $this->version;
    }

    function setTFSuccess($tfSuccess) {
      $this->tfSuccess = $tfSuccess;
    }

    function setSection($section) {
      $this->section = $section;
    }

    function setRow($row) {
      $this->row = $row;
    }

    function setSeat($seat) {
      $this->seat = $seat;
    }

    function setConfidence($confidence) {
      $this->confidence = $confidence;
    }

    function setTFError($tfError) {
      $this->tfError = $tfError;
    }

    function setVersion($version) {
      $this->version = $version;
    }
  }
?>
