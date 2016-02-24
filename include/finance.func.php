<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-11-25
 * Time: 下午3:55
 * To change this template use File | Settings | File Templates.
 */

session_verify($_SESSION['username']);
if (!isset($_GET['page']) || $_GET['page'] == '') {
    $_GET['page'] = 1;
}
if (!isset($specialty) || $specialty == '') {
    $specialty = 0;
}
$power=$_SESSION['power'];
$user=$_SESSION['name'];
$acs = array('edit','delete','pass','success','wait');
$ac = (!empty($_GET['ac']) && in_array($_GET['ac'], $acs))?$_GET['ac']:'edit';
switch ($ac){
    case 'edit':
        finance_edit($power);
        break;
    case 'delete':
        mange_delete($_GET['id'],$user,$power);
        break;
    case 'pass':
        finance_pass($_GET['uid'],$user);
        break;
    case 'success':
        finance_success($power);
        break;
    case 'wait':
        finance_wait($power);
        break;
}
function finance_edit($power){
    global $_SC;
    get_header();
    get_left_menu();
    if($power<=8){
        echo "<script>alert('提示:您没有权限');location.href='index.php?do=main'</script>";
        exit();
    }
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?index.php?do=detail"><i class="icon-dashboard"></i> 客户账户管理</a></li>
              <li class="active"><i class="icon-edit"></i> 客户消费审核</li>
          </ol>
            <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="index.php?do=finance&ac=all" >全部交易</a></li>
                <li class=""><a href="index.php?do=finance&ac=wait" >未审核交易</a></li>
                <li class=""><a href="index.php?do=finance&ac=success" >已审核交易</a></li>
                </li>
              </ul>
            </div>
        <div class="row">
         <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>客户姓名 <i class="icon-sort"></i></th>
                    <th>时间 <i class="icon-sort"></i></th>
                    <th>存入/消费 <i class="icon-sort"></i></th>
                    <th>内容 <i class="icon-sort"></i></th>
                    <th>金额 <i class="icon-sort"></i></th>
                    <th>余额 <i class="icon-sort"></i></th>
                    <th>备注 <i class="icon-sort"></i></th>
                    <th>负责人 <i class="icon-sort"></i></th>
                    <th>状态 <i class="icon-sort"></i></th>
                  </tr>
                </thead>
html;
        $sql="select * from tbl_vip_detail ORDER BY uid desc";
        $query=$_SC['db']->query($sql);
        $pageSize = 15;
        $totalCountsql = "select count(*) as t from tbl_vip_detail ";
        $query = $_SC['db']->query($totalCountsql);
        $rs = $_SC['db']->fetch_array($query);
        $totalCount = $rs['t'];
        $pageUrl = './index.php?do=finance&specialty=' . $specialty . '&page=';
        $sql = "select * from tbl_vip_detail  order by uid desc limit " . (($_GET['page']- 1) * $pageSize) . ",$pageSize";
        $query = $_SC['db']->query($sql);
        while ($rs = $_SC['db']->fetch_array($query)){
            $time=date('Y-m-d',$rs['time']);
            $sql="select * from tbl_member_info where id='".$rs['member_id']."'";
            $row_member=$_SC['db']->fetch_array($_SC['db']->query($sql));
            echo <<<html
                <thead>
                  <tr>
                    <td>{$row_member['name']} </td>
                    <td>{$time} </th>
                    <td>{$rs['consumption_type']} </td>
                    <td>{$rs['content']}  </td>
                    <td>{$rs['amount_money']} </td>
                    <td>{$rs['balance']}  </td>
                    <td>{$rs['remark']} </td>
                    <td>
html;

            $sql="select * from tbl_member_user where member_id=".$rs['member_id']."";
            $query_user=$_SC['db']->query($sql);
            while($row_follow=$_SC['db']->fetch_array($query_user)){
                $sql="select * from tbl_user where user_id=".$row_follow['user_id']."";
                $user_row=$_SC['db']->fetch_array($_SC['db']->query($sql));
                echo <<<html
                    {$user_row['name']};
html;
            }
            if($rs['status']=="未审核")
                $class="btn btn-danger";
            elseif($rs['status']=="财务已审核")
                $class="btn btn-success";
            elseif($rs['status']=="")
                $class="btn btn-danger";

            echo <<<html

                    </td>
                    <td><a href="index.php?do=finance&ac=pass&uid={$rs['uid']}" onclick='return CommandConfirm();'><font class="$class"> {$rs['status']} </font></a></td>
                  </tr>
                </thead>
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
            </div>
        </div>
        </div>
html;
}





function finance_wait($power){
    global $_SC;
    get_header();
    get_left_menu();
    if($power<=8){
        echo "<script>alert('提示:您没有权限');location.href='index.php?do=main'</script>";
        exit();
    }
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?index.php?do=detail"><i class="icon-dashboard"></i> 客户账户管理</a></li>
              <li class="active"><i class="icon-edit"></i> 客户消费审核</li>
          </ol>
            <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class=""><a href="index.php?do=finance&ac=all" >全部交易</a></li>
                <li class="active"><a href="index.php?do=finance&ac=wait" >未审核交易</a></li>
                <li class=""><a href="index.php?do=finance&ac=success" >已审核交易</a></li>
                </li>
              </ul>
            </div>
        <div class="row">
         <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>客户姓名 <i class="icon-sort"></i></th>
                    <th>时间 <i class="icon-sort"></i></th>
                    <th>存入/消费 <i class="icon-sort"></i></th>
                    <th>内容 <i class="icon-sort"></i></th>
                    <th>金额 <i class="icon-sort"></i></th>
                    <th>余额 <i class="icon-sort"></i></th>
                    <th>备注 <i class="icon-sort"></i></th>
                    <th>负责人 <i class="icon-sort"></i></th>
                    <th>状态 <i class="icon-sort"></i></th>
                  </tr>
                </thead>
html;
    $status="未审核";
    $sql="select * from tbl_vip_detail  ORDER BY uid desc";
    $query=$_SC['db']->query($sql);
    $pageSize = 15;
    $totalCountsql = "select count(*) as t from  tbl_vip_detail where status='".daddslashes($status)."'";
    $query = $_SC['db']->query($totalCountsql);
    $rs = $_SC['db']->fetch_array($query);
    $totalCount = $rs['t'];
    $pageUrl = './index.php?do=finance&ac=wait&specialty=' . $specialty . '&page=';

    $sql = "select * from tbl_vip_detail  where status='".daddslashes($status)."' order by uid desc limit " . (($_GET['page']- 1) * $pageSize) . ",$pageSize";
    $query = $_SC['db']->query($sql);
    while ($rs = $_SC['db']->fetch_array($query)){
        $time=date('Y-m-d',$rs['time']);
        $sql="select * from tbl_member_info where id='".$rs['member_id']."'";
        $row_member=$_SC['db']->fetch_array($_SC['db']->query($sql));
        echo <<<html
                <thead>
                  <tr>
                    <td>{$row_member['name']} </td>
                    <td>{$time} </th>
                    <td>{$rs['consumption_type']} </td>
                    <td>{$rs['content']}  </td>
                    <td>{$rs['amount_money']} </td>
                    <td>{$rs['balance']}  </td>
                    <td>{$rs['remark']} </td>
                    <td>
html;

        $sql="select * from tbl_member_user where member_id=".$rs['member_id']."";
        $query_user=$_SC['db']->query($sql);
        while($row_follow=$_SC['db']->fetch_array($query_user)){
            $sql="select * from tbl_user where user_id=".$row_follow['user_id']."";
            $user_row=$_SC['db']->fetch_array($_SC['db']->query($sql));
            echo <<<html
                    {$user_row['name']};
html;
        }
        if($rs['status']=="未审核")
            $class="btn btn-danger";
        elseif($rs['status']=="财务已审核")
            $class="btn btn-success";
        elseif($rs['status']=="")
            $class="btn btn-danger";

        echo <<<html

                    </td>
                    <td><a href="index.php?do=finance&ac=pass&uid={$rs['uid']}" onclick='return CommandConfirm();'><font class="$class"> {$rs['status']} </font></a></td>
                  </tr>
                </thead>
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
            </div>
        </div>
        </div>
html;
}





function finance_success($power){
    global $_SC;
    get_header();
    get_left_menu();
    if($power<=8){
        echo "<script>alert('提示:您没有权限');location.href='index.php?do=main'</script>";
        exit();
    }
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?index.php?do=detail"><i class="icon-dashboard"></i> 客户账户管理</a></li>
              <li class="active"><i class="icon-edit"></i> 客户消费审核</li>
          </ol>
            <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class=""><a href="index.php?do=finance&ac=all" >全部交易</a></li>
                <li class=""><a href="index.php?do=finance&ac=wait" >未审核交易</a></li>
                <li class="active"><a href="index.php?do=finance&ac=success" >已审核交易</a></li>
                </li>
              </ul>
            </div>
        <div class="row">
         <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>客户姓名 <i class="icon-sort"></i></th>
                    <th>时间 <i class="icon-sort"></i></th>
                    <th>存入/消费 <i class="icon-sort"></i></th>
                    <th>内容 <i class="icon-sort"></i></th>
                    <th>金额 <i class="icon-sort"></i></th>
                    <th>余额 <i class="icon-sort"></i></th>
                    <th>备注 <i class="icon-sort"></i></th>
                    <th>负责人 <i class="icon-sort"></i></th>
                    <th>状态 <i class="icon-sort"></i></th>
                  </tr>
                </thead>
html;
    $status="财务已审核";
    $sql="select * from tbl_vip_detail  ORDER BY uid desc";
    $query=$_SC['db']->query($sql);
    $pageSize = 15;
    $totalCountsql = "select count(*) as t from  tbl_vip_detail where status='".daddslashes($status)."'";
    $query = $_SC['db']->query($totalCountsql);
    $rs = $_SC['db']->fetch_array($query);
    $totalCount = $rs['t'];
    $pageUrl = './index.php?do=finance&ac=success&specialty=' . $specialty . '&page=';

    $sql = "select * from tbl_vip_detail  where status='".daddslashes($status)."' order by uid desc limit " . (($_GET['page']- 1) * $pageSize) . ",$pageSize";
    $query = $_SC['db']->query($sql);
    while ($rs = $_SC['db']->fetch_array($query)){
        $time=date('Y-m-d',$rs['time']);
        $sql="select * from tbl_member_info where id='".$rs['member_id']."'";
        $row_member=$_SC['db']->fetch_array($_SC['db']->query($sql));
        echo <<<html
                <thead>
                  <tr>
                    <td>{$row_member['name']} </td>
                    <td>{$time} </th>
                    <td>{$rs['consumption_type']} </td>
                    <td>{$rs['content']}  </td>
                    <td>{$rs['amount_money']} </td>
                    <td>{$rs['balance']}  </td>
                    <td>{$rs['remark']} </td>
                    <td>
html;

        $sql="select * from tbl_member_user where member_id=".$rs['member_id']."";
        $query_user=$_SC['db']->query($sql);
        while($row_follow=$_SC['db']->fetch_array($query_user)){
            $sql="select * from tbl_user where user_id=".$row_follow['user_id']."";
            $user_row=$_SC['db']->fetch_array($_SC['db']->query($sql));
            echo <<<html
                    {$user_row['name']};
html;
        }
        if($rs['status']=="未审核")
            $class="btn btn-danger";
        elseif($rs['status']=="财务已审核")
            $class="btn btn-success";
        elseif($rs['status']=="")
            $class="btn btn-danger";

        echo <<<html

                    </td>
                    <td><a href="index.php?do=finance&ac=pass&uid={$rs['uid']}" onclick='return CommandConfirm();'><font class="$class"> {$rs['status']} </font></a></td>
                  </tr>
                </thead>
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
            </div>
        </div>
        </div>
html;
}





function  finance_pass($uid,$user){
    global $_SC;
    $status="财务已审核";
    $sql="UPDATE `tbl_vip_detail` SET status='".$status."' where uid='".$uid."'";
    $query=$_SC['db']->query($sql);
    if($query){
        $op_type="审核交易";
        $sql=" insert into tbl_op_user (op_user,op_type,op_id,op_time) value ('".daddslashes($user)."','".daddslashes($op_type)."',".$uid.",".time().")";
        $query=$_SC['db']->query($sql);
        echo "<script>alert('提示:审核成功');history.go(-1)</script>";
    }
}





?>

<script>
function CommandConfirm(){
    if(window.confirm("确定审核通过此记录？")){
        return true;
    }else{
        return false;
    }
}
</script>
