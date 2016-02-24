<?php
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
    $in_class="4";
    $op_type="新建";
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=club&ac=edit"><i class="icon-dashboard"></i> 会所管理</a></li>
              <li class="active"><i class="icon-edit"></i> 会所登记</li>
          </ol>
        <div class="row">
          <div class="col-lg-6">
            <form role="form" action="index.php?do=club&ac=add" method="post" enctype="multipart/form-data">
                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">会所名</label>
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
                        <label class="control-label" for="inputSuccess">地区</label>
                        <input class="form-control" value="" name="district">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">会所功能</label>
                        <input class="form-control" value="" name="club_function">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">低消</label>
                        <input class="form-control" value="" name="minimum_charge">
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
                        <label class="control-label" for="inputSuccess">预定时间（提前几天）</label>
                        <input class="form-control" value="" name="preset_time">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">地址</label>
                        <input class="form-control" value="" name="address">
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
        }elseif(empty($_POST['hotel_lxr'])){
            echo "<script>alert('警告:酒店联系人不能为空');history.go(-1)</script>";
        }elseif(empty($_POST['hotel_phone'])){
            echo "<script>alert('警告:联系方式不能为空');history.go(-1)</script>";
        }else{
            $sql="insert into tbl_product_info (in_class,product_name,hotel_lxr,hotel_phone,district,club_function,minimum_charge,is_member,avgprice,park,preset_time,address,remark,booker,booker_department,create_time,last_modified_time,city) value (".$in_class.",'".daddslashes($_POST['product_name'])."','".daddslashes($_POST['hotel_lxr'])."','".daddslashes($_POST['hotel_phone'])."','".daddslashes($_POST['district'])."','".daddslashes($_POST['club_function'])."','".daddslashes($_POST['minimum_charge'])."','".daddslashes($_POST['is_member'])."','".daddslashes($_POST['avgprice'])."','".daddslashes($_POST['park'])."','".daddslashes($_POST['preset_time'])."','".daddslashes($_POST['address'])."','".daddslashes($_POST['remark'])."','".daddslashes($booker)."','".daddslashes($booker_department_id_id)."',".time().",".time().",'".daddslashes($_POST['city'])."')";
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
            echo "<script>alert('提示:登记成功');location.href='index.php?do=club&ac=edit';</script>";
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
              <a href="index.php?do=club&ac=add"><button type="button" class="btn btn-default btn-1g btn-block" style="height:500px "><h1>会所登记</h1></button></a>
            </p>
    </div>
        <div class="col-lg-6 col-md-9">

                <p>
              <a href="index.php?do=club&ac=edit"><button type="button" class="btn btn-default btn-lg btn-block" style="height:500px "><h1>会所更新</h1></button></a>
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
                      <li><a href="index.php?do=club&ac=edit"><i class="icon-dashboard"></i> 会所列表</a></li>
                      <li class="active"><i class="icon-edit"></i> 会所管理</li>
                  </ol>
                  <ol class="breadcrumb">
                  <div class="col-lg-12">
                  <a href="index.php?do=club&ac=add"><button type="button" class="btn btn-primary btn-1g btn-block" style="">会所登记</button></a>
                  </div>
                  </ol>

                  <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>会所名 </th>
                    <th>酒店联系人</th>
                    <th>联系方式</th>
                    <th>城市</th>
                    <th>地区 </th>
                    <th>会所功能</th>
                    <th>低消 </th>
                    <th>会员制/非会员制</th>
                    <th>人均消费 </th>
                    <th>泊车 </th>
                    <th>预定时间 </th>
                    <th>地址 </th>
                    <th>备注 </th>
                    <th>操作 </th>
                  </tr>
                </thead>


html;

    $pageSize = 10;
    $totalCountsql= "SELECT count(*) as t FROM  tbl_product_info where in_class=4 and is_delete=0";
    $query_s = $_SC['db']->query($totalCountsql);
    $rs = $_SC['db']->fetch_array($query_s);
    $totalCount = $rs['t'];
    $pageUrl = './index.php?do=club&ac=edit&page=';
    $sql="SELECT * FROM  tbl_product_info where in_class=4 and is_delete=0 limit " . (($_GET['page']- 1) * $pageSize) . ",$pageSize";
    $query=$_SC['db']->query($sql);
    while($row=$_SC['db']->fetch_array($query)){
        echo <<<html
                <tbody>
                  <tr>
                    <td><a href="index.php?do=club&ac=view&product_id={$row['product_id']}"> {$row['product_name']}</a></td>
                    <td>{$row['hotel_lxr']}</td>
                    <td>{$row['hotel_phone']}</td>
                    <td>{$row['city']}</td>
                    <td>{$row['district']}</td>
                    <td>{$row['club_function']}</td>
                    <td>{$row['minimum_charge']}</td>
                    <td>{$row['is_member']}</td>
                    <td>{$row['avgprice']}</td>
                    <td>{$row['park']}</td>
                    <td>{$row['preset_time']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['remark']}</td>
                    <td>
                    <a href="index.php?do=club&ac=view&&product_id={$row['product_id']}"><button type="button" class="btn btn-primary btn-xs" >查看</button></a>
                    <a href="index.php?do=club&ac=update&product_id={$row['product_id']}"><button type="button" class="btn btn-primary btn-xs" >更新</button></a>
                    <a href="index.php?do=club&ac=delete&product_id={$row['product_id']}" onclick="return CommandConfirm_server()"><button type="button" class="btn btn-primary btn-xs" >删除</button></a>
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
        $product_pdf_url=product_pdf_url($row['product_id']);
        $pic_url=product_pic_url($row['product_id']);
        if($row['is_member']=="会员制"){
            $checked_a="checked";
        }else{
            $checked_b="checked";
        }

        echo <<<html
    <div id="page-wrapper">
    <div class="">
          <ol class="breadcrumb">
              <li><a href="index.php?do=club&ac=edit"><i class="icon-dashboard"></i> 会所管理</a></li>
              <li class="active"><i class="icon-edit"></i> 会所更新</li>
          </ol>
        <div class="row">
          <div class="col-lg-6">
            <form role="form" action="index.php?do=club&ac=update&product_id={$product_id}" method="post" enctype="multipart/form-data">
                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">会所名</label>
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
                        <label class="control-label" for="inputSuccess">地区</label>
                        <input class="form-control" value="{$row['district']}" name="district">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">会所功能</label>
                        <input class="form-control" value="{$row['club_function']}" name="club_function">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">低消</label>
                        <input class="form-control" value="{$row['minimum_charge']}" name="minimum_charge">
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
                        <label class="control-label" for="inputSuccess">备注</label>
                        <textarea class="form-control" rows="3" name="remark" value="{$row['remark']}">{$row['remark']}</textarea>
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
                    <label class="control-label" for="inputSuccess">更换新图片</label>
                    <input type="file" name="picture_id">
                    <img src="{$pic_url['url']}" width="500px" title="{$pic_url['pic_name']}">
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
        if(!empty($_POST['hotel_lxr'])){
            $sql="UPDATE `tbl_product_info` SET `hotel_lxr` ='".daddslashes($_POST['hotel_lxr'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['hotel_phone'])){
            $sql="UPDATE `tbl_product_info` SET `hotel_phone` ='".daddslashes($_POST['hotel_phone'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['district'])){
            $sql="UPDATE `tbl_product_info` SET `district` ='".daddslashes($_POST['district'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['club_function'])){
            $sql="UPDATE `tbl_product_info` SET `club_function` ='".daddslashes($_POST['club_function'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['minimum_charge'])){
            $sql="UPDATE `tbl_product_info` SET `minimum_charge` ='".daddslashes($_POST['minimum_charge'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['is_member'])){
            $sql="UPDATE `tbl_product_info` SET `is_member` ='".daddslashes($_POST['is_member'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['avgprice'])){
            $sql="UPDATE `tbl_product_info` SET `avgprice` ='".daddslashes($_POST['avgprice'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['park'])){
            $sql="UPDATE `tbl_product_info` SET `park` ='".daddslashes($_POST['park'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }

        if(!empty($_POST['preset_time'])){
            $sql="UPDATE `tbl_product_info` SET `preset_time` ='".daddslashes($_POST['preset_time'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['address'])){
            $sql="UPDATE `tbl_product_info` SET `address` ='".daddslashes($_POST['address'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['remark'])){
            $sql="UPDATE `tbl_product_info` SET `remark` ='".daddslashes($_POST['remark'])."' WHERE `product_id` =$product_id ";
            $_SC['db']->query($sql);
        }
        if(!empty($_POST['city'])){
            $sql="UPDATE `tbl_product_info` SET `city` ='".daddslashes($_POST['city'])."' WHERE `product_id` =$product_id ";
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
        echo "<script>alert('提示:更新完成');location.href='index.php?do=club&ac=edit';</script>";
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
        $product_pdf_url=product_pdf_url($row['product_id']);
        if($row['is_member']=="会员制"){
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
                      <li><a href="index.php?do=club&ac=edit"><i class="icon-dashboard"></i> 会所管理</a></li>
                      <li class="active"><i class="icon-edit"></i> 会所查看</li>
                  </ol>
            <div class="row">
            <fieldset disabled>
                <div class="col-lg-6">
                    <div class="form-group has-success">
                       <div class="form-group">
                        <label class="control-label" for="inputSuccess">会所名</label>
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
                        <label class="control-label" for="inputSuccess">地区</label>
                        <input class="form-control" value="{$row['district']}" name="district">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">会所功能</label>
                        <input class="form-control" value="{$row['club_function']}" name="club_function">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">低消</label>
                        <input class="form-control" value="{$row['minimum_charge']}" name="minimum_charge">
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
                    <label class="control-label" for="inputSuccess">上传新文件(合同)</label>
                    <input type="file" name="contract">
                    <label class="control-label" for="inputSuccess"><a href="{$product_pdf_url['pdf_url']}" target="_blank">原文件({$product_pdf_url['pdf_name']})</a></label>
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
        echo "<script>alert('提示:删除成功');location.href='index.php?do=club&ac=edit';</script>";
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