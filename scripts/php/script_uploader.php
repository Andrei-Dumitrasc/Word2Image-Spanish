<?php

// upload and move text file
$target_dir = "../../uploads/";
$filename = $_FILES["uploaded_script"]["name"];
$target_file = $target_dir . $filename;
move_uploaded_file($_FILES["uploaded_script"]["tmp_name"], $target_file);

if (strcmp($filename, "executor.py")==0){
	$cmd_str = 'python '.$target_file;
	// $cmd_str = 'cmd /K  ../../u/'.$target_file;
	$ret_str = system($cmd_str, $ret_val);
	// exec('move Alice.txt ../../uploads/Alice.txt');
	echo $cmd_str.'\n';
	echo $ret_str;
	echo $ret_val;
}
?>

<html>
<head>
 <link rel="stylesheet" type="text/css" href="../../style/mystyle.css">
 </head>
<body>
  <a href="index.html"> <h2>Word2Image </h2> </a>   

File uploaded successfully.
<p>
<?php
	// echo $_FILES["uploaded_script"]["name"];
	echo $target_file;
?>
</p>
 <button onclick="document.location = '../../script_upload.html'">Upload more</button>

</body>
</html>