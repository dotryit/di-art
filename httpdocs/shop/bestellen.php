<?php
if (isset($_POST['name']) && isset($_POST['address']) && isset($_POST['code']) && isset($_POST['city'])) {

    $iban = "CH99 9999 9999 9999 9999 (di:art GmbH)";
    $total = 0;
    $versand = 3;
    $name = $_POST['name'];
    $address = $_POST['address'];
    $code = $_POST['code'];
    $city = $_POST['city'];
    
    $bestellt = [];
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'produkt') === 0) {
            $produktId = substr($key, 7);
            $anzahl = $value;

            if ($anzahl > 0) {
                $bestellt[$produktId] = $anzahl;
            }
        }
    }

    // Verarbeite die Bestelldaten

    // Sende eine Bestätigungsnachricht
    echo "<h1>Bestellung di:art Webshop</h1>";
    echo "<p>Du möchtest folgende Produkte bestellen:</p>";

    echo "<ul>";
    foreach ($bestellt as $produktId => $anzahl) {
        $preis = 20;
        echo "<li>" . $anzahl . " mal Produkt " . $produktId . " zu CHF " . $preis . " = CHF " . $anzahl * $preis . "</li>";
    }
    echo "</ul>";

    $subject = "Bestellung di:art Webshop";
    $body = "Hallo\n\n";
    $body .= "Ich möchte gerne folgende Artikel bestellen:\n\n";
    foreach ($bestellt as $produktId => $anzahl) {
        $preis = 20;
        $body .= $anzahl . " mal Produkt " . $produktId . " zu CHF " . $preis . " = CHF " . $anzahl * $preis . "\n";
        $total += $anzahl * $preis;
    }
    $total += $versand;
    $body .= "\nDen Totalbetrag von CHF " . $total . " (inkl. Versandkosten von CHF " . $versand . ") überweise ich auf das Konto " . $iban . "\n";
    $body .= "\nSende mir nach Zahlungseingang bitte die Artikel an folgende Adresse zu:\n\n";
    $body .= $name . "\n";
    $body .= $address . "\n";
    $body .= $code . " " . $city . "\n";
    $body .= "\n";

    echo "<p>Mit dem Drücken auf diesen <a href=\"mailto:shop@di-art.ch?subject=", rawurlencode($subject), "&amp;body=", rawurlencode($body), "\">Link</a> erscheint deine Bestellung in deinem Email-Programm. Kontrolliere noch einmal deine Bestellung sowie die Lieferadresse und schicke die E-Mail an uns ab.</p>";
    echo "<p>Sobald deine Zahlung von CHF " . $total . " (inkl. Versandkosten von CHF " . $versand . ") auf dem Konto " . $iban . " eingetroffen ist, werden wir dir die gewünschten Produkte an folgende Adresse versenden:</p>";
    echo "<p>" . $name . "<br>";
    echo $address . "<br>";
    echo $code . " " . $city . "<br></p>";
    echo "<p>Vielen Dank für deine Bestellung.</p>";
} else {
    echo "Fehler: Es wurden nicht alle erforderlichen Daten übermittelt.";
}
?>
