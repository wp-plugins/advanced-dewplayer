<?php

$file=$_GET['dew_file'];

header("Content-type:application/mp3");

// It will be called downloaded.pdf
header("Content-Disposition:attachment;filename='$file'");

// The PDF source is in original.pdf
readfile($file);
?>