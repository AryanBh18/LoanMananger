<?php
//if it works, dont touch it please.
//PS i tried optimizing it but i got $error_message.
require 'config.php';

if (!isset($_GET['leningid'])) {
    die("Geen lening ID opgegeven.");
}

$leningid = $_GET['leningid'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lening_bedrag = $_POST['lening_bedrag'];
    $lening_duur = $_POST['lening_duur'];
    $rente = $_POST['rente'];
    $lening_status = $_POST['lening_status'];

    $stmt = $pdo->prepare("UPDATE leningen SET lening_bedrag = ?, lening_duur = ?, rente = ?, lening_status = ? WHERE leningid = ?");
    $stmt->execute([$lening_bedrag, $lening_duur, $rente, $lening_status, $leningid]);

    header("Location: ../index.php");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-900 p-4 flex justify-between items-center">
        <div class="text-white text-xl font-bold">BankLoan Pro</div>
        <a href="../index.php" class="text-white flex items-center"><i class="fas fa-arrow-left mr-2"></i>Terug</a>
    </nav>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4">Lening Bewerken</h1>
        <div class="bg-white p-6 rounded shadow-md">
            <form method="POST" class="space-y-4">
                <label class="block">
                    Bedrag (€):
                    <input type="number" name="lening_bedrag" value="<?= htmlspecialchars($lening['lening_bedrag']) ?>" required class="w-full p-2 border rounded">
                </label>

                <label class="block">
                    Looptijd (maanden):
                    <input type="number" name="lening_duur" value="<?= htmlspecialchars($lening['lening_duur']) ?>" required class="w-full p-2 border rounded">
                </label>

                <label class="block">
                    Rente (%):
                    <input type="number" step="0.01" name="rente" value="<?= htmlspecialchars($lening['rente']) ?>" required class="w-full p-2 border rounded">
                </label>

                <label class="block">
                    Status:
                    <select name="lening_status" required class="w-full p-2 border rounded">
                        <option value="In behandeling" <?= $lening['lening_status'] === 'In behandeling' ? 'selected' : '' ?>>In behandeling</option>
                        <option value="Goedgekeurd" <?= $lening['lening_status'] === 'Goedgekeurd' ? 'selected' : '' ?>>Goedgekeurd</option>
                        <option value="Afgekeurd" <?= $lening['lening_status'] === 'Afgekeurd' ? 'selected' : '' ?>>Afgekeurd</option>
                        <option value="Afgesloten" <?= $lening['lening_status'] === 'Afgesloten' ? 'selected' : '' ?>>Afgesloten</option>
                    </select>
                </label>

                <button type="submit" class="bg-blue-600 text-white p-2 rounded">Opslaan</button>
            </form>
        </div>
    </div>
</body>
</html>