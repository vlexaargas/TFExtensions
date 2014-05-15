This repo contains a series of modular quickfixes for TF app. Available
components are summarized below.

# API Wrapper

Makes call to TF engine and adds TF data to TF object.

Example usage below. You will need to include TFApi.php and TFResult.php.

```
$tf = new TFResult();

# NOTE: pass TF object by reference
TFApi::process_ticket('path/to/bin', 'path/to/tess', 'path/to/image', &$tf);

$tf->getSection()     # ticket section
$tf->getRow()         # ticket row
$tf->getSeat()        # ticket seat
$tf->getConfidence()  # engine confidence
$tf->getSuccess()     # engine status
$tf->getTicketError() # engine errors
$tf->getMsg()         # dev errors
```

# Barcode Encoder

Adds a layer of absraction to barcode encoding library. Encodes barcode in PNG
format to given path.

Example usage below. You will need to include TFBarcode.php and BarcodeResult.php.

```
$barcode_result = new BarcodeResult();

TFBarcode::build('helloWorld',     # num/text to be encoded
                 'i25',            # type of barcode to encode
                 'filename',       # png barcode will be written this filename
                 &$barcode_result, # process results
                 200,              # optional image width
                 100)              # optional image height

$barcode_result->getCode()    # code encoded
$barcode_result->getType()    # type of barcode encoded
$barcode_result->getMsg()     # str of errors
$barcode_result->getSuccess() # encoding success
```
