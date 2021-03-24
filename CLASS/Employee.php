<?php
class Employee extends Main{
    function add_employee(){
        $data = array();
        $error = array();

        $data["name"] = isset($_POST["add_name"]) ? $_POST["add_name"] :'';
        $data["sex"] = isset($_POST["add_sex"]) ? $_POST["add_sex"] :'';
        $data["date"] = isset($_POST["add_date"]) ? $_POST["add_date"] :'';
        $data["phone"] = isset($_POST["add_phone"]) ? $_POST["add_phone"] :'';
        $data["adress"] = isset($_POST["add_adress"]) ? $_POST["add_adress"] :'';
        $data["position"] = isset($_POST["add_position"]) ? $_POST["add_position"] :'';

        if (strlen($data["phone"]) >12 ) {
            $error["message"] = '<script>
            alert("Số điện thoại không hợp lệ");
            </script> !';
        }
        if (is_numeric($data["phone"])==false) {
            $error["message"] = '<script>
            alert("Số điện thoại phải là các chữ số !");
            </script> !';
        }
        if (! $error) {
            $name = $data["name"];
            $sex = $data["sex"];
            $date = $data["date"];
            $phone = $data["phone"];
            $adress = $data["adress"];
            $position = $data["position"];

            $insert = "INSERT INTO `employee`(`Ep_name`, `Ep_sex`, `Ep_birthday`, `Ep_phone`, `Ep_adress`, `Ep_Position`) 
            VALUES ('$name','$sex','$date','$phone','$adress','$position')";
            $this->exec_update($insert);
            header("location: index.php?page=employee");
        }
        $messenger[0]= $data;
        $messenger[1] = $error;
        return $messenger;
    }

    function update_employee(){
        $data = array();
        $error = array();

        $data["id"] = isset($_POST["Ep_id"]) ? $_POST["Ep_id"] :'';
        $data["name"] = isset($_POST["Ep_name"]) ? $_POST["Ep_name"] :'';
        $data["sex"] = isset($_POST["Ep_sex"]) ? $_POST["Ep_sex"] :'';
        $data["date"] = isset($_POST["Ep_birthday"]) ? $_POST["Ep_birthday"] :'';
        $data["phone"] = isset($_POST["Ep_phone"]) ? $_POST["Ep_phone"] :'';
        $data["adress"] = isset($_POST["Ep_adress"]) ? $_POST["Ep_adress"] :'';
        $data["position"] = isset($_POST["Ep_Position"]) ? $_POST["Ep_Position"] :'';

        if (strlen($data["phone"]) >12) {
            $error["message"] = '<script>
            alert("Số điện thoại không hợp lệ");
            </script> !';
        }

        if (is_numeric($data["phone"])==false) {
            $error["message"] = '<script>
            alert("Số điện thoại phải là các chữ số !");
            </script> !';
        }
        if (! $error) {
            $id = $data["id"];
            $name = $data["name"];
            $sex = $data["sex"];
            $date = $data["date"];
            $phone = $data["phone"];
            $adress = $data["adress"];
            $position = $data["position"];

            $update = "UPDATE `employee` SET `Ep_name`='$name',`Ep_sex`='$sex',`Ep_birthday`='$date',
            `Ep_phone`='$phone',`Ep_adress`='$adress',`Ep_Position`='$position' WHERE `Ep_id`='$id'";

            $this->exec_update($update);
            header("location: index.php?page=employee");
        }
        $messenger[0]= $data;
        $messenger[1] = $error;
        return $messenger;
    }
    function remove_employee(){
        $data = array();
        $error = array();

        $data["id"] = isset($_POST["Ep_id"]) ? $_POST["Ep_id"] :'';
        
        $id = $data["id"];

        $select = "SELECT COUNT(*) FROM `account` WHERE `Ep_id` = '$id'";
        $data = $this ->select_one($select);
        $count = 0;
        if (isset($data)) {
            foreach ($data as $item) {
                $count += $item;
            }
        }
        if ($count>0) {
            $error['message'] = '<script>
            alert("Nhân viên còn tài khoản đăng nhập hệ thống, vui lòng xóa toàn bộ rồi trở lại");
            </script> !';
            
        }
        else
        {
            $remove = "DELETE FROM `employee` WHERE `Ep_id` ='$id'";

            $this->exec_update($remove);
            header("location: index.php?page=employee");

        }

        $messenger[0]= $data;
        $messenger[1]=$error;

        return $messenger;
    }
    
}
?>