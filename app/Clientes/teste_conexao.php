<?php
$hosts = ['127.0.0.1', 'localhost'];
$portas = [3306, 3307, 3308];

foreach ($hosts as $h) {
    foreach ($portas as $p) {
        $fp = @fsockopen($h, $p, $errno, $errstr, 1);
        echo "$h:$p => " . ($fp ? 'ABERTA (tem algo escutando)' : 'fechada') . "<br>";
        if ($fp) fclose($fp);
    }
}
echo '<hr>pdo_mysql: ' . (extension_loaded('pdo_mysql') ? 'ativo' : 'NÃO ATIVO');