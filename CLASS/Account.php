<?php
class account extends Main{
    function login(){
        $data = array();
        $error = array();

        $data["login_name"] = isset($_POST["login_name"]) ? $_POST["login_name"] : '';
        $data["login_pass"] = isset($_POST["login_pass"]) ? $_POST["login_pass"] : '';

        $name = $data["login_name"];
        $pwd = md5($data["login_pass"]);
        
        $query = "SELECT COUNT(*) FROM `account` WHERE Ac_name = '$name' AND Ac_pwd = '$pwd'";
        
        //thực thi truy vấn
        $data = $this ->select_one($query);
        $count = 0;
        if (isset($data)) {
            foreach ($data as $item) {
                $count += $item;
            }
        }
        
        if ($count>0) {
            //lưu cookie
            
            setcookie("login_name", $name, time() + (86400 * 30));

            //đăng nhập vào trang chính
            header("Location:index.php");
            die();
        }
        else
        {
            $error['message'] = 'Tên tài khoản hoặc mật khẩu không đúng !';
        }
        $messenger[0] = $error;
        return $messenger;
    }
    function logout(){
        setcookie("login_name", "", time() - 3600);

        header("location: index.php");
    }
    function add_account(){
        $data = array();
        $error =array();

        $data["nameEp"] = isset($_POST["add_Ep"]) ? $_POST["add_Ep"] :'';
        $data["nameAC"] = isset($_POST["add_name_account"]) ? $_POST["add_name_account"] :'';
        $data["pwd"] = isset($_POST["add_pwd_account"]) ? $_POST["add_pwd_account"] :'';
        $data["confim"] = isset($_POST["cf_pwd_account"]) ? $_POST["cf_pwd_account"] :'';

        $id_ep = $data["nameEp"];
        $name = $data["nameAC"];
        $pwd = md5($data["pwd"]);
        $cf = md5($data["confim"]);

        $select ="SELECT COUNT(*) FROM `account` WHERE `Ac_name` ='$name'";
        $data = $this ->select_one($select);
        $count = 0;
        if (isset($data)) {
            foreach ($data as $item) {
                $count += $item;
            }
        }
        if ($count>0) {
            $error['message'] = '<script>
            alert("Tên tài khoản đã tồn tại");
            </script> !';
            
        }
        else
        {
            if ($pwd != $cf) {
                $error['message'] = '<script>
                alert("Xác nhận mật khẩu không chính xác");
                </script> !';
            }
            else{
                $query = "INSERT INTO `account`(`Ep_id`, `Ac_name`, `Ac_pwd`) VALUES ('$id_ep','$name','$pwd')";
                $this->exec_update($query);
                header("location: index.php?page=account");
            }
            
        }

        
        $messenger[0] = $data;
        $messenger[1] = $error;
        return $messenger;
        
    }
    function remove_account(){
        $data = array();
        $error =array();

        $data["id"] = isset($_POST["Ac_id"]) ? $_POST["Ac_id"] :'';
        $data["pwd"] = isset($_POST["Ac_pwd"]) ? $_POST["Ac_pwd"] :'';
        
        $id = $data["id"];
        $pwd = md5($data["pwd"]);

        $name = isset($_COOKIE["login_name"]) ? $_COOKIE["login_name"] :'';

        $select ="SELECT `Ac_id`,`Ac_pwd` FROM `account` WHERE `Ac_name` ='$name'";
        $data = $this ->select_one($select);
        
        if ($id == $data["Ac_id"]) {
            $error['message'] = '<script>
            alert("Tài khoản đang được sử dụng, không thể xóa !");
            </script> !';
        }

        elseif ($pwd != $data["Ac_pwd"]) {
            $error['message'] = '<script>
            alert("Mật khẩu vừa nhập không chính xác !");
            </script> !';
            
        }
        
        if (! $error) {
            
            $remove = "DELETE FROM `account` WHERE `Ac_id` = $id";
            $this ->exec_update($remove);
            header("Location: index.php?page=account");
        }

        
        $messenger[0] = $data;
        $messenger[1] = $error;
        return $messenger;
        
    }
}
?>