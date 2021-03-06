<?php
$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

if (!isset($_SESSION["uloga"])) {
    header("Location: ../obrasci/prijava.php");
    exit();
} elseif (isset($_SESSION["uloga"]) && $_SESSION["uloga"] === "4") {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['submit'])) {
    $posiljka = $_GET['posiljkaID'];
    $tezina = $_GET['tezina'];
    $primatelj = $_GET['primatelj'];

    $veza = new Baza();
    $veza->spojiDB();

    $upit = "UPDATE pošiljka SET primatelj = $primatelj, težina_kg = $tezina WHERE pošiljka_id = $posiljka";

    $rezultat = $veza->updateDB($upit);

    $veza->zatvoriDB();
}
?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Moje pošiljke</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Silvio Mihalic">
        <meta name="keywords" content="FOI, WebDiP, moje pošiljke, pošta">
        <meta name="description" content="Stranica moje pošijlke, 30.5.2020.">
        <link rel="stylesheet" href="../css/smihalic.css" type="text/css"/>
        <link href="../css/smihalic_prilagodbe.css" rel="stylesheet" type="text/css"/>
        <link href="../css/smihalic_ispis.css" rel="stylesheet" type="text/css" media="print"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../javascript/poslane_posiljke_jquery.js"></script>

    </head>
    <body>
        <header style="width: 100%;text-align: right;">
            <nav>
                <?php
                include '../meni.php';
                ?>
                <a href = "../index.php"><img class = "logo" style="width:45px;margin-left: 25px" id = "slikaf1" src = "../multimedija/logo.png" alt = "f1 pozadina" /></a>
                <h2 class="naslovStranice" style="margin-left: -5px">Moje pošiljke</h2>                

            </nav>
            <form method="post" name="form1" action="http://barka.foi.hr/WebDiP/2019/materijali/zadace/ispis_forme.php">
                <input type="text" id='trazilica' name='trazi' placeholder="Traži" class="trazilica">
                <input type="image" style="width:1.4%; padding-right: 10px" src="../multimedija/search.PNG" alt="Submit">
            </form>
        </header>
        <br>
        <div id="poruka">

        </div>
        <br>
        <div style="font-size:15px;font-family: arial;">
            <table class="display compact nowrap" id="tablica1" style="font-weight: bold;">
                <caption style="font-size: 20px">Poslane pošiljke</caption>
                <thead>
                    <tr id="zaglavljetablice">
                        <th>ID pošiljke</th>
                        <th>Trenutna lokacija</th>
                        <th>Primatelj ID</th>
                        <th>Primatelj</th>
                        <th>Težina(kg)</th>
                        <th>Datum otpreme</th>
                        <th>Datum pristizanja</th>
                        <th>Broj računa</th>
                        <th>Ažuriraj</th>
                        <th>Obriši</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal">

                </tbody>
            </table>
            <br><br> 

        </div>
        <div id="azuriranjePosiljke" style="font-family: arial;width: 70%;margin: auto;">
            <div style="width: 40%;">
                <h2>Ažuriraj pošiljku</h2>
                <form method="get" name="form1" action="poslane_posiljke.php">
                    <label for="posiljka">ID pošiljke: </label>
                    <input type="text" id="posiljkaID" name="posiljkaID" required="posiljkaID" readonly=""><br><br>
                    <label for="tezina">Težina (kg): </label>
                    <input type="number" id="tezina" name="tezina" placeholder="1.0" step="0.1" min="0" required="required"><br><br>
                    <label for="primatelj">ID primatelja: </label>
                    <input type="number" id="primatelj" name="primatelj"  placeholder="id primatelja" required="required"><br><br>
                    <input type="submit" name="submit" id="submit" value="Spremi">
                </form> 
            </div>
            <br><br>
            <div style="width:40%;font-size:15px;font-family: arial;margin-left:40%;margin-top: -22%;">
                <table class="display compact nowrap" id="tablica2" style="font-weight: bold;">
                    <caption style="font-size: 20px">Korisnici</caption>
                    <thead>
                        <tr id="zaglavljetablice">
                            <th>ID korisnika</th>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Korisničko ime</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: normal">

                    </tbody>
                </table>

            </div>

        </div>

    </body>
</html>
