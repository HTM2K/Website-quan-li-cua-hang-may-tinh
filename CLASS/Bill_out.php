<?php
class Bill_out extends Main{
    function add_bill($stt){
        $_SESSION["Pr_id_out"][$stt] = isset($_POST["Pr_id_out"]) ? $_POST["Pr_id_out"] : '';
        $_SESSION["amount_out"][$stt] = isset($_POST["amount_out"]) ? $_POST["amount_out"] : '';
        $_SESSION["discount"][$stt] = isset($_POST["discount"]) ? $_POST["discount"] : '';
        
        return 1;
    }
    function addBill_database($stt,$customer){

        if ($stt > 0) {

            if (isset($_COOKIE["login_name"])) {
                $account = $_COOKIE["login_name"];
            }
            $sl_ac = "SELECT `Ep_id` FROM `account` WHERE `Ac_name` = '$account'";
            $data_ac = $this->select_one($sl_ac);
    
            $account_name = $data_ac["Ep_id"];
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date("Y-m-d");

            
            $is_bill = "INSERT INTO `bill`(`bill_id`,`Ep_id`, `Ct_id`, `Date`) VALUES ('','$account_name','$customer','$date')";
            $sl_bill = "SELECT `bill_id` FROM `bill` WHERE `Ep_id` = '$account_name' and `Ct_id` ='$customer' and `Date`='$date' ORDER BY bill_id DESC Limit 1";
    
            $this->exec_update($is_bill);
            $data_bill = $this->select_one($sl_bill);
    
            $id_bill = $data_bill["bill_id"];
    
            for ($i=1; $i <= $stt; $i++) {
                $pr_id = $_SESSION["Pr_id_out"][$i];
                $amount = $_SESSION["amount_out"][$i];
                $discount = $_SESSION["discount"][$i];
    
                $is_billdetail = "INSERT INTO `bill_detail`(`bill_id`, `pr_id`, `number`, `discount`) 
                VALUES ('$id_bill','$pr_id','$amount','$discount')";
                $this->exec_update($is_billdetail);
            }
           
            
            unset($_SESSION["temp"]);
            unset($_SESSION["Pr_id_out"]);
            unset($_SESSION["amount_out"]);
            unset($_SESSION["discount"]);
        }
        header("location: index.php?page=billout");  
        
       
        $messenger[1] = $stt;
        $messenger[2] = $id_bill;
        return  $messenger;
    }
    function search($q){
        $sql = "SELECT bill.bill_id, customer.Ct_name, `Date` FROM `bill`,`customer` WHERE bill.Ct_id = customer.Ct_id AND `Date` LIKE '%$q%'";
        $data = $this->select_list($sql);

        return $data;
    }
}
?>