<?php
// get, move, name the image
$target_dir = "../../uploads/";
$extens = pathinfo($_FILES["imagelocation"]["name"], PATHINFO_EXTENSION);
$fname = pathinfo($_FILES["imagelocation"]["tmp_name"], PATHINFO_FILENAME);
// $target_file = $target_dir . basename($_FILES["imagelocation"]["name"]);
// $target_file2 = $target_dir . basename($_FILES["imagelocation"]["tmp_name"]);
$target_file3 = $target_dir . $fname . '.' . $extens;
$temp_name = $_FILES["imagelocation"]["tmp_name"];
move_uploaded_file($temp_name, $target_file3 );

$slen=strlen($_POST["all_words"]);
$listEntry= substr($_POST["all_words"],0,$slen-1) . ',"' .basename($target_file3). '":"image"}';
// echo $listEntry;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
 <link rel="stylesheet" type="text/css" href="../../style/mystyle.css">
  <script src="../javascript/myScript.js"></script> 
 </head>

<body onload="addToReplacementList()">
<a href="../../index.html"> <h2>Word2Image </h2> </a>

Image uploaded successfully.
</br>
<p id="listEntry" hidden="hidden">
<?php
echo $listEntry;
?>
<p />
<br />
<?php
 // echo $temp_name; 
?>
<br />
<p> If you wish to replace more words with images, click the button below. <p />
 <button onclick="document.location = '../../image_upload.html'">Add more word-image associations</button>

<br />
<p> If you have changed your mind about the previous words to be replaced, click the button below to change them. <p />
 <button onclick="document.location = '../../review_finalize.html'">Review previous associations</button>
 
 <br />
<p> If you are done with the associations and wish to create your document, click the button below. <p />
 <button onclick="document.location = '../../review_finalize.html'">Create document</button>
</body>
</html>