<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $klant_naam = trim($_POST['klant_naam']);
    $klant_email = trim($_POST['klant_email']);
    $lening_bedrag = $_POST['lening_bedrag'];
    $lening_duur = $_POST['lening_duur'];
    $rente = $_POST['rente'];

    if (empty($klant_naam) || empty($klant_email) || empty($lening_bedrag) || empty($lening_duur) || empty($rente)) {
        echo "<p>Vul alle velden in.</p>";
    } else {
        try {
            // Voeg klant toe
            $stmt = $pdo->prepare("INSERT INTO klanten (klant_naam, klant_email) VALUES (?, ?)");
            $stmt->execute([$klant_naam, $klant_email]);
            $klantid = $pdo->lastInsertId();

            // Voeg lening toe
            $stmt = $pdo->prepare("INSERT INTO leningen (klantid, lening_bedrag, lening_duur, rente, datum_aanvraag) VALUES (?, ?, ?, ?, CURDATE())");
            $stmt->execute([$klantid, $lening_bedrag, $lening_duur, $rente]);

            header("Location: index.php");
            exit;
        } catch (Exception $e) {
            echo "<p>Fout bij het toevoegen: " . $e->getMessage() . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Nieuwe Lening Toevoegen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-900 p-4 flex justify-between items-center">
        <div class="text-white text-xl font-bold">BankLoan Pro</div>
        <a href="index.php" class="text-white flex items-center"><i class="fas fa-arrow-left mr-2"></i>Terug</a>
    </nav>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4">Nieuwe Lening Toevoegen</h1>
        <form method="POST" class="space-y-4">
            <label for="klant_naam" class="block">
                Klantnaam:
                <input type="text" id="klant_naam" name="klant_naam" required class="w-full p-2 border rounded">
            </label>
            <label for="klant_email" class="block">
                E-mail:
                <input type="email" id="klant_email" name="klant_email" required class="w-full p-2 border rounded">
            </label>
            <label for="lening_bedrag" class="block">
                Leningbedrag:
                <input type="number" step="0.01" id="lening_bedrag" name="lening_bedrag" required class="w-full p-2 border rounded">
            </label>
            <label for="lening_duur" class="block">
                Leningduur (maanden):
                <input type="number" id="lening_duur" name="lening_duur" required class="w-full p-2 border rounded">
            </label>
            <label for="rente" class="block">
                Rente (%):
                <input type="number" step="0.01" id="rente" name="rente" required class="w-full p-2 border rounded">
            </label>
            <button type="submit" class="bg-blue-600 text-white p-2 rounded">Toevoegen</button>
        </form>
    </div>
</body>
</html>