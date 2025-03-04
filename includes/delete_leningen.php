<?php
require 'config.php';

if (!isset($_GET['leningid'])) {
    die("Geen lening ID opgegeven.");
}

$leningid = $_GET['leningid'];

// Controleer of de lening mag worden verwijderd
$stmt = $pdo->prepare("SELECT lening_status FROM leningen WHERE leningid = ?");
$stmt->execute([$leningid]);
$lening = $stmt->fetch(PDO::FETCH_ASSOC);

if ($lening && $lening['lening_status'] !== 'Goedgekeurd') {
    $stmt = $pdo->prepare("DELETE FROM leningen WHERE leningid = ?");
    $stmt->execute([$leningid]);
}

header("Location: ../index.php");
exit;
?>