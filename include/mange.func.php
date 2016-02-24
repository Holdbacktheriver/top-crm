<?php
session_verify($_SESSION['username']);
$power=$_SESSION['power'];
$user=$_SESSION['name'];
$acs = array('edit','delete','add','update','setting','authority');
$ac = (!empty($_GET['ac']) && in_array($_GET['ac'], $acs))?$_GET['ac']:'edit';
switch ($ac){
    case 'edit':
        mange_edit();
        break;
    case 'delete':
        mange_delete($_GET['id'],$user,$power);
        break;
    case 'add':
        mange_add($user);
        break;
    case 'update':
        mange_update($_GET['id'],$user,$power);
        break;
    case 'setting':
        mange_setting($_SESSION['user_id'],$user,$power);
        break;
    case 'authority':
        authority($_GET['id']);
        break;
}

function authority($user_id){
    global $_SC;
    get_header();
    get_left_menu();
    $sql="select * from tbl_user where user_id='".$user_id."' and is_delete=0";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    echo <<<html
    <script>
        window.onload=function(){
            if({$rs['mange_part_m']}==1){
            document.getElementById('mange_part_m').checked=true;
            }
            if({$rs['mange_edu_all']}==1){
            document.getElementById('mange_edu_all').checked=true;
            }
            if({$rs['mange_all_m']}==1){
            document.getElementById('mange_all_m').checked=true;
            }
            if({$rs['mange_group_use']}==1){
            document.getElementById('mange_group_use').checked=true;
            }
            if({$rs['mange_all_use']}==1){
            document.getElementById('mange_all_use').checked=true;
            }
            if({$rs['mange_p_all']}==1){
            document.getElementById('mange_p_all').checked=true;
            }
        }
    </script>
        <div id="page-wrapper">
              <ol class="breadcrumb">
                  <li><a href="index.php?do=mange&ac=edit"><i class="icon-dashboard"></i> 员工管理</a></li>
                  <li class="active"><i class="icon-edit"></i> 编辑<a href=""> {$rs['name']}</a>的权限</li>
              </ol>
          <div class="col-lg-6">
          <form action="#" method="post" id="form">
              <table class="table table-bordered table-hover tablesorter">
                  <tr>
                    <th style="text-align: center;" colspan="3">客户管理权限</th>
                  </tr>
                  <tr>
                    <td style="text-align: center">操作负责客户 <input type="checkbox" name="mange_part_m" id="mange_part_m" value="1"> </td>
                    <td style="text-align: center">操作教育客户  <input type="checkbox" name="mange_edu_all" id="mange_edu_all" value="1"></td>
                    <td style="text-align: center">操作所有客户 <input type="checkbox" name="mange_all_m" id="mange_all_m" value="1"></td>
                  </tr>
                  <tr>
                    <th style="text-align: center;" colspan="3">员工管理权限</th>
                  </tr>
                  <tr>
                    <td style="text-align: center">操作本组员工 <input type="checkbox" name="mange_group_use" id="mange_group_use" value="1"></td>
                    <td style="text-align: center">操作全部员工 <input type="checkbox" name="mange_all_use" id="mange_all_use" value="1"></td>
                    <td style="text-align: center"></td>
                  </tr>
                   <tr>
                    <th style="text-align: center;" colspan="3">产品管理权限</th>
                  </tr>
                  <tr>
                    <td style="text-align: center">操作全部产品 <input type="checkbox" name="mange_p_all" id="mange_p_all" value="1"></td>
                    <td style="text-align: center">注:所有员工均可查看所有产品</td>
                    <td style="text-align: center"></td>
                  </tr>
                  </table>
                  <div class="text-center"><input type="submit" name="submit"  class="btn-default btn"></div>
          </form>

        </div>
</div>
html;
if(isset($_POST['submit'])){
    $mange_part_m=$_POST['mange_part_m'];
    if(empty($mange_part_m)){
        $mange_part_m=0;
    }
    $mange_edu_all=$_POST['mange_edu_all'];
    if(empty($mange_edu_all)){
        $mange_edu_all=0;
    }
    $mange_all_m=$_POST['mange_all_m'];
    if(empty($mange_all_m)){
        $mange_all_m=0;
    }
    $mange_group_use=$_POST['mange_group_use'];
    if(empty($mange_group_use)){
        $mange_group_use=0;
    }
    $mange_all_use=$_POST['mange_all_use'];
    if(empty($mange_all_use)){
        $mange_all_use=0;
    }
    $mange_p_all=$_POST['mange_p_all'];
    if(empty($mange_p_all)){
        $mange_p_all=0;
    }
    $sql="update tbl_user set mange_part_m='".$mange_part_m."',  mange_edu_all='".$mange_edu_all."', mange_all_m='".$mange_all_m."' ,mange_group_use='".$mange_group_use."', mange_all_use='".$mange_all_use."' ,mange_p_all='".$mange_p_all."' where user_id='".$user_id."'";
    $query=$_SC['db']->query($sql);
    if($query){
        echo "<script>location.href='index.php?do=mange&ac=edit';</script>";
    }
  }

}


function mange_edit(){
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
        <div id="page-wrapper">
        <div class="">

              <ol class="breadcrumb">
                  <li><a href="index.php?do=mange&ac=edit"><i class="icon-dashboard"></i> 员工管理</a></li>
                  <li class="active"><i class="icon-edit"></i> 员工列表</li>
              </ol>
              <ol class="breadcrumb">
                  <div class="col-lg-12">
                      <a href="index.php?do=mange&ac=add"><button type="button" class="btn btn-primary btn-1g btn-block" style="">增加员工账号</button></a>
                      </div>
              </ol>
               <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>账号 <i class="icon-sort"></i></th>
                    <th>姓名 <i class="icon-sort"></i></th>
                    <th>手机 <i class="icon-sort"></i></th>
                    <th>E-mail <i class="icon-sort"></i></th>
                    <th>职位<i class="icon-sort"></i></th>
                    <th>部门<i class="icon-sort"></i></th>
                    <th>操作<i class="icon-sort"></i></th>
                  </tr>
                </thead>
html;
    $sql="select * from tbl_user where is_delete=0";
    $query=$_SC['db']->query($sql);
    while($row=$_SC['db']->fetch_array($query)){
        echo <<<html
                    <tr>
                    <td> {$row['username']}</td>
                    <td> {$row['name']}</td>
                    <td> {$row['mobile']}</td>
                    <td> {$row['email']}</td>
                    <th>{$row['title']}</td>
                    <td>{$row['department_id']}</td>
                    <td>
                    <a href="index.php?do=mange&ac=update&id={$row['user_id']}"><button type="button" class="btn btn-primary btn-xs" >修改资料</button></a>
                    <a href="index.php?do=mange&ac=authority&id={$row['user_id']}"><button type="button" class="btn btn-primary btn-xs" >编辑权限</button></a>
                    <a href="index.php?do=mange&ac=delete&id={$row['user_id']}"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
                    </td>
                    </tr>
html;
    }
    echo <<<html
               </div>
            </table>
html;
    echo <<<html
         </div>
    </div>
html;

}


function mange_add($user){
    global $_SC;
    $op_type="创建员工账号";
    get_header();
    get_left_menu();
    echo <<<html
        <div id="page-wrapper">
        <div class="">

              <ol class="breadcrumb">
                  <li><a href="index.php?do=mange&ac=edit"><i class="icon-dashboard"></i> 员工管理</a></li>
                  <li class="active"><i class="icon-edit"><a href="index.php?do=mange&ac=edit"></i> 员工列表</a></li>
                  <li class="active"><i class="icon-edit"></i> 创建员工账号</li>
              </ol>
            <div class="row">
              <div class="col-lg-6">
                <form role="form" action="index.php?do=mange&ac=add" method="post" enctype="multipart/form-data">
                    <div class="form-group has-success">
                          <div class="form-group">
                            <label class="control-label" for="inputSuccess">员工姓名</label>
                            <input class="form-control" placeholder="" name="name">
                          </div>
                        </div>
                    <div class="form-group has-success">
                          <div class="form-group">
                            <label class="control-label" for="inputSuccess">员工账号</label>
                            <input class="form-control" placeholder="" name="username">
                          </div>
                        </div>
                    <div class="form-group has-success">
                          <div class="form-group">
                            <label class="control-label" for="inputSuccess">密码</label>
                            <input class="form-control" placeholder="" name="password">
                          </div>
                        </div>
                    <div class="form-group has-success">
                          <div class="form-group">
                            <label class="control-label" for="inputSuccess">手机号</label>
                            <input class="form-control" placeholder="" name="mobile">
                          </div>
                        </div>
                    <div class="form-group has-success">
                          <div class="form-group">
                            <label class="control-label" for="inputSuccess">E_mail</label>
                            <input class="form-control" placeholder="" name="email">
                          </div>
                        </div>
              <div class="form-group has-success">
                <label class="control-label">职位</label>
                <select class="form-control" name="title">
                  <option value="员工" selected>员工</option>
                  <option value="部门主管" >部门主管</option>
                  <option value="产品管理员">产品管理员</option>
                  <option value="客户管理员">客户管理员</option>
                  <option value="行政管理员">行政管理员</option>
                  <option value="总经理" >总经理</option>
                </select>
              </div>

                    <div class="form-group has-success">
                          <div class="form-group">
                            <label class="control-label" for="inputSuccess">部门</label>
                            <input class="form-control" placeholder="" name="department_id">
                          </div>
                        </div>
                    <div class="form-group has-success">
                          <div class="form-group">
                            <label class="control-label" for="inputSuccess">客服人员编号(仅客服人员填写)</label>
                            <input class="form-control" placeholder="" name="customer_number" maxlength="4" onkeyup="value=value.replace(/[\W]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))">
                          </div>
                        </div>
              <button type="submit" class="btn btn-default" name="user_add">提  交</button>
              <button type="reset" class="btn btn-default">复 位</button>
             </form>
html;
    if(isset($_POST['user_add'])){
        if(!empty($_POST['name'])){
            $username=str_replace(" ",'',$_POST['username']);
            $sql="select * from tbl_user where username='".$username."'";
            $query=$_SC['db']->query($sql);
            if(!$row=$_SC['db']->fetch_array($query)){
                      if(!empty($_POST['password'])){
                          if(!empty($_POST['title'])){
                              if(!empty($_POST['mobile'])){
                                  $name=str_replace(" ",'',$_POST['name']);
                                  $username=str_replace(" ",'',$_POST['username']);
                                  $password=md5($_POST['password']);
                                  $sql=" insert into tbl_user (name,username,password,title,mobile,email,department_id,customer_number) value ('".daddslashes($name)."','".daddslashes($username)."','".$password."','".daddslashes($_POST['title'])."','".daddslashes($_POST['mobile'])."','".daddslashes($_POST['email'])."','".daddslashes($_POST['department_id'])."','".daddslashes($_POST['customer_number'])."')";
                                  $_SC['db']->query($sql);
                                  $id=$_SC['db']->insert_id();
                                  $sql=" insert into tbl_op_user (op_user,op_type,op_id,op_time) value ('".daddslashes($user)."','".daddslashes($op_type)."',".$id.",".time().")";
                                  $query=$_SC['db']->query($sql);
                                  if($query){
                                      echo "<script>alert('提示:创建成功');location.href='index.php?do=mange&ac=edit';</script>";
                                  }
                              }else{
                                  echo "<script>alert('警告:手机号不能为空');history.go(-1)</script>";
                              }
                          }else{
                              echo "<script>alert('警告:职位不能为空');history.go(-1)</script>";
                          }
                      }else{
                          echo "<script>alert('警告:密码不能为空');history.go(-1)</script>";
                      }
            }else{
                echo "<script>alert('警告:账号已存在');history.go(-1)</script>";
            }
        }else{
            echo "<script>alert('警告:姓名不能为空');history.go(-1)</script>";
        }
    }
    echo <<<html
         </div>
    </div>
html;
}



function mange_delete($id,$user,$power){
    global $_SC;
    $is_delete="1";
    $op_type="删除员工账号";
    $sql="select * from tbl_user where user_id='".$id."'";
    $row=$_SC['db']->fetch_array($_SC['db']->query($sql));

    if($power>$row['power']){
        $sql="UPDATE `tbl_user` SET `is_delete` =".$is_delete." WHERE `user_id` = '".$id."'";
        $query=$_SC['db']->query($sql);
        if($query){
            $sql=" insert into tbl_op_user (op_user,op_type,op_id,op_time) value ('".daddslashes($user)."','".daddslashes($op_type)."',".$id.",".time().")";
            $query=$_SC['db']->query($sql);
            if($query){
                echo "<script>alert('提示:删除成功');location.href='index.php?do=mange&ac=edit';</script>";
            }
        }
    }else{
        echo "<script>alert('提示:权限不足');location.href='index.php?do=mange&ac=edit';</script>";
    }
}



function mange_setting($user_id,$user,$power){
    global $_SC;
    $op_type="修改密码";
    get_header();
    get_left_menu();
    echo <<<html
    <div id="page-wrapper">
        <div class="">

              <ol class="breadcrumb">
                  <li><a href="index.php?do=mange&ac=setting"><i class="icon-dashboard"></i> 我的设置</a></li>
                  <li class="active"><i class="icon-edit"></i>修改密码</li>
              </ol>
              <div class="row">
              <div class="col-lg-6">
                <form role="form" action="index.php?do=mange&ac=setting" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="form-group has-success">
                        <label for="inputPassword3" class="col-sm-2 control-label" >密  码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="old_password" id="inputPassword3" placeholder="请输入密码">
                        </div>
                    </div>
                    <div class="form-group has-success">
                        <label for="inputPassword3" class="col-sm-2 control-label">新密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="new_password" id="inputPassword3" placeholder="请输入新密码">
                        </div>
                    </div>
                        <div class="form-group has-success">
                        <label for="inputPassword3" class="col-sm-2 control-label">确认</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="new_password_enter" id="inputPassword3" placeholder="请输入新密码">
                        </div>
                    </div>

                        <div class="col-sm-offset-2">
                             <div class="col-sm-6">
                            <button type="submit" name="setting" class="btn btn-default col-lg-6">提 交</button>
                            </div>
                            <div class="col-sm-6">
                            <a href="index.php?do=main"><font class="btn btn-default col-lg-6">取 消</font></a>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
                </div>
                </div>
html;
    if(isset($_POST['setting'])){
        $old_password=md5($_POST['old_password']);
        $new_password=md5($_POST['new_password']);
        $new_password_enter=md5($_POST['new_password_enter']);
        $sql="select * from tbl_user where user_id='".$_SESSION['user_id']."'";
        $query=$_SC['db']->query($sql);
        $row=$_SC['db']->fetch_array($query);
        if($old_password==$row['password']){
            if($new_password==$new_password_enter){
				if(strlen($_POST['new_password']) >= 10){
					if(pwd_intensity($_POST['new_password'])){
						$pwd_validity = time()+ 3600 * 24 * 30;
						$sql="UPDATE tbl_user SET password='".$new_password."',pwd_validity = '".$pwd_validity."' where user_id='".$user_id."'";
						$query=$_SC['db']->query($sql);
						if($query){
							$sql=" insert into tbl_op_user (op_user,op_type,op_id,op_time) value ('".daddslashes($user)."','".daddslashes($op_type)."','$user_id',".time().")";
							$query=$_SC['db']->query($sql);
							if($query){
								echo "<script>alert('提示:修改完成');location.href='index.php?do=main';</script>";
							}
						}
					}else{
						echo "<script>alert('警告:密码必须包含大小写字母,数组,符号');history.go(-1)</script>";
					}
				}else{
					echo "<script>alert('警告:密码长度不能小于10位');history.go(-1)</script>";
				}



            }else{
                echo "<script>alert('警告:密码不一致,请重新输入');history.go(-1)</script>";
            }
        }else{
            echo "<script>alert('警告:密码错误');history.go(-1)</script>";
        }
    }
    echo <<<html

html;
    echo <<<html
        </div>
     </div>
html;

}


function mange_update($id,$user,$power){
    global $_SC;
    $op_type="修改员工资料";
    get_header();
    get_left_menu();
    $sql="select * from tbl_user where user_id='".$id."'";
    $row=$_SC['db']->fetch_array($_SC['db']->query($sql));
    //判断员工职位生成默认值
    if($row['title']=="员工")
        $selected_a="selected";
    elseif($row['title']=="部门主管")
        $selected_b="selected";
    elseif($row['title']=="产品管理员")
        $selected_c="selected";
    elseif($row['title']=="客户管理员")
        $selected_d="selected";
    elseif($row['title']=="行政管理员")
        $selected_e="selected";
    elseif($row['title']=="总经理")
        $selected_f="selected";

    if($power>=8){
    echo <<<html
        <div id="page-wrapper">
        <div class="">
              <ol class="breadcrumb">
                  <li><a href="index.php?do=mange&ac=edit"><i class="icon-dashboard"></i> 员工管理</a></li>
                  <li class="active"><i class="icon-edit"><a href="index.php?do=mange&ac=edit"></i> 员工列表</a></li>
                  <li class="active"><i class="icon-edit"></i> 修改员工资料</li>
              </ol>
            <div class="row">
              <div class="col-lg-6">
                <form role="form" action="index.php?do=mange&ac=update&id={$id}" method="post" enctype="multipart/form-data">
                    <div class="form-group has-success">
                          <div class="form-group">
                            <label class="control-label" for="inputSuccess">员工姓名</label>
                            <input class="form-control" placeholder="" name="name" value="{$row['name']}">
                          </div>
                        </div>
                    <div class="form-group has-success">
                          <div class="form-group">
                            <label class="control-label" for="inputSuccess">手机号</label>
                            <input class="form-control" placeholder="" name="mobile" value="{$row['mobile']}">
                          </div>
                        </div>
                    <div class="form-group has-success">
                          <div class="form-group">
                            <label class="control-label" for="inputSuccess">E_mail</label>
                            <input class="form-control" placeholder="" name="email" value="{$row['email']}">
                          </div>
                        </div>

              <div class="form-group has-success">
                <label class="control-label">职位</label>
                <select class="form-control" name="title">
                  <option value="员工" {$selected_a}>员工</option>
                  <option value="部门主管" {$selected_b}>部门主管</option>
                  <option value="产品管理员" {$selected_c}>产品管理员</option>
                  <option value="客户管理员" {$selected_d}>客户管理员</option>
                  <option value="行政管理员" {$selected_e}>行政管理员</option>
                  <option value="总经理"  {$selected_f}>总经理</option>
                </select>
              </div>

                    <div class="form-group has-success">
                          <div class="form-group">
                            <label class="control-label" for="inputSuccess">部门</label>
                            <input class="form-control" placeholder="" name="department_id" value="{$row['department_id']}">
                          </div>
                        </div>

                    <div class="form-group has-success">
                          <div class="form-group">
                            <label class="control-label" for="inputSuccess">密码</label>
                            <input class="form-control" type="password" placeholder="请输入新密码" name="password">
                          </div>
                        </div>

              <button type="submit" class="btn btn-default" name="user_update">提  交</button>
             </form>
html;
    if(isset($_POST['user_update'])){
        if(!empty($_POST['name'])){
            $sql="UPDATE `tbl_user` SET `name` ='".daddslashes($_POST['name'])."' WHERE `user_id` = '".$id."'";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['mobile'])){
            $sql="UPDATE `tbl_user` SET `mobile` ='".daddslashes($_POST['mobile'])."' WHERE `user_id` = '".$id."'";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['email'])){
            $sql="UPDATE `tbl_user` SET `email` ='".daddslashes($_POST['email'])."' WHERE `user_id` = '".$id."'";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['title'])){
            $sql="UPDATE `tbl_user` SET `title` ='".daddslashes($_POST['title'])."' WHERE `user_id` = '".$id."'";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['department_id'])){
            $sql="UPDATE `tbl_user` SET `department_id` ='".daddslashes($_POST['department_id'])."' WHERE `user_id` = '".$id."'";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['password'])){
            $password=md5($_POST['password']);
            $sql="UPDATE `tbl_user` SET `password` ='".$password."' WHERE `user_id` = '".$id."'";
            $_SC['db']->query($sql);
        }
        $sql=" insert into tbl_op_user (op_user,op_type,op_id,op_time) value ('".daddslashes($user)."','".daddslashes($op_type)."','".$id."',".time().")";
        $query=$_SC['db']->query($sql);
        if($query){
            echo "<script>alert('提示:修改成功');location.href='index.php?do=mange&ac=edit';</script>";
        }

    }

    }else{
        echo "<script>alert('提示:权限不足');location.href='index.php?do=mange&ac=edit';</script>";
    }
    echo <<<html
         </div>
    </div>
html;
}


//get_footer();
echo <<<html
    </body>
</html>
html;


function pwd_intensity($str){
    if(!preg_match("/[0-9]+/",$str))
    {
        return false;
    }
    if(!preg_match("/[a-z]+/",$str))
    {
        return false;
    }
    if(!preg_match("/[A-Z]+/",$str))
    {
        return false;
    }
    if(!preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/",$str))
    {
        return false;
    }
    return true;
}

