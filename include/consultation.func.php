<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 14-6-25
 * Time: 17:09
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
$acs = array('list','edit','edit_setting','del');
$ac = (!empty($_GET['ac']) && in_array($_GET['ac'], $acs))?$_GET['ac']:'list';
switch ($ac){
    case 'del':
        $id=$_GET['id'];
        $member_id=$_GET['member_id'];
        $user_arr=member_responsible($member_id);
        $user_info=user_info($user_id);
        if(in_array($user_id,$user_arr) || $user_info['mange_all_m']=='1'){
            del($_GET['id'],$user_id);
        }else{
            echo "<script>alert('提示:权限不足');history.go(-1)</script>";
        }
        break;
        break;
    case 'list':
        consultation_list();
        break;
    case 'edit':
        $id=$_GET['id'];
        $member_id=$_GET['member_id'];
        $user_arr=member_responsible($member_id);
        $user_info=user_info($user_id);
        if(in_array($user_id,$user_arr) || $user_info['mange_all_m']=='1'){
            consultation_edit($_GET['id'],$user_id);
        }else{
            echo "<script>alert('提示:权限不足');history.go(-1)</script>";
        }
        break;
    case 'edit_setting':
        $server_id=daddslashes($_GET['server_id']);

        $time = strtotime($_POST['time']);
        $rectime = strtotime($_POST['rectime']);
        $reptime = strtotime($_POST['reptime']);

        $sql="update tbl_member_follow set time='".$time."' , rectime = '".$rectime."' , reptime = '".$reptime."' ,content='".daddslashes($_POST['content'])."' ,follow_plan='".daddslashes($_POST['follow_plan'])."' ,remark='".daddslashes($_POST['remark'])."', server_id='".$_POST['server_id']."' where id='".$id."' ";


        $query=$_SC['db']->query($sql);
        if($query){
            echo "<script>alert('提示:操作成功')</script>";
            echo "<script>location.href='index.php?do=consultation&ac=list'</script>";
        }else{
            echo "<script>alert('提示:操作失败,请确认输入正确');history.go(-1)</script>";
        }
        break;
}


function del($id,$user_id){
    global $_SC;
    $sql="update tbl_member_follow set is_delete='1' where id='".$id."'";
    $query=$_SC['db']->query($sql);
    if($query){
        header('location:'.$_SERVER["HTTP_REFERER"]);
    }else{
        echo "<script>alert('提示:删除失败');history.go(-1)</script>";
    }


}

function consultation_edit($id,$user_id){
    global $_SC;
    get_header();
    get_left_menu();
    $consultation_info=consultation_info($id);
    $time=date('Y-m-d',$consultation_info['time']);

    $rectime=date('Y-m-d H:i:s',$consultation_info['rectime']);
    $reptime=date('Y-m-d H:i:s',$consultation_info['reptime']);

    echo <<<html
        <div id="page-wrapper">
              <div class="">
                  <ol class="breadcrumb">

                      <li><a href="index.php?do=consultation&ac=list"><i class="icon-dashboard"></i> 咨询列表</a></li>
                      <li class="active"><i class="icon-edit"></i>咨询内容</li>
                  </ol>
                         <div class="row">
             <div class="col-lg-6">
             <form role="form" action="index.php?do=consultation&ac=edit_setting&id={$id}" method="post" enctype="multipart/form-data">


                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess" >时间</label>
                        <input class="form-control" placeholder="" name="time" value="{$time}" type="date">
                      </div>
                    </div>




                    <div class="form-group has-success">
                         <div class="form-group">
                         <label class="control-label" for="inputSuccess">Toplist收到邮件时间</label>
                         <input class="form-control"  name="rectime" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})" value="{$rectime}">
                         </div>
                    </div>


                    <div class="form-group has-success">
                         <div class="form-group">
                         <label class="control-label" for="inputSuccess">Toplist回复时间</label>
                         <input class="form-control"  name="reptime" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"  value="{$reptime}">
                         </div>
                    </div>


                  <div class="form-group has-success">
                  <label class="control-label" for="inputSuccess" >订单</label>
                     <select class="form-control" name="server_id">
                     <option value="" >无订单</option>
html;
    if(!empty($_GET['member_id'])){
        $member_id=daddslashes($_GET['member_id']);
        $sql="select order_id,server_id from tbl_server_member where member_id=$member_id";
        $query=$_SC['db']->query($sql);
        while($rs=$_SC['db']->fetch_array($query)){
            $selected="";
            if($rs['server_id']==$consultation_info['server_id']){
                $selected="selected";
            }else{
                $selected="";
            }
            echo <<<html
                  <option value="{$rs['server_id']}" {$selected}>{$rs['order_id']}</option>
html;
        }
    }

    echo <<<html
                    </select>
                    </div>
                    <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">内容</label>
                        <textarea class="form-control" rows="10" name="content">{$consultation_info['content']}</textarea>
                        </textarea>
                      </div>
                    </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">后续计划</label>
                        <input class="form-control" placeholder="" value="{$consultation_info['follow_plan']}" name="follow_plan">
                      </div>
                    </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">备注</label>
                        <textarea class="form-control" rows="10" name="remark">{$consultation_info['remark']}</textarea>

                        </textarea>
                      </div>
                    </div>



                      <button type="submit" class="btn btn-default">提  交</button>
                      <a href="index.php?do=consultation&ac=list" class="btn btn-default">取 消</a>
                  </form>
                </div>
            </div>
        </div>
        </div>
html;
}



function consultation_list(){
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
        <div id="page-wrapper">
              <div class="">
                  <ol class="breadcrumb">
                      <li><a href="index.php?do=consultation&ac=list"><i class="icon-dashboard"></i> 咨询记录</a></li>
                  </ol>

html;
    search_consultation_from();
}




function search_consultation_from(){
    global $_SC;
    echo <<<html
               <ol class="breadcrumb">
                <div class="col-lg-12">
                <form role="form" action="#" method="get" >
                   <table class="table table-bordered table-hover tablesorter">
                   <input type="hidden" name="do" value="consultation">
                   <input type="hidden" name="ac" value="list">

                  <tr>
                    <th colspan="9" style="text-align: center">请输入搜索条件 </th>
                  </tr>

                  <tr>
                    <th style="text-align: center">请输入起始日期 </th>
                    <th style="text-align: center">请输入结束日期 </th>
                    <th style="text-align: center">请输入搜索内容 </th>
                    <th style="text-align: center">点击搜索（导出报表） </th>
                  </tr>


                   <tr>
                   <th ><input class="form-control" type="date" value="{$_GET['time_start']}" name="time_start" id="time_start"></th>
                   <th><input class="form-control" type="date"  value="{$_GET['time_end']}" name="time_end" id="time_end"></th>
                   <th style="text-align: center">
                        <input class="form-control" name="keyword" value="{$_GET['keyword']}">
                   </th>
                   <th style="text-align: center">

                        <div class="btn-group">
                          <button type="submit" class="btn btn-primary btn-1g" style="padding: 6px 40px"><i class="icon-search"></i>搜索</button>
                          <button type="button" class="btn btn-primary dropdown-toggle" id="down" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="consultationexcel.php"  id="export">导出报表</a></li>
                          </ul>
                        </div>
                   </th>

                  </tr>
                </table>
                </form>
                  </div>
                  </ol>

html;
    echo <<<html
            <div class="row">
          <div class="col-lg-12">
            <h2>咨询记录</h2>
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>客户 </th>
                    <th>时间 </th>
                    <th>内容 </th>
                    <th>后续计划 </th>
                    <th>订单信息 </th>
                    <th>备注 </th>
                    <th>操作 </th>
                  </tr>
                </thead>
              <script type="text/javascript">
                $("#down").click(function(){
                    var timestart = $("#time_start").val();
                    var timeend = $("#time_end").val();
                    $("#export").attr('href','consultationexcel.php?time_start=' + timestart +'&'+ 'time_end=' + timeend)
                })
                </script>
html;




    if(!empty($_GET['time_start'])){
        $time_start=strtotime($_GET['time_start']);
        $sql_start="and time>=$time_start";

    }
    if(!empty($_GET['time_end'])){
        $time_end=strtotime($_GET['time_end'])+86399;
        $sql_end="and time<=$time_end";
    }


    if(!empty($_GET['keyword'])){
        $keyword=daddslashes($_GET['keyword']);
        //$sql_keyword="and(name like '%".$keyword."%')";
        $sql = "SELECT * FROM tbl_member_info WHERE  is_delete='0' and(name like '%".$keyword."%'   or sex like '%".$keyword."%' or corporation like '%".$keyword."%' or title like '%".$keyword."%' or marital_status like '%".$keyword."%' or city like '%".$keyword."%' or mobile like '%".$keyword."%' or tel like '%".$keyword."%' or in_class like '%".$keyword."%' or label like '%".$keyword."%')";
        $query = $_SC['db']->query($sql);
        $member_all = array();
        while($rs_tmp=$_SC['db']->fetch_array($query)){
            $member_all[]=$rs_tmp['id'];
        }

        $tmp_sql_2="and( content like '%".$keyword."%' or follow_plan like '%".$keyword."%' or remark like '%".$keyword."%')";



        if($member_all){
            $tmp_sql_1="and (member_id=".implode(" or member_id=",$member_all).")".$tmp_sql_2;
        }else{
            $tmp_sql_1=$tmp_sql_2;
        }
    }




    $pageSize = 15;
    $totalCountsql="select count(*) as t from tbl_member_follow  where is_delete='0' $sql_start  $sql_end $tmp_sql_1 ORDER BY  `tbl_member_follow`.`id` DESC";
    $query_s = $_SC['db']->query($totalCountsql);
    $rs = $_SC['db']->fetch_array($query_s);
    $totalCount = $rs['t'];
    $pageUrl = './index.php?do=consultation&ac=list&keyword='.$_GET['keyword'].'&time_start='.$_GET['time_start'].'&time_end='.$_GET['time_end'].'&page=';
    $sql="select * from tbl_member_follow  where is_delete='0' $sql_start  $sql_end $tmp_sql_1 ORDER BY  `tbl_member_follow`.`id` DESC limit " . (($_GET['page']- 1) * $pageSize) . ",$pageSize";
    $query=$_SC['db']->query($sql);
    while($row_follow=$_SC['db']->fetch_array($query)){
        $row_follow['time']=date("Y-m-d",$row_follow['time']);
        $member_info=member_info($row_follow['member_id']);
        echo <<<html
                  <tr>
                    <td>{$member_info['name']}</td>
                    <td>{$row_follow['time']}</td>
                    <td>{$row_follow['content']}</td>
                    <td>{$row_follow['follow_plan']}</td>
html;
        if(!empty($row_follow['server_id'])){
            $server_info=server_info($row_follow['server_id']);
            echo <<<html
                    <td><a href="index.php?do=member&ac=update_server&server_id={$row_follow['server_id']}&member_id={$row_follow['member_id']}">{$server_info['order_id']}</a></td>
html;
        }else{
            echo <<<html
                    <td>无订单</td>
html;
        }


        echo <<<html
                    <td>{$row_follow['remark']}</td>
                    <td><a href="index.php?do=consultation&ac=edit&id=$row_follow[id]&member_id=$row_follow[member_id]">详细信息</a></td>
                  </tr>
html;
    }
    echo <<<html
              </table>
          </div>
          </div>
html;

    include_once('./include/pagination.class.php');
    $pg = new pagination($totalCount, $pageSize, $pageUrl, 10, true, true, 'right');
    $pg->curPageNum = (($_GET['page'] > $pg->pageNum) or (intval($_GET['page']) <= 0)) ? 1 : $_GET['page'];
    echo $pg->generatePageNav();
    echo <<<html

             </div>


html;
}

//获取咨询内容
function consultation_info($id){
    global $_SC;
    $sql="select * from tbl_member_follow where id='".$id."' and is_delete='0'";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    if($rs){
        return $rs;
    }else{
        return false;
    }
}


function server_info($server_id){
    global $_SC;
    $sql="select * from tbl_server_member where server_id='".$server_id."'";
    $query=$_SC['db']->query($sql);
    if($rs=$_SC['db']->fetch_array($query)){
        $sql="select * from tbl_file where file_id='".$rs['file_id']."'";
        $file_info=$_SC['db']->fetch_array($_SC['db']->query($sql));
        $sql="select * from tbl_file where file_id='".$rs['attachment_id']."'";
        $attachment_info=$_SC['db']->fetch_array($_SC['db']->query($sql));
        array_push($rs,$file_info,$attachment_info);
        return $rs;
    }else{
        return false;
    }
}



