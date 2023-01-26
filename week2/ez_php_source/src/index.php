<?php
highlight_file(__FILE__);
error_reporting(0);
print ("Now hackers, if you win the game, I will show you the flag. Try!!!<br>");

if ($_POST['a'] == 405 && $_GET['b'] == 408) {
    print ("nice!! you pass the first php game!<br>");

    if ($_POST['c'] !== $_POST['d'] && md5($_POST['c']) === md5($_POST['d'])) {
        print ("you are so cute, but it's not over");

        if (isset($_POST['last1'])&&isset($_GET['last2'])&&urlencode($_POST['last1']) == urldecode($_GET['last2'])&&$_POST['last1']=='TheBestLanguage====PHP') {
            print ("You win, now show you the flag!!!");
            system("cat /flag");
        }
        else {
            echo urlencode($_POST['last1']);
            echo urldecode($_GET['last2']);
            die ('it is the last one!');
        }
    } else {
        die("but hacker, you can't change the end!!! <!-- something trick in php, you can find many tricks in https://book.hacktricks.xyz/ -->");
    }
} else {
    die("nonono, you are failed");
}




