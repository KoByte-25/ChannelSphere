<?php
// db.php
function getPdo(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $host = "localhost"; //'your host name';
        $db   = "channel_sphere"; //'your_database_name';
        $user = "root"; //'your_db_user';
        $pass = "root"; //'your_db_password';

        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $pdo = new PDO($dsn, $user, $pass, $options);
    }

    return $pdo;
}

function generateCode(): string
{
    static $id = "";
    // 3 random English letters (A–Z)
    $letters = '';
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i < 3; $i++) {
        $index = random_int(0, strlen($alphabet) - 1);
        $letters .= $alphabet[$index];
    }

    // 4 random digits (0–9)
    $numbers = '';
    for ($i = 0; $i < 4; $i++) {
        $numbers .= random_int(0, 9);
    }

    $id = $letters . $numbers; // e.g. "ABC1234"

    return $id;
}

function checkLabel(string $s): string
{
    static $output = "";

    $labels = [
                "ရေသန့် ဖြန့်ချီရေး" => "ရေသန့်",
                "ဟာလဝါ ဖြန့်ဖြူးရောင်းချရေး" => "ဟာလဝါ"
              ];  

    $output = $labels[$s];
    return $output;
}

function checkUnit(string $s): string
{
    static $output = "";

    $labels = [
                "ရေသန့် ဖြန့်ချီရေး" => "ဘူး",
                "ဟာလဝါ ဖြန့်ဖြူးရောင်းချရေး" => "ဘူး"
              ];  

    $output = $labels[$s];
    return $output;
}
?>