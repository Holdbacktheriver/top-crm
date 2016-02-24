<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 14-6-27
 * Time: 11:27
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
$acs = array('list','edit','addfrom','update','add');
$ac = (!empty($_GET['ac']) && in_array($_GET['ac'], $acs))?$_GET['ac']:'list';
switch ($ac){
    case 'list':
        commember_list($_GET['id'],$user,$user_id);
        break;
    case 'edit':
        commember_edit($_GET['id'],$user,$user_id);
        break;
    case 'update':
        if(!empty($_GET['id'])){
            $id=daddslashes($_GET['id']);
            $sql="update tbl_commember_info set name='".daddslashes($_POST['name'])."', sex='".daddslashes($_POST['sex'])."',department='".daddslashes($_POST['department'])."',title='".daddslashes($_POST['title'])."',relatives='".daddslashes($_POST['relatives'])."',tel='".daddslashes($_POST['tel'])."',phone='".daddslashes($_POST['phone'])."',mail='".daddslashes($_POST['mail'])."',remark='".daddslashes($_POST['remark'])."',company='".daddslashes($_POST['company'])."',company_type='".daddslashes($_POST['company_type'])."',province='".daddslashes($_POST['province'])."',city='".daddslashes($_POST['city'])."',district='".daddslashes($_POST['district'])."',address='".daddslashes($_POST['address'])."',zip_code='".daddslashes($_POST['zip_code'])."',company_tel_1='".daddslashes($_POST['company_tel_1'])."',company_tel_2='".daddslashes($_POST['company_tel_2'])."',website='".daddslashes($_POST['website'])."',company_remark='".daddslashes($_POST['company_remark'])."' where com_id='".$id."'";
            $query=$_SC['db']->query($sql);
            if($query){
                echo "<script>alert('提示:修改成功');location.href='index.php?do=commember&ac=list'</script>";
            }else{
                echo "<script>alert('提示:修改失败');history.go(-1)</script>";

            }
        }
        break;
    case 'addfrom':
        commember_from();
        break;
    case 'add':
        $sql="INSERT INTO `tbl_commember_info`(`name`, `sex`, `department`, `title`, `relatives`, `tel`, `phone`, `mail`, `remark`, `company`, `company_type`, `province`, `city`, `district`, `address`, `zip_code`, `company_tel_1`, `company_tel_2`, `website`, `company_remark`) VALUES ('".daddslashes($_POST['name'])."','".daddslashes($_POST['sex'])."','".daddslashes($_POST['department'])."','".daddslashes($_POST['title'])."','".daddslashes($_POST['relatives'])."','".daddslashes($_POST['tel'])."','".daddslashes($_POST['phone'])."','".daddslashes($_POST['mail'])."','".daddslashes($_POST['remark'])."','".daddslashes($_POST['company'])."','".daddslashes($_POST['company_type'])."','".daddslashes($_POST['province'])."','".daddslashes($_POST['city'])."','".daddslashes($_POST['district'])."','".daddslashes($_POST['address'])."','".daddslashes($_POST['zip_code'])."','".daddslashes($_POST['company_tel_1'])."','".daddslashes($_POST['company_tel_2'])."','".daddslashes($_POST['website'])."','".daddslashes($_POST['company_remark'])."')";
        $query=$_SC['db']->query($sql);
        if($query){
            echo "<script>alert('提示:新建成功');location.href='index.php?do=commember&ac=list'</script>";
        }else{
            echo "<script>alert('提示:新建失败');history.go(-1)</script>";
        }


}


function commember_from(){
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
        <div id="page-wrapper">
                  <ol class="breadcrumb">
                      <li><a href="index.php?do=commember&ac=list"><i class="icon-dashboard"></i> 公司客户</a></li>
                       <li> 新建客户</li>
                    </ol>
       <div class="row">
       <div class="col-lg-6">
            <form action="index.php?do=commember&ac=add" method="post">


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">姓名</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['name']}" name="name">
            </div>
            </div>


            <div class="form-group has-success">
            <label class="control-label">性别</label>
            <select class="form-control" name="sex">
            <option value="男" >男</option>
            <option value="男" >女</option>

            </select>
            </div>

            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">部门</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['department']}" name="department">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">职务</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['title']}" name="title">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">关系人</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['relatives']}" name="relatives">
            </div>
            </div>



            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">电话</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['tel']}" name="tel">
            </div>
            </div>




            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">手机</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['phone']}" name="phone">
            </div>
            </div>



            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">邮箱</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['mail']}" name="mail">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">备注</label>
            <textarea  class="form-control" rows="5" cols="" name="remark">{$rs['remark']}</textarea>
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">组织</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['company']}" name="company">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">组织类型</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['company_type']}" name="company_type">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">省</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['province']}" name="province">
            </div>
            </div>



            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">城市</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['city']}" name="city">
            </div>
            </div>



            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">地区</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['district']}" name="district">
            </div>
            </div>




            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">地址</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['address']}" name="address">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">邮编</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['zip_code']}" name="zip_code">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">电话号码1</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['company_tel_1']}" name="company_tel_1">
            </div>
            </div>



            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">电话号码2</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['company_tel_2']}" name="company_tel_2">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">website</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['website']}" name="website">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">组织备注</label>
            <textarea  class="form-control" rows="5" cols="" name="company_remark">{$rs['company_remark']}</textarea>
            </div>
            </div>


            <button type="submit" class="btn btn-default">提  交</button>
            <a href="index.php?do=commember&ac=list" class="btn btn-default">取 消</a>

            </form>


       </div>
       </div>
       </div>
html;
}


function commember_edit(){
    global $_SC;
    get_header();
    get_left_menu();
    $com_id=daddslashes($_GET['id']);
    $sql="select * from tbl_commember_info where com_id=$com_id";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    if($rs['sex']=="男"){
        $selected_1="selected";
        $selected_2="";
    }else{
        $selected_1="";
        $selected_2="selected";
    }

    echo <<<html
        <div id="page-wrapper">
                  <ol class="breadcrumb">
                      <li><a href="index.php?do=commember&ac=list"><i class="icon-dashboard"></i> 公司客户</a></li>
                       <li> 详细信息</li>

                  </ol>
       <div class="row">
       <div class="col-lg-6">
            <form action="index.php?do=commember&ac=update&id={$rs['com_id']}" method="post">


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">姓名</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['name']}" name="name">
            </div>
            </div>


            <div class="form-group has-success">
            <label class="control-label">性别</label>
            <select class="form-control" name="sex">
            <option value="男" {$selected_1}>男</option>
            <option value="女" {$selected_2}>女</option>

            </select>
            </div>

            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">部门</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['department']}" name="department">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">职务</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['title']}" name="title">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">关系人</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['relatives']}" name="relatives">
            </div>
            </div>



            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">电话</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['tel']}" name="tel">
            </div>
            </div>




            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">手机</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['phone']}" name="phone">
            </div>
            </div>



            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">邮箱</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['mail']}" name="mail">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">备注</label>
            <textarea  class="form-control" rows="5" cols="" name="remark">{$rs['remark']}</textarea>
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">组织</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['company']}" name="company">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">组织类型</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['company_type']}" name="company_type">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">省</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['province']}" name="province">
            </div>
            </div>



            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">城市</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['city']}" name="city">
            </div>
            </div>



            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">地区</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['district']}" name="district">
            </div>
            </div>




            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">地址</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['address']}" name="address">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">邮编</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['zip_code']}" name="zip_code">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">电话号码1</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['company_tel_1']}" name="company_tel_1">
            </div>
            </div>



            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">电话号码2</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['company_tel_2']}" name="company_tel_2">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">website</label>
            <input class="form-control" type="text" placeholder="" value="{$rs['website']}" name="website">
            </div>
            </div>


            <div class="form-group has-success">
            <div class="form-group">
            <label class="control-label" for="inputSuccess">组织备注</label>
            <textarea  class="form-control" rows="5" cols="" name="company_remark">{$rs['company_remark']}</textarea>
            </div>
            </div>


            <button type="submit" class="btn btn-default">提  交</button>
            <a href="index.php?do=commember&ac=list" class="btn btn-default">取 消</a>

            </form>


       </div>
       </div>
       </div>
html;
}




function commember_list(){
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
        <div id="page-wrapper">
                  <ol class="breadcrumb">
                      <li><a href="index.php?do=commember&ac=list"><i class="icon-dashboard"></i> 公司客户</a></li>
                  </ol>

                  <ol class="breadcrumb">
                  <div class="col-lg-12">
                  <a href="index.php?do=commember&ac=addfrom"><button type="button" class="btn btn-primary btn-1g btn-block" style="">客户登记</button></a>
                  </div>
                  </ol>


html;
    serach_from();
    echo <<<html
       <div class="row">
          <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped tablesorter">
                <thead>
                  <tr>
                    <th>姓名</th>
                    <th>性别</th>
                    <th>部门</th>
                    <th>职务 </th>
                    <th>关系人 </th>
                    <th>电话号码 </th>
                    <th>手机号码</th>
                    <th>E-mail </th>
                    <th>备注 </th>
                    <th>组织名称 </th>
                    <th>类型 </th>
                    <th>操作</th>
                  </tr>
                </thead>

html;

    if(!empty($_GET['keyword'])){
        $keyword=daddslashes($_GET['keyword']);
        $tmp_sql="and (name like '%".$keyword."%' or sex like '%".$keyword."%' or department like '%".$keyword."%' or title like '%".$keyword."%' or relatives like '%".$keyword."%' or tel like '%".$keyword."%' or phone like '%".$keyword."%' or mail like '%".$keyword."%' or remark like '%".$keyword."%' or company like '%".$keyword."%' or company_type like '%".$keyword."%' or province like '%".$keyword."%' or city like '%".$keyword."%' or district like '%".$keyword."%' or address like '%".$keyword."%' or zip_code like '%".$keyword."%' or company_tel_1 like '%".$keyword."%' or company_tel_2 like '%".$keyword."%' or website like '%".$keyword."%' or company_remark like '%".$keyword."%')";

    }else{
        $tmp_sql='';
    }


    $pageSize = 20;
    $totalCountsql = "select count(*) as t from tbl_commember_info where is_delete='0' $tmp_sql";
    $query_s = $_SC['db']->query($totalCountsql);
    $rs = $_SC['db']->fetch_array($query_s);
    $totalCount = $rs['t'];
    $pageUrl = './index.php?do=commember&ac=list&keyword='.$_GET['keyword'].'&page=';
    $sql = "select * from tbl_commember_info where  is_delete='0' $tmp_sql order by com_id desc limit " . (($_GET['page']- 1) * $pageSize) . ",$pageSize";
    $query = $_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
echo <<<html
    <tr>
    <td>{$rs['name']}</td>
    <td>{$rs['sex']}</td>
    <td>{$rs['department']}</td>
    <td>{$rs['title']}</td>
    <td>{$rs['relatives']}</td>
    <td>{$rs['tel']}</td>
    <td>{$rs['phone']}</td>
    <td>{$rs['mail']}</td>
    <td>{$rs['remark']}</td>
    <td>{$rs['company']}</td>
    <td>{$rs['company_type']}</td>
    <td><a href="index.php?do=commember&ac=edit&id={$rs['com_id']}">查看详细</a>   </td>
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



function serach_from(){
    echo <<<html
               <ol class="breadcrumb">
                <div class="col-lg-12">
                <form role="form" action="#" method="get" >
                   <table class="table table-bordered table-hover tablesorter">
                   <input type="hidden" name="do" value="commember">
                   <input type="hidden" name="ac" value="list">
                    <tr>
                    <th colspan="9" style="text-align: center">请输入搜索条件 </th>
                    </tr>
                   <tr>

                    <th colspan=""style="text-align: center">
                  <input class="form-control" name="keyword" value="{$_GET['keyword']}">
                  </th>
                  <th colspan="1"style="text-align: center">
                  <button type="submit" class="btn btn-primary btn-1g " style="padding: 5px 40px"><i class="icon-search"></i> 搜索</button>
                     </th>
                  </tr>
                </table>
                </form>
                  </div>
                  </ol>
html;
}


