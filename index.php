<?php
include_once "./JString2.php";
$str = JString2::from("Hello");
$str->substring(1,5);
echo $str;