<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 14-6-25
 * Time: 10:59
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
$acs = array('list');
$ac = (!empty($_GET['ac']) && in_array($_GET['ac'], $acs))?$_GET['ac']:'list';
switch ($ac){
    case 'list':
        order_list($_GET['id'],$user,$user_id);
        break;

}



function order_list(){
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
        <div id="page-wrapper">
              <div class="">
                  <ol class="breadcrumb">
                      <li><a href="index.php?do=order&ac=list"><i class="icon-dashboard"></i> 订单列表</a></li>
                  </ol>

html;
    search_order_from();
}




function search_order_from(){
    global $_SC;
    echo <<<html
               <ol class="breadcrumb">
                <div class="col-lg-12">
                <form role="form" action="#" method="get" >
                   <table class="table table-bordered table-hover tablesorter">
                   <input type="hidden" name="do" value="order">
                   <input type="hidden" name="ac" value="list">

                  <tr>
                    <th colspan="9" style="text-align: center">请输入搜索条件 </th>
                  </tr>

                  <tr>
                    <th style="text-align: center">请输入起始日期 </th>
                    <th style="text-align: center">请输入结束日期 </th>
                    <th style="text-align: center">请输入搜索内容 </th>
                    <th style="text-align: center">点击搜索 (导出报表)</th>
                  </tr>


                   <tr>
                   <th ><input class="form-control" type="date" value="{$_GET['time_start']}" name="time_start" id="time_start"></th>
                   <th><input class="form-control" type="date"  value="{$_GET['time_end']}" name="time_end" id="time_end"></th>
                   <th style="text-align: center">
                        <input class="form-control" name="keyword" value="{$_GET['keyword']}">
                   </th>
                   <th style="text-align: center">
                        <!--<button type="submit"  class="btn btn-primary btn-1g " style="padding: 5px 40px"><i class="icon-search"></i> 搜索</button>-->


                        <div class="btn-group">
                          <button type="submit" class="btn btn-primary btn-1g" style="padding: 6px 40px"><i class="icon-search"></i>搜索</button>
                          <button type="button" class="btn btn-primary dropdown-toggle" id="down" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="orderexcel.php"  id="export">导出报表</a></li>
                            <script>


                            </script>
                          </ul>
                        </div>

                   </th>

                  </tr>
                </table>
                </form>
                  </div>
                  </ol>

        <div class="row">
          <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped ">
                <thead>
                  <tr>
                    <th>编号</th>
                    <th>日期</th>
                    <th>客户姓名</th>
                    <th>项目 </th>
                    <th>内容 </th>
                    <th>金额 </th>
                    <th>付款方式</th>
                    <th>付款时间 </th>
                    <th>服务内容类别 </th>
                    <th>合同 </th>
                    <th>附件 </th>
                    <th>备注 </th>
                    <th>操作</th>
                  </tr>
                </thead>

                <script type="text/javascript">
                $("#down").click(function(){
                    var timestart = $("#time_start").val();
                    var timeend = $("#time_end").val();
                    $("#export").attr('href','orderexcel.php?time_start=' + timestart +'&'+ 'time_end=' + timeend)
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

        $sql="SELECT * FROM tbl_product_info where product_name like '%".$keyword."%'";
        $query = $_SC['db']->query($sql);
        while($rs_tmp_pr=$_SC['db']->fetch_array($query)){
            $product_all[]=$rs_tmp_pr['product_id'];
        }
        if($product_all){
            $tmp_sql_pr="or product_id=".implode(" or product_id=",$product_all)."";
        }


        if($member_all){
            $tmp_sql_1="and (member_id=".implode(" or member_id=",$member_all).")";
            $tmp_sql_2="or (content like '%".$keyword."%' or server_type like '%".$keyword."%' or remark like '%".$keyword."%' or pay_mode like '%".$keyword."%')";
            $tmp_sql=$tmp_sql_1.$tmp_sql_2.$tmp_sql_pr;
        }else{
            $tmp_sql="and (content like '%".$keyword."%' or server_type like '%".$keyword."%' or remark like '%".$keyword."%'  or pay_mode like '%".$keyword."%')".$tmp_sql_pr;
        }
    }





    $pageSize = 15;
    $totalCountsql = "select count(*) as t from tbl_server_member where is_delete='0' $sql_start $sql_end $tmp_sql";
    $query_s = $_SC['db']->query($totalCountsql);
    $rs = $_SC['db']->fetch_array($query_s);
    $totalCount = $rs['t'];
    $pageUrl = './index.php?do=order&ac=list&keyword='.$keyword.'&time_start='.$_GET['time_start'].'&time_end='.$_GET['time_end'].'&page=';
    $sql = "select * from tbl_server_member where  is_delete='0' $sql_start $sql_end $tmp_sql order by server_id desc limit " . (($_GET['page']- 1) * $pageSize) . ",$pageSize";
    $query = $_SC['db']->query($sql);

    while($row_server=$_SC['db']->fetch_array($query)){
        $time=date('Y-m-d',$row_server['time']);
        if(!empty($row_server['pay_time'])){
            $pay_time=date('Y-m-d',$row_server['pay_time']);
        }
        $file_info=file_info($row_server['file_id']);
        $attachment=file_info($row_server['attachment_id']);
        $member_info=member_info($row_server['member_id']);

        echo <<<html

                  <tr>
                    <td>{$row_server['order_id']}</td>
                    <td>{$time}</td>
                    <td>{$member_info['name']}</td>
                    <td>
html;
        if(!empty($row_server['product_id'])){
            $sql="select * from tbl_product_info where product_id=".$row_server['product_id']."";
            $product_name=$_SC['db']->fetch_array($_SC['db']->query($sql));


        echo <<<html
                    <a href="index.php?do=product&ac=view&product_id={$row_server['product_id']}">{$product_name['product_name']}</a>
html;
    }else{
            
        }
        echo <<<html
                    </td>
                    <td>{$row_server['content']}</td>
                    <td>{$row_server['amount_money']}</td>
                    <td>{$row_server['pay_mode']}</td>
                    <td>{$pay_time}</td>
                    <td>{$row_server['server_type']}</td>
                    <td><a href="./{$file_info['file_url']}" target="_blank">{$file_info['file_name']}</a></td>
                    <td><a href="./{$attachment['file_url']}" target="_blank">{$attachment['file_name']}</a></td>
                    <td>{$row_server['remark']}</td>
                    <td>
                        <!--<a href="index.php?do=member&ac=update_server&server_id={$row_server['server_id']}&member_id={$id}" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>-->
                        <!--<a href="index.php?do=member&ac=delete_server&server_id={$row_server['server_id']}&member_id={$id}" onclick="return CommandConfirm_server()"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>-->
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

html;
}