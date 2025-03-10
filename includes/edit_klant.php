<?php
// edit_klant.php
require 'config.php';

$message = '';

if (isset($_GET['id'])) {
    $klantid = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM klanten WHERE klantid = ?");
    $stmt->execute([$klantid]);
    $klant = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $klant_naam = trim($_POST['klant_naam']);
    $klant_email = trim($_POST['klant_email']);
    $klant_telefoon = trim($_POST['klant_telefoon']);
    $klant_address = trim($_POST['klant_address']);
    $geboorte_datum = trim($_POST['geboorte_datum']);

    $stmt = $pdo->prepare("UPDATE klanten SET klant_naam = ?, klant_email = ?, klant_telefoon = ?, klant_address = ?, geboorte_datum = ? WHERE klantid = ?");
    if ($stmt->execute([$klant_naam, $klant_email, $klant_telefoon, $klant_address, $geboorte_datum, $klantid])) {
        $message = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">Klantgegevens bijgewerkt!</div>';
    } else {
        $message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">Fout bij het bijwerken van klantgegevens.</div>';
    }
}
?>