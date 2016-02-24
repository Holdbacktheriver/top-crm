<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-11-1
 * Time: 下午5:59
 * To change this template use File | Settings | File Templates.
 * 臻品
 */
session_verify($_SESSION['username']);

$user_id=$_SESSION['user_id'];
$booker=$_SESSION['name'];
$booker_department_id=$_SESSION['department_id'];
$acs = array('view','edit','delete','add','manage','update');
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
    $in_class="1";
    $op_type="新建";
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=product&ac=edit"><i class="icon-dashboard"></i> 臻品管理</a></li>
              <li class="active"><i class="icon-edit"></i> 臻品登记</li>
          </ol>
        <div class="row">
          <div class="col-lg-6">
            <form role="form" action="index.php?do=product&ac=add" method="post" enctype="multipart/form-data">
                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">产品名</label>
                        <input class="form-control" value="" name="product_name">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">型号</label>
                        <input class="form-control" value="" name="model">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">尺寸</label>
                        <input class="form-control" value="" name="product_size">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">颜色</label>
                        <input class="form-control" value="" name="color">
                      </div>
                    </div>

                  <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">预定/现货</label>
                    <label class="radio-inline">
                      <input type="radio" name="is_spot" id="optionsRadiosInline1" value="预定" checked> 预定
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="is_spot" id="optionsRadiosInline2" value="现货"> 现货
                    </label>
                  </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">到货预计时间</label>
                        <input class="form-control" value="" name="delivery">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">供应商联系人</label>
                        <input class="form-control" value="" name="supplier">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">臻客价</label>
                        <input class="form-control" value="" name="price">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">市场价</label>
                        <input class="form-control" value="" name="market_price">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                    <label class="control-label" for="inputSuccess">图片(宽度不能超过500PX)</label>
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
            $sql="insert into tbl_product_info (in_class,product_name,model,product_size,color,is_spot,delivery,supplier,price,market_price,remark,booker,booker_department,create_time,last_modified_time) value (".$in_class.",'".daddslashes($_POST['product_name'])."','".daddslashes($_POST['model'])."','".daddslashes($_POST['product_size'])."','".daddslashes($_POST['color'])."','".daddslashes($_POST['is_spot'])."','".daddslashes($_POST['delivery'])."','".daddslashes($_POST['supplier'])."','".daddslashes($_POST['price'])."','".daddslashes($_POST['market_price'])."','".daddslashes($_POST['remark'])."','".daddslashes($booker)."','".daddslashes($booker_department_id)."',".time().",".time().")";
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
            echo "<script>alert('提示:登记成功');location.href='index.php?do=product&ac=edit';</script>";
        }
    }
}



//function product_list(){
//    global $_SC;
//    get_header();
//    get_left_menu();
//    echo <<<html
//        <div id="page-wrapper">
//              <div class="">
//                  <ol class="breadcrumb">
//                      <li><a href="index.php?do=product&ac=list"><i class="icon-dashboard"></i> 臻品管理</a></li>
//                      <li class="active"><i class="icon-edit"></i> 臻品列表</li>
//                  </ol>
//                <div class="row">
//                  <div class="col-lg-12">
//            <div class="table-responsive">
//              <table class="table table-bordered table-hover tablesorter">
//                <thead>
//                  <tr>
//                    <th>产品名 <i class="icon-sort"></i></th>
//                    <th>型号 <i class="icon-sort"></i></th>
//                    <th>尺寸 <i class="icon-sort"></i></th>
//                    <th>颜色 <i class="icon-sort"></i></th>
//                    <th>预定/现货 <i class="icon-sort"></i></th>
//                    <th>到货预计时间 <i class="icon-sort"></i></th>
//                    <th>供应商联系人 <i class="icon-sort"></i></th>
//                    <th>臻客价 <i class="icon-sort"></i></th>
//                    <th>市场价 <i class="icon-sort"></i></th>
//                    <th>备注 <i class="icon-sort"></i></th>
//                    <th>操作 <i class="icon-sort"></i></th>
//                  </tr>
//                </thead>
//
//
//html;
//
//    $sql="SELECT * FROM  tbl_product_info where in_class=1 and is_delete=0";
//    $query=$_SC['db']->query($sql);
//    while($row=$_SC['db']->fetch_array($query)){
//    echo <<<html
//                <tbody>
//                  <tr>
//                    <td>{$row['product_name']}</td>
//                    <td>{$row['model']}</td>
//                    <td>{$row['product_size']}</td>
//                    <td>{$row['color']}</td>
//                    <td>{$row['is_spot']}</td>
//                    <td>{$row['delivery']}</td>
//                    <td>{$row['supplier']}</td>
//                    <td>{$row['price']}</td>
//                    <td>{$row['market_price']}</td>
//                    <td>{$row['remark']}</td>
//                    <td>
//                    <a href="index.php?do=product&ac=view&product_id={$row['product_id']}"><button type="button" class="btn btn-primary btn-xs" >详细信息</button></a>
//                    </td>
//                  </tr>
//html;
//    }
//
//    echo <<<html
//                </tbody>
//              </table>
//            </div>
//
//                  </div>
//                </div>
//              </div>
//        </div>
//html;
//
//}



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
              <a href="index.php?do=product&ac=add"><button type="button" class="btn btn-default btn-1g btn-block" style="height:500px "><h1>臻品登记</h1></button></a>
            </p>
    </div>
        <div class="col-lg-6 col-md-9">

                <p>
              <a href="index.php?do=product&ac=edit"><button type="button" class="btn btn-default btn-lg btn-block" style="height:500px "><h1>臻品更新</h1></button></a>
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
                      <li><a href="index.php?do=product&ac=edit"><i class="icon-dashboard"></i> 臻品列表</a></li>
                      <li class="active"><i class="icon-edit"></i> 臻品管理</li>
                  </ol>
                  <ol class="breadcrumb">
                  <div class="col-lg-12">
                  <a href="index.php?do=product&ac=add"><button type="button" class="btn btn-primary btn-1g btn-block" style="">臻品登记</button></a>
                  </div>
                  </ol>

                  <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>产品名</th>
                    <th>型号</th>
                    <th>尺寸</th>
                    <th>颜色 </th>
                    <th>预定/现货 </th>
                    <th>到货预计时间 </th>
                    <th>供应商联系人 </th>
                    <th>臻客价 </th>
                    <th>市场价 </th>
                    <th class="col-lg-2">图片(点击查看大图)</th>
                    <th>备注 </th>
                    <th>操作 </th>
                  </tr>
                </thead>


html;
    $pageSize = 10;
    $totalCountsql="SELECT count(*) as t FROM  tbl_product_info where in_class=1 and is_delete=0";
    $query_s = $_SC['db']->query($totalCountsql);
    $rs = $_SC['db']->fetch_array($query_s);
    $totalCount = $rs['t'];
    $pageUrl = './index.php?do=product&ac=edit&page=';
    $sql="SELECT * FROM  tbl_product_info where in_class=1 and is_delete=0 limit " . (($_GET['page']- 1) * $pageSize) . ",$pageSize";
    $query=$_SC['db']->query($sql);
    while($row=$_SC['db']->fetch_array($query)){
        $pic_url=product_pic_url($row['product_id']);
        view_pic($pic_url['uid']);
        echo <<<html
                <tbody>
                  <tr>
                    <td><a href="index.php?do=product&ac=view&product_id={$row['product_id']}"> {$row['product_name']}</a></td>
                    <td>{$row['model']}</td>
                    <td>{$row['product_size']}</td>
                    <td>{$row['color']}</td>
                    <td>{$row['is_spot']}</td>
                    <td>{$row['delivery']}</td>
                    <td>{$row['supplier']}</td>
                    <td>{$row['price']}</td>
                    <td>{$row['market_price']}</td>
                    <td><a  href="#bigpic" data-toggle="modal"><img src="{$pic_url['url']}" width="150px"></a></td>
                    <td>{$row['remark']}</td>
                    <td>
                    <a href="index.php?do=product&ac=view&product_id={$row['product_id']}"><button type="button" class="btn btn-primary btn-xs" >查看</button></a>
                    <a href="index.php?do=product&ac=update&product_id={$row['product_id']}"><button type="button" class="btn btn-primary btn-xs" >更新</button></a>
                    <a href="index.php?do=product&ac=delete&product_id={$row['product_id']}" onclick="return CommandConfirm_server()"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
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
        if($row['is_spot']=="预定"){
            $checked_a="checked";
        }else{
            $checked_b="checked";
        }

        echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=product&ac=edit"><i class="icon-dashboard"></i> 臻品管理</a></li>
              <li class="active"><i class="icon-edit"></i> 臻品更新</li>
          </ol>
        <div class="row">
          <div class="col-lg-6">
            <form role="form" action="index.php?do=product&ac=update&product_id={$product_id}" method="post" enctype="multipart/form-data">
                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">产品名</label>
                        <input class="form-control" value="{$row['product_name']}" name="product_name">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">型号</label>
                        <input class="form-control" value="{$row['model']}" name="model">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">尺寸</label>
                        <input class="form-control" value="{$row['product_size']}" name="product_size">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">颜色</label>
                        <input class="form-control" value="{$row['color']}" name="color">
                      </div>
                    </div>

                  <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">预定/现货</label>
                    <label class="radio-inline">
                      <input type="radio" name="is_spot" id="optionsRadiosInline1" value="预定" {$checked_a}> 预定
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="is_spot" id="optionsRadiosInline2" value="现货" {$checked_b}> 现货
                    </label>
                  </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">到货预计时间</label>
                        <input class="form-control" value="{$row['delivery']}" name="delivery">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">供应商联系人</label>
                        <input class="form-control" value="{$row['supplier']}" name="supplier">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">臻客价</label>
                        <input class="form-control" value="{$row['price']}" name="price">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">市场价</label>
                        <input class="form-control" value="{$row['market_price']}" name="market_price">
                      </div>
                    </div>



                  <div class="form-group">
                    <label>备注</label>
                    <textarea class="form-control" rows="3" name="remark" value="">{$row['remark']}</textarea>
                  </div>


html;
        $sql="select * from tbl_product_pic where product_id=".$product_id."";
        $query=$_SC['db']->query($sql);
        $url_arr=$_SC['db']->fetch_array($query);
        echo <<<html

                <img src="{$url_arr['url']}" width="500px" title="{$url_arr['pic_name']}">
                <div class="form-group has-success">
                   <div class="form-group">
                    <label class="control-label" for="inputSuccess">更换新图片(宽度不能超过500PX)</label>
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
        if(!empty($_POST['model'])){
            $sql="UPDATE `tbl_product_info` SET `model` ='".daddslashes($_POST['model'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['product_size'])){
            $sql="UPDATE `tbl_product_info` SET `product_size` ='".daddslashes($_POST['product_size'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['color'])){
            $sql="UPDATE `tbl_product_info` SET `color` ='".daddslashes($_POST['color'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['is_spot'])){
            $sql="UPDATE `tbl_product_info` SET `is_spot` ='".daddslashes($_POST['is_spot'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['delivery'])){
            $sql="UPDATE `tbl_product_info` SET `delivery` ='".daddslashes($_POST['delivery'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['supplier'])){
            $sql="UPDATE `tbl_product_info` SET `supplier` ='".daddslashes($_POST['supplier'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['price'])){
            $sql="UPDATE `tbl_product_info` SET `price` ='".daddslashes($_POST['price'])."' WHERE `product_id` =$product_id ";
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
        echo "<script>alert('提示:更新完成');location.href='index.php?do=product&ac=edit';</script>";
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
        if($row['is_spot']=="预定"){
            $checked_a="checked";
        }else{
            $checked_b="checked";
        }
        $sql="select * from tbl_product_pic where product_id=".$product_id."";
        $query=$_SC['db']->query($sql);
        $url_arr=$_SC['db']->fetch_array($query);
        echo <<<html
         <div id="page-wrapper">
             <div class="">
                  <ol class="breadcrumb">
                      <li><a href="index.php?do=product&ac=edit"><i class="icon-dashboard"></i> 臻品管理</a></li>
                      <li class="active"><i class="icon-edit"></i> 臻品查看</li>
                  </ol>
            <div class="row">
            <fieldset disabled>
                <div class="col-lg-6">
                    <div class="form-group has-success">
                       <div class="form-group">
                        <label class="control-label" for="inputSuccess">产品名</label>
                        <input class="form-control" value="{$row['product_name']}" name="product_name">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">型号</label>
                        <input class="form-control" value="{$row['model']}" name="model">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">尺寸</label>
                        <input class="form-control" value="{$row['product_size']}" name="product_size">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">颜色</label>
                        <input class="form-control" value="{$row['color']}" name="color">
                      </div>
                    </div>

                  <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">预定/现货</label>
                    <label class="radio-inline">
                      <input type="radio" name="is_spot" id="optionsRadiosInline1" value="预定" {$checked_a}> 预定
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="is_spot" id="optionsRadiosInline2" value="现货" {$checked_b}> 现货
                    </label>
                  </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">到货预计时间</label>
                        <input class="form-control" value="{$row['delivery']}" name="delivery">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">供应商联系人</label>
                        <input class="form-control" value="{$row['supplier']}" name="supplier">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">臻客价</label>
                        <input class="form-control" value="{$row['price']}" name="price">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">市场价</label>
                        <input class="form-control" value="{$row['market_price']}" name="market_price">
                      </div>
                    </div>



                  <div class="form-group">
                    <label>备注</label>
                    <textarea class="form-control" rows="3" name="remark" value="">{$row['remark']}</textarea>
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
        echo "<script>alert('提示:删除成功');location.href='index.php?do=product&ac=edit';</script>";
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