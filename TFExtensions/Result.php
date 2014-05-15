<?php
  Class Result {
    private $success;
    private $msg;
    private $errorArr = [];

    function getSuccess() {
      return $this->success;
    }

    function getMsg() {
      $numErr = sizeof($this->errorArr);
      if ($numErr != 0) {
        return implode(' ', $this->errorArr);
      } else {
        return "Success.";
      }
    }

    function getErrorArr() {
      return $this->errorArr;
    }

    function setSuccess($success) {
      $this->sucess = $success;
    }

    function addError($e) {
      array_push($this->errorArr, $e);
    }
  }
?>
