<?php
    require_once '../includes/DB.php';

    $pdo = getPdo();

    $tno = isset($_POST["tno"]) ? $_POST["tno"] : "";
    $oid = isset($_POST["oid"]) ? $_POST["oid"] : "";

    $avail = -1;
    $qty = -1;

    $selectA = "SELECT available from truck where truck_no = :tn";
    $stmtA = $pdo->prepare($selectA);
    $stmtA->execute(['tn' => $tno]);
    $resultA = $stmtA->fetch();
    $avail = $resultA['available'];

    $selectQ = "SELECT qty from orders where orderId = :oi";
    $stmtQ = $pdo->prepare($selectQ);
    $stmtQ->execute(['oi' => $oid]);
    $resultQ = $stmtQ->fetch();
    $qty = $resultQ['qty'];

    $diff = $avail - $qty;

    if($diff > 0)
        {
            //avail updating
            $updateA = "UPDATE truck set available = :a where truck_no = :tn";
            $stmtUA = $pdo->prepare($updateA);
            $stmtUA->execute([ ':a' => $diff, 'tn' => $tno]);

            //deliver table update
            $insertQuery = "INSERT into delivery(orderId, truck_no) values (:oi, :tn)";
            $stmtIQ = $pdo->prepare($insertQuery);
            $stmtIQ->execute([ 'oi' => $oid, 'tn' => $tno]);

            //order status update
            $updateOS = "UPDATE orders set delivery_status='ON_DELIVERY' where orderId = :oi";
            $stmtOS = $pdo->prepare($updateOS);
            $stmtOS->execute([ ':oi' => $oid]);

            header("Location: ./sendOrders.php?tno=$tno&msgType=success&msg=အောင်မြင်စွာ ကားပေါ်တင်ပြီးပါပြီ။");
        }
    
    elseif($diff == 0)
        {
            //avail updating
            $updateA = "UPDATE truck set available = :a where truck_no = :tn";
            $stmtUA = $pdo->prepare($updateA);
            $stmtUA->execute([ ':a' => $diff, 'tn' => $tno]);

            //deliver table update
            $insertQuery = "INSERT into delivery(orderId, truck_no) values (:oi, :tn)";
            $stmtIQ = $pdo->prepare($insertQuery);
            $stmtIQ->execute([ 'oi' => $oid, 'tn' => $tno]);

            //order status update
            $updateOS = "UPDATE orders set delivery_status='ON_DELIVERY' where orderId = :oi";
            $stmtOS = $pdo->prepare($updateOS);
            $stmtOS->execute([ ':oi' => $oid]);

            header("Location: ./sendOrders.php?tno=$tno&msgType=full_warning&msg=အောင်မြင်စွာ ကားပေါ်တင်ပြီးပါပြီ။ သို့သော် ထရပ် နံပါတ် \" $tno \" အတွက် တင်နိုင်သောပမာဏပြည့်သွားပြီဖြစ်သောကြောင့် ထို ထရပ်ကားဖြင့် အော်ဒါများ စတင်ပို့ဆောင်နိုင်ပါပြီ");
        }

    else
        {
            header("Location: ./sendOrders.php?tno=$tno&msgType=warning&msg=ကားပေါ်တင်မှု မအောင်မြင်ပါ။ ထရပ် နံပါတ် \" $tno \" အတွက် တင်နိုင်သောပမာဏ မှာ \" $avail \" ဖြစ်ပြီး တင်ဖို့ကြိုးစားသည့် အော်ဒါ၏ အရေအတွက်မှာ \" $qty \" ဖြစ်ပါတယ်။ တင်နိုင်တဲ့ ပမာဏထပ် ကျော်လွန်နေတာ ဖြစ်တဲ့အတွက် တစ်ခြား အော်ဒါကို ​ရွေးချယ်ပေးပါ။ တစ်ခြား ရွေးချယ်စရာအော်ဒါ မရှိတော့ပါက ထို ထရပ်ကားဖြင့် တင်ထားပြီးသော အော်ဒါများအား စတင်ပို့ဆောင်ပြီး ကျန်ရှိနေသော အော်ဒါများအား နောက် ထရပ်ကား တစ်စီးဖြင့် တင်ပို့နိုင်ပါတယ်။");
        }
?>