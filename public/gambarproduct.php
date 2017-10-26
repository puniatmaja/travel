<?php

if ( !empty( $_FILES ) ) {

    $tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
    $uploadPath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'gambar' . DIRECTORY_SEPARATOR . $_FILES[ 'file' ][ 'name' ];    
    move_uploaded_file( $tempPath, $uploadPath );


    list($width,$height)=getimagesize($uploadPath);
    if ($_FILES[ 'file' ][ 'type' ] == 'image/jpeg') {
		$newfile=imagecreatefromjpeg($uploadPath);        	
    }else{
    	$newfile=imagecreatefrompng($uploadPath);
    }        
    $thumb = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'gambar/thumb' .DIRECTORY_SEPARATOR . $_FILES[ 'file' ][ 'name' ];
    $truecolor=imagecreatetruecolor('400','350');
    imagecopyresampled($truecolor, $newfile, 0, 0, 0, 0, '400', '350', $width, $height);        
    imagejpeg($truecolor,$thumb,100);


    $answer = array( 'answer' => 'File transfer completed' );
    $json = json_encode( $answer );

    echo $json;

} else {

    echo 'No files';

}

?>