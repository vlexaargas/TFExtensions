<?php
  class TFApi {

    /************************************************
      Executes call to TF engine, returns TF Object
    ************************************************/
    static public function process_ticket($bin_path, $tess_path, $image_path, &$tfResult) {
      # execute call to TF engine on server
      $output; # output from TF engine call
      $fail;   # fail code from TF engine call
      exec($bin_path . " --tess_dir=" . $tess_path . " " . $image_path,
        $output, $fail);
      if ($fail) {
        $tfResult->addError("Error: invalid command (code " . $fail . ").");
      }

      # parse JSON response
      try {
        $jsonArr = extract_json_str($output);
        $jsonArrSize = count($jsonStrArr);
        $tf;     # TF assoc array
        if ($jsonArrSize > 1) {
          $tfResult->addError("Error: more than 1 JSON object in response.");
        } elseif ($jsonArrSize < 1) {
          $tfResult->addError("Error: no JSON object in response.");
        } else {
          $tf = json_decode($jsonArr[0], true);
          if (!$tf) {
              $tfResult->addError("Error: JSON parse failed.");
            }
        }
      } catch (Exception $e) {
        $tfResult->addError("Engine error: " . $e->getMessage());
      }

      # build TF result object
      $errors = $tfResult->getErrorArr();
      if (!empty($errors)) {
        $tfResult->setSuccess(false);
      } else {
        $tfResult->setSuccess($tf["success"]);
        $tfResult->setSection($tf["section"]);
        $tfResult->setRow($tf["row"]);
        $tfResult->setSeat($tf["seat"]);
        $tfResult->setConfidence($tf["confidence"]);
        $tfResult->setTicketError($tf["error"]);
        $tfResult->setVersion($tf["version"]);
      }

      return $tfResult->getSuccess();
    }

    /**********************************************
      Extracts JSON objects from array of strings
    **********************************************/
    private function extract_json_str ($array) {
      $imploded = implode('', $array);
      preg_match_all('~\{(?:[^{}]|(?R))*\}~', $imploded, $result);
      return $result[0];
    }

  }
?>
