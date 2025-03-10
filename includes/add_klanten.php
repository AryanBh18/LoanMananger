<?php
require 'config.php';

$message = '';

// Handle the form submission for adding a new client
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize input values
    $klant_naam = trim($_POST['klant_naam']);
    $klant_email = trim($_POST['klant_email']);
    $klant_telefoon = trim($_POST['klant_telefoon']);
    $klant_address = trim($_POST['klant_address']);
    $geboorte_datum = trim($_POST['geboorte_datum']);
    
    // Check if the customer already exists in the klanten table based on name and email
    $stmt = $pdo->prepare("SELECT klantid FROM klanten WHERE klant_naam = ? AND klant_email = ?");
    $stmt->execute([$klant_naam, $klant_email]);
    $klantid = $stmt->fetchColumn();
    
    if ($klantid) {
        // Client already exists
        $message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">Client bestaat al.</div>';
    } else {
        // Client does not exist, proceed to insert the new client
        $stmt = $pdo->prepare("INSERT INTO klanten (klant_naam, klant_email, klant_telefoon, klant_address, geboorte_datum, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        if ($stmt->execute([$klant_naam, $klant_email, $klant_telefoon, $klant_address, $geboorte_datum])) {
            // Insertion successful
            $message = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">Klant is succesvol toegevoegd!</div>';
        } else {
            // Insertion failed
            $message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">Er is een fout opgetreden bij het toevoegen van de klant.</div>';
        }
    }
}

// Fetch all clients from the database
$stmt = $pdo->prepare("SELECT * FROM klanten ORDER BY klant_naam ASC");
$stmt->execute();
$klanten = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Klantenoverzicht - BankLoan Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-900 p-4 flex justify-between items-center">
        <div class="text-white text-xl font-bold">BankLoan Pro</div>
        <a href="../index.php" class="text-white flex items-center"><i class="fas fa-home mr-2"></i>Terug</a>
    </nav>
    
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Klantenbeheer</h1>
        
        <!-- Display message if any -->
        <?php echo $message; ?>
        
        <!-- Add New Client Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Nieuwe Klant Toevoegen</h2>
            <form method="POST" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                        <input type="text" id="klant_telefoon" name="klant_telefoon" required class="w-full p-2 border rounded">
                    </label>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <label for="klant_address" class="block">
                        Adres:
                        <input type="text" id="klant_address" name="klant_address" required class="w-full p-2 border rounded">
                    </label>
                    <label for="geboorte_datum" class="block">
                        Geboortedatum:
                        <input type="date" id="geboorte_datum" name="geboorte_datum" required class="w-full p-2 border rounded">
                    </label>
                </div>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                    <i class="fas fa-plus mr-2"></i>Klant Toevoegen
                </button>
            </form>
        </div>
        
        <!-- Clients Table -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Klantenoverzicht</h2>
                <input type="text" id="zoekKlant" placeholder="Zoek klant..." class="p-2 border rounded" onkeyup="filterTable()">
            </div>
            
            <?php if (count($klanten) > 0): ?>
                <div class="overflow-x-auto">
                    <table id="klantenTabel" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefoon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adres</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Geboortedatum</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aangemaakt op</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($klanten as $klant): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($klant['klantid']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($klant['klant_naam']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($klant['klant_email']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($klant['klant_telefoon']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($klant['klant_address']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($klant['geboorte_datum']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($klant['created_at']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="./edit_klant.php?id=<?php echo $klant['klantid']; ?>" class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fas fa-edit"></i> Bewerken
                                        </a>
                                       
                                        <a href="./delete_klant.php?id=<?php echo $klant['klantid']; ?>" 
                                           onclick="return confirm('Weet je zeker dat je deze klant wilt verwijderen?')" 
                                           class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i> Verwijderen
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
                    <p>Er zijn nog geen klanten toegevoegd.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    function filterTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("zoekKlant");
        filter = input.value.toUpperCase();
        table = document.getElementById("klantenTabel");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            // Skip header row
            if (i === 0) continue;
            
            td = tr[i].getElementsByTagName("td")[1]; // Name column
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    </script>
</body>
</html>