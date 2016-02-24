<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-11-1
 * Time: 下午5:59
 * To change this template use File | Settings | File Templates.
 * 餐厅
 */
session_verify($_SESSION['username']);

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
    $in_class="2";
    $op_type="新建";
    $booker_department_id="it";
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=restaurant&ac=edit"><i class="icon-dashboard"></i> 餐厅管理</a></li>
              <li class="active"><i class="icon-edit"></i> 餐厅登记</li>
          </ol>
        <div class="row">
          <div class="col-lg-6">
            <form role="form" action="index.php?do=restaurant&ac=add" method="post" enctype="multipart/form-data">
                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">餐厅名</label>
                        <input class="form-control" value="" name="product_name">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">酒店联系人</label>
                        <input class="form-control" value="" name="hotel_lxr">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">联系方式</label>
                        <input class="form-control" value="" name="hotel_phone">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">低消（包房）</label>
                        <input class="form-control" value="" name="room_minimum">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">菜系</label>
                        <input class="form-control" value="" name="cuisine">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">人均消费</label>
                        <input class="form-control" value="" name="avgprice">
                      </div>
                    </div>



                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">泊车</label>
                        <input class="form-control" value="" name="park">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">预定时间</label>
                        <input class="form-control" value="" name="preset_time">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">地区（商圈）</label>
                        <input class="form-control" value="" name="district">
html;
//    get_district($row['district']);
    echo <<<html
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">预定电话</label>
                        <input class="form-control" value="" name="reservation_call">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">营业时间</label>
                        <input class="form-control" value="" name="business_hours">
                      </div>
                    </div>



                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">优惠内容</label>
                        <input class="form-control" value="" name="preferential">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">优惠内容期限</label>
                        <input class="form-control" value="" name="preferential_time">
                      </div>
                    </div>

              <div class="form-group has-success">
                <label class="control-label">合作商户</label>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="民生" name="partners[]">
                    民生
                  </label>
                  </div>

                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="运通" name="partners[]">
                    运通
                  </label>
                  </div>
                  </div>





                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">餐厅全国数量</label>
                        <input class="form-control" value="" name="total">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">餐厅联系人</label>
                        <input class="form-control" value="" name="restaurant_contacts">
                      </div>
                    </div>



                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">地址</label>
                        <input class="form-control" value="" name="address">
                      </div>
                    </div>

                 <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">图片(宽度不能超过500PX)</label>
                    <input type="file" name="picture_id">
                  </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">餐厅简介</label>
                        <textarea class="form-control" rows="3" name="information"></textarea>
                      </div>
                    </div>

                 <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">合同(请上传合同pdf文档)</label>
                    <input type="file" name="contract">
                  </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">城市</label>
                        <input class="form-control" value="" name="city">
                      </div>
                    </div>

                  <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">附件(请压缩后上传)</label>
                    <input type="file" name="attachment">
                  </div>

                  <div class="form-group has-success">
                    <label class="control-label" for="inputSuccess">备注</label>
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
        }elseif(empty($_POST['hotel_lxr'])){
            echo "<script>alert('警告:酒店联系人不能为空');history.go(-1)</script>";
        }elseif(empty($_POST['hotel_phone'])){
            echo "<script>alert('警告:联系方式不能为空');history.go(-1)</script>";
        }else{
            $partners=implode(",",$_POST['partners']);
//            $district=implode(",",$_POST['district']);
            $sql="insert into tbl_product_info (in_class,product_name,hotel_lxr,hotel_phone,room_minimum,cuisine,avgprice,park,preset_time,district,reservation_call,address,remark,booker,booker_department,create_time,last_modified_time,business_hours,information,preferential,preferential_time,partners,total,restaurant_contacts,city) value (".$in_class.",'".daddslashes($_POST['product_name'])."','".daddslashes($_POST['hotel_lxr'])."','".daddslashes($_POST['hotel_phone'])."','".daddslashes($_POST['room_minimum'])."','".daddslashes($_POST['cuisine'])."','".daddslashes($_POST['avgprice'])."','".daddslashes($_POST['park'])."','".daddslashes($_POST['preset_time'])."','".daddslashes($_POST['district'])."','".daddslashes($_POST['reservation_call'])."','".daddslashes($_POST['address'])."','".daddslashes($_POST['remark'])."','".daddslashes($booker)."','".daddslashes($booker_department_id)."',".time().",".time().",'".daddslashes($_POST['business_hours'])."','".daddslashes($_POST['information'])."','".daddslashes($_POST['preferential'])."','".daddslashes($_POST['preferential_time'])."','".$partners."','".daddslashes($_POST['total'])."','".daddslashes($_POST['restaurant_contacts'])."','".daddslashes($_POST['city'])."')";
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


            if($_FILES['attachment']['error']=='0'){
                $file_type_array=array('rar','zip','tar','cab','uue','jar','iso','z','7-zip','ace','lzh','arj','gzip','bz2');
                $file_type_name=pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
                if(in_array($file_type_name,$file_type_array)){
                    $time=time();
                    $tmp = str_replace('\\\\', '\\', $_FILES['attachment']['tmp_name']);
                    $move=move_uploaded_file($tmp,'./image/product/zip/'.date(Ymd).$time.'.'.$file_type_name);
                    if($move){
                        $url="image/product/zip/".date(Ymd).$time.'.'.$file_type_name;
                        $sql="insert into tbl_product_file (product_id,file_name,file_url) value (".$product_id.",'".daddslashes($_FILES['attachment']['name'])."','".daddslashes($url)."')";
                        $_SC['db']->query($sql);
                    }
                }else{
                    echo "<script>alert('提示:压缩文件类型错误');history.go(-1)</script>";
                }
            }

            if($_FILES['contract']['error']=='0'){
                $file_type_array=array('pdf');
                $file_type_name=pathinfo($_FILES['contract']['name'], PATHINFO_EXTENSION);
                if(in_array($file_type_name,$file_type_array)){
                    $time=time();
                    $tmp = str_replace('\\\\', '\\', $_FILES['contract']['tmp_name']);
                    $move=move_uploaded_file($tmp,'./image/product/pdf/'.date(Ymd).$time.'.'.$file_type_name);
                    if($move){
                        $url="image/product/pdf/".date(Ymd).$time.'.'.$file_type_name;
                        $sql="insert into tbl_product_pdf (product_id,pdf_name,pdf_url) value (".$product_id.",'".daddslashes($_FILES['contract']['name'])."','".daddslashes($url)."')";
                        $_SC['db']->query($sql);
                    }
                }else{
                    echo "<script>alert('提示:上传文件类型错误');history.go(-1)</script>";
                }
            }


            $sql=" insert into tbl_op_record (op_type, op_user,product_id,op_time) value ('".daddslashes($op_type)."','".daddslashes($booker)."',".$product_id.",".time().")";
            $_SC['db']->query($sql);
            echo "<script>alert('提示:登记成功');location.href='index.php?do=restaurant&ac=edit';</script>";
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
              <a href="index.php?do=restaurant&ac=add"><button type="button" class="btn btn-default btn-1g btn-block" style="height:500px "><h1>餐厅登记</h1></button></a>
            </p>
    </div>
        <div class="col-lg-6 col-md-9">

                <p>
              <a href="index.php?do=restaurant&ac=edit"><button type="button" class="btn btn-default btn-lg btn-block" style="height:500px "><h1>餐厅更新</h1></button></a>
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
                      <li><a href="index.php?do=restaurant&ac=edit"><i class="icon-dashboard"></i> 餐厅列表</a></li>
                      <li class="active"><i class="icon-edit"></i> 餐厅管理</li>
                  </ol>
                  <ol class="breadcrumb">
                  <div class="col-lg-12">
                  <a href="index.php?do=restaurant&ac=add"><button type="button" class="btn btn-primary btn-1g btn-block" style="">餐厅登记</button></a>
                  </div>
                  </ol>
html;
    search_restaurant_from();
    echo <<<html
                  <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>餐厅名</th>
                    <th>酒店联系人</th>
                    <th>联系方式</th>
                    <th>城市</th>
                    <th>低消（包房）</th>
                    <th>菜系 </th>
                    <th>人均消费 </th>
                    <th>泊车 </th>
                    <th>预定时间 </th>
                    <th>地区（商圈） </th>
                    <th>预定电话 </th>
                    <th>地址 </th>
                    <th class="col-lg-2">图片(点击查看大图)</th>
                    <th>备注 </th>
                    <th>操作 </th>
                  </tr>
                </thead>


html;
    $keyword=daddslashes($_GET['keyword']);
    $sql_and="and (product_name like '%".$_GET['keyword']."%' or district like '%".$_GET['keyword']."%' )";
    $pageSize = 15;
    $totalCountsql="SELECT count(*) as t FROM  tbl_product_info where in_class=2 and is_delete=0 $sql_and";
    $query_s = $_SC['db']->query($totalCountsql);
    $rs = $_SC['db']->fetch_array($query_s);
    $totalCount = $rs['t'];
    $pageUrl = "./index.php?do=restaurant&ac=edit&keyword=$keyword&page=";
    $sql="SELECT * FROM  tbl_product_info where in_class=2 and is_delete=0 $sql_and limit " . (($_GET['page']- 1) * $pageSize) . ",$pageSize";
    $query=$_SC['db']->query($sql);
    while($row=$_SC['db']->fetch_array($query)){
        $pic_url=product_pic_url($row['product_id']);
//        view_pic($pic_url['uid']);
 //      $district=get_district_name($row['district']);
        echo <<<html
                <tbody>
                  <tr>
                    <td><a href="index.php?do=restaurant&ac=view&product_id={$row['product_id']}"> {$row['product_name']}</a></td>
                    <td>{$row['hotel_lxr']}</td>
                    <td>{$row['hotel_phone']}</td>
                    <td>{$row['city']}</td>
                    <td>{$row['room_minimum']}</td>
                    <td>{$row['cuisine']}</td>
                    <td>{$row['avgprice']}</td>
                    <td>{$row['park']}</td>
                    <td>{$row['preset_time']}</td>
                    <td>{$row['district']}</td>
                    <td>{$row['reservation_call']}</td>
                    <td>{$row['address']}</td>
                    <td><a  href="#bigpic" data-toggle="modal"><img src="{$pic_url['url']}" width="150px"></a></td>
                    <td>{$row['remark']}</td>
                    <td>
                    <a href="index.php?do=restaurant&ac=view&product_id={$row['product_id']}"><button type="button" class="btn btn-primary btn-xs" >查看</button></a>
                    <a href="index.php?do=restaurant&ac=update&product_id={$row['product_id']}"><button type="button" class="btn btn-primary btn-xs" >更新</button></a>
                    <a href="index.php?do=restaurant&ac=delete&product_id={$row['product_id']}" onclick="return CommandConfirm_server()"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
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
        $pic_url=product_pic_url($row['product_id']);
        $product_file_url=product_file_url($row['product_id']);
        $product_pdf_url=product_pdf_url($row['product_id']);


        $arr_tmp=explode(",",$row['partners']);
        foreach($arr_tmp as $v){
            if($v=="民生"){
                $checked_partners_1="checked";
            }
            if($v=="运通"){
                $checked_partners_2="checked";
            }
        }

        echo <<<html
      <div id="page-wrapper">
       <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=restaurant&ac=edit"><i class="icon-dashboard"></i> 餐厅管理</a></li>
              <li class="active"><i class="icon-edit"></i> 餐厅更新</li>
          </ol>
        <div class="row">
          <div class="col-lg-6">
            <form role="form" action="index.php?do=restaurant&ac=update&product_id={$product_id}" method="post" enctype="multipart/form-data">
               <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">餐厅名</label>
                        <input class="form-control" value="{$row['product_name']}" name="product_name">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">酒店联系人</label>
                        <input class="form-control" value="{$row['hotel_lxr']}" name="hotel_lxr">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">联系方式</label>
                        <input class="form-control" value="{$row['hotel_phone']}" name="hotel_phone">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">低消（包房）</label>
                        <input class="form-control" value="{$row['room_minimum']}" name="room_minimum">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">菜系</label>
                        <input class="form-control" value="{$row['cuisine']}" name="cuisine">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">人均消费</label>
                        <input class="form-control" value="{$row['avgprice']}" name="avgprice">
                      </div>
                    </div>



                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">泊车</label>
                        <input class="form-control" value="{$row['park']}" name="park">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">预定时间</label>
                        <input class="form-control" value="{$row['preset_time']}" name="preset_time">
                      </div>
                    </div>



                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">地区（商圈）</label>
                         <input class="form-control" value="{$row['district']}" name="district">
html;
//        get_district($row['district']);
        echo <<<html
                      </div>
                    </div>



                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">预定电话</label>
                        <input class="form-control" value="{$row['reservation_call']}" name="reservation_call">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">营业时间</label>
                        <input class="form-control" value="{$row['business_hours']}" name="business_hours">
                      </div>
                    </div>




                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">优惠内容</label>
                        <input class="form-control" value="{$row['preferential']}" name="preferential">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">优惠内容期限</label>
                        <input class="form-control" value="{$row['preferential_time']}" name="preferential_time">
                      </div>
                    </div>



              <div class="form-group has-success">
                <label class="control-label">合作商户</label>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="民生" name="partners[]" {$checked_partners_1}>
                    民生
                  </label>
                  </div>

                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="运通" name="partners[]" {$checked_partners_2}>
                    运通
                  </label>
                  </div>
                  </div>



                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">餐厅全国数量</label>
                        <input class="form-control" value="{$row['total']}" name="total">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">餐厅联系人</label>
                        <input class="form-control" value="{$row['restaurant_contacts']}" name="restaurant_contacts">
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
                        <label class="control-label" for="inputSuccess">城市</label>
                        <input class="form-control" value="{$row['city']}" name="city">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">餐厅简介</label>
                        <textarea class="form-control" rows="3" name="information" value="{$row['information']}">{$row['information']}</textarea>
                      </div>
                    </div>

                  <div class="form-group">
                    <label>备注</label>
                    <textarea class="form-control" rows="3" name="remark" value="{$row['remark']}">{$row['remark']}</textarea>
                  </div>


                <div class="form-group has-success">
                   <div class="form-group">
                    <label class="control-label" for="inputSuccess">更换新图片</label>
                    <input type="file" name="picture_id">
                    <img src="{$pic_url['url']}" width="500px" title="{$pic_url['pic_name']}">
                  </div>
                  </div>

                 <div class="form-group has-success">
                   <div class="form-group">
                    <label class="control-label" for="inputSuccess">上传新文件(合同)</label>
                    <input type="file" name="contract">
                    <label class="control-label" for="inputSuccess"><a href="{$product_pdf_url['pdf_url']}" target="_blank">原文件({$product_pdf_url['pdf_name']})</a></label>
                  </div>
                  </div>

                <div class="form-group has-success">
                   <div class="form-group">
                   <label class="control-label" for="inputSuccess">上传新附件</label>
                    <input type="file" name="attachment">
                    <label class="control-label" for="inputSuccess"><a href="{$product_file_url['file_url']}" target="_blank">原附件({$product_file_url['file_name']})</a></label>
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

        $partners=implode(",",$_POST['partners']);



            $sql="UPDATE `tbl_product_info` SET `product_name` ='".daddslashes($_POST['product_name'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `hotel_lxr` ='".daddslashes($_POST['hotel_lxr'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `hotel_phone` ='".daddslashes($_POST['hotel_phone'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `room_minimum` ='".daddslashes($_POST['room_minimum'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `cuisine` ='".daddslashes($_POST['cuisine'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `avgprice` ='".daddslashes($_POST['avgprice'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `park` ='".daddslashes($_POST['park'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `preset_time` ='".daddslashes($_POST['preset_time'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            //$district=implode(",",$_POST['district']);
            $sql="UPDATE `tbl_product_info` SET `district` ='".daddslashes($_POST['district'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `reservation_call` ='".daddslashes($_POST['reservation_call'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `address` ='".daddslashes($_POST['address'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `remark` ='".daddslashes($_POST['remark'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `business_hours` ='".daddslashes($_POST['business_hours'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `information` ='".daddslashes($_POST['information'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `preferential` ='".daddslashes($_POST['preferential'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `preferential_time` ='".daddslashes($_POST['preferential_time'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `partners` ='".$partners."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `total` ='".daddslashes($_POST['total'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);

            $sql="UPDATE `tbl_product_info` SET `restaurant_contacts` ='".daddslashes($_POST['restaurant_contacts'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            //12.24
            $sql="UPDATE `tbl_product_info` SET `city` ='".daddslashes($_POST['city'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);


            $sql="UPDATE `tbl_product_info` SET `last_modified_time` =".time()." WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);



//修改图片

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



        //修改附件
        if($_FILES['attachment']['error']=='0'){
            $file_type_array=array('rar','zip','tar','cab','uue','jar','iso','z','7-zip','ace','lzh','arj','gzip','bz2');
            $file_type_name=pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
            if(in_array($file_type_name,$file_type_array)){
                $time=time();
                $tmp = str_replace('\\\\', '\\', $_FILES['attachment']['tmp_name']);
                $move=move_uploaded_file($tmp,'./image/product/zip/'.date(Ymd).$time.'.'.$file_type_name);
                if($move){
                    $url="image/product/zip/".date(Ymd).$time.'.'.$file_type_name;
                    $sql="select * from tbl_product_file where product_id='".$product_id."'";
                    $row=$_SC['db']->fetch_array($_SC['db']->query($sql));
                    if (file_exists($row['file_url'])) {
                        unlink($row['file_url']);
                    }
                    $sql="delete from tbl_product_file where product_id='".$product_id."'";
                    $_SC['db']->query($sql);
                    $sql="insert into tbl_product_file (product_id,file_url,file_name) value (".$product_id.",'".daddslashes($url)."','".daddslashes($_FILES['attachment']['name'])."')";
                    $_SC['db']->query($sql);
                }else{
                    echo "<script>alert('提示:文件上传失败');history.go(-1)</script>";
                }
            }else{
                echo "<script>alert('提示:压缩文件类型错误');history.go(-1)</script>";
            }
        }

        //修改合同
        if($_FILES['contract']['error']=='0'){
            $file_type_array=array('pdf');
            $file_type_name=pathinfo($_FILES['contract']['name'], PATHINFO_EXTENSION);
            if(in_array($file_type_name,$file_type_array)){
                $time=time();
                $tmp = str_replace('\\\\', '\\', $_FILES['contract']['tmp_name']);
                $move=move_uploaded_file($tmp,'./image/product/pdf/'.date(Ymd).$time.'.'.$file_type_name);
                if($move){
                    $url="image/product/pdf/".date(Ymd).$time.'.'.$file_type_name;
                    $sql="select * from tbl_product_pdf where product_id='".$product_id."'";
                    $row=$_SC['db']->fetch_array($_SC['db']->query($sql));
                    if (file_exists($row['pdf_url'])) {
                        unlink($row['pdf_url']);
                    }
                    $sql="delete from tbl_product_pdf where product_id='".$product_id."'";
                    $_SC['db']->query($sql);
                    $sql="insert into tbl_product_pdf (product_id,pdf_url,pdf_name) value (".$product_id.",'".daddslashes($url)."','".daddslashes($_FILES['contract']['name'])."')";
                    $_SC['db']->query($sql);
                }else{
                    echo "<script>alert('提示:文件上传失败');history.go(-1)</script>";
                }
            }else{
                echo "<script>alert('提示:上传文件类型错误');history.go(-1)</script>";
            }
        }

        $sql=" insert into tbl_op_record (op_type, op_user,product_id,op_time) value ('".daddslashes($op_type)."','".daddslashes($booker)."',".$product_id.",".time().")";
        $_SC['db']->query($sql);
        echo "<script>alert('提示:更新完成');location.href='index.php?do=restaurant&ac=edit';</script>";
    }





}




function product_view($product_id){
    global $_SC;
        get_header();
        get_left_menu();
        $sql="select * from tbl_product_info where product_id='".$product_id."'";
        $query=$_SC['db']->query($sql);
        $row=$_SC['db']->fetch_array($query);
        $pic_url=product_pic_url($row['product_id']);
        $product_file_url=product_file_url($row['product_id']);
        $product_pdf_url=product_pdf_url($row['product_id']);

        $arr_tmp=explode(",",$row['partners']);
        foreach($arr_tmp as $v){
            if($v=="民生"){
                $checked_partners_1="checked";
            }
            if($v=="运通"){
                $checked_partners_2="checked";
            }
        }

        echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=restaurant&ac=edit"><i class="icon-dashboard"></i> 餐厅管理</a></li>
              <li class="active"><i class="icon-edit"></i> 餐厅查看</li>
          </ol>
        <fieldset disabled>
               <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">餐厅名</label>
                        <input class="form-control" value="{$row['product_name']}" name="product_name">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">酒店联系人</label>
                        <input class="form-control" value="{$row['hotel_lxr']}" name="product_name">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">联系方式</label>
                        <input class="form-control" value="{$row['hotel_phone']}" name="product_name">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">低消（包房）</label>
                        <input class="form-control" value="{$row['room_minimum']}" name="room_minimum">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">菜系</label>
                        <input class="form-control" value="{$row['cuisine']}" name="cuisine">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">人均消费</label>
                        <input class="form-control" value="{$row['avgprice']}" name="avgprice">
                      </div>
                    </div>



                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">泊车</label>
                        <input class="form-control" value="{$row['park']}" name="park">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">预定时间</label>
                        <input class="form-control" value="{$row['preset_time']}" name="preset_time">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">地区（商圈）</label>
                        <input class="form-control" value="{$row['district']}" name="district">
html;
//    get_district($row['district']);
    echo <<<html
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">预定电话</label>
                        <input class="form-control" value="{$row['reservation_call']}" name="reservation_call">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">营业时间</label>
                        <input class="form-control" value="{$row['business_hours']}" name="business_hours">
                      </div>
                    </div>




                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">优惠内容</label>
                        <input class="form-control" value="{$row['preferential']}" name="preferential">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">优惠内容期限</label>
                        <input class="form-control" value="{$row['preferential_time']}" name="preferential_time">
                      </div>
                    </div>

              <div class="form-group has-success">
                <label class="control-label">合作商户</label>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="民生" name="partners[]" {$checked_partners_1}>
                    民生
                  </label>
                  </div>

                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="运通" name="partners[]" {$checked_partners_2}>
                    运通
                  </label>
                  </div>
                  </div>


                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">餐厅全国数量</label>
                        <input class="form-control" value="{$row['total']}" name="total">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">餐厅联系人</label>
                        <input class="form-control" value="{$row['restaurant_contacts']}" name="restaurant_contacts">
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
                        <label class="control-label" for="inputSuccess">餐厅简介</label>
                        <textarea class="form-control" rows="3" name="information" value="{$row['information']}">{$row['information']}</textarea>
                      </div>
                    </div>

                  <div class="form-group">
                    <label>备注</label>
                    <textarea class="form-control" rows="3" name="remark" value="{$row['remark']}">{$row['remark']}</textarea>
                  </div>

                   <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">城市</label>
                        <input class="form-control" value="{$row['city']}" name="city">
                      </div>
                    </div>


                <div class="form-group has-success">
                   <div class="form-group">
                    <label class="control-label" for="inputSuccess">更换新图片</label>
                    <input type="file" name="picture_id">
                    <img src="{$pic_url['url']}" width="500px" title="{$pic_url['pic_name']}">
                  </div>
                  </div>


                <div class="form-group has-success">
                   <div class="form-group">
                    <label class="control-label" for="inputSuccess">上传新文件(合同)</label>
                    <input type="file" name="contract">
                    <label class="control-label" for="inputSuccess"><a href="{$product_pdf_url['pdf_url']}" target="_blank">原文件({$product_pdf_url['pdf_name']})</a></label>
                  </div>
                  </div>


                <div class="form-group has-success">
                   <div class="form-group">
                   <label class="control-label" for="inputSuccess">上传新附件</label>
                    <input type="file" name="attachment">
                    <label class="control-label" for="inputSuccess"><a href="{$product_file_url['file_url']}" target="_blank">原附件({$product_file_url['file_name']})</a></label>
                  </div>
                  </div>
                </fieldset>




html;
        echo <<<html
                </div>
             </div>
          </div>
        </div>
html;

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
        echo "<script>alert('提示:删除成功');location.href='index.php?do=restaurant&ac=edit';</script>";
    }
}



//筛选from表单
function search_restaurant_from(){
    echo <<<html
               <ol class="breadcrumb">
                <div class="col-lg-12">
                <form role="form" action="index.php?do=restaurant&ac=edit" method="get" >
                   <table class="table table-bordered table-hover tablesorter">
                   <input type="hidden" name="do" value="restaurant">
                   <input type="hidden" name="ac" value="edit">

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