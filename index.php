<?php
require './includes/config.php';

// Zoekfunctie
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$whereClause = '';
if (!empty($search)) {
    $whereClause = "WHERE k.klant_naam LIKE '%$search%' OR k.klant_email LIKE '%$search%'";
}

// Haal alle leningen op
$stmt = $pdo->query("
    SELECT l.leningid, k.klant_naam, k.klant_email, l.lening_bedrag, l.lening_duur, l.rente, l.lening_status, l.datum_aanvraag
    FROM leningen l
    JOIN klanten k ON l.klantid = k.klantid
    $whereClause
");
$lendingen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <title>BankLoan Pro Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Kopieer hier de HTML van de front-end -->
    <nav class="bg-blue-900 p-4 flex justify-between items-center">
        <div class="text-white text-xl font-bold">BankLoan Pro</div>
        <div class="flex space-x-6">
            <a href="#" class="text-white flex items-center"><i class="fas fa-home mr-2"></i>Home</a>
            <a href="./includes/add_leningen.php" class="text-white flex items-center"><i class="fas fa-plus mr-2"></i>Nieuwe Lening</a>
            <a href="#" class="text-white flex items-center"><i class="fas fa-users mr-2"></i>Klanten</a>
            <a href="calculator.php" class="text-white flex items-center"><i class="fas fa-calculator mr-2"></i>Calculator</a>
        </div>
        <div class="text-white">
            <i class="fas fa-user-circle text-2xl"></i>
        </div>
    </nav>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4">Dashboard</h1>
        <p class="text-gray-600 mb-6">Overzicht van alle leningen bij de bank</p>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <!-- Statistieken -->
            <?php
            $totalLoans = $pdo->query("SELECT COUNT(*) FROM leningen")->fetchColumn();
            $approvedLoans = $pdo->query("SELECT COUNT(*) FROM leningen WHERE lening_status = 'Goedgekeurd'")->fetchColumn();
            $rejectedLoans = $pdo->query("SELECT COUNT(*) FROM leningen WHERE lening_status = 'Afgekeurd'")->fetchColumn();
            $pendingLoans = $pdo->query("SELECT COUNT(*) FROM leningen WHERE lening_status = 'In behandeling'")->fetchColumn();
            ?>
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="text-3xl font-bold text-blue-600"><?= $totalLoans ?></div>
                    <div class="ml-4">
                        <p class="text-gray-600">Totaal Aantal Leningen</p>
                        <i class="fas fa-chart-bar text-blue-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="text-3xl font-bold text-green-600"><?= $approvedLoans ?></div>
                    <div class="ml-4">
                        <p class="text-gray-600">Goedgekeurde Leningen</p>
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="text-3xl font-bold text-red-600"><?= $rejectedLoans ?></div>
                    <div class="ml-4">
                        <p class="text-gray-600">Afgekeurde Leningen</p>
                        <i class="fas fa-times-circle text-red-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="text-3xl font-bold text-yellow-600"><?= $pendingLoans ?></div>
                    <div class="ml-4">
                        <p class="text-gray-600">In Behandeling</p>
                        <i class="fas fa-hourglass-half text-yellow-600"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center mb-4">
            <form method="GET" class="flex-grow">
                <input type="text" name="search" placeholder="Zoek op klantnaam of e-mail..." value="<?= htmlspecialchars($search) ?>" class="p-2 border rounded-lg flex-grow mr-2">
                <button type="submit" class="bg-blue-600 text-white p-2 rounded-lg">Zoeken</button>
            </form>
        </div>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 text-left">Klant</th>
                        <th class="py-2 px-4 text-left">Bedrag</th>
                        <th class="py-2 px-4 text-left">Looptijd</th>
                        <th class="py-2 px-4 text-left">Status</th>
                        <th class="py-2 px-4 text-left">Datum Aanvraag</th>
                        <th class="py-2 px-4 text-left">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lendingen as $lening): ?>
                    <tr class="border-t">
                        <td class="py-2 px-4 flex items-center">
                            <div class="bg-gray-300 rounded-full h-8 w-8 flex items-center justify-center text-sm font-bold text-white">
                                <?= strtoupper(substr($lening['klant_naam'], 0, 2)) ?>
                            </div>
                            <div class="ml-2">
                                <p class="font-bold"><?= htmlspecialchars($lening['klant_naam']) ?></p>
                                <p class="text-gray-600 text-sm"><?= htmlspecialchars($lening['klant_email']) ?></p>
                            </div>
                        </td>
                        <td class="py-2 px-4">€<?= number_format($lening['lening_bedrag'], 2) ?></td>
                        <td class="py-2 px-4"><?= $lening['lening_duur'] ?> maanden</td>
                        <td class="py-2 px-4">
                            <span class="
                                <?= $lening['lening_status'] === 'In behandeling' ? 'bg-yellow-100 text-yellow-600' : '' ?>
                                <?= $lening['lening_status'] === 'Goedgekeurd' ? 'bg-green-100 text-green-600' : '' ?>
                                <?= $lening['lening_status'] === 'Afgekeurd' ? 'bg-red-100 text-red-600' : '' ?>
                                py-1 px-3 rounded-full text-xs
                            ">
                                <?= htmlspecialchars($lening['lening_status']) ?>
                            </span>
                        </td>
                        <td class="py-2 px-4"><?= htmlspecialchars($lening['datum_aanvraag']) ?></td>
                        <td class="py-2 px-4 flex space-x-2">
                            <a href="includes/edit_leningen.php?leningid=<?= $lening['leningid'] ?>" class="text-blue-600"><i class="fas fa-edit"></i></a>
                            <a href="includes/delete_leningen.php?leningid=<?= $lening['leningid'] ?>" onclick="return confirm('Weet je zeker dat je deze lening wilt verwijderen?')" class="text-red-600"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>