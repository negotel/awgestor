<?php    

    include "qrlib.php";    
    

    $filename = 'test.png';
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 4;
  
     QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
       
        
    //display generated file
    echo '<img src="'.basename($filename).'" />';  
   
 