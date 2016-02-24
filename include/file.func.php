<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 14-8-14
 * Time: 13:29
 */

session_verify($_SESSION['username']);
$user=$_SESSION['username'];
$user_id=$_SESSION['user_id'];
$department_id=$_SESSION['department_id'];
$acs = array('edit','delfile','addfolder','list','view','delfolder','filelist');
$ac = (!empty($_GET['ac']) && in_array($_GET['ac'], $acs))?$_GET['ac']:'list';


switch ($ac){
    case 'edit':
        fileedit();
        break;
    case 'delfolder':
        delfolder();
        break;
    case 'addfolder':
        addfolder();
        break;
    case 'list':
        folderlist($user_id);
        break;
    case 'view':
        fileview($_GET['activitie_id']);
        break;
    case 'filelist':
        filelist($_GET['folder_id']);
        break;
    case 'delfile':
        delfile(daddslashes($_GET['file_id']));
        break;
}


function delfolder(){
    global $_SC;
    if(empty($_GET['folder_id'])){
        echo "<script>alert('提示:操作失败');history.go(-1)</script>";
    }else{
        $folder_id=daddslashes($_GET['folder_id']);
        $sql="update tbl_folderlist set is_delete='1' where folder_id='".$folder_id."'";
        $query=$_SC['db']->query($sql);
        echo "<script>alert('提示:操作成功');history.go(-1)</script>";

    }
}

function addfolder(){
    global $_SC;
    if(empty($_POST['folder_name'])){
        $tmp=array(
            'state'=>'400',
            'error'=>'文件夹名称不能为空'
        );
        echo json_encode($tmp);
    }else{
        $folder_name=daddslashes($_POST['folder_name']);
        $user_id=daddslashes($_POST['user_id']);
        $sql="insert into tbl_folderlist (folder_name,user_id) value ('".$folder_name."','".$user_id."')";
        $query=$_SC['db']->query($sql);
        if($query){
            $folder_id=$_SC['db']->insert_id();
            $tmp=array(
                'state'=>'200',
                'folder_id'=>$folder_id,
                'folder_name'=>$folder_name
            );
            echo json_encode($tmp);
        }else{
            $tmp=array(
                'state'=>'401',
                'error'=>'创建失败',

            );
            echo json_encode($tmp);
        }

    }
}


function delfile($file_id){
    global $_SC;
    $sql="select * from tbl_file_list where file_id='".$file_id."'";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    if(file_exists($rs['file_url'])){
        unlink($rs['file_url']);
    }

    $sql="DELETE FROM `tbl_file_list` WHERE file_id = '".$file_id."'";
    $query=$_SC['db']->query($sql);
    if($query){
        echo "<script>alert('提示:删除成功');history.go(-1)</script>";
    }
}



function filelist($folder_id){
    global $_SC;
    get_header();
    get_left_menu();
    echo <<<html
        <div id="page-wrapper">
          <ol class="breadcrumb">
              <li><a href="index.php?do=file&ac=list"><i class="icon-dashboard"></i> 文件夹列表</a></li>
          </ol>
          <div class="row">
          <div class="col-lg-12">


html;


    $sql="select * from tbl_folderlist where folder_id='".$folder_id."'";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    if($rs['is_open']==0){
        $sql="select * from tbl_file_list where folder_id = '".$folder_id."'";
        $query=$_SC['db']->query($sql);
        while($rs=$_SC['db']->fetch_array($query)){
            $suffix=pathinfo($rs['file_url'],PATHINFO_EXTENSION);
echo <<<html
        <ol>
         <a href="down.php?file_url={$rs['file_url']}&suffix={$suffix}&file_name={$rs['file_name']}" title="点击查看文件">
         <div class="col-sm-10 well well-sm">{$rs['file_name']}</div>
          </a>
          <div class="col-sm-2"><a href="index.php?do=file&ac=delfile&file_id={$rs['file_id']}" class="btn btn-default">删除</a></div>
        </ol>
html;


        }
    }else{
        echo "<script>alert('此文件没有公开');history.go(-1)</script>";
        exit();
    }



    echo <<<html
            <div class="row">


            <form action="#" method="post" enctype="multipart/form-data">

             <div class="col-lg-4">
             <input class="form-control" name="file"type="file">
             </div>
             <div class="col-lg-8">
            <button type="submit" class="btn btn-default">提  交</button>
            </div>
            </form>
            </div>


            </div>

	       </div>
	    </div>



html;

    if($_FILES['file']['error']=='0'){
        $file_type_array=array('txt','mp3','wav','aif','au','ram','rar','zip','doc','docx','dotx','dotm','docm','xlsx','xlsm','xltx','xltm','xls','xlsb','xlam','ppt','pptx','ppsx','pdf','bmp','jpg','jpeg','png','gif');
        $file_type_name=pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        if(in_array($file_type_name,$file_type_array)){
            $time=time();
            $year=date(Y);
            $month=date(m);
            $day=date(d);
            $tmp = str_replace('\\\\', '\\', $_FILES['file']['tmp_name']);
            if(!file_exists('./fileupload/'.$year.'/'.$month.'/'.$day.'/')){
                mkdir("./fileupload/$year/$month/$day",0777,true);
                chmod("fileupload/$year",0777);
                chmod("fileupload/$year/$month",0777);
                chmod("./fileupload/$year/$month/$day",0777);

            }


            $move=move_uploaded_file($tmp,'./fileupload/'.$year.'/'.$month.'/'.$day.'/'.date(Hi).$time.'.'.$file_type_name);
            if($move){
                $file_name=date(Hi).$time;
                $url="fileupload/$year/$month/$day/$file_name.$file_type_name";
                chmod("./fileupload/$year/$month/$day/$file_name.$file_type_name",0777);
            }

            $folder_id=daddslashes($_GET['folder_id']);
            $sql="insert into tbl_file_list (folder_id,file_name,file_url) value ('".$folder_id."','".$_FILES['file']['name']."','".$url."')";
            $query=$_SC['db']->query($sql);
            if($query){
                $tmp_url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                echo "<script>alert('提示:增加成功');location.href='".$tmp_url."';</script>";
            }

        }


    }


}






function folderlist($user_id){
    global $_SC;
    get_header();
    get_left_menu();
    if (!isset($_GET['page']) || $_GET['page'] == '') {
        $_GET['page'] = 1;
    }
    echo <<<html
        <div id="page-wrapper">
          <ol class="breadcrumb">
              <li><a href="index.php?do=file&ac=list"><i class="icon-dashboard"></i> 文件夹列表</a></li>
          </ol>
          <div class="row">
          <div class="col-lg-12">
          <div id="folder">


html;
    $pageSize = 10;
    $totalCountsql = "select count(*) as t from tbl_folderlist  where is_delete='0' and is_open='0' order by folder_id";
    $query_s = $_SC['db']->query($totalCountsql);
    $rs = $_SC['db']->fetch_array($query_s);
    $totalCount = $rs['t'];
    $pageUrl = './index.php?do=file&ac=list&page=';
    $sql="select * from tbl_folderlist  where is_delete='0'  and is_open='0'  order by folder_id desc limit " . (($_GET['page']- 1) * $pageSize) . ",$pageSize";

    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
    echo <<<html

                <ol class="folder">
                <a href="index.php?do=file&ac=filelist&folder_id={$rs['folder_id']}" title="点击查看文件">
                <div class="col-sm-10 well well-sm">{$rs['folder_name']}</div>
                </a>
                <div class="col-sm-2"><a href="index.php?do=file&ac=delfolder&folder_id={$rs['folder_id']}" class="btn btn-default">删除</a></div>
                </ol>



html;

    }

echo <<<html
        </div>

         <div class="form-group has-success">

         <div class="col-lg-10">
            <div class="form-group">
               <input class="form-control" placeholder="请输入文件夹名称" id="folder_name" name="folder_name"  type="text">
            </div>
          </div>
          <div class="col-lg-2">
          <button type="submit" id="addfolder" class="btn btn-default">创建</button>
          </div>
         </div>

html;



    include_once('./include/pagination.class.php');
    $pg = new pagination($totalCount, $pageSize, $pageUrl, 10, true, true, 'right');
    $pg->curPageNum = (($_GET['page'] > $pg->pageNum) or (intval($_GET['page']) <= 0)) ? 1 : $_GET['page'];
    echo $pg->generatePageNav();
    echo <<<html

            </div>
	       </div>
	    </div>

    <script type="text/javascript">
    $("#addfolder").click(function(){
        var folder_name = $("#folder_name").val();
        $.ajax({
        type: "post",
        url: "index.php?do=file&ac=addfolder",
        data: {folder_name:folder_name,user_id:{$user_id}},
        success: function(result){
            var obj = eval('(' + result + ')');
            var state = obj.state;
            if(state==400){
               alert(obj.error);
            }

            if(state==401){
               alert(obj.error);
            }


            if(state==200){
                $("#folder").before(
                '<ol class="folder">'+
                '<a href="index.php?do=file&ac=filelist&folder_id="'+ obj.folder_id + 'title="点击查看文件">'+
                '<div class="col-sm-10 well well-sm">'+ obj.folder_name +'</div>'+
                '</a>'+
                '<div class="col-sm-2"><a href="index.php?do=file&ac=delfolder&folder_id='+ obj.folder_id +'" class="btn btn-default">删除</a></div>'+
                '</ol>'
              );
              scrollOffset($(".folder:first").offset());
              $("#folder_name").val("");
            }

      }});
    })


    function scrollOffset(scroll_offset) {
        $("body,html").animate({
        scrollTop: scroll_offset.top - 70
        }, 0);
        }

    </script>
html;
}



