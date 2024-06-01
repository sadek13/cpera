<?php require_once ('DAL.class.php');



class Image extends DAL{

  public function deleteImage($id){
    $sql= "DELETE FROM product_img WHERE img_ID =?";
  $params=["i",$id];
    
  return  $this->delete($sql,$params);

}
}
?>

