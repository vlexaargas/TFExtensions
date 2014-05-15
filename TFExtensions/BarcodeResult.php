<?php
  include('./Result.php');

  Class BarcodeResult extends Result{
    private $code;
    private $type;

    function getCode() {
      return $this->code;
    }

    function getType() {
      return $this->type;
    }

    function setCode($code) {
      $this->code = $code;
    }

    function setType($type) {
      $this->type = $type;
    }
  }
?>
