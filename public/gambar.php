<?php
	
	if(!empty($_FILES['image'])){
		$ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);        
        $image = time().'.'.$ext;
        $orgfile = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'gambar' .DIRECTORY_SEPARATOR . $_FILES[ 'image' ][ 'name' ];
        move_uploaded_file($_FILES["image"]["tmp_name"], $orgfile);                
        list($width,$height)=getimagesize($orgfile);
        if ($_FILES[ 'image' ][ 'type' ] == 'image/jpeg') {
			$newfile=imagecreatefromjpeg($orgfile);        	
        }else{
        	$newfile=imagecreatefrompng($orgfile);
        }        
        $thumb = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'gambar/thumb' .DIRECTORY_SEPARATOR . $_FILES[ 'image' ][ 'name' ];
        $truecolor=imagecreatetruecolor('400','350');
        imagecopyresampled($truecolor, $newfile, 0, 0, 0, 0, '400', '350', $width, $height);        
        imagejpeg($truecolor,$thumb,100);        

        echo $_FILES[ 'image' ][ 'name' ];
        
	}else{
		return false;
	}
?>