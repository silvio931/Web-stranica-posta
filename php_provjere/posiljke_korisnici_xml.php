<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

$veza = new Baza();
$veza->spojiDB();
$upit = "SELECT korisnik_id as id,ime as ime, prezime as prezime, korisnicko_ime as korime FROM `korisnik`";
$rezultat = $veza->selectDB($upit);

$num_rows = mysqli_num_rows($rezultat);
$atributi = array("id", "ime", "prezime", "korime");

$xmlDom = new DOMDocument();
header("Content-Type: text/xml");
$xmlDom->appendChild($xmlDom->createElement('korisnici'));
$xmlRootNode = $xmlDom->documentElement;

if ($num_rows === 0) {
    $xmlRowElementNode = $xmlDom->createElement('korisnik');

    for ($k = 0; $k < count($atributi); $k++) {
        $xmlRowElement = $xmlDom->createElement($atributi[$k]);
        $xmlText = $xmlDom->createTextNode(0);
        $xmlRowElement->appendChild($xmlText);

        $xmlRowElementNode->appendChild($xmlRowElement);
    }
    $xmlRootNode->appendChild($xmlRowElementNode);
}

if ($num_rows > 0) {
    while ($red = mysqli_fetch_array($rezultat)) {
        $id = $red['id'];
        $ime = $red['ime'];
        $prezime = $red['prezime'];
        $korime = $red['korime'];
        
        $xmlRowElementNode = $xmlDom->createElement('korisnik');

        for ($j = 0; $j < count($atributi); $j++) {
            $xmlRowElement = $xmlDom->createElement($atributi[$j]);
            $xmlText = $xmlDom->createTextNode($red[$j]);
            $xmlRowElement->appendChild($xmlText);

            $xmlRowElementNode->appendChild($xmlRowElement);
        }

        $xmlRootNode->appendChild($xmlRowElementNode);
    }
}

$veza->zatvoriDB();
echo $xmlDom->saveXML();

?>