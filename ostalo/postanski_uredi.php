<?php
$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

if (!isset($_SESSION["uloga"])) {
    header("Location: ../obrasci/prijava.php");
    exit();
} elseif (isset($_SESSION["uloga"]) && $_SESSION["uloga"] > 1) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['submitDodaj'])) {
    $drzava = $_GET['drzave'];
    $moderator = $_GET['moderator'];
    $naziv = $_GET['naziv'];
    $adresa = $_GET['adresa'];
    $brojZaposlenih = $_GET['brojZaposlenih'];

    $veza = new Baza();
    $veza->spojiDB();

    $upit = "INSERT INTO poštanski_ured (poštanski_ured_id, država_id, moderator_id, naziv, adresa, broj_zaposlenih) VALUES (DEFAULT, $drzava, $moderator, '$naziv', '$adresa', $brojZaposlenih)";

    $rezultat = $veza->updateDB($upit);

    $veza->zatvoriDB();
}

if (isset($_GET['submitAzuriraj'])) {
    $uredID = $_GET['uredID'];
    $drzava = $_GET['drzave'];
    $moderator = $_GET['moderator'];
    $naziv = $_GET['naziv'];
    $adresa = $_GET['adresa'];
    $brojZaposlenih = $_GET['brojZaposlenih'];

    $veza = new Baza();
    $veza->spojiDB();

    $upit = "UPDATE poštanski_ured SET država_id = $drzava, moderator_id = $moderator, naziv = '$naziv', adresa = '$adresa', broj_zaposlenih = $brojZaposlenih WHERE poštanski_ured_id = $uredID";

    $rezultat = $veza->updateDB($upit);

    $veza->zatvoriDB();
}
?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Poštanski uredi</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Silvio Mihalic">
        <meta name="keywords" content="FOI, WebDiP, države, pošta">
        <meta name="description" content="Stranica za pregled, unos, ažuriranje i brisanje država za admina, 7.6.2020.">
        <link rel="stylesheet" href="../css/smihalic.css" type="text/css"/>
        <link href="../css/smihalic_prilagodbe.css" rel="stylesheet" type="text/css"/>
        <link href="../css/smihalic_ispis.css" rel="stylesheet" type="text/css" media="print"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../javascript/postanski_uredi_jquery.js"></script>

    </head>
    <body>
        <header style="width: 100%;text-align: right;">
            <nav>
                <?php
                include '../meni.php';
                ?>
                <a href = "../index.php"><img class = "logo" style="width:45px;margin-left: 25px" id = "slikaf1" src = "../multimedija/logo.png" alt = "f1 pozadina" /></a>
                <h2 class="naslovStranice" style="margin-left: -5px">Poštanski uredi</h2>                

            </nav>
            <form method="post" name="form1" action="http://barka.foi.hr/WebDiP/2019/materijali/zadace/ispis_forme.php">
                <input type="text" id='trazilica' name='trazi' placeholder="Traži" class="trazilica">
                <input type="image" style="width:1.4%; padding-right: 10px" src="../multimedija/search.PNG" alt="Submit">
            </form>
        </header>
        <br><br>

        <div style="font-size:15px;font-family: arial;">
            <table class="display compact nowrap" id="tablica1" style="font-weight: bold;">
                <caption style="font-size: 20px">Poštanski uredi</caption>
                <thead>
                    <tr id="zaglavljetablice">
                        <th>Poštanski ured ID</th>
                        <th>Država</th>
                        <th>Moderator</th>
                        <th>Naziv</th>
                        <th>Adresa</th>
                        <th>Broj zaposlenih</th>
                        <th>Ažuriraj</th>
                        <th>Obriši</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal">

                </tbody>
            </table>

        </div>
        <br><br>

        <div id="dodajUred" style="width: 55%;font-family: arial;margin-right:100px">
            <h2 id="naslovDodaj">Dodaj poštanski ured</h2>
            <h2 id="naslovAzuriraj">Ažuriraj poštanski ured</h2>
            <form method="get" name="form1" action="postanski_uredi.php">
                <label for="uredID" id="ured">Poštanski ured ID: </label>
                <input type="text" id="uredID" name="uredID" required="required" readonly=""><br><br>

                <label for="drzava">Država: </label>
                <select name="drzave" id="drzave">

                </select><br><br>
                <label for="moderatori">Moderator: </label>
                <select name="moderator" id="moderator">

                </select><br><br>

                <label for="naziv">Naziv: </label>
                <input type="text" id="naziv" name="naziv" required="required"><br><br>
                <label for="adresa">Adresa: </label>
                <input type="text" id="adresa" name="adresa" required="required"><br><br>
                <label for="brojZaposlenih">Broj zaposlenih: </label>
                <input type="number" id="brojZaposlenih" name="brojZaposlenih" required="required"><br><br>

                <input type="submit" name="submitDodaj" id="submitDodaj" value="Dodaj">
                <input type="submit" name="submitAzuriraj" id="submitAzuriraj" value="Spremi">





            </form> 
        </div>
        <br><br>

    </body>
</html>
