<?php
class Producer extends Main{
    function add_producer(){
        $data = array();
        $error = array();

        $name = isset($_POST["add_name_producer"]) ? $_POST["add_name_producer"] : ''; 
        $phone = isset($_POST["add_number_producer"]) ? $_POST["add_number_producer"] : ''; 
        $adress = isset($_POST["add_adress"]) ? $_POST["add_adress"] : ''; 

        if (is_numeric($phone)==false) {
            $error["message"] = '<script>
            alert("Số điện thoại phải là các chữ số!");
            </script> !';
        }
        if (! $error) {
            $query = "INSERT INTO `producer`(`Pd_id`, `Pd_name`, `Adress`, `number_phone`) VALUES ('','$name','$adress','$phone')";
            $this->exec_update($query);
            header("location: index.php?page=producer");  
        }
       
       $messenger[0] = $data;
       $messenger[1] = $error;

       return $messenger;
    }
    function update_producer(){
        $error = array();

        $ID = isset($_POST["Pd_id"]) ? $_POST["Pd_id"] : ''; 
        $name = isset($_POST["Pd_name"]) ? $_POST["Pd_name"] : ''; 
        $phone = isset($_POST["number_phone"]) ? $_POST["number_phone"] : ''; 
        $adress = isset($_POST["Adress"]) ? $_POST["Adress"] : ''; 

        if (is_numeric($phone)==false) {
            $error["message"] = '<script>
            alert("Số điện thoại phải là các chữ số!");
            </script> !';
        }
        if (strlen($phone) >12) {
            $error["message"] = '<script>
            alert("Số điện thoại không hợp lệ");
            </script> !';
        }
        if (! $error) {
            $query = "UPDATE `producer` SET `Pd_name`='$name',`Adress`='$adress',`number_phone`='$phone' WHERE `Pd_id` = '$ID'";
            $this->exec_update($query);
            header("location: index.php?page=producer");  
        }
      
       $messenger[1] = $error;

       return $messenger;
    }
    function remove_producer(){
       
        $ID = isset($_POST["Pd_id"]) ? $_POST["Pd_id"] : ''; 

        $query = "DELETE FROM `producer` WHERE `Pd_id` = '$ID'";
        $this->exec_update($query);
        header("location: index.php?page=producer");  
      
       return 0;
    }
}
?>