<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize input values
    $klant_naam = trim($_POST['klant_naam']);
    $klant_email = trim($_POST['klant_email']);
    $klant_telefoon = trim($_POST['klant_telefoon']); // Assuming this is the phone number

    // Check if the customer already exists in the klanten table based on name and email
    $stmt = $pdo->prepare("SELECT klantid FROM klanten WHERE klant_naam = ? AND klant_email = ?");
    $stmt->execute([$klant_naam, $klant_email]);
    $klantid = $stmt->fetchColumn();

    if ($klantid) {
        // Client already exists
        header("Location: add_klanten.php?error=Client already exists.");
        exit;
    } else {
        // Client does not exist, proceed to insert the new client
        $stmt = $pdo->prepare("INSERT INTO klanten (klant_naam, klant_email, klant_telefoon, created_at) VALUES (?, ?, ?, NOW())");
        if ($stmt->execute([$klant_naam, $klant_email, $klant_telefoon])) {
            // Insertion successful, now get the new klantid
            $klantid = $pdo->lastInsertId();

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
            <label for="klant_telefoon" class="block">
                Telefoon Nummer:
                <input type="number" step="0.01" id="klant_telefoon" name="klant_telefoon" required class="w-full p-2 border rounded">
            </label>
            <button type="submit" class="bg-blue-600 text-white p-2 rounded">Toevoegen</button>
        </form>
    </div>
</body>
</html>