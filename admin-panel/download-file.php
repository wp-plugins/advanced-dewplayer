<?php

$file=$_GET['dew_file'];

$fbasename = pathinfo($file);
$file_name = $fbasename['basename'];
$file_dir = $fbasename['dirname']."/";
//$download = rawurlencode($file_name);

$data = str_replace(' ','%20',$file);

//header("Content-type:application/mp3");
header("Content-type:application/octet-stream");
header("Content-Disposition:attachment;filename=".$file_name);

header('Pragma: no-cache');
header('Expires: 0');
readfile($data);
?>