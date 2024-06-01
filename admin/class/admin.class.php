<?php require_once('DAL.class.php');



class Admin extends DAL{



    public function getAllAdmins(){
        $sql="select * from admin";
        return $this->getdata($sql);
    }

 public function registerAdmin($admin_fn,$admin_ln,$user_id){
    $sql = "INSERT INTO admin(admin_fn,admin_ln,user_id) VALUES(?,?,?)";
    $params = ['ssi', $admin_fn, $admin_ln, $user_id];
    return $this->execute($sql, $params);
    
}
}   
?> 

