<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-11-1
 * Time: 下午5:59
 * To change this template use File | Settings | File Templates.
 * 高尔夫场地
 */
session_verify($_SESSION['username']);

$user_id=$_SESSION['user_id'];
$booker=$_SESSION['name'];
$booker_department_id_id_id=$_SESSION['department_id'];
$acs = array('list','view','edit','delete','add','manage','update');
$ac = (!empty($_GET['ac']) && in_array($_GET['ac'], $acs))?$_GET['ac']:'edit';
switch ($ac){
    case 'list':
        product_list();
        break;
    case 'view':
        product_view($_GET['product_id']);
        break;
    case 'edit':
        product_edit();
        break;
    case 'delete':
        product_delete($_GET['product_id'],$booker);
        break;
    case 'add':
        product_add($booker);
        break;
    case 'manage':
        product_manage();
        break;
    case 'update':
        product_update($_GET['product_id'],$booker);
        break;
}

function product_add($booker){
    $in_class="3";
    $op_type="新建";
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=golf&ac=edit"><i class="icon-dashboard"></i> 高尔夫场地管理</a></li>
              <li class="active"><i class="icon-edit"></i> 高尔夫场地登记</li>
          </ol>
        <div class="row">
          <div class="col-lg-6">
            <form role="form" action="index.php?do=golf&ac=add" method="post" enctype="multipart/form-data">
                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">球场名</label>
                        <input class="form-control" value="" name="product_name">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">地区</label>
                        <input class="form-control" value="" name="district">
                      </div>
                    </div>


                  <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">会员制/非会员制</label>
                    <label class="radio-inline">
                      <input type="radio" name="is_member" id="optionsRadiosInline1" value="会员制" checked> 会员制
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="is_member" id="optionsRadiosInline2" value="非会员制"> 非会员制
                    </label>
                  </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">平日价格</label>
                        <input class="form-control" value="" name="normal_price">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">假日价格</label>
                        <input class="form-control" value="" name="holiday_price">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">预定时间</label>
                        <input class="form-control" value="" name="preset_time">
                      </div>
                    </div>

              <div class="form-group has-success">
                <label class="control-label">预付/现付</label>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="预付" name="payment[]">
                    预付
                  </label>
                  </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="前台现付" name="payment[]">
                    前台现付
                  </label>
                  </div>
                  </div>




              <div class="form-group has-success">
                <label class="control-label">服务选项</label>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="果岭" name="server[]">
                    果岭
                  </label>
                  </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="球童" name="server[]">
                    球童
                  </label>
                  </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="球车" name="server[]">
                    球车
                  </label>
                  </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="衣柜" name="server[]">
                    衣柜
                  </label>
                  </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="午餐" name="server[]">
                    午餐
                  </label>
                  </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="球差价" name="server[]" {$checked_6}>
                    球差价
                  </label>
                  </div>
                  </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">差价金额</label>
                        <input class="form-control" value="" name="difference">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">地址</label>
                        <input class="form-control" value="" name="address">
                      </div>
                    </div>

                  <div class="form-group">
                    <label>附件</label>
                    <input type="file" name="picture_id">
                  </div>

                  <div class="form-group">
                    <label>备注</label>
                    <textarea class="form-control" rows="3" name="remark"></textarea>
                  </div>

              <button type="submit" class="btn btn-default" name="product_add">提  交</button>
              <button type="reset" class="btn btn-default">复 位</button>

             </form>

           </div>
          </div>
       </div>
    </div>
html;


    if(isset($_POST['product_add'])){
        if(empty($_POST['product_name'])){
            echo "<script>alert('警告:产品名称不能为空');history.go(-1)</script>";
        }else{
            $payment=implode(",",$_POST['payment']);
            $sql="insert into tbl_product_info (in_class,product_name,district,is_member,normal_price,holiday_price,preset_time,address,remark,booker,booker_department,create_time,last_modified_time,payment,difference) value (".$in_class.",'".daddslashes($_POST['product_name'])."','".daddslashes($_POST['district'])."','".daddslashes($_POST['is_member'])."','".daddslashes($_POST['normal_price'])."','".daddslashes($_POST['holiday_price'])."','".daddslashes($_POST['preset_time'])."','".daddslashes($_POST['address'])."','".daddslashes($_POST['remark'])."','".daddslashes($booker)."','".daddslashes($booker_department_id)."',".time().",".time().",'".$payment."','".daddslashes($_POST['difference'])."')";
            $query=$_SC['db']->query($sql);
            $product_id=$_SC['db']->insert_id();
            if($_FILES['picture_id']['error']=='0'){
                //创建图片类型数组
                $pic_type_array=array('bmp','jpg','jpeg','png','gif');
                //获取图片后缀名
                $pic_type_name=pathinfo($_FILES['picture_id']['name'], PATHINFO_EXTENSION);
                if(in_array($pic_type_name,$pic_type_array)){
                    $time=time();
                    $tmp = str_replace('\\\\', '\\', $_FILES['picture_id']['tmp_name']);
                    $move=move_uploaded_file($tmp,'./image/product/product/'.date(Ymd).$time.".".$pic_type_name);
                    if($move){
                        $url="image/product/product/".date(Ymd).$time.".".$pic_type_name;
                        if($query){
                            $sql="insert into tbl_product_pic (product_id,url,pic_name) value (".$product_id.",'".daddslashes($url)."','".daddslashes($_FILES['picture_id']['name'])."')";
                            $_SC['db']->query($sql);
                        }
                    }else{
                        echo "<script>alert('提示:图片上传失败');history.go(-1)</script>";
                    }
                }else{
                    echo "<script>alert('提示:图片文件类型错误');history.go(-1)</script>";
                }
            }

            if(is_array($_POST['server'])){
                foreach($_POST['server'] as $v){
                    $sql="insert into tbl_golf_sever (product_id,sever_content) value (".$product_id.",'".daddslashes($v)."')";
                    $_SC['db']->query($sql);
                }
            }

            $sql=" insert into tbl_op_record (op_type, op_user,product_id,op_time) value ('".daddslashes($op_type)."','".daddslashes($booker)."',".$product_id.",".time().")";
            $_SC['db']->query($sql);
            echo "<script>alert('提示:登记成功');location.href='index.php?do=golf&ac=edit';</script>";
        }
    }
}






function product_manage(){
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
              <a href="index.php?do=golf&ac=add"><button type="button" class="btn btn-default btn-1g btn-block" style="height:500px "><h1>高尔夫场地登记</h1></button></a>
            </p>
    </div>
        <div class="col-lg-6 col-md-9">

                <p>
              <a href="index.php?do=golf&ac=edit"><button type="button" class="btn btn-default btn-lg btn-block" style="height:500px "><h1>高尔夫场地更新</h1></button></a>
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



function product_edit($product_di=NULL){
    global $_SC;
    get_header();
    get_left_menu();
    if (!isset($_GET['page']) || $_GET['page'] == '') {
        $_GET['page'] = 1;
    }
    echo <<<html
        <div id="page-wrapper">
              <div class="">
                  <ol class="breadcrumb">
                      <li><a href="index.php?do=golf&ac=edit"><i class="icon-dashboard"></i> 高尔夫场地列表</a></li>
                      <li class="active"><i class="icon-edit"></i> 高尔夫场地管理</li>
                  </ol>
                  <ol class="breadcrumb">
                  <div class="col-lg-12">
                  <a href="index.php?do=golf&ac=add"><button type="button" class="btn btn-primary btn-1g btn-block" style="">高尔夫场地登记</button></a>
                  </div>
                  </ol>

                  <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>球场名 </th>
                    <th>地区 </th>
                    <th>会员制/非会员制 </th>
                    <th>平日价格 </th>
                    <th>假日价格 </th>
                    <th>预定时间 </th>
                    <th>预付/现付</th>
                    <th>服务选项</th>
                    <th>地址 </th>
                    <th>备注 </th>
                    <th>操作 </th>
                  </tr>
                </thead>


html;
    $pageSize = 10;
    $totalCountsql="SELECT count(*) as t FROM  tbl_product_info where in_class=3 and is_delete=0";
    $query_s = $_SC['db']->query($totalCountsql);
    $rs = $_SC['db']->fetch_array($query_s);
    $totalCount = $rs['t'];
    $pageUrl = './index.php?do=golf&ac=edit&page=';
    $sql="SELECT * FROM  tbl_product_info where in_class=3 and is_delete=0  limit " . (($_GET['page']- 1) * $pageSize) . ",$pageSize";
    $query=$_SC['db']->query($sql);
    while($row=$_SC['db']->fetch_array($query)){
        echo <<<html
                <tbody>
                  <tr>
                    <td><a href="index.php?do=golf&ac=view&product_id={$row['product_id']}"> {$row['product_name']}</a></td>
                    <td>{$row['district']}</td>
                    <td>{$row['is_member']}</td>
                    <td>{$row['normal_price']}</td>
                    <td>{$row['holiday_price']}</td>
                    <td>{$row['preset_time']}</td>
                    <td>{$row['payment']}</td>
                    <td>
html;

        $golf_server=golf_server($row['product_id']);
         foreach($golf_server as $v){
             echo $v['sever_content'].';';
         }
        echo <<<html
                    </td>
                    <td>{$row['address']}</td>
                    <td>{$row['remark']}</td>
                    <td>
                    <a href="index.php?do=golf&ac=view&product_id={$row['product_id']}"><button type="button" class="btn btn-primary btn-xs" >查看</button></a>
                    <a href="index.php?do=golf&ac=update&product_id={$row['product_id']}"><button type="button" class="btn btn-primary btn-xs" >更新</button></a>
                    <a href="index.php?do=golf&ac=delete&product_id={$row['product_id']}" onclick="return CommandConfirm_server()"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
                    </td>
                  </tr>
html;
    }

    echo <<<html
                </tbody>
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



function product_update($product_id,$booker){
    $op_type="更新";
    global $_SC;
    if(isset($product_id)){
        get_header();
        get_left_menu();
        $sql="select * from tbl_product_info where product_id='".$product_id."'";
        $query=$_SC['db']->query($sql);
        $row=$_SC['db']->fetch_array($query);
        if($row['is_spot']=="会员制"){
            $checked_a="checked";
        }else{
            $checked_b="checked";
        }

        $golf_server=golf_server($row['product_id']);

        foreach($golf_server as $value){
            if($value['sever_content']=="果岭")
                $checked_1=checked;
            elseif($value['sever_content']=="球童")
                $checked_2=checked;
            elseif($value['sever_content']=="球车")
                $checked_3=checked;
            elseif($value['sever_content']=="衣柜")
                $checked_4=checked;
            elseif($value['sever_content']=="午餐")
                $checked_5=checked;
            elseif($value['sever_content']=="球差价")
                $checked_6=checked;
        }

        $arr_tmp=explode(",",$row['payment']);
        foreach($arr_tmp as $v){
            if($v=="预付"){
                $checked_payment_1="checked";
            }
            if($v=="前台现付"){
                $checked_payment_2="checked";
            }
        }
        echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=golf&ac=edit"><i class="icon-dashboard"></i> 高尔夫场地管理</a></li>
              <li class="active"><i class="icon-edit"></i> 高尔夫场地更新</li>
          </ol>
        <div class="row">
          <div class="col-lg-6">
            <form role="form" action="index.php?do=golf&ac=update&product_id={$product_id}" method="post" enctype="multipart/form-data">
                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">球场名</label>
                        <input class="form-control" value="{$row['product_name']}" name="product_name">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">地区</label>
                        <input class="form-control" value="{$row['district']}" name="district">
                      </div>
                    </div>


                  <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">会员制/非会员制</label>
                    <label class="radio-inline">
                      <input type="radio" name="is_member" id="optionsRadiosInline1" value="会员制" {$checked_a}> 会员制
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="is_member" id="optionsRadiosInline2" value="非会员制" {$checked_b}> 非会员制
                    </label>
                  </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">平日价格</label>
                        <input class="form-control" value="{$row['normal_price']}" name="normal_price">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">假日价格</label>
                        <input class="form-control" value="{$row['holiday_price']}" name="holiday_price">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">预定时间</label>
                        <input class="form-control" value="{$row['preset_time']}" name="preset_time">
                      </div>
                    </div>







              <div class="form-group has-success">
                <label class="control-label">预付/现付</label>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="预付" name="payment[]" {$checked_payment_1}>
                    预付
                  </label>
                  </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="前台现付" name="payment[]" {$checked_payment_2}>
                    前台现付
                  </label>
                  </div>
                  </div>



              <div class="form-group has-success">
                <label class="control-label">服务选项</label>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="果岭" name="server[]" {$checked_1}>
                    果岭
                  </label>
                  </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="球童" name="server[]" {$checked_2}>
                    球童
                  </label>
                  </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="球车" name="server[]" {$checked_3}>
                    球车
                  </label>
                  </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="衣柜" name="server[]" {$checked_4}>
                    衣柜
                  </label>
                  </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="午餐" name="server[]" {$checked_5}>
                    午餐
                  </label>
                  </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="球差价" name="server[]" {$checked_6}>
                    球差价
                  </label>
                  </div>
                  </div>


                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">差价金额</label>
                        <input class="form-control" value="{$row['difference']}" name="difference">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">地址</label>
                        <input class="form-control" value="{$row['address']}" name="address">
                      </div>
                    </div>


                <div class="form-group has-success">
                  <div class="form-group">
                     <label class="control-label" for="inputSuccess">备注</label>
                    <textarea class="form-control" rows="3" name="remark" value="{$row['remark']}">{$row['remark']}</textarea>
                  </div>
                  </div>

html;
        $sql="select * from tbl_product_pic where product_id=".$product_id."";
        $query=$_SC['db']->query($sql);
        $url_arr=$_SC['db']->fetch_array($query);
        $url=$url_arr['url'];
        echo <<<html

                <img src="{$url_arr['url']}" width="500px" title="{$url_arr['pic_name']}">
                <div class="form-group has-success">
                   <div class="form-group">
                    <label class="control-label" for="inputSuccess">更换新图片</label>
                    <input type="file" name="picture_id">
                  </div>
                  </div>


              <button type="submit" class="btn btn-default" name="product_update">提  交</button>
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
    if(isset($_POST['product_update'])){
        $payment=implode(",",$_POST['payment']);


            $sql="UPDATE `tbl_product_info` SET `product_name` ='".daddslashes($_POST['product_name'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `district` ='".daddslashes($_POST['district'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `is_member` ='".daddslashes($_POST['is_member'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);

            $sql="UPDATE `tbl_product_info` SET `normal_price` ='".daddslashes($_POST['normal_price'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `holiday_price` ='".daddslashes($_POST['holiday_price'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `preset_time` ='".daddslashes($_POST['preset_time'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `address` ='".daddslashes($_POST['address'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);



            $sql="UPDATE `tbl_product_info` SET `remark` ='".daddslashes($_POST['remark'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);



            $sql="UPDATE `tbl_product_info` SET `difference` ='".daddslashes($_POST['difference'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


        $sql="UPDATE `tbl_product_info` SET `last_modified_time` =".time()." WHERE `product_id` =$product_id ";
        $_SC['db']->query($sql);


        $sql="UPDATE `tbl_product_info` SET `payment` ='".$payment."' WHERE `product_id` =$product_id ";
        $_SC['db']->query($sql);


        $sql="UPDATE `tbl_product_info` SET `last_modified_time` =".time()." WHERE `product_id` =$product_id ";
        $_SC['db']->query($sql);

        $sql="delete from tbl_golf_sever where product_id='".$product_id."'";
        $query=$_SC['db']->query($sql);
        if(is_array($_POST['server'])){
            foreach($_POST['server'] as $v){
                $sql="insert into tbl_golf_sever (product_id,sever_content) value ('".$product_id."','".daddslashes($v)."')";
                $_SC['db']->query($sql);
            }
        }


        if($_FILES['picture_id']['error']=='0'){
            $pic_type_array=array('bmp','jpg','jpeg','png','gif');
            //获取图片后缀名
            $pic_type_name=pathinfo($_FILES['picture_id']['name'], PATHINFO_EXTENSION);
            if(in_array($pic_type_name,$pic_type_array)){
                $time=time();
                $tmp = str_replace('\\\\', '\\', $_FILES['picture_id']['tmp_name']);
                $move=move_uploaded_file($tmp,'./image/product/product/'.date(Ymd).$time.".".$pic_type_name);
                if($move){
                    $url="image/product/product/".date(Ymd).$time.".".$pic_type_name;
                    $sql="select * from tbl_product_pic where product_id='".$product_id."'";
                    $row=$_SC['db']->fetch_array($_SC['db']->query($sql));
                    if (file_exists($row['url'])) {
                        unlink($row['url']);
                    }
                    $sql="delete from tbl_product_pic where product_id='".$product_id."'";
                    $_SC['db']->query($sql);
                    $sql="insert into tbl_product_pic (product_id,url,pic_name) value (".$product_id.",'".daddslashes($url)."','".daddslashes($_FILES['picture_id']['name'])."')";
                    $_SC['db']->query($sql);
                }else{
                    echo "<script>alert('提示:图片上传失败');history.go(-1)</script>";
                }
            }else{
                echo "<script>alert('提示:图片文件类型错误');history.go(-1)</script>";
            }
        }


        $sql=" insert into tbl_op_record (op_type, op_user,product_id,op_time) value ('".daddslashes($op_type)."','".daddslashes($booker)."',".$product_id.",".time().")";
        $_SC['db']->query($sql);
        echo "<script>alert('提示:更新完成');location.href='index.php?do=golf&ac=edit';</script>";
    }
}




function product_view($product_id){
    global $_SC;
    if(isset($product_id)){
        get_header();
        get_left_menu();
        $sql="select * from tbl_product_info where product_id='".$product_id."'";
        $query=$_SC['db']->query($sql);
        $row=$_SC['db']->fetch_array($query);
        $sql="select * from tbl_product_pic where product_id=".$product_id."";
        $query=$_SC['db']->query($sql);
        $url_arr=$_SC['db']->fetch_array($query);
        if($row['is_spot']=="会员制"){
            $checked_a="checked";
        }else{
            $checked_b="checked";
        }

        $golf_server=golf_server($row['product_id']);

        foreach($golf_server as $value){
            if($value['sever_content']=="果岭")
                $checked_1=checked;
            elseif($value['sever_content']=="球童")
                $checked_2=checked;
            elseif($value['sever_content']=="球车")
                $checked_3=checked;
            elseif($value['sever_content']=="衣柜")
                $checked_4=checked;
            elseif($value['sever_content']=="午餐")
                $checked_5=checked;
            elseif($value['sever_content']=="球差价")
                $checked_6=checked;
        }


        $arr_tmp=explode(",",$row['payment']);
        foreach($arr_tmp as $v){
            if($v=="预付"){
                $checked_payment_1="checked";
            }
            if($v=="前台现付"){
                $checked_payment_2="checked";
            }
        }

        echo <<<html
         <div id="page-wrapper">
             <div class="">
                  <ol class="breadcrumb">
                      <li><a href="index.php?do=golf&ac=edit"><i class="icon-dashboard"></i> 高尔夫场地管理</a></li>
                      <li class="active"><i class="icon-edit"></i> 高尔夫场地查看</li>
                  </ol>
            <div class="row">
            <fieldset disabled>
                <div class="col-lg-6">
                    <div class="form-group has-success">
                       <div class="form-group">
                        <label class="control-label" for="inputSuccess">球场名</label>
                        <input class="form-control" value="{$row['product_name']}" name="product_name">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">地区</label>
                        <input class="form-control" value="{$row['district']}" name="district">
                      </div>
                    </div>


                  <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">会员制/非会员制</label>
                    <label class="radio-inline">
                      <input type="radio" name="is_member" id="optionsRadiosInline1" value="会员制" {$checked_a}> 会员制
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="is_member" id="optionsRadiosInline2" value="会员制" {$checked_b}> 会员制
                    </label>
                  </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">平日价格</label>
                        <input class="form-control" value="{$row['normal_price']}" name="normal_price">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">假日价格</label>
                        <input class="form-control" value="{$row['holiday_price']}" name="holiday_price">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">预定时间</label>
                        <input class="form-control" value="{$row['preset_time']}" name="preset_time">
                      </div>
                    </div>


              <div class="form-group has-success">
                <label class="control-label">预付/现付</label>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="预付" name="payment[]" {$checked_payment_1}>
                    预付
                  </label>
                  </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="前台现付" name="payment[]" {$checked_payment_2}>
                    前台现付
                  </label>
                  </div>
                  </div>

              <div class="form-group has-success">
                <label class="control-label">服务选项</label>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="果岭" name="server[]" {$checked_1}>
                    果岭
                  </label>
                  </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="球童" name="server[]" {$checked_2}>
                    球童
                  </label>
                  </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="球车" name="server[]" {$checked_3}>
                    球车
                  </label>
                  </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="衣柜" name="server[]" {$checked_4}>
                    衣柜
                  </label>
                  </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="午餐" name="server[]" {$checked_5}>
                    午餐
                  </label>
                  </div>
                 <div class="checkbox">
                  <label>
                    <input type="checkbox" value="球差价" name="server[]" {$checked_6}>
                    球差价
                  </label>
                  </div>
                  </div>

            <div id="show">
                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">差价金额</label>
                        <input class="form-control" value="{$row['difference']}" name="difference">
                      </div>
                    </div>
            </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">地址</label>
                        <input class="form-control" value="{$row['address']}" name="address">
                      </div>
                    </div>



                  <div class="form-group">
                    <label>备注</label>
                    <textarea class="form-control" rows="3" name="remark" value="{$row['remark']}">{$row['remark']}</textarea>
                  </div>
                </fieldset>
                <img src="{$url_arr['url']}" width="500px" title="{$url_arr['pic_name']}">

html;
        echo <<<html
                </div>
             </div>
          </div>
        </div>
html;
    }else{
        echo "<script>alert('警告:非法参数');history.go(-1)</script>";
    }
}





function product_delete($product_id,$booker){
    $is_delete="1";
    $op_type="删除";
    global $_SC;
    $sql="UPDATE `tbl_product_info` SET `is_delete` =".$is_delete." WHERE `product_id` =$product_id ";
    $_SC['db']->query($sql);
    $sql="UPDATE `tbl_product_info` SET `last_modified_time` =".time()." WHERE `product_id` =$product_id ";
    $query=$_SC['db']->query($sql);
    if($query){
        $sql=" insert into tbl_op_record (op_type, op_user,product_id,op_time) value ('".daddslashes($op_type)."','".daddslashes($booker)."',".$product_id.",".time().")";
        $query=$_SC['db']->query($sql);
        echo "<script>alert('提示:删除成功');location.href='index.php?do=golf&ac=edit';</script>";
    }
}
?>


<script>
    function CommandConfirm_server(){
        if(window.confirm("提示:确定要删除此记录？")){
            return true;
        }else{
            return false;
        }
    }
</script>