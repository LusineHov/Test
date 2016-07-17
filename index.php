<?php
$mysqli = new mysqli("localhost", "root", "", "photogallery");
if ($mysqli->connect_errno) {
    printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
    exit();
}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Image Cropping</title>
		<meta charset="UTF-8">
		<link href="crop-style.css" rel="stylesheet" type="text/css">
		<link href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" >	
		<script src="https://code.jquery.com/jquery-1.9.1.js" ></script>
		<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<script src="index.js" type="text/javascript"></script>
	</head>
	<body>	
		<section>
		<form method="post" enctype="multipart/form-data">
			<input id="choose" type="file" name="photo">
			<input id="add" type="submit" name="addphoto" value="Addphoto">
			
			<div class="image_full_div">
			<?php
			session_start();
				if(isset($_POST['addphoto']) && $_FILES['photo']['error'] == 0){
					$time = explode('.', microtime());
					$time = str_replace(' ', '', $time[1]);
					$rest = substr($_FILES['photo']['name'], -3); 
					$unicalName = $time.'.'.$rest;
					$_SESSION['uN']=$unicalName;
					move_uploaded_file($_FILES['photo']['tmp_name'], './images/'.$unicalName);
					

					$size = getimagesize ("images/".$unicalName);

						$width = $size[0];
						$height = $size[1];
						
						if($width > 550 || $height > 550)
						{
							if($height >= $width)
							{
								echo '<img src="images/'.$unicalName.'" class="new_image" style="height:100%; width:auto;">';
							}
							else
							{
								echo '<img src="images/'.$unicalName.'" class="new_image" style="width:100%; height:auto;">';
							}
						}
						else
						{
							echo '<img src="images/'.$unicalName.'" class="new_image">';
						}


						
					$q = "INSERT INTO photos (`photo`, `status`, `time`) VALUES ('{$unicalName}', '1', '2016-05-16 20:54:48')";
					$addresult = $mysqli->query($q);
				
			?>
			<div id="crop_tool"></div>
			<?php } ?>
			
			<?php 
	$a=$_SESSION['uN'];
	if(isset($_POST['crop'])){
		$newnamejpg=$_SESSION['newnamejpg'];

		$size = getimagesize ("images/".$newnamejpg);

						$width = $size[0];
						$height = $size[1];
						
						if($width > 550 || $height > 550)
						{
							if($height >= $width)
							{
								echo '<img src="images/'.$newnamejpg.'" class="new_image" style="height:100%; width:auto;">';
							}
							else
							{
								echo '<img src="images/'.$newnamejpg.'" class="new_image" style="width:100%; height:auto;">';
							}
						}
						else
						{
							echo '<img src="images/'.$newnamejpg.'" class="new_image">';
						}

					$q = "INSERT INTO photos (`photo`, `status`, `time`) VALUES ('{$newnamejpg}', '1', '2016-05-16 20:54:48')";
					$addresult = $mysqli->query($q);

	}
	if(isset($_POST['submit'])){
		if(exif_imagetype("images/$a") == IMAGETYPE_JPEG){
		$newnamejpg=$_SESSION['newnamejpg'];
		unlink("images/".$newnamejpg);
		$sql = "DELETE FROM photos WHERE photo='{$newnamejpg}'";
		$addresult1 = $mysqli->query($sql);
		}
		if(exif_imagetype("images/$a") == IMAGETYPE_PNG){
		$newnamepng=$_SESSION['newnamepng'];
		unlink("images/".$newnamepng);	
		$sql = "DELETE FROM photos WHERE photo='{$newnamepng}'";
		$addresult1 = $mysqli->query($sql);
		}
		//$size = getimagesize ("images/".$a);

						//$width = $size[0];
						//$height = $size[1];

		//if($width > 550 || $height > 550)
						//{
							//if($height >= $width)
							//{
							//	echo '<img src="images/'.$a.'" class="new_image" style="height:100%; width:auto;">';
							//}
							//else
							//{
							//	echo '<img src="images/'.$a.'" class="new_image" style="width:100%; height:auto;">';
							//}
						//}
						//else
						//{
						//	echo '<img src="images/'.$a.'" class="new_image">';
						//}
						//echo "<div id='crop_tool'></div>";
	}

	if(isset($_POST['submit1'])){
		unlink("images/$a");
		$sql = "DELETE FROM photos WHERE photo='{$a}'";
		$addresult1 = $mysqli->query($sql);
		//header('location:index.php');
	}

?>
			</div>
				<form id="form" method="post">
				<button id="crop_btn" name="crop" img_name="<?php echo $unicalName; ?>">Crop Image</button>
				<input id="cansel" type="submit" name="submit" value="Cansel">
				<input id="save" type="submit" name="submit1" value="Save">
			</form>
		</form>
		</section>
	</body>
</html>
