<?php
$message = '';

// Controleren of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ingevoerde gegevens ophalen en schoonmaken
    $klant_naam = trim($_POST['klant_naam']);
    $klant_email = trim($_POST['klant_email']);
    $klant_telefoon = trim($_POST['klant_telefoon']);
    $klant_address = trim($_POST['klant_address']);
    $geboorte_datum = trim($_POST['geboorte_datum']);
    
    // Kijken of de klant al in de database al staat op basis van naam en e-mail
    $stmt = $pdo->prepare("SELECT klantid FROM klanten WHERE klant_naam = ? AND klant_email = ?");
    $stmt->execute([$klant_naam, $klant_email]);
    $klantid = $stmt->fetchColumn();
    
    if ($klantid) {
        // Klant bestaat al, dus geven we een melding
        $message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">Client bestaat al.</div>';
    } else {
        // Klant bestaat nog niet, dus dan word  deze toegevoegd
        $stmt = $pdo->prepare("INSERT INTO klanten (klant_naam, klant_email, klant_telefoon, klant_address, geboorte_datum, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        if ($stmt->execute([$klant_naam, $klant_email, $klant_telefoon, $klant_address, $geboorte_datum])) {
            // Klant succesvol toegevoegd
            $message = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">Klant is succesvol toegevoegd!</div>';
        } else {
            // iets is misgegaan bij het toevoegen van de klant
            $message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">Er is een fout opgetreden bij het toevoegen van de klant.</div>';
        }
    }
}

// Alle klanten ophalen uit de database
$stmt = $pdo->prepare("SELECT * FROM klanten ORDER BY klant_naam ASC");
$stmt->execute();
$klanten = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>