<?php
require './includes/config.php';
require './includes/filters.php';
require './includes/stats.php';  
require './includes/groepering.php';

// Bepaal of geavanceerde filters actief zijn
$advancedFiltersActive = (!empty($date_from) || !empty($date_to) || 
                         !empty($amount_min) || !empty($amount_max));

// Controleer of de "Groeperen per klant" filter is geselecteerd
$group_by_customer = isset($_GET['group_by_customer']) ? $_GET['group_by_customer'] : 'no';

// Use the query builder function to construct the query
$query = buildQuery($group_by_customer, $whereClause, $sort_by, $sort_order);

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$lendingen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <title>BankLoan Pro Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Top navigation -->
    <nav class="bg-gradient-to-r from-blue-900 to-blue-800 p-3 flex justify-between items-center shadow-lg sticky top-0 z-10">
        <div class="flex items-center">
            <div class="text-white text-xl font-bold flex items-center">
                <i class="fas fa-landmark mr-2"></i>
                BankLoan Pro
            </div>
        </div>
        <div class="flex space-x-2">
            <a href="index.php" class="text-white nav-link flex items-center">
                <i class="fas fa-home mr-2"></i>Dashboard
            </a>
            <a href="./pages/add_leningen_page.php" class="text-white nav-link flex items-center">
                <i class="fas fa-plus mr-2"></i>Nieuwe Lening
            </a>
            <a href="./pages/add_klanten_page.php" class="text-white nav-link flex items-center">
                <i class="fas fa-users mr-2"></i>Klanten
            </a>
        </div>
        <div class="flex items-center">
            <div class="bg-white text-blue-900 px-3 py-1 rounded-full text-sm font-medium mr-3">Admin</div>
            <div class="text-white flex items-center">
                <i class="fas fa-user-circle text-2xl"></i>
                <span class="ml-2 mr-1">Ronny Brunswijk</span>
                <i class="fas fa-chevron-down text-xs"></i>
            </div>
        </div>
    </nav>
    <div class="container mx-auto px-4 py-6 max-w-7xl">
        <!-- Page header with breadcrumbs -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
                <div class="flex items-center text-sm text-gray-500 mt-1">
                    <a href="index.php" class="hover:text-blue-600">Home</a>
                    <span class="mx-2">/</span>
                    <span>Dashboard</span>
                </div>
            </div>
            <div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    <a href="./pages/add_leningen_page.php" class="text-white">
                    Nieuwe Lening
                    </a>
                </button>
            </div>
        </div>
        <!-- Statistics cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card total-card bg-white rounded-lg shadow p-5 flex items-start">
                <div class="flex-1">
                    <p class="text-sm text-gray-500 mb-1">Totaal Aantal Leningen</p>
                    <div class="text-3xl font-bold text-gray-800"><?= $totalLoans ?></div>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-chart-bar text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="stat-card approved-card bg-white rounded-lg shadow p-5 flex items-start">
                <div class="flex-1">
                    <p class="text-sm text-gray-500 mb-1">Goedgekeurde Leningen</p>
                    <div class="text-3xl font-bold text-gray-800"><?= $approvedLoans ?></div>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="stat-card rejected-card bg-white rounded-lg shadow p-5 flex items-start">
                <div class="flex-1">
                    <p class="text-sm text-gray-500 mb-1">Afgekeurde Leningen</p>
                    <div class="text-3xl font-bold text-gray-800"><?= $rejectedLoans ?></div>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>
            <div class="stat-card pending-card bg-white rounded-lg shadow p-5 flex items-start">
                <div class="flex-1">
                    <p class="text-sm text-gray-500 mb-1">In Behandeling</p>
                    <div class="text-3xl font-bold text-gray-800"><?= $pendingLoans ?></div>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-hourglass-half text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
  <!-- Filter Form -->
<div class="bg-white rounded-lg shadow-sm mb-8">
    <div class="p-5 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
            <i class="fas fa-filter mr-2 text-blue-600"></i>
            Zoek & Filter Leningen
        </h2>
    </div>
    <form method="GET" action="" class="p-5">
        <!-- Basic filters -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Search input -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Zoek klant</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="search" name="search" placeholder="Naam of e-mail..." 
                           value="<?= htmlspecialchars($search) ?>" 
                           class="filter-input w-full pl-10">
                </div>
            </div>
            <!-- Status filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <div class="relative">
                    <select id="status" name="status" class="filter-select w-full appearance-none">
                        <option value="">Alle statussen</option>
                        <?php foreach ($status_options as $option): ?>
                            <option value="<?= $option ?>" <?= $status_filter === $option ? 'selected' : '' ?>>
                                <?= $option ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
            </div>
            <!-- Groeperen per klant -->
            <div>
                <label for="group_by_customer" class="block text-sm font-medium text-gray-700 mb-1">Groeperen</label>
                <div class="relative">
                    <select id="group_by_customer" name="group_by_customer" class="filter-select w-full appearance-none">
                        <option value="no" <?= $group_by_customer === 'no' ? 'selected' : '' ?>>Uitgeschakeld</option>
                        <option value="yes" <?= $group_by_customer === 'yes' ? 'selected' : '' ?>>Per klant</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Advanced filters section -->
        <div id="advancedFilters" class="border-t border-gray-100 pt-5" <?= $advancedFiltersActive ? '' : 'style="display: none;"' ?>>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <!-- Date range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Datum bereik</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                            <input type="date" id="date_from" name="date_from" 
                                   value="<?= htmlspecialchars($date_from) ?>" 
                                   class="filter-input w-full pl-10">
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                            <input type="date" id="date_to" name="date_to" 
                                   value="<?= htmlspecialchars($date_to) ?>" 
                                   class="filter-input w-full pl-10">
                        </div>
                    </div>
                </div>
                <!-- Amount range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bedrag bereik</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">SRD</span>
                            </div>
                            <input type="number" id="amount_min" name="amount_min" step="0.01" min="0"
                                   placeholder="Min"
                                   value="<?= htmlspecialchars($amount_min) ?>" 
                                   class="filter-input w-full pl-8">
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">SRD</span>
                            </div>
                            <input type="number" id="amount_max" name="amount_max" step="0.01" min="0"
                                   placeholder="Max"
                                   value="<?= htmlspecialchars($amount_max) ?>" 
                                   class="filter-input w-full pl-8">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-between items-center pt-2">
            <a href="#" id="toggleFilters" onclick="toggleAdvancedFilters(); return false;" 
               class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                <i class="fas fa-sliders-h mr-1"></i>
                <span id="toggleText"><?= $advancedFiltersActive ? 'Verberg geavanceerde filters' : 'Toon geavanceerde filters' ?></span>
            </a>
            <div class="space-x-2">
                <a href="./" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition duration-200 inline-block">
                    <i class="fas fa-redo-alt mr-1"></i> Herstel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-search mr-1"></i> Zoeken
                </button>
            </div>
        </div>
    </form>
</div>
 <!-- Loans table -->
<div class="table-container bg-white mb-6">
    <table class="min-w-full loan-table">
        <thead>
            <tr class="table-header">
                <th class="py-3 px-4 text-left">Klant</th>
                <th class="py-3 px-4 text-left"><?= $group_by_customer === 'yes' ? 'Totaal Bedrag' : 'Bedrag' ?></th>
                <th class="py-3 px-4 text-left"><?= $group_by_customer === 'yes' ? 'Aantal Leningen' : 'Looptijd' ?></th>
                <th class="py-3 px-4 text-left">Status</th>
                <th class="py-3 px-4 text-left"><?= $group_by_customer === 'yes' ? '' : 'Rente' ?></th>
                <th class="py-3 px-4 text-left"><?= $group_by_customer === 'yes' ? '' : 'Datum Aanvraag' ?></th>
                <th class="py-3 px-4 text-left">Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($lendingen) > 0): ?>
                <?php foreach ($lendingen as $lening): ?>
                <?php 
                    // Generate a color for the avatar based on customer name
                    $colors = ['bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-pink-500', 'bg-yellow-500', 'bg-indigo-500'];
                    $colorIndex = crc32($lening['klant_naam']) % count($colors);
                    $avatarColor = $colors[$colorIndex];
                ?>
                <tr class="border-t">
                    <td class="py-3 px-4">
                        <div class="flex items-center">
                            <div class="avatar <?= $avatarColor ?>">
                                <?= strtoupper(substr($lening['klant_naam'], 0, 2)) ?>
                            </div>
                            <div class="ml-3">
                                <p class="font-medium text-gray-800"><?= htmlspecialchars($lening['klant_naam']) ?></p>
                                <p class="text-gray-500 text-sm"><?= htmlspecialchars($lening['klant_email']) ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4 font-medium">
                        <?= $group_by_customer === 'yes' 
                            ? 'SRD ' . number_format($lening['totaal_bedrag'], 2, ',', '.') 
                            : 'SRD ' . number_format($lening['lening_bedrag'], 2, ',', '.') ?>
                    </td>
                    <td class="py-3 px-4">
                        <?= $group_by_customer === 'yes' 
                            ? $lening['aantal_leningen'] 
                            : $lening['lening_duur'] . ' maanden' ?>
                    </td>
                    <td class="py-3 px-4">
                        <span class="
                            <?= $lening['lening_status'] === 'In behandeling' ? 'bg-yellow-100 text-yellow-800' : '' ?>
                            <?= $lening['lening_status'] === 'Goedgekeurd' ? 'bg-green-100 text-green-800' : '' ?>
                            <?= $lening['lening_status'] === 'Afgekeurd' ? 'bg-red-100 text-red-800' : '' ?>
                            <?= $lening['lening_status'] === 'Afgesloten' ? 'bg-gray-100 text-gray-800' : '' ?>
                            py-1 px-3 rounded-full text-xs font-medium
                        ">
                            <?= htmlspecialchars($lening['lening_status']) ?>
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <?= $group_by_customer === 'yes' ? '' : number_format($lening['rente'], 2, ',', '.') . '%' ?>
                    </td>
                    <td class="py-3 px-4 text-gray-600">
                        <?= $group_by_customer === 'yes' ? '' : date('d-m-Y', strtotime($lening['datum_aanvraag'])) ?>
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex space-x-1">
                            <?php if ($group_by_customer === 'yes'): ?>
                            <?php else: ?>
                                <!-- Normal view with individual loan actions -->
                                <a href="includes/edit_leningen.php?leningid=<?= $lening['leningid'] ?>" 
                                   class="action-button text-yellow-600" title="Bewerken">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="includes/delete_leningen.php?leningid=<?= $lening['leningid'] ?>" 
                                   onclick="return confirm('Weet je zeker dat je deze lening wilt verwijderen?')" 
                                   class="action-button text-red-600" title="Verwijderen">
                                    <i class="fas fa-trash"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="border-t">
                    <td colspan="7" class="py-12 px-4 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-search text-gray-300 text-5xl mb-3"></i>
                            <p class="text-gray-500 mb-1">Geen leningen gevonden die aan de zoekcriteria voldoen.</p>
                            <p class="text-gray-400 text-sm">Probeer andere zoekfilters of klik op 'Herstel'.</p>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
    <script>
        // Toggle advanced filters
        function toggleAdvancedFilters() {
            const advancedFilters = document.getElementById('advancedFilters');
            const toggleText = document.getElementById('toggleText');
            if (advancedFilters.style.display === 'none') {
                advancedFilters.style.display = 'block';
                toggleText.textContent = 'Verberg geavanceerde filters';
            } else {
                advancedFilters.style.display = 'none';
                toggleText.textContent = 'Toon geavanceerde filters';
            }
        }
    </script>
</body>
</html>