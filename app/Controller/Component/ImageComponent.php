<?php
/*
File: /app/controllers/components/image.php
*/
class ImageComponent extends Component
{
        /*
        *       Uploads an image and its thumbnail into $folderName/big and $folderName/small respectivley.
        *       the  generated thumnail could either have the same aspect ratio as the uploaded image, or could
        *       be a zoomed and cropped version.
       
        *       Directions:
        *       In view where you upload the image, make sure your form creation is similar to the following
        *       <?= $form->create('FurnitureSet',array('type' => 'file')); ?>
        *
        *       In view where you upload the image, make sure that you have a file input similar to the following
        *       <?= $form->file('Image/name1'); ?>
        *       
        *       In the controller, add the component to your components array
        *       var $components = array("Image");
        *
        *       In your controller action (the parameters are expained below)
        *       $image_path = $this->Image->upload_image_and_thumbnail($this->request->data,"name1",573,80,"sets",true);
        *       this returns the file name of the result image.  You can  store this file name in the database
        *
        *       Note that your image will be stored in 2 locations:
        *       Image: /webroot/img/$folderName/big/$image_path
        *       Thumbnail:  /webroot/img/$folderName/small/$image_path
        *
        *       Finally in the view where you want to see the images
        *       <?= $html->image('sets/big/'.$furnitureSet['FurnitureSet']['image_path']);
        *       where "sets" is the folder name we saved our pictures in, and $furnitureSet['FurnitureSet']['image_path'] is the file name we stored in the database
       
        *       Parameters:
        *       $data: CakePHP data array from the form
        *       $datakey: key in the $data array. If you used <?= $form->file('Image/name1'); ?> in your view, then $datakey = name1
        *       $imgscale: the maximum width or height that you want your picture to be resized to
        *       $thumbscale: the maximum width or height that you want your thumbnail to be resized to
        *       $folderName: the name of the parent folder of the images. The images will be stored to /webroot/img/$folderName/big/ and  /webroot/img/$folderName/small/
        *       $square: a boolean flag indicating whether you want square and zoom cropped thumbnails, or thumbnails with the same aspect ratio of the source image
        */     
        function upload_image_and_thumbnail($data, $imgscale, $thumbscale, $folderName, $square,$prefix) {
        	if (strlen($data['name'])>4){
                                        $error = 0;
                                        $tempuploaddir = "img/temp"; // the /temp/ directory, should delete the image after we upload
                                        $biguploaddir = "img/".$folderName."/big"; // the /big/ directory
                                        $smalluploaddir = "img/".$folderName."/small"; // the /small/ directory for thumbnails
                                        $originaluploaddir="img/".$folderName;
                                       
                                        // Make sure the required directories exist, and create them if necessary
                                        if(!is_dir($tempuploaddir)) mkdir($tempuploaddir,true);
                                        if(!is_dir($biguploaddir)) mkdir($biguploaddir,true);
                                        if(!is_dir($smalluploaddir)) mkdir($smalluploaddir,true);
                                       
                                        $filetype = $this->getFileExtension($data['name']);
                                        $filetype = strtolower($filetype);
 
                                        if (($filetype != "jpeg")  && ($filetype != "jpg") && ($filetype != "gif") && ($filetype != "png"))
                                        {
                                                // verify the extension
                                                return;
                                        }
                                        else
                                        {
                                                // Get the image size
                                                $imgsize = GetImageSize($data['tmp_name']);
                                        }
 
                                        // Generate a unique name for the image (from the timestamp)
                                     /*   $id_unic = str_replace(".", "", strtotime ("now"));
                                        $filename = $id_unic;
                                          
                                        settype($filename,"string");
                                        $filename.= ".";
                                        $filename.=$filetype;*/
                                        $data['name'] = preg_replace("![^a-z0-9.]+!i", "-", $data['name']);
                                        $filename = $prefix.$data['name'];
                                        $tempfile = $tempuploaddir . "/$filename";
                                        $resizedfile = $biguploaddir . "/$filename";
                                        $croppedfile = $smalluploaddir . "/$filename";
                                        $originalfile=$originaluploaddir. "/$filename";
                                       
                                       
                                        if (is_uploaded_file($data['tmp_name']))
                    {                   
                                                // Copy the image into the temporary directory
                        if (!copy($data['tmp_name'],"$tempfile"))
                        {
                            print "Error Uploading File!.";
                            exit();
                        }
                                                else {       
                                                        /*
                                                         *      Generate the big version of the image with max of $imgscale in either directions
                                                         */
                                                                  
                                                       
                                                        if($square) {
                                                                /*
                                                                 *      Generate the small square version of the image with scale of $thumbscale
                                                                 */
                                                                $this->crop_img($tempfile, $thumbscale, $croppedfile);
                                                                   $this->crop_img($tempfile, $imgscale, $resizedfile);
                                                        }
                                                        else {
                                                                /*
                                                                 *      Generate the big version of the image with max of $imgscale in either directions
                                                                 */
                                                                $this->resize_img($tempfile, $thumbscale, $croppedfile);
                                                                   $this->resize_img($tempfile, $imgscale, $resizedfile);
                                                        }
                                                       
                                                        // Delete the temporary image
                                                        unlink($tempfile);
                                                }
                    }
 
                     // Image uploaded, return the file name
                                         return $filename;
                                       // return true;   
                }
        }
       
        /*
        *       Deletes the image and its associated thumbnail
        *       Example in controller action:  $this->Image->delete_image("1210632285.jpg","sets");
        *
        *       Parameters:
        *       $filename: The file name of the image
        *       $folderName: the name of the parent folder of the images. The images will be stored to /webroot/img/$folderName/big/ and  /webroot/img/$folderName/small/
        */
        function delete_image($filename,$folderName) {
                unlink("img/".$folderName."/big/".$filename);
                unlink("img/".$folderName."/small/".$filename);
                if($folderName == 'portfolio'){
                	unlink("img/".$folderName."/".$filename);
                }
        }
       
    function crop_img($imgname, $scale, $filename) {   
                $filetype = $this->getFileExtension($imgname);
                $filetype = strtolower($filetype);
                          
                switch($filetype){
                        case "jpeg":
                        case "jpg":
                          $img_src = ImageCreateFromjpeg ($imgname);
                         break;
                         case "gif":
                          $img_src = imagecreatefromgif ($imgname);
                         break;
                         case "png":
                          $img_src = imagecreatefrompng ($imgname);
                         break;
                }
               
            $width = imagesx($img_src);
            $height = imagesy($img_src);
            $ratiox = $width / $height * $scale;
            $ratioy = $height / $width * $scale;
                
            //-- Calculate resampling
            $newheight = ($width <= $height) ? $ratioy : $scale;
            $newwidth = ($width <= $height) ? $scale : $ratiox;
               
            //-- Calculate cropping (division by zero)
            $cropx = ($newwidth - $scale != 0) ? ($newwidth - $scale) / 2 : 0;
            $cropy = ($newheight - $scale != 0) ? ($newheight - $scale) / 2 : 0;
               
            //-- Setup Resample & Crop buffers
            $resampled = imagecreatetruecolor($newwidth, $newheight);
            $cropped = imagecreatetruecolor($scale, $scale);
               
            //make png image transparent
            if($filetype=="png"){
            imagealphablending($resampled, false);
 			 imagesavealpha($resampled,true);
            }
            
            //-- Resample
            imagecopyresampled($resampled, $img_src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            
            //make png image transparent
     		 if($filetype=="png"){
           		 imagealphablending($cropped, false);
 				 imagesavealpha($cropped,true);
           	 }
           	 
            //-- Crop
            imagecopy($cropped, $resampled, 0, 0, $cropx, $cropy, $newwidth, $newheight);
 
                // Save the cropped image
                switch($filetype)
                {
                        case "jpeg":
                        case "jpg":
                         imagejpeg($cropped,$filename,80);
                         break;
                         case "gif":
                         imagegif($cropped,$filename,80);
                         break;
                         case "png":
                         imagepng($cropped,$filename,8);
                         break;
                }
    }
       
        function resize_img($imgname, $size, $filename) {
                $filetype = $this->getFileExtension($imgname);
                $filetype = strtolower($filetype);
 
                switch($filetype) {
                        case "jpeg":
                        case "jpg":
                        $img_src = ImageCreateFromjpeg ($imgname);
                        break;
                        case "gif":
                        $img_src = imagecreatefromgif ($imgname);
                        break;
                        case "png":
                        $img_src = imagecreatefrompng ($imgname);
                        break;
                }
 
                $true_width = imagesx($img_src);
                $true_height = imagesy($img_src);
 		//600x300
 		//100x50
 		//300x600
 		//100x200
 			
 			//	$original_ratio = $true_width/$true_height;
 				
                if ($true_width>=$true_height)
                {
                        $width=$size;
                        $height = ($width/$true_width)*$true_height;
                }
                else
                {
                        $width=$size;
                        $height = ($width/$true_width)*$true_height;
                }
                $img_des = ImageCreateTrueColor($width,$height);
                imagecopyresampled ($img_des, $img_src, 0, 0, 0, 0, $width, $height, $true_width, $true_height);
 
                // Save the resized image
                switch($filetype)
                {
                        case "jpeg":
                        case "jpg":
                         imagejpeg($img_des,$filename,80);
                         break;
                         case "gif":
                         imagegif($img_des,$filename,80);
                         break;
                         case "png":
                         imagepng($img_des,$filename,8);   
                         // error_log($img_des."AAAA".$filename);                    
                         break;
                }
        }
 
        // Additional function added for resizing based on width and height as well
        function resize_img_wh($imgname, $width, $height, $filename) {
        	$filetype = $this->getFileExtension($imgname);
        	$filetype = strtolower($filetype);
        
        	switch($filetype) {
        		case "jpeg":
        		case "jpg":
        			$img_src = ImageCreateFromjpeg ($imgname);
        			break;
        		case "gif":
        			$img_src = imagecreatefromgif ($imgname);
        			break;
        		case "png":
        			$img_src = imagecreatefrompng ($imgname);
        			break;
        	}
        
        	$true_width = imagesx($img_src);
        	$true_height = imagesy($img_src);
        	//600x300
        	//100x50
        	//300x600
        	//100x200
            // 500x500;
            // 800x500;  400x100; 160x100;
            // 100x500; 300x1000; 200x1000;
           
            
        	$original_ratio = $true_width/$true_height;
        	$width_ratio = $width/$true_width; 
        	$height_ratio = $height/ $true_height; 
        	if($width_ratio < $height_ratio){
        		$height = $width_ratio*$true_height;
        	}else{
        		$width = $height_ratio*$true_width;
        		
        	}
        	$img_des = ImageCreateTrueColor($width,$height);
        	imagecopyresampled ($img_des, $img_src, 0, 0, 0, 0, $width, $height, $true_width, $true_height);
        
        	// Save the resized image
        	switch($filetype)
        	{
        		case "jpeg":
        		case "jpg":
        			imagejpeg($img_des,$filename,80);
        			break;
        		case "gif":
        			imagegif($img_des,$filename,80);
        			break;
        		case "png":
        			imagepng($img_des,$filename,8);
        			// error_log($img_des."AAAA".$filename);
        			break;
        	}
        }
        
        function crop_img_wh($imgname, $cropwidth, $cropheight, $filename) {
        	$filetype = $this->getFileExtension($imgname);
        	$filetype = strtolower($filetype);
        
        	switch($filetype){
        		case "jpeg":
        		case "jpg":
        			$img_src = ImageCreateFromjpeg ($imgname);
        			break;
        		case "gif":
        			$img_src = imagecreatefromgif ($imgname);
        			break;
        		case "png":
        			$img_src = imagecreatefrompng ($imgname);
        			break;
        	}
            // 700x500     350x200     .5,.4
            // cropheight = 200;
            // cropwidth = 350;
            // ratiox = 800
            // ratioy = 250
            // newheight = 400
            // newwidth = 800
            // cropx = 150;
            // cropy = 0
            
        	$width = imagesx($img_src);
        	$height = imagesy($img_src);
        	$ratiox = $width / $height * $cropheight;
        	$ratioy = $height / $width * $cropwidth;
        	$width_ratio = $cropwidth/$width;
        	$height_ratio = $cropheight/ $height;
        	//-- Calculate resampling
        	$newheight = ($width_ratio >= $height_ratio) ? $ratioy : $cropheight;
        	$newwidth = ($width_ratio >= $height_ratio) ? $cropwidth : $ratiox;
        
        	//-- Calculate cropping (division by zero)
        	$cropx = ($newwidth - $cropwidth != 0) ? ($newwidth - $cropwidth) / 2 : 0;
        	$cropy = ($newheight - $cropheight != 0) ? ($newheight - $cropheight) / 2 : 0;
        
        	//-- Setup Resample & Crop buffers
        	$resampled = imagecreatetruecolor($newwidth, $newheight);
        	$cropped = imagecreatetruecolor($cropwidth, $cropheight);
        
        	//make png image transparent
        	if($filetype=="png"){
        		imagealphablending($resampled, false);
        		imagesavealpha($resampled,true);
        	}
        
        	//-- Resample
        	imagecopyresampled($resampled, $img_src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        
        	//make png image transparent
        	if($filetype=="png"){
        		imagealphablending($cropped, false);
        		imagesavealpha($cropped,true);
        	}
        
        	//-- Crop
        	imagecopy($cropped, $resampled, 0, 0, $cropx, $cropy, $newwidth, $newheight);
        
        	// Save the cropped image
        	switch($filetype)
        	{
        		case "jpeg":
        		case "jpg":
        			imagejpeg($cropped,$filename,80);
        			break;
        		case "gif":
        			imagegif($cropped,$filename,80);
        			break;
        		case "png":
        			imagepng($cropped,$filename,8);
        			break;
        	}
        }
    function getFileExtension($str) {
 
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }
} ?>