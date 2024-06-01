<?php require_once('DAL.class.php');



class User extends DAL{



    public function getallUsers(){
        $sql='select * from users';
        return $this->getdata($sql);
    }
 

   public function getUUserDetailsByUserId($userId){
    $sql="select * from users where user_id =$userId";

    $userArray=$this->getdata($sql);
    $userElement=$userArray[0];
    return $userElement;


   }



    public function registerUser($username,$password,$user_type){

        $sql = "INSERT INTO users (username,user_type,password)
        VALUES (?,?,?)";

    $params=['sss',$username,$user_type,$password];


        return $this->execute($sql,$params);
      
    }

  

    public function checkUsername($username,$password){
        $sql= "select * from users where username = '$username' and password = '$password'";
        $params=['dd',$username,$password];
        $usernameArray=$this->getdata($sql);
        
        return $usernameArray;
        }
        
    

    public function getUserDataByID($id){
        $sql= "select * from users where id = $id";
        return $this->getdata($sql);
}



function validateUserName($username) {
    $sql="select * from users where username = '$username'";
    if(!$this->getdata($sql)==0){
        header('Content-Type: application/json');
        echo json_encode(array(
            'status' => 'error',
            'message' => "Invalid input. User Name Taken.",
        ));
        exit;
    }
}
}
?>

