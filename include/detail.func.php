<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-11-21
 * Time: 下午5:50
 * To change this template use File | Settings | File Templates.
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
$acs = array('record','edit','delete','add','follow_add','update');
$ac = (!empty($_GET['ac']) && in_array($_GET['ac'], $acs))?$_GET['ac']:'edit';
switch ($ac){
    case 'edit':
        detail_edit($user_id,$user,$power);
        break;
    case 'record':
        detail_record($user_id,$_GET['member_id']);
        break;

}


function detail_edit($user_id,$user,$power){
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=detail"><i class="icon-dashboard"></i> 会员消费管理</a></li>
              <li class="active"><i class="icon-edit"></i> 会员列表</li>
          </ol>
        <div class="row">
         <div class="col-lg-12">
          <h2>会员账户列表 </h2>
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped tablesorter">
                <thead>
                  <tr>
                    <th>会员名 <i class="icon-sort"></i></th>
                    <th>会员卡号 <i class="icon-sort"></i></th>
                    <th>余额 <i class="icon-sort"></i></th>
                    <th>负责人 <i class="icon-sort"></i></th>
                    <th>备注 <i class="icon-sort"></i></th>
                    <th>操作 <i class="icon-sort"></i></th>
                  </tr>
                </thead>
html;
        if($power<7){
        $pageSize = 15;
        $in_class="臻客会员";
        $totalCountsql = "SELECT count(*) as t FROM `tbl_member_user`a,tbl_member_info b WHERE a.`user_id`='$user_id' and b.is_delete=0 and b.in_class='".daddslashes($in_class)."' and a.member_id=b.id";
        $query = $_SC['db']->query($totalCountsql);
        $rs = $_SC['db']->fetch_array($query);
        $totalCount = $rs['t'];
        $pageUrl = './index.php?do=detail&page=';
        $sql =  "SELECT * FROM `tbl_member_user`a,tbl_member_info b WHERE a.`user_id`='$user_id' and b.is_delete=0 and a.member_id=b.id and b.in_class='".daddslashes($in_class)."' LIMIT " . (($_GET['page']- 1) * $pageSize) . ", $pageSize ";
        $query = $_SC['db']->query($sql);
        while($row=$_SC['db']->fetch_array($query)){
            $sql="select * from tbl_vip_detail where member_id='".$row['id']."' order by uid DESC";
            $row_edit=$_SC['db']->fetch_array($_SC['db']->query($sql));
           echo <<<html

                  <tr>
                    <td><a href="index.php?do=member&ac=follow&id={$row_member_info['id']}">{$row['name']}{$row['in_class']}</a> </td>
                    <td>{$row['vip_id']} </td>
                    <td>{$row_edit['balance']} </td>
                    <td>
html;
            $sql="select * from tbl_member_user where member_id=".$row['id']."";
            $query_user=$_SC['db']->query($sql);
            while($row_follow=$_SC['db']->fetch_array($query_user)){
                $sql="select * from tbl_user where user_id=".$row_follow['user_id']."";
                $user_row=$_SC['db']->fetch_array($_SC['db']->query($sql));
            echo <<<html
                    {$user_row['name']};
html;
            }
            echo <<<html
                      </td>
                    <td>{$row_edit['remark']} </td>
                    <td>
                     <a href="index.php?do=detail&ac=record&member_id={$row_member_info['id']}"><button type="button" class="btn btn-primary btn-xs" >详细记录</button></a>
                     <a href="index.php?do=detail&ac=deposit&member_id={$row_member_info['id']}"><button type="button" class="btn btn-primary btn-xs" >会员充值</button></a>
                  </td>
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
         </div>
     </div>
     </div>
html;
    }else{
            $pageSize = 15;
            $in_class="臻客会员";
            $totalCountsql = "select count(distinct id) as t from tbl_member_info where in_class='".daddslashes($in_class)."' and is_delete='0'";
            $query_s = $_SC['db']->query($totalCountsql);
            $rs = $_SC['db']->fetch_array($query_s);
            $totalCount = $rs['t'];
            $pageUrl = './index.php?do=detail&page=';
            $sql = "select * from tbl_member_info  where in_class='".daddslashes($in_class)."' and is_delete='0' order by id desc limit " . (($_GET['page']- 1) * $pageSize) . ",$pageSize";
            $query = $_SC['db']->query($sql);
            while($row=$_SC['db']->fetch_array($query)){
                    $sql="select * from tbl_vip_detail where member_id='".$row['id']."' order by uid DESC";
                    $row_edit=$_SC['db']->fetch_array($_SC['db']->query($sql));
                    echo <<<html
                  <tr>
                    <td><a href="index.php?do=member&ac=follow&id={$row['id']}">{$row['name']}</a> </td>
                    <td>{$row['vip_id']} </td>
                    <td>{$row_edit['balance']} </td>
                    <td>
html;
                    $sql="select * from tbl_member_user where member_id=".$row['id']." ";
                    $query_user=$_SC['db']->query($sql);
                    while($row_follow=$_SC['db']->fetch_array($query_user)){
                        $sql="select * from tbl_user where user_id=".$row_follow['user_id']."";
                        $user_row=$_SC['db']->fetch_array($_SC['db']->query($sql));
                        echo <<<html
                    {$user_row['name']};
html;
                    }
                    echo <<<html
                      </td>
                    <td>{$row['remark']} </td>
                    <td>
                     <a href="index.php?do=detail&ac=record&member_id={$row['id']}"><button type="button" class="btn btn-primary btn-xs" >详细记录</button></a>
                     <a href="index.php?do=detail&ac=deposit&member_id={$row['id']}"><button type="button" class="btn btn-primary btn-xs" >会员充值</button></a>
                  </td>
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
             </div>
         </div>
     </div>
html;
        }
}



function detail_record($user_id,$member_id){
    global $_SC;
    get_header();
    get_left_menu();
    $sql="select * from tbl_member_info where id='".$member_id."'";
    $member_info=$_SC['db']->fetch_array($_SC['db']->query($sql));
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=detail"><i class="icon-dashboard"></i> 客户账户管理</a></li>
              <li class="active"><i class="icon-edit"></i> 客户消费记录</li>
          </ol>
        <div class="row">
         <div class="col-lg-12">
                   <h2>会员账户记录 </h2>
                   <h5><small>会员姓名：{$member_info['name']} </small>
                   &nbsp
                       <small>会员卡号：{$member_info['vip_id']}</small></h5>
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>时间 <i class="icon-sort"></i></th>
                    <th><font color="#468847"> 存入</font>/<font color="red"> 消费</font> <i class="icon-sort"></i></th>
                    <th>内容 <i class="icon-sort"></i></th>
                    <th>金额 <i class="icon-sort"></i></th>
                    <th>余额 <i class="icon-sort"></i></th>
                    <th>备注 <i class="icon-sort"></i></th>
                    <th>状态 <i class="icon-sort"></i></th>
                  </tr>
                </thead>
html;
    $sql="select * from tbl_vip_detail where member_id='".$member_id."'";
    $query=$_SC['db']->query($sql);
    $pageSize = 15;
    $totalCountsql = "select count(*) as t from tbl_vip_detail where member_id='".$member_id."'";
    $query = $_SC['db']->query($totalCountsql);
    $rs = $_SC['db']->fetch_array($query);
    $totalCount = $rs['t'];
    $pageUrl = './index.php?do=detail&ac=record&member_id='.$member_id.'&page=';
    $sql = "select * from tbl_vip_detail  where member_id='".$member_id."' order by uid desc limit " . (($_GET['page']- 1) * $pageSize) . ",$pageSize";
    $query = $_SC['db']->query($sql);

    while($rs=$_SC['db']->fetch_array($query)){
        $time=date('Y-m-d',$rs['time']);
        if($rs['consumption_type']=="存入"){
            $color="#468847";
            $i='+';
        }else{
            $color="red";
            $i='-';
        }
    echo <<<html
                <thead>
                  <tr>
                    <td>{$time} </th>
                    <td><font color="$color"> {$rs['consumption_type']} </font></td>
                    <td>{$rs['content']}  </td>
                    <td>{$i} {$rs['amount_money']} </td>
                    <td>{$rs['balance']}  </td>
                    <td>{$rs['remark']} </td>
                    <td>{$rs['status']} </td>
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
                <div class="col-lg-4">
            <form role="form" action="index.php?do=detail&ac=record&member_id={$member_id}" method="post" enctype="multipart/form-data">
                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">充值金额</label>
                        <input class="form-control" placeholder="请输入金额" name="amount_money">
                      </div>
                    </div>

                     <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">内容</label>
                        <input class="form-control" placeholder="" name="content">
                      </div>
                    </div>

                     <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">备注</label>
                        <input class="form-control" placeholder="" name="remark">
                      </div>
                    </div>

                    <button type="submit" class="btn btn-default" name="add_money">提  交</button>
                    </form>
                    </div>
            </div>
        </div>
        </div>
html;
    if(isset($_POST['add_money'])){
        if(!empty($_POST['amount_money'])){
            if(is_numeric($_POST['amount_money'])){
                $consumption_type="存入";
                //计算当前余额生成本次消费后的新余额
                $sql="select * from tbl_vip_detail where member_id='".$member_id."' order by uid DESC";
                $query=$_SC['db']->query($sql);
                $tmp_arr=$_SC['db']->fetch_array($query);
                if($tmp_arr['balance']!="0"){
                    $balance=$tmp_arr['balance']+$_POST['amount_money'];
                }else{
                    //若不存在余额记录则默认新余额为0-本次消费金额
                    $balance=$_POST['amount_money'];
                }
                $sql="insert into tbl_vip_detail (member_id,time,consumption_type,content,amount_money,balance,remark,s_time) value (".$member_id.",'".time()."','".daddslashes($consumption_type)."','".daddslashes($_POST['content'])."','".daddslashes($_POST['amount_money'])."','".$balance."','".daddslashes($_POST['remark'])."','".time()."')";
                $query=$_SC['db']->query($sql);
                if($query){
                    echo "<script>alert('提示:充值成功，等待财务审核');history.go(-1)</script>";
                }


            }else{
                echo "<script>alert('提示:金额输入错误');history.go(-1)</script>";
            }
        }else{
            echo "<script>alert('提示:金额不能为空');history.go(-1)</script>";
        }
    }
}




