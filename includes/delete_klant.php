<?php
require 'config.php';

if (!isset($_GET['id'])) {
    die("Geen klant ID opgegeven.");
}

$klantid = intval($_GET['id']);

try {
    $pdo->beginTransaction();

    // Check if the klant exists
    $stmt = $pdo->prepare("SELECT klantid FROM klanten WHERE klantid = ?");
    $stmt->execute([$klantid]);
    $klant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$klant) {
        $pdo->rollBack();
        die("Klant niet gevonden.");
    }

    // Checken voor goedgekeurde leningen
    $stmt = $pdo->prepare("
        SELECT COUNT(*) AS goedgekeurde_leningen 
        FROM leningen 
        WHERE klantid = ? AND lening_status = 'Goedgekeurd'
    ");
    $stmt->execute([$klantid]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['goedgekeurde_leningen'] > 0) {
        $pdo->rollBack();
        echo "<script>
                alert('Deze klant heeft goedgekeurde leningen en kan niet worden verwijderd.');
                window.location.href = '../pages/add_klanten_page.php';
              </script>";
        exit;
    }

    // Delete the klant
    $stmt = $pdo->prepare("DELETE FROM klanten WHERE klantid = ?");
    $stmt->execute([$klantid]);

    $pdo->commit();

    header("Location: ../pages/klanten.php?message=Klant succesvol verwijderd.");
    exit;

} catch (PDOException $e) {
    $pdo->rollBack();
    error_log("Fout bij het verwijderen van klant: " . $e->getMessage());
    die("Er is een fout opgetreden bij het verwijderen van de klant. Probeer het later opnieuw.");
}
?>