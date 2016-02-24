<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-2-18
 * Time: 上午11:25
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
$acs = array('list','update','delete','delete_call','add');
$ac = (!empty($_GET['ac']) && in_array($_GET['ac'], $acs))?$_GET['ac']:'list';

switch ($ac){
    case 'list':
        member_edu_list();
        break;
    case 'delete':
        edu_server_delete($_GET['member_id'],$_GET['edu_server_id'],$_GET['tbl_s_id']);
        break;
    case 'add':
                $tbl_name="tbl_s".$_GET['tbl_s_id'];
                $member_id=$_GET['member_id'];
                $sql="insert into $tbl_name (member_id,reg_time,is_delete) value ('$member_id','".time()."','1')";
                $query=$_SC['db']->query($sql);
                $edu_server_id=$_SC['db']->insert_id();
                $server_type="教育服务";
                $sql="insert into tbl_server_member (member_id,time,server_type,user_id,is_delete,edu_class_id,edu_s_id) value ('".$_GET['member_id']."','".time()."','".daddslashes($server_type)."','$user_id','1','".$_GET['tbl_s_id']."','".$edu_server_id."')";
                $query=$_SC['db']->query($sql);
                echo "<script>location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id={$_GET['tbl_s_id']}'</script>";
        break;
    case 'update':
        edu_server_update($_GET['member_id'],$_GET['edu_server_id'],$_GET['tbl_s_id']);
        break;
    case 'delete_call':
        delete_call($_GET['call_id']);
        break;
}
function member_edu_list(){
    global $_SC;
    get_header();
    get_left_menu();
    $acts = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17');
    $act = (!empty($_GET['class']) && in_array($_GET['class'], $acts))?$_GET['class']:'1';
    switch ($act){
        case '1':
            $act1="active in";
            break;
        case '2':
            $act2="active in";
            break;
        case '3':
            $act3="active in";
            break;
        case '4':
            $act4="active in";
            break;
        case '5':
            $act5="active in";
            break;
        case '6':
            $act6="active in";
            break;
        case '7':
            $act7="active in";
            break;
        case '8':
            $act8="active in";
            break;
        case '9':
            $act9="active in";
            break;
        case '10':
            $act10="active in";
            break;
        case '11':
            $act11="active in";
            break;
        case '12':
            $act12="active in";
            break;
        case '13':
            $act13="active in";
            break;
        case '14':
            $act14="active in";
            break;
        case '15':
            $act15="active in";
            break;
        case '16':
            $act16="active in";
            break;
        case '17':
            $act17="active in";
            break;
    }
//获取分类记录
    $member_info=member_info($_GET['member_id']);
    $s1_list=edu_list_s($_GET['member_id'],1);
    $s2_list=edu_list_s($_GET['member_id'],2);
    $s3_list=edu_list_s($_GET['member_id'],3);
    $s4_list=edu_list_s($_GET['member_id'],4);
    $s5_list=edu_list_s($_GET['member_id'],5);
    $s6_list=edu_list_s($_GET['member_id'],6);
    $s7_list=edu_list_s($_GET['member_id'],7);
    $s8_list=edu_list_s($_GET['member_id'],8);
    $s9_list=edu_list_s($_GET['member_id'],9);
    $s10_list=edu_list_s($_GET['member_id'],10);
    $s11_list=edu_list_s($_GET['member_id'],11);
    $s12_list=edu_list_s($_GET['member_id'],12);
    $s13_list=edu_list_s($_GET['member_id'],13);
    $s14_list=edu_list_s($_GET['member_id'],14);
    $s15_list=edu_list_s($_GET['member_id'],15);
    $s16_list=edu_list_s($_GET['member_id'],16);
    $s17_list=edu_list_s($_GET['member_id'],17);

    $act="active in";
    echo <<<html
        <div id="page-wrapper">
              <div class="">
                  <ol class="breadcrumb">
                      <li><a href="index.php?do=member&ac=edit"><i class="icon-dashboard"></i>客户信息</a></li>
                      <li class="active"><i class="icon-edit"></i>{$member_info['name']}的教育服务记录</li>
                  </ol>

html;

echo <<<html
            <div class="col-lg-12">
            <div class="table-responsive">


              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    点击选择查看服务项 <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a href="#dropdown1" data-toggle="tab">培训</a></li>
                    <li><a href="#dropdown2" data-toggle="tab">申请大学/高中</a></li>
                    <li><a href="#dropdown3" data-toggle="tab">海外机场接送</a></li>
                    <li><a href="#dropdown4" data-toggle="tab">海外机场礼遇</a></li>
                    <li><a href="#dropdown5" data-toggle="tab">行李遗失服务</a></li>
                    <li><a href="#dropdown6" data-toggle="tab">寄宿家庭和房屋租凭</a></li>
                    <li><a href="#dropdown7" data-toggle="tab">留学生当地电话卡服务</a></li>
                    <li><a href="#dropdown8" data-toggle="tab">入境手续和当地居住手续</a></li>
                    <li><a href="#dropdown9" data-toggle="tab">生活费管理及学习监理</a></li>
                    <li><a href="#dropdown10" data-toggle="tab">生活资讯服务</a></li>
                    <li><a href="#dropdown11" data-toggle="tab">海外租车和援驾服务</a></li>
                    <li><a href="#dropdown12" data-toggle="tab">健康管理和就医服务</a></li>
                    <li><a href="#dropdown13" data-toggle="tab">翻译服务</a></li>
                    <li><a href="#dropdown14" data-toggle="tab">护照证件等遗失应急服务</a></li>
                    <li><a href="#dropdown15" data-toggle="tab">留学托管</a></li>
                    <li><a href="#dropdown16" data-toggle="tab">游学</a></li>
                    <li><a href="#dropdown17" data-toggle="tab">旅游定制服务</a></li>
                  </ul>
                </li>
              </ul>
              <div id="myTabContent" class="tab-content">

<!--S1-start-->
              <div class="tab-pane fade {$act1}" id="dropdown1">
              <h1>培训</h1>
                <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>服务名称</th>
                    <th>联系人姓名</th>
                    <th>留学生姓名</th>
                    <th>服务状态</th>
                    <th>操作</th>
                  </tr>
                </thead>
html;
    foreach($s1_list as $v){
        if(is_complete($v['is_complete'])){
            $is_complete="完成";
        }else{
            $is_complete="未完成";
        }
        echo <<<html
            <tr>
            <td>{$v['server_name']}</td>
            <td>{$member_info['name']}</td>
            <td>{$v['student_name']}</td>
            <td>{$is_complete}</td>
            <td>
            <a href="index.php?do=edu&ac=update&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=1" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
            <a href="index.php?do=edu&ac=delete&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=1" onclick='return CommandConfirm_server();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
            </td>
            </tr>
html;
        unset($is_complete);
    }
    echo <<<html
                  <tr><td colspan="5" align="center"><a href="index.php?do=edu&ac=add&member_id={$_GET['member_id']}&tbl_s_id=1" data-toggle="modal"  >创建接培训服务</a></td></tr>
                </table>
              </div>
<!--S1--end-->



<!--S2-start-->
              <div class="tab-pane fade {$act2}" id="dropdown2">
              <h1>申请大学/高中</h1>
                <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>服务名称</th>
                    <th>联系人姓名</th>
                    <th>留学生姓名</th>
                    <th>服务状态</th>
                    <th>操作</th>
                  </tr>
                </thead>
html;
    foreach($s2_list as $v){
        $member_info=member_info($v['member_id']);
        if(is_complete($v['is_complete'])){
            $is_complete="完成";
        }else{
            $is_complete="未完成";
        }
        echo <<<html
            <tr>
            <td>{$v['server_name']}</td>
            <td>{$member_info['name']}</td>
            <td>{$v['student_name']}</td>
            <td>{$is_complete}</td>
            <td>
            <a href="index.php?do=edu&ac=update&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=2" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
            <a href="index.php?do=edu&ac=delete&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=2" onclick='return CommandConfirm_server();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
            </td>
            </tr>
html;
        unset($is_complete);
    }
    echo <<<html
                  <tr><td colspan="5" align="center"><a href="index.php?do=edu&ac=add&member_id={$_GET['member_id']}&tbl_s_id=2" data-toggle="modal"  >创建接培训服务</a></td></tr>
                </table>
              </div>
<!--S2--end-->


<!--S3-start-->
            <div class="tab-pane fade {$act3}" id="dropdown3">
            <h1>海外机场接送</h1>
                <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>服务名称</th>
                    <th>客户姓名</th>
                    <th>接机人姓名</th>
                    <th>服务状态</th>
                    <th>操作</th>
                  </tr>
                </thead>
html;
        foreach($s3_list as $v){
            $member_info=member_info($v['member_id']);
            if(is_complete($v['is_complete'])){
                $is_complete="完成";
            }else{
                $is_complete="未完成";
            }
            echo <<<html
            <tr>
            <td>{$v['server_name']}</td>
            <td>{$member_info['name']}</td>
            <td>{$v['meeting_name']}</td>
            <td>{$is_complete}</td>
            <td>
            <a href="index.php?do=edu&ac=update&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=3" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
            <a href="index.php?do=edu&ac=delete&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=3" onclick='return CommandConfirm_server();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
            </td>
            </tr>
html;
            unset($is_complete);
        }
    echo <<<html
                  <tr><td colspan="5" align="center"><a href="index.php?do=edu&ac=add&member_id={$_GET['member_id']}&tbl_s_id=3" data-toggle="modal"  >创建接送机服务</a></td></tr>
                </table>
              </div>
    <!--S3--end-->

    <!--S4--start-->
              <div class="tab-pane fade {$act4}" id="dropdown4">
              <h1>海外机场礼遇</h1>
                <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>服务名称</th>
                    <th>客户姓名</th>
                    <th>联系人姓名</th>
                    <th>服务状态</th>
                    <th>操作</th>
                  </tr>
                </thead>
html;
    foreach($s4_list as $v){
        $member_info=member_info($v['member_id']);
        if(is_complete($v['is_complete'])){
            $is_complete="完成";
        }else{
            $is_complete="未完成";
        }
        echo <<<html
            <tr>
            <td>{$v['server_name']}</td>
            <td>{$member_info['name']}</td>
            <td>{$v['meeting_name']}</td>
            <td>{$is_complete}</td>
            <td>
            <a href="index.php?do=edu&ac=update&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=4" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
            <a href="index.php?do=edu&ac=delete&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=4" onclick='return CommandConfirm_server();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
            </td>
            </tr>
html;
        unset($is_complete);
    }
    echo <<<html
                  <tr><td colspan="5" align="center"><a href="index.php?do=edu&ac=add&member_id={$_GET['member_id']}&tbl_s_id=4" data-toggle="modal"  >创建机场礼遇服务</a></td></tr>
                </table>



              </div>
    <!--s4--end-->

    <!--s5--start-->
    <div class="tab-pane fade {$act5}" id="dropdown5">
              <h1>行李遗失服务</h1>
                <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>服务名称</th>
                    <th>客户姓名</th>
                    <th>联系人姓名</th>
                    <th>服务状态</th>
                    <th>操作</th>
                  </tr>
                </thead>
html;
    foreach($s5_list as $v){
        $member_info=member_info($v['member_id']);
        if(is_complete($v['is_complete'])){
            $is_complete="完成";
        }else{
            $is_complete="未完成";
        }
        echo <<<html
            <tr>
            <td>{$v['server_name']}</td>
            <td>{$member_info['name']}</td>
            <td>{$v['meeting_name']}</td>
            <td>{$is_complete}</td>
            <td>
            <a href="index.php?do=edu&ac=update&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=5" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
            <a href="index.php?do=edu&ac=delete&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=5" onclick='return CommandConfirm_server();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
            </td>
            </tr>
html;
        unset($is_complete);
    }
    echo <<<html
                  <tr><td colspan="5" align="center"><a href="index.php?do=edu&ac=add&member_id={$_GET['member_id']}&tbl_s_id=5" data-toggle="modal"  >创建行李遗失服务</a></td></tr>
                </table>
    </div>
    <!--s5--end-->

    <!--s6--start-->
    <div class="tab-pane fade {$act6}" id="dropdown6">
              <h1>寄宿家庭和房屋租凭</h1>
                <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>服务名称</th>
                    <th>客户姓名</th>
                    <th>服务状态</th>
                    <th>操作</th>
                  </tr>
                </thead>
html;
    foreach($s6_list as $v){
        $member_info=member_info($v['member_id']);
        if(is_complete($v['is_complete'])){
            $is_complete="完成";
        }else{
            $is_complete="未完成";
        }
        echo <<<html
            <tr>
            <td>{$v['server_name']}</td>
            <td>{$member_info['name']}</td>
            <td>{$is_complete}</td>
            <td>
            <a href="index.php?do=edu&ac=update&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=6" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
            <a href="index.php?do=edu&ac=delete&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=6" onclick='return CommandConfirm_server();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
            </td>
            </tr>
html;
        unset($is_complete);
    }
    echo <<<html
              <tr><td colspan="5" align="center"><a href="index.php?do=edu&ac=add&member_id={$_GET['member_id']}&tbl_s_id=6" data-toggle="modal"  >创建房屋租凭服务</a></td></tr>
         </table>
    </div>
    <!--s6--end-->
    <!--s7--start-->
     <div class="tab-pane fade {$act7}" id="dropdown7">
              <h1>留学生当地电话卡服务</h1>
                <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>服务名称</th>
                    <th>客户姓名</th>
                    <th>服务状态</th>
                    <th>操作</th>
                  </tr>
                </thead>

html;
foreach($s7_list as $v){
    $member_info=member_info($v['member_id']);
    if(is_complete($v['is_complete'])){
        $is_complete="完成";
    }else{
        $is_complete="未完成";
    }
    echo <<<html
            <tr>
            <td>{$v['server_name']}</td>
            <td>{$member_info['name']}</td>
            <td>{$is_complete}</td>
            <td>
            <a href="index.php?do=edu&ac=update&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=7" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
            <a href="index.php?do=edu&ac=delete&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=7" onclick='return CommandConfirm_server();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
            </td>
            </tr>

html;
    unset($is_complete);
}
echo <<<html
             <tr><td colspan="5" align="center"><a href="index.php?do=edu&ac=add&member_id={$_GET['member_id']}&tbl_s_id=7" data-toggle="modal"  >创建留学生当地电话卡服务</a></td></tr>
            </table>
    </div>
    <!--s7--end-->
    <!--s8--start-->
     <div class="tab-pane fade {$act8}" id="dropdown8">
              <h1>入境手续和当地居住手续</h1>
                <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>服务名称</th>
                    <th>客户姓名</th>
                    <th>服务状态</th>
                    <th>操作</th>
                  </tr>
                </thead>

html;
    foreach($s8_list as $v){
        $member_info=member_info($v['member_id']);
        if(is_complete($v['is_complete'])){
            $is_complete="完成";
        }else{
            $is_complete="未完成";
        }
        echo <<<html
            <tr>
            <td>{$v['server_name']}</td>
            <td>{$member_info['name']}</td>
            <td>{$is_complete}</td>
            <td>
            <a href="index.php?do=edu&ac=update&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=8" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
            <a href="index.php?do=edu&ac=delete&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=8" onclick='return CommandConfirm_server();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
            </td>
            </tr>

html;
        unset($is_complete);
    }
    echo <<<html
             <tr><td colspan="5" align="center"><a href="index.php?do=edu&ac=add&member_id={$_GET['member_id']}&tbl_s_id=8" data-toggle="modal"  >创建入境手续和当地居住手续服务</a></td></tr>
            </table>
     </div>
    <!--s8--end-->
    <!--s9--start-->
     <div class="tab-pane {$act9}" id="dropdown9">
              <h1>生活费管理及学习监理</h1>
                <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>服务名称</th>
                    <th>客户姓名</th>
                    <th>服务状态</th>
                    <th>操作</th>
                  </tr>
                </thead>

html;
    foreach($s9_list as $v){
        $member_info=member_info($v['member_id']);
        if(is_complete($v['is_complete'])){
            $is_complete="完成";
        }else{
            $is_complete="未完成";
        }
        echo <<<html
            <tr>
            <td>{$v['server_name']}</td>
            <td>{$member_info['name']}</td>
            <td>{$is_complete}</td>
            <td>
            <a href="index.php?do=edu&ac=update&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=9" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
            <a href="index.php?do=edu&ac=delete&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=9" onclick='return CommandConfirm_server();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
            </td>
            </tr>

html;
        unset($is_complete);
    }
    echo <<<html
             <tr><td colspan="5" align="center"><a href="index.php?do=edu&ac=add&member_id={$_GET['member_id']}&tbl_s_id=9" data-toggle="modal"  >创建生活费管理及学习监理服务</a></td></tr>
            </table>
     </div>
    <!--s9--end-->
    <!--s10--start-->
     <div class="tab-pane fade {$act10}" id="dropdown10">
              <h1>生活资讯服务</h1>
                <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>服务名称</th>
                    <th>客户姓名</th>
                    <th>服务状态</th>
                    <th>操作</th>
                  </tr>
                </thead>
html;
    foreach($s10_list as $v){
        $member_info=member_info($v['member_id']);
        if(is_complete($v['is_complete'])){
            $is_complete="完成";
        }else{
            $is_complete="未完成";
        }
        echo <<<html
            <tr>
            <td>{$v['server_name']}</td>
            <td>{$member_info['name']}</td>
            <td>{$is_complete}</td>
            <td>
            <a href="index.php?do=edu&ac=update&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=10" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
            <a href="index.php?do=edu&ac=delete&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=10" onclick='return CommandConfirm_server();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
            </td>
            </tr>
html;
        unset($is_complete);
    }
    echo <<<html
              <tr><td colspan="5" align="center"><a href="index.php?do=edu&ac=add&member_id={$_GET['member_id']}&tbl_s_id=10" data-toggle="modal"  >创建生活资讯服务</a></td></tr>
         </table>

     </div>
    <!--s10--end-->
    <!--s11--start-->
     <div class="tab-pane fade {$act11}" id="dropdown11">
              <h1>海外租车和援驾服务</h1>
                <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>服务名称</th>
                    <th>客户姓名</th>
                    <th>服务状态</th>
                    <th>操作</th>
                  </tr>
                </thead>

html;
    foreach($s11_list as $v){
        $member_info=member_info($v['member_id']);
        if(is_complete($v['is_complete'])){
            $is_complete="完成";
        }else{
            $is_complete="未完成";
        }
        echo <<<html
            <tr>
            <td>{$v['server_name']}</td>
            <td>{$member_info['name']}</td>
            <td>{$is_complete}</td>
            <td>
            <a href="index.php?do=edu&ac=update&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=11" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
            <a href="index.php?do=edu&ac=delete&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=11" onclick='return CommandConfirm_server();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
            </td>
            </tr>

html;
        unset($is_complete);
    }
    echo <<<html
             <tr><td colspan="5" align="center"><a href="index.php?do=edu&ac=add&member_id={$_GET['member_id']}&tbl_s_id=11" data-toggle="modal"  >创建海外租车和援驾服务</a></td></tr>
            </table>
     </div>
    <!--s11--end-->
    <!--s12--start-->
     <div class="tab-pane fade {$act12}" id="dropdown12">
              <h1>健康管理及就医服务</h1>
                <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>服务名称</th>
                    <th>客户姓名</th>
                    <th>服务状态</th>
                    <th>操作</th>
                  </tr>
                </thead>

html;
    foreach($s12_list as $v){
        $member_info=member_info($v['member_id']);
        if(is_complete($v['is_complete'])){
            $is_complete="完成";
        }else{
            $is_complete="未完成";
        }
        echo <<<html
            <tr>
            <td>{$v['server_name']}</td>
            <td>{$member_info['name']}</td>
            <td>{$is_complete}</td>
            <td>
            <a href="index.php?do=edu&ac=update&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=12" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
            <a href="index.php?do=edu&ac=delete&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=12" onclick='return CommandConfirm_server();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
            </td>
            </tr>

html;
        unset($is_complete);
    }
    echo <<<html
             <tr><td colspan="5" align="center"><a href="index.php?do=edu&ac=add&member_id={$_GET['member_id']}&tbl_s_id=12" data-toggle="modal"  >创建健康管理及就医服务</a></td></tr>
            </table>
     </div>
    <!--s12--end-->
    <!--s13--start-->
     <div class="tab-pane fade fade {$act13}" id="dropdown13">
              <h1>翻译服务</h1>
                <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>服务名称</th>
                    <th>客户姓名</th>
                    <th>服务状态</th>
                    <th>操作</th>
                  </tr>
                </thead>

html;
    foreach($s13_list as $v){
        $member_info=member_info($v['member_id']);
        if(is_complete($v['is_complete'])){
            $is_complete="完成";
        }else{
            $is_complete="未完成";
        }
        echo <<<html
            <tr>
            <td>{$v['server_name']}</td>
            <td>{$member_info['name']}</td>
            <td>{$is_complete}</td>
            <td>
            <a href="index.php?do=edu&ac=update&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=13" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
            <a href="index.php?do=edu&ac=delete&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=13" onclick='return CommandConfirm_server();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
            </td>
            </tr>

html;
        unset($is_complete);
    }
    echo <<<html
             <tr><td colspan="5" align="center"><a href="index.php?do=edu&ac=add&member_id={$_GET['member_id']}&tbl_s_id=13" data-toggle="modal"  >创建健康管理及就医服务</a></td></tr>
            </table>
     </div>
    <!--s13--end-->
    <!--s14--start-->
     <div class="tab-pane fade {$act14}" id="dropdown14">
              <h1>证件遗失等应急服务</h1>
                <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>服务名称</th>
                    <th>客户姓名</th>
                    <th>服务状态</th>
                    <th>操作</th>
                  </tr>
                </thead>

html;
    foreach($s14_list as $v){
        $member_info=member_info($v['member_id']);
        if(is_complete($v['is_complete'])){
            $is_complete="完成";
        }else{
            $is_complete="未完成";
        }
        echo <<<html
            <tr>
            <td>{$v['server_name']}</td>
            <td>{$member_info['name']}</td>
            <td>{$is_complete}</td>
            <td>
            <a href="index.php?do=edu&ac=update&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=14" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
            <a href="index.php?do=edu&ac=delete&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=14" onclick='return CommandConfirm_server();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
            </td>
            </tr>

html;
        unset($is_complete);
    }
    echo <<<html
             <tr><td colspan="5" align="center"><a href="index.php?do=edu&ac=add&member_id={$_GET['member_id']}&tbl_s_id=14" data-toggle="modal"  >创建健康管理及就医服务</a></td></tr>
            </table>
     </div>
    <!--s14--end-->
    <!--s15--start-->
     <div class="tab-pane fade {$act15}" id="dropdown15">
              <h1>留学托管</h1>
                <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>服务名称</th>
                    <th>客户姓名</th>
                    <th>服务状态</th>
                    <th>操作</th>
                  </tr>
                </thead>

html;
    foreach($s15_list as $v){
        $member_info=member_info($v['member_id']);
        if(is_complete($v['is_complete'])){
            $is_complete="完成";
        }else{
            $is_complete="未完成";
        }
        echo <<<html
            <tr>
            <td>{$v['server_name']}</td>
            <td>{$member_info['name']}</td>
            <td>{$is_complete}</td>
            <td>
            <a href="index.php?do=edu&ac=update&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=15" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
            <a href="index.php?do=edu&ac=delete&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=15" onclick='return CommandConfirm_server();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
            </td>
            </tr>

html;
        unset($is_complete);
    }
    echo <<<html
             <tr><td colspan="5" align="center"><a href="index.php?do=edu&ac=add&member_id={$_GET['member_id']}&tbl_s_id=15" data-toggle="modal"  >创建留学托管服务</a></td></tr>
            </table>
     </div>
    <!--s15--end-->
    <!--s16--start-->
     <div class="tab-pane fade {$act16}" id="dropdown16">
              <h1>游学</h1>
                <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>服务名称</th>
                    <th>客户姓名</th>
                    <th>服务状态</th>
                    <th>操作</th>
                  </tr>
                </thead>

html;
    foreach($s16_list as $v){
        $member_info=member_info($v['member_id']);
        if(is_complete($v['is_complete'])){
            $is_complete="完成";
        }else{
            $is_complete="未完成";
        }
        echo <<<html
            <tr>
            <td>{$v['server_name']}</td>
            <td>{$member_info['name']}</td>
            <td>{$is_complete}</td>
            <td>
            <a href="index.php?do=edu&ac=update&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=16" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
            <a href="index.php?do=edu&ac=delete&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=16" onclick='return CommandConfirm_server();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
            </td>
            </tr>

html;
        unset($is_complete);
    }
    echo <<<html
             <tr><td colspan="5" align="center"><a href="index.php?do=edu&ac=add&member_id={$_GET['member_id']}&tbl_s_id=16" data-toggle="modal"  >创建游学服务</a></td></tr>
            </table>

     </div>
    <!--s16--end-->
    <!--s17--start-->
     <div class="tab-pane fade {$act17}" id="dropdown17">
              <h1>旅游定制服务</h1>
                <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>服务名称</th>
                    <th>客户姓名</th>
                    <th>服务状态</th>
                    <th>操作</th>
                  </tr>
                </thead>

html;
    foreach($s17_list as $v){
        $member_info=member_info($v['member_id']);
        if(is_complete($v['is_complete'])){
            $is_complete="完成";
        }else{
            $is_complete="未完成";
        }
        echo <<<html
            <tr>
            <td>{$v['server_name']}</td>
            <td>{$member_info['name']}</td>
            <td>{$is_complete}</td>
            <td>
            <a href="index.php?do=edu&ac=update&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=17" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
            <a href="index.php?do=edu&ac=delete&member_id={$v['member_id']}&edu_server_id={$v['s_id']}&tbl_s_id=17" onclick='return CommandConfirm_server();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
            </td>
            </tr>

html;
        unset($is_complete);
    }
    echo <<<html
             <tr><td colspan="5" align="center"><a href="index.php?do=edu&ac=add&member_id={$_GET['member_id']}&tbl_s_id=17" data-toggle="modal"  >创建旅游定制服务</a></td></tr>
            </table>
     </div>
    <!--s17--end-->


html;
echo <<<html
            </div>
        </div>
html;

}














function edu_server_update($member_id,$edu_server_id,$tbl_s_id){
    global $_SC;
    if($tbl_s_id==1)
       update_s1($member_id,$edu_server_id);
    elseif($tbl_s_id==2)
        update_s2($member_id,$edu_server_id);
    elseif($tbl_s_id==3)
        update_s3($member_id,$edu_server_id);
    elseif($tbl_s_id==4)
       update_s4($member_id,$edu_server_id);
    elseif($tbl_s_id==5)
        update_s5($member_id,$edu_server_id);
    elseif($tbl_s_id==6)
        update_s6($member_id,$edu_server_id);
    elseif($tbl_s_id==7)
        update_s7($member_id,$edu_server_id);
    elseif($tbl_s_id==8)
        update_s8($member_id,$edu_server_id);
    elseif($tbl_s_id==9)
        update_s9($member_id,$edu_server_id);
    elseif($tbl_s_id==10)
        update_s10($member_id,$edu_server_id);
    elseif($tbl_s_id==11)
        update_s11($member_id,$edu_server_id);
    elseif($tbl_s_id==12)
        update_s12($member_id,$edu_server_id);
    elseif($tbl_s_id==13)
        update_s13($member_id,$edu_server_id);
    elseif($tbl_s_id==14)
        update_s14($member_id,$edu_server_id);
    elseif($tbl_s_id==15)
        update_s15($member_id,$edu_server_id);
    elseif($tbl_s_id==16)
        update_s16($member_id,$edu_server_id);
    elseif($tbl_s_id==17)
        update_s17($member_id,$edu_server_id);
}


function update_s1($member_id,$edu_server_id){
    global $_SC;
    get_header();
    get_left_menu();
    $tbl_s_id="1";
    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
    if($edu_server_info['is_complete']==0){
        $selected_a="selected";
    }else{
        $selected_b="selected";
    }

    if($edu_server_info['pay_status']==0){
        $selected_pay_a="selected";
    }else{
        $selected_pay_b="selected";
    }




    $member_info=member_info($member_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=edu&member_id={$member_id}"><i class="icon-dashboard"></i>教育服务记录 </a></li>
              <li class="active"><i class="icon-edit"></i><a href="index.php?do=edu&member_id={$member_id}&class=1">{$member_info['name']}培训服务列表</a></li>
              <li class="active"><i class="icon-edit"></i>{$edu_server_info['server_name']}详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#basic_info" data-toggle="tab">基本信息</a></li>
                <li><a href="#server_need" data-toggle="tab">服务需求</a></li>
                <li><a href="#pay_info" data-toggle="tab">支付信息</a></li>
                <li><a href="#server_status" data-toggle="tab">服务状态</a></li>
                <li><a href="#visit" data-toggle="tab">回访情况</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <!--基本信息--start-->
                <div class="tab-pane fade active in" id="basic_info">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务名称</label>
                                                    <input class="form-control" value="{$edu_server_info['server_name']}" name="server_name">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_name']}" name="contact_name">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">留学生姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['student_name']}" name="student_name">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">留学生年龄</label>
                                                    <input class="form-control" value="{$edu_server_info['student_age']}" name="student_age">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">住址1</label>
                                                    <input class="form-control" value="{$edu_server_info['address_1']}" name="address_1">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">住址2</label>
                                                    <input class="form-control" value="{$edu_server_info['address_2']}" name="address_2">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人电话</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_mobile']}" name="contact_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人邮箱</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_email']}" name="contact_email">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">留学生电话</label>
                                                    <input class="form-control" value="{$edu_server_info['student_mobile']}" name="student_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">留学生邮箱</label>
                                                    <input class="form-control" value="{$edu_server_info['student_email']}" name="student_email">
                                                  </div>
                                                </div>



                </div>
                <!--基本信息--end-->
                <!--服务需求--start-->
                <div class="tab-pane fade" id="server_need">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">留学国家</label>
                                                    <input class="form-control" value="{$edu_server_info['foreign_countries']}" name="foreign_countries">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">现就读学校</label>
                                                    <input class="form-control" value="{$edu_server_info['attend_school']}" name="attend_school">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">留学学校</label>
                                                    <input class="form-control" value="{$edu_server_info['study_school']}" name="study_school">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">英语水平描述</label>
                                                    <input class="form-control" value="{$edu_server_info['english_description']}" name="english_description">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">期望培训地</label>
                                                    <input class="form-control" value="{$edu_server_info['expected_training']}" name="expected_training">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">推荐供应商</label>
                                                    <input class="form-control" value="{$edu_server_info['recommended_supplier']}" name="recommended_supplier">
                                                  </div>
                                                </div>

                </div>
                <!--服务需求--end-->
                <!--支付信息--start-->
               <div class="tab-pane fade" id="pay_info">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">支付方式</label>
                                                    <input class="form-control" value="{$edu_server_info['payment']}" name="payment">
                                                  </div>
                                                </div>



                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务内容</label>
                                                    <input class="form-control" value="{$edu_server_info['server_content']}" name="server_content">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">金额</label>
                                                    <input class="form-control" value="{$edu_server_info['money_amount']}" name="money_amount">
                                                  </div>
                                                </div>



                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">支付状态</label>
                                                    <select class="form-control" name="pay_status">
                                                      <option value="0" {$selected_pay_a}>未付</option>
                                                      <option value="1" {$selected_pay_b}>已付</option>
                                                    </select>
                                                  </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">抵用卷</label>
                                                    <input class="form-control" value="{$edu_server_info['vouchers']}" name="vouchers">
                                                  </div>
                                                </div>



                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">支付时间</label>
                                                    <input class="form-control" value="{$edu_server_info['pay_time']}" name="pay_time" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                                                  </div>
                                                </div>

                </div>
            <!--支付信息--end-->
            <!--服务状态--start-->
               <div class="tab-pane fade" id="server_status">
                                                 <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">面试时间</label>
                                                    <input class="form-control" value="{$edu_server_info['interview_time']}" name="interview_time" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                                                  </div>
                                                </div>



                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">面试回访</label>
                                                    <input class="form-control" value="{$edu_server_info['Interview_visit']}" name="Interview_visit">
                                                  </div>
                                                </div>



                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">考试提醒</label>
                                                    <input class="form-control" value="{$edu_server_info['exam_remind']}" name="exam_remind">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">出分日期</label>
                                                    <input class="form-control" value="{$edu_server_info['out_date']}" name="out_date" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                                                  </div>
                                                </div>


                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">完成状态</label>
                                                    <select class="form-control" name="is_complete">
                                                      <option value="0" {$selected_a}>未完成</option>
                                                      <option value="1" {$selected_b}>已完成</option>
                                                    </select>
                                                  </div>


                </div>
        <!--服务状态--end-->
        <!--回访情况--start-->
        <div class="tab-pane fade" id="visit">
                                                        <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">满意度回访</label>
                                                    <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction']}" name="reciprocal_satisfaction">
                                                  </div>
                                                </div>
        </div>
        <!--回访情况--end-->

              </div>
            </div>
            <div class="form-group">
                      <button type="submit" class="btn btn-default" name="update_edu_server">提 交</button>
                      <a href="index.php?do=edu&member_id={$member_id}" class="btn btn-default">取 消</a>
                      </div>
                  </form>
                </div>
            </div>
        </div>

html;
    call_module($edu_server_id,$tbl_s_id,$member_id);
if(isset($_POST['update_edu_server'])){

    if(!empty($_POST['server_name'])){
        $sql="UPDATE `tbl_s1` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['contact_name'])){
        $sql="UPDATE `tbl_s1` SET `contact_name` ='".daddslashes($_POST['contact_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['student_name'])){
        $sql="UPDATE `tbl_s1` SET `student_name` ='".daddslashes($_POST['student_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['student_age'])){
        $sql="UPDATE `tbl_s1` SET `student_age` ='".daddslashes($_POST['student_age'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['server_name'])){
        $sql="UPDATE `tbl_s1` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['address_1'])){
        $sql="UPDATE `tbl_s1` SET `address_1` ='".daddslashes($_POST['address_1'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['address_2'])){
        $sql="UPDATE `tbl_s1` SET `address_2` ='".daddslashes($_POST['address_2'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['contact_mobile'])){
        $sql="UPDATE `tbl_s1` SET `contact_mobile` ='".daddslashes($_POST['contact_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['contact_email'])){
        $sql="UPDATE `tbl_s1` SET `contact_email` ='".daddslashes($_POST['contact_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['student_mobile'])){
        $sql="UPDATE `tbl_s1` SET `student_mobile` ='".daddslashes($_POST['student_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['student_email'])){
        $sql="UPDATE `tbl_s1` SET `student_email` ='".daddslashes($_POST['student_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['foreign_countries'])){
        $sql="UPDATE `tbl_s1` SET `foreign_countries` ='".daddslashes($_POST['foreign_countries'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['attend_school'])){
        $sql="UPDATE `tbl_s1` SET `attend_school` ='".daddslashes($_POST['attend_school'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['study_school'])){
        $sql="UPDATE `tbl_s1` SET `study_school` ='".daddslashes($_POST['study_school'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['english_description'])){
        $sql="UPDATE `tbl_s1` SET `english_description` ='".daddslashes($_POST['english_description'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['expected_training'])){
        $sql="UPDATE `tbl_s1` SET `expected_training` ='".daddslashes($_POST['expected_training'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['recommended_supplier'])){
        $sql="UPDATE `tbl_s1` SET `recommended_supplier` ='".daddslashes($_POST['recommended_supplier'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['payment'])){
        $sql="UPDATE `tbl_s1` SET `payment` ='".daddslashes($_POST['payment'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['vouchers'])){
        $sql="UPDATE `tbl_s1` SET `vouchers` ='".daddslashes($_POST['vouchers'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['server_content'])){
        $sql="UPDATE `tbl_s1` SET `server_content` ='".daddslashes($_POST['server_content'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['money_amount'])){
        $sql="UPDATE `tbl_s1` SET `money_amount` ='".daddslashes($_POST['money_amount'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }


    if(!empty($_POST['pay_time'])){
        $sql="UPDATE `tbl_s1` SET `pay_time` ='".daddslashes($_POST['pay_time'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['interview_time'])){
        $sql="UPDATE `tbl_s1` SET `interview_time` ='".daddslashes($_POST['interview_time'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['Interview_visit'])){
        $sql="UPDATE `tbl_s1` SET `Interview_visit` ='".daddslashes($_POST['Interview_visit'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }

    if(!empty($_POST['exam_remind'])){
        $sql="UPDATE `tbl_s1` SET `exam_remind` ='".daddslashes($_POST['exam_remind'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }


    if(!empty($_POST['out_date'])){
        $sql="UPDATE `tbl_s1` SET `out_date` ='".daddslashes($_POST['out_date'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }


    if(!empty($_POST['reciprocal_satisfaction'])){
        $sql="UPDATE `tbl_s1` SET `reciprocal_satisfaction` ='".daddslashes($_POST['reciprocal_satisfaction'])."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
    }
    $sql="UPDATE `tbl_s1` SET `is_delete` ='0'  WHERE `s_id` ='".$edu_server_id."' ";
    $_SC['db']->query($sql);

    $sql="UPDATE `tbl_s1` SET `is_complete` ='".$_POST['is_complete']."'  WHERE `s_id` ='".$edu_server_id."' ";
    $_SC['db']->query($sql);

    $sql="UPDATE `tbl_s1` SET `pay_status` ='".$_POST['pay_status']."'  WHERE `s_id` ='".$edu_server_id."' ";
    $_SC['db']->query($sql);

    $sql="UPDATE `tbl_server_member` SET `is_delete` ='0'  WHERE edu_class_id='".$tbl_s_id."' and edu_s_id='".$edu_server_id."'";
    $_SC['db']->query($sql);

    echo "<script>alert('提示:成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id=1'</script>";

}


}

function update_s2($member_id,$edu_server_id){
    global $_SC;
    get_header();
    get_left_menu();
    $tbl_s_id="2";
    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
    if($edu_server_info['is_complete']==0){
        $selected_a="selected";
    }else{
        $selected_b="selected";
    }

    if($edu_server_info['pay_status']==0){
        $selected_pay_a="selected";
    }else{
        $selected_pay_b="selected";
    }


    $member_info=member_info($member_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=edu&member_id={$member_id}"><i class="icon-dashboard"></i>教育服务记录 </a></li>
              <li class="active"><i class="icon-edit"></i><a href="index.php?do=edu&member_id={$member_id}&class=2">{$member_info['name']}申请学校服务列表</a></li>
              <li class="active"><i class="icon-edit"></i>{$edu_server_info['server_name']}详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#basic_info" data-toggle="tab">基本信息</a></li>
                <li><a href="#server_need" data-toggle="tab">服务需求</a></li>
                <li><a href="#pay_info" data-toggle="tab">支付信息</a></li>
                <li><a href="#server_status" data-toggle="tab">服务状态</a></li>
                <li><a href="#visit" data-toggle="tab">回访情况</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <!--基本信息--start-->
                <div class="tab-pane fade active in" id="basic_info">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务名称</label>
                                                    <input class="form-control" value="{$edu_server_info['server_name']}" name="server_name">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_name']}" name="contact_name">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">留学生姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['student_name']}" name="student_name">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人电话</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_mobile']}" name="contact_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人邮箱</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_email']}" name="contact_email">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">留学生电话</label>
                                                    <input class="form-control" value="{$edu_server_info['student_mobile']}" name="student_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">留学生邮箱</label>
                                                    <input class="form-control" value="{$edu_server_info['student_email']}" name="student_email">
                                                  </div>
                                                </div>



                </div>
                <!--基本信息--end-->
                <!--服务需求--start-->
                <div class="tab-pane fade" id="server_need">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">留学国家</label>
                                                    <input class="form-control" value="{$edu_server_info['foreign_countries']}" name="foreign_countries">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">现就读学校</label>
                                                    <input class="form-control" value="{$edu_server_info['attend_school']}" name="attend_school">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">留学学校</label>
                                                    <input class="form-control" value="{$edu_server_info['study_school']}" name="study_school">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">英语水平描述</label>
                                                    <input class="form-control" value="{$edu_server_info['english_description']}" name="english_description">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">期望服务提供地</label>
                                                    <input class="form-control" value="{$edu_server_info['expected_training']}" name="expected_training">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">推荐供应商</label>
                                                    <input class="form-control" value="{$edu_server_info['recommended_supplier']}" name="recommended_supplier">
                                                  </div>
                                                </div>

                </div>
                <!--服务需求--end-->
                <!--支付信息--start-->
               <div class="tab-pane fade" id="pay_info">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">支付方式</label>
                                                    <input class="form-control" value="{$edu_server_info['payment']}" name="payment">
                                                  </div>
                                                </div>



                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务内容</label>
                                                    <input class="form-control" value="{$edu_server_info['server_content']}" name="server_content">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">金额</label>
                                                    <input class="form-control" value="{$edu_server_info['money_amount']}" name="money_amount">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">支付状态</label>
                                                    <select class="form-control" name="pay_status">
                                                        <option value="0" {$selected_pay_a}>未付</option>
                                                        <option value="1" {$selected_pay_b}>已付</option>
                                                    </select>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">抵用卷</label>
                                                    <input class="form-control" value="{$edu_server_info['vouchers']}" name="vouchers">
                                                  </div>
                                                </div>



                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">支付时间</label>
                                                    <input class="form-control" value="{$edu_server_info['pay_time']}" name="pay_time" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                                                  </div>
                                                </div>

                </div>
            <!--支付信息--end-->
            <!--服务状态--start-->
               <div class="tab-pane fade" id="server_status">
                                                 <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">面试时间</label>
                                                    <input class="form-control" value="{$edu_server_info['interview_time']}" name="interview_time" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                                                  </div>
                                                </div>



                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">面试回访</label>
                                                    <input class="form-control" value="{$edu_server_info['Interview_visit']}" name="Interview_visit">
                                                  </div>
                                                </div>



                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">考试提醒</label>
                                                    <input class="form-control" value="{$edu_server_info['exam_remind']}" name="exam_remind">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">出分日期</label>
                                                    <input class="form-control" value="{$edu_server_info['out_date']}" name="out_date" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                                                  </div>
                                                </div>


                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">完成状态</label>
                                                    <select class="form-control" name="is_complete">
                                                      <option value="0" {$selected_a}>未完成</option>
                                                      <option value="1" {$selected_b}>已完成</option>
                                                    </select>
                                                  </div>


                </div>
        <!--服务状态--end-->
        <!--回访情况--start-->
               <div class="tab-pane fade" id="visit">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">满意度回访</label>
                                                    <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction']}" name="reciprocal_satisfaction">
                                                  </div>
                                                </div>
                       </div>
        <!--回访情况--end-->

              </div>
            </div>
            <div class="form-group">
                      <button type="submit" class="btn btn-default" name="update_edu_server">提 交</button>
                      <a href="index.php?do=edu&member_id={$member_id}" class="btn btn-default">取 消</a>
                      </div>
                  </form>
                </div>
            </div>
        </div>
html;
    call_module($edu_server_id,$tbl_s_id,$member_id);
    if(isset($_POST['update_edu_server'])){

        if(!empty($_POST['server_name'])){
            $sql="UPDATE `tbl_s2` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_name'])){
            $sql="UPDATE `tbl_s2` SET `contact_name` ='".daddslashes($_POST['contact_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['student_name'])){
            $sql="UPDATE `tbl_s2` SET `student_name` ='".daddslashes($_POST['student_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['server_name'])){
            $sql="UPDATE `tbl_s2` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['contact_mobile'])){
            $sql="UPDATE `tbl_s2` SET `contact_mobile` ='".daddslashes($_POST['contact_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_email'])){
            $sql="UPDATE `tbl_s2` SET `contact_email` ='".daddslashes($_POST['contact_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['student_mobile'])){
            $sql="UPDATE `tbl_s2` SET `student_mobile` ='".daddslashes($_POST['student_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['student_email'])){
            $sql="UPDATE `tbl_s2` SET `student_email` ='".daddslashes($_POST['student_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['foreign_countries'])){
            $sql="UPDATE `tbl_s2` SET `foreign_countries` ='".daddslashes($_POST['foreign_countries'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['attend_school'])){
            $sql="UPDATE `tbl_s2` SET `attend_school` ='".daddslashes($_POST['attend_school'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['study_school'])){
            $sql="UPDATE `tbl_s2` SET `study_school` ='".daddslashes($_POST['study_school'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['english_description'])){
            $sql="UPDATE `tbl_s2` SET `english_description` ='".daddslashes($_POST['english_description'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['expected_training'])){
            $sql="UPDATE `tbl_s2` SET `expected_training` ='".daddslashes($_POST['expected_training'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['recommended_supplier'])){
            $sql="UPDATE `tbl_s2` SET `recommended_supplier` ='".daddslashes($_POST['recommended_supplier'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['payment'])){
            $sql="UPDATE `tbl_s2` SET `payment` ='".daddslashes($_POST['payment'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['server_content'])){
            $sql="UPDATE `tbl_s2` SET `server_content` ='".daddslashes($_POST['server_content'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['money_amount'])){
            $sql="UPDATE `tbl_s2` SET `money_amount` ='".daddslashes($_POST['money_amount'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['pay_time'])){
            $sql="UPDATE `tbl_s2` SET `pay_time` ='".daddslashes($_POST['pay_time'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['vouchers'])){
            $sql="UPDATE `tbl_s2` SET `vouchers` ='".daddslashes($_POST['vouchers'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['interview_time'])){
            $sql="UPDATE `tbl_s2` SET `interview_time` ='".daddslashes($_POST['interview_time'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['Interview_visit'])){
            $sql="UPDATE `tbl_s2` SET `Interview_visit` ='".daddslashes($_POST['Interview_visit'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['exam_remind'])){
            $sql="UPDATE `tbl_s2` SET `exam_remind` ='".daddslashes($_POST['exam_remind'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['out_date'])){
            $sql="UPDATE `tbl_s2` SET `out_date` ='".daddslashes($_POST['out_date'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['reciprocal_satisfaction'])){
            $sql="UPDATE `tbl_s2` SET `reciprocal_satisfaction` ='".daddslashes($_POST['reciprocal_satisfaction'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }
        $sql="UPDATE `tbl_s2` SET `is_delete` ='0'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s2` SET `is_complete` ='".$_POST['is_complete']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s2` SET `pay_status` ='".$_POST['pay_status']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_server_member` SET `is_delete` ='0'  WHERE edu_class_id='".$tbl_s_id."' and edu_s_id='".$edu_server_id."'";
        $_SC['db']->query($sql);

        echo "<script>alert('提示:成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id=2'</script>";
    }


}

function update_s3($member_id,$edu_server_id){
    global $_SC;
    get_header();
    get_left_menu();
    $tbl_s_id="3";
    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
    for ($i=1; $i<=9; $i++)
    {
            if(is_message($edu_server_id,$tbl_s_id,$i)){
               eval('$button_'.$i."='已发送';");
        }else{
               eval('$button_'.$i."='发送短信';");
            }
    }


    if($edu_server_info['is_complete']==0){
        $selected_a="selected";
    }else{
        $selected_b="selected";
    }
    if($edu_server_info['pay_status']==0){
        $selected_pay_a="selected";
    }else{
        $selected_pay_b="selected";
    }
    $member_info=member_info($member_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=edu&member_id={$member_id}"><i class="icon-dashboard"></i>教育服务记录 </a></li>
              <li class="active"><i class="icon-edit"></i><a href="index.php?do=edu&member_id={$member_id}&class=3">{$member_info['name']}海外机场接送服务列表</a></li>
              <li class="active"><i class="icon-edit"></i>{$edu_server_info['server_name']}详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#basic_info" data-toggle="tab">基本信息</a></li>
                <li><a href="#server_need" data-toggle="tab">服务需求</a></li>
                <li><a href="#pay_info" data-toggle="tab">支付信息</a></li>
                <li><a href="#server_status" data-toggle="tab">服务状态</a></li>
                <li><a href="#visit" data-toggle="tab">回访情况</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <!--基本信息--start-->
                <div class="tab-pane fade active in" id="basic_info">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务名称</label>
                                                    <input class="form-control" value="{$edu_server_info['server_name']}" name="server_name">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">接机联系人</label>
                                                    <input class="form-control" value="{$edu_server_info['meeting_name']}" name="meeting_name">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">接机联系人护照号</label>
                                                    <input class="form-control" value="{$edu_server_info['meeting_p_number']}" name="meeting_p_number">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">接机人手机</label>
                                                    <input class="form-control" value="{$edu_server_info['metting_mobile']}" name="metting_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">接机人Email</label>
                                                    <input class="form-control" value="{$edu_server_info['metting_email']}" name="metting_email">
                                                  </div>
                                                </div>

                </div>
                <!--基本信息--end-->
                <!--服务需求--start-->
                <div class="tab-pane fade" id="server_need">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">航班号</label>
                                                    <input class="form-control" value="{$edu_server_info['flight_number']}" name="flight_number">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">出发中国时间</label>
                                                    <input class="form-control" value="{$edu_server_info['go_time_china']}" name="go_time_china" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">出发当地时间</label>
                                                    <input class="form-control" value="{$edu_server_info['go_time_local']}" name="go_time_local" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">落地中国时间</label>
                                                    <input class="form-control" value="{$edu_server_info['arrival_time_china']}" name="arrival_time_china" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">落地当地时间</label>
                                                    <input class="form-control" value="{$edu_server_info['arrival_time_local']}" name="arrival_time_local" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">出发地</label>
                                                    <input class="form-control" value="{$edu_server_info['departure']}" name="departure">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">目的地</label>
                                                    <input class="form-control" value="{$edu_server_info['destination']}" name="destination">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">人数</label>
                                                    <input class="form-control" value="{$edu_server_info['people_number']}" name="people_number">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">行李数</label>
                                                    <input class="form-control" value="{$edu_server_info['amount_baggage']}" name="amount_baggage">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">备注说明</label>
                                                    <input class="form-control" value="{$edu_server_info['remarks']}" name="remarks">
                                                  </div>
                                                </div>
                </div>
                <!--服务需求--end-->
                <!--支付信息--start-->
               <div class="tab-pane fade" id="pay_info">



                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">支付方式</label>
                                                    <input class="form-control" value="{$edu_server_info['payment']}" name="payment">
                                                  </div>
                                                </div>



                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务内容</label>
                                                    <input class="form-control" value="{$edu_server_info['server_content']}" name="server_content">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">金额</label>
                                                    <input class="form-control" value="{$edu_server_info['money_amount']}" name="money_amount">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">支付状态</label>
                                                    <select class="form-control" name="pay_status">
                                                        <option value="0" {$selected_pay_a}>未付</option>
                                                        <option value="1" {$selected_pay_b}>已付</option>
                                                    </select>
                                                </div>






                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">支付时间</label>
                                                    <input class="form-control" value="{$edu_server_info['pay_time']}" name="pay_time" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <div class="row"><div class="col-lg-4" for="inputSuccess"><label class="control-label" for="inputSuccess">抵用卷</label></div>
                                                    <div class=" col-lg-4"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},3,9)">{$button_9}</a></div>
                                                    </div>
                                                  </div>
                                                </div>

                </div>
            <!--支付信息--end-->
            <!--服务状态--start-->
               <div class="tab-pane fade" id="server_status">
                                                 <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">车型</label>
                                                    <input class="form-control" value="{$edu_server_info['models']}" name="models">
                                                  </div>
                                                </div>



                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">牌照</label>
                                                    <input class="form-control" value="{$edu_server_info['licence']}" name="licence">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">司机姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['driver_name']}" name="driver_name">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">司机联系方式</label>
                                                    <input class="form-control" value="{$edu_server_info['driver_information']}" name="driver_information">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">机场待接时间</label>
                                                    <input class="form-control" value="{$edu_server_info['waiting_time']}" name="waiting_time">
                                                  </div>
                                                </div>






                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">完成状态</label>
                                                    <select class="form-control" name="is_complete">
                                                      <option value="0" {$selected_a}>未完成</option>
                                                      <option value="1" {$selected_b}>已完成</option>
                                                    </select>
                                                  </div>



                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <div class="row"><div class="col-lg-4" for="inputSuccess"><label class="control-label" for="inputSuccess">预定成功(接机/送机)</label></div>
                                                    <div class=" col-lg-4"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},3,1)"><div id="i_1">{$button_1}</div></a></div>
                                                    <div class=" col-lg-4"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},3,5)"><div id="i_5">{$button_5}</div></a></div>
                                                    </div>
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <div class="row"><div class="col-lg-4" for="inputSuccess"><label class="control-label" for="inputSuccess">服务信息(接机/送机)</label></div>
                                                    <div class=" col-lg-4"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},3,2)"><div id="i_2">{$button_2}</div></a></div>
                                                    <div class=" col-lg-4"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},3,6)"><div id="i_6">{$button_6}</div></a></div>
                                                    </div>
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <div class="row"><div class="col-lg-4" for="inputSuccess"><label class="control-label" for="inputSuccess">成功接到联系人(接机/送机)</label></div>
                                                    <div class=" col-lg-4"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},3,3)"><div id="i_3">{$button_3}</div></a></div>
                                                    <div class=" col-lg-4"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},3,7)"><div id="i_7">{$button_7}</div></a></div>
                                                    </div>
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <div class="row"><div class="col-lg-4" for="inputSuccess"><label l class="control-label" for="inputSuccess">安全抵达(接机/送机)</label></div>
                                                    <div class=" col-lg-4"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},3,4)"><div id="i_4">{$button_4}</div></a></div>
                                                    <div class=" col-lg-4"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},3,8)"><div id="i_8">{$button_8}</div></a></div>
                                                    </div>
                                                  </div>
                                                </div>

                </div>
        <!--服务状态--end-->
            <!--服务状态--start-->
               <div class="tab-pane fade" id="visit">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">回访</label>
                                                    <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction']}" name="reciprocal_satisfaction">
                                                  </div>
                                                </div>
                       </div>
            <!--服务状态--end-->
              </div>
            </div>
            <div class="form-group">
                      <button type="submit" class="btn btn-default" name="update_edu_server">提 交</button>
                      <a href="index.php?do=edu&member_id={$member_id}" class="btn btn-default">取 消</a>
                      </div>
                  </form>
                </div>
            </div>

        </div>
html;
    call_module($edu_server_id,$tbl_s_id,$member_id);
    message_module($edu_server_id,$tbl_s_id);

    if(isset($_POST['update_edu_server'])){

        if(!empty($_POST['server_name'])){
            $sql="UPDATE `tbl_s3` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['meeting_name'])){
            $sql="UPDATE `tbl_s3` SET `meeting_name` ='".daddslashes($_POST['meeting_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['meeting_p_number'])){
            $sql="UPDATE `tbl_s3` SET `meeting_p_number` ='".daddslashes($_POST['meeting_p_number'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['metting_mobile'])){
            $sql="UPDATE `tbl_s3` SET `metting_mobile` ='".daddslashes($_POST['metting_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['metting_email'])){
            $sql="UPDATE `tbl_s3` SET `metting_email` ='".daddslashes($_POST['metting_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['flight_number'])){
            $sql="UPDATE `tbl_s3` SET `flight_number` ='".daddslashes($_POST['flight_number'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['go_time_china'])){
            $sql="UPDATE `tbl_s3` SET `go_time_china` ='".daddslashes($_POST['go_time_china'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['go_time_local'])){
            $sql="UPDATE `tbl_s3` SET `go_time_local` ='".daddslashes($_POST['go_time_local'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['arrival_time_china'])){
            $sql="UPDATE `tbl_s3` SET `arrival_time_china` ='".daddslashes($_POST['arrival_time_china'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['arrival_time_local'])){
            $sql="UPDATE `tbl_s3` SET `arrival_time_local` ='".daddslashes($_POST['arrival_time_local'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['departure'])){
            $sql="UPDATE `tbl_s3` SET `departure` ='".daddslashes($_POST['departure'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['destination'])){
            $sql="UPDATE `tbl_s3` SET `destination` ='".daddslashes($_POST['destination'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['people_number'])){
            $sql="UPDATE `tbl_s3` SET `people_number` ='".daddslashes($_POST['people_number'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['amount_baggage'])){
            $sql="UPDATE `tbl_s3` SET `amount_baggage` ='".daddslashes($_POST['amount_baggage'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['remarks'])){
            $sql="UPDATE `tbl_s3` SET `remarks` ='".daddslashes($_POST['remarks'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['server_content'])){
            $sql="UPDATE `tbl_s3` SET `server_content` ='".daddslashes($_POST['server_content'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['payment'])){
            $sql="UPDATE `tbl_s3` SET `payment` ='".daddslashes($_POST['payment'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['money_amount'])){
            $sql="UPDATE `tbl_s3` SET `money_amount` ='".daddslashes($_POST['money_amount'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['vouchers'])){
            $sql="UPDATE `tbl_s3` SET `vouchers` ='".daddslashes($_POST['vouchers'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['models'])){
            $sql="UPDATE `tbl_s3` SET `models` ='".daddslashes($_POST['models'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['licence'])){
            $sql="UPDATE `tbl_s3` SET `licence` ='".daddslashes($_POST['licence'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['driver_name'])){
            $sql="UPDATE `tbl_s3` SET `driver_name` ='".daddslashes($_POST['driver_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['driver_information'])){
            $sql="UPDATE `tbl_s3` SET `driver_information` ='".daddslashes($_POST['driver_information'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['waiting_time'])){
            $sql="UPDATE `tbl_s3` SET `waiting_time` ='".daddslashes($_POST['waiting_time'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['reciprocal_satisfaction'])){
            $sql="UPDATE `tbl_s3` SET `reciprocal_satisfaction` ='".daddslashes($_POST['reciprocal_satisfaction'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        $sql="UPDATE `tbl_s3` SET `is_delete` ='0'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s3` SET `is_complete` ='".$_POST['is_complete']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s3` SET `pay_status` ='".$_POST['pay_status']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_server_member` SET `is_delete` ='0'  WHERE edu_class_id='".$tbl_s_id."' and edu_s_id='".$edu_server_id."'";
        $_SC['db']->query($sql);

        echo "<script>alert('提示:成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id=3'</script>";
    }
}

function update_s4($member_id,$edu_server_id){
    global $_SC;
    get_header();
    get_left_menu();
    $tbl_s_id="4";
    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);

    for ($i=10; $i<=11; $i++)
    {
        if(is_message($edu_server_id,$tbl_s_id,$i)){
            eval('$button_'.$i."='已发送';");
        }else{
            eval('$button_'.$i."='发送短信';");
        }
    }
    if($edu_server_info['is_complete']==0){
        $selected_a="selected";
    }else{
        $selected_b="selected";
    }
    if($edu_server_info['pay_status']==0){
        $selected_pay_a="selected";
    }else{
        $selected_pay_b="selected";
    }
    $member_info=member_info($member_id);
    $arr_tmp=explode(",",$edu_server_info['vip_service']);
    foreach($arr_tmp as $v){
        if($v=="VIP休息室"){
            $checked_service_1="checked";
        }
        if($v=="专人陪同办理乘机手续"){
            $checked_service_2="checked";
        }
    }
    echo <<<html
    <div id="page-wrapper">
          <ol class="breadcrumb">
              <li><a href="index.php?do=edu&member_id={$member_id}"><i class="icon-dashboard"></i>教育服务记录 </a></li>
              <li class="active"><i class="icon-edit"></i><a href="index.php?do=edu&member_id={$member_id}&class=4">{$member_info['name']}海外机场礼遇服务列表</a></li>
              <li class="active"><i class="icon-edit"></i>{$edu_server_info['server_name']}详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#basic_info" data-toggle="tab">基本信息</a></li>
                <li><a href="#server_need" data-toggle="tab">服务需求</a></li>
                <li><a href="#pay_info" data-toggle="tab">支付信息</a></li>
                <li><a href="#server_status" data-toggle="tab">服务状态</a></li>
                <li><a href="#visit" data-toggle="tab">回访情况</a></li>
              </ul>


               <div id="myTabContent" class="tab-content">

                <!--基本信息--start-->
                                <div class="tab-pane fade active in" id="basic_info">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务名称</label>
                                                    <input class="form-control" value="{$edu_server_info['server_name']}" name="server_name">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_name']}" name="contact_name">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人护照号码</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_p_number']}" name="contact_p_number">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人手机</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_mobile']}" name="contact_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人email</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_email']}" name="contact_email">
                                                  </div>
                                                </div>

                </div>
                <!--基本信息--end-->
                <!--服务需求--start-->
                <div class="tab-pane fade" id="server_need">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">航班号</label>
                                                    <input class="form-control" value="{$edu_server_info['flight_number']}" name="flight_number">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">出发中国时间</label>
                                                    <input class="form-control" value="{$edu_server_info['go_time_china']}" name="go_time_china" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">出发当地时间</label>
                                                    <input class="form-control" value="{$edu_server_info['go_time_local']}" name="go_time_local" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">落地中国时间</label>
                                                    <input class="form-control" value="{$edu_server_info['arrival_time_china']}" name="arrival_time_china" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">落地当地时间</label>
                                                    <input class="form-control" value="{$edu_server_info['arrival_time_local']}" name="arrival_time_local" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">出发地</label>
                                                    <input class="form-control" value="{$edu_server_info['departure']}" name="departure">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">目的地</label>
                                                    <input class="form-control" value="{$edu_server_info['destination']}" name="destination">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">人数</label>
                                                    <input class="form-control" value="{$edu_server_info['people_number']}" name="people_number">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">行李数</label>
                                                    <input class="form-control" value="{$edu_server_info['amount_baggage']}" name="amount_baggage">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务说明</label>（请按“20xx年xx月xx日xxxx机场”的样式填写）
                                                    <input class="form-control" value="{$edu_server_info['remarks']}" name="remarks">
                                                  </div>
                                                </div>



                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">贵宾服务</label>
                                                    <checkbox name="demo" value="" onpropertychange="show()" >
                                                    <label class="checkbox-inline">
                                                      <input type="checkbox" name="vip_service[]" id="optionsRadiosInline1" value="VIP休息室" onclick="show()" {$checked_service_1}> VIP休息室
                                                    </label>
                                                    <label class="checkbox-inline">
                                                      <input type="checkbox" name="vip_service[]" id="optionsRadiosInline2" value="专人陪同办理乘机手续" onclick="show()" {$checked_service_2} > 专人陪同办理乘机手续
                                                    </label>
                                                    </checkbox>
                                                  </div>


                </div>
                <!--服务需求--end-->
                <!--支付信息--start-->
               <div class="tab-pane fade" id="pay_info">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">支付方式</label>
                                                    <input class="form-control" value="{$edu_server_info['payment']}" name="payment">
                                                  </div>
                                                </div>



                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">金额</label>
                                                    <input class="form-control" value="{$edu_server_info['money_amount']}" name="money_amount">
                                                  </div>
                                                </div>



                                                <div class="form-group has-success">
                                                        <label class="control-label" for="inputSuccess">支付状态</label>
                                                        <select class="form-control" name="pay_status">
                                                            <option value="0" {$selected_pay_a}>未付</option>
                                                            <option value="1" {$selected_pay_b}>已付</option>
                                                        </select>
                                                    </div>

                </div>
            <!--支付信息--end-->
             <!--服务状态--start-->
               <div class="tab-pane fade" id="server_status">





                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">礼宾联系方式</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_concierge']}" name="contact_concierge">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">预约时间</label>
                                                    <input class="form-control" value="{$edu_server_info['time_control']}" name="time_control">
                                                  </div>
                                                </div>


                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">完成状态</label>
                                                    <select class="form-control" name="is_complete">
                                                      <option value="0" {$selected_a}>未完成</option>
                                                      <option value="1" {$selected_b}>已完成</option>
                                                    </select>
                                                  </div>


                                          <div id="checkbox_1" style="display: none">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <div class="row"><div class="col-lg-4" for="inputSuccess"><label class="control-label" for="inputSuccess">VIP休息室</label></div>
                                                    <div class=" col-lg-8"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},4,10)">{$button_10}</a></div>
                                                    </div>
                                                </div>
                                              </div>
                                            </div>



                                          <div id="checkbox_2" style="display: none">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <div class="row"><div class="col-lg-4" for="inputSuccess"><label class="control-label" for="inputSuccess">专人陪同办理乘机手续</label></div>
                                                    <div class=" col-lg-8"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},4,11)">{$button_11}</a></div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>


                </div>
        <!--服务状态--end-->
       <!--回访情况--start-->
               <div class="tab-pane fade" id="visit">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">满意度回访</label>
                                                    <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction']}" name="reciprocal_satisfaction">
                                                  </div>
                                                </div>
               </div>
        <!--回访情况--end-->
                </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-default" name="update_edu_server">提 交</button>
                      <a href="index.php?do=edu&member_id={$member_id}" class="btn btn-default">取 消</a>
                      </div>
                  </form>
               </div>
             </div>
            </div>
html;
    call_module($edu_server_id,$tbl_s_id,$member_id);
    message_module($edu_server_id,$tbl_s_id);


    if(isset($_POST['update_edu_server'])){
        $payment=implode(",",$_POST['vip_service']);
        $sql="UPDATE `tbl_s4` SET `vip_service` ='".$payment."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);
        if(!empty($_POST['vip_lounge'])){
            $sql="UPDATE `tbl_s4` SET `vip_lounge` ='".daddslashes($_POST['vip_lounge'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['accompanied'])){
            $sql="UPDATE `tbl_s4` SET `accompanied` ='".daddslashes($_POST['accompanied'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['server_name'])){
            $sql="UPDATE `tbl_s4` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_name'])){
            $sql="UPDATE `tbl_s4` SET `contact_name` ='".daddslashes($_POST['contact_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_p_number'])){
            $sql="UPDATE `tbl_s4` SET `contact_p_number` ='".daddslashes($_POST['contact_p_number'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_mobile'])){
            $sql="UPDATE `tbl_s4` SET `contact_mobile` ='".daddslashes($_POST['contact_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_email'])){
            $sql="UPDATE `tbl_s4` SET `contact_email` ='".daddslashes($_POST['contact_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['flight_number'])){
            $sql="UPDATE `tbl_s4` SET `flight_number` ='".daddslashes($_POST['flight_number'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['go_time_china'])){
            $sql="UPDATE `tbl_s4` SET `go_time_china` ='".daddslashes($_POST['go_time_china'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['go_time_local'])){
            $sql="UPDATE `tbl_s4` SET `go_time_local` ='".daddslashes($_POST['go_time_local'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['arrival_time_china'])){
            $sql="UPDATE `tbl_s4` SET `arrival_time_china` ='".daddslashes($_POST['arrival_time_china'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['arrival_time_local'])){
            $sql="UPDATE `tbl_s4` SET `arrival_time_local` ='".daddslashes($_POST['arrival_time_local'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['departure'])){
            $sql="UPDATE `tbl_s4` SET `departure` ='".daddslashes($_POST['departure'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['destination'])){
            $sql="UPDATE `tbl_s4` SET `destination` ='".daddslashes($_POST['destination'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['people_number'])){
            $sql="UPDATE `tbl_s4` SET `people_number` ='".daddslashes($_POST['people_number'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['amount_baggage'])){
            $sql="UPDATE `tbl_s4` SET `amount_baggage` ='".daddslashes($_POST['amount_baggage'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['remarks'])){
            $sql="UPDATE `tbl_s4` SET `remarks` ='".daddslashes($_POST['remarks'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['payment'])){
            $sql="UPDATE `tbl_s4` SET `payment` ='".daddslashes($_POST['payment'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['money_amount'])){
            $sql="UPDATE `tbl_s4` SET `money_amount` ='".daddslashes($_POST['money_amount'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['contact_concierge'])){
            $sql="UPDATE `tbl_s4` SET `contact_concierge` ='".daddslashes($_POST['contact_concierge'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['time_control'])){
            $sql="UPDATE `tbl_s4` SET `time_control` ='".daddslashes($_POST['time_control'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['reciprocal_satisfaction'])){
            $sql="UPDATE `tbl_s4` SET `reciprocal_satisfaction` ='".daddslashes($_POST['reciprocal_satisfaction'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        $sql="UPDATE `tbl_s4` SET `is_delete` ='0'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s4` SET `is_complete` ='".$_POST['is_complete']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s4` SET `pay_status` ='".$_POST['pay_status']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_server_member` SET `is_delete` ='0'  WHERE edu_class_id='".$tbl_s_id."' and edu_s_id='".$edu_server_id."'";
        $_SC['db']->query($sql);


        echo "<script>alert('提示:成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id=4'</script>";
    }

}

function update_s5($member_id,$edu_server_id){
    global $_SC;
    get_header();
    get_left_menu();
    $tbl_s_id="5";
    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
    for ($i=12; $i<=13; $i++)
    {
        if(is_message($edu_server_id,$tbl_s_id,$i)){
            eval('$button_'.$i."='已发送';");
        }else{
            eval('$button_'.$i."='发送短信';");
        }
    }
    if($edu_server_info['is_complete']==0){
        $selected_a="selected";
    }else{
        $selected_b="selected";
    }
    if($edu_server_info['pay_status']==0){
        $selected_pay_a="selected";
    }else{
        $selected_pay_b="selected";
    }


    $member_info=member_info($member_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=edu&member_id={$member_id}"><i class="icon-dashboard"></i>教育服务记录 </a></li>
               <li class="active"><i class="icon-edit"></i><a href="index.php?do=edu&member_id={$member_id}&class=5">{$member_info['name']}行李遗失服务列表</a></li>
              <li class="active"><i class="icon-edit"></i>{$edu_server_info['server_name']}详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#basic_info" data-toggle="tab">基本信息</a></li>
                <li><a href="#server_need" data-toggle="tab">服务需求</a></li>
                <li><a href="#pay_info" data-toggle="tab">支付信息</a></li>
                <li><a href="#server_status" data-toggle="tab">服务状态</a></li>
                <li><a href="#visit" data-toggle="tab">回访情况</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <!--基本信息--start-->
                <div class="tab-pane fade active in" id="basic_info">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务名称</label>
                                                    <input class="form-control" value="{$edu_server_info['server_name']}" name="server_name">
                                                  </div>
                                                </div>

                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_name']}" name="contact_name">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人电话</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_mobile']}" name="contact_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人邮箱</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_email']}" name="contact_email">
                                                  </div>
                                                </div>




                </div>
                <!--基本信息--end-->
                <!--服务需求--start-->
                <div class="tab-pane fade" id="server_need">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">航班号</label>
                                                    <input class="form-control" value="{$edu_server_info['flight_number']}" name="flight_number">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">所在机场</label>
                                                    <input class="form-control" value="{$edu_server_info['service_location']}" name="service_location">
                                                  </div>
                                                </div>




                </div>
                <!--服务需求--end-->

                <!--支付信息--start-->
                <div class="tab-pane fade" id="pay_info">

                                            <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">金额</label>
                                                    <input class="form-control" value="{$edu_server_info['money_amount']}" name="money_amount">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">支付方式</label>
                                                    <input class="form-control" value="{$edu_server_info['payment']}" name="payment">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">支付状态</label>
                                                    <select class="form-control" name="pay_status">
                                                        <option value="0" {$selected_pay_a}>未付</option>
                                                        <option value="1" {$selected_pay_b}>已付</option>
                                                    </select>
                                                </div>




                </div>
                <!--支付信息--end-->

            <!--服务状态--start-->





               <div class="tab-pane fade" id="server_status">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">礼宾人员联系方式</label>
                                                    <input class="form-control" value="{$edu_server_info['concierge_name']}" name="concierge_name">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">礼宾人员联系方式</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_concierge']}" name="contact_concierge">
                                                  </div>
                                                </div>




                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">遗失处理日期</label>
                                                    <input class="form-control" value="{$edu_server_info['processing_date']}" name="processing_date">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">最终处理结果</label>
                                                    <input class="form-control" value="{$edu_server_info['result']}" name="result">
                                                  </div>
                                                </div>



                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">完成状态</label>
                                                    <select class="form-control" name="is_complete">
                                                      <option value="0" {$selected_a}>未完成</option>
                                                      <option value="1" {$selected_b}>已完成</option>
                                                    </select>
                                                  </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <div class="row"><div class="col-lg-4" for="inputSuccess"><label class="control-label" for="inputSuccess">预定成功</label></div>
                                                    <div class=" col-lg-8"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},5,12)">{$button_12}</a></div>
                                                    </div>
                                                  </div>
                                                </div>



                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <div class="row"><div class="col-lg-4" for="inputSuccess"><label class="control-label" for="inputSuccess">行李跟进</label></div>
                                                    <div class=" col-lg-8"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},5,13)">{$button_13}</a></div>
                                                    </div>
                                                  </div>
                                                </div>




                </div>
        <!--服务状态--end-->

            <!--回访情况--start-->
               <div class="tab-pane fade" id="visit">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">满意度回访</label>
                                                    <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction']}" name="reciprocal_satisfaction">
                                                  </div>
                                                </div>
                </div>
        <!--回访情况--end-->

              </div>
            </div>
            <div class="form-group">
                      <button type="submit" class="btn btn-default" name="update_edu_server">提 交</button>
                      <a href="index.php?do=edu&member_id={$member_id}" class="btn btn-default">取 消</a>
                      </div>
                  </form>
                </div>
            </div>
        </div>

html;
    call_module($edu_server_id,$tbl_s_id,$member_id);
    message_module($edu_server_id,$tbl_s_id);
    if(isset($_POST['update_edu_server'])){

        if(!empty($_POST['server_name'])){
            $sql="UPDATE `tbl_s5` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_name'])){
            $sql="UPDATE `tbl_s5` SET `contact_name` ='".daddslashes($_POST['contact_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_mobile'])){
            $sql="UPDATE `tbl_s5` SET `contact_mobile` ='".daddslashes($_POST['contact_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_email'])){
            $sql="UPDATE `tbl_s5` SET `contact_email` ='".daddslashes($_POST['contact_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['flight_number'])){
            $sql="UPDATE `tbl_s5` SET `flight_number` ='".daddslashes($_POST['flight_number'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['service_location'])){
            $sql="UPDATE `tbl_s5` SET `service_location` ='".daddslashes($_POST['service_location'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['money_amount'])){
            $sql="UPDATE `tbl_s5` SET `money_amount` ='".daddslashes($_POST['money_amount'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }



        if(!empty($_POST['pay_status'])){
            $sql="UPDATE `tbl_s5` SET `pay_status` ='".daddslashes($_POST['pay_status'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }




        if(!empty($_POST['payment'])){
            $sql="UPDATE `tbl_s5` SET `payment` ='".daddslashes($_POST['payment'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['concierge_name'])){
            $sql="UPDATE `tbl_s5` SET `concierge_name` ='".daddslashes($_POST['concierge_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_concierge'])){
            $sql="UPDATE `tbl_s5` SET `contact_concierge` ='".daddslashes($_POST['contact_concierge'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['follow_up'])){
            $sql="UPDATE `tbl_s5` SET `follow_up` ='".daddslashes($_POST['follow_up'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['processing_date'])){
            $sql="UPDATE `tbl_s5` SET `processing_date` ='".daddslashes($_POST['processing_date'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['result'])){
            $sql="UPDATE `tbl_s5` SET `result` ='".daddslashes($_POST['result'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['reciprocal_satisfaction'])){
            $sql="UPDATE `tbl_s5` SET `reciprocal_satisfaction` ='".daddslashes($_POST['reciprocal_satisfaction'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }
        $sql="UPDATE `tbl_s5` SET `is_delete` ='0'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s5` SET `is_complete` ='".$_POST['is_complete']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_server_member` SET `is_delete` ='0'  WHERE edu_class_id='".$tbl_s_id."' and edu_s_id='".$edu_server_id."'";
        $_SC['db']->query($sql);



        echo "<script>alert('提示:成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id={$tbl_s_id}'</script>";
    }


}

function update_s6($member_id,$edu_server_id){
    global $_SC;
    get_header();
    get_left_menu();
    $tbl_s_id="6";
    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
    if($edu_server_info['is_complete']==0){
        $selected_a="selected";
    }else{
        $selected_b="selected";
    }
    $member_info=member_info($member_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=edu&member_id={$member_id}"><i class="icon-dashboard"></i>教育服务记录 </a></li>
               <li class="active"><i class="icon-edit"></i><a href="index.php?do=edu&member_id={$member_id}&class=6">{$member_info['name']}寄宿家庭和房屋租凭服务列表</a></li>
              <li class="active"><i class="icon-edit"></i>{$edu_server_info['server_name']}详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#basic_info" data-toggle="tab">基本信息</a></li>
                <li><a href="#server_need" data-toggle="tab">服务需求</a></li>
                <li><a href="#server_status" data-toggle="tab">服务状态</a></li>
                <li><a href="#visit" data-toggle="tab">回访情况</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <!--基本信息--start-->
                <div class="tab-pane fade active in" id="basic_info">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务名称</label>
                                                    <input class="form-control" value="{$edu_server_info['server_name']}" name="server_name">
                                                  </div>
                                                </div>



                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_name']}" name="contact_name">
                                                  </div>
                                                </div>





                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人电话</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_mobile']}" name="contact_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人邮箱</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_email']}" name="contact_email">
                                                  </div>
                                                </div>




                </div>
                <!--基本信息--end-->
                <!--服务需求--start-->
                <div class="tab-pane fade" id="server_need">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">所在学校</label>
                                                    <input class="form-control" value="{$edu_server_info['attend_school']}" name="attend_school">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">可接受路程</label>
                                                    <input class="form-control" value="{$edu_server_info['accept_route']}" name="accept_route">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">租住方式</label>
                                                    <input class="form-control" value="{$edu_server_info['rental_methods']}" name="rental_methods">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">价格/周</label>
                                                    <input class="form-control" value="{$edu_server_info['price']}" name="price">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">备注说明</label>
                                                    <input class="form-control" value="{$edu_server_info['price']}" name="price">
                                                  </div>
                                                </div>



                </div>
                <!--服务需求--end-->

            <!--服务状态--start-->
               <div class="tab-pane fade" id="server_status">


                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">完成状态</label>
                                                    <select class="form-control" name="is_complete">
                                                      <option value="0" {$selected_a}>未完成</option>
                                                      <option value="1" {$selected_b}>已完成</option>
                                                    </select>
                                                  </div>

                </div>
        <!--服务状态--end-->
        <!--回访情况--start-->
                                                <div class="tab-pane fade" id="visit">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">满意度回访</label>
                                                    <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction']}" name="reciprocal_satisfaction">
                                                  </div>
                                                </div>
                                                </div>
        <!--回访情况--end-->

              </div>
            </div>
            <div class="form-group">
                      <button type="submit" class="btn btn-default" name="update_edu_server">提 交</button>
                      <a href="index.php?do=edu&member_id={$member_id}" class="btn btn-default">取 消</a>
                      </div>
                  </form>
                </div>
            </div>
        </div>

html;
    call_module($edu_server_id,$tbl_s_id,$member_id);
    if(isset($_POST['update_edu_server'])){

        if(!empty($_POST['server_name'])){
            $sql="UPDATE `tbl_s6` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_name'])){
            $sql="UPDATE `tbl_s6` SET `contact_name` ='".daddslashes($_POST['contact_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_mobile'])){
            $sql="UPDATE `tbl_s6` SET `contact_mobile` ='".daddslashes($_POST['contact_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_email'])){
            $sql="UPDATE `tbl_s6` SET `contact_email` ='".daddslashes($_POST['contact_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['attend_school'])){
            $sql="UPDATE `tbl_s6` SET `attend_school` ='".daddslashes($_POST['attend_school'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['accept_route'])){
            $sql="UPDATE `tbl_s6` SET `accept_route` ='".daddslashes($_POST['accept_route'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['rental_methods'])){
            $sql="UPDATE `tbl_s6` SET `rental_methods` ='".daddslashes($_POST['rental_methods'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['price'])){
            $sql="UPDATE `tbl_s6` SET `price` ='".daddslashes($_POST['price'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['remarks'])){
            $sql="UPDATE `tbl_s6` SET `remarks` ='".daddslashes($_POST['remarks'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['reciprocal_satisfaction'])){
            $sql="UPDATE `tbl_s6` SET `reciprocal_satisfaction` ='".daddslashes($_POST['reciprocal_satisfaction'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }
        $sql="UPDATE `tbl_s6` SET `is_delete` ='0'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s6` SET `is_complete` ='".$_POST['is_complete']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_server_member` SET `is_delete` ='0'  WHERE edu_class_id='".$tbl_s_id."' and edu_s_id='".$edu_server_id."'";
        $_SC['db']->query($sql);



        echo "<script>alert('提示:成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id={$tbl_s_id}'</script>";
    }


}

function update_s7($member_id,$edu_server_id){
    global $_SC;
    get_header();
    get_left_menu();
    $tbl_s_id="7";
    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
    if($edu_server_info['is_complete']==0){
        $selected_a="selected";
    }else{
        $selected_b="selected";
    }
    $member_info=member_info($member_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=edu&member_id={$member_id}"><i class="icon-dashboard"></i>教育服务记录 </a></li>
              <li class="active"><i class="icon-edit"></i><a href="index.php?do=edu&member_id={$member_id}&class=7">{$member_info['name']}留学生当地电话卡服务列表</a></li>
              <li class="active"><i class="icon-edit"></i>{$edu_server_info['server_name']}详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#basic_info" data-toggle="tab">基本信息</a></li>
                <li><a href="#server_need" data-toggle="tab">服务需求</a></li>
                <li><a href="#server_status" data-toggle="tab">服务状态</a></li>
                <li><a href="#visit" data-toggle="tab">回访情况</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <!--基本信息--start-->
                <div class="tab-pane fade active in" id="basic_info">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务名称</label>
                                                    <input class="form-control" value="{$edu_server_info['server_name']}" name="server_name">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_name']}" name="contact_name">
                                                  </div>
                                                </div>



                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人电话</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_mobile']}" name="contact_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人邮箱</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_email']}" name="contact_email">
                                                  </div>
                                                </div>




                </div>
                <!--基本信息--end-->
                <!--服务需求--start-->
                <div class="tab-pane fade" id="server_need">

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">咨询内容简介</label>
                                                    <textarea class="form-control" value="{$edu_server_info['contnet']}" name="contnet"></textarea>
                                                  </div>
                                                </div>



                </div>
                <!--服务需求--end-->

            <!--服务状态--start-->
               <div class="tab-pane fade" id="server_status">


                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">完成状态</label>
                                                    <select class="form-control" name="is_complete">
                                                      <option value="0" {$selected_a}>未完成</option>
                                                      <option value="1" {$selected_b}>已完成</option>
                                                    </select>
                                                  </div>


                </div>
        <!--服务状态--end-->
                            <!--回访情况--start-->
                            <div class="tab-pane fade" id="visit">
                                <div class="form-group has-success">
                                    <div class="form-group">
                                        <label class="control-label" for="inputSuccess">满意度回访</label>
                                        <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction']}" name="reciprocal_satisfaction">
                                    </div>
                                </div>
                            </div>
                            <!--回访情况--end-->
              </div>
            </div>
            <div class="form-group">
                      <button type="submit" class="btn btn-default" name="update_edu_server">提 交</button>
                      <a href="index.php?do=edu&member_id={$member_id}" class="btn btn-default">取 消</a>
                      </div>
                  </form>
                </div>
            </div>
        </div>

html;
    call_module($edu_server_id,$tbl_s_id,$member_id);
    message_module($edu_server_id,$tbl_s_id);
    if(isset($_POST['update_edu_server'])){

        if(!empty($_POST['server_name'])){
            $sql="UPDATE `tbl_s7` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_name'])){
            $sql="UPDATE `tbl_s7` SET `contact_name` ='".daddslashes($_POST['contact_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_mobile'])){
            $sql="UPDATE `tbl_s7` SET `contact_mobile` ='".daddslashes($_POST['contact_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_email'])){
            $sql="UPDATE `tbl_s7` SET `contact_email` ='".daddslashes($_POST['contact_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contnet'])){
            $sql="UPDATE `tbl_s7` SET `contnet` ='".daddslashes($_POST['contnet'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['reciprocal_satisfaction'])){
            $sql="UPDATE `tbl_s7` SET `reciprocal_satisfaction` ='".daddslashes($_POST['reciprocal_satisfaction'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }
        $sql="UPDATE `tbl_s7` SET `is_delete` ='0'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s7` SET `is_complete` ='".$_POST['is_complete']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_server_member` SET `is_delete` ='0'  WHERE edu_class_id='".$tbl_s_id."' and edu_s_id='".$edu_server_id."'";
        $_SC['db']->query($sql);



        echo "<script>alert('提示:成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id={$tbl_s_id}'</script>";
    }


}

function update_s8($member_id,$edu_server_id){
    global $_SC;
    get_header();
    get_left_menu();
    $tbl_s_id="8";
    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
    if($edu_server_info['is_complete']==0){
        $selected_a="selected";
    }else{
        $selected_b="selected";
    }
    $member_info=member_info($member_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=edu&member_id={$member_id}"><i class="icon-dashboard"></i>教育服务记录 </a></li>
               <li class="active"><i class="icon-edit"></i><a href="index.php?do=edu&member_id={$member_id}&class=8">{$member_info['name']}入境手续和当地居住服务列表</a></li>
              <li class="active"><i class="icon-edit"></i>{$edu_server_info['server_name']}详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#basic_info" data-toggle="tab">基本信息</a></li>
                <li><a href="#server_need" data-toggle="tab">服务需求</a></li>
                <li><a href="#server_status" data-toggle="tab">服务状态</a></li>
                <li><a href="#visit" data-toggle="tab">回访情况</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <!--基本信息--start-->
                <div class="tab-pane fade active in" id="basic_info">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务名称</label>
                                                    <input class="form-control" value="{$edu_server_info['server_name']}" name="server_name">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_name']}" name="contact_name">
                                                  </div>
                                                </div>



                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人电话</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_mobile']}" name="contact_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人邮箱</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_email']}" name="contact_email">
                                                  </div>
                                                </div>




                </div>
                <!--基本信息--end-->
                <!--服务需求--start-->
                <div class="tab-pane fade" id="server_need">



                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">推荐供应商</label>
                                                    <input class="form-control" value="{$edu_server_info['recommended_supplier']}" name="recommended_supplier">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">咨询内容简介</label>
                                                    <textarea class="form-control" value="{$edu_server_info['contnet']}" name="contnet"></textarea>
                                                  </div>
                                                </div>


                </div>
                <!--服务需求--end-->

            <!--服务状态--start-->
               <div class="tab-pane fade" id="server_status">


                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">完成状态</label>
                                                    <select class="form-control" name="is_complete">
                                                      <option value="0" {$selected_a}>未完成</option>
                                                      <option value="1" {$selected_b}>已完成</option>
                                                    </select>
                                                  </div>


                </div>
        <!--服务状态--end-->
<!--回访情况--start-->
                    <div class="tab-pane fade" id="visit">
                        <div class="form-group has-success">
                            <div class="form-group">
                                <label class="control-label" for="inputSuccess">满意度回访</label>
                                <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction']}" name="reciprocal_satisfaction">
                            </div>
                        </div>
                    </div>
<!--回访情况--end-->
              </div>
            </div>
            <div class="form-group">
                      <button type="submit" class="btn btn-default" name="update_edu_server">提 交</button>
                      <a href="index.php?do=edu&member_id={$member_id}" class="btn btn-default">取 消</a>
                      </div>
                  </form>
                </div>
            </div>
        </div>

html;
    call_module($edu_server_id,$tbl_s_id,$member_id);
    if(isset($_POST['update_edu_server'])){

        if(!empty($_POST['server_name'])){
            $sql="UPDATE `tbl_s8` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['contact_name'])){
            $sql="UPDATE `tbl_s8` SET `contact_name` ='".daddslashes($_POST['contact_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_mobile'])){
            $sql="UPDATE `tbl_s8` SET `contact_mobile` ='".daddslashes($_POST['contact_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_email'])){
            $sql="UPDATE `tbl_s8` SET `contact_email` ='".daddslashes($_POST['contact_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contnet'])){
            $sql="UPDATE `tbl_s8` SET `contnet` ='".daddslashes($_POST['contnet'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['recommended_supplier'])){
            $sql="UPDATE `tbl_s8` SET `recommended_supplier` ='".daddslashes($_POST['recommended_supplier'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['reciprocal_satisfaction'])){
            $sql="UPDATE `tbl_s8` SET `reciprocal_satisfaction` ='".daddslashes($_POST['reciprocal_satisfaction'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }
        $sql="UPDATE `tbl_s8` SET `is_delete` ='0'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s8` SET `is_complete` ='".$_POST['is_complete']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_server_member` SET `is_delete` ='0'  WHERE edu_class_id='".$tbl_s_id."' and edu_s_id='".$edu_server_id."'";
        $_SC['db']->query($sql);



        echo "<script>alert('提示:成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id={$tbl_s_id}'</script>";
    }


}

function update_s9($member_id,$edu_server_id){
    global $_SC;
    get_header();
    get_left_menu();
    $tbl_s_id="9";
    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
    if($edu_server_info['is_complete']==0){
        $selected_a="selected";
    }else{
        $selected_b="selected";
    }
    $member_info=member_info($member_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=edu&member_id={$member_id}"><i class="icon-dashboard"></i>教育服务记录 </a></li>
              <li class="active"><i class="icon-edit"></i><a href="index.php?do=edu&member_id={$member_id}&class=9">{$member_info['name']}生活费管理及学习监理服务列表</a></li>
              <li class="active"><i class="icon-edit"></i>{$edu_server_info['server_name']}详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#basic_info" data-toggle="tab">基本信息</a></li>
                <li><a href="#server_need" data-toggle="tab">服务需求</a></li>
                <li><a href="#server_status" data-toggle="tab">服务状态</a></li>
                <li><a href="#visit" data-toggle="tab">回访情况</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <!--基本信息--start-->
                <div class="tab-pane fade active in" id="basic_info">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务名称</label>
                                                    <input class="form-control" value="{$edu_server_info['server_name']}" name="server_name">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_name']}" name="contact_name">
                                                  </div>
                                                </div>



                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人电话</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_mobile']}" name="contact_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人邮箱</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_email']}" name="contact_email">
                                                  </div>
                                                </div>




                </div>
                <!--基本信息--end-->
                <!--服务需求--start-->
                <div class="tab-pane fade" id="server_need">



                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">推荐供应商</label>
                                                    <input class="form-control" value="{$edu_server_info['recommended_supplier']}" name="recommended_supplier">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">咨询内容简介</label>
                                                    <textarea class="form-control" value="{$edu_server_info['contnet']}" name="contnet"></textarea>
                                                  </div>
                                                </div>


                </div>
                <!--服务需求--end-->

            <!--服务状态--start-->
               <div class="tab-pane fade" id="server_status">


                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">完成状态</label>
                                                    <select class="form-control" name="is_complete">
                                                      <option value="0" {$selected_a}>未完成</option>
                                                      <option value="1" {$selected_b}>已完成</option>
                                                    </select>
                                                  </div>


                </div>
        <!--服务状态--end-->
<!--回访情况--start-->
<div class="tab-pane fade" id="visit">
    <div class="form-group has-success">
        <div class="form-group">
            <label class="control-label" for="inputSuccess">满意度回访</label>
            <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction']}" name="reciprocal_satisfaction">
        </div>
    </div>
</div>
<!--回访情况--end-->
              </div>
            </div>
            <div class="form-group">
                      <button type="submit" class="btn btn-default" name="update_edu_server">提 交</button>
                      <a href="index.php?do=edu&member_id={$member_id}" class="btn btn-default">取 消</a>
                      </div>
                  </form>
                </div>
            </div>
        </div>

html;
    call_module($edu_server_id,$tbl_s_id,$member_id);
    if(isset($_POST['update_edu_server'])){

        if(!empty($_POST['server_name'])){
            $sql="UPDATE `tbl_s9` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['contact_name'])){
            $sql="UPDATE `tbl_s9` SET `contact_name` ='".daddslashes($_POST['contact_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_mobile'])){
            $sql="UPDATE `tbl_s9` SET `contact_mobile` ='".daddslashes($_POST['contact_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_email'])){
            $sql="UPDATE `tbl_s9` SET `contact_email` ='".daddslashes($_POST['contact_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contnet'])){
            $sql="UPDATE `tbl_s9` SET `contnet` ='".daddslashes($_POST['contnet'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['recommended_supplier'])){
            $sql="UPDATE `tbl_s9` SET `recommended_supplier` ='".daddslashes($_POST['recommended_supplier'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['reciprocal_satisfaction'])){
            $sql="UPDATE `tbl_s9` SET `reciprocal_satisfaction` ='".daddslashes($_POST['reciprocal_satisfaction'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }
        $sql="UPDATE `tbl_s9` SET `is_delete` ='0'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s9` SET `is_complete` ='".$_POST['is_complete']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_server_member` SET `is_delete` ='0'  WHERE edu_class_id='".$tbl_s_id."' and edu_s_id='".$edu_server_id."'";
        $_SC['db']->query($sql);



        echo "<script>alert('提示:成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id={$tbl_s_id}'</script>";
    }


}


function update_s10($member_id,$edu_server_id){
    global $_SC;
    get_header();
    get_left_menu();
    $tbl_s_id="10";
    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
    for ($i=14; $i<=14; $i++)
    {
        if(is_message($edu_server_id,$tbl_s_id,$i)){
            eval('$button_'.$i."='已发送';");
        }else{
            eval('$button_'.$i."='发送短信';");
        }
    }
    if($edu_server_info['is_complete']==0){
        $selected_a="selected";
    }else{
        $selected_b="selected";
    }
    if($edu_server_info['pay_status']==0){
        $selected_pay_a="selected";
    }else{
        $selected_pay_b="selected";
    }
    $member_info=member_info($member_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=edu&member_id={$member_id}"><i class="icon-dashboard"></i>教育服务记录 </a></li>
              <li class="active"><i class="icon-edit"></i><a href="index.php?do=edu&member_id={$member_id}&class=10">{$member_info['name']}生活资讯服务列表</a></li>
              <li class="active"><i class="icon-edit"></i>{$edu_server_info['server_name']}详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#basic_info" data-toggle="tab">基本信息</a></li>
                <li><a href="#server_need" data-toggle="tab">服务需求</a></li>
                <li><a href="#pay_info" data-toggle="tab">支付信息</a></li>
                <li><a href="#server_status" data-toggle="tab">服务状态</a></li>
                <li><a href="#visit" data-toggle="tab">回访情况</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <!--基本信息--start-->
                <div class="tab-pane fade active in" id="basic_info">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务名称</label>
                                                    <input class="form-control" value="{$edu_server_info['server_name']}" name="server_name">
                                                  </div>
                                                </div>


                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_name']}" name="contact_name">
                                                  </div>
                                                </div>



                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人电话</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_mobile']}" name="contact_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人邮箱</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_email']}" name="contact_email">
                                                  </div>
                                                </div>




                </div>
                <!--基本信息--end-->
                <!--服务需求--start-->
                <div class="tab-pane fade" id="server_need">



                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">推荐供应商</label>
                                                    <input class="form-control" value="{$edu_server_info['recommended_supplier']}" name="recommended_supplier">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">咨询内容简介</label>
                                                    <textarea class="form-control" value="{$edu_server_info['contnet']}" name="contnet"></textarea>
                                                  </div>
                                                </div>


                </div>
                <!--服务需求--end-->

                                <!--支付信息--start-->
                                    <div class="tab-pane fade" id="pay_info">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">支付方式</label>
                                                    <input class="form-control" value="{$edu_server_info['bill']}" name="bill">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">票据</label>
                                                    <input class="form-control" value="{$edu_server_info['payment']}" name="payment">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">金额</label>
                                                    <input class="form-control" value="{$edu_server_info['money_amount']}" name="money_amount">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">支付状态</label>
                                                    <select class="form-control" name="pay_status">
                                                        <option value="0" {$selected_pay_a}>未付</option>
                                                        <option value="1" {$selected_pay_b}>已付</option>
                                                    </select>
                                                </div>
                                                </div>
                                            <!--支付信息--end-->

            <!--服务状态--start-->
               <div class="tab-pane fade" id="server_status">


                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">完成状态</label>
                                                    <select class="form-control" name="is_complete">
                                                      <option value="0" {$selected_a}>未完成</option>
                                                      <option value="1" {$selected_b}>已完成</option>
                                                    </select>
                                                  </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <div class="row"><div class="col-lg-4" for="inputSuccess"><label class="control-label" for="inputSuccess">预定成功</label></div>
                                                    <div class=" col-lg-8"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},10,14)">{$button_14}</a></div>
                                                    </div>
                                                  </div>
                                                </div>

                </div>
        <!--服务状态--end-->
<!--回访情况--start-->
<div class="tab-pane fade" id="visit">
    <div class="form-group has-success">
        <div class="form-group">
            <label class="control-label" for="inputSuccess">满意度回访</label>
            <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction']}" name="reciprocal_satisfaction">
        </div>
    </div>
</div>
<!--回访情况--end-->
              </div>
            </div>
            <div class="form-group">
                      <button type="submit" class="btn btn-default" name="update_edu_server">提 交</button>
                      <a href="index.php?do=edu&member_id={$member_id}" class="btn btn-default">取 消</a>
                      </div>
                  </form>
                </div>
            </div>
        </div>

html;
    call_module($edu_server_id,$tbl_s_id,$member_id);
    message_module($edu_server_id,$tbl_s_id);
    if(isset($_POST['update_edu_server'])){

        if(!empty($_POST['server_name'])){
            $sql="UPDATE `tbl_s10` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['contact_name'])){
            $sql="UPDATE `tbl_s10` SET `contact_name` ='".daddslashes($_POST['contact_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['contact_mobile'])){
            $sql="UPDATE `tbl_s10` SET `contact_mobile` ='".daddslashes($_POST['contact_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_mobile'])){
            $sql="UPDATE `tbl_s10` SET `contact_mobile` ='".daddslashes($_POST['contact_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_email'])){
            $sql="UPDATE `tbl_s10` SET `contact_email` ='".daddslashes($_POST['contact_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contnet'])){
            $sql="UPDATE `tbl_s10` SET `contnet` ='".daddslashes($_POST['contnet'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['recommended_supplier'])){
            $sql="UPDATE `tbl_s10` SET `recommended_supplier` ='".daddslashes($_POST['recommended_supplier'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['bill'])){
            $sql="UPDATE `tbl_s10` SET `bill` ='".daddslashes($_POST['bill'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['payment'])){
            $sql="UPDATE `tbl_s10` SET `payment` ='".daddslashes($_POST['payment'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['money_amount'])){
            $sql="UPDATE `tbl_s10` SET `money_amount` ='".daddslashes($_POST['money_amount'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['reciprocal_satisfaction'])){
            $sql="UPDATE `tbl_s10` SET `reciprocal_satisfaction` ='".daddslashes($_POST['reciprocal_satisfaction'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }
        $sql="UPDATE `tbl_s10` SET `is_delete` ='0'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s10` SET `is_complete` ='".$_POST['is_complete']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s10` SET `pay_status` ='".$_POST['pay_status']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_server_member` SET `is_delete` ='0'  WHERE edu_class_id='".$tbl_s_id."' and edu_s_id='".$edu_server_id."'";
        $_SC['db']->query($sql);



        echo "<script>alert('提示:成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id={$tbl_s_id}'</script>";
    }


}

function update_s11($member_id,$edu_server_id){
    global $_SC;
    get_header();
    get_left_menu();
    $tbl_s_id="11";
    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
    for ($i=15; $i<=15; $i++)
    {
        if(is_message($edu_server_id,$tbl_s_id,$i)){
            eval('$button_'.$i."='已发送';");
        }else{
            eval('$button_'.$i."='发送短信';");
        }
    }
    if($edu_server_info['is_complete']==0){
        $selected_a="selected";
    }else{
        $selected_b="selected";
    }
    if($edu_server_info['pay_status']==0){
        $selected_pay_a="selected";
    }else{
        $selected_pay_b="selected";
    }
    $member_info=member_info($member_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=edu&member_id={$member_id}"><i class="icon-dashboard"></i>教育服务记录 </a></li>
              <li class="active"><i class="icon-edit"></i><a href="index.php?do=edu&member_id={$member_id}&class=11">{$member_info['name']}海外租车和援驾服务列表</a></li>
              <li class="active"><i class="icon-edit"></i>{$edu_server_info['server_name']}详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#basic_info" data-toggle="tab">基本信息</a></li>
                <li><a href="#server_need" data-toggle="tab">服务需求</a></li>
                <li><a href="#pay_info" data-toggle="tab">支付信息</a></li>
                <li><a href="#server_status" data-toggle="tab">服务状态</a></li>
                <li><a href="#visit" data-toggle="tab">回访情况</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <!--基本信息--start-->
                <div class="tab-pane fade active in" id="basic_info">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务名称</label>
                                                    <input class="form-control" value="{$edu_server_info['server_name']}" name="server_name">
                                                  </div>
                                                </div>

                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_name']}" name="contact_name">
                                                  </div>
                                                </div>




                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人电话</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_mobile']}" name="contact_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人邮箱</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_email']}" name="contact_email">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">驾照编号</label>
                                                    <input class="form-control" value="{$edu_server_info['license_number']}" name="license_number">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">签发地</label>
                                                    <input class="form-control" value="{$edu_server_info['issued']}" name="issued">
                                                  </div>
                                                </div>



                </div>
                <!--基本信息--end-->
                <!--服务需求--start-->
                <div class="tab-pane fade" id="server_need">




                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">咨询内容简介</label>
                                                    <textarea class="form-control" value="{$edu_server_info['contnet']}" name="contnet"></textarea>
                                                  </div>
                                                </div>


                </div>
                <!--服务需求--end-->
                <!--支付信息--start-->
                <div class="tab-pane fade" id="pay_info">

                                            <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">金额</label>
                                                    <input class="form-control" value="{$edu_server_info['money_amount']}" name="money_amount">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">支付方式</label>
                                                    <input class="form-control" value="{$edu_server_info['payment']}" name="payment">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">支付状态</label>
                                                    <select class="form-control" name="pay_status">
                                                        <option value="0" {$selected_pay_a}>未付</option>
                                                        <option value="1" {$selected_pay_b}>已付</option>
                                                    </select>
                                                </div>




                </div>
                <!--支付信息--end-->
            <!--服务状态--start-->
               <div class="tab-pane fade" id="server_status">

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">援驾司机姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['driver_name']}" name="driver_name">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">司机联系方式</label>
                                                    <input class="form-control" value="{$edu_server_info['driver_contact']}" name="driver_contact">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">预计到达时间</label>
                                                    <input class="form-control" value="{$edu_server_info['time_control']}" name="time_control">
                                                  </div>
                                                </div>


                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">完成状态</label>
                                                    <select class="form-control" name="is_complete">
                                                      <option value="0" {$selected_a}>未完成</option>
                                                      <option value="1" {$selected_b}>已完成</option>
                                                    </select>
                                                  </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <div class="row"><div class="col-lg-4" for="inputSuccess"><label class="control-label" for="inputSuccess">预定成功</label></div>
                                                    <div class=" col-lg-8"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},11,15)">{$button_15}</a></div>
                                                    </div>
                                                  </div>
                                                </div>

                </div>
        <!--服务状态--end-->
<!--回访情况--start-->
<div class="tab-pane fade" id="visit">
    <div class="form-group has-success">
        <div class="form-group">
            <label class="control-label" for="inputSuccess">满意度回访</label>
            <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction']}" name="reciprocal_satisfaction">
        </div>
    </div>
</div>
<!--回访情况--end-->
              </div>
            </div>
            <div class="form-group">
                      <button type="submit" class="btn btn-default" name="update_edu_server">提 交</button>
                      <a href="index.php?do=edu&member_id={$member_id}" class="btn btn-default">取 消</a>
                      </div>
                  </form>
                </div>
            </div>
        </div>

html;
    call_module($edu_server_id,$tbl_s_id,$member_id);
    message_module($edu_server_id,$tbl_s_id);
    if(isset($_POST['update_edu_server'])){

        if(!empty($_POST['server_name'])){
            $sql="UPDATE `tbl_s11` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_name'])){
            $sql="UPDATE `tbl_s11` SET `contact_name` ='".daddslashes($_POST['contact_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_mobile'])){
            $sql="UPDATE `tbl_s11` SET `contact_mobile` ='".daddslashes($_POST['contact_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_email'])){
            $sql="UPDATE `tbl_s11` SET `contact_email` ='".daddslashes($_POST['contact_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['license_number'])){
            $sql="UPDATE `tbl_s11` SET `license_number` ='".daddslashes($_POST['license_number'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['issued'])){
            $sql="UPDATE `tbl_s11` SET `issued` ='".daddslashes($_POST['issued'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contnet'])){
            $sql="UPDATE `tbl_s11` SET `contnet` ='".daddslashes($_POST['contnet'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['payment'])){
            $sql="UPDATE `tbl_s11` SET `payment` ='".daddslashes($_POST['payment'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['money_amount'])){
            $sql="UPDATE `tbl_s11` SET `money_amount` ='".daddslashes($_POST['money_amount'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['pay_status'])){
            $sql="UPDATE `tbl_s11` SET `pay_status` ='".daddslashes($_POST['pay_status'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['driver_name'])){
            $sql="UPDATE `tbl_s11` SET `driver_name` ='".daddslashes($_POST['driver_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['driver_contact'])){
            $sql="UPDATE `tbl_s11` SET `driver_contact` ='".daddslashes($_POST['driver_contact'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['time_control'])){
            $sql="UPDATE `tbl_s11` SET `time_control` ='".daddslashes($_POST['time_control'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['reciprocal_satisfaction'])){
            $sql="UPDATE `tbl_s11` SET `reciprocal_satisfaction` ='".daddslashes($_POST['reciprocal_satisfaction'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }
        $sql="UPDATE `tbl_s11` SET `is_delete` ='0'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s11` SET `is_complete` ='".$_POST['is_complete']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_server_member` SET `is_delete` ='0'  WHERE edu_class_id='".$tbl_s_id."' and edu_s_id='".$edu_server_id."'";
        $_SC['db']->query($sql);



        echo "<script>alert('提示:成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id={$tbl_s_id}'</script>";
    }


}

function update_s12($member_id,$edu_server_id){
    global $_SC;
    get_header();
    get_left_menu();
    $tbl_s_id="12";
    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
    for ($i=16; $i<=16; $i++)
    {
        if(is_message($edu_server_id,$tbl_s_id,$i)){
            eval('$button_'.$i."='已发送';");
        }else{
            eval('$button_'.$i."='发送短信';");
        }
    }
    if($edu_server_info['is_complete']==0){
        $selected_a="selected";
    }else{
        $selected_b="selected";
    }
    if($edu_server_info['pay_status']==0){
        $selected_pay_a="selected";
    }else{
        $selected_pay_b="selected";
    }
    $member_info=member_info($member_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=edu&member_id={$member_id}"><i class="icon-dashboard"></i>教育服务记录 </a></li>
              <li class="active"><i class="icon-edit"></i><a href="index.php?do=edu&member_id={$member_id}&class=12">{$member_info['name']}健康管理和就医服务列表</a></li>
              <li class="active"><i class="icon-edit"></i>{$edu_server_info['server_name']}详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#basic_info" data-toggle="tab">基本信息</a></li>
                <li><a href="#server_need" data-toggle="tab">服务需求</a></li>
                <li><a href="#pay_info" data-toggle="tab">支付信息</a></li>
                <li><a href="#server_status" data-toggle="tab">服务状态</a></li>
                <li><a href="#visit" data-toggle="tab">回访情况</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <!--基本信息--start-->
                <div class="tab-pane fade active in" id="basic_info">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务名称</label>
                                                    <input class="form-control" value="{$edu_server_info['server_name']}" name="server_name">
                                                  </div>
                                                </div>


                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_name']}" name="contact_name">
                                                  </div>
                                                </div>




                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人电话</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_mobile']}" name="contact_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人邮箱</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_email']}" name="contact_email">
                                                  </div>
                                                </div>




                </div>
                <!--基本信息--end-->
                <!--服务需求--start-->
                <div class="tab-pane fade" id="server_need">

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">推荐供应商</label>
                                                    <input class="form-control" value="{$edu_server_info['recommended_supplier']}" name="recommended_supplier">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">咨询内容简介</label>
                                                    <textarea class="form-control" value="{$edu_server_info['contnet']}" name="contnet"></textarea>
                                                  </div>
                                                </div>


                </div>
                <!--服务需求--end-->

                <!--支付信息--start-->
                <div class="tab-pane fade" id="pay_info">

                                            <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">金额</label>
                                                    <input class="form-control" value="{$edu_server_info['money_amount']}" name="money_amount">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">支付方式</label>
                                                    <input class="form-control" value="{$edu_server_info['payment']}" name="payment">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">支付状态</label>
                                                    <select class="form-control" name="pay_status">
                                                        <option value="0" {$selected_pay_a}>未付</option>
                                                        <option value="1" {$selected_pay_b}>已付</option>
                                                    </select>
                                                </div>




                </div>
                <!--支付信息--end-->
            <!--服务状态--start-->
               <div class="tab-pane fade" id="server_status">
                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">礼宾人员姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['concierge_name']}" name="concierge_name">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系方式</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_concierge']}" name="contact_concierge">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">预计到达时间</label>
                                                    <input class="form-control" value="{$edu_server_info['time_control']}" name="time_control">
                                                  </div>
                                                </div>


                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">完成状态</label>
                                                    <select class="form-control" name="is_complete">
                                                      <option value="0" {$selected_a}>未完成</option>
                                                      <option value="1" {$selected_b}>已完成</option>
                                                    </select>
                                                  </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <div class="row"><div class="col-lg-4" for="inputSuccess"><label class="control-label" for="inputSuccess">预定成功</label></div>
                                                    <div class=" col-lg-8"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},12,16)">{$button_16}</a></div>
                                                    </div>
                                                  </div>
                                                </div>

                </div>
        <!--服务状态--end-->

        <!--回访情况--start-->
        <div class="tab-pane fade" id="visit">
            <div class="form-group has-success">
                <div class="form-group">
                    <label class="control-label" for="inputSuccess">满意度回访</label>
                    <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction']}" name="reciprocal_satisfaction">
                </div>
            </div>
        </div>
        <!--回访情况--end-->

              </div>
            </div>
            <div class="form-group">
                      <button type="submit" class="btn btn-default" name="update_edu_server">提 交</button>
                      <a href="index.php?do=edu&member_id={$member_id}" class="btn btn-default">取 消</a>
                      </div>
                  </form>
                </div>
            </div>
        </div>

html;
    call_module($edu_server_id,$tbl_s_id,$member_id);
    message_module($edu_server_id,$tbl_s_id);
    if(isset($_POST['update_edu_server'])){

        if(!empty($_POST['server_name'])){
            $sql="UPDATE `tbl_s12` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_name'])){
            $sql="UPDATE `tbl_s12` SET `contact_name` ='".daddslashes($_POST['contact_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_mobile'])){
            $sql="UPDATE `tbl_s12` SET `contact_mobile` ='".daddslashes($_POST['contact_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_email'])){
            $sql="UPDATE `tbl_s12` SET `contact_email` ='".daddslashes($_POST['contact_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contnet'])){
            $sql="UPDATE `tbl_s12` SET `contnet` ='".daddslashes($_POST['contnet'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['payment'])){
            $sql="UPDATE `tbl_s12` SET `payment` ='".daddslashes($_POST['payment'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['money_amount'])){
            $sql="UPDATE `tbl_s12` SET `money_amount` ='".daddslashes($_POST['money_amount'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['pay_status'])){
            $sql="UPDATE `tbl_s12` SET `pay_status` ='".daddslashes($_POST['pay_status'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['concierge_name'])){
            $sql="UPDATE `tbl_s12` SET `concierge_name` ='".daddslashes($_POST['concierge_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_concierge'])){
            $sql="UPDATE `tbl_s12` SET `contact_concierge` ='".daddslashes($_POST['contact_concierge'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['time_control'])){
            $sql="UPDATE `tbl_s12` SET `time_control` ='".daddslashes($_POST['time_control'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['recommended_supplier'])){
            $sql="UPDATE `tbl_s12` SET `recommended_supplier` ='".daddslashes($_POST['recommended_supplier'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['reciprocal_satisfaction'])){
            $sql="UPDATE `tbl_s12` SET `reciprocal_satisfaction` ='".daddslashes($_POST['reciprocal_satisfaction'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }
        $sql="UPDATE `tbl_s12` SET `is_delete` ='0'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s12` SET `is_complete` ='".$_POST['is_complete']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_server_member` SET `is_delete` ='0'  WHERE edu_class_id='".$tbl_s_id."' and edu_s_id='".$edu_server_id."'";
        $_SC['db']->query($sql);



        echo "<script>alert('提示:成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id={$tbl_s_id}'</script>";
    }


}

function update_s13($member_id,$edu_server_id){
    global $_SC;
    get_header();
    get_left_menu();
    $tbl_s_id="13";
    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
    for ($i=17; $i<=18; $i++)
    {
        if(is_message($edu_server_id,$tbl_s_id,$i)){
            eval('$button_'.$i."='已发送';");
        }else{
            eval('$button_'.$i."='发送短信';");
        }
    }
    if($edu_server_info['is_complete']==0){
        $selected_a="selected";
    }else{
        $selected_b="selected";
    }
    $member_info=member_info($member_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=edu&member_id={$member_id}"><i class="icon-dashboard"></i>教育服务记录 </a></li>
              <li class="active"><i class="icon-edit"></i><a href="index.php?do=edu&member_id={$member_id}&class=13">{$member_info['name']}翻译服务列表</a></li>
              <li class="active"><i class="icon-edit"></i>{$edu_server_info['server_name']}详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#basic_info" data-toggle="tab">基本信息</a></li>
                <li><a href="#server_need" data-toggle="tab">服务需求</a></li>
                <li><a href="#server_status" data-toggle="tab">服务状态</a></li>
                <li><a href="#visit" data-toggle="tab">回访情况</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <!--基本信息--start-->
                <div class="tab-pane fade active in" id="basic_info">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务名称</label>
                                                    <input class="form-control" value="{$edu_server_info['server_name']}" name="server_name">
                                                  </div>
                                                </div>

                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_name']}" name="contact_name">
                                                  </div>
                                                </div>




                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人电话</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_mobile']}" name="contact_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人邮箱</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_email']}" name="contact_email">
                                                  </div>
                                                </div>




                </div>
                <!--基本信息--end-->
                <!--服务需求--start-->
                <div class="tab-pane fade" id="server_need">



                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">咨询内容简介</label>
                                                    <textarea class="form-control" value="{$edu_server_info['contnet']}" name="contnet"></textarea>
                                                  </div>
                                                </div>


                </div>
                <!--服务需求--end-->

            <!--服务状态--start-->
               <div class="tab-pane fade" id="server_status">
                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">翻译人员姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['translate_name']}" name="translate_name">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">翻译人员联系方式</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_translate']}" name="contact_translate">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">预计使用时间</label>
                                                    <input class="form-control" value="{$edu_server_info['time_control']}" name="time_control">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务地点</label>
                                                    <input class="form-control" value="{$edu_server_info['service_location']}" name="service_location">
                                                  </div>
                                                </div>

                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">完成状态</label>
                                                    <select class="form-control" name="is_complete">
                                                      <option value="0" {$selected_a}>未完成</option>
                                                      <option value="1" {$selected_b}>已完成</option>
                                                    </select>
                                                  </div>



                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <div class="row"><div class="col-lg-4" for="inputSuccess"><label class="control-label" for="inputSuccess">预定成功</label></div>
                                                    <div class=" col-lg-8"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},13,17)">{$button_17}</a></div>
                                                    </div>
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <div class="row"><div class="col-lg-4" for="inputSuccess"><label class="control-label" for="inputSuccess">服务信息</label></div>
                                                    <div class=" col-lg-8"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},13,18)">{$button_18}</a></div>
                                                    </div>
                                                  </div>
                                                </div>


                </div>
        <!--服务状态--end-->
        <!--回访情况--start-->
<div class="tab-pane fade" id="visit">
    <div class="form-group has-success">
        <div class="form-group">
            <label class="control-label" for="inputSuccess">满意度回访</label>
            <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction']}" name="reciprocal_satisfaction">
        </div>
    </div>
</div>
<!--回访情况--end-->

              </div>
            </div>
            <div class="form-group">
                      <button type="submit" class="btn btn-default" name="update_edu_server">提 交</button>
                      <a href="index.php?do=edu&member_id={$member_id}" class="btn btn-default">取 消</a>
                      </div>
                  </form>
                </div>
            </div>
        </div>

html;
    call_module($edu_server_id,$tbl_s_id,$member_id);
    message_module($edu_server_id,$tbl_s_id);
    if(isset($_POST['update_edu_server'])){

        if(!empty($_POST['server_name'])){
            $sql="UPDATE `tbl_s13` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_name'])){
            $sql="UPDATE `tbl_s13` SET `contact_name` ='".daddslashes($_POST['contact_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_mobile'])){
            $sql="UPDATE `tbl_s13` SET `contact_mobile` ='".daddslashes($_POST['contact_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_email'])){
            $sql="UPDATE `tbl_s13` SET `contact_email` ='".daddslashes($_POST['contact_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contnet'])){
            $sql="UPDATE `tbl_s13` SET `contnet` ='".daddslashes($_POST['contnet'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['translate_name'])){
            $sql="UPDATE `tbl_s13` SET `translate_name` ='".daddslashes($_POST['translate_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_translate'])){
            $sql="UPDATE `tbl_s13` SET `contact_translate` ='".daddslashes($_POST['contact_translate'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['time_control'])){
            $sql="UPDATE `tbl_s13` SET `time_control` ='".daddslashes($_POST['time_control'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['service_location'])){
            $sql="UPDATE `tbl_s13` SET `service_location` ='".daddslashes($_POST['service_location'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['reciprocal_satisfaction'])){
            $sql="UPDATE `tbl_s13` SET `reciprocal_satisfaction` ='".daddslashes($_POST['reciprocal_satisfaction'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }
        $sql="UPDATE `tbl_s13` SET `is_delete` ='0'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s13` SET `is_complete` ='".$_POST['is_complete']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_server_member` SET `is_delete` ='0'  WHERE edu_class_id='".$tbl_s_id."' and edu_s_id='".$edu_server_id."'";
        $_SC['db']->query($sql);



        echo "<script>alert('提示:成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id={$tbl_s_id}'</script>";
    }


}

function update_s14($member_id,$edu_server_id){
    global $_SC;
    get_header();
    get_left_menu();
    $tbl_s_id="14";
    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
    for ($i=19; $i<=20; $i++)
    {
        if(is_message($edu_server_id,$tbl_s_id,$i)){
            eval('$button_'.$i."='已发送';");
        }else{
            eval('$button_'.$i."='发送短信';");
        }
    }
    if($edu_server_info['is_complete']==0){
        $selected_a="selected";
    }else{
        $selected_b="selected";
    }
    if($edu_server_info['pay_status']==0){
        $selected_pay_a="selected";
    }else{
        $selected_pay_b="selected";
    }
    $member_info=member_info($member_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=edu&member_id={$member_id}"><i class="icon-dashboard"></i>教育服务记录 </a></li>
              <li class="active"><i class="icon-edit"></i><a href="index.php?do=edu&member_id={$member_id}&class=14">{$member_info['name']}证件遗失等应急服务列表</a></li>
              <li class="active"><i class="icon-edit"></i>{$edu_server_info['server_name']}详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#basic_info" data-toggle="tab">基本信息</a></li>
                <li><a href="#server_need" data-toggle="tab">服务需求</a></li>
                <li><a href="#pay_info" data-toggle="tab">支付信息</a></li>
                <li><a href="#server_status" data-toggle="tab">服务状态</a></li>
                <li><a href="#visit" data-toggle="tab">回访情况</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <!--基本信息--start-->
                <div class="tab-pane fade active in" id="basic_info">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务名称</label>
                                                    <input class="form-control" value="{$edu_server_info['server_name']}" name="server_name">
                                                  </div>
                                                </div>


                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_name']}" name="contact_name">
                                                  </div>
                                                </div>



                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人电话</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_mobile']}" name="contact_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人邮箱</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_email']}" name="contact_email">
                                                  </div>
                                                </div>




                </div>
                <!--基本信息--end-->
                <!--服务需求--start-->
                <div class="tab-pane fade" id="server_need">


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">咨询内容简介</label>
                                                    <textarea class="form-control" value="{$edu_server_info['contnet']}" name="contnet"></textarea>
                                                  </div>
                                                </div>


                </div>
                <!--服务需求--end-->
                <!--支付信息--start-->
                <div class="tab-pane fade" id="pay_info">

                                            <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">金额</label>
                                                    <input class="form-control" value="{$edu_server_info['money_amount']}" name="money_amount">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">支付方式</label>
                                                    <input class="form-control" value="{$edu_server_info['payment']}" name="payment">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">支付状态</label>
                                                    <select class="form-control" name="pay_status">
                                                        <option value="0" {$selected_pay_a}>未付</option>
                                                        <option value="1" {$selected_pay_b}>已付</option>
                                                    </select>
                                                </div>




                </div>
                <!--支付信息--end-->
            <!--服务状态--start-->
               <div class="tab-pane fade" id="server_status">

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">礼宾人员姓名</label>
                                                    <input class="form-control" value="{$edu_server_info['concierge_name']}" name="concierge_name">
                                                  </div>
                                                </div>


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">礼宾人员联系方式</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_concierge']}" name="contact_concierge">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">预计使用时间</label>
                                                    <input class="form-control" value="{$edu_server_info['time_control']}" name="time_control">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务地点</label>
                                                    <input class="form-control" value="{$edu_server_info['service_location']}" name="service_location">
                                                  </div>
                                                </div>


                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">完成状态</label>
                                                    <select class="form-control" name="is_complete">
                                                      <option value="0" {$selected_a}>未完成</option>
                                                      <option value="1" {$selected_b}>已完成</option>
                                                    </select>
                                                  </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <div class="row"><div class="col-lg-4" for="inputSuccess"><label class="control-label" for="inputSuccess">预定成功</label></div>
                                                    <div class=" col-lg-8"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},14,19)">{$button_19}</a></div>
                                                    </div>
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <div class="row"><div class="col-lg-4" for="inputSuccess"><label class="control-label" for="inputSuccess">服务信息</label></div>
                                                    <div class=" col-lg-8"> <a href="#" class="btn btn-large btn-primary col-md-7" onclick="message({$edu_server_info['s_id']},14,20)">{$button_20}</a></div>
                                                    </div>
                                                  </div>
                                                </div>

                </div>
        <!--服务状态--end-->
<!--回访情况--start-->
<div class="tab-pane fade" id="visit">
    <div class="form-group has-success">
        <div class="form-group">
            <label class="control-label" for="inputSuccess">满意度回访</label>
            <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction']}" name="reciprocal_satisfaction">
        </div>
    </div>
</div>
<!--回访情况--end-->
              </div>
            </div>
            <div class="form-group">
                      <button type="submit" class="btn btn-default" name="update_edu_server">提 交</button>
                      <a href="index.php?do=edu&member_id={$member_id}" class="btn btn-default">取 消</a>
                      </div>
                  </form>
                </div>
            </div>
        </div>

html;
    call_module($edu_server_id,$tbl_s_id,$member_id);
    message_module($edu_server_id,$tbl_s_id);
    if(isset($_POST['update_edu_server'])){

        if(!empty($_POST['server_name'])){
            $sql="UPDATE `tbl_s14` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['contact_name'])){
            $sql="UPDATE `tbl_s14` SET `contact_name` ='".daddslashes($_POST['contact_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_mobile'])){
            $sql="UPDATE `tbl_s14` SET `contact_mobile` ='".daddslashes($_POST['contact_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_email'])){
            $sql="UPDATE `tbl_s14` SET `contact_email` ='".daddslashes($_POST['contact_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contnet'])){
            $sql="UPDATE `tbl_s14` SET `contnet` ='".daddslashes($_POST['contnet'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['payment'])){
            $sql="UPDATE `tbl_s14` SET `payment` ='".daddslashes($_POST['payment'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['money_amount'])){
            $sql="UPDATE `tbl_s14` SET `money_amount` ='".daddslashes($_POST['money_amount'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['pay_status'])){
            $sql="UPDATE `tbl_s14` SET `pay_status` ='".daddslashes($_POST['pay_status'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['contact_concierge'])){
            $sql="UPDATE `tbl_s14` SET `contact_concierge` ='".daddslashes($_POST['contact_concierge'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['concierge_name'])){
            $sql="UPDATE `tbl_s14` SET `concierge_name` ='".daddslashes($_POST['concierge_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['time_control'])){
            $sql="UPDATE `tbl_s14` SET `time_control` ='".daddslashes($_POST['time_control'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['service_location'])){
            $sql="UPDATE `tbl_s14` SET `service_location` ='".daddslashes($_POST['service_location'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['reciprocal_satisfaction'])){
            $sql="UPDATE `tbl_s14` SET `reciprocal_satisfaction` ='".daddslashes($_POST['reciprocal_satisfaction'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }
        $sql="UPDATE `tbl_s14` SET `is_delete` ='0'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s14` SET `is_complete` ='".$_POST['is_complete']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_server_member` SET `is_delete` ='0'  WHERE edu_class_id='".$tbl_s_id."' and edu_s_id='".$edu_server_id."'";
        $_SC['db']->query($sql);



        echo "<script>alert('提示:成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id={$tbl_s_id}'</script>";
    }


}

function update_s15($member_id,$edu_server_id){
    global $_SC;
    get_header();
    get_left_menu();
    $tbl_s_id="15";
    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
    if($edu_server_info['is_complete']==0){
        $selected_a="selected";
    }else{
        $selected_b="selected";
    }
    $member_info=member_info($member_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=edu&member_id={$member_id}"><i class="icon-dashboard"></i>教育服务记录 </a></li>
              <li class="active"><i class="icon-edit"></i><a href="index.php?do=edu&member_id={$member_id}&class=15">{$member_info['name']}留学托管服务列表</a></li>
              <li class="active"><i class="icon-edit"></i>{$edu_server_info['server_name']}详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#basic_info" data-toggle="tab">基本信息</a></li>
                <li><a href="#server_need" data-toggle="tab">服务需求</a></li>
                <li><a href="#server_status" data-toggle="tab">服务状态</a></li>
                <li><a href="#visit" data-toggle="tab">回访情况</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <!--基本信息--start-->
                <div class="tab-pane fade active in" id="basic_info">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务名称</label>
                                                    <input class="form-control" value="{$edu_server_info['server_name']}" name="server_name">
                                                  </div>
                                                </div>






                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人电话</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_mobile']}" name="contact_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人邮箱</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_email']}" name="contact_email">
                                                  </div>
                                                </div>




                </div>
                <!--基本信息--end-->
                <!--服务需求--start-->
                <div class="tab-pane fade" id="server_need">



                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">推荐供应商</label>
                                                    <input class="form-control" value="{$edu_server_info['recommended_supplier']}" name="recommended_supplier">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">咨询内容简介</label>
                                                    <textarea class="form-control" value="{$edu_server_info['contnet']}" name="contnet"></textarea>
                                                  </div>
                                                </div>


                </div>
                <!--服务需求--end-->

            <!--服务状态--start-->
               <div class="tab-pane fade" id="server_status">


                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">完成状态</label>
                                                    <select class="form-control" name="is_complete">
                                                      <option value="0" {$selected_a}>未完成</option>
                                                      <option value="1" {$selected_b}>已完成</option>
                                                    </select>
                                                  </div>


                </div>
        <!--服务状态--end-->

        <!--回访--start-->
        <div class="tab-pane fade" id="visit">
                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">满意度回访(第一次)</label>
                                                    <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction_1']}" name="reciprocal_satisfaction_1">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">满意度回访(第二次)</label>
                                                    <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction_2']}" name="reciprocal_satisfaction_2">
                                                  </div>
                                                </div>



                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">满意度回访(第三次)</label>
                                                    <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction_3']}" name="reciprocal_satisfaction_3">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">满意度回访(第四次)</label>
                                                    <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction_4']}" name="reciprocal_satisfaction_4">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">满意度回访(第五次)</label>
                                                    <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction_5']}" name="reciprocal_satisfaction_5">
                                                  </div>
                                                </div>
        </div>
        <!--回访--end-->

              </div>
            </div>
            <div class="form-group">
                      <button type="submit" class="btn btn-default" name="update_edu_server">提 交</button>
                      <a href="index.php?do=edu&member_id={$member_id}" class="btn btn-default">取 消</a>
                      </div>
                  </form>
                </div>
            </div>
        </div>

html;
    call_module($edu_server_id,$tbl_s_id,$member_id);
    if(isset($_POST['update_edu_server'])){

        if(!empty($_POST['server_name'])){
            $sql="UPDATE `tbl_s15` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['contact_mobile'])){
            $sql="UPDATE `tbl_s15` SET `contact_mobile` ='".daddslashes($_POST['contact_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_email'])){
            $sql="UPDATE `tbl_s15` SET `contact_email` ='".daddslashes($_POST['contact_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contnet'])){
            $sql="UPDATE `tbl_s15` SET `contnet` ='".daddslashes($_POST['contnet'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['recommended_supplier'])){
            $sql="UPDATE `tbl_s15` SET `recommended_supplier` ='".daddslashes($_POST['recommended_supplier'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['reciprocal_satisfaction_1'])){
            $sql="UPDATE `tbl_s15` SET `reciprocal_satisfaction_1` ='".daddslashes($_POST['reciprocal_satisfaction_1'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['reciprocal_satisfaction_2'])){
            $sql="UPDATE `tbl_s15` SET `reciprocal_satisfaction_2` ='".daddslashes($_POST['reciprocal_satisfaction_2'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['reciprocal_satisfaction_3'])){
            $sql="UPDATE `tbl_s15` SET `reciprocal_satisfaction_3` ='".daddslashes($_POST['reciprocal_satisfaction_3'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['reciprocal_satisfaction_4'])){
            $sql="UPDATE `tbl_s15` SET `reciprocal_satisfaction_4` ='".daddslashes($_POST['reciprocal_satisfaction_4'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['reciprocal_satisfaction_5'])){
            $sql="UPDATE `tbl_s15` SET `reciprocal_satisfaction_5` ='".daddslashes($_POST['reciprocal_satisfaction_5'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }



        $sql="UPDATE `tbl_s15` SET `is_delete` ='0'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s15` SET `is_complete` ='".$_POST['is_complete']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_server_member` SET `is_delete` ='0'  WHERE edu_class_id='".$tbl_s_id."' and edu_s_id='".$edu_server_id."'";
        $_SC['db']->query($sql);


        echo "<script>alert('提示:成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id={$tbl_s_id}'</script>";
    }


}

function update_s16($member_id,$edu_server_id){
    global $_SC;
    get_header();
    get_left_menu();
    $tbl_s_id="16";
    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
    if($edu_server_info['is_complete']==0){
        $selected_a="selected";
    }else{
        $selected_b="selected";
    }
    $member_info=member_info($member_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=edu&member_id={$member_id}"><i class="icon-dashboard"></i>教育服务记录 </a></li>
              <li class="active"><i class="icon-edit"></i><a href="index.php?do=edu&member_id={$member_id}&class=16">{$member_info['name']}游学服务列表</a></li>
              <li class="active"><i class="icon-edit"></i>{$edu_server_info['server_name']}详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#basic_info" data-toggle="tab">基本信息</a></li>
                <li><a href="#server_need" data-toggle="tab">服务需求</a></li>
                <li><a href="#server_status" data-toggle="tab">服务状态</a></li>
                <li><a href="#visit" data-toggle="tab">回访情况</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <!--基本信息--start-->
                <div class="tab-pane fade active in" id="basic_info">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务名称</label>
                                                    <input class="form-control" value="{$edu_server_info['server_name']}" name="server_name">
                                                  </div>
                                                </div>






                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人电话</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_mobile']}" name="contact_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人邮箱</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_email']}" name="contact_email">
                                                  </div>
                                                </div>




                </div>
                <!--基本信息--end-->
                <!--服务需求--start-->
                <div class="tab-pane fade" id="server_need">



                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">推荐供应商</label>
                                                    <input class="form-control" value="{$edu_server_info['recommended_supplier']}" name="recommended_supplier">
                                                  </div>
                                                </div>

                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">咨询内容简介</label>
                                                    <textarea class="form-control" value="{$edu_server_info['contnet']}" name="contnet"></textarea>
                                                  </div>
                                                </div>


                </div>
                <!--服务需求--end-->

            <!--服务状态--start-->
               <div class="tab-pane fade" id="server_status">


                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">完成状态</label>
                                                    <select class="form-control" name="is_complete">
                                                      <option value="0" {$selected_a}>未完成</option>
                                                      <option value="1" {$selected_b}>已完成</option>
                                                    </select>
                                                  </div>


                </div>
        <!--服务状态--end-->
<!--回访情况--start-->
<div class="tab-pane fade" id="visit">
    <div class="form-group has-success">
        <div class="form-group">
            <label class="control-label" for="inputSuccess">满意度回访</label>
            <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction']}" name="reciprocal_satisfaction">
        </div>
    </div>
</div>
<!--回访情况--end-->
              </div>
            </div>
            <div class="form-group">
                      <button type="submit" class="btn btn-default" name="update_edu_server">提 交</button>
                      <a href="index.php?do=edu&member_id={$member_id}" class="btn btn-default">取 消</a>
                      </div>
                  </form>
                </div>
            </div>
        </div>

html;
    call_module($edu_server_id,$tbl_s_id,$member_id);
    if(isset($_POST['update_edu_server'])){

        if(!empty($_POST['server_name'])){
            $sql="UPDATE `tbl_s16` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['contact_mobile'])){
            $sql="UPDATE `tbl_s16` SET `contact_mobile` ='".daddslashes($_POST['contact_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_email'])){
            $sql="UPDATE `tbl_s16` SET `contact_email` ='".daddslashes($_POST['contact_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contnet'])){
            $sql="UPDATE `tbl_s16` SET `contnet` ='".daddslashes($_POST['contnet'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['recommended_supplier'])){
            $sql="UPDATE `tbl_s16` SET `recommended_supplier` ='".daddslashes($_POST['recommended_supplier'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['reciprocal_satisfaction'])){
            $sql="UPDATE `tbl_s16` SET `reciprocal_satisfaction` ='".daddslashes($_POST['reciprocal_satisfaction'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }
        $sql="UPDATE `tbl_s16` SET `is_delete` ='0'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s16` SET `is_complete` ='".$_POST['is_complete']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_server_member` SET `is_delete` ='0'  WHERE edu_class_id='".$tbl_s_id."' and edu_s_id='".$edu_server_id."'";
        $_SC['db']->query($sql);

        echo "<script>alert('提示:成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id={$tbl_s_id}'</script>";
    }


}

function update_s17($member_id,$edu_server_id){
    global $_SC;
    get_header();
    get_left_menu();
    $tbl_s_id="17";
    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
    if($edu_server_info['is_complete']==0){
        $selected_a="selected";
    }else{
        $selected_b="selected";
    }
    $member_info=member_info($member_id);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=edu&member_id={$member_id}"><i class="icon-dashboard"></i>教育服务记录 </a></li>
              <li class="active"><i class="icon-edit"></i><a href="index.php?do=edu&member_id={$member_id}&class=17">{$member_info['name']}旅游定制服务列表</a></li>
              <li class="active"><i class="icon-edit"></i>{$edu_server_info['server_name']}详细信息</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
            <form role="form" action="#" method="post" enctype="multipart/form-data">
              <div class="bs-example">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#basic_info" data-toggle="tab">基本信息</a></li>
                <li><a href="#server_need" data-toggle="tab">服务需求</a></li>
                <li><a href="#server_status" data-toggle="tab">服务状态</a></li>
                <li><a href="#visit" data-toggle="tab">回访情况</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <!--基本信息--start-->
                <div class="tab-pane fade active in" id="basic_info">
                                              <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">服务名称</label>
                                                    <input class="form-control" value="{$edu_server_info['server_name']}" name="server_name">
                                                  </div>
                                                </div>






                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人电话</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_mobile']}" name="contact_mobile">
                                                  </div>
                                                </div>

                                               <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">联系人邮箱</label>
                                                    <input class="form-control" value="{$edu_server_info['contact_email']}" name="contact_email">
                                                  </div>
                                                </div>




                </div>
                <!--基本信息--end-->
                <!--服务需求--start-->
                <div class="tab-pane fade" id="server_need">


                                                <div class="form-group has-success">
                                                  <div class="form-group">
                                                    <label class="control-label" for="inputSuccess">咨询内容简介</label>
                                                    <textarea class="form-control" value="{$edu_server_info['contnet']}" name="contnet"></textarea>
                                                  </div>
                                                </div>


                </div>
                <!--服务需求--end-->

            <!--服务状态--start-->
               <div class="tab-pane fade" id="server_status">


                                                  <div class="form-group has-success">
                                                    <label class="control-label" for="inputSuccess">完成状态</label>
                                                    <select class="form-control" name="is_complete">
                                                      <option value="0" {$selected_a}>未完成</option>
                                                      <option value="1" {$selected_b}>已完成</option>
                                                    </select>
                                                  </div>

                </div>
        <!--服务状态--end-->
<!--回访情况--start-->
<div class="tab-pane fade" id="visit">
    <div class="form-group has-success">
        <div class="form-group">
            <label class="control-label" for="inputSuccess">满意度回访</label>
            <input class="form-control" value="{$edu_server_info['reciprocal_satisfaction']}" name="reciprocal_satisfaction">
        </div>
    </div>
</div>
<!--回访情况--end-->
              </div>
            </div>
            <div class="form-group">
                      <button type="submit" class="btn btn-default" name="update_edu_server">提 交</button>
                      <a href="index.php?do=edu&member_id={$member_id}" class="btn btn-default">取 消</a>
                      </div>
                  </form>
                </div>
            </div>
        </div>

html;
    call_module($edu_server_id,$tbl_s_id,$member_id);
    if(isset($_POST['update_edu_server'])){

        if(!empty($_POST['server_name'])){
            $sql="UPDATE `tbl_s17` SET `server_name` ='".daddslashes($_POST['server_name'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }


        if(!empty($_POST['contact_mobile'])){
            $sql="UPDATE `tbl_s17` SET `contact_mobile` ='".daddslashes($_POST['contact_mobile'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contact_email'])){
            $sql="UPDATE `tbl_s17` SET `contact_email` ='".daddslashes($_POST['contact_email'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['contnet'])){
            $sql="UPDATE `tbl_s17` SET `contnet` ='".daddslashes($_POST['contnet'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['reciprocal_satisfaction'])){
            $sql="UPDATE `tbl_s17` SET `reciprocal_satisfaction` ='".daddslashes($_POST['reciprocal_satisfaction'])."'  WHERE `s_id` ='".$edu_server_id."' ";
            $_SC['db']->query($sql);
        }
        $sql="UPDATE `tbl_s17` SET `is_delete` ='0'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_s17` SET `is_complete` ='".$_POST['is_complete']."'  WHERE `s_id` ='".$edu_server_id."' ";
        $_SC['db']->query($sql);

        $sql="UPDATE `tbl_server_member` SET `is_delete` ='0'  WHERE edu_class_id='".$tbl_s_id."' and edu_s_id='".$edu_server_id."'";
        $_SC['db']->query($sql);


        echo "<script>alert('提示:成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id={$tbl_s_id}'</script>";
    }


}


//获取指定教育服务的全部信息
function edu_server_info($edu_server_id,$tbl_s_id){
    global $_SC;
    $tbl_name="tbl_s".$tbl_s_id;
    $sql="select * from $tbl_name where s_id='".$edu_server_id."'";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    return $rs;
}

//删除教育服务
function edu_server_delete($member_id,$edu_server_id,$tbl_s_id){
    global $_SC;
    $is_delete="1";
    $tbl_name="tbl_s".$tbl_s_id;
    $sql="UPDATE `$tbl_name` SET `is_delete` ='".$is_delete."'  WHERE `s_id` ='".$edu_server_id."' ";
    $_SC['db']->query($sql);
    $sql="UPDATE `tbl_server_member` SET `is_delete` ='".$is_delete."'  WHERE `edu_s_id` ='".$edu_server_id."' and edu_class_id='".$tbl_s_id."' ";
    $_SC['db']->query($sql);
    echo "<script>alert('提示:删除成功');location.href='index.php?do=edu&member_id={$member_id}'</script>";
}

//获取指定教育服务的全部通话记录
function call_arr($edu_server_id,$tbl_s_id){
    global $_SC;
    $sql="select * from tbl_call_record where edu_server_id=$edu_server_id and edu_server_class='".$tbl_s_id."' and is_delete='0' ";
    $query=$_SC['db']->query($sql);
    $tmp=array();
    while($rs=$_SC['db']->fetch_array($query)){
        $tmp[]=$rs;
    }
    return $tmp;
}

//删除指定ID的通话记录
function delete_call($call_id){
    global $_SC;
    $sql="update tbl_call_record set is_delete='1' where call_id='".$call_id."'";
    $query=$_SC['db']->query($sql);
    if($query){
        echo "<script>history.go(-1)</script>";
    }
}








//  通话记录模块
function call_module($edu_server_id,$tbl_s_id,$member_id){
    global $_SC;
    echo <<<html
                <!--通话记录模块--start-->
         <div class="col-lg-8">

            <h2 id="nav-tabs">通话记录</h2>
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th >致电编号</th>
                    <th style="width: 20%;min-width: 200px">需求种类</th>
                    <th >致电时间</th>
                    <th >录音文件(mp3,wav,aif,au,ram)</th>
                    <th >备注</th>
                  </tr>
                </thead>
html;
    $call_record_arr=call_arr($edu_server_id,$tbl_s_id);
    foreach($call_record_arr as $v){
        $call_time=date('Y-m-d H:i',$v['call_time']);
        $suffix=pathinfo($v['recording_url'], PATHINFO_EXTENSION);
        echo <<<html
       <tr>
                    <td>{$v['call_number']}</td>
                    <td>{$v['need_species']}</td>
                    <td>{$call_time}</td>
                    <td>
html;
        if(!empty($v['recording_url'])){
    echo <<<html
                    <audio  src="{$v['recording_url']}"  controls="controls"   style="width: 200px;float: left"></audio>
                    <a href="down.php?file_url={$v['recording_url']}&file_name={$v['call_number']}&suffix={$suffix}" class="icon-arrow-down btn btn-default" style="height: 30px;float: left;margin-left: 5px" title="下载" ></a>
html;
    }
        echo <<<html
                    </td>
                    <td>{$v['remarks']}
                    <a href="index.php?do=edu&ac=delete_call&call_id={$v['call_id']}" onclick='return CommandConfirm_server();'"><button type="button" class="close" title="删除">&times;</button></a>
                    </td>
       </tr>



html;

    }
    echo <<<html
    <tr>
    <form method="post" action="#" enctype="multipart/form-data">
        <td><input name="call_number"></td>
        <td>
          <select class="form-control" name="need_species">
           <option value="服务咨询" selected>服务咨询</option>
           <option value="服务申请">服务申请</option>
           <option value="服务变更">服务变更</option>
           <option value="服务投诉">服务投诉</option>
          </select>
        </td>
        <td><input name="call_time" type="datetime-local"></td>
        <td><input name="call_audio"  type="file"></td>
        <td><input name="remarks"><button type="submit" class="btn btn-default" name="add_call">提交</button></td>
        </form>
    </tr>
                </table>
            </div>

html;

    if(isset($_POST['add_call'])){
        if(!empty($_POST['call_number'])){
            if(!empty($_POST['call_time'])){
                $time=strtotime($_POST['call_time']);
                if($_FILES['call_audio']['error']=='0'){
                    $audio_type_array=array('mp3','wav','aif','au','ram');
                    $audio_type_name=pathinfo($_FILES['call_audio']['name'], PATHINFO_EXTENSION);
                    if(in_array($audio_type_name,$audio_type_array)){
                        $time=time();
                        $year=date(Y);
                        $month=date(m);
                        $day=date(d);
                        $tmp = str_replace('\\\\', '\\', $_FILES['call_audio']['tmp_name']);
                        if(!file_exists('./audio/'.$year.'/'.$month.'/'.$day.'/')){
                            mkdir("./audio/$year/$month/$day",'0777',true);
                        }
                        $move=move_uploaded_file($tmp,'./audio/'.$year.'/'.$month.'/'.$day.'/'.date(Hi).$time.'.'.$audio_type_name);
                        if($move){
                            $file_name=date(Hi).$time;
                            $url="audio/$year/$month/$day/$file_name.$audio_type_name";
                        }

                        $sql="insert into tbl_call_record (call_number,need_species,edu_server_class,edu_server_id,call_time,remarks,recording_url) value ('".daddslashes($_POST['call_number'])."','".daddslashes($_POST['need_species'])."','$tbl_s_id','.$edu_server_id.','.$time.','".daddslashes($_POST['remarks'])."','".$url."')";
                        $query=$_SC['db']->query($sql);

                    }else{
                        echo "<script>alert('提示:音频文件类型错误');history.go(-1)</script>";
                    }
                }

                if($_POST['need_species']=="服务投诉"){
                    $call_id=$_SC['db']->insert_id();
                    $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
                    $sql="insert into tbl_complaint (call_id,member_id,complaint_time,server_time) value ('.$call_id.','".$member_id."','".$time."','".$edu_server_info['reg_time']."')";
                    $query=$_SC['db']->query($sql);
                }

                if($query){
                    echo "<script>alert('提示:增加成功');location.href='index.php?do=edu&ac=update&member_id={$member_id}&edu_server_id={$edu_server_id}&tbl_s_id={$tbl_s_id}'</script>";
                }

            }else{
                echo "<script>alert('提示:致电时间不能为空');history.go(-1)</script>";
            }
        }else{
            echo "<script>alert('提示:致电编号不能为空');history.go(-1)</script>";
        }
    }
    echo <<<html
    <!--通话记录模块--end           -->
html;

}

function message_arr($edu_server_id,$tbl_s_id){
    global $_SC;
    $sql="select * from tbl_message_record where edu_server_id=$edu_server_id and tbl_s_id='".$tbl_s_id."' ORDER BY  `tbl_message_record`.`message_record_id` DESC";
    $query=$_SC['db']->query($sql);
    $tmp=array();
    while($rs=$_SC['db']->fetch_array($query)){
        $tmp[]=$rs;
    }
    return $tmp;
}




function is_message($edu_server_id,$tbl_s_id,$message_num){
    global $_SC;
    $sql="select * from tbl_message_record where edu_server_id=$edu_server_id and tbl_s_id='".$tbl_s_id."' and message_num='".$message_num."'";
    $query=$_SC['db']->query($sql);
    if($rs=$_SC['db']->fetch_array($query)){
        return true;
    }else{
        return false;
    }
}


function message_module($edu_server_id,$tbl_s_id){
    global $_SC;
    echo <<<html
                <!--短信发送记录列表--start-->
         <div class="col-lg-8">

            <h2 id="nav-tabs">短信通知记录</h2>
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th >短信说明</th>
                    <th style="width: 20%;min-width: 200px">接收号码</th>
                    <th >发送时间</th>
                    <th >状态</th>
                    <th >操作</th>
                  </tr>
                </thead>
html;
    $message_arr=message_arr($edu_server_id,$tbl_s_id);
        foreach($message_arr as $v){
            $send_time=date('Y-m-d H:i',$v['send_time']);
            echo <<<html
            <tr>
            <td>{$v['remarks']}</td>
            <td>{$v['recipient_mobile']}</td>
            <td>{$send_time}</td>
            <td>{$v['state']}</td>
            <td></td>
            </tr>

html;

        }


 echo <<<html
                </table>
            </div>

html;


    echo <<<html
    <!--短信发送记录列表--end           -->
html;

}

//判断是否服务是否完成
function is_complete($is_complete){
    if($is_complete==0){
        return false;
    }else{
        return true;
    }
}



function edu_list_s($menber_id,$tbl_s_id){
    global $_SC;
    $tbl_name="tbl_s".$tbl_s_id;
    $sql="select * from $tbl_name where is_delete=0 and member_id='$menber_id'";
    $query=$_SC['db']->query($sql);
    $tmp=array();
    while($rs=$_SC['db']->fetch_array($query)){
        $tmp[]=$rs;
    }
    return $tmp;
}









?>

<script>
    window.onload(show());
    function CommandConfirm_server(){
        if(window.confirm("提示:确定要删除此记录？")){
            return true;
        }else{
            return false;
        }
    }
    function go(url){
        n==0?new function(){frames("frame1").location=url,n=1}:null;
        document.all("frame1").readyState!="complete"?setTimeout(go,10):so();
        function so(){frames("frame1").document.execCommand("SaveAs"),n=0};
    }
    function show()
    {
        var str=document.getElementById("optionsRadiosInline1").checked;
        var str=document.getElementById("optionsRadiosInline2").checked;
        if(document.getElementById("optionsRadiosInline1").checked){
            document.getElementById('checkbox_1').style.display = "";
        }else{
            document.getElementById('checkbox_1').style.display = "none";
        }

        if(document.getElementById("optionsRadiosInline2").checked){
            document.getElementById('checkbox_2').style.display = "";
        }else{
            document.getElementById('checkbox_2').style.display = "none";
        }
    }
    function moveon(){
        window.location.reload();
    }

    function message(edu_server_id,tbl_s_id,message_num){
        setTimeout('moveon()',1000);
        window.open("message.php?edu_server_id="+edu_server_id+"&tbl_s_id="+tbl_s_id+"&message_num="+message_num+"",'_blank',' toolbar=no,top=150,left=600, location=no, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=600, height=800')
    }
</script>

