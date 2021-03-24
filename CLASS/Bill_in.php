<?php
class Bill_in extends Main{
    function add_bill($stt){
        $_SESSION["producer"][$stt] = isset($_POST["add_Pd"]) ? $_POST["add_Pd"] : '';
        $_SESSION["name"][$stt] = isset($_POST["Pr_name"]) ? $_POST["Pr_name"] : '';
        $_SESSION["amount"][$stt] = isset($_POST["Pr_amount"]) ? $_POST["Pr_amount"] : '';
        $_SESSION["purchase_price"][$stt] = isset($_POST["Pr_Purchase"]) ? $_POST["Pr_Purchase"] : '';
        return 1;
    }
    function addBill_database($stt){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date("Y-m-d");
        if ($stt >0) {
            for ($i=1; $i <= $stt; $i++) {
                $producer = isset($_SESSION["producer"][$i]) ? $_SESSION["producer"][$i] : '';
                $name = isset($_SESSION["name"][$i]) ? $_SESSION["name"][$i] : '';
                $amount = isset($_SESSION["amount"][$i]) ? $_SESSION["amount"][$i] : '';
                $purchase_price = isset($_SESSION["purchase_price"][$i]) ? $_SESSION["purchase_price"][$i] : '';
    
                $product = "INSERT INTO `product`(`Pd_id`, `Pr_name`, `Pr_amount`, `Price`, `Purchase_price`, `Create_date`, `image`, `content`) 
                VALUES ('$producer','$name',' $amount','0','$purchase_price ','$date','','')";
                $this->exec_update($product);
            }
        }
        
        header('Location: index.php?page=billin');

        return $stt;
    }
}
?>