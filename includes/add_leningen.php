<?php
// Initialize variables
$klanten = [];
$zoekterm = '';
$geselecteerde_klant = null;
$zoekresultaten = [];
$error_message = '';
$success_message = '';

// Haal alle klanten op voor de dropdown
$stmt = $pdo->query("SELECT klantid, klant_naam, klant_email FROM klanten ORDER BY klant_naam");
$klanten = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verwerk het zoekformulier als dat is ingediend
if (isset($_POST['zoeken']) && !empty($_POST['zoekterm'])) {
    $zoekterm = trim($_POST['zoekterm']);
    
    // Zoek klanten die overeenkomen met de zoekterm
    $stmt = $pdo->prepare("SELECT klantid, klant_naam, klant_email FROM klanten 
                           WHERE klant_naam LIKE ? OR klant_email LIKE ? 
                           ORDER BY klant_naam LIMIT 10");
    $stmt->execute(['%' . $zoekterm . '%', '%' . $zoekterm . '%']);
    $zoekresultaten = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Verwerk de klantselectie
if (isset($_POST['select_klant']) && !empty($_POST['klantid'])) {
    $klantid = $_POST['klantid'];
    
    // Haal de geselecteerde klant op
    $stmt = $pdo->prepare("SELECT klantid, klant_naam, klant_email FROM klanten WHERE klantid = ?");
    $stmt->execute([$klantid]);
    $geselecteerde_klant = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Verwerk het leningformulier
if (isset($_POST['submit_lening'])) {
    $klantid = $_POST['klantid'] ?? null;
    $lening_bedrag = $_POST['lening_bedrag'] ?? null;
    $lening_duur = $_POST['lening_duur'] ?? null;
    $rente = $_POST['rente'] ?? null;
    
    // Valideer de invoer
    if (empty($klantid)) {
        $error_message = "Selecteer eerst een klant.";
    } elseif (empty($lening_bedrag) || empty($lening_duur) || empty($rente)) {
        $error_message = "Alle velden zijn verplicht.";
    } else {
        // Voeg de lening toe
        $stmt = $pdo->prepare("INSERT INTO leningen (klantid, lening_bedrag, lening_duur, rente, datum_aanvraag) 
                               VALUES (?, ?, ?, ?, CURDATE())");
        
        if ($stmt->execute([$klantid, $lening_bedrag, $lening_duur, $rente])) {
            $success_message = "De lening is succesvol aangemaakt.";
            // Haal de geselecteerde klant op voor weergave
            $stmt = $pdo->prepare("SELECT klantid, klant_naam, klant_email FROM klanten WHERE klantid = ?");
            $stmt->execute([$klantid]);
            $geselecteerde_klant = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $error_message = "Er is een fout opgetreden bij het aanmaken van de lening.";
        }
    }
}
?>