<?php
$user = $_POST['user'];
$pass = $_POST['pass'];

if($user == "admin"
&& $pass == "admin")
{
        
	$dir          = 'images/';
	$file_display = array(
	    'jpg',
	    'jpeg',
	    'png',
	    'gif'
	);
	$previous_uploader = '';

	if (file_exists($dir) == false) {
	    echo 'Directory \'', $dir, '\' not found!';
	} else {
	    foreach (scandir($dir) as $file) {
	    	if(substr($file, 0, 1) == '.') continue;
	    	?>
	    	<h2><?php echo $file ?></h2>
	    	<?php
		foreach(scandir($dir."/".$file) as $img){
			if(substr($img, 0, 1) == '.') continue;
			echo "<img src='images/{$file}/{$img}' width='800px' border='1'><br />\n";
			try{
		          $exif_data = exif_read_data ( $dir."/".$file."/".$img );
		          $title = "Uploaded: " . date ("F d Y H:i:s.", $exif_data['FileDateTime']) . "<br />".
		            	"Filesize: " . human_filesize($exif_data['FileSize']). "<br />";
		            echo $title;
 	            }catch (Exception $e) { 
 	            	$title = "";
		    }

		}
	    }
	}
	
}
else
{
    if(isset($_POST))
    {?>

            <form method="POST" action="">
            Username <input type="text" name="user"></input><br/>
            Password <input type="password" name="pass"></input><br/>
            <input type="submit" name="submit" value="Go"></input>
            </form>
    <?}
}

function human_filesize($bytes, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

?>
