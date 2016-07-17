<?php
	session_start();
	$img_name = $_POST['img_name'];
	$crop_start_x = $_POST['crop_start_x'];
	$crop_start_y = $_POST['crop_start_y'];
	$crop_tool_width = $_POST['crop_tool_width'];
	$crop_tool_height = $_POST['crop_tool_height'];
	$newimgwdt = $_POST['newimgwdt'];
	$newimghgt = $_POST['newimghgt'];
	
	list($width, $height, $type, $attr) = getimagesize("images/$img_name");

	$width1 = $width/$newimgwdt;
	$height1 = $height/$newimghgt;

	$dst_x = 0;
	$dst_y = 0;
	$src_x = $width1*$crop_start_x; //crop start x
	$src_y = $height1*$crop_start_y; //crop start y
	$dst_w = $width1*$crop_tool_width; //Thumb width
	$dst_h = $height1*$crop_tool_height; //Thumb height
	$src_w = $width1*$crop_tool_width;
	$src_h = $height1*$crop_tool_height;
	
	

	$dst_image = imagecreatetruecolor($dst_w, $dst_h);
	if (exif_imagetype("images/$img_name") == IMAGETYPE_JPEG){

		$src_image = imagecreatefromjpeg("images/$img_name");
	
		imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
		$time = explode('.', microtime());
		$time = str_replace(' ', '', $time[1]);
		$rest = substr("images/$img_name", -3); 
		$unicalName1 = $time.'.'.$rest;
		$_SESSION['newnamejpg']=$unicalName1;
		imagejpeg($dst_image,"images/$unicalName1");
	}
	if (exif_imagetype("images/$img_name") == IMAGETYPE_PNG){
		
		$src_image = imagecreatefrompng("images/$img_name");
	
		imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
		$time1 = explode('.', microtime());
		$time1 = str_replace(' ', '', $time[1]);
		$rest = substr("images/$img_name", -3); 
		$unicalName1 = $time.'.'.$rest;
		$_SESSION['newnamepng']=$unicalName2;
		imagepng($dst_image,"images/$unicalName2");

	}

?>
