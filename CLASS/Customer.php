<?php
class Customer extends Main{
    function update_customer(){
       $data = array();
       $error = array();

       $data["id"] = isset($_POST["Ct_id"]) ? $_POST["Ct_id"] :'';
       $data["name"] = isset($_POST["Ct_name"]) ? $_POST["Ct_name"] :'';
       $data["sex"] = isset($_POST["Ct_sex"]) ? $_POST["Ct_sex"] :'';
       $data["phone"] = isset($_POST["Ct_phone"]) ? $_POST["Ct_phone"] :'';
       $data["adress"] = isset($_POST["Ct_adress"]) ? $_POST["Ct_adress"] :'';

       $id =  $data["id"];
       $name = $data["name"];
       $sex = $data["sex"];
       $phone = $data["phone"];
       $adress = $data["adress"];

      if (strlen($phone) >12) {
         $error["message"] = '<script>
            alert("Số điện thoại không hợp lệ");
            </script> !';
      }

      if (is_numeric($phone)==false) {
            $error["message"] = '<script>
            alert("Số điện thoại phải là các chữ số!");
            </script> !';
      }
      if (! $error) {
         $query = "UPDATE `customer` SET `Ct_name`='$name',`Ct_sex`='$sex',`Ct_phone`='$phone',`Ct_adress`='$adress' WHERE `Ct_id` = '$id'";
         $this->exec_update($query);
         header("location: index.php?page=customer");  
      }
       
       $messenger[0] = $data;
       $messenger[1] = $error;

       return $messenger;
    
    }
    function remove_customer(){
        $data = array();
 
        $data["id"] = isset($_POST["Ct_id"]) ? $_POST["Ct_id"] :'';
 
        $id =  $data["id"];
 
        $query = "DELETE FROM `customer` WHERE `Ct_id` = '$id'";
        $this->exec_update($query);
        header("location: index.php?page=customer");
 
        $messenger[0] = $data;
        return $messenger;
     
     }

     function add_customer(){
         $error = array();

         $name = isset($_POST["add_name"]) ? $_POST["add_name"] : '';
         $sex = isset($_POST["add_sex"]) ? $_POST["add_sex"] : '';
         $phone = isset($_POST["add_phone"]) ? $_POST["add_phone"] : '';
         $adress = isset($_POST["add_adress"]) ? $_POST["add_adress"] : '';

         if (strlen($phone) >12) {
            $error["message"] = '<script>
               alert("Số điện thoại không hợp lệ");
               </script> !';
         }
   
         if (is_numeric($phone)==false) {
               $error["message"] = '<script>
               alert("Số điện thoại phải là các chữ số!");
               </script> !';
         }
         if (! $error) {
            $query = "INSERT INTO `customer`(`Ct_name`, `Ct_sex`, `Ct_phone`, `Ct_adress`) 
            VALUES ('$name','$sex','$phone','$adress')";

            $this->exec_update($query);
            header("location: index.php?page=customer");  
         }

         $messenger[1] = $error;

         return $messenger;
     }
     function select()
     {
         $query_select = "SELECT * FROM `customer`";
         $data = $this->select_list($query_select);
         return $data;
     }
      function statistical($sex){
         $selecl = "SELECT * FROM `customer` WHERE `Ct_sex` = '$sex'";
         $data_select = $this->select_list($selecl);

         return $data_select;
      }
}
?>