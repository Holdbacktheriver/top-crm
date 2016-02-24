<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-11-1
 * Time: 下午5:59
 * To change this template use File | Settings | File Templates.
 * 旅游线路
 */


$user_id=$_SESSION['user_id'];
$booker=$_SESSION['name'];
$booker_department_id=$_SESSION['department_id'];
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
    $in_class="6";
    $op_type="新建";
    $booker_department_id="it";
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=tour&ac=edit"><i class="icon-dashboard"></i> 旅游线路管理</a></li>
              <li class="active"><i class="icon-edit"></i> 旅游线路登记</li>
          </ol>
        <div class="row">
          <div class="col-lg-6">
            <form role="form" action="index.php?do=tour&ac=add" method="post" enctype="multipart/form-data">
                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">产品名</label>
                        <input class="form-control" placeholder="" name="product_name">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">出发时间</label>
                        <input class="form-control" placeholder="" name="go_time">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">截止报名时间</label>
                        <input class="form-control" placeholder="" name="enrolment_end">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">出发地</label>
                        <input class="form-control" placeholder="" name="departure">
                      </div>
                    </div>



                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">目的地</label>
                        <input class="form-control" placeholder="" name="destination">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">特色</label>
                        <input class="form-control" placeholder="" name="feature">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">天数</label>
                        <input class="form-control" placeholder="" name="days">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">预定周期</label>
                        <input class="form-control" placeholder="" name="predetermined_cycle">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">参考价</label>
                        <input class="form-control" placeholder="" name="market_price">
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
            $sql="insert into tbl_product_info (in_class,product_name,go_time,enrolment_end,departure,destination,feature,days,predetermined_cycle,market_price,remark,booker,booker_department,create_time,last_modified_time) value (".$in_class.",'".daddslashes($_POST['product_name'])."','".daddslashes($_POST['go_time'])."','".daddslashes($_POST['enrolment_end'])."','".daddslashes($_POST['departure'])."','".daddslashes($_POST['destination'])."','".daddslashes($_POST['feature'])."','".daddslashes($_POST['days'])."','".daddslashes($_POST['predetermined_cycle'])."','".daddslashes($_POST['market_price'])."','".daddslashes($_POST['remark'])."','".daddslashes($booker)."','".daddslashes($booker_department_id)."',".time().",".time().")";
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
            $sql=" insert into tbl_op_record (op_type, op_user,product_id,op_time) value ('".daddslashes($op_type)."','".daddslashes($booker)."',".$product_id.",".time().")";
            $_SC['db']->query($sql);
            echo "<script>alert('提示:登记成功');location.href='index.php?do=tour&ac=edit';</script>";
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
              <a href="index.php?do=tour&ac=add"><button type="button" class="btn btn-default btn-1g btn-block" style="height:500px "><h1>旅游线路登记</h1></button></a>
            </p>
    </div>
        <div class="col-lg-6 col-md-9">

                <p>
              <a href="index.php?do=tour&ac=edit"><button type="button" class="btn btn-default btn-lg btn-block" style="height:500px "><h1>旅游线路更新</h1></button></a>
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
    echo <<<html
        <div id="page-wrapper">
              <div class="">
                  <ol class="breadcrumb">
                      <li><a href="index.php?do=tour&ac=edit"><i class="icon-dashboard"></i> 旅游线路列表</a></li>
                      <li class="active"><i class="icon-edit"></i> 旅游线路管理</li>
                  </ol>
                  <ol class="breadcrumb">
                  <div class="col-lg-12">
                  <a href="index.php?do=tour&ac=add"><button type="button" class="btn btn-primary btn-1g btn-block" style="">旅游线路登记</button></a>
                  </div>
                  </ol>

                  <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>产品名 </th>
                    <th>出发时间 </th>
                    <th>截止报名时间 </th>
                    <th>出发地</th>
                    <th>目的地 </th>
                    <th>特色 </th>
                    <th>天数 </th>
                    <th>预定周期 </th>
                    <th>参考价 </th>
                    <th>备注 </th>
                    <th>操作 </th>
                  </tr>
                </thead>


html;
    $pageSize = 10;
    $totalCountsql="SELECT count(*) as t FROM  tbl_product_info where in_class=6 and is_delete=0";
    $query_s = $_SC['db']->query($totalCountsql);
    $rs = $_SC['db']->fetch_array($query_s);
    $totalCount = $rs['t'];
    $pageUrl = './index.php?do=club&ac=edit&page=';
    $sql="SELECT * FROM  tbl_product_info where in_class=6 and is_delete=0";
    $query=$_SC['db']->query($sql);
    while($row=$_SC['db']->fetch_array($query)){
        echo <<<html
                <tbody>
                  <tr>
                    <td><a href="index.php?do=tour&ac=view&product_id={$row['product_id']}"> {$row['product_name']}</a></td>
                    <td>{$row['go_time']}</td>
                    <td>{$row['enrolment_end']}</td>
                    <td>{$row['departure']}</td>
                    <td>{$row['destination']}</td>
                    <td>{$row['feature']}</td>
                    <td>{$row['days']}</td>
                    <td>{$row['predetermined_cycle']}</td>
                    <td>{$row['market_price']}</td>
                    <td>{$row['remark']}</td>
                    <td>
                    <a href="index.php?do=tour&ac=view&product_id={$row['product_id']}"><button type="button" class="btn btn-primary btn-xs" >查看</button></a>
                    <a href="index.php?do=tour&ac=update&product_id={$row['product_id']}"><button type="button" class="btn btn-primary btn-xs" >更新</button></a>
                    <a href="index.php?do=tour&ac=delete&product_id={$row['product_id']}" onclick="return CommandConfirm_server()"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
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
        $sql="select * from tbl_product_pic where product_id=".$product_id."";
        $query=$_SC['db']->query($sql);
        $url_arr=$_SC['db']->fetch_array($query);

        echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=tour&ac=edit"><i class="icon-dashboard"></i> 旅游线路管理</a></li>
              <li class="active"><i class="icon-edit"></i> 旅游线路更新</li>
          </ol>
        <div class="row">
          <div class="col-lg-6">
            <form role="form" action="index.php?do=tour&ac=update&product_id={$product_id}" method="post" enctype="multipart/form-data">
               <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">产品名</label>
                        <input class="form-control" placeholder="{$row['product_name']}" name="product_name">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">出发时间</label>
                        <input class="form-control" placeholder="{$row['go_time']}" name="go_time">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">截止报名时间</label>
                        <input class="form-control" placeholder="{$row['enrolment_end']}" name="enrolment_end">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">出发地</label>
                        <input class="form-control" placeholder="{$row['departure']}" name="departure">
                      </div>
                    </div>



                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">目的地</label>
                        <input class="form-control" placeholder="{$row['destination']}" name="destination">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">特色</label>
                        <input class="form-control" placeholder="{$row['feature']}" name="feature">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">天数</label>
                        <input class="form-control" placeholder="{$row['days']}" name="days">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">预定周期</label>
                        <input class="form-control" placeholder="{$row['predetermined_cycle']}" name="predetermined_cycle">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">参考价</label>
                        <input class="form-control" placeholder="{$row['market_price']}" name="market_price">
                      </div>
                    </div>



                  <div class="form-group">
                    <label>备注</label>
                    <textarea class="form-control" rows="3" name="remark" placeholder="{$row['remark']}"></textarea>
                  </div>



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
        if(!empty($_POST['product_name'])){
            $sql="UPDATE `tbl_product_info` SET `product_name` ='".daddslashes($_POST['product_name'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['go_time'])){
            $sql="UPDATE `tbl_product_info` SET `go_time` ='".daddslashes($_POST['go_time'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['enrolment_end'])){
            $sql="UPDATE `tbl_product_info` SET `enrolment_end` ='".daddslashes($_POST['enrolment_end'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['departure'])){
            $sql="UPDATE `tbl_product_info` SET `departure` ='".daddslashes($_POST['departure'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['destination'])){
            $sql="UPDATE `tbl_product_info` SET `destination` ='".daddslashes($_POST['destination'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['feature'])){
            $sql="UPDATE `tbl_product_info` SET `feature` ='".daddslashes($_POST['feature'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['days'])){
            $sql="UPDATE `tbl_product_info` SET `days` ='".daddslashes($_POST['days'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['predetermined_cycle'])){
            $sql="UPDATE `tbl_product_info` SET `predetermined_cycle` ='".daddslashes($_POST['predetermined_cycle'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['market_price'])){
            $sql="UPDATE `tbl_product_info` SET `market_price` ='".daddslashes($_POST['market_price'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['remark'])){
            $sql="UPDATE `tbl_product_info` SET `remark` ='".daddslashes($_POST['remark'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        $sql="UPDATE `tbl_product_info` SET `last_modified_time` =".time()." WHERE `product_id` =$product_id ";
        $_SC['db']->query($sql);


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
        echo "<script>alert('提示:更新完成');location.href='index.php?do=tour&ac=edit';</script>";
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
        echo <<<html
         <div id="page-wrapper">
             <div class="">
                  <ol class="breadcrumb">
                      <li><a href="index.php?do=tour&ac=edit"><i class="icon-dashboard"></i> 旅游线路管理</a></li>
                      <li class="active"><i class="icon-edit"></i> 旅游线路查看</li>
                  </ol>
            <div class="row">
            <fieldset disabled>
                <div class="col-lg-6">
                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">产品名</label>
                        <input class="form-control" placeholder="{$row['product_name']}" name="product_name">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">出发时间</label>
                        <input class="form-control" placeholder="{$row['go_time']}" name="go_time">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">截止报名时间</label>
                        <input class="form-control" placeholder="{$row['enrolment_end']}" name="enrolment_end">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">出发地</label>
                        <input class="form-control" placeholder="{$row['departure']}" name="departure">
                      </div>
                    </div>



                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">目的地</label>
                        <input class="form-control" placeholder="{$row['destination']}" name="destination">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">特色</label>
                        <input class="form-control" placeholder="{$row['feature']}" name="feature">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">天数</label>
                        <input class="form-control" placeholder="{$row['days']}" name="days">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">预定周期</label>
                        <input class="form-control" placeholder="{$row['predetermined_cycle']}" name="predetermined_cycle">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">参考价</label>
                        <input class="form-control" placeholder="{$row['market_price']}" name="market_price">
                      </div>
                    </div>



                  <div class="form-group">
                    <label>备注</label>
                    <textarea class="form-control" rows="3" name="remark" placeholder="{$row['remark']}"></textarea>
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
        echo "<script>alert('提示:删除成功');location.href='index.php?do=tour&ac=edit';</script>";
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