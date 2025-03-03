<?php
require 'config.php';

if (!isset($_GET['leningid'])) {
    die("Geen lening ID opgegeven.");
}

$leningid = $_GET['leningid'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lening_status = $_POST['lening_status'];

    $stmt = $pdo->prepare("UPDATE leningen SET lening_status = ? WHERE leningid = ?");
    $stmt->execute([$lening_status, $leningid]);

    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM leningen WHERE leningid = ?");
$stmt->execute([$leningid]);
$lening = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$lening) {
    die("Lening niet gevonden.");
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Lening Bewerken</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-900 p-4 flex justify-between items-center">
        <div class="text-white text-xl font-bold">BankLoan Pro</div>
        <a href="index.php" class="text-white flex items-center"><i class="fas fa-arrow-left mr-2"></i>Terug</a>
    </nav>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4">Lening Bewerken</h1>
        <form method="POST" class="space-y-4">
            <label for="lening_status" class="block">
                Status:
                <select id="lening_status" name="lening_status" required class="w-full p-2 border rounded">
                    <option value="In behandeling" <?= $lening['lening_status'] === 'In behandeling' ? 'selected' : '' ?>>In behandeling</option>
                    <option value="Goedgekeurd" <?= $lening['lening_status'] === 'Goedgekeurd' ? 'selected' : '' ?>>Goedgekeurd</option>
                    <option value="Afgekeurd" <?= $lening['lening_status'] === 'Afgekeurd' ? 'selected' : '' ?>>Afgekeurd</option>
                    <option value="Afgesloten" <?= $lening['lening_status'] === 'Afgesloten' ? 'selected' : '' ?>>Afgesloten</option>
                </select>
            </label>
            <button type="submit" class="bg-blue-600 text-white p-2 rounded">Opslaan</button>
        </form>
    </div>
</body>
</html>