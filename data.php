<?php
require './includes/config.php';

try {
    // Voeg klanten toe
    $stmt = $pdo->prepare("INSERT INTO klanten (klant_naam, klant_email, klant_telefoon) VALUES (?, ?, ?)");
    $customers = [
        ['Jan Jansen', 'jan@example.com', '0612345678'],
        ['Petra de Vries', 'petra@example.com', '0687654321'],
        ['Mark Bakker', 'mark@example.com', '0655555555'],
        ['Anna Pieters', 'anna@example.com', '0611111111'],
    ];
    foreach ($customers as $customer) {
        $stmt->execute($customer);
    }

    // Voeg leningen toe
    $stmt = $pdo->prepare("INSERT INTO leningen (klantid, lening_bedrag, lening_duur, rente, lening_status, datum_aanvraag) VALUES (?, ?, ?, ?, ?, ?)");
    $loans = [
        [1, 25000, 60, 4.5, 'In behandeling', '2023-01-15'],
        [2, 10000, 36, 3.2, 'Goedgekeurd', '2023-02-10'],
        [3, 50000, 120, 5.0, 'Afgekeurd', '2023-03-05'],
        [4, 15000, 48, 4.0, 'Afgesloten', '2023-04-20'],
    ];
    foreach ($loans as $loan) {
        $stmt->execute($loan);
    }

    echo "Testdata succesvol toegevoegd!";
} catch (Exception $e) {
    echo "Fout bij het toevoegen van testdata: " . $e->getMessage();
}
?>