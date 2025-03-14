<?php
// Aryan Bhaggoe!!! als dit is voor die groepering van die ene thingy die juf heeft veranderd
function buildQuery($group_by_customer, $whereClause, $sort_by, $sort_order) {
    if ($group_by_customer === 'yes') {
        $query = "
            SELECT 
                k.klantid,
                k.klant_naam,
                k.klant_email,
                l.lening_status,
                SUM(l.lening_bedrag) AS totaal_bedrag,
                COUNT(*) AS aantal_leningen
            FROM leningen l
            JOIN klanten k ON l.klantid = k.klantid
            $whereClause
            GROUP BY k.klantid, l.lening_status
            ORDER BY k.klant_naam ASC, FIELD(l.lening_status, 'Goedgekeurd', 'In behandeling', 'Afgekeurd', 'Afgesloten')
        ";
    } else {
        // Default query without grouping
        $query = "
            SELECT l.leningid, k.klant_naam, k.klant_email, l.lening_bedrag, 
                   l.lening_duur, l.rente, l.lening_status, l.datum_aanvraag
            FROM leningen l
            JOIN klanten k ON l.klantid = k.klantid
            $whereClause
            ORDER BY " . ($sort_by === 'klant_naam' ? 'k.klant_naam' : "l.$sort_by") . " $sort_order
        ";
    }

    return $query;
}