<head>
<body>
<form method='post' action=''> <!--admin.php'>-->
	<input type='file' name='uploadfile'><br>
    <input type='text' name = 'changeThis' value='change This'><br>
    <input type='text' name = 'changeTo' value='change It To'><br>
	<input type='submit' name= 'btnConfirm'>
</form>


<form>
  <input class="upload" type="file" id="uploadOne" name="uploadOne" onchange="setfilename(this.value);" value="Select File"/ >
  <input id="uploadFile" name="uploadFileOne" type="text" disabled="disabled" placeholder="EWIS" class="name-info-form file-witdth" />
</form>

<?php
//tool_gather_all_php_in_one_file.php
// this program gathers all php files in the current working directory
// and puts them in 1 php file in which one can change and search and alter 



$gather = '';
$files =  scandir (getcwd());
//print_r ($files);
foreach ($files as $file) {    echo $file; echo "<br>"; }

$outFilename = '_______gathered_php_FILES.php';
foreach($files as $value) 
    { 
        $file_parts = pathinfo($value);
        $basename = basename($value);
        $first4letters = substr($basename,0,strlen('tool'));
        if (
                $value != $outFilename &&
                $file_parts['extension']  == 'php' && 
                $first4letters != 'tool'  // don't include php tool files
            ) 
            {
                print_r (  $value ); echo "<br>";
                $curCont = file_get_contents( $value );
                $gather .= $curCont;
                file_put_contents($outFilename, $gather);
            }
    }

