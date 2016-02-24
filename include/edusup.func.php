<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 14-7-4
 * Time: 16:32
 */
session_verify($_SESSION['username']);
if (!isset($_GET['page']) || $_GET['page'] == '') {
    $_GET['page'] = 1;
}
if (!isset($specialty) || $specialty == '') {
    $specialty = 0;
}
$user_id=$_SESSION['user_id'];
$user=$_SESSION['name'];
$department_id=$_SESSION['department_id'];
$power=$_SESSION['power'];
$acs = array('list','add','form','info','info_edit','edit','update','view');
$ac = (!empty($_GET['ac']) && in_array($_GET['ac'], $acs))?$_GET['ac']:'list';
switch ($ac){
    case 'list':
        order_list($_GET['id'],$user,$user_id);
        break;
    case 'form':
        order_form();
        break;
    case 'add':
        $sql="INSERT INTO `tbl_sup_info`(`sup_name`, `country`, `district`, `city`, `address`, `website`, `contract_signed`, `remark`, `contract1`, `sex_1`, `phone_1`, `email_1`, `remark_1`, `contract2`, `sex_2`, `phone_2`, `email_2`, `remark_2`) VALUES ('".daddslashes($_POST['sup_name'])."','".daddslashes($_POST['country'])."','".daddslashes($_POST['district'])."','".daddslashes($_POST['city'])."','".daddslashes($_POST['address'])."','".daddslashes($_POST['website'])."','".daddslashes($_POST['contract_signed'])."','".daddslashes($_POST['remark'])."','".daddslashes($_POST['contract1'])."','".daddslashes($_POST['sex_1'])."','".daddslashes($_POST['phone_1'])."','".daddslashes($_POST['email_1'])."','".daddslashes($_POST['remark_1'])."','".daddslashes($_POST['contract2'])."','".daddslashes($_POST['sex_2'])."','".daddslashes($_POST['phone_2'])."','".daddslashes($_POST['email_2'])."','".daddslashes($_POST['remark_2'])."')";
        $query=$_SC['db']->query($sql);
        if($query){
            echo "<script>alert('提示:新建成功');location.href='index.php?do=edusup&ac=list';</script>";
        }
        break;
    case 'info':
        $sup_id=$_GET['sup_id'];
        sup_edu_info($sup_id);
        break;
    case 'info_edit':
        if(isset($_POST) && (!empty($_GET['sup_id']))){
            $sup_id=daddslashes($_GET['sup_id']);
            $sql="delete from tbl_d_s where sup_id='".$sup_id."'";
            $_SC['db']->query($sql);
        foreach ($_POST as $k=>$v) {
            foreach($v as $val){
                $sql="insert into tbl_d_s (sup_id,district_id,server_id) value ('".$sup_id."','".$val."','".$k."')";
                $query=$_SC['db']->query($sql);
                if($query){
                    echo "<script>alert('提示:设置成功');location.href='index.php?do=edusup&ac=info&sup_id=$sup_id';</script>";
                }
            }

        }
        }

        break;
    case 'edit':
        sup_edit();
        break;
    case 'update':
        $sql="UPDATE `tbl_sup_info` SET `sup_name`='".daddslashes($_POST['sup_name'])."',`country`='".daddslashes($_POST['country'])."',`district`='".daddslashes($_POST['district'])."',`city`='".daddslashes($_POST['city'])."',`address`='".daddslashes($_POST['address'])."',`website`='".daddslashes($_POST['website'])."',`contract_signed`='".daddslashes($_POST['contract_signed'])."',`remark`='".daddslashes($_POST['remark'])."',`contract1`='".daddslashes($_POST['contract1'])."',`sex_1`='".daddslashes($_POST['sex_1'])."',`phone_1`='".daddslashes($_POST['phone_1'])."',`email_1`='".daddslashes($_POST['email_1'])."',`remark_1`='".daddslashes($_POST['remark_1'])."',`contract2`='".daddslashes($_POST['contract2'])."',`sex_2`='".daddslashes($_POST['sex_2'])."',`phone_2`='".daddslashes($_POST['phone_2'])."',`email_2`='".daddslashes($_POST['email_2'])."',`remark_2`='".daddslashes($_POST['remark_2'])."' WHERE sup_id='".$_POST['sup_id']."'";
        $query=$_SC['db']->query($sql);
        if($query){
            echo "<script>alert('提示:设置成功');location.href='index.php?do=edusup&ac=list';</script>";
        }
        break;
    case "view":
        view();
        break;

}


function view(){
    global $_SC;
    get_header();
    get_left_menu();
    $sup_id=$_GET['sup_id'];
    $sup_info=sup_info($sup_id);
    if($sup_info['sex_1']=="男"){
        $selected_1_m="selected";
    }else{
        $selected_1_w="selected";
    }

    if($sup_info['sex_2']=="男"){
        $selected_2_m="selected";
    }else{
        $selected_2_w="selected";
    }


    echo <<<html
    <div id="page-wrapper" xmlns="http://www.w3.org/1999/html">
      <ol class="breadcrumb">
          <li><a href="index.php?do=edusup&ac=list"><i class="icon-dashboard"></i> 供应商列表</a></li>
          <li>供应商资料修改</li>
      </ol>
    <div class="row">
    <form action="index.php?do=edusup&ac=update" method="post">
    <input type="hidden" name="sup_id" value="{$sup_info['sup_id']}">
    <fieldset disabled>
       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">供应商名称</label>
             <input class="form-control" value="{$sup_info['sup_name']}" placeholder="请输入供应商名称" name="sup_name">
         </div>
       </div>


       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">国家</label>
             <input class="form-control" value="{$sup_info['country']}" placeholder="请输入供应商所在国家" name="country">
         </div>
       </div>


        <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">省/州/郡</label>
             <input class="form-control" value="{$sup_info['district']}" placeholder="请输入省/州/郡" name="district">
         </div>
       </div>



      <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">城市</label>
             <input class="form-control" value="{$sup_info['city']}" placeholder="请输入供应商所在城市" name="city">
         </div>
       </div>




       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">地址</label>
             <input class="form-control" value="{$sup_info['address']}" placeholder="请输入供应商地址" name="address">
         </div>
       </div>

       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">网址</label>
             <input class="form-control" value="{$sup_info['website']}" placeholder="请输入供应商网址" name="website">
         </div>
       </div>


       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">合同签署</label>
             <input class="form-control" value="{$sup_info['contract_signed']}" placeholder="" name="contract_signed">
         </div>
       </div>


       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">备注</label>
             <input class="form-control" value="{$sup_info['remark']}" placeholder="请输入备注" name="remark">
         </div>
       </div>



           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">联系人姓名</label>
                 <input class="form-control" value="{$sup_info['contract1']}" placeholder="请输入联系人姓名" name="contract1">
             </div>
           </div>

           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">性别</label>
                 <select class="form-control" name="sex_1">
                  <option value="男" {$selected_1_m}>男</option>
                  <option value="女" {$selected_1_w}>女</option>
                </select>
             </div>
           </div>


           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">电话</label>
                 <input class="form-control" value="{$sup_info['phone_1']}" placeholder="请输入联系人电话" name="phone_1">
             </div>
           </div>



           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">email</label>
                 <input class="form-control" value="{$sup_info['email_1']}" placeholder="请输入联系人email" name="email_1">
             </div>
           </div>


           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">备注</label>
                 <input class="form-control" value="{$sup_info['remark_1']}" placeholder="请输入联系人备注" name="remark_1">
             </div>
           </div>


           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">备用联系人姓名</label>
                 <input class="form-control" value="{$sup_info['contract2']}" placeholder="请输入备用联系人姓名" name="contract2">
             </div>
           </div>

           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">性别</label>
                 <select class="form-control" name="sex_2">
                  <option value="男" {$selected_2_m}>男</option>
                  <option value="女" {$selected_2_w}>女</option>
                </select>
             </div>
           </div>


           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">电话</label>
                 <input class="form-control" value="{$sup_info['phone_2']}" placeholder="请输入备用联系人电话" name="phone_2">
             </div>
           </div>



           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">email</label>
                 <input class="form-control" value="{$sup_info['email_2']}" placeholder="请输入备用联系人email" name="email_2">
             </div>
           </div>


           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">备注</label>
                 <input class="form-control" value="{$sup_info['remark_2']}" placeholder="请输入备用联系人备注" name="remark_2">
             </div>
           </div>
</fieldset>

              <a href="index.php?do=edusup&ac=list" class="btn btn-default">返 回</a>

        </form>
       </div>
    </div>


html;
}

function sup_edit(){
    global $_SC;
    get_header();
    get_left_menu();
    $sup_id=$_GET['sup_id'];
    $sup_info=sup_info($sup_id);
    if($sup_info['sex_1']=="男"){
        $selected_1_m="selected";
    }else{
        $selected_1_w="selected";
    }

    if($sup_info['sex_2']=="男"){
        $selected_2_m="selected";
    }else{
        $selected_2_w="selected";
    }


    echo <<<html
    <div id="page-wrapper" xmlns="http://www.w3.org/1999/html">
      <ol class="breadcrumb">
          <li><a href="index.php?do=edusup&ac=list"><i class="icon-dashboard"></i> 供应商列表</a></li>
          <li>供应商资料修改</li>
      </ol>
    <div class="row">
    <form action="index.php?do=edusup&ac=update" method="post">
    <input type="hidden" name="sup_id" value="{$sup_info['sup_id']}">
       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">供应商名称</label>
             <input class="form-control" value="{$sup_info['sup_name']}" placeholder="请输入供应商名称" name="sup_name">
         </div>
       </div>


       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">国家</label>
             <input class="form-control" value="{$sup_info['country']}" placeholder="请输入供应商所在国家" name="country">
         </div>
       </div>


        <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">省/州/郡</label>
             <input class="form-control" value="{$sup_info['district']}" placeholder="请输入省/州/郡" name="district">
         </div>
       </div>



      <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">城市</label>
             <input class="form-control" value="{$sup_info['city']}" placeholder="请输入供应商所在城市" name="city">
         </div>
       </div>




       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">地址</label>
             <input class="form-control" value="{$sup_info['address']}" placeholder="请输入供应商地址" name="address">
         </div>
       </div>

       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">网址</label>
             <input class="form-control" value="{$sup_info['website']}" placeholder="请输入供应商网址" name="website">
         </div>
       </div>


       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">合同签署</label>
             <input class="form-control" value="{$sup_info['contract_signed']}" placeholder="" name="contract_signed">
         </div>
       </div>


       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">备注</label>
             <input class="form-control" value="{$sup_info['remark']}" placeholder="请输入备注" name="remark">
         </div>
       </div>



           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">联系人姓名</label>
                 <input class="form-control" value="{$sup_info['contract1']}" placeholder="请输入联系人姓名" name="contract1">
             </div>
           </div>

           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">性别</label>
                 <select class="form-control" name="sex_1">
                  <option value="男" {$selected_1_m}>男</option>
                  <option value="女" {$selected_1_w}>女</option>
                </select>
             </div>
           </div>


           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">电话</label>
                 <input class="form-control" value="{$sup_info['phone_1']}" placeholder="请输入联系人电话" name="phone_1">
             </div>
           </div>



           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">email</label>
                 <input class="form-control" value="{$sup_info['email_1']}" placeholder="请输入联系人email" name="email_1">
             </div>
           </div>


           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">备注</label>
                 <input class="form-control" value="{$sup_info['remark_1']}" placeholder="请输入联系人备注" name="remark_1">
             </div>
           </div>


           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">备用联系人姓名</label>
                 <input class="form-control" value="{$sup_info['contract2']}" placeholder="请输入备用联系人姓名" name="contract2">
             </div>
           </div>

           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">性别</label>
                 <select class="form-control" name="sex_2">
                  <option value="男" {$selected_2_m}>男</option>
                  <option value="女" {$selected_2_w}>女</option>
                </select>
             </div>
           </div>


           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">电话</label>
                 <input class="form-control" value="{$sup_info['phone_2']}" placeholder="请输入备用联系人电话" name="phone_2">
             </div>
           </div>



           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">email</label>
                 <input class="form-control" value="{$sup_info['email_2']}" placeholder="请输入备用联系人email" name="email_2">
             </div>
           </div>


           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">备注</label>
                 <input class="form-control" value="{$sup_info['remark_2']}" placeholder="请输入备用联系人备注" name="remark_2">
             </div>
           </div>



              <button type="submit" class="btn btn-default" name="product_add">提  交</button>
              <a href="index.php?do=edusup&ac=list" class="btn btn-default">取 消</a>

        </form>
       </div>
    </div>


html;
}


function order_form(){
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
    <div id="page-wrapper" xmlns="http://www.w3.org/1999/html">
      <ol class="breadcrumb">
          <li><a href="index.php?do=edusup&ac=list"><i class="icon-dashboard"></i> 供应商列表</a></li>
          <li>供应商新建</li>
      </ol>
    <div class="row">
    <form action="index.php?do=edusup&ac=add" method="post">
       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">供应商名称</label>
             <input class="form-control" value="" placeholder="请输入供应商名称" name="sup_name">
         </div>
       </div>


       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">国家</label>
             <input class="form-control" value="" placeholder="请输入供应商所在国家" name="country">
         </div>
       </div>


        <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">省/州/郡</label>
             <input class="form-control" value="" placeholder="请输入省/州/郡" name="district">
         </div>
       </div>



      <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">城市</label>
             <input class="form-control" value="" placeholder="请输入供应商所在城市" name="city">
         </div>
       </div>




       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">地址</label>
             <input class="form-control" value="" placeholder="请输入供应商地址" name="address">
         </div>
       </div>

       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">网址</label>
             <input class="form-control" value="" placeholder="请输入供应商网址" name="website">
         </div>
       </div>


       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">合同签署</label>
             <input class="form-control" value="" placeholder="" name="contract_signed">
         </div>
       </div>


       <div class="form-group has-success">
         <div class="form-group">
             <label class="control-label" for="inputSuccess">备注</label>
             <input class="form-control" value="" placeholder="请输入备注" name="remark">
         </div>
       </div>



           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">联系人姓名</label>
                 <input class="form-control" value="" placeholder="请输入联系人姓名" name="contract1">
             </div>
           </div>

           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">性别</label>
                 <select class="form-control" name="sex_1">
                  <option value="男" selected>男</option>
                  <option value="女">女</option>
                </select>
             </div>
           </div>


           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">电话</label>
                 <input class="form-control" value="" placeholder="请输入联系人电话" name="phone_1">
             </div>
           </div>



           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">email</label>
                 <input class="form-control" value="" placeholder="请输入联系人email" name="email_1">
             </div>
           </div>


           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">备注</label>
                 <input class="form-control" value="" placeholder="请输入联系人备注" name="remark_1">
             </div>
           </div>


           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">备用联系人姓名</label>
                 <input class="form-control" value="" placeholder="请输入备用联系人姓名" name="contract2">
             </div>
           </div>

           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">性别</label>
                 <select class="form-control" name="sex_2">
                  <option value="男" selected>男</option>
                  <option value="女">女</option>
                </select>
             </div>
           </div>


           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">电话</label>
                 <input class="form-control" value="" placeholder="请输入备用联系人电话" name="phone_2">
             </div>
           </div>



           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">email</label>
                 <input class="form-control" value="" placeholder="请输入备用联系人email" name="email_2">
             </div>
           </div>


           <div class="form-group has-success">
             <div class="form-group">
                 <label class="control-label" for="inputSuccess">备注</label>
                 <input class="form-control" value="" placeholder="请输入备用联系人备注" name="remark_2">
             </div>
           </div>



              <button type="submit" class="btn btn-default" name="product_add">提  交</button>
              <a href="index.php?do=edusup&ac=list" class="btn btn-default">取 消</a>

        </form>
       </div>
    </div>


html;
}


function sup_edu_info($sup_id){
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
    <div id="page-wrapper">
    <div class="row">
      <ol class="breadcrumb">
            <li><a href="index.php?do=edusup&ac=list"><i class="icon-dashboard"></i> 供应商列表</a></li>
            <li>供应商服务信息设置</a></li>
      </ol>
      <button class="btn btn-primary btn-1g btn-block" id="showall">显示全部</button>

      <form action="index.php?do=edusup&ac=info_edit&sup_id={$sup_id}" method="post">
    <table class="table table-bordered table-striped">

        <tr class="server">
          <th class="text-center">S1 &nbsp;  培训</th>
        </tr>
        <tr class="info">
            <td>
            <table style="width: 100%;height: 100%" class="table table-bordered table-striped">
            <tr>
html;
    $i=0;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
while($rs=$_SC['db']->fetch_array($query)){
    $i++;
    $sql="SELECT * FROM `tbl_d_s` where server_id='s1' and sup_id='".$sup_id."' and district_id='".$rs['district_id']."'";
    $checked_query=$_SC['db']->query($sql);
    $checked_rs=$_SC['db']->fetch_array($checked_query);
    $checked="";
    if($checked_rs){
        $checked="checked";
    }else{
        $checked="";
    }
    if(($i%3)==1){
        echo <<<html
        <tr>
html;
    }
echo <<<html
            <td class="col-xs-4">
            <label>
            <input type="checkbox" value="{$rs['district_id']}" name="s1[]" {$checked}>
            {$rs['district']}
            </label>
            </td>
html;

    if(($i%3)==0){
        echo <<<html
        </tr>
html;
    }
}
    echo <<<html
            </tr>
            </table>
            </td>
        </tr>



        <tr class="server">
         <th class="text-center">S2 &nbsp;  申请大学/高中</th>
        </tr>
        <tr class="info">
            <td>
            <table style="width: 100%;height: 100%" class="table table-bordered table-striped">
            <tr>
html;
    $i=0;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $i++;
        $sql="SELECT * FROM `tbl_d_s` where server_id='s2' and sup_id='".$sup_id."' and district_id='".$rs['district_id']."'";
        $checked_query=$_SC['db']->query($sql);
        $checked_rs=$_SC['db']->fetch_array($checked_query);
        $checked="";
        if($checked_rs){
            $checked="checked";
        }else{
            $checked="";
        }
        if(($i%3)==1){
            echo <<<html
        <tr>
html;
        }
        echo <<<html
            <td class="col-xs-4">
            <label>
            <input type="checkbox" value="{$rs['district_id']}" name="s2[]" {$checked}>
            {$rs['district']}
            </label>
            </td>
html;

        if(($i%3)==0){
            echo <<<html
        </tr>
html;
        }
    }
    echo <<<html
            </tr>
            </table>
            </td>
        </tr>


        <tr class="server">
         <th class="text-center">S3 &nbsp;  海外机场接送</th>
        </tr>
        <tr class="info">
            <td>
            <table style="width: 100%;height: 100%" class="table table-bordered table-striped">
            <tr>
html;
    $i=0;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $i++;
        $sql="SELECT * FROM `tbl_d_s` where server_id='s3' and sup_id='".$sup_id."' and district_id='".$rs['district_id']."'";
        $checked_query=$_SC['db']->query($sql);
        $checked_rs=$_SC['db']->fetch_array($checked_query);
        $checked="";
        if($checked_rs){
            $checked="checked";
        }else{
            $checked="";
        }
        if(($i%3)==1){
            echo <<<html
        <tr>
html;
        }
        echo <<<html
            <td class="col-xs-4">
            <label>
            <input type="checkbox" value="{$rs['district_id']}" name="s3[]" {$checked}>
            {$rs['district']}
            </label>
            </td>
html;

        if(($i%3)==0){
            echo <<<html
        </tr>
html;
        }
    }
    echo <<<html
            </tr>
            </table>
            </td>
        </tr>

        <tr class="server">
         <th class="text-center">S4 &nbsp;  海外机场礼遇</th>
        </tr>
        <tr class="info">
            <td>
            <table style="width: 100%;height: 100%" class="table table-bordered table-striped">
            <tr>
html;
    $i=0;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $i++;
        $sql="SELECT * FROM `tbl_d_s` where server_id='s4' and sup_id='".$sup_id."' and district_id='".$rs['district_id']."'";
        $checked_query=$_SC['db']->query($sql);
        $checked_rs=$_SC['db']->fetch_array($checked_query);
        $checked="";
        if($checked_rs){
            $checked="checked";
        }else{
            $checked="";
        }
        if(($i%3)==1){
            echo <<<html
        <tr>
html;
        }
        echo <<<html
            <td class="col-xs-4">
            <label>
            <input type="checkbox" value="{$rs['district_id']}" name="s4[]" {$checked}>
            {$rs['district']}
            </label>
            </td>
html;

        if(($i%3)==0){
            echo <<<html
        </tr>
html;
        }
    }
    echo <<<html
            </tr>
            </table>
            </td>
        </tr>

        <tr class="server">
         <th class="text-center">S5 &nbsp; 行李遗失服务</th>
        </tr>
        <tr class="info">
            <td>
            <table style="width: 100%;height: 100%" class="table table-bordered table-striped">
            <tr>
html;
    $i=0;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $i++;
        $sql="SELECT * FROM `tbl_d_s` where server_id='s5' and sup_id='".$sup_id."' and district_id='".$rs['district_id']."'";
        $checked_query=$_SC['db']->query($sql);
        $checked_rs=$_SC['db']->fetch_array($checked_query);
        $checked="";
        if($checked_rs){
            $checked="checked";
        }else{
            $checked="";
        }
        if(($i%3)==1){
            echo <<<html
        <tr>
html;
        }
        echo <<<html
            <td class="col-xs-4">
            <label>
            <input type="checkbox" value="{$rs['district_id']}" name="s5[]" {$checked}>
            {$rs['district']}
            </label>
            </td>
html;

        if(($i%3)==0){
            echo <<<html
        </tr>
html;
        }
    }
    echo <<<html
            </tr>
            </table>
            </td>
        </tr>

        <tr class="server">
         <th class="text-center">S6 &nbsp;  寄宿家庭和房屋租凭</th>
        </tr>
        <tr class="info">
            <td>
            <table style="width: 100%;height: 100%" class="table table-bordered table-striped">
            <tr>
html;
    $i=0;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $i++;
        $sql="SELECT * FROM `tbl_d_s` where server_id='s6' and sup_id='".$sup_id."' and district_id='".$rs['district_id']."'";
        $checked_query=$_SC['db']->query($sql);
        $checked_rs=$_SC['db']->fetch_array($checked_query);
        $checked="";
        if($checked_rs){
            $checked="checked";
        }else{
            $checked="";
        }
        if(($i%3)==1){
            echo <<<html
        <tr>
html;
        }
        echo <<<html
            <td class="col-xs-4">
            <label>
            <input type="checkbox" value="{$rs['district_id']}" name="s6[]" {$checked}>
            {$rs['district']}
            </label>
            </td>
html;

        if(($i%3)==0){
            echo <<<html
        </tr>
html;
        }
    }
    echo <<<html
            </tr>

            </table>
            </td>
        </tr>


        <tr class="server">
         <th class="text-center">S7 &nbsp;  留学生当地电话卡服务</th>
        </tr>
        <tr class="info">
            <td>
            <table style="width: 100%;height: 100%" class="table table-bordered table-striped">
            <tr>
html;
    $i=0;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $i++;
        $sql="SELECT * FROM `tbl_d_s` where server_id='s7' and sup_id='".$sup_id."' and district_id='".$rs['district_id']."'";
        $checked_query=$_SC['db']->query($sql);
        $checked_rs=$_SC['db']->fetch_array($checked_query);
        $checked="";
        if($checked_rs){
            $checked="checked";
        }else{
            $checked="";
        }
        if(($i%3)==1){
            echo <<<html
        <tr>
html;
        }
        echo <<<html
            <td class="col-xs-4">
            <label>
            <input type="checkbox" value="{$rs['district_id']}" name="s7[]" {$checked}>
            {$rs['district']}
            </label>
            </td>
html;

        if(($i%3)==0){
            echo <<<html
        </tr>
html;
        }
    }
    echo <<<html
            </tr>
            </table>
            </td>
        </tr>

        <tr class="server">
         <th class="text-center">S8 &nbsp;  入境手续和当地居住手续</th>
        </tr>
        <tr class="info">
            <td>
            <table style="width: 100%;height: 100%" class="table table-bordered table-striped">
            <tr>
html;
    $i=0;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $i++;
        $sql="SELECT * FROM `tbl_d_s` where server_id='s8' and sup_id='".$sup_id."' and district_id='".$rs['district_id']."'";
        $checked_query=$_SC['db']->query($sql);
        $checked_rs=$_SC['db']->fetch_array($checked_query);
        $checked="";
        if($checked_rs){
            $checked="checked";
        }else{
            $checked="";
        }
        if(($i%3)==1){
            echo <<<html
        <tr>
html;
        }
        echo <<<html
            <td class="col-xs-4">
            <label>
            <input type="checkbox" value="{$rs['district_id']}" name="s8[]" {$checked}>
            {$rs['district']}
            </label>
            </td>
html;

        if(($i%3)==0){
            echo <<<html
        </tr>
html;
        }
    }
    echo <<<html
            </tr>
            </table>
            </td>
        </tr>



        <tr class="server">
         <th class="text-center">S9 &nbsp;  生活费管理及学习监理</th>
        </tr>
        <tr class="info">
            <td>
            <table style="width: 100%;height: 100%" class="table table-bordered table-striped">
            <tr>
html;
    $i=0;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $i++;
        $sql="SELECT * FROM `tbl_d_s` where server_id='s9' and sup_id='".$sup_id."' and district_id='".$rs['district_id']."'";
        $checked_query=$_SC['db']->query($sql);
        $checked_rs=$_SC['db']->fetch_array($checked_query);
        $checked="";
        if($checked_rs){
            $checked="checked";
        }else{
            $checked="";
        }
        if(($i%3)==1){
            echo <<<html
        <tr>
html;
        }
        echo <<<html
            <td class="col-xs-4">
            <label>
            <input type="checkbox" value="{$rs['district_id']}" name="s9[]" {$checked}>
            {$rs['district']}
            </label>
            </td>
html;

        if(($i%3)==0){
            echo <<<html
        </tr>
html;
        }
    }
    echo <<<html
            </tr>
            </table>
            </td>
        </tr>



        <tr class="server">
         <th class="text-center">S10 生活资讯服务</th>
        </tr>
        <tr class="info">
            <td>
            <table style="width: 100%;height: 100%" class="table table-bordered table-striped">
            <tr>
html;
    $i=0;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $i++;
        $sql="SELECT * FROM `tbl_d_s` where server_id='s10' and sup_id='".$sup_id."' and district_id='".$rs['district_id']."'";
        $checked_query=$_SC['db']->query($sql);
        $checked_rs=$_SC['db']->fetch_array($checked_query);
        $checked="";
        if($checked_rs){
            $checked="checked";
        }else{
            $checked="";
        }
        if(($i%3)==1){
            echo <<<html
        <tr>
html;
        }
        echo <<<html
            <td class="col-xs-4">
            <label>
            <input type="checkbox" value="{$rs['district_id']}" name="s10[]" {$checked}>
            {$rs['district']}
            </label>
            </td>
html;

        if(($i%3)==0){
            echo <<<html
        </tr>
html;
        }
    }
    echo <<<html
            </tr>
            </table>
            </td>
        </tr>



        <tr class="server">
         <th class="text-center">S11 海外租车和援驾服务</th>
        </tr>
        <tr class="info">
            <td>
            <table style="width: 100%;height: 100%" class="table table-bordered table-striped">
            <tr>
html;
    $i=0;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $i++;
        $sql="SELECT * FROM `tbl_d_s` where server_id='s11' and sup_id='".$sup_id."' and district_id='".$rs['district_id']."'";
        $checked_query=$_SC['db']->query($sql);
        $checked_rs=$_SC['db']->fetch_array($checked_query);
        $checked="";
        if($checked_rs){
            $checked="checked";
        }else{
            $checked="";
        }
        if(($i%3)==1){
            echo <<<html
        <tr>
html;
        }
        echo <<<html
            <td class="col-xs-4">
            <label>
            <input type="checkbox" value="{$rs['district_id']}" name="s11[]" {$checked}>
            {$rs['district']}
            </label>
            </td>
html;

        if(($i%3)==0){
            echo <<<html
        </tr>
html;
        }
    }
    echo <<<html
            </tr>
            </table>
            </td>
        </tr>


        <tr class="server">
         <th class="text-center">S12 健康管理和就医服务</th>
        </tr>
        <tr class="info">
            <td>
            <table style="width: 100%;height: 100%" class="table table-bordered table-striped">
            <tr>
html;
    $i=0;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $i++;
        $sql="SELECT * FROM `tbl_d_s` where server_id='s12' and sup_id='".$sup_id."' and district_id='".$rs['district_id']."'";
        $checked_query=$_SC['db']->query($sql);
        $checked_rs=$_SC['db']->fetch_array($checked_query);
        $checked="";
        if($checked_rs){
            $checked="checked";
        }else{
            $checked="";
        }
        if(($i%3)==1){
            echo <<<html
        <tr>
html;
        }
        echo <<<html
            <td class="col-xs-4">
            <label>
            <input type="checkbox" value="{$rs['district_id']}" name="s12[]" {$checked}>
            {$rs['district']}
            </label>
            </td>
html;

        if(($i%3)==0){
            echo <<<html
        </tr>
html;
        }
    }
    echo <<<html
            </tr>
            </table>
            </td>
        </tr>



        <tr class="server">
         <th class="text-center">S13 翻译服务</th>
        </tr>
        <tr class="info">
            <td>
            <table style="width: 100%;height: 100%" class="table table-bordered table-striped">
            <tr>
html;
    $i=0;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $i++;
        $sql="SELECT * FROM `tbl_d_s` where server_id='s3' and sup_id='".$sup_id."' and district_id='".$rs['district_id']."'";
        $checked_query=$_SC['db']->query($sql);
        $checked_rs=$_SC['db']->fetch_array($checked_query);
        $checked="";
        if($checked_rs){
            $checked="checked";
        }else{
            $checked="";
        }
        if(($i%3)==1){
            echo <<<html
        <tr>
html;
        }
        echo <<<html
            <td class="col-xs-4">
            <label>
            <input type="checkbox" value="{$rs['district_id']}" name="s13[]" {$checked}>
            {$rs['district']}
            </label>
            </td>
html;

        if(($i%3)==0){
            echo <<<html
        </tr>
html;
        }
    }
    echo <<<html
            </tr>
            </table>
            </td>
        </tr>


        <tr class="server">
         <th class="text-center">S14 护照证件等遗失应急服务</th>
        </tr>
        <tr class="info">
            <td>
            <table style="width: 100%;height: 100%" class="table table-bordered table-striped">
            <tr>
html;
    $i=0;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $i++;
        $sql="SELECT * FROM `tbl_d_s` where server_id='s14' and sup_id='".$sup_id."' and district_id='".$rs['district_id']."'";
        $checked_query=$_SC['db']->query($sql);
        $checked_rs=$_SC['db']->fetch_array($checked_query);
        $checked="";
        if($checked_rs){
            $checked="checked";
        }else{
            $checked="";
        }
        if(($i%3)==1){
            echo <<<html
        <tr>
html;
        }
        echo <<<html
            <td class="col-xs-4">
            <label>
            <input type="checkbox" value="{$rs['district_id']}" name="s14[]" {$checked}>
            {$rs['district']}
            </label>
            </td>
html;

        if(($i%3)==0){
            echo <<<html
        </tr>
html;
        }
    }
    echo <<<html
            </tr>
            </table>
            </td>
        </tr>


        <tr class="server">
         <th class="text-center">S15 留学托管</th>
        </tr>
        <tr class="info">
            <td>
            <table style="width: 100%;height: 100%" class="table table-bordered table-striped">
            <tr>
html;
    $i=0;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $i++;
        $sql="SELECT * FROM `tbl_d_s` where server_id='s15' and sup_id='".$sup_id."' and district_id='".$rs['district_id']."'";
        $checked_query=$_SC['db']->query($sql);
        $checked_rs=$_SC['db']->fetch_array($checked_query);
        $checked="";
        if($checked_rs){
            $checked="checked";
        }else{
            $checked="";
        }
        if(($i%3)==1){
            echo <<<html
        <tr>
html;
        }
        echo <<<html
            <td class="col-xs-4">
            <label>
            <input type="checkbox" value="{$rs['district_id']}" name="s15[]" {$checked}>
            {$rs['district']}
            </label>
            </td>
html;

        if(($i%3)==0){
            echo <<<html
        </tr>
html;
        }
    }
    echo <<<html
            </tr>
            </table>
            </td>
        </tr>

        <tr class="server">
         <th class="text-center">S16 游学</th>
        </tr>
        <tr class="info">
            <td>
            <table style="width: 100%;height: 100%" class="table table-bordered table-striped">
            <tr>
html;
    $i=0;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $i++;
        $sql="SELECT * FROM `tbl_d_s` where server_id='s16' and sup_id='".$sup_id."' and district_id='".$rs['district_id']."'";
        $checked_query=$_SC['db']->query($sql);
        $checked_rs=$_SC['db']->fetch_array($checked_query);
        $checked="";
        if($checked_rs){
            $checked="checked";
        }else{
            $checked="";
        }
        if(($i%3)==1){
            echo <<<html
        <tr>
html;
        }
        echo <<<html
            <td class="col-xs-4">
            <label>
            <input type="checkbox" value="{$rs['district_id']}" name="s16[]" {$checked}>
            {$rs['district']}
            </label>
            </td>
html;

        if(($i%3)==0){
            echo <<<html
        </tr>
html;
        }
    }
    echo <<<html
            </tr>
            </table>
            </td>
        </tr>


        <tr class="server">
         <th class="text-center">S17 旅游定制服务</th>
        </tr>
        <tr class="info">
            <td>
            <table style="width: 100%;height: 100%" class="table table-bordered table-striped">
            <tr>
html;
    $i=0;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $i++;
        $sql="SELECT * FROM `tbl_d_s` where server_id='s17' and sup_id='".$sup_id."' and district_id='".$rs['district_id']."'";
        $checked_query=$_SC['db']->query($sql);
        $checked_rs=$_SC['db']->fetch_array($checked_query);
        $checked="";
        if($checked_rs){
            $checked="checked";
        }else{
            $checked="";
        }
        if(($i%3)==1){
            echo <<<html
        <tr>
html;
        }
        echo <<<html
            <td class="col-xs-4">
            <label>
            <input type="checkbox" value="{$rs['district_id']}" name="s17[]" {$checked}>
            {$rs['district']}
            </label>
            </td>
html;

        if(($i%3)==0){
            echo <<<html
        </tr>
html;
        }
    }
    echo <<<html
            </tr>
            </table>
            </td>
        </tr>




    </table>



    <button type="submit" class="btn btn-default">提交</button>
    <a href="index.php?do=edusup&ac=list" class="btn btn-default">取消</a>
    </form>




    </div>
    </div>
    <script type="text/javascript">
      $(function(){
        $('.server').click(function(){
          $(this).next().toggle();
         });

            $('.info').hide();

        });
        $("#showall").click(function(){
            $('.info').toggle();
        })

    </script>
html;
}


function order_list(){
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
    <div id="page-wrapper">
    <div class="row">
                  <ol class="breadcrumb">
                      <li><a href="index.php?do=edusup&ac=list"><i class="icon-dashboard"></i> 供应商列表</a></li>
                  </ol>

                  <ol class="breadcrumb">
                  <a href="index.php?do=edusup&ac=form" class="btn btn-primary btn-1g btn-block">增加供应商</a>
                  </ol>

        <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">区 域</span>
          <select class="form-control" id="district">
          <option value="all" selected>全部</option>
html;
    $sql="select * from tbl_edu_district";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
    echo <<<html
          <option value="{$rs['district_id']}">{$rs['district']}</option>
html;
    }
    echo <<<html
          </select>
        </div>
        </div>

        <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">服 务</span>
          <select class="form-control" id="service">
          <option value="all">全部</option>
          <option value="1">S1 &nbsp;  培训</option>
          <option value="2">S2 &nbsp;  申请大学/高中</option>
          <option value="3">S3 &nbsp;  海外机场接送</option>
          <option value="4">S4 &nbsp;  海外机场礼遇</option>
          <option value="5">S5 &nbsp; 行李遗失服务</option>
          <option value="6">S6 &nbsp;  寄宿家庭和房屋租凭</option>
          <option value="7">S7 &nbsp;  留学生当地电话卡服务</option>
          <option value="8">S8 &nbsp;  入境手续和当地居住手续</option>
          <option value="9">S9 &nbsp;  生活费管理及学习监理</option>
          <option value="10">S10 生活资讯服务</option>
          <option value="11">S11 海外租车和援驾服务</option>
          <option value="12">S12 健康管理和就医服务</option>
          <option value="13">S13 翻译服务</option>
          <option value="14">S14 护照证件等遗失应急服务</option>
          <option value="15">S15 留学托管</option>
          <option value="16">S16 游学</option>
          <option value="17">S17 旅游定制服务</option>
          </select>
        </div>
        </div>
html;

echo <<<html
<table class="table table-bordered">
      <thead>
        <tr>
          <th>供应商名称</th>
          <th>国家</th>
          <th>城市</th>
          <th>地址</th>
          <th>网址</th>
          <th>联系人</th>
          <th>电话</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody id="list">
      </tbody>
    </table>

html;




echo <<<html
    </div>
    </div>
    <script type="text/javascript">
    var aa ;
    $(function(){
        district = $("#district").val();
        service = $("#service").val();
        htmlobj=$.ajax({url:"ajax.php?district=" + district + '&' +'service='+ service,async:false});
        $("#list").html(htmlobj.responseText);

        $("#district,#service").change(function(){
        district = $("#district").val();
        service = $("#service").val();
        aa = $("#district").val();
            htmlobj=$.ajax({url:"ajax.php?district=" + district + '&' +'service='+ service,async:false});
            $("#list").html(htmlobj.responseText);

        })
    });


    </script>


html;

}

function sup_info($sup_id){
    global $_SC;
    $sql="select * from tbl_sup_info where sup_id='".$sup_id."'";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    return $rs;
}



function district_info($district_id){
    global $_SC;
    $tmp=array();
    $sql="select * from tbl_edu_district where district_id='".$district_id."'";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    return $rs;
}
