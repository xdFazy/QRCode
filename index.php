<?php

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

require_once "vendor/autoload.php";

if (isset($_GET["phonenr"])) {

    $result = Builder::create()
        ->writer(new PngWriter())
        ->writerOptions([])
        ->data('tel:' . $_GET["phonenr"])
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(300)
        ->margin(10)
        ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
        ->labelText($_GET["phonenr"])
        ->labelFont(new NotoSans(20))
        ->labelAlignment(new LabelAlignmentCenter())
        ->validateResult(false)
        ->build();

    header('Content-Type: ' . $result->getMimeType());
    echo $result->getString();
} else {
    echo <<<FORMULAR
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seite für QRCode</title>
</head>
    <body>
        <p>-</p>
        <h1>QR-Code Generator</h1>
        
        <main>
            <form>
               <label>Phonenumber:</label>
               <input name="phonenr" type="text" required>

                <div>
                    <button type="submit">Get Code</button>
                </div>
            </form>
        </main>
    </body>
</html>
FORMULAR;

}