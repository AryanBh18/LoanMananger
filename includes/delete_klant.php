<?php
// delete_klant.php
require 'config.php';

if (!isset($_GET['id'])) {
    die("Geen klant ID opgegeven.");
}

$klantid = intval($_GET['id']);

// Controleer of de klant mag worden verwijderd (optioneel: check of er afhankelijkheden zijn)
$stmt = $pdo->prepare("SELECT klantid FROM klanten WHERE klantid = ?");
$stmt->execute([$klantid]);
$klant = $stmt->fetch(PDO::FETCH_ASSOC);

if ($klant) {
    $stmt = $pdo->prepare("DELETE FROM klanten WHERE klantid = ?");
    $stmt->execute([$klantid]);
}

header("Location: add_klanten.php");
exit;
?>
