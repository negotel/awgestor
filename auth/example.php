<?php
include_once("lib/GoogleAuthenticator.php");

$secret = 'XVQ2UIGO75XRUKJO';
$time = floor(time() / 30);
$code = "785943";

$g = new GoogleAuthenticator();

if(!isset($_GET['valida'])){

echo "Current Code is: ";
echo $g->getCode($secret);

$secret = $g->generateSecret();
echo "Get a new Secret: $secret <br /><br />";

echo "The QR Code for this secret (to scan with the Google Authenticator App: <br /><br />";
echo $g->getURL('chregu','example.org',$secret);
echo "<br /><br />";

}else{
echo "<br /><br />";

if ($g->checkCode("TDLZTDIVLAVOVXEB",$_GET['valida'])) {
    echo "YES <br /><br />";
} else {
    echo "NO <br /><br />";
}


}
