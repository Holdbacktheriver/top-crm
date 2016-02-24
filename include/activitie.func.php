<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-11-14
 * Time: 下午5:12
 * To change this template use File | Settings | File Templates.
 */
session_verify($_SESSION['username']);
$user=$_SESSION['username'];
$user_id=$_SESSION['user_id'];
$department_id=$_SESSION['department_id'];
$acs = array('edit','delete','add','update','view');
$ac = (!empty($_GET['ac']) && in_array($_GET['ac'], $acs))?$_GET['ac']:'edit';
switch ($ac){
    case 'edit':
        activitie_edit();
        break;
    case 'delete':
        activitie_delete($_GET['activitie_id'],$user);
        break;
    case 'add':
        activitie_add($user,$user_id,$department_id);
        break;
    case 'update':
        activitie_update($_GET['activitie_id']);
        break;
    case 'view':
        activitie_view($_GET['activitie_id']);
        break;
}

function activitie_add($user,$user_id,$department_id){
    global $_SC;
    $op_type="创建活动";
    get_header();
    get_left_menu();
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=member&ac=edit"><i class="icon-dashboard"></i> 活动列表</a></li>
              <li class="active"><i class="icon-edit"></i>新建活动</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
             <form role="form" action="index.php?do=activitie&ac=add" method="post" enctype="multipart/form-data">

                    <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">日期</label>
                        <input class="form-control" value="" name="activitie_date">
                      </div>
                    </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">主题</label>
                        <input class="form-control" value="" name="theme">
                      </div>
                    </div>


     <label class="control-label" for="inputSuccess">参加人员</label>
     <table class="table table-bordered table-hover tablesorter">
html;
    $sql="select * from tbl_member_info";
    $query=$_SC['db']->query($sql);
    $i=0;
    while($row=$_SC['db']->fetch_array($query)){
        $x="5";
        $a=fmod($i,$x);
            if($a=="0" || $i=="0"){
                echo <<<html
                <tr>
html;
            }
        echo <<<html
                <td>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value="{$row['id']}" name="member_f[]">
                            {$row['name']}
                          </label>
                        </div>
                </td>
html;
        $i=$i+1;
    }
    echo <<<html
                    </table>
                     <div class="form-group has-success">


                    <div class="form-group">
                        <label class="control-label" for="inputSuccess">总人数(含非本公司会员用户)</label>
                        <input class="form-control" value="" name="total">
                      </div>


                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">联系方式</label>
                        <input class="form-control" value="" name="contact_number">
                      </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">合作方</label>
                        <input class="form-control" value="" name="partner">
                      </div>
                    </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">合作方联系方式</label>
                        <input class="form-control" value="" name="partner_tel">
                      </div>
                    </div>

     <label class="control-label">负责人</label>
     <table class="table table-bordered table-hover tablesorter">
html;
    $sql="select * from tbl_user";
    $query=$_SC['db']->query($sql);
    $i=0;
    while($row_user_checkbox=$_SC['db']->fetch_array($query)){
        $x="5";
        $a=fmod($i,$x);
        if($a=="0" || $i=="0"){
            echo <<<html
                <tr>
html;
        }
        echo <<<html
                <td>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value="{$row_user_checkbox['user_id']}" name="user_f[]">
                            {$row_user_checkbox['name']}
                          </label>
                        </div>
                </td>
html;
        $i=$i+1;
    }
    echo <<<html
                    </table>

html;



    echo <<<html
                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">备注</label>
                        <input class="form-control" value="" name="remark">
                      </div>
                    </div>

                <div class="form-group has-success">
                 <div class="form-group">
                     <label  class="control-label" for="inputSuccess">附件(请上传压缩文件)</label>
                     <input type="file" name="attachment">
                    </div>
                  </div>

                      <button type="submit" class="btn btn-default" name="activitie_add">提  交</button>
                      <button type="reset" class="btn btn-default">复 位</button>
                    </div>
            </form>
             </div>
          </div>
     </div>
     </div>
html;
    if(isset($_POST['activitie_add'])){
        if(empty($_POST['activitie_date'])){
            echo "<script>alert('警告:活动日期不能为空');history.go(-1)</script>";
        }else{
            if(empty($_POST['theme']) || empty($_POST['user_f']) || empty($_POST['member_f'])){
                echo "<script>alert('警告:活动主题或（参加人员，负责人）不能为空');history.go(-1)</script>";
            }else{
                $sql="insert into tbl_activitie (activitie_date,theme,contact_number,partner,partner_tel,remark,total) value ('".daddslashes($_POST['activitie_date'])."','".daddslashes($_POST['theme'])."','".daddslashes($_POST['contact_number'])."','".daddslashes($_POST['partner'])."','".daddslashes($_POST['partner_tel'])."','".daddslashes($_POST['remark'])."','".daddslashes($_POST['total'])."')";
                $_SC['db']->query($sql);
                $activitie_id=$_SC['db']->insert_id();
                if(!empty($_POST['user_f']) && !empty($_POST['member_f'])){
                    foreach($_POST['member_f'] as $key=>$value){
                        $sql="insert into tbl_activitie_member (activitie_id,member_id) value (".$activitie_id.",".$value.")";
                        $_SC['db']->query($sql);

                    }

                    if($_FILES['attachment']['error']=='0'){
                        $file_type_array=array('rar','zip','tar','cab','uue','jar','iso','z','7-zip','ace','lzh','arj','gzip','bz2');
                        $file_type_name=pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
                        if(in_array($file_type_name,$file_type_array)){
                            $time=time();
                            $tmp = str_replace('\\\\', '\\', $_FILES['attachment']['tmp_name']);
                            $move=move_uploaded_file($tmp,'./image/activitie/zip/'.date(Ymd).$time.'.'.$file_type_name);
                            if($move){
                                $url="image/activitie/zip/".date(Ymd).$time.'.'.$file_type_name;
                                $sql="insert into tbl_activitie_file (activitie_file_name,activitie_file_url,activitie_id) value ('".daddslashes($_FILES['attachment']['name'])."','".daddslashes($url)."','".$activitie_id."')";
                                $_SC['db']->query($sql);
                                $attachment_id=$_SC['db']->insert_id();
                            }
                        }else{
                            echo "<script>alert('提示:压缩文件类型错误');history.go(-1)</script>";
                        }
                    }

                        foreach($_POST['user_f'] as $key=>$value){
                            echo $value;
                            $sql="insert into tbl_activitie_user (activitie_id,user_id) value (".$activitie_id.",".$value.")";
                            $_SC['db']->query($sql);
                        }

                    $sql=" insert into tbl_op_user (op_user,op_type,op_id,op_time) value ('".daddslashes($user)."','".daddslashes($op_type)."',".$activitie_id.",".time().")";
                    $_SC['db']->query($sql);
                    echo "<script>alert('提示:活动创建成功');location.href='index.php?do=activitie&ac=edit';</script>";
                }

            }
        }
    }
}



function activitie_edit(){
    global $_SC;
    get_header();
    get_left_menu();
    if (!isset($_GET['page']) || $_GET['page'] == '') {
        $_GET['page'] = 1;
    }
    echo <<<html
            <div id="page-wrapper">
              <div class="">
                  <ol class="breadcrumb">
                      <li><a href="index.php?do=activitie&ac=edit"><i class="icon-dashboard"></i> 活动管理</a></li>
                      <li class="active"><i class="icon-edit"></i> 活动列表</li>
                  </ol>
                  <ol class="breadcrumb">
                   <div class="col-lg-12">
                  <a href="index.php?do=activitie&ac=add"><button type="button" class="btn btn-primary btn-1g btn-block" style="">创建活动</button></a>
                  </div>
                  </ol>
              <table class="table table-bordered table-hover tablesorter">
                  <thead>
                  <tr>
                    <th>日期 </th>
                    <th>主题 </th>
                    <th>参加总人数 </th>
                    <th>联系方式 </th>
                    <th>合作方 </th>
                    <th>合作方联系方式 </th>
                    <th>负责人员 </th>
                    <th>附件(点击下载) </th>
                    <th>备注 </th>
                    <th>操作 </th>
                  </tr>
                </thead>
html;


    $pageSize = 10;
    $totalCountsql = "select count(*) as t from tbl_activitie  where is_delete='0' order by activitie_id";
    $query_s = $_SC['db']->query($totalCountsql);
    $rs = $_SC['db']->fetch_array($query_s);
    $totalCount = $rs['t'];
    $pageUrl = './index.php?do=activitie&ac=edit&page=';
    $sql="select * from tbl_activitie  where is_delete='0' order by activitie_id desc limit " . (($_GET['page']- 1) * $pageSize) . ",$pageSize";
    $query=$_SC['db']->query($sql);
    while($row=$_SC['db']->fetch_array($query)){
    $activitie_file_info=activitie_file_info($row['activitie_id']);
    echo <<<html
                    <tr>
                    <td>{$row['activitie_date']}</td>
                    <td>{$row['theme']}</td>
                    <td>{$row['total']} </td>
                    <td>{$row['contact_number']}</td>
                    <td>{$row['partner']}</td>
                    <td>{$row['partner_tel']}</td>
                    <td>
html;
        $sql="select * from tbl_activitie_user where activitie_id=".$row['activitie_id']."";
        $query_user=$_SC['db']->query($sql);
        while($row_user_id=$_SC['db']->fetch_array($query_user)){
            $sql="select * from tbl_user where user_id=".$row_user_id['user_id']."";
            $user=$_SC['db']->fetch_array($_SC['db']->query($sql));
            echo <<<html
                     {$user['name']};
html;
        }

    echo <<<html
                  </td>
                  <td><a href="{$activitie_file_info['activitie_file_url']}" target="_blank"> {$activitie_file_info['activitie_file_name']}</a> </td>
                  <td>{$row['remark']}</td>
                  <td><a href="index.php?do=activitie&ac=view&activitie_id={$row['activitie_id']}"> <button type="button" class="btn btn-primary btn-xs" >查看</button></a>
                  <a href="index.php?do=activitie&ac=update&activitie_id={$row['activitie_id']}"> <button type="button" class="btn btn-primary btn-xs" >修改</button></a>
                  <a href="index.php?do=activitie&ac=delete&activitie_id={$row['activitie_id']}" onclick="return CommandConfirm_server()"> <button type="button" class="btn btn-primary btn-xs" >删除</button></a></td>
                  </tr>
html;
     }
    echo <<<html
        </table>
html;
    include_once('./include/pagination.class.php');
    $pg = new pagination($totalCount, $pageSize, $pageUrl, 10, true, true, 'right');
    $pg->curPageNum = (($_GET['page'] > $pg->pageNum) or (intval($_GET['page']) <= 0)) ? 1 : $_GET['page'];
    echo $pg->generatePageNav();
    echo <<<html
      </div>
    </div>
html;
}



function activitie_update($activitie_id){
    global $_SC;
    $op_type="修改活动";
    get_header();
    get_left_menu();
    $activitie_info=activitie_info($activitie_id);
    $activitie_file_info=activitie_file_info($activitie_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=member&ac=edit"><i class="icon-dashboard"></i> 活动列表</a></li>
              <li class="active"><i class="icon-edit"></i>修改活动</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
             <form role="form" action="index.php?do=activitie&ac=update&activitie_id={$activitie_id}" method="post" enctype="multipart/form-data">

                    <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">日期</label>
                        <input class="form-control" value="{$activitie_info['activitie_date']}" name="activitie_date">
                      </div>
                    </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">主题</label>
                        <input class="form-control" value="{$activitie_info['theme']}" name="theme">
                      </div>
                    </div>


     <label class="control-label" for="inputSuccess">参加人员</label>
     <table class="table table-bordered table-hover tablesorter">
html;
    $sql="select * from tbl_member_info";
    $query=$_SC['db']->query($sql);
    $i=0;
    while($row=$_SC['db']->fetch_array($query)){
        $sql="select * from tbl_activitie_member where activitie_id='".$activitie_id."' and member_id='".$row['id']."'";
        $query_2=$_SC['db']->query($sql);
        if($rs_1=$_SC['db']->fetch_array($query_2)){
            $checked_m=checked;
        }else{
            $checked_m='';
        }
        $x="5";
        $a=fmod($i,$x);
        if($a=="0" || $i=="0"){
            echo <<<html
                <tr>
html;
        }
        echo <<<html
                <td>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value="{$row['id']}" name="member_f[]" {$checked_m}>
                            {$row['name']}
                          </label>
                        </div>
                </td>
html;
        $i=$i+1;
    }
    echo <<<html
                    </table>
                     <div class="form-group has-success">


                    <div class="form-group">
                        <label class="control-label" for="inputSuccess">总人数(含非本公司会员用户)</label>
                        <input class="form-control" value="{$activitie_info['total']}" name="total">
                      </div>


                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">联系方式</label>
                        <input class="form-control" value="{$activitie_info['contact_number']}" name="contact_number">
                      </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">合作方</label>
                        <input class="form-control" value="{$activitie_info['partner']}" name="partner">
                      </div>
                    </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">合作方联系方式</label>
                        <input class="form-control" value="{$activitie_info['partner_tel']}" name="partner_tel">
                      </div>
                    </div>

     <label class="control-label">负责人</label>
     <table class="table table-bordered table-hover tablesorter">
html;
    $sql="select * from tbl_user";
    $query=$_SC['db']->query($sql);
    $i=0;
    while($row_user_checkbox=$_SC['db']->fetch_array($query)){
        $sql="select * from tbl_activitie_user where activitie_id='".$activitie_id."' and user_id='".$row_user_checkbox['user_id']."'";
        $query_1=$_SC['db']->query($sql);
        if($rs=$_SC['db']->fetch_array($query_1)){
            $checked=checked;
        }else{
            $checked='';
        }
        $a=fmod($i,$x);
        if($a=="0" || $i=="0"){
            echo <<<html
                <tr>
html;
        }
        echo <<<html
                <td>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value="{$row_user_checkbox['user_id']}" name="user_f[]" {$checked}>
                            {$row_user_checkbox['name']}
                          </label>
                        </div>
                </td>
html;
        $i=$i+1;
    }
    echo <<<html
                    </table>
                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">备注</label>
                        <input class="form-control" value="{$activitie_info['remark']}" name="remark">
                      </div>
                    </div>

                <div class="form-group has-success">
                 <label ><a href="{$activitie_file_info['activitie_file_url']}"> 原附件({$activitie_file_info['activitie_file_name']})</a></label>
                 <div class="form-group">
                     <label  class="control-label" for="inputSuccess">附件(请上传压缩文件)</label>
                     <input type="file" name="attachment">
                    </div>
                  </div>

                      <button type="submit" class="btn btn-default" name="activitie_update">提  交</button>
                      <button type="reset" class="btn btn-default">复 位</button>
                    </div>
            </form>
             </div>
          </div>
     </div>
     </div>
html;
    if(isset($_POST['activitie_update'])){
        if(!empty($_POST['activitie_date'])){
            $sql="UPDATE `tbl_activitie` SET `activitie_date` ='".daddslashes($_POST['activitie_date'])."' WHERE `activitie_id` ='".$activitie_id."' ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['theme'])){
            $sql="UPDATE `tbl_activitie` SET `theme` ='".daddslashes($_POST['theme'])."' WHERE `activitie_id` ='".$activitie_id."' ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['contact_number'])){
            $sql="UPDATE `tbl_activitie` SET `contact_number` ='".daddslashes($_POST['contact_number'])."' WHERE `activitie_id` ='".$activitie_id."' ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['partner'])){
            $sql="UPDATE `tbl_activitie` SET `partner` ='".daddslashes($_POST['partner'])."' WHERE `activitie_id` ='".$activitie_id."' ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['partner_tel'])){
            $sql="UPDATE `tbl_activitie` SET `partner_tel` ='".daddslashes($_POST['partner_tel'])."' WHERE `activitie_id` ='".$activitie_id."' ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['remark'])){
            $sql="UPDATE `tbl_activitie` SET `remark` ='".daddslashes($_POST['remark'])."' WHERE `activitie_id` ='".$activitie_id."' ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['total'])){
            $sql="UPDATE `tbl_activitie` SET `total` ='".daddslashes($_POST['total'])."' WHERE `activitie_id` ='".$activitie_id."' ";
            $_SC['db']->query($sql);
        }


        $sql="delete from tbl_activitie_user where activitie_id='".$activitie_id."'";
        $_SC['db']->query($sql);

        if(is_array($_POST['user_f'])){
            foreach($_POST['user_f'] as $key=>$value){
                echo $value;
                $sql="insert into tbl_activitie_user (activitie_id,user_id) value (".$activitie_id.",".$value.")";
                $_SC['db']->query($sql);
            }
        }


        $sql="delete from tbl_activitie_member where activitie_id='".$activitie_id."'";
        $_SC['db']->query($sql);

        if(is_array($_POST['member_f'])){
            foreach($_POST['member_f'] as $key=>$value){
                $sql="insert into tbl_activitie_member (activitie_id,member_id) value (".$activitie_id.",".$value.")";
                $_SC['db']->query($sql);
            }
        }





        if($_FILES['attachment']['error']=='0'){
            $file_type_array=array('rar','zip','tar','cab','uue','jar','iso','z','7-zip','ace','lzh','arj','gzip','bz2');
            $file_type_name=pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
            if(in_array($file_type_name,$file_type_array)){
                $time=time();
                $tmp = str_replace('\\\\', '\\', $_FILES['attachment']['tmp_name']);
                $move=move_uploaded_file($tmp,'./image/activitie/zip/'.date(Ymd).$time.'.'.$file_type_name);
                if($move){
                    $url="image/activitie/zip/".date(Ymd).$time.'.'.$file_type_name;
                    $sql="select * from tbl_activitie_file where activitie_id='".$activitie_id."'";
                    $row=$_SC['db']->fetch_array($_SC['db']->query($sql));
                    if (file_exists($row['activitie_file_url'])) {
                        unlink($row['activitie_file_url']);
                    }
                    $sql="delete from tbl_activitie_file where activitie_id='".$activitie_id."'";
                    $_SC['db']->query($sql);
                    $sql="insert into tbl_activitie_file (activitie_id,activitie_file_url,activitie_file_name) value (".$activitie_id.",'".daddslashes($url)."','".daddslashes($_FILES['attachment']['name'])."')";
                    $_SC['db']->query($sql);
                }else{
                    echo "<script>alert('提示:文件上传失败');history.go(-1)</script>";
                }
            }else{
                echo "<script>alert('提示:压缩文件类型错误');history.go(-1)</script>";
            }
        }
        echo "<script>alert('提示:修改完成');location.href='index.php?do=activitie&ac=edit';</script>";
    }

}



function activitie_view($activitie_id){
    global $_SC;
    $op_type="查看";
    get_header();
    get_left_menu();
    $activitie_info=activitie_info($activitie_id);
    $activitie_file_info=activitie_file_info($activitie_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=member&ac=edit"><i class="icon-dashboard"></i> 活动列表</a></li>
              <li class="active"><i class="icon-edit"></i>活动详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
             <fieldset disabled>
             <form role="form" action="index.php?do=activitie&ac=update&activitie_id={$activitie_id}" method="post" enctype="multipart/form-data">

                    <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">日期</label>
                        <input class="form-control" value="{$activitie_info['activitie_date']}" name="activitie_date">
                      </div>
                    </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">主题</label>
                        <input class="form-control" value="{$activitie_info['theme']}" name="theme">
                      </div>
                    </div>


     <label class="control-label" for="inputSuccess">参加人员</label>
     <table class="table table-bordered table-hover tablesorter">
html;
    $sql="select * from tbl_member_info";
    $query=$_SC['db']->query($sql);
    $i=0;
    while($row=$_SC['db']->fetch_array($query)){
        $sql="select * from tbl_activitie_member where activitie_id='".$activitie_id."' and member_id='".$row['id']."'";
        $query_2=$_SC['db']->query($sql);
        if($rs_1=$_SC['db']->fetch_array($query_2)){
            $checked_m=checked;
        }else{
            $checked_m='';
        }
        $x="5";
        $a=fmod($i,$x);
        if($a=="0" || $i=="0"){
            echo <<<html
                <tr>
html;
        }
        echo <<<html
                <td>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value="{$row['id']}" name="member_f[]" {$checked_m}>
                            {$row['name']}
                          </label>
                        </div>
                </td>
html;
        $i=$i+1;
    }
    echo <<<html
                    </table>
                     <div class="form-group has-success">


                    <div class="form-group">
                        <label class="control-label" for="inputSuccess">总人数(含非本公司会员用户)</label>
                        <input class="form-control" value="{$activitie_info['total']}" name="total">
                      </div>


                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">联系方式</label>
                        <input class="form-control" value="{$activitie_info['contact_number']}" name="contact_number">
                      </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">合作方</label>
                        <input class="form-control" value="{$activitie_info['partner']}" name="partner">
                      </div>
                    </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">合作方联系方式</label>
                        <input class="form-control" value="{$activitie_info['partner_tel']}" name="partner_tel">
                      </div>
                    </div>

     <label class="control-label">负责人</label>
     <table class="table table-bordered table-hover tablesorter">
html;
    $sql="select * from tbl_user";
    $query=$_SC['db']->query($sql);
    $i=0;
    while($row_user_checkbox=$_SC['db']->fetch_array($query)){
        $sql="select * from tbl_activitie_user where activitie_id='".$activitie_id."' and user_id='".$row_user_checkbox['user_id']."'";
        $query_1=$_SC['db']->query($sql);
        if($rs=$_SC['db']->fetch_array($query_1)){
            $checked=checked;
        }else{
            $checked='';
        }
        $a=fmod($i,$x);
        if($a=="0" || $i=="0"){
            echo <<<html
                <tr>
html;
        }
        echo <<<html
                <td>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value="{$row_user_checkbox['user_id']}" name="user_f[]" {$checked}>
                            {$row_user_checkbox['name']}
                          </label>
                        </div>
                </td>
html;
        $i=$i+1;
    }
    echo <<<html
                    </table>
                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">备注</label>
                        <input class="form-control" value="{$activitie_info['remark']}" name="remark">
                      </div>
                    </div>

                <div class="form-group has-success">
                 <label ><a href="{$activitie_file_info['activitie_file_url']}"> 原附件({$activitie_file_info['activitie_file_name']})</a></label>
                  </div>

                      <button type="reset" class="btn btn-default">复 位</button>
                    </div>
            </form>
            <fieldset disabled>
             </div>
          </div>
     </div>
     </div>
html;
}



function activitie_delete($activitie_id){
    $is_delete="1";
    $op_type="删除活动";
    global $_SC;
    $sql="UPDATE `tbl_activitie` SET `is_delete` =".$is_delete." WHERE `activitie_id` =$activitie_id ";
    $query=$_SC['db']->query($sql);
    if($query){
        $sql=" insert into tbl_op_record (op_type, op_user,product_id,op_time) value ('".daddslashes($op_type)."','".daddslashes($booker)."',".$activitie_id.",".time().")";
        $query=$_SC['db']->query($sql);
        echo "<script>alert('提示:删除成功');location.href='index.php?do=activitie&ac=edit';</script>";
    }
}
?>

<script>
    function CommandConfirm_server(){
        if(window.confirm("提示:确定要删除此记录？")){
            return true;
        }else{
            return false;
        }
    }
</script>