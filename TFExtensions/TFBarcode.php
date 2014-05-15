<?php
  include('./php-barcode.php');

  class TFBarcode {

    static public function build($code, $type, $filename, &$barcodeResult,
      $width=200, $height=100) {

      // -------------------------------------------------- //
      //                  PROPERTIES
      // -------------------------------------------------- //
      $font     = './font/OpenSans-Regular.TTF';
      $fontSize = 10;   // GD1 in px ; GD2 in point
      $marge    = 10;   // between barcode and hri in pixel
      $x        = $width / 2.0;  // barcode center
      $y        = $height / 2.0;  // barcode center
      $w        = 2;    // barcode line width
      $angle    = 0;   // rotation in degrees

      // -------------------------------------------------- //
      //            ALLOCATE GD RESSOURCE
      // -------------------------------------------------- //
      $im     = imagecreatetruecolor($width, $height + 20);
      $black  = ImageColorAllocate($im,0x00,0x00,0x00);
      $white  = ImageColorAllocate($im,0xff,0xff,0xff);
      imagefilledrectangle($im, 0, 0, $width, $height + 20, $white);

      // -------------------------------------------------- //
      //              SET STATUS VAR
      // -------------------------------------------------- //
      $barcodeResult->setSuccess(true);
      $barcodeResult->setCode($code);
      $barcodeResult->setType($type);

      // -------------------------------------------------- //
      //     MAP $type VARIABLE + CHECK CODE VALIDITY
      // -------------------------------------------------- //
      switch($type) {
      case 'code-128':
        $type = 'code128';
        break;
      case 'code-39':
        $type = 'code39';
        break;
      case 'i25':
      case 'int':
        $type = 'int25';
        break;
      case 'ean-8':
        if (!is_numeric($code) || strlen((string)$code) < 7) {
          $barcodeResult->setSuccess(false);
          $barcodeResult->addError("Error: ean-8 Barcode must be 7+ numbers long.");
        }
        $type = 'ean8';
        break;
      case 'upc-a':
        if (!is_numeric($code) || strlen((string)$code) < 11) {
          $barcodeResult->setSuccess(false);
          $barcodeResult->addError("Error: upc-a Barcode must be 11+ numbers long.");
        }
        $type = 'upc';
        break;
      case 'upc-e':
      case 'qr-code':
      default:
        $barcodeResult->setSuccess(false);
        $barcodeResult->addError("Error: This type of barcode is not supported.");
        break;
      }

      // -------------------------------------------------- //
      //                      BARCODE
      // -------------------------------------------------- //
      $data = Barcode::gd($im, $black, $x, $y, $angle, $type,
        array('code'=>$code), $w, $height);

      // -------------------------------------------------- //
      //                        HRI
      // -------------------------------------------------- //
      $box = imagettfbbox($fontSize, 0, $font, $data['hri']);
      $len = $box[2] - $box[0];
      Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge,
        $angle, $xt, $yt);
      imagettftext($im, $fontSize, $angle, $x + $xt, $y + $yt, $black, $font,
        $data['hri']);

      // -------------------------------------------------- //
      //                    GENERATE
      // -------------------------------------------------- //
      if ($status['success']) {
        if (!imagepng($im, $filename)) {
          $barcodeResult->setSuccess(false);
          $barcodeResult->addError("Error: PNG write failed.");
        }
      }
      imagedestroy($im);
      return $barcodeResult->getSuccess();
    }
  }
?>
