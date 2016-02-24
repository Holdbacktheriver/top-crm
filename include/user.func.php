<?php
/**
 * Created by PhpStorm.
 * User: liulei
 * Date: 16/2/19
 * Time: 下午4:32
 */
session_verify($_SESSION['username']);
$power=$_SESSION['power'];
$user=$_SESSION['name'];
$acs = array('default','setting','save_pwd');
$ac = (!empty($_GET['ac']) && in_array($_GET['ac'], $acs))?$_GET['ac']:'default';


switch ($ac){
    case 'default':
        header('Location:index.php?do=main');
        break;
    case 'setting':
        setting();
        break;
    case 'save_pwd':
        if(strlen($_POST['password']) >= 10){
            if($_POST['password'] == $_POST['confirmpwd']){
                if(pwd_intensity($_POST['password'])){
                    $new_password=md5($_POST['password']);
                    $pwd_validity = time()+ 3600 * 24 * 30;
                    $sql = "update tbl_user set password = '".$new_password."',pwd_validity = '".$pwd_validity."' where user_id = '".$_SESSION['user_id']."'";
                    $query = $_SC['db']->query($sql);
                    header('Location:index.php?do=main');
                    exit;

                }else{
                    echo "<script>alert('警告:密码必须包含大小写字母,数组,符号');history.go(-1)</script>";
                    exit;
                }
            }else{
                echo "<script>alert('警告:2次输入密码不一致');history.go(-1)</script>";
                exit;
            }
        }else{
            echo "<script>alert('警告:密码长度不能少于10位');history.go(-1)</script>";
            exit;
        }
        break;
}

function setting(){
    echo <<<html

<!DOCTYPE html>
<html lang="zh-cn">
<head>

    <meta charset="utf-8">
    <title>臻客—CRM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
    <meta name="author" content="Muhammad Usman">
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!-- Add custom CSS here -->
    <link href="assets/css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
    <!-- Page Specific CSS -->
    <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">


</head>

<body>

            <div style="width: 500px;margin:0 auto;">
                <h2 style="text-align:center;width: 500px">密码已过期,请更新你的密码</h2>
				<h3 style="text-align:center;width: 500px">密码必须包含大小写字母,数组,符号</h3>
                <form class="form-horizontal" role="form" action="index.php?do=user&ac=save_pwd" method="post">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" required="required" id="inputEmail3" placeholder="请输入你的新密码">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">确认密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="confirmpwd" required="required" id="inputPassword3" placeholder="请再次输入你的新密码">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-10">
                            <button type="submit" name="submit" class="btn btn-default col-lg-6">提交</button>
                        </div>
                    </div>
                </form>
            </div>

<!-- external javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<!-- jQuery -->
<script src="assets/js/jquery-1.7.2.min.js"></script>
<!-- jQuery UI -->
<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
<!-- transition / effect library -->
<script src="js/bootstrap-transition.js"></script>
<!-- alert enhancer library -->
<script src="js/bootstrap-alert.js"></script>
<!-- modal / dialog library -->
<script src="js/bootstrap-modal.js"></script>
<!-- custom dropdown library -->
<script src="js/bootstrap-dropdown.js"></script>
<!-- scrolspy library -->
<script src="js/bootstrap-scrollspy.js"></script>
<!-- library for creating tabs -->
<script src="js/bootstrap-tab.js"></script>
<!-- library for advanced tooltip -->
<script src="js/bootstrap-tooltip.js"></script>
<!-- popover effect library -->
<script src="js/bootstrap-popover.js"></script>
<!-- button enhancer library -->
<script src="js/bootstrap-button.js"></script>
<!-- accordion library (optional, not used in demo) -->
<script src="js/bootstrap-collapse.js"></script>
<!-- carousel slideshow library (optional, not used in demo) -->
<script src="js/bootstrap-carousel.js"></script>
<!-- autocomplete library -->
<script src="js/bootstrap-typeahead.js"></script>
<!-- tour library -->
<script src="js/bootstrap-tour.js"></script>
<!-- library for cookie management -->
<script src="js/jquery.cookie.js"></script>
<!-- calander plugin -->
<script src='js/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='js/jquery.dataTables.min.js'></script>

<!-- chart libraries start -->
<script src="js/excanvas.js"></script>
<script src="js/jquery.flot.min.js"></script>
<script src="js/jquery.flot.pie.min.js"></script>
<script src="js/jquery.flot.stack.js"></script>
<script src="js/jquery.flot.resize.min.js"></script>
<!-- chart libraries end -->

<!-- select or dropdown enhancer -->
<script src="js/jquery.chosen.min.js"></script>
<!-- checkbox, radio, and file input styler -->
<script src="js/jquery.uniform.min.js"></script>
<!-- plugin for gallery image view -->
<script src="js/jquery.colorbox.min.js"></script>
<!-- rich text editor library -->
<script src="js/jquery.cleditor.min.js"></script>
<!-- notification plugin -->
<script src="js/jquery.noty.js"></script>
<!-- file manager library -->
<script src="js/jquery.elfinder.min.js"></script>
<!-- star rating plugin -->
<script src="js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script src="js/jquery.uploadify-3.1.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="js/jquery.history.js"></script>
<!-- application script for Charisma demo -->
<script src="js/charisma.js"></script>

</body>
</html>

html;
}


function pwd_intensity($str){
    if(!preg_match("/[0-9]+/",$str))
    {
        return false;
    }
    if(!preg_match("/[a-z]+/",$str))
    {
        return false;
    }
    if(!preg_match("/[A-Z]+/",$str))
    {
        return false;
    }
    if(!preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/",$str))
    {
        return false;
    }
    return true;
}

?>