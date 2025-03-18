<?php
    // Basis filters
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $status_filter = isset($_GET['status']) ? $_GET['status'] : '';
    $date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
    $date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
    $amount_min = isset($_GET['amount_min']) ? $_GET['amount_min'] : '';
    $amount_max = isset($_GET['amount_max']) ? $_GET['amount_max'] : '';
    $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'datum_aanvraag';
    $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'DESC';
    
    $status_query = $pdo->query("SELECT DISTINCT lening_status FROM leningen");
    $status_options = $status_query->fetchAll(PDO::FETCH_COLUMN);

    $whereConditions = [];
    $params = [];
    if (!empty($search)) {
        $whereConditions[] = "(k.klant_naam LIKE ? OR k.klant_email LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }
    if (!empty($status_filter)) {
        $whereConditions[] = "l.lening_status = ?";
        $params[] = $status_filter;
    }
    if (!empty($date_from)) {
        $whereConditions[] = "l.datum_aanvraag >= ?";
        $params[] = $date_from;
    }
    if (!empty($date_to)) {
        $whereConditions[] = "l.datum_aanvraag <= ?";
        $params[] = $date_to;
    }
    if (!empty($amount_min)) {
        $whereConditions[] = "l.lening_bedrag >= ?";
        $params[] = $amount_min;
    }
    if (!empty($amount_max)) {
        $whereConditions[] = "l.lening_bedrag <= ?";
        $params[] = $amount_max;
    }
    $whereClause = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";
?>