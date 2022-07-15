<?php
// array_map('unlink', glob("$target_dir/*.*"));
array_map('unlink', glob("{../../uploads/*.*,../../intermediary_files/*.*,../../latex/output.*}",GLOB_BRACE));

// upload and move text file
$target_dir = "../../uploads/";
$filename = "input.txt";
$target_file = $target_dir . $filename;
move_uploaded_file($_FILES["uploaded_text"]["tmp_name"], $target_file);

// if necessary: read, convert encoding from ANSI/Win-1252 to UTF-8 and overwrite
$ini_text = file_get_contents($target_file);
if (strcmp(mb_detect_encoding($ini_text, mb_detect_order(), true),"UTF-8")!=0)
{	$conv_text = iconv('CP1252', 'UTF-8', $ini_text);
	$myfile = fopen($target_file, "w") or die("Unable to open file!");
	fwrite($myfile, $conv_text);
	fclose($myfile);
}
?>

<html>
<head>
 <link rel="stylesheet" type="text/css" href="../../style/mystyle.css">
 </head>
<body>
<h2>Word2Image</h2>

Text uploaded successfully.
<br />
<?php
 // echo $_FILES["uploaded_text"]["tmp_name"];
  // echo $target_file;

?>
<br />
 <button onclick="document.location = '../../image_upload.html'">Continue to the next page</button>

</body>
</html>