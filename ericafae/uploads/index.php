<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Multiple File Upload</title>
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<style>
.body{
	margin-left:50px;
}
</style>
</head>
<body>
<div class="body">
<h2>Wedding photos - upload</h2>
<p>We&apos;d love to see your photos of the day[s]. You can upload them to us here.</p>
  <form action="" method="post" enctype="multipart/form-data">
  Your name (this is important to get right so we know whose images they are!):<br />
    <p><input type="text" name="name" /></p>
    <p>Then, select the photos from your computer and attach them with the "Choose files" button.<br />
    (you can select multiple images with the &apos;cmd&apos; key)</p>
    <p><input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" /></p>
    <p>Then hit this "upload" button.</p>
  <input type="submit" value="Upload!" />
</form>
<p>Thanks! You&apos;re done!! Can&apos;t wait to see them all!!!</p>
</div>
</body>
</html>

<?php
$valid_formats = array("jpg", "jpeg", "png", "gif", "zip", "bmp");
$max_file_size = 1024*100*100; //100 kb * 100
$path = "images/"; // Upload directory
$count = 0;

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
	if(isset($_POST['name']))
		$user = preg_replace("/[^A-Za-z0-9]/", "", $_POST['name']);

	if($user == "")
		$user = "unknown";

	if(!file_exists($path.$user))
		mkdir($path.$user);

	// Loop $_FILES to exeicute all files
	foreach ($_FILES['files']['name'] as $f => $name) {     
	    if ($_FILES['files']['error'][$f] == 4) {
	        continue; // Skip file if any error found
	    }	       
	    if ($_FILES['files']['error'][$f] == 0) {	           
	        if ($_FILES['files']['size'][$f] > $max_file_size) {
	            $message[] = "$name is too large!.";
	            continue; // Skip large files
	        }
			elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
				$message[] = "$name is not a valid format";
				continue; // Skip invalid file formats
			}
	        else{ // No error found! Move uploaded files 
	            if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$user."/".$name))
	            $count++; // Number of successfully uploaded file
	        }
	    }
	}
	?>
Successfully uploaded <?php echo $count ?> images.<br />
<?php }

?>