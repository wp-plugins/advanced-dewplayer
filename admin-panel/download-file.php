<?php

$file=$_GET['dew_file'];

header("Content-type:application/mp3");

$fbasename = pathinfo($file);
$file_name = $fbasename['basename'];
// It will be called downloaded.pdf
header("Content-Disposition:attachment;filename=$file_name");

// The PDF source is in original.pdf
readfile($file);
?>