<?php
require_once 'DB.php';


function countOrders(string $un) : int 
{
    static $noOfOrders = -1;

    $comName = "";
    $comType = "";
    $pdo = getPdo();

    $selectComInfo = "SELECT * from company where com_username = :un";
    $stmtSCI = $pdo->prepare($selectComInfo);
    $stmtSCI->execute(['un' => $un]);
    $resultSCI = $stmtSCI->fetch();
    $comName = $resultSCI['com_name'];
    $comType = $resultSCI['com_type'];

    $selectOrders = "SELECT * from orders where com_name = :cn and material_type = :mt and delivery_status = 'NOT_START_DELIVERY'";
    $stmtO = $pdo->prepare($selectOrders);
    $stmtO->execute([
        'cn' => $comName,
        'mt' => $comType
    ]);
    $resultO = $stmtO->fetchAll();
    $noOfOrders = count($resultO);

    return $noOfOrders;
}
?>