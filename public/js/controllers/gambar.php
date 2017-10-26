<?php
	
	if(!empty($_FILES['image'])){
		$ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
                $image = time().'.'.$ext;
                move_uploaded_file($_FILES["image"]["tmp_name"], dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $_FILES[ 'image' ][ 'name' ]);
        echo json_encode($_FILES[ 'image' ][ 'name' ]);
	}else{
		echo "Image Is Empty";
	}
?>