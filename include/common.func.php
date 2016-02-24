<?php
function db_connect() {
    global $_SC;
    include_once(ABSPATH.'/include/db.class.php');
    $_SC['db'] = new dbstuff;
    $_SC['db']->charset = $_SC['db_charset'];
    $_SC['db']->connect($_SC['db_host'], $_SC['db_user'], $_SC['db_pw'], $_SC['db_name'], $_SC['pr_pconnect']);
}


//判断是否是PC端
function is_mobile() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $mobile_agents = Array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipad","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte");
    $is_mobile = false;
    foreach ($mobile_agents as $device) {
        if (stristr($user_agent, $device)) {
            $is_mobile = true;
            break;
        }
    }
    return $is_mobile;
}

function daddslashes($string, $force = 0) {
    if(!$GLOBALS['magic_quotes_gpc'] || $force) {
        if(is_array($string)) {
            foreach($string as $key => $val) {
                $string[$key] = daddslashes($val, $force);
            }
        } else {
            $string = addslashes($string);
        }
    }
    return $string;
}

//获取员工负责的所有客户(不包括已删除客户)
function member_user_arr($user_id){
    global $_SC;
    $tmp_arr=array();
    $sql="select * from tbl_member_user where user_id=".$user_id."";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $user_info=user_info($rs['member_id']);
        if($user_info['is_delete']==0){
            $tmp_arr[]=$rs['member_id'];
        }
    }
    return $tmp_arr;
}


function member_edu_arr(){
    global $_SC;
    $tmp_arr=array();
    $sql="select * from tbl_member_info where in_class='教育客户' and is_delete='0'";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
            $tmp_arr[]=$rs['id'];
    }
    return $tmp_arr;
}


//获取此客户全部负责人
function member_responsible($member_id){
    global $_SC;
    $sql="select * from tbl_member_user where  member_id=".$member_id." ";
    $query=$_SC['db']->query($sql);
    $temp=array();
    while($rs=$_SC['db']->fetch_array($query)){
       $temp[]=$rs['user_id'];
    }
    return $temp;
}

//输出全部未删除客户ID和姓名
function member_all(){
    global $_SC;
    $sql="select * from tbl_member_info where is_delete='0'";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $temp[]=array(
            'member_id'=>$rs['id'],
            'member_name'=>$rs['name'],
        );
    }
    return $temp;
}

//获取员工信息
function user_info($user_id){
    global $_SC;
    $sql="SELECT * FROM  tbl_user where user_id=".$user_id."";
    $query=$_SC['db']->query($sql);
    if($rs=$_SC['db']->fetch_array($query)){
        return $rs;
    }else{
        return false;
    }
}


//获取客户信息
function member_info($member_id){
    global $_SC;
    $sql="SELECT * FROM  tbl_member_info where id=".$member_id."";
    $query=$_SC['db']->query($sql);
    if($rs=$_SC['db']->fetch_array($query)){
        return $rs;
    }else{
        return false;
    }
}



function file_url($sever_id){
    global $_SC;
    $sql="select * from tbl_server_member where server_id='".$sever_id."'";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    if($rs){
        $sql="select * from tbl_file where file_id='".$rs['file_id']."'";
        $row=$_SC['db']->fetch_array($_SC['db']->query($sql));
        $tmp_file_url=$row['file_url'];
        $sql="select * from tbl_file where file_id='".$rs['attachment_id']."'";
        $row=$_SC['db']->fetch_array($_SC['db']->query($sql));
        $tmp_attachment_url=$row['file_url'];
        $tmp=array(
            'file'=>array('file_id'=>$rs['file_id'],'file_url'=>$tmp_file_url),
            'attachment'=>array('file_id'=>$rs['attachment_id'],'file_url'=>$tmp_attachment_url),
        );
        return $tmp;
    }else{
        return false;
    }
}



function pic_info($pic_id){
    global $_SC;
    $sql="select * from tbl_member_pic where pic_id='".$pic_id."'";
    $rs=$_SC['db']->fetch_array($_SC['db']->query($sql));
    if($rs){
        return $rs;
    }else{
        return false;
    }
}


function file_info($file_id){
    global $_SC;
    $sql="select * from tbl_file where file_id='".$file_id."'";
    $query=$_SC['db']->query($sql);
    if($rs=$_SC['db']->fetch_array($query)){
        return $rs;
    }else{
        return false;
    }
}




function golf_server($product_id){
    global $_SC;
    $sql="select * from tbl_golf_sever where product_id='".$product_id."'";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $tmp[]=$rs;
    }
    if(is_array($tmp)){
        return $tmp;
    }else{
        $tmp=array();
        return $tmp;
    }
}

function activitie_info($activitie_id){
    global $_SC;
    $sql="select * from tbl_activitie where activitie_id='".$activitie_id."'";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    if($rs){
        return $rs;
    }else{
        return false;
    }
}




function activitie_file_info($activitie_id){
    global $_SC;
    $sql="select * from tbl_activitie_file where activitie_id='".$activitie_id."'";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    if($rs){
        return $rs;
    }else{
        return false;
    }
}


//按ID数组输出所有员工名单
function member_responsible_name_arr($user_id_arr){
    foreach($user_id_arr as $v){
        $user_info=user_info($v);
        echo $user_info['name'].";";
    }
}


//关系查询函数
//返回格式为  关系id  关系客户id 关系
function m_to_m($member_id){
    global $_SC;
    $sql="select * from tbl_m_to_m where member_id_a='".$member_id."' or member_id_b='".$member_id."' ";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $temp[]=$rs;
    }
    if(is_array($temp)){
    foreach($temp as $v){
        $k=array_search($member_id,$v);
        unset($v[$k]);
        $id=array_shift($v);
        $m_id=array_shift($v);
        $tmp[]=array(
            'id'=>$id,
            'm_id'=>$m_id,
            'relationships'=>$v['relationships'],
        );
    }
        return $tmp;
    }else{
        $tmp=array();
        return $tmp;
    }

}



function search_edu_member_from(){
    echo <<<html
               <ol class="breadcrumb">
                <div class="col-lg-12">
                <form role="form" action="index.php?do=edumember" method="get" >
                   <table class="table table-bordered table-hover tablesorter">
                   <input type="hidden" name="do" value="edumember">
                    <tr>
                    <th colspan="9" style="text-align: center">请输入搜索条件 </th>
                    </tr>
                   <tr>
                   <th colspan="2"></th>
                    <th colspan=""style="text-align: center">
                  <input class="form-control" name="keyword" value="{$_GET['keyword']}">
                  </th>
                  <th colspan="1"style="text-align: center">
                  <button type="submit" name="search_all" class="btn btn-primary btn-1g " style="padding: 5px 40px"><i class="icon-search"></i> 搜索</button>
                     </th>
                     <th colspan="2"></th>
                  </tr>
                </table>
                </form>
                  </div>
                  </ol>
html;
}



//筛选from表单
function search_member_from(){
    echo <<<html
               <ol class="breadcrumb">
                <div class="col-lg-12">
                <form role="form" action="index.php?do=member&ac=edit" method="get" >
                   <table class="table table-bordered table-hover tablesorter">
                   <input type="hidden" name="do" value="member">
                   <input type="hidden" name="ac" value="edit">
                    <tr>
                    <th colspan="9" style="text-align: center">请输入筛选条件 </th>
                    </tr>
                  <tr>
                    <th class="col-lg-2"> 性别</th>
                    <th class="col-lg-2">婚姻状况 </th>
                    <th class="col-lg-2   ">是否有小孩 </th>
                    <th class="col-lg-2">分类 </th>
                    <th class="col-lg-2">标签 </th>
                    <th class="col-lg-2">注意事项 </th>
                  </tr>
                    <tr>

                    <th>
                        <select class="form-control" name="sex">
                          <option value="" selected>全部</option>
                          <option value="男"> 男   </option>
                          <option value="女"> 女    </option>
                        </select></th>
                    <th>
                     <div class="">
                        <select class="form-control" name="marital_status">
                          <option value="" selected>全部</option>
                          <option value="单身"> 单身   </option>
                          <option value="已婚"> 已婚    </option>
                          <option value="离异" > 离异    </option>
                        </select>
                  </div>
                  </th>
                    <th>
                          <select class="form-control" name="is_children">
                          <option value="" selected>全部</option>
                          <option value="">全部   </option>
                          <option value="有"> 有    </option>
                          <option value="否" > 否    </option>
                        </select>
                    </th>
                    <th>
                      <select class="form-control" name="in_class">
                          <option value="" selected>全部</option>
                          <option value="供应商">供应商   </option>
                          <option value="潜在客户"> 潜在客户    </option>
                          <option value="臻客会员" > 臻客会员    </option>
                          <option value="其他"> 其他    </option>
                        </select>
                        </th>
                    <th>
                      <select class="form-control" name="label">
                          <option value="" selected>全部</option>
                          <option value="传媒">传媒   </option>
                          <option value="金融"> 金融    </option>
                          <option value="长江同学" > 长江同学    </option>
                          <option value="其他"> 其他    </option>
                        </select>
                        </th>
                    <th>
                      <select class="form-control" name="tips">
                          <option value="" selected>全部</option>
                          <option value="重点客户">重点客户   </option>
                          <option value="已用过产品客户"> 已用过产品客户    </option>
                        </select>
                        </th>
                  </tr>
                  <tr>
                    <th colspan="9"style="text-align: center">
                  <button type="submit" name="search" class="btn btn-primary btn-1g " style="padding: 5px 40px"><i class="icon-search"></i> 执行</button>
                     </th>
                  </tr>
                    <tr>
                    <th colspan="9" style="text-align: center">请输入搜索条件 </th>
                    </tr>
                   <tr>
                   <th colspan="2"></th>
                    <th colspan=""style="text-align: center">
                  <input class="form-control" name="keyword" value="{$_GET['keyword']}">
                  </th>
                  <th colspan="1"style="text-align: center">
                  <button type="submit" name="search_all" class="btn btn-primary btn-1g " style="padding: 5px 40px"><i class="icon-search"></i> 搜索</button>
                     </th>
                     <th colspan="2"></th>
                  </tr>
                </table>
                </form>
                  </div>
                  </ol>
html;
}







function session_verify($username){
    if(!isset($username)){
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
    <!--<link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">-->
</head>
<body>
            <div class="col-sm-offset-4 col-sm-10">
                <h2 style="text-align:center;width: 430px">提示:未登录</h2>
                </div>
            <div class="col-sm-offset-4 col-sm-10">
                <h2 style="text-align:center;width: 430px">请登录后再操作</h2>
                </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                <a href="index.php?do=login"><button type="submit" name="submit" class="btn btn-default col-lg-6">点击登录</button></a>
                 </div>
             </div>

<!-- external javascript
================================================== -->



</body>
</html>

html;
        exit();
    }
}




function get_left_menu(){
    echo <<<html
         <nav class=" navbar-inverse " role="navigation">
   <div class="">
          <ul class="nav navbar-nav side-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-table"></i>  客户管理 <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="index.php?do=member&ac=edit">  客户列表</a></li>
                <li><a href="index.php?do=order&ac=list">  订单列表</a></li>
                <li><a href="index.php?do=consultation&ac=list">  咨询记录</a></li>
                <li><a href="index.php?do=commember&ac=list">  公司客户</a></li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-table"></i>  活动管理 <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="index.php?do=activitie&ac=edit">  活动列表</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-collapse"></i>      产品管理 <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="index.php?do=product&ac=edit">   臻品</a></li>
                <li><a href="index.php?do=restaurant&ac=edit">   餐厅</a></li>
                <li><a href="index.php?do=club&ac=edit">   会所</a></li>
                <li><a href="index.php?do=hotel&ac=edit">   酒店</a></li>
                <li><a href="index.php?do=tour&ac=edit">   旅游线路</a></li>
                <li><a href="index.php?do=golf&ac=edit">   高尔夫场地</a></li>
                <li><a href="index.php?do=edusup&ac=list">   教育供应商</a></li>
                <li><a href="index.php?do=edusup&ac=list">   教育供应商</a></li>
                <li><a href="index.php?do=file&ac=list">   文件管理</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-collapse"></i>      账务管理 <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="index.php?do=detail">   会员账户明细</a></li>
html;
    if($_SESSION['power']>=8){
      echo <<<html
                <li><a href="index.php?do=finance">  会员交易审核</a></li>
html;
}
     echo <<<html
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-collapse"></i>  教育项目 <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="index.php?do=complaint">  投诉列表</a></li>
                <li><a href="index.php?do=edumember">  教育客户列表</a></li>
              </ul>
            </li>
             <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-collapse"></i>      系统设置 <b class="caret"></b></a>
              <ul class="dropdown-menu">
html;


    if($_SESSION['power']>8){
    echo <<<html
                <li><a href="index.php?do=mange&ac=edit">   员工管理</a></li>
html;
}
     echo <<<html

              </ul>
            </li>
          </ul>
          </nav>
html;

}

function get_header(){
    echo <<<html
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>臻客 - CRM</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!-- Add custom CSS here -->
    <link href="assets/css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
    <!-- Page Specific CSS -->
    <!--<link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">-->
  </head>
  <body>
    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">

          </button>
          <a class="navbar-brand" href="index.html">臻客CRM</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="">
          <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> {$_SESSION['name']} <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="index.php?do=mange&ac=setting"><i class="icon-gear"></i> 设置</a></li>
                <li class="divider"></li>
                <li><a href="index.php?do=exit"><i class="icon-power-off"></i> 退出</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->

    <!-- Bootstrap core JavaScript -->
    <script src="assets/js/tablesorter/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <!-- Page Specific Plugins -->
    <script src="assets/js/tablesorter/raphael-min.js"></script>
    <script src="assets/js/tablesorter/morris-0.4.3.min.js"></script>
    <script src="assets/js/morris/chart-data-morris.js"></script>
    <script src="assets/js/tablesorter/jquery.tablesorter.js"></script>
    <script src="assets/js/tablesorter/tables.js"></script>
    <script src="assets/js/my.js"></script>
    <script language="javascript" type="text/javascript" src="assets/js/datepicker/wdatepicker.js"></script>
</nav>
</html>
html;
}



function add_relationships($member_id_a){
    global $_SC;
    $member_all=member_all();
    $member_info=member_info($member_id_a);
    echo <<<html
                <div id="createPopup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">增加{$member_info['name']}的人际关系</h4>
                            </div>
                            <form method="post" action="#" >
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label>目标客户</label>
                                                <select name="member_id_b" id="pr_patient_agetype" class="form-control">
html;
    foreach($member_all as $k=>$v){
echo <<<html
        <option value="{$v['member_id']}">{$v['member_name']}</option>;
html;
       }

    echo <<<html
                                                </select>
                                           </div>
                                           <div class="col-xs-6">
                                               <label>关系内容</label> <input type="text" placeholder="请输入关系" name="relationships" id="pr_patient_age" value="" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:void(0);" class="btn btn-default" data-dismiss="modal">关闭</a>
                                    <button class="btn btn-primary" type="submit" name="add_relationships" value="{$member_id_a}">创建</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
html;
    if(isset($_POST['add_relationships'])){
        if($_POST['member_id_b']!=$_POST['add_relationships'] ){
            if(!empty($_POST['relationships'])){
                $sql="select * from tbl_m_to_m where member_id_a='".$_POST['add_relationships']."' and member_id_b='".$_POST['member_id_b']."' or (member_id_a='".$_POST['member_id_b']."' and member_id_b='".$_POST['add_relationships']."')";
                $query=$_SC['db']->query($sql);
                if(!$rs=$_SC['db']->fetch_array($query)){
                    $sql="insert into tbl_m_to_m (member_id_a,member_id_b,relationships) value ('".$_POST['add_relationships']."','".$_POST['member_id_b']."','".daddslashes($_POST['relationships'])."')";
                    $_SC['db']->query($sql);
                }else{
                    echo "<script>alert('提示:于此客户关系已存在');location.href='index.php?do=member&ac=follow&id={$member_id_a}'</script>";
                }
            }else{
                echo "<script>alert('提示:创建成功');location.href='index.php?do=member&ac=follow&id={$member_id_a}'</script>";
            }
        }else{
            echo "<script>alert('提示:目标客户不能是该客户');location.href='index.php?do=member&ac=follow&id={$member_id_a}'</script>";
        }
    }

}




function view_pic($uid){
    global $_SC;
    $sql="select * from tbl_product_pic where uid='".$uid."'";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    echo <<<html
                <div id="bigpic" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">{$rs['pic_name']}</h4>
                            </div>
                                <div class="modal-body">
                                <img src="{$rs['url']}" width="550px">
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:void(0);" class="btn btn-default" data-dismiss="modal">关闭</a>
                                </div>
                        </div>
                    </div>
                </div>
html;

}


function delete_relationships($relationships_id){
    global $_SC;
    $sql="DELETE FROM tbl_m_to_m WHERE id='$relationships_id'";
    $query=$_SC['db']->query($sql);
    if($query){
        echo "<script>alert('提示:删除成功');history.go(-1)</script>";
    }
}


function product_pic_url($product_id){
    global $_SC;
    $sql="select * from tbl_product_pic where product_id=".$product_id."";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    if($rs){
        return $rs;
    }else{
        return false;
    }
}


function product_file_url($product_id){
    global $_SC;
    $sql="select * from tbl_product_file where product_id=".$product_id."";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    if($rs){
        return $rs;
    }else{
        return false;
    }
}

function product_pdf_url($product_id){
    global $_SC;
    $sql="select * from tbl_product_pdf where product_id=".$product_id."";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    if($rs){
        return $rs;
    }else{
        return false;
    }
}

function curl_get_content($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}


function get_district($district_id){
    global $_SC;
    if(!empty($district_id)){
        $arr_tmp=explode(",",$district_id);
        $sql="select * from tbl_district";
        $query=$_SC['db']->query($sql);
        while($rs=$_SC['db']->fetch_array($query)){
            if(in_array($rs['district_id'],$arr_tmp)){
                $checked="checked";
            }else{
                $checked="";
            }

            echo <<<html
                 <div class="checkbox">
                      <label>
                        <input type="checkbox" value="{$rs['district_id']}" name="district[]" {$checked}>
                        {$rs['district']}
                      </label>
                      </div>
html;
            unset($checked);
            }

    }else{
        $arr_tmp=explode(",",$district_id);
        $sql="select * from tbl_district";
        $query=$_SC['db']->query($sql);
        while($rs=$_SC['db']->fetch_array($query)){
            echo <<<html
                 <div class="checkbox">
                      <label>
                        <input type="checkbox" value="{$rs['district_id']}" name="district[]">
                        {$rs['district']}
                      </label>
                      </div>
html;
            unset($checked);
        }
    }

}


function get_district_name($district_id){
    global $_SC;
    $arr_tmp=explode(",",$district_id);
    $tmp=array();
    if(is_array($arr_tmp)){
        foreach($arr_tmp as $v){
            $sql="select * from tbl_district where district_id=$v";

            $query=$_SC['db']->query($sql);
            $rs=$_SC['db']->fetch_array($query);
            $tmp[]=$rs['district'];
        }
        $tmp_district=implode(",",$tmp);
        return $tmp_district;
    }else{
        if(!empty($district_id)){
            $sql="select * from tbl_district where district_id=$district_id";
            $query=$_SC['db']->query($sql);
            $rs=$_SC['db']->fetch_array($query);
            $tmp=$rs['district'];
            return $tmp;
        }else{
            $tmp_district="";
            return $tmp_district;
        }
    }
}












