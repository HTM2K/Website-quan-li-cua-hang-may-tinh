<?php
class Product extends Main{
   
    function update_product(){
        $error = array();

        $id = isset($_POST["Pr_id"]) ? $_POST["Pr_id"] : '';
        $name = isset($_POST["Pr_name"]) ? $_POST["Pr_name"] : '';
        $amount = isset($_POST["Pr_amount"]) ? $_POST["Pr_amount"] : '';
        $date = isset($_POST["Create_date"]) ? $_POST["Create_date"] : '';
        $Purchase_price = isset($_POST["Purchase_price"]) ? $_POST["Purchase_price"] : '';
        $Price = isset($_POST["Price"]) ? $_POST["Price"] : '';
        $image = isset($_POST["image"]) ? $_POST["image"] : '';
        $content = isset($_POST["content"]) ? $_POST["content"] : '';

        $query = "UPDATE `product` SET `Pr_name`='$name',`Pr_amount`='$amount',`Price`='$Price',
            `Purchase_price`='$Purchase_price',`Create_date`='$date',`image`='$image',`content`='$content' WHERE `Pr_id` = '$id'";

            $this->exec_update($query);
            header("location: index.php?page=product");  

       $messenger[1] = $error;

       return $messenger;
    }
    function remove_product(){
        $id = isset($_POST["Pr_id"]) ? $_POST["Pr_id"] : '';
        
        $query = "DELETE FROM `product` WHERE `Pr_id` = '$id'";

        $this->exec_update($query);
        header("location: index.php?page=product");  

       return 1;
    }
}
?>