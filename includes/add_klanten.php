<?php
require 'config.php';

$message = '';

// Handle the form submission for adding a new client
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize input values
    $klant_naam = trim($_POST['klant_naam']);
    $klant_email = trim($_POST['klant_email']);
    $klant_telefoon = trim($_POST['klant_telefoon']);
    $klant_address = trim($_POST['klant_address']);
    $geboorte_datum = trim($_POST['geboorte_datum']);
    
    // Check if the customer already exists in the klanten table based on name and email
    $stmt = $pdo->prepare("SELECT klantid FROM klanten WHERE klant_naam = ? AND klant_email = ?");
    $stmt->execute([$klant_naam, $klant_email]);
    $klantid = $stmt->fetchColumn();
    
    if ($klantid) {
        // Client already exists
        $message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">Client bestaat al.</div>';
    } else {
        // Client does not exist, proceed to insert the new client
        $stmt = $pdo->prepare("INSERT INTO klanten (klant_naam, klant_email, klant_telefoon, klant_address, geboorte_datum, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        if ($stmt->execute([$klant_naam, $klant_email, $klant_telefoon, $klant_address, $geboorte_datum])) {
            // Insertion successful
            $message = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">Klant is succesvol toegevoegd!</div>';
        } else {
            // Insertion failed
            $message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">Er is een fout opgetreden bij het toevoegen van de klant.</div>';
        }
    }
}

// Fetch all clients from the database
$stmt = $pdo->prepare("SELECT * FROM klanten ORDER BY klant_naam ASC");
$stmt->execute();
$klanten = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

