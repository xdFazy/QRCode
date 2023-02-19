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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
    <body class="bg-gradient-to-b from-white via-white00 to-blue-100">
        <p class="text-transparent mt-80">-</p>
        <h1 class="text-transparent font-bold text-6xl bg-clip-text bg-gradient-to-r from-blue-500 to-cyan-500 text-center mt-20">QR-Code Generator</h1>
        
        <main class="flex justify-center mt-16">
            <form class="flex flex-col space-y-3 w-80 h-fit m-10 p-10 bg-white rounded-2xl shadow-2xl text-stone-500">
               <label>Phonenumber:</label>
               <input name="phonenr" type="text" class="p-1 bg-white rounded-lg border border-zinc-300" required>

                <div>
                    <button type="submit" class="submit 
                                                 bg-gradient-to-r from-blue-500 to-cyan-500 
                                                 hover:from-blue-400 hover:to-cyan-400 
                                                 active:from-blue-500 active:to-cyan-500 
                                                 shadow-lg shadow-cyan-500/50 
                                                 font-bold text-white rounded-full w-36 p-2 mt-6">Get Code</button>
                </div>
            </form>
        </main>
  
        <footer class="fixed bottom-0 left-0 z-20 w-full p-2 bg-white">    
          <span class="block text-sm text-gray-500 text-center dark:text-gray-400">WEBT | CORE | Composer</span>
        </footer>
  
    </body>
</html>
FORMULAR;

}