<?php
$listContents=$_POST["finallist"];
$listContents= str_replace("*","\n",$listContents);

$my_fname="../../intermediary_files/replacementList.txt";
$myfile = fopen($my_fname, "w");
fwrite($myfile, $listContents);
fclose($myfile);
file_put_contents($my_fname, mb_convert_encoding($listContents, 'UTF-8', 'CP1252'));
$mystring = system('python ../python/replacer.py', $retval);
?>

<html>
<head>
 <link rel="stylesheet" type="text/css" href="../../style/mystyle.css">
 </head>
 
<body>
<br />
<p> Your document is ready for download. <p /> 
<button  style="padding:-2px" >
    <a href="../../latex/output.pdf" download="Word2Image.pdf">Download PDF</a>
</button>
<br />

<br />
<p> If you wish to have another text including images, click on the link below. <p /> 
 <button onclick="document.location = '../../text_upload.html'">Create a new PDF</button>

</body>
</html>