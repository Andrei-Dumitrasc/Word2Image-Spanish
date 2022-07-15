<?php
$word=$_REQUEST["word"];

$cmd='python ../python/SpanishForms.py ' . $word . ' 2>&1';
$mystring = exec($cmd, $a,$retval);
$spanish_text = file_get_contents("../../intermediary_files/SpanishForms.txt");
echo($spanish_text);

return;
////// Reusable bits 
$cmd=escapeshellarg('python ../python/SpanishForms.py ' . $word . ' 2>&1' );
// escapeshellarg seems to change something important => crash
$cmd=escapeshellarg('python 2>&1' );
$mystring = exec('python', $pyout, $retval);

echo $cmd;
echo($mystring);
foreach ($pyout as $value) {
  echo $value;
}

$mystring = exec('python ../python/SpanishForms.py ' . $word . ' 2>&1' , $a,$retval);
passthru(escapeshellarg('python ../python/SpanishForms.py ' . $word ), $retval);
echo($retval);
echo(json_encode(utf8_encode ($spanish_text)));
?>