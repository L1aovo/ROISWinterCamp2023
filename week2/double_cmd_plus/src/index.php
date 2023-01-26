<?php
highlight_file(__FILE__);
error_reporting(0);
print ("easy lfi, but no flag~~");
$cmd = $_POST['cmd'];
//flag in /flag
if (isset($cmd)) {
    print ("first one:" . "<br>");
    $cmd = preg_replace("/flag/i", '', $cmd);
    echo $cmd;
    if (preg_match("/flag/i", $cmd)) {
        include($cmd);
    }
}