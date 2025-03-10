<?php
// Calculate statistics using single optimized query
$statsQuery = $pdo->query("
    SELECT 
        COUNT(*) AS total,
        SUM(lening_status = 'Goedgekeurd') AS approved,
        SUM(lening_status = 'Afgekeurd') AS rejected,
        SUM(lening_status = 'In behandeling') AS pending
    FROM leningen
");
$stats = $statsQuery->fetch(PDO::FETCH_ASSOC);

// Extract statistics
$totalLoans = $stats['total'];
$approvedLoans = $stats['approved'];
$rejectedLoans = $stats['rejected'];
$pendingLoans = $stats['pending'];
?>