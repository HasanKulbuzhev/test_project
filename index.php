<?php
include_once "./JString2.php";
$str = JString2::from("Hello");
$str->reverse();
echo $str;