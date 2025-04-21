<?php
$current_file=$_SERVER['REQUEST_URI'];
echo $current_file;
$current_file=explode("/",$current_file);
$current_file=$current_file[count($current_file)-1];
$target_file="../classes/".$current_file;


if (file_exists($target_file)) {
echo "The file $target_file exists";
} else {
echo "The file $target_file does not exist";
}
include_once("../classes/".$current_file);