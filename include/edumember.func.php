<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-3-27
 * Time: 上午11:01
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

edu_member_list();




function edu_member_list(){
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
        <div id="page-wrapper">
                  <ol class="breadcrumb">
                      <li><a href="index.php?do=member&ac=edit"><i class="icon-dashboard"></i> 客户列表</a></li>
                      <li class="active"><i class="icon-edit"></i> 教育客户列表</li>
                  </ol>
                  <ol class="breadcrumb">
                  <div class="col-lg-12">
                  <a href="index.php?do=member&ac=add"><button type="button" class="btn btn-primary btn-1g btn-block" style="">客户登记</button></a>
                  </div>
                  </ol>
html;

    search_edu_member_from();
    echo <<<html
            <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>姓名 <i class="icon-sort"></i></th>
                    <th>性别 <i class="icon-sort"></i></th>
                    <th>公司 <i class="icon-sort"></i></th>
                    <th>职务 <i class="icon-sort"></i></th>
                    <th>婚姻/有否小孩 <i class="icon-sort"></i></th>
                    <th>城市 <i class="icon-sort"></i></th>
                    <th>手机 <i class="icon-sort"></i></th>
                    <th>座机（公司/家） <i class="icon-sort"></i></th>
                    <th>分类 <i class="icon-sort"></i></th>
                    <th>标签 <i class="icon-sort"></i></th>
                    <th>负责人员 <i class="icon-sort"></i></th>
                    <th>备注 <i class="icon-sort"></i></th>
                    <th>操作 <i class="icon-sort"></i></th>
                  </tr>
                </thead>
html;
    $keyword=daddslashes($_GET['keyword']);
    $pageSize = 15;
    $totalCountsql ="select count(distinct member_id) as t  from tbl_server_member a, tbl_member_info b  where a.server_type='教育服务' and b.is_delete='0' and a.member_id=b.id $sql_add";
    $pageUrl = "./index.php?do=edumember&page=";
    $query = $_SC['db']->query($totalCountsql);
    $rs = $_SC['db']->fetch_array($query);
    $totalCount = $rs['t'];
    $sql_add= "and(name like '%".$keyword."%'   or sex like '%".$keyword."%' or corporation like '%".$keyword."%' or title like '%".$keyword."%' or marital_status like '%".$keyword."%' or city like '%".$keyword."%' or mobile like '%".$keyword."%' or tel like '%".$keyword."%' or in_class like '%".$keyword."%' or label like '%".$keyword."%')  LIMIT " . (($_GET['page']- 1) * $pageSize) . ", $pageSize ";
    $sql="select distinct member_id from tbl_server_member a, tbl_member_info b  where a.server_type='教育服务' and b.is_delete='0'  and a.member_id=b.id $sql_add";
    $query=$_SC['db']->query($sql);
    while($row=$_SC['db']->fetch_array($query)){
        $member_info=member_info($row['member_id']);
        $user_arr=member_responsible($row['member_id']);

        echo <<<html
                      <tr>
                        <td>{$member_info['name']}</td>
                        <td>{$member_info['sex']}</td>
                        <td>{$member_info['corporation']}</td>
                        <td>{$member_info['title']}</td>
                        <td>{$member_info['marital_status']}/{$member_info['is_children']}</td>
                        <td>{$member_info['city']}</td>
                        <td>{$member_info['mobile']}</td>
                        <td>{$member_info['tel']}</td>
                        <td>{$member_info['in_class']}</td>
                        <td>{$member_info['label']}</td>
                        <td>
html;
                member_responsible_name_arr($user_arr);
                echo <<<html
                        </td>
                        <td>{$member_info['remark']}</td>
                        <td>
                        <a href="index.php?do=member&ac=follow&id={$member_info['id']}"><button type="button" class="btn btn-primary btn-xs" >详细信息</button></a>
                        <a href="index.php?do=edu&member_id={$member_info['id']}"><button type="button" class="btn btn-primary btn-xs" >教育服务</button></a>
                        <a href="index.php?do=member&ac=update&id={$member_info['id']}"><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
                        <a href="index.php?do=member&ac=delete&id={$member_info['id']}" onclick='return CommandConfirm();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
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
html;






}