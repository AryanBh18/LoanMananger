<?php
require 'config.php';

// Initialize variables
$klanten = [];
$zoekterm = '';
$geselecteerde_klant = null;
$zoekresultaten = [];
$error_message = '';
$success_message = '';

// Haal alle klanten op voor de dropdown
$stmt = $pdo->query("SELECT klantid, klant_naam, klant_email FROM klanten ORDER BY klant_naam");
$klanten = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verwerk het zoekformulier als dat is ingediend
if (isset($_POST['zoeken']) && !empty($_POST['zoekterm'])) {
    $zoekterm = trim($_POST['zoekterm']);
    
    // Zoek klanten die overeenkomen met de zoekterm
    $stmt = $pdo->prepare("SELECT klantid, klant_naam, klant_email FROM klanten 
                           WHERE klant_naam LIKE ? OR klant_email LIKE ? 
                           ORDER BY klant_naam LIMIT 10");
    $stmt->execute(['%' . $zoekterm . '%', '%' . $zoekterm . '%']);
    $zoekresultaten = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Verwerk de klantselectie
if (isset($_POST['select_klant']) && !empty($_POST['klantid'])) {
    $klantid = $_POST['klantid'];
    
    // Haal de geselecteerde klant op
    $stmt = $pdo->prepare("SELECT klantid, klant_naam, klant_email FROM klanten WHERE klantid = ?");
    $stmt->execute([$klantid]);
    $geselecteerde_klant = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Verwerk het leningformulier
if (isset($_POST['submit_lening'])) {
    $klantid = $_POST['klantid'] ?? null;
    $lening_bedrag = $_POST['lening_bedrag'] ?? null;
    $lening_duur = $_POST['lening_duur'] ?? null;
    $rente = $_POST['rente'] ?? null;
    
    // Valideer de invoer
    if (empty($klantid)) {
        $error_message = "Selecteer eerst een klant.";
    } elseif (empty($lening_bedrag) || empty($lening_duur) || empty($rente)) {
        $error_message = "Alle velden zijn verplicht.";
    } else {
        // Voeg de lening toe
        $stmt = $pdo->prepare("INSERT INTO leningen (klantid, lening_bedrag, lening_duur, rente, datum_aanvraag) 
                               VALUES (?, ?, ?, ?, CURDATE())");
        
        if ($stmt->execute([$klantid, $lening_bedrag, $lening_duur, $rente])) {
            $success_message = "De lening is succesvol aangemaakt.";
            // Haal de geselecteerde klant op voor weergave
            $stmt = $pdo->prepare("SELECT klantid, klant_naam, klant_email FROM klanten WHERE klantid = ?");
            $stmt->execute([$klantid]);
            $geselecteerde_klant = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $error_message = "Er is een fout opgetreden bij het aanmaken van de lening.";
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
        <a href="../index.php" class="text-white flex items-center"><i class="fas fa-arrow-left mr-2"></i>Terug</a>
    </nav>
    
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4">Nieuwe Lening Toevoegen</h1>
        
        <?php if (!empty($error_message)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($success_message)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        
        <!-- Klant zoeken -->
        <div class="bg-white p-4 rounded shadow mb-6">
            <h2 class="text-xl font-bold mb-4">Stap 1: Selecteer een klant</h2>
            
            <!-- Zoekformulier -->
            <form method="POST" class="mb-4">
                <div class="flex gap-2">
                    <input type="text" name="zoekterm" placeholder="Zoek op naam of e-mail" 
                           value="<?php echo htmlspecialchars($zoekterm); ?>" 
                           class="flex-1 p-2 border rounded">
                    <button type="submit" name="zoeken" class="bg-blue-600 text-white p-2 rounded">Zoeken</button>
                </div>
            </form>
            
            <!-- Zoekresultaten -->
            <?php if (!empty($zoekresultaten)): ?>
                <div class="border rounded mb-4">
                    <div class="bg-gray-100 p-2 font-bold">Zoekresultaten</div>
                    <div class="divide-y">
                        <?php foreach ($zoekresultaten as $klant): ?>
                            <form method="POST" class="p-2 hover:bg-gray-50">
                                <input type="hidden" name="klantid" value="<?php echo $klant['klantid']; ?>">
                                <div>
                                    <span class="font-medium"><?php echo htmlspecialchars($klant['klant_naam']); ?></span>
                                    <span class="text-gray-600 ml-2"><?php echo htmlspecialchars($klant['klant_email']); ?></span>
                                </div>
                                <button type="submit" name="select_klant" class="text-blue-600 text-sm mt-1">
                                    Selecteer deze klant
                                </button>
                            </form>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Dropdown met alle klanten -->
            <form method="POST">
                <div class="flex gap-2">
                    <select name="klantid" class="flex-1 p-2 border rounded">
                        <option value="">-- Selecteer een klant --</option>
                        <?php foreach ($klanten as $klant): ?>
                            <option value="<?php echo $klant['klantid']; ?>">
                                <?php echo htmlspecialchars($klant['klant_naam'] . ' (' . $klant['klant_email'] . ')'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="select_klant" class="bg-blue-600 text-white p-2 rounded">Selecteren</button>
                </div>
            </form>
        </div>
        
        <!-- Leningformulier -->
        <?php if ($geselecteerde_klant): ?>
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-bold mb-4">Stap 2: Vul leninggegevens in</h2>
                
                <div class="bg-blue-50 p-3 rounded border border-blue-200 mb-4">
                    <div class="font-bold">Geselecteerde klant:</div>
                    <div><?php echo htmlspecialchars($geselecteerde_klant['klant_naam']); ?></div>
                    <div class="text-gray-600"><?php echo htmlspecialchars($geselecteerde_klant['klant_email']); ?></div>
                </div>
                
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="klantid" value="<?php echo $geselecteerde_klant['klantid']; ?>">
                    
                    <label class="block">
                        <span class="font-medium">Leningbedrag:</span>
                        <input type="number" step="0.01" name="lening_bedrag" required 
                               class="w-full p-2 border rounded mt-1">
                    </label>
                    
                    <label class="block">
                        <span class="font-medium">Leningduur (maanden):</span>
                        <input type="number" name="lening_duur" required 
                               class="w-full p-2 border rounded mt-1">
                    </label>
                    
                    <label class="block">
                        <span class="font-medium">Rente (%):</span>
                        <input type="number" step="0.01" name="rente" required 
                               class="w-full p-2 border rounded mt-1">
                    </label>
                    
                    <button type="submit" name="submit_lening" 
                            class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded w-full">
                        Lening toevoegen
                    </button>
                </form>
            </div>
        <?php else: ?>
            <div class="bg-yellow-50 p-4 rounded border border-yellow-200 text-center">
                Selecteer eerst een klant om een nieuwe lening aan te maken.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>