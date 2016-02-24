<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-11-1
 * Time: 下午5:59
 * To change this template use File | Settings | File Templates.
 * 客户
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
$acs = array('follow','server_add','edit','delete','add','follow_add','update','update_server','delete_server','delete_relationships');
$ac = (!empty($_GET['ac']) && in_array($_GET['ac'], $acs))?$_GET['ac']:'edit';
switch ($ac){
    case 'follow':
        member_follow($_GET['id'],$user,$user_id);
        break;
    case 'server_add':
        server_add($_GET['member_id'],$user_id);
        break;
    case 'edit':
        member_edit($user,$user_id,$department_id,$power);
        break;
    case 'delete':
        member_delete($_GET['id'],$user);
        break;
    case 'add':
        member_add($user,$user_id,$department_id);
        break;
    case 'follow_add':
        follow_add($_GET['member_id'],$_GET['user_id']);
        break;
    case 'update':
        member_update($_GET['id'],$user);
        break;
    case 'update_server':
        update_server($_GET['server_id'],$_GET['member_id']);
        break;
    case 'delete_server':
        delete_server($_GET['server_id'],$_GET['member_id']);
        break;
    case 'delete_relationships':
        delete_relationships($_GET['relationships_id']);
        break;
}

function member_add($user,$user_id,$department_id){
    $op_type="新建客户";
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=member&ac=edit"><i class="icon-dashboard"></i> 客户管理</a></li>
              <li class="active"><i class="icon-edit"></i> 客户登记</li>
          </ol>
        <div class="row">
          <div class="col-lg-6">
            <form role="form" action="index.php?do=member&ac=add" method="post" enctype="multipart/form-data">
                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">姓名</label>
                        <input class="form-control" placeholder="" name="name">
                      </div>
                    </div>


                  <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">性别</label>
                    <label class="radio-inline">
                      <input type="radio" name="sex" id="optionsRadiosInline1" value="男" checked> 男
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="sex" id="optionsRadiosInline2" value="女"> 女
                    </label>
                  </div>


              <div class="form-group has-success">
                <label class="control-label">客户类型</label>
                <select class="form-control" name="in_class">
                  <option value="潜在客户" selected>潜在客户</option>
                  <option value="供应商" >供应商</option>
                  <option value="臻客会员">臻客会员</option>
                  <option value="教育客户">教育客户</option>
                  <option value="其他" >其他</option>
                </select>
              </div>



              <div class="form-group has-success">
                <label class="control-label">标签</label>
                <select class="form-control" name="label">
                  <option value="传媒">传媒</option>
                  <option value="金融">金融</option>
                  <option value="长江同学">长江同学</option>
                  <option value="其他" >其他</option>
                </select>
              </div>



              <div class="form-group has-success">
                <label class="control-label">注意事项</label>
                <select class="form-control" name="tips">
                  <option value="重点客户">重点客户</option>
                  <option value="已用过产品客户">已用过产品客户</option>
                  <option value="其他" >其他</option>
                </select>
              </div>





                 <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">会员卡号</label>
                        <input class="form-control" placeholder="会员客户请输入" name="vip_id">
                      </div>
                    </div>



                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">公司</label>
                        <input class="form-control" placeholder="" name="corporation">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">职务</label>
                        <input class="form-control" placeholder="" name="title">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">银行账户</label>
                        <input class="form-control" placeholder="" name="bank_account">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">年收入/身价</label>
                        <input class="form-control" placeholder="" name="annual_income">
                      </div>
                    </div>


                  <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">婚姻状况</label>
                    <label class="radio-inline">
                      <input type="radio" name="marital_status" id="optionsRadiosInline1" value="单身" checked> 单身
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="marital_status" id="optionsRadiosInline2" value="已婚"> 已婚
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="marital_status" id="optionsRadiosInline3" value="离异"> 离异
                    </label>
                  </div>

                  <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">是否有孩子</label>
                    <label class="radio-inline">
                      <input type="radio" name="is_children" id="optionsRadiosInline4" value="是"> 是
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="is_children" id="optionsRadiosInline5" value="否" checked> 否
                    </label>
                  </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">网址</label>
                        <input class="form-control" placeholder="" name="website">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">国籍</label>
                        <input class="form-control" placeholder="" name="nationality">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">城市</label>
                        <input class="form-control" placeholder="" name="city">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">护照号码</label>
                        <input class="form-control" placeholder="" name="passport_num">
                      </div>
                    </div>


                <div class="form-group has-success">
                   <div class="form-group">
                      <label label class="control-label" for="inputSuccess">护照照片</label>
                     <input type="file" name="passport_num_pic">
                    </div>
                  </div>


                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">身份证号码</label>
                        <input class="form-control" placeholder="" name="card_id">
                      </div>
                    </div>

                <div class="form-group has-success">
                 <div class="form-group">
                     <label  class="control-label" for="inputSuccess">身份证照片</label>
                     <input type="file" name="card_id_pic">
                    </div>
                  </div>




                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">兴趣爱好</label>
                        <input class="form-control" placeholder="" name="hobbies">
                      </div>
                    </div>






                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">手机</label>
                        <input class="form-control" placeholder="" name="mobile">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">座机（公司/家）</label>
                        <input class="form-control" placeholder="" name="tel">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">邮箱</label>
                        <input class="form-control" placeholder="" name="email">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">公司地址</label>
                        <input class="form-control" placeholder="" name="company_address">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">家庭地址</label>
                        <input class="form-control" placeholder="" name="home_address">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">传真</label>
                        <input class="form-control" placeholder="" name="fax">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">其他</label>
                        <input class="form-control" placeholder="" name="other">
                      </div>
                    </div>



              <div class="form-group has-success">
                <label class="control-label">负责人</label>
                <div class="checkbox">
html;
    $sql="select * from tbl_user";
    $query=$_SC['db']->query($sql);
    while($row=$_SC['db']->fetch_array($query)){
    echo <<<html
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="{$row['user_id']}" name="user_f[]">
                    {$row['name']}
                  </label>
                </div>

html;
    }





    echo <<<html
              </div>
              <div class="form-group has-success">
                  <div class="form-group">
                    <label class="control-label">负责人员备注</label>
                    <textarea class="form-control" rows="3" name="remark_user"></textarea>
                  </div>
                </div>


                <div class="form-group has-success">
                  <div class="form-group">
                    <label class="control-label">备注</label>
                    <textarea class="form-control" rows="3" name="remark"></textarea>
                  </div>
                </div>

              <button type="submit" class="btn btn-default" name="member_add">提  交</button>
              <button type="reset" class="btn btn-default">复 位</button>

             </form>

           </div>
          </div>
       </div>
    </div>
html;


    if(isset($_POST['member_add'])){
        if(empty($_POST['name'])){
            echo "<script>alert('警告:客户姓名不能为空');history.go(-1)</script>";
        }else{
            if(empty($_POST['mobile'])&&empty($_POST['tel'])){
                echo "<script>alert('警告:客户联系电话不能为空');history.go(-1)</script>";
            }else{
                 $sql="insert into tbl_member_info (name,sex,in_class,corporation,title,bank_account,annual_income,marital_status,is_children,website,nationality,city,passport_num,card_id,hobbies,mobile,tel,email,company_address,home_address,fax,other,remark,user_id,department_id,create_time,label,vip_id,tips) value ('".daddslashes($_POST['name'])."','".daddslashes($_POST['sex'])."','".daddslashes($_POST['in_class'])."','".daddslashes($_POST['corporation'])."','".daddslashes($_POST['title'])."','".daddslashes($_POST['bank_account'])."','".daddslashes($_POST['annual_income'])."','".daddslashes($_POST['marital_status'])."','".daddslashes($_POST['is_children'])."','".daddslashes($_POST['website'])."','".daddslashes($_POST['nationality'])."','".daddslashes($_POST['city'])."','".daddslashes($_POST['passport_num'])."','".daddslashes($_POST['card_id'])."','".daddslashes($_POST['hobbies'])."','".daddslashes($_POST['mobile'])."','".daddslashes($_POST['tel'])."','".daddslashes($_POST['email'])."','".daddslashes($_POST['company_address'])."','".daddslashes($_POST['home_address'])."','".daddslashes($_POST['fax'])."','".daddslashes($_POST['other'])."','".daddslashes($_POST['remark'])."','".daddslashes($user_id)."','".daddslashes($department_id)."',".time().",'".daddslashes($_POST['label'])."','".daddslashes($_POST['vip_id'])."','".daddslashes($_POST['tips'])."')";
                 $query=$_SC['db']->query($sql);
                 $id=$_SC['db']->insert_id();
                 $sql=" insert into tbl_op_user (op_user,op_type,op_id,op_time) value ('".daddslashes($user)."','".daddslashes($op_type)."',".$id.",".time().")";
                 $_SC['db']->query($sql);

//处理护照图片
                if($_FILES['passport_num_pic']['error']=='0'){
                    $member_info=member_info($id);
                    $pic_type_array=array('bmp','jpg','jpeg','png','gif');
                    //获取图片后缀名
                    $pic_type_name=pathinfo($_FILES['passport_num_pic']['name'], PATHINFO_EXTENSION);
                    if(in_array($pic_type_name,$pic_type_array)){
                        $time=time();
                        $tmp = str_replace('\\\\', '\\', $_FILES['passport_num_pic']['tmp_name']);
                        $move=move_uploaded_file($tmp,'./image/pt/'.date(Ymd).$time.'.'.$pic_type_name);
                        if($move){
                            $url="image/pt/".date(Ymd).$time.'.'.$pic_type_name;
                            $p_pic_info=pic_info($member_info['p_pic_id']);
                            $sql="UPDATE tbl_member_pic SET pic_url='".daddslashes($url)."', pic_name='".daddslashes($_FILES['passport_num_pic']['name'])."' where pic_id='".$member_info['p_pic_id']."'";
                            $query=$_SC['db']->query($sql);
                            $sql="insert into tbl_member_pic (pic_url,pic_name) value ('".daddslashes($url)."','".daddslashes($_FILES['passport_num_pic']['name'])."')";
                            $query=$_SC['db']->query($sql);
                            $p_pic_id=$_SC['db']->insert_id();
                            $sql="UPDATE tbl_member_info set p_pic_id='.$p_pic_id.' where id='".$id."'";
                            $_SC['db']->query($sql);

                        }else{
                            echo "<script>alert('提示:图片上传失败');history.go(-1)</script>";
                        }
                    }else{
                        echo "<script>alert('提示:图片文件类型错误');history.go(-1)</script>";
                    }
                }

//处理身份证图片
                if($_FILES['card_id_pic']['error']=='0'){
                    $member_info=member_info($id);
                    $pic_type_array=array('bmp','jpg','jpeg','png','gif');
                    //获取图片后缀名
                    $pic_type_name=pathinfo($_FILES['card_id_pic']['name'], PATHINFO_EXTENSION);
                    if(in_array($pic_type_name,$pic_type_array)){
                        $time=time();
                        $tmp = str_replace('\\\\', '\\', $_FILES['card_id_pic']['tmp_name']);
                        $move=move_uploaded_file($tmp,'./image/c_id/'.date(Ymd).$time.'.'.$pic_type_name);
                        if($move){
                            $url="image/c_id/".date(Ymd).$time.'.'.$pic_type_name;
                            $sql="insert into tbl_member_pic (pic_url,pic_name) value ('".daddslashes($url)."','".daddslashes($_FILES['card_id_pic']['name'])."')";
                            $query=$_SC['db']->query($sql);
                            $c_pic_id=$_SC['db']->insert_id();
                            $sql="UPDATE tbl_member_info set c_pic_id='.$c_pic_id.' where id='".$id."'";
                            $_SC['db']->query($sql);
                        }else{
                            echo "<script>alert('提示:图片上传失败');history.go(-1)</script>";
                        }
                    }else{
                        echo "<script>alert('提示:图片文件类型错误');history.go(-1)</script>";
                    }
                }
//写入客户负责人
                 if(!empty($_POST['user_f'])){
                        foreach($_POST['user_f'] as $key=>$value){
                            $sql=" insert into tbl_member_user (member_id,user_id,remark_user) value (".$id.",".$value.",'".daddslashes($_POST['remark_user'])."')";
                            $query=$_SC['db']->query($sql);
                        }
                 }
                if($query){
                     echo "<script>alert('提示:创建成功');location.href='index.php?do=member&ac=edit';</script>";
                }
            }

        }
    }
}




function member_manage(){
    get_header();
    get_left_menu();
    echo <<<html
    <div id="page-wrapper">
    <div class="">
            <div class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              欢迎登陆 <a class="alert-link" href="http://#.com">臻客</a>! .
            </div>
    </div>
    <div class="col-lg-6 col-md-12"

                <p>
              <a href="index.php?do=member&ac=add"><button type="button" class="btn btn-default btn-1g btn-block" style="height:500px "><h1>客户登记</h1></button></a>
            </p>
    </div>
        <div class="col-lg-6 col-md-9">

                <p>
              <a href="index.php?do=member&ac=edit"><button type="button" class="btn btn-default btn-lg btn-block" style="height:500px "><h1>客户更新</h1></button></a>
            </p>
    </div>
    </div>
html;

    get_footer();

    echo <<<html
    </body>
</html>
html;
}



function member_edit($user,$user_id,$department_id,$power){
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
        <div id="page-wrapper">
              <div class="">
                  <ol class="breadcrumb">
                      <li><a href="index.php?do=member&ac=edit"><i class="icon-dashboard"></i> 客户列表</a></li>
                      <li class="active"><i class="icon-edit"></i> 客户管理</li>
                  </ol>
                  <ol class="breadcrumb">
                  <div class="col-lg-12">
                  <a href="index.php?do=member&ac=add"><button type="button" class="btn btn-primary btn-1g btn-block" style="">客户登记</button></a>
                  </div>
                  </ol>
html;
    search_member_from();
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

    if(isset($_GET)){
        if(isset($_GET['search'])){
                if(!empty($_GET['sex'])){
                    $sex_search="and sex='".daddslashes($_GET['sex'])."'";
                }
                if(!empty($_GET['marital_status'])){
                    $marital_status_search="and marital_status='".daddslashes($_GET['marital_status'])."'";
                }
                if(!empty($_GET['is_children'])){
                    $is_children_search="and is_children='".daddslashes($_GET['is_children'])."'";
                }
                if(!empty($_GET['in_class'])){
                    $in_class_search="and in_class='".daddslashes($_GET['in_class'])."'";
                }
                if(!empty($_GET['label'])){
                    $label_search="and label='".daddslashes($_GET['label'])."'";
                }
                if(!empty($_GET['tips'])){
                    $tips_search="and tips='".daddslashes($_GET['tips'])."'";
                }
                $pageSize = 15;
                $sql = "SELECT * FROM tbl_member_info  WHERE  is_delete='0' $sex_search $marital_status_search $is_children_search $in_class_search $label_search $tips_search LIMIT " . (($_GET['page']- 1) * $pageSize) . ", $pageSize ";
                $totalCountsql = "SELECT COUNT( * ) as t FROM tbl_member_info  WHERE  is_delete='0' $sex_search $marital_status_search $is_children_search $in_class_search $label_search $tips_search";
                $pageUrl = "./index.php?do=member&ac=edit&page=";

      }else{
            $pageSize = 15;
            $keyword=$_GET['keyword'];
            $totalCountsql = "SELECT COUNT( * ) as t FROM tbl_member_info WHERE  is_delete='0' and( name like '%".$keyword."%'   or sex like '%".$keyword."%' or corporation like '%".$keyword."%' or title like '%".$keyword."%' or marital_status like '%".$keyword."%' or city like '%".$keyword."%' or mobile like '%".$keyword."%' or tel like '%".$keyword."%' or in_class) like '%".$keyword."%' or label like '%".$keyword."%'";
            $pageUrl = "./index.php?do=member&ac=edit&keyword=$keyword&page=";
            $sql = "SELECT * FROM tbl_member_info WHERE  is_delete='0' and(name like '%".$keyword."%'   or sex like '%".$keyword."%' or corporation like '%".$keyword."%' or title like '%".$keyword."%' or marital_status like '%".$keyword."%' or city like '%".$keyword."%' or mobile like '%".$keyword."%' or tel like '%".$keyword."%' or in_class like '%".$keyword."%' or label like '%".$keyword."%')  LIMIT " . (($_GET['page']- 1) * $pageSize) . ", $pageSize ";

        }
    }else{
        $totalCountsql = "SELECT COUNT( * ) as t FROM tbl_member_info WHERE is_delete='0'";
        $sql = "SELECT * FROM tbl_member_info  WHERE  is_delete='0'  LIMIT " . (($_GET['page']- 1) * $pageSize) . ", $pageSize ";
        $pageUrl = './index.php?do=member&ac=edit&page=';
    }
            $pageSize = 15;
            $query = $_SC['db']->query($totalCountsql);
            $rs = $_SC['db']->fetch_array($query);
            $totalCount = $rs['t'];
            $query = $_SC['db']->query($sql);
            $authority_info=authority_info($user_id);
            while($row=$_SC['db']->fetch_array($query)){
                if($authority_info['mange_all_m']==1)
                {
                    $user_arr=member_responsible($row['id']);
                }else{
                    if($authority_info['mange_part_m']==1)
                    {
                        $member_user_arr=member_user_arr($user_id);
                        $totalCount=count($member_user_arr);
                        $user_arr=member_responsible($row['id']);
                        if(!in_array($user_id,$user_arr)){
                            continue;
                        }
                    }
                    if($authority_info['mange_edu_all']==1){
                        $member_edu_arr=member_edu_arr();
                        $totalCount=count($member_edu_arr);
                        if(!in_array($row['id'],$member_edu_arr)){
                            continue;
                        }
                    }
                }



                echo <<<html
                      <tr>
                        <td>{$row['name']}</td>
                        <td>{$row['sex']}</td>
                        <td>{$row['corporation']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['marital_status']}/{$row['is_children']}</td>
                        <td>{$row['city']}</td>
                        <td>{$row['mobile']}</td>
                        <td>{$row['tel']}</td>
                        <td>{$row['in_class']}</td>
                        <td>{$row['label']}</td>
                        <td>
html;
                member_responsible_name_arr($user_arr);
                echo <<<html
                        </td>
                        <td>{$row['remark']}</td>
                        <td>
                        <a href="index.php?do=member&ac=follow&id={$row['id']}"><button type="button" class="btn btn-primary btn-xs" >详细信息</button></a>
                        <a href="index.php?do=edu&member_id={$row['id']}"><button type="button" class="btn btn-primary btn-xs" >教育服务</button></a>
                        <a href="index.php?do=member&ac=update&id={$row['id']}"><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
                        <a href="index.php?do=member&ac=delete&id={$row['id']}" onclick='return CommandConfirm();'"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
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
                   </div>
                  </div>
                 </div>
               </div>
            </div>
html;

}



function member_update($id,$user){
    $op_type="修改客户信息";
    global $_SC;
    if(isset($id)){
        get_header();
        get_left_menu();
        $sql="select * from tbl_member_info where id='".$id."'";
        $query=$_SC['db']->query($sql);
        $row=$_SC['db']->fetch_array($query);

//=====================================================判断客户婚姻默认值
        if($row['sex']=="男"){
            $checked_sex_a="checked";
        }else{
            $checked_sex_b="checked";
        }

//=====================================================判断客户性别默认值
        if($row['marital_status']=="单身")
            $marital_status_a="checked";
        elseif($row['marital_status']=="已婚")
            $marital_status_b="checked";
        elseif($row['marital_status']=="离异")
            $marital_status_c="checked";




//=====================================================判断客户是否有小孩默认值
        if($row['is_children']=="是"){
            $is_children_a="checked";
        }else{
            $is_children_b="checked";
        }
//=====================================================判断客户类型默认值
        if($row['in_class']=="潜在客户")
            $selected_a_in_class="selected";
        elseif($row['in_class']=="供应商")
            $selected_b_in_class="selected";
        elseif($row['in_class']=="臻客会员")
            $selected_c_in_class="selected";
        elseif($row['in_class']=="其他")
            $selected_d_in_class="selected";
        elseif($row['in_class']=="教育客户")
            $selected_e_in_class="selected";


//=====================================================判断客户标签默认值
        if($row['label']=="传媒")
            $selected_a_label="selected";
        elseif($row['label']=="金融")
            $selected_b_label="selected";
        elseif($row['label']=="长江同学")
            $selected_c_label="selected";
        elseif($row['label']=="其他")
            $selected_d_label="selected";
//=====================================================判断客户标签默认值
        if($row['tips']=="重点客户")
            $selected_a_tips="selected";
        elseif($row['tips']=="已用过产品客户")
            $selected_b_tips="selected";





        echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=member&ac=edit"><i class="icon-dashboard"></i> 客户管理</a></li>
              <li class="active"><i class="icon-edit"></i> 客户信息修改</li>
          </ol>
        <div class="row">
          <div class="col-lg-6">
            <form role="form" action="index.php?do=member&ac=update&id={$row['id']}" method="post" enctype="multipart/form-data">
                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">姓名</label>
                        <input class="form-control" value="{$row['name']}" name="name">
                      </div>
                    </div>


                  <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">性别</label>
                    <label class="radio-inline">
                      <input type="radio" name="sex" id="optionsRadiosInline1" value="男" {$checked_sex_a}> 男
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="sex" id="optionsRadiosInline2" value="女" {$checked_sex_b}> 女
                    </label>
                  </div>


              <div class="form-group has-success">
                <label class="control-label">客户类型</label>
                <select class="form-control" name="in_class">
                  <option value="潜在客户" {$selected_a_in_class}>潜在客户</option>
                  <option value="供应商" {$selected_b_in_class}>供应商</option>
                  <option value="臻客会员" {$selected_c_in_class}>臻客会员</option>
                  <option value="教育客户" {$selected_e_in_class} >教育客户</option>
                  <option value="其他" {$selected_d_in_class}>其他</option>
                </select>
              </div>

              <div class="form-group has-success">
                <label class="control-label">标签</label>
                <select class="form-control" name="label">
                  <option value="传媒" {$selected_a_label}>传媒</option>
                  <option value="金融" {$selected_b_label}>金融</option>
                  <option value="长江同学" {$selected_c_label}>长江同学</option>
                  <option value="其他" {$selected_d_label}>其他</option>
                </select>
              </div>

              <div class="form-group has-success">
                <label class="control-label">注意事项</label>
                <select class="form-control" name="tips">
                  <option value="重点客户" {$selected_a_tips}>重点客户</option>
                  <option value="已用过产品客户" {$selected_b_tips}>已用过产品客户</option>
                </select>
              </div>





              <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">会员卡号</label>
                        <input class="form-control" value="{$row['vip_id']}" name="vip_id">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">公司</label>
                        <input class="form-control" value="{$row['corporation']}" name="corporation">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">职务</label>
                        <input class="form-control" value="{$row['title']}" name="title">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">银行账户</label>
                        <input class="form-control" value="{$row['bank_account']}" name="bank_account">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">年收入/身价</label>
                        <input class="form-control" value="{$row['annual_income']}" name="annual_income">
                      </div>
                    </div>


                  <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">婚姻状况</label>
                    <label class="radio-inline">
                      <input type="radio" name="marital_status" id="optionsRadiosInline1" value="单身" {$marital_status_a}> 单身
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="marital_status" id="optionsRadiosInline2" value="已婚" {$marital_status_b}> 已婚
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="marital_status" id="optionsRadiosInline3" value="离异" {$marital_status_c}> 离异
                    </label>
                  </div>

                  <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">是否有孩子</label>
                    <label class="radio-inline">
                      <input type="radio" name="is_children" id="optionsRadiosInline4" value="是" {$is_children_a}> 是
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="is_children" id="optionsRadiosInline5" value="否" {$is_children_b}> 否
                    </label>
                  </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">网址</label>
                        <input class="form-control" value="{$row['website']}" name="website">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">国籍</label>
                        <input class="form-control" value="{$row['nationality']}" name="nationality">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">城市</label>
                        <input class="form-control" value="{$row['city']}" name="city">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">护照号码</label>
                        <input class="form-control" value="{$row['passport_num']}" name="passport_num">
                      </div>
                    </div>



                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">身份证号码</label>
                        <input class="form-control" value="{$row['card_id']}" name="card_id">
                      </div>
                    </div>
html;
        $member_info=member_info($id);
        $p=pic_info($member_info['p_pic_id']);
        $c=pic_info($member_info['c_pic_id']);
        echo <<<html
        <div class="row">
          <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter">
              <tr>
                  <td>
                     <div class="form-group has-success">
                     <div class="form-group">
                         <label label class="control-label" for="inputSuccess">如需更改请上传新身份证图片</label>
                         <input type="file" name="passport_num_pic">
                        </div>
                      </div>
                  </td>
                  <td>
                     <div class="form-group has-success">
                       <div class="form-group">
                          <label label class="control-label" for="inputSuccess">如需更改请上传新护照图片</label>
                         <input type="file" name="card_id_pic">
                        </div>
                      </div>
                  </td>
              </tr>
              <tr>
              <td>护照</td><td>身份证</td>
              </tr>
              <tr>
              <td><img src="{$p['pic_url']}" width="500px"  title="{$p['pic_name']}"></td>
              <td><img src="{$c['pic_url']}" width="500px"  title="{$c['pic_name']}"></td>
              </tr>
              </table>
             </div>
       </div>
    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">兴趣爱好</label>
                        <input class="form-control" value="{$row['hobbies']}" name="hobbies">
                      </div>
                    </div>


                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">手机</label>
                        <input class="form-control" value="{$row['mobile']}" name="mobile">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">座机（公司/家）</label>
                        <input class="form-control" value="{$row['tel']}" name="tel">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">邮箱</label>
                        <input class="form-control" value="{$row['email']}" name="email">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">公司地址</label>
                        <input class="form-control" value="{$row['company_address']}" name="company_address">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">家庭地址</label>
                        <input class="form-control" value="{$row['home_address']}" name="home_address">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">传真</label>
                        <input class="form-control" value="{$row['fax']}" name="fax">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">其他</label>
                        <input class="form-control" value="{$row['other']}" name="other">
                      </div>
                    </div>





                <div class="form-group has-success">
                  <div class="form-group">
                    <label class="control-label" for="inputSuccess"> 备注</label>
                    <textarea class="form-control" rows="3" name="remark" value="{$row['remark']}"></textarea>
                  </div>
                  </div>

              <div class="form-group has-success">
                <label class="control-label">负责人</label>
                <div class="checkbox">
html;
        $sql="select * from tbl_user";
        $query=$_SC['db']->query($sql);
        while($row=$_SC['db']->fetch_array($query)){
            $sql="select * from tbl_member_user where  user_id=".$row['user_id']." and member_id=".$id." ";
            $row_tmp=$_SC['db']->fetch_array($_SC['db']->query($sql));
            if($row_tmp){
                $checked="checked";
            }else{
                $checked="";
            }
            echo <<<html
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="{$row['user_id']}" name="user_f[]" {$checked}>
                    {$row['name']}
                  </label>

                </div>

html;
        }

        echo <<<html



              <button type="submit" class="btn btn-default" name="member_update">提  交</button>
              <button type="reset" class="btn btn-default">复 位</button>

             </form>

           </div>
          </div>
       </div>
    </div>
html;

    }else{
        echo "<script>alert('警告:非法参数');history.go(-1)</script>";
    }
    if(isset($_POST['member_update'])){
        if(!empty($_POST['name'])){
            $sql="UPDATE `tbl_member_info` SET `name` ='".daddslashes($_POST['name'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['sex'])){
            $sql="UPDATE `tbl_member_info` SET `sex` ='".daddslashes($_POST['sex'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['in_class'])){
            $sql="UPDATE `tbl_member_info` SET `in_class` ='".daddslashes($_POST['in_class'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['vip_id'])){
            $sql="UPDATE `tbl_member_info` SET `vip_id` ='".daddslashes($_POST['vip_id'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['label'])){
            $sql="UPDATE `tbl_member_info` SET `label` ='".daddslashes($_POST['label'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['tips'])){
            $sql="UPDATE `tbl_member_info` SET `tips` ='".daddslashes($_POST['tips'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['corporation'])){
            $sql="UPDATE `tbl_member_info` SET `corporation` ='".daddslashes($_POST['corporation'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['title'])){
            $sql="UPDATE `tbl_member_info` SET `title` ='".daddslashes($_POST['title'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['bank_account'])){
            $sql="UPDATE `tbl_member_info` SET `bank_account` ='".daddslashes($_POST['bank_account'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['annual_income'])){
            $sql="UPDATE `tbl_member_info` SET `annual_income` ='".daddslashes($_POST['annual_income'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['marital_status'])){
            $sql="UPDATE `tbl_member_info` SET `marital_status` ='".daddslashes($_POST['marital_status'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['is_children'])){
            $sql="UPDATE `tbl_member_info` SET `is_children` ='".daddslashes($_POST['is_children'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['website'])){
            $sql="UPDATE `tbl_member_info` SET `website` ='".daddslashes($_POST['website'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['nationality'])){
            $sql="UPDATE `tbl_member_info` SET `nationality` ='".daddslashes($_POST['nationality'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['city'])){
            $sql="UPDATE `tbl_member_info` SET `city` ='".daddslashes($_POST['city'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['passport_num'])){
            $sql="UPDATE `tbl_member_info` SET `passport_num` ='".daddslashes($_POST['passport_num'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['card_id'])){
            $sql="UPDATE `tbl_member_info` SET `card_id` ='".daddslashes($_POST['card_id'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['marital'])){
            $sql="UPDATE `tbl_member_info` SET `marital` ='".daddslashes($_POST['marital'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['hobbies'])){
            $sql="UPDATE `tbl_member_info` SET `hobbies` ='".daddslashes($_POST['hobbies'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['mobile'])){
            $sql="UPDATE `tbl_member_info` SET `mobile` ='".daddslashes($_POST['mobile'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['tel'])){
            $sql="UPDATE `tbl_member_info` SET `tel` ='".daddslashes($_POST['tel'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['email'])){
            $sql="UPDATE `tbl_member_info` SET `email` ='".daddslashes($_POST['email'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['company_address'])){
            $sql="UPDATE `tbl_member_info` SET `company_address` ='".daddslashes($_POST['company_address'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['home_address'])){
            $sql="UPDATE `tbl_member_info` SET `home_address` ='".daddslashes($_POST['home_address'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['fax'])){
            $sql="UPDATE `tbl_member_info` SET `fax` ='".daddslashes($_POST['fax'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['other'])){
            $sql="UPDATE `tbl_member_info` SET `other` ='".daddslashes($_POST['other'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['label'])){
            $sql="UPDATE `tbl_member_info` SET `label` ='".daddslashes($_POST['label'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['remark'])){
            $sql="UPDATE `tbl_member_info` SET `remark` ='".daddslashes($_POST['remark'])."' WHERE `id` =$id ";
            $_SC['db']->query($sql);
        }

            $sql="delete from tbl_member_user where member_id=".$id."";
            $_SC['db']->query($sql);
            foreach($_POST['user_f'] as $key=>$value){
                $sql=" insert into tbl_member_user (member_id,user_id) value (".$id.",".$value.")";
                $query=$_SC['db']->query($sql);
            }



//处理护照图片
        if($_FILES['passport_num_pic']['error']=='0'){
            $member_info=member_info($id);
            $pic_type_array=array('bmp','jpg','jpeg','png','gif');
            //获取图片后缀名
            $pic_type_name=pathinfo($_FILES['passport_num_pic']['name'], PATHINFO_EXTENSION);
            if(in_array($pic_type_name,$pic_type_array)){
                $time=time();
                $tmp = str_replace('\\\\', '\\', $_FILES['passport_num_pic']['tmp_name']);
                $move=move_uploaded_file($tmp,'./image/pt/'.date(Ymd).$time.'.'.$pic_type_name);
                if($move){
                    $url="image/pt/".date(Ymd).$time.'.'.$pic_type_name;
                    if($member_info['p_pic_id']>0){
                        $p_pic_info=pic_info($member_info['p_pic_id']);
                        $sql="UPDATE tbl_member_pic SET pic_url='".daddslashes($url)."', pic_name='".daddslashes($_FILES['passport_num_pic']['name'])."' where pic_id='".$member_info['p_pic_id']."'";
                        $query=$_SC['db']->query($sql);
                        if (file_exists($p_pic_info['pic_url'])) {
                            unlink($p_pic_info['pic_url']);
                        }
                    }else{
                        $sql="insert into tbl_member_pic (pic_url,pic_name) value ('".daddslashes($url)."','".daddslashes($_FILES['passport_num_pic']['name'])."')";
                        $query=$_SC['db']->query($sql);
                        $p_pic_id=$_SC['db']->insert_id();
                        $sql="UPDATE tbl_member_info set p_pic_id='.$p_pic_id.' where id='".$id."'";
                        $_SC['db']->query($sql);
                    }
                }else{
                    echo "<script>alert('提示:图片上传失败');history.go(-1)</script>";
                }
            }else{
                echo "<script>alert('提示:图片文件类型错误');history.go(-1)</script>";
            }
        }


//处理身份证图片
       if($_FILES['card_id_pic']['error']=='0'){
            $member_info=member_info($id);
            $pic_type_array=array('bmp','jpg','jpeg','png','gif');
            //获取图片后缀名
            $pic_type_name=pathinfo($_FILES['card_id_pic']['name'], PATHINFO_EXTENSION);
            if(in_array($pic_type_name,$pic_type_array)){
                $time=time();
                $tmp = str_replace('\\\\', '\\', $_FILES['card_id_pic']['tmp_name']);
                $move=move_uploaded_file($tmp,'./image/c_id/'.date(Ymd).$time.'.'.$pic_type_name);
                if($move){
                    $url="image/c_id/".date(Ymd).$time.'.'.$pic_type_name;
                    if($member_info['c_pic_id']>0){
                        $c_pic_info=pic_info($member_info['c_pic_id']);
                        $sql="UPDATE tbl_member_pic SET pic_url='".daddslashes($url)."', pic_name='".daddslashes($_FILES['card_id_pic']['name'])."' where pic_id='".$member_info['c_pic_id']."'";
                        $query=$_SC['db']->query($sql);
                        if (file_exists($c_pic_info['pic_url'])) {
                            unlink($c_pic_info['pic_url']);
                        }
                    }else{
                        $sql="insert into tbl_member_pic (pic_url,pic_name) value ('".daddslashes($url)."','".daddslashes($_FILES['card_id_pic']['name'])."')";
                        $query=$_SC['db']->query($sql);
                        $c_pic_id=$_SC['db']->insert_id();
                        $sql="UPDATE tbl_member_info set c_pic_id='.$c_pic_id.' where id='".$id."'";
                        $_SC['db']->query($sql);
                    }
                }else{
                    echo "<script>alert('提示:图片上传失败');history.go(-1)</script>";
                }
            }else{
                echo "<script>alert('提示:图片文件类型错误');history.go(-1)</script>";
            }
        }







        $sql=" insert into tbl_op_user (op_user,op_type,op_id,op_time) value ('".daddslashes($user)."','".daddslashes($op_type)."',".$id.",".time().")";
        $query=$_SC['db']->query($sql);

        if($query){
            echo "<script>alert('提示:更新完成');location.href='index.php?do=member&ac=edit';</script>";

        }
    }
}




function member_view($id){
    global $_SC;
    if(isset($id)){
        get_header();
        get_left_menu();
        $sql="select * from tbl_member_info where id='".$id."'";
        $query=$_SC['db']->query($sql);
        $row=$_SC['db']->fetch_array($query);
//=====================================================判断客户婚姻默认值
        if($row['sex']=="男"){
            $checked_sex_a="checked";
        }else{
            $checked_sex_b="checked";
        }

//=====================================================判断客户性别默认值
        if($row['marital_status']=="单身")
            $marital_status_a="checked";
        elseif($row['marital_status']=="已婚")
            $marital_status_b="checked";
        elseif($row['marital_status']=="离异")
            $marital_status_c="checked";




//=====================================================判断客户是否有小孩默认值
        if($row['is_children']=="是"){
            $is_children_a="checked";
        }else{
            $is_children_b="checked";
        }
//=====================================================判断客户类型默认值
        if($row['in_class']=="潜在客户")
            $selected_a="selected";
        elseif($row['in_class']=="供应商")
            $selected_b="selected";
        elseif($row['in_class']=="臻客会员")
            $selected_c="selected";
        elseif($row['in_class']=="传媒")
            $selected_d="selected";
        elseif($row['in_class']=="金融")
            $selected_e="selected";
        elseif($row['in_class']=="其他")
            $selected_f="selected";
//        $sql="select * from tbl_picture_pic where member_id=".$member_id."";
//        $query=$_SC['db']->query($sql);
//        $url_arr=$_SC['db']->fetch_array($query);
//        $url=$url_arr['url'];
        echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=member&ac=edit"><i class="icon-dashboard"></i> 客户管理</a></li>
              <li class="active"><i class="icon-edit"></i> 客户登记</li>
          </ol>
        <div class="row">

          <div class="col-lg-6">
            <form role="form" action="index.php?do=member&ac=update&id={$row['id']}" method="post" enctype="multipart/form-data">
                 <fieldset disabled>
                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">姓名</label>
                        <input class="form-control" value="{$row['name']}" name="name">
                      </div>
                    </div>


                  <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">性别</label>
                    <label class="radio-inline">
                      <input type="radio" name="sex" id="optionsRadiosInline1" value="男" {$checked_sex_a}> 男
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="sex" id="optionsRadiosInline2" value="女" {$checked_sex_b}> 女
                    </label>
                  </div>


              <div class="form-group has-success">
                <label class="control-label">客户类型</label>
                <select class="form-control" name="in_class">
                  <option value="潜在客户" {$selected_a}>潜在客户</option>
                  <option value="供应商" {$selected_b}>供应商</option>
                  <option value="臻客会员" {$selected_c}>臻客会员</option>
                  <option value="传媒" {$selected_d}>传媒</option>
                  <option value="金融" {$selected_e}>金融</option>
                  <option value="其他" {$selected_f}>其他</option>
                </select>
              </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">公司</label>
                        <input class="form-control" value="{$row['corporation']}" name="corporation">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">职务</label>
                        <input class="form-control" value="{$row['title']}" name="title">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">银行账户</label>
                        <input class="form-control" value="{$row['bank_account']}" name="bank_account">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">年收入/身价</label>
                        <input class="form-control" value="{$row['annual_income']}" name="annual_income">
                      </div>
                    </div>


                  <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">婚姻状况</label>
                    <label class="radio-inline">
                      <input type="radio" name="marital_status" id="optionsRadiosInline1" value="单身" {$marital_status_a}> 单身
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="marital_status" id="optionsRadiosInline2" value="已婚" {$marital_status_b}> 已婚
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="marital_status" id="optionsRadiosInline3" value="离异" {$marital_status_c}> 离异
                    </label>
                  </div>

                  <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">是否有孩子</label>
                    <label class="radio-inline">
                      <input type="radio" name="is_children" id="optionsRadiosInline4" value="是" {$is_children_a}> 是
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="is_children" id="optionsRadiosInline5" value="否" {$is_children_b}> 否
                    </label>
                  </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">网址</label>
                        <input class="form-control" value="{$row['website']}" name="website">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">国籍</label>
                        <input class="form-control" value="{$row['nationality']}" name="nationality">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">城市</label>
                        <input class="form-control" value="{$row['city']}" name="city">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">护照号码</label>
                        <input class="form-control" value="{$row['passport_num']}" name="passport_num">
                      </div>
                    </div>


                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">身份证号码</label>
                        <input class="form-control" value="{$row['card_id']}" name="card_id">
                      </div>
                    </div>


                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">配偶信息</label>
                        <input class="form-control" value="{$row['marital']}" name="marital">
                      </div>
                    </div>



                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">兴趣爱好</label>
                        <input class="form-control" value="{$row['hobbies']}" name="hobbies">
                      </div>
                    </div>


                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">手机</label>
                        <input class="form-control" value="{$row['mobile']}" name="mobile">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">座机（公司/家）</label>
                        <input class="form-control" value="{$row['tel']}" name="tel">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">邮箱</label>
                        <input class="form-control" value="{$row['email']}" name="email">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">公司地址</label>
                        <input class="form-control" value="{$row['company_address']}" name="company_address">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">家庭地址</label>
                        <input class="form-control" value="{$row['home_address']}" name="home_address">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">传真</label>
                        <input class="form-control" value="{$row['fax']}" name="fax">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">其他</label>
                        <input class="form-control" value="{$row['other']}" name="other">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">标签</label>
                        <input class="form-control" value="{$row['label']}" name="label">
                      </div>
                    </div>

                <div class="form-group">
                    <label>附件</label>
                    <input type="file" name="attachment">
                  </div>

                  <div class="form-group">
                    <label>备注</label>
                    <textarea class="form-control" rows="3" name="remark" value="{$row['remark']}"></textarea>
                  </div>
           </fieldset>
              <button type="reset" class="btn btn-default"  onclick="history.go(-1)">返回</button>

             </form>

            </div>

          </div>
       </div>
    </div>

html;

    }else{
        echo "<script>alert('警告:非法参数');history.go(-1)</script>";
    }
}





function member_delete($id,$user){
    $is_delete="1";
    $op_type="删除客户";
    global $_SC;
    $sql="UPDATE `tbl_member_info` SET `is_delete` =".$is_delete." WHERE `id` =$id ";
    $query=$_SC['db']->query($sql);
    if($query){
        $sql=" insert into tbl_op_user (op_user,op_type,op_id,op_time) value ('".daddslashes($user)."','".daddslashes($op_type)."',".$id.",".time().")";
        $query=$_SC['db']->query($sql);
        if($query){
            echo "<script>alert('提示:删除成功');location.href='index.php?do=member&ac=edit';</script>";

        }
    }
}








function member_follow($id,$user,$user_id){
    global $_SC;
    get_header();
    get_left_menu();
    $sql="SELECT * FROM  tbl_member_info where  is_delete=0 and id='".$id."'";
    $query=$_SC['db']->query($sql);
    $row=$_SC['db']->fetch_array($query);//存储客户个人信息
    if(!$row){
        echo "<script>alert('提示:该客户已被删除');history.go(-1)</script>";
        exit();
    }



    echo <<<html
        <div id="page-wrapper">
              <div class="">
                  <ol class="breadcrumb">
                      <li><a href="index.php?do=member&ac=edit"><i class="icon-dashboard"></i> 客户管理</a></li>
                      <li class="active"><i class="icon-edit"></i> 客户详细信息</li>
                  </ol>
         <div class="row">
          <div class="col-lg-12">
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>姓名 <i class="icon-sort"></i></th>
                    <th>性别 <i class="icon-sort"></i></th>
                    <th>公司 <i class="icon-sort"></i></th>
                    <th>职务 <i class="icon-sort"></i></th>
                    <th>类型 <i class="icon-sort"></i></th>
                    <th>年收入/身价 <i class="icon-sort"></i></th>
                    <th>婚姻状况 <i class="icon-sort"></i></th>
                    <th>小孩有/否 <i class="icon-sort"></i></th>
                    <th>国籍 <i class="icon-sort"></i></th>
                  </tr>
                </thead>
                  <tr>
                    <td> {$row['name']}</td>
                    <td>{$row['sex']}</td>
                    <td>{$row['corporation']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['in_class']}</td>
                    <td>{$row['annual_income']}</td>
                    <td>{$row['marital_status']}</td>
                    <td>{$row['is_children']}</td>
                    <td>{$row['nationality']}</td>
                  </tr>
              </table>
            </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <h2>使用服务记录 </h2>
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped tablesorter">
                <thead>
                  <tr>
                    <th>日期 </th>
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


html;
    $sql="select * from tbl_server_member where member_id='".$id."' ORDER BY server_id desc";
    $query=$_SC['db']->query($sql);
    $pageSize = 10;
    $totalCountsql = "select count(*) as t from tbl_server_member where member_id='".$id."' and is_delete='0'";
    $query_s = $_SC['db']->query($totalCountsql);
    $rs = $_SC['db']->fetch_array($query_s);
    $totalCount = $rs['t'];
    $pageUrl = './index.php?do=member&ac=follow&id='.$id.'&specialty=' . $specialty . '&page=';
    $sql = "select * from tbl_server_member where  is_delete='0' and member_id='".$id."' order by server_id desc limit " . (($_GET['page']- 1) * $pageSize) . ",$pageSize";
    $query = $_SC['db']->query($sql);
    while($row_server=$_SC['db']->fetch_array($query)){
        $time=date('Y-m-d',$row_server['time']);
        if(!empty($row_server['pay_time'])){
            $pay_time=date('Y-m-d',$row_server['pay_time']);
        }
        $file_info=file_info($row_server['file_id']);
        $attachment=file_info($row_server['attachment_id']);
        echo <<<html

                  <tr>
                    <td>{$time}</td>
                    <td>
html;
    if(!empty($row_server['product_id'])){
    $sql="select * from tbl_product_info where product_id=".$row_server['product_id']."";
    $product_name=$_SC['db']->fetch_array($_SC['db']->query($sql));
    }

        echo <<<html
                    <a href="index.php?do=product&ac=view&product_id={$row_server['product_id']}">{$product_name['product_name']}</a>
html;
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
                        <a href="index.php?do=member&ac=update_server&server_id={$row_server['server_id']}&member_id={$id}" ><button type="button" class="btn btn-primary btn-xs" >修改</button></a>
                        <a href="index.php?do=member&ac=delete_server&server_id={$row_server['server_id']}&member_id={$id}" onclick="return CommandConfirm_server()"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
                    </td>
                  </tr>
html;

}
    echo <<<html
          <tbody>
                  <tr>
                   <td colspan="11" align="center"><a href="index.php?do=member&ac=server_add&member_id={$id}&user_id={$user_id}">增加服务记录</a></td>
                  </tr>
                  </tbody>
html;

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

    echo <<<html
            <div class="row">
          <div class="col-lg-6">
            <h2>咨询情况</h2>
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>时间 <i class="icon-sort"></i></th>
                    <th>内容 <i class="icon-sort"></i></th>
                    <th>后续计划 <i class="icon-sort"></i></th>
                    <th>备注 <i class="icon-sort"></i></th>
                    <th>操作 <i class="icon-sort"></i></th>
                  </tr>
                </thead>
html;

    $sql="select * from tbl_member_follow where member_id=".$id." and is_delete='0' ORDER BY  `tbl_member_follow`.`id` DESC";
    $query=$_SC['db']->query($sql);
    while($row_follow=$_SC['db']->fetch_array($query)){
        $row_follow['time']=date("Y-m-d",$row_follow['time']);
    echo <<<html
                  <tr>
                    <td>{$row_follow['time']}</td>
                    <td>{$row_follow['content']}</td>
                    <td>{$row_follow['follow_plan']}</td>
                    <td>{$row_follow['remark']}</td>
                    <td>
                    <a class="btn btn-default" href="index.php?do=consultation&ac=edit&id=$row_follow[id]&member_id=$row_follow[member_id]">修改</a>
                    <a class="btn btn-default" href="index.php?do=consultation&ac=del&id=$row_follow[id]&member_id=$row_follow[member_id]" onclick="return CommandConfirm_server()">删除</a></td>
                  </tr>
html;
    }
    echo <<<html
                <tbody>
                  <tr>
                   <td colspan="5" align="center"><a href="index.php?do=member&ac=follow_add&member_id={$id}&user_id={$user_id}">增加跟进记录</a></td>
                  </tr>
                  </tbody>
html;




    echo <<<html
              </table>
          </div>
          </div>

          <div class="col-lg-6">
            <h2>负责人</h2>
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped tablesorter">
                <thead>
                  <tr>
                    <th>姓名 <i class="icon-sort"></i></th>
                    <th>职位 <i class="icon-sort"></i></th>
                    <th>部门 <i class="icon-sort"></i></th>
                    <th>备注 <i class="icon-sort"></i></th>
                  </tr>
                </thead>
html;
    $sql="select * from tbl_member_user where member_id=".$id."";
    $query=$_SC['db']->query($sql);
    while($row_follow=$_SC['db']->fetch_array($query)){
    $sql="select * from tbl_user where user_id=".$row_follow['user_id']."";
    $user_row=$_SC['db']->fetch_array($_SC['db']->query($sql));
    echo <<<html
                  <tr>
                    <td>{$user_row['name']}</td>
                    <td>{$user_row['title']}</td>
                    <td>{$user_row['title']}</td>
                    <td>{$row_follow['remark_user']}</td>
                  </tr>
html;
    }
    echo <<<html
                </tbody>
              </table>
            </div>
          </div>
          </div>
          <div class="row">
          <div class="col-lg-6">
            <h2>详细信息 </h2>
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>类型 <i class="icon-sort"></i></th>
                    <th>内容 <i class="icon-sort"></i></th>
                  </tr>
                </thead>
                 <tr>
                    <td>网址 </td>
                    <td> {$row['website']}</td>
                  </tr>
                 <tr>
                    <td>城市 </td>
                    <td> {$row['city']}</td>
                  </tr>
                 <tr>
                 <tr>
                    <td>会员卡号 </td>
                    <td> {$row['vip_id']}</td>
                  </tr>
                 <tr>
                    <td>银行账户 </td>
                    <td> {$row['bank_account']}</td>
                  </tr>
                  <tr>
                    <td>身份证号码</td>
                    <td> {$row['card_id']}</td>
                  </tr>
                 <tr>
                    <td>护照号码</td>
                    <td> {$row['passport_num']}</td>
                  </tr>
                 <tr>
                    <td>标签</td>
                    <td> {$row['label']}</td>
                  </tr>
                 <tr>
                    <td>兴趣爱好</td>
                    <td> {$row['hobbies']}</td>
                  </tr>
                  <tr>
                    <td>注意事项</td>
                    <td>{$row['tips']} </td>
                  </tr>
                  <tr>
                    <td>备注</td>
                    <td>{$row['remark']} </td>
                  </tr>
              </table>
          </div>
          </div>
          <div class="col-lg-6">
            <h2>联系方式</h2>
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>类型<i class="icon-sort"></i></th>
                    <th>内容<i class="icon-sort"></i></th>
                  </tr>
                </thead>
                    <tr>
                    <td>手机</td>
                    <td> {$row['mobile']}</td>
                  </tr>
                  <tr>
                    <td>座机（公司/家）</td>
                    <td> {$row['tel']}</td>
                  </tr>
                  <tr>
                    <td>邮箱</td>
                    <td> {$row['email']}</td>
                  </tr>
                    <tr>
                    <td>公司地址</td>
                    <td> {$row['company_address']}</td>
                  </tr>
                  <tr>
                    <td>家庭地址</td>
                    <td> {$row['home_address']}</td>
                  </tr>
                  <tr>
                    <td>传真</td>
                    <td>{$row['fax']} </td>
                  </tr>
                  <tr>
                    <td>其他</td>
                    <td>{$row['sex']} </td>
                  </tr>
              </table>
            </div>
            </div>
        </div>
          <div class="row">
          <div class="col-lg-6">
            <h2>人际关系 </h2>
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>姓名 </th>
                    <th>关系 </th>
                    <th>操作 </th>
                  </tr>
                </thead>
html;
    add_relationships($id);
    $m_to_m=m_to_m($id);
    foreach($m_to_m as $v){
        $m_name=member_info($v['m_id']);
        echo <<<html
                 <tr>
                    <td> {$m_name['name']}</td>
                    <td> {$v['relationships']}</td>
                    <td><a href="index.php?do=member&ac=delete_relationships&relationships_id={$v['id']}" onclick="return CommandConfirm_server()">删除</a></td>
                  </tr>
html;
    }

    echo <<<html
              <tr><td colspan="3" align="center"><a href="#createPopup" data-toggle="modal"  >增加客户人际关系</a></td></tr>
              </table>
          </div>
          </div>
          </div>
html;
    $member_info=member_info($id);
    $p=pic_info($member_info['p_pic_id']);
    $c=pic_info($member_info['c_pic_id']);

    echo <<<html
        <div class="row">
          <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter">
              <tr>
              <td>护照</td><td>身份证</td>
              </tr>
              <tr>
              <td><img src="{$p['pic_url']}" width="500px"  title={$p['pic_name']}></td>
              <td><img src="{$c['pic_url']}" width="500px"  title={$c['pic_name']}></td>
              </tr>
              </table>
             </div>
       </div>
    </div>

html;
}



//完成  客户服务记录增加功能模块
function server_add($member_id,$user_id){
    global $_SC;
    get_header();
    get_left_menu();
    $sql="select * from tbl_member_info where id=".$member_id."";
    $query=$_SC['db']->query($sql);
    $row=$_SC['db']->fetch_array($query);
    $new_time=date('Y-m-d');
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=member&ac=edit"><i class="icon-dashboard"></i> 客户列表</a></li>
              <li class="active"><a href="index.php?do=member&ac=follow&id={$member_id}"><i class="icon-edit"></i> {$row['name']} 的服务记录</a></li>
              <li class="active"><i class="icon-edit"></i>增加 {$row['name']} 的服务记录</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
             <form role="form" action="index.php?do=member&ac=server_add&member_id={$member_id}&user_id={$user_id}" method="post" enctype="multipart/form-data">
                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">日期</label>
                        <input class="form-control" type="date" value="{$new_time}" name="time">
                      </div>
                    </div>
                <div class="form-group has-success">
                    <label class="control-label">项目</label>
                    <select class="form-control" name="product_id">
html;
    $sql="select * from tbl_product_info where is_delete='0' ORDER BY in_class ASC ";
    $query=$_SC['db']->query($sql);
    while($row_pro=$_SC['db']->fetch_array($query)){
        $sql="select * from tbl_product_class where  class_id=".$row_pro['in_class']."";
        $row_class=$_SC['db']->fetch_array($_SC['db']->query($sql));
    echo <<<html
                    <option value="{$row_pro['product_id']}" >{$row_class['class_name']}-->{$row_pro['product_name']}</option>
html;
    }
    echo <<<html

                    </select>
                      </div>
                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">内容</label>
                        <input class="form-control" placeholder="" name="content">
                      </div>
                    </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">金额</label>
                        <input class="form-control" placeholder="请输入数字" name="amount_money">
                      </div>
                    </div>



              <div class="form-group has-success">
                <label class="control-label">付款方式</label>
                <select class="form-control" name="pay_mode">
                  <option value="现金" selected>现金</option>
                  <option value="刷卡" >刷卡</option>
                  <option value="转账" >转账</option>
                  <option value="支票" >支票</option>
                </select>
              </div>


                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">付款时间</label>
                        <input class="form-control" type="date" placeholder="" value="{$new_time}" name="pay_time">
                      </div>
                    </div>



              <div class="form-group has-success">
                <label class="control-label">服务类别</label>
                <select class="form-control" name="server_type">
                  <option value="管家" selected>管家</option>
                  <option value="旅游" >旅游</option>
                  <option value="教育" >教育</option>
                  <option value="臻品" >臻品</option>
                  <option value="教育服务" >教育服务</option>
                  <option value="其他" >其他</option>
                </select>
              </div>



                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">合同（请上传OFFICE文件）</label>
                        <input  placeholder="" name="contract" type="file">
                      </div>
                    </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">附件(请压缩后上传)</label>
                        <input  placeholder="" name="attachment" type="file">
                      </div>
                    </div>


                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">备注</label>
                        <input class="form-control" placeholder="" name="remark">
                      </div>
                    </div>
                      <button type="submit" class="btn btn-default" name="server_add">提  交</button>
                      <button type="reset" class="btn btn-default">复 位</button>
                  </form>
                </div>
            </div>
        </div>
        </div>
html;

    if(isset($_POST['server_add'])){
        if(is_numeric($_POST['amount_money']) && !empty($_POST['time'])){
            if(!empty($_POST['pay_time']) && !empty($_POST['product_id'])){
                $time=strtotime($_POST['time']);
                $pay_time=strtotime($_POST['pay_time']);
                if($_FILES['contract']['error']=='0'){
                    $file_type_array=array('doc','docx','docm','dotx','dotm','xls','xlsx','xlsm','xltx','xltm','xlsb','xlam','ppt','pptx','pptm','ppsx','ppsm','potx','potm','ppam');
                    $file_type_name=pathinfo($_FILES['contract']['name'], PATHINFO_EXTENSION);
                    if(in_array($file_type_name,$file_type_array)){
                        $time=time();
                        $tmp = str_replace('\\\\', '\\', $_FILES['contract']['tmp_name']);
                        $move=move_uploaded_file($tmp,'./upload/doc/'.date(Ymd).$time.'.'.$file_type_name);
                        if($move){
                            $url="upload/doc/".date(Ymd).$time.'.'.$file_type_name;
                            $sql="insert into tbl_file (file_name,file_url) value ('".daddslashes($_FILES['contract']['name'])."','".daddslashes($url)."')";
                            $_SC['db']->query($sql);
                            $file_id=$_SC['db']->insert_id();
                        }
                    }else{
                        echo "<script>alert('提示:合同文件类型错误');history.go(-1)</script>";
                        exit();
                    }
                }

                if($_FILES['attachment']['error']=='0'){
                    $file_type_array=array('rar','zip','tar','cab','uue','jar','iso','z','7-zip','ace','lzh','arj','gzip','bz2');
                    $file_type_name=pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
                    if(in_array($file_type_name,$file_type_array)){
                        $time=time();
                        $tmp = str_replace('\\\\', '\\', $_FILES['attachment']['tmp_name']);
                        $move=move_uploaded_file($tmp,'./upload/zip/'.date(Ymd).$time.'.'.$file_type_name);
                        if($move){
                            $url="upload/zip/".date(Ymd).$time.'.'.$file_type_name;
                            $sql="insert into tbl_file (file_name,file_url) value ('".daddslashes($_FILES['attachment']['name'])."','".daddslashes($url)."')";
                            $_SC['db']->query($sql);
                            $attachment_id=$_SC['db']->insert_id();
                        }
                    }else{
                        echo "<script>alert('提示:压缩文件类型错误');history.go(-1)</script>";
                        exit();
                    }
                }

                $order_id=date('YmdHis');
                $sql="insert into tbl_server_member (member_id,time,product_id,content,amount_money,pay_mode,pay_time,server_type,remark,user_id,attachment_id,file_id,order_id) value (".$member_id.",'".daddslashes($time)."','".daddslashes($_POST['product_id'])."','".daddslashes($_POST['content'])."','".daddslashes($_POST['amount_money'])."','".daddslashes($_POST['pay_mode'])."','".$pay_time."','".daddslashes($_POST['server_type'])."','".daddslashes($_POST['remark'])."',".$user_id.",'".$attachment_id."','".$file_id."','".$order_id."')";
                $query=$_SC['db']->query($sql);
                if($row['in_class']=="臻客会员"){
                    $consumption_type="消费";
                    //计算当前余额生成本次消费后的新余额
                    $sql="select * from tbl_vip_detail where member_id='".$member_id."' order by uid DESC";
                    $query=$_SC['db']->query($sql);
                    $tmp_arr=$_SC['db']->fetch_array($query);
                    if($tmp_arr['balance']!="0"){
                        $balance=$tmp_arr['balance']-$_POST['amount_money'];
                    }else{
                        //若不存在余额记录则默认新余额为0-本次消费金额
                        $balance=-$_POST['amount_money'];
                    }
                    $sql="insert into tbl_vip_detail (member_id,time,consumption_type,content,amount_money,balance,remark,s_time) value (".$member_id.",'".$time."','".daddslashes($consumption_type)."','".daddslashes($_POST['content'])."','".daddslashes($_POST['amount_money'])."','".$balance."','".daddslashes($_POST['remark'])."','".time()."')";
                    $query=$_SC['db']->query($sql);
            }

            if($query){
                echo "<script>alert('提示:增加成功');location.href='index.php?do=member&ac=follow&id={$member_id}'</script>";
              }
            }else{
                    echo "<script>alert('提示:付款时间,使用项目不能为空');history.go(-1)</script>";
                }
        }else{
            echo "<script>alert('提示:金额只能输入数字,日期不能为空');history.go(-1)</script>";
        }
    }

}



function follow_add($member_id,$user_id){
    global $_SC;
    get_header();
    get_left_menu();
    $sql="select * from tbl_member_info where id=".$member_id."";
    $query=$_SC['db']->query($sql);
    $row=$_SC['db']->fetch_array($query);
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=member&ac=edit"><i class="icon-dashboard"></i> 跟进记录</a></li>
              <li class="active"><i class="icon-edit"></i>增加 {$row['name']} 的跟进记录</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
             <form role="form" action="index.php?do=member&ac=follow_add&member_id={$member_id}&user_id={$user_id}" method="post" enctype="multipart/form-data">


                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess" >时间</label>
                        <input class="form-control" placeholder="" name="time" type="date" >
                      </div>
                    </div>


                     <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess" >Toplist收到邮件时间</label>
                        <input class="form-control" placeholder="" name="rectime" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                      </div>
                    </div>



                    <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess" >Toplist回复时间</label>
                        <input class="form-control" placeholder="" name="reptime" onFocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                      </div>
                    </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">内容</label>
                        <!--<input class="form-control" placeholder="" name="content">-->
                        <textarea class="form-control" rows="10" name="content"></textarea>
                      </div>
                    </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">后续计划</label>
                        <input class="form-control" placeholder="" name="follow_plan">
                      </div>
                    </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">备注</label>
                        <!--<input class="form-control" placeholder="" name="remark">-->
                        <textarea class="form-control" rows="10" name="remark"></textarea>
                      </div>
                    </div>
                      <button type="submit" class="btn btn-default" name="follow_add">提  交</button>
                      <button type="reset" class="btn btn-default">复 位</button>
                  </form>
                </div>
            </div>
        </div>
        </div>
html;
    if(isset($_POST['follow_add'])){

        $_POST['rectime']=strtotime($_POST['rectime']);
        $_POST['reptime']=strtotime($_POST['reptime']);
        $_POST['time']=strtotime($_POST['time']);
        $sql="insert into tbl_member_follow (member_id,time,content,follow_plan,remark,user_id,rectime,reptime) value (".$member_id.",'".daddslashes($_POST['time'])."','".daddslashes($_POST['content'])."','".daddslashes($_POST['follow_plan'])."','".daddslashes($_POST['remark'])."',".$user_id.",'".$_POST['rectime']."','".$_POST['reptime']."')";
        $query=$_SC['db']->query($sql);
        if($query){
            echo "<script>alert('提示:增加成功');location.href='index.php?do=member&ac=follow&id={$member_id}'</script>";
        }
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

//服务记录修改模块（已完成）
function update_server($server_id,$member_id){
    global $_SC;
    get_header();
    get_left_menu();
    $member_info=member_info($member_id);
    $server_info=server_info($server_id);
    $time=date('Y-m-d',$server_info['time']);
    $pay_time=date('Y-m-d',$server_info['pay_time']);
        echo <<<html

    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=member&ac=edit"><i class="icon-dashboard"></i> 客户列表</a></li>
              <li class="active"><i class="icon-edit"></i>修改{$member_info['name']} 的服务记录</li>
          </ol>
          <div class="row">
             <div class="col-lg-6">
             <form role="form" action="#" method="post" enctype="multipart/form-data">
                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">日期</label>
                        <input class="form-control" type="date" value="$time" name="time">
                      </div>
                    </div>
                <div class="form-group has-success">
                    <label class="control-label">项目</label>
                    <select class="form-control" name="product_id">

html;
    $sql="select * from  tbl_product_info a, tbl_product_class b where a.product_id='".$server_info['product_id']."' and a.in_class=b.class_id";
    $query=$_SC['db']->query($sql);
    $row=$_SC['db']->fetch_array($query);
    echo <<<html
                    <option value="{$row['product_id']}" >{$row['class_name']}-->{$row['product_name']}</option>
html;
    $sql="select * from tbl_product_info ORDER BY in_class ASC ";
    $query=$_SC['db']->query($sql);
    while($row_pro=$_SC['db']->fetch_array($query)){
            $sql="select * from tbl_product_class where  class_id=".$row_pro['in_class']."";
            $row_class=$_SC['db']->fetch_array($_SC['db']->query($sql));
            echo <<<html
                    <option value="{$row_pro['product_id']}" >{$row_class['class_name']}-->{$row_pro['product_name']}</option>
html;
        }
        echo <<<html

                    </select>
                      </div>
                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">内容</label>
                        <input class="form-control" value="{$server_info['content']}" name="content">
                      </div>
                    </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">金额</label>
                        <input class="form-control" value="{$server_info['amount_money']}" name="amount_money">
                      </div>
                    </div>



              <div class="form-group has-success">
                <label class="control-label">付款方式</label>
                <select class="form-control" name="pay_mode">
                  <option value="{$server_info['pay_mode']}" selected>{$server_info['pay_mode']}</option>
                  <option value="现金" >现金</option>
                  <option value="刷卡" >刷卡</option>
                  <option value="转账" >转账</option>
                  <option value="支票" >支票</option>
                </select>
              </div>


                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">付款时间</label>
                        <input class="form-control" type="date" placeholder="" value="{$pay_time}" name="pay_time">
                      </div>
                    </div>



              <div class="form-group has-success">
                <label class="control-label">服务类别</label>
                <select class="form-control" name="server_type">
                  <option value="{$server_info['server_type']}" selected>{$server_info['server_type']}</option>
                  <option value="管家" >管家</option>
                  <option value="旅游" >旅游</option>
                  <option value="教育" >教育</option>
                  <option value="臻品" >臻品</option>
                  <option value="其他" >其他</option>
                </select>
              </div>



                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess"><a href="{$server_info['0']['file_url']}">原合同（{$server_info['0']['file_name']}）</a></label>
                        <input  placeholder="" name="contract" type="file" title="上传新合同">
                      </div>
                    </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess"><a href="{$server_info['1']['file_url']}">原附件({$server_info['1']['file_name']})</a></label>
                        <input  placeholder="" name="attachment" type="file" title="上传新附件">
                      </div>
                    </div>


                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">备注</label>
                        <input class="form-control" value="{$server_info['remark']}" name="remark">
                      </div>
                    </div>
                      <button type="submit" class="btn btn-default" name="update_server">提  交</button>
                      <a href="index.php?do=member&ac=edit" class="btn btn-default">取 消</a>
                  </form>
                </div>
            </div>
        </div>
        </div>
html;

        if(isset($_POST['update_server'])){
            $time=strtotime($_POST['time']);
            $pay_time=strtotime($_POST['pay_time']);
//修改合同
                    if($_FILES['contract']['error']=='0'){
                        $file_type_array=array('doc','docx','docm','dotx','dotm','xls','xlsx','xlsm','xltx','xltm','xlsb','xlam','ppt','pptx','pptm','ppsx','ppsm','potx','potm','ppam');
                        $file_type_name=pathinfo($_FILES['contract']['name'], PATHINFO_EXTENSION);
                        if(in_array($file_type_name,$file_type_array)){
                            $time=time();
                            $tmp = str_replace('\\\\', '\\', $_FILES['contract']['tmp_name']);
                            $move=move_uploaded_file($tmp,'./upload/doc/'.date(Ymd).$time.'.'.$file_type_name);
                            if($move){
                                $url="upload/doc/".date(Ymd).$time.'.'.$file_type_name;
                                if($server_info['0']['file_id']>0){
                                    $sql="UPDATE tbl_file SET file_url='".daddslashes($url)."', file_name='".daddslashes($_FILES['contract']['name'])."' where file_id='".$server_info['0']['file_id']."'";
                                    $query=$_SC['db']->query($sql);
                                    if (file_exists($server_info['0']['file_url'])) {
                                        unlink($server_info['0']['file_url']);
                                    }
                                }else{
                                    $sql="insert into tbl_file (file_url,file_name) value ('".daddslashes($url)."','".daddslashes($_FILES['contract']['name'])."')";
                                    $query=$_SC['db']->query($sql);
                                    $file_id=$_SC['db']->insert_id();
                                    $sql="UPDATE tbl_server_member set file_id='.$file_id.' where server_id='".$server_info['server_id']."'";
                                    $_SC['db']->query($sql);
                                }
                            }else{
                                echo "<script>alert('提示:文件上传失败');history.go(-1)</script>";
                            }
                        }else{
                            echo "<script>alert('提示:合同文件类型错误');history.go(-1)</script>";
                        }
                    }

//修改附件
                    if($_FILES['attachment']['error']=='0'){
                        $file_type_array=array('rar','zip','tar','cab','uue','jar','iso','z','7-zip','ace','lzh','arj','gzip','bz2');
                        $file_type_name=pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
                        if(in_array($file_type_name,$file_type_array)){
                            $time=time();
                            $tmp = str_replace('\\\\', '\\', $_FILES['attachment']['tmp_name']);
                            $move=move_uploaded_file($tmp,'./upload/zip/'.date(Ymd).$time.'.'.$file_type_name);
                            if($move){
                                $url="upload/zip/".date(Ymd).$time.'.'.$file_type_name;
                                if($server_info['1']['file_id']>0){
                                $sql="UPDATE tbl_file SET file_url='".daddslashes($url)."', file_name='".daddslashes($_FILES['attachment']['name'])."' where file_id='".$server_info['1']['file_id']."'";
                                $query=$_SC['db']->query($sql);
                                    if (file_exists($server_info['1']['file_url'])) {
                                        unlink($server_info['1']['file_url']);
                                    }
                                }else{
                                    $sql="insert into tbl_file (file_url,file_name) value ('".daddslashes($url)."','".daddslashes($_FILES['attachment']['name'])."')";
                                    $query=$_SC['db']->query($sql);
                                    $attachment_id=$_SC['db']->insert_id();
                                    $sql="UPDATE tbl_server_member set attachment_id='.$attachment_id.' where server_id='".$server_info['server_id']."'";
                                    $_SC['db']->query($sql);
                                }
                            }else{
                                echo "<script>alert('提示:文件上传失败');history.go(-1)</script>";
                            }
                        }else{
                            echo "<script>alert('提示:压缩文件类型错误');history.go(-1)</script>";
                        }
                    }

                    if(!empty($_POST['time'])){
                        $sql="UPDATE `tbl_server_member` SET `time` ='".$time."' WHERE `server_id` ='".$server_info['server_id']."' ";
                        $_SC['db']->query($sql);
                    }

                    if(!empty($_POST['product_id'])){
                        $sql="UPDATE `tbl_server_member` SET `product_id` ='".daddslashes($_POST['product_id'])."' WHERE `server_id` ='".$server_info['server_id']."'";
                        $_SC['db']->query($sql);
                    }

                    if(!empty($_POST['content'])){
                        $sql="UPDATE `tbl_server_member` SET `content` ='".daddslashes($_POST['content'])."' WHERE `server_id` ='".$server_info['server_id']."' ";
                        $_SC['db']->query($sql);
                    }

                    if(!empty($_POST['amount_money'])){
                        $sql="UPDATE `tbl_server_member` SET `amount_money` ='".daddslashes($_POST['amount_money'])."' WHERE `server_id` ='".$server_info['server_id']."' ";
                        $_SC['db']->query($sql);
                    }

                    if(!empty($_POST['pay_mode'])){
                        $sql="UPDATE `tbl_server_member` SET `pay_mode` ='".daddslashes($_POST['pay_mode'])."' WHERE `server_id` ='".$server_info['server_id']."' ";
                        $_SC['db']->query($sql);
                    }

                    if(!empty($_POST['pay_time'])){
                        $sql="UPDATE `tbl_server_member` SET `pay_time` ='".$pay_time."' WHERE `server_id` ='".$server_info['server_id']."' ";
                        $_SC['db']->query($sql);
                    }

                    if(!empty($_POST['server_type'])){
                        $sql="UPDATE `tbl_server_member` SET `server_type` ='".daddslashes($_POST['server_type'])."' WHERE `server_id` ='".$server_info['server_id']."' ";
                        $_SC['db']->query($sql);
                    }

                    if(!empty($_POST['remark'])){
                        $sql="UPDATE `tbl_server_member` SET `remark` ='".daddslashes($_POST['remark'])."' WHERE `server_id` ='".$server_info['server_id']."' ";
                        $_SC['db']->query($sql);
                    }



//                    if($row['in_class']=="臻客会员"){
//                        $consumption_type="消费";
//                        //计算当前余额生成本次消费后的新余额
//                        $sql="select * from tbl_vip_detail where member_id='".$member_id."' order by uid DESC";
//                        $query=$_SC['db']->query($sql);
//                        $tmp_arr=$_SC['db']->fetch_array($query);
//                        if($tmp_arr['balance']!="0"){
//                            $balance=$tmp_arr['balance']-$_POST['amount_money'];
//                        }else{
//                            //若不存在余额记录则默认新余额为0-本次消费金额
//                            $balance=-$_POST['amount_money'];
//                        }
//                        $sql="insert into tbl_vip_detail (member_id,time,consumption_type,content,amount_money,balance,remark,s_time) value (".$member_id.",'".$time."','".daddslashes($consumption_type)."','".daddslashes($_POST['content'])."','".daddslashes($_POST['amount_money'])."','".$balance."','".daddslashes($_POST['remark'])."','".time()."')";
//                        $query=$_SC['db']->query($sql);
//                    }
                        echo "<script>alert('提示:修改成功');location.href='index.php?do=member&ac=follow&id={$member_id}'</script>";
        }




}






function delete_server($server_id,$member_id){
    global $_SC;
    $url_arr=file_url($server_id);
    if($url_arr=file_url($server_id)){
        foreach($url_arr as $v){
            @unlink($v['file_url']);
            $sql="DELETE FROM `tbl_file` WHERE file_id='".$v['file_id']."'";
            $_SC['db']->query($sql);
        }
        $sql="update tbl_server_member set is_delete='1' where server_id='".$server_id."'";
        $_SC['db']->query($sql);

        $sql="select * from tbl_server_member where server_id='".$server_id."'";
        $query=$_SC['db']->query($sql);
        $rs=$_SC['db']->fetch_array($query);
        if(!empty($rs['edu_s_id'])){
            edu_server_delete($member_id,$rs['edu_s_id'],$rs['edu_class_id']);
        }
        echo "<script>alert('提示:删除成功');location.href='index.php?do=member&ac=follow&id={$member_id}'</script>";
    }
}

function edu_server_delete($member_id,$edu_server_id,$tbl_s_id){
    global $_SC;
    $is_delete="1";
    $tbl_name="tbl_s".$tbl_s_id;
    $sql="UPDATE `$tbl_name` SET `is_delete` ='".$is_delete."'  WHERE `s_id` ='".$edu_server_id."' ";
    $_SC['db']->query($sql);
    $sql="UPDATE `tbl_server_member` SET `is_delete` ='".$is_delete."'  WHERE `edu_s_id` ='".$edu_server_id."' and edu_class_id='".$tbl_s_id."' ";
    $_SC['db']->query($sql);
}


function authority_info($user_id){
    global $_SC;
    $sql="select * from tbl_user";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    return $rs;
}

?>

<script>
    function CommandConfirm(){
        if(window.confirm("提示:确定要删除此客户？")){
            return true;
        }else{
            return false;
        }
    }
</script>

<script>
    function CommandConfirm_server(){
        if(window.confirm("提示:确定要删除此记录？")){
            return true;
        }else{
            return false;
        }
    }
</script>


