<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-3-10
 * Time: 上午11:22
 */
session_verify($_SESSION['username']);
$user_id=$_SESSION['user_id'];
$user=$_SESSION['name'];
$department_id=$_SESSION['department_id'];
$power=$_SESSION['power'];
$acs = array('list','edit','delete','add','view','over');
$ac = (!empty($_GET['ac']) && in_array($_GET['ac'], $acs))?$_GET['ac']:'list';


switch ($ac){
    case 'list':
        complaint_list();
        break;
    case 'over':
        if(isset($_GET['complaint_id'])){
            $complaint_id=$_GET['complaint_id'];
            $sql="update tbl_complaint set is_complete='1' where complaint_id='$complaint_id'";
            $query=$_SC['db']->query($sql);
            echo "<script>location.href='index.php?do=complaint';</script>";
        }
        break;
    case 'view':
        if(isset($_GET['complaint_id'])){
            $complaint_id=$_GET['complaint_id'];
            complaint_view($complaint_id);
        }
        break;
    case 'delete':
        if(isset($_GET['complaint_id']) && isset($_GET['call_id'])){
            $complaint_id=$_GET['complaint_id'];
            $call_id=$_GET['call_id'];
            delete_complaint($complaint_id,$call_id);
        }
        break;
    case 'edit':
        if(isset($_GET['complaint_id'])){
            $complaint_id=$_GET['complaint_id'];
            complaint_edit($complaint_id);
        }
        break;

}

function complaint_list(){
    global $_SC;
    get_header();
    get_left_menu();
    if(empty($_GET['type']))
        $active_all="active";
    elseif($_GET['type']=="unfinished")
        $active_unfinished="active";
    elseif($_GET['type']=="completed")
        $active_completed="active";
    echo <<<html
   <div id="page-wrapper">
          <ol class="breadcrumb">
              <li><a href="index.php?do=complaint"><i class="icon-dashboard"></i>教育项目 </a></li>
              <li class="active"><i class="icon-edit"></i>投诉列表</li>
          </ol>
          <div class="row">
            <div class="col-lg-12">
            <div class="table-responsive">
              <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="{$active_all}"><a href="index.php?do=complaint" >全部</a></li>
                <li class="{$active_unfinished}"><a href="index.php?do=complaint&type=unfinished" >未完成</a></li>
                <li class="{$active_completed}"><a href="index.php?do=complaint&type=completed" >已完成</a></li>
              </ul>
              <table class="table table-bordered table-hover tablesorter">
                <thead>
                  <tr>
                    <th>序号 </th>
                    <th>客户姓名 </th>
                    <th>投诉时间 </th>
                    <th>服务时间 </th>
                    <th>通话录音</th>
                    <th>严重程度 </th>
                    <th>投诉响应时间 </th>
                    <th>解决成本 </th>
                    <th>决策人 </th>
                    <th>操作 </th>
                  </tr>
                </thead>

html;
    if($_GET['type']=="unfinished")
        $condition="and is_complete='0'";
    elseif($_GET['type']=="completed")
        $condition="and is_complete='1'";



    $complaint_list_arr=complaint_list_arr($condition);
    foreach($complaint_list_arr as $v){
        $complaint_time=date('Y-m-d H:i:s',$v['complaint_time']);
        $server_time=date('Y-m-d H:i:s',$v['server_time']);
        if(!empty($v['response_time'])){
        $response_time=date('Y-m-d H:i:s',$v['response_time']);
        }
        if($v['is_complete']=="0")
            $status="color: firebrick";
        elseif($v['is_complete']=="1")
            $status="color: forestgreen";
        $member_info=member_info($v['member_id']);
        $call_url=call_url($v['call_id']);
        $suffix=pathinfo($call_url['recording_url'],PATHINFO_EXTENSION);
        echo <<<html
        <tr style="{$status}">
        <td>{$v['complaint_id']}</td>
        <td>{$member_info['name']}</td>
        <td>{$complaint_time}</td>
        <td>{$server_time}</td>
        <td>
html;
        if(!empty($call_url['recording_url'])){
        echo <<<html
        <audio  src="{$call_url['recording_url']}"  controls="controls"   style="width: 200px;float: left"></audio>
         <a href="down.php?file_url={$call_url['recording_url']}&file_name={$call_url['call_number']}&suffix={$suffix}" class="icon-arrow-down btn btn-default" style="height: 30px;float: left;margin-left: 5px" title="下载" ></a>
html;
        }
        echo <<<html
        </td>
        <td>{$v['complaint_level']}</td>
        <td>{$response_time}</td>
        <td>{$v['solve_cost']}</td>
        <td>{$v['policymakers']}</td>
        <td>
        <a href="index.php?do=complaint&ac=edit&complaint_id={$v['complaint_id']}"> <i class="icon-edit" title="修改"></i></a>&nbsp;
        <a href="index.php?do=complaint&ac=view&complaint_id={$v['complaint_id']}"> <i class="icon-eye-open" title="查看"></i></a>&nbsp;
        <a href="index.php?do=complaint&ac=delete&complaint_id={$v['complaint_id']}&call_id={$v['call_id']}"> <i class="icon-trash" title="删除" onclick="return CommandConfirm_server()"></i></a>&nbsp;
html;
        if($v['is_complete']=="0"){
        echo <<<html
            <a href="index.php?do=complaint&ac=over&complaint_id={$v['complaint_id']}"> <i class="icon-ok-sign" title="完成此项" onclick="return CommandConfirm_over()"></i></a>
html;
        }
         echo <<<html
        </td>
        </tr>
html;
        unset($status);
    }



    echo <<<html
                 </div>
              </div>
            </div>
          </div>
html;



}

function call_url($call_id){
    global $_SC;
    $sql="select * from tbl_call_record where call_id=$call_id";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    return $rs;
}



function complaint_view($complaint_id){
    global $_SC;
    get_header();
    get_left_menu();
    $complaint_info=complaint_info($complaint_id);
    $member_info=member_info($complaint_info['member_id']);
    $complaint_time=date("Y-m-d H:i:s",$complaint_info['complaint_time']);
    $server_time=date("Y-m-d H:i:s",$complaint_info['server_time']);
    if(isset($complaint_info['response_time'])){
    $response_time=date("Y-m-d H:i:s",$complaint_info['response_time']);
    }
    echo <<<html
   <div id="page-wrapper">
          <ol class="breadcrumb">
              <li><a href="index.php?do=complaint"><i class="icon-dashboard"></i>教育项目 </a></li>
              <li class="active"><a href="index.php?do=complaint"><i class="icon-edit"></i>投诉列表</a></li>
              <li class="active"><i class="icon-eye-open"></i>{$complaint_info['complaint_id']}号投诉</li>
          </ol>
          <div class="row">
            <div class="col-lg-6">

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">客户姓名</label>
                        <input class="form-control" value="{$member_info['name']}">
                      </div>
                    </div>


                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">投诉时间</label>
                        <input class="form-control" value="{$complaint_time}">
                      </div>
                    </div>


                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">服务时间</label>
                        <input class="form-control" value="{$server_time}">
                      </div>
                    </div>



                <div class="form-group has-success">
                  <div class="form-group">
                    <label class="control-label" for="inputSuccess">投诉事由</label>
                    <textarea class="form-control" style="height: 100px" >{$complaint_info['complaint_content']}</textarea>
                    </div>
                   </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">严重程度</label>
                        <input class="form-control" value="{$complaint_info['complaint_level']}">
                      </div>
                    </div>


                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">投诉响应时间</label>
                        <input class="form-control" value="{$response_time}">
                      </div>
                    </div>


                <div class="form-group has-success">
                  <div class="form-group">
                    <label class="control-label" for="inputSuccess">调查结果</label>
                    <textarea class="form-control" style="height: 100px" >{$complaint_info['findings']}</textarea>
                  </div>
                    </div>


                <div class="form-group has-success">
                  <div class="form-group">
                    <label class="control-label" for="inputSuccess">解决方案</label>
                    <textarea class="form-control" style="height: 100px" >{$complaint_info['solution']}</textarea>
                  </div>
                    </div>




                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">解决成本</label>
                        <input class="form-control" value="{$complaint_info['solve_cost']}">
                      </div>
                    </div>


                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">决策人</label>
                        <input class="form-control" value="{$complaint_info['policymakers']}">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">客户满意度</label>
                        <input class="form-control" value="{$complaint_info['satisfaction']}">
                      </div>
                    </div>


                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">是否需要优化</label>
                        <input class="form-control" value="{$complaint_info['is_improve']}">
                      </div>
                    </div>

                <div class="form-group has-success">
                  <div class="form-group">
                    <label class="control-label" for="inputSuccess">优化方案</label>
                    <textarea class="form-control" style="height: 100px">{$complaint_info['improve_project']}</textarea>
                  </div>
                    </div>
                    </body>

                        <button type="reset" class="btn btn-default"  onclick="history.go(-1)">返回</button>




             </div>
             </div>
           </div>

html;


}


function complaint_edit($complaint_id){
    global $_SC;
    get_header();
    get_left_menu();
    $complaint_info=complaint_info($complaint_id);
    $member_info=member_info($complaint_info['member_id']);
    $complaint_time=date("Y-m-d H:i:s",$complaint_info['complaint_time']);
    $server_time=date("Y-m-d H:i:s",$complaint_info['server_time']);
    if(isset($complaint_info['response_time'])){
        $response_time=date("Y-m-d H:i:s",$complaint_info['response_time']);
    }
    echo <<<html
   <div id="page-wrapper">
          <ol class="breadcrumb">
              <li><a href="index.php?do=complaint"><i class="icon-dashboard"></i>教育项目 </a></li>
              <li class="active"><a href="index.php?do=complaint"><i class="icon-edit"></i>投诉列表</a></li>
              <li class="active"><i class="icon-edit-sign"></i>{$complaint_info['complaint_id']}号投诉</li>
          </ol>
          <div class="row">
            <div class="col-lg-6">
            <form method="post" action="#">
                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">客户姓名</label>
                        <input class="form-control" value="{$member_info['name']}"  disabled>
                      </div>
                    </div>


                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">投诉时间</label>
                        <input class="form-control" value="{$complaint_time}" disabled>
                      </div>
                    </div>


                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">服务时间</label>
                        <input class="form-control" value="{$server_time}" disabled>
                      </div>
                    </div>



                <div class="form-group has-success">
                  <div class="form-group">
                    <label class="control-label" for="inputSuccess">投诉事由</label>
                    <textarea class="form-control" style="height: 100px" name="complaint_content">{$complaint_info['complaint_content']}</textarea>
                    </div>
                   </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">严重程度</label>
                        <input class="form-control" value="{$complaint_info['complaint_level']}" name="complaint_level">
                      </div>
                    </div>


                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">投诉响应时间</label>
                        <input class="form-control" value="{$response_time}" name="response_time" onfocus="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})">
                      </div>
                    </div>


                <div class="form-group has-success">
                  <div class="form-group">
                    <label class="control-label" for="inputSuccess">调查结果</label>
                    <textarea class="form-control" style="height: 100px" name="findings">{$complaint_info['findings']}</textarea>
                  </div>
                    </div>


                <div class="form-group has-success">
                  <div class="form-group">
                    <label class="control-label" for="inputSuccess">解决方案</label>
                    <textarea class="form-control" style="height: 100px" name="solution">{$complaint_info['solution']}</textarea>
                  </div>
                    </div>




                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">解决成本</label>
                        <input class="form-control" value="{$complaint_info['solve_cost']}" name="solve_cost">
                      </div>
                    </div>


                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">决策人</label>
                        <input class="form-control" value="{$complaint_info['policymakers']}" name="policymakers">
                      </div>
                    </div>

                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">客户满意度</label>
                        <input class="form-control" value="{$complaint_info['satisfaction']}" name="satisfaction">
                      </div>
                    </div>


                <div class="form-group has-success">
                      <div class="form-group">
                        <label class="control-label" for="inputSuccess">是否需要优化</label>
                        <input class="form-control" value="{$complaint_info['is_improve']}" name="is_improve">
                      </div>
                    </div>

                <div class="form-group has-success">
                  <div class="form-group">
                    <label class="control-label" for="inputSuccess">优化方案</label>
                    <textarea class="form-control" style="height: 100px" name="improve_project">{$complaint_info['improve_project']}</textarea>
                  </div>
                    </div>
                       <button type="submit" class="btn btn-default" name="edit_complaint">提交</button>
                        <a href="index.php?do=complaint"> <button type="reset" class="btn btn-default bottom-right">返回</button></a>
                    </form>
             </div>
             </div>
           </div>

html;
    if(isset($_POST['edit_complaint'])){
        if(!empty($_POST['complaint_content'])){
            $sql="update tbl_complaint set complaint_content='".daddslashes($_POST['complaint_content'])."' where complaint_id='".$complaint_id."'";
            $query=$_SC['db']->query($sql);
        }

        if(!empty($_POST['complaint_level'])){
            $sql="update tbl_complaint set complaint_level='".daddslashes($_POST['complaint_level'])."' where complaint_id='".$complaint_id."'";
            $query=$_SC['db']->query($sql);
        }

        if(!empty($_POST['response_time'])){
            $date_response_time=strtotime($_POST['response_time']);
            $sql="update tbl_complaint set response_time='$date_response_time' where complaint_id='".$complaint_id."'";
            $query=$_SC['db']->query($sql);
        }

        if(!empty($_POST['findings'])){
            $sql="update tbl_complaint set findings='".daddslashes($_POST['findings'])."' where complaint_id='".$complaint_id."'";
            $query=$_SC['db']->query($sql);
        }

        if(!empty($_POST['solution'])){
            $sql="update tbl_complaint set solution='".daddslashes($_POST['solution'])."' where complaint_id='".$complaint_id."'";
            $query=$_SC['db']->query($sql);
        }

        if(!empty($_POST['solve_cost'])){
            $sql="update tbl_complaint set solve_cost='".daddslashes($_POST['solve_cost'])."' where complaint_id='".$complaint_id."'";
            $query=$_SC['db']->query($sql);
        }


        if(!empty($_POST['policymakers'])){
            $sql="update tbl_complaint set policymakers='".daddslashes($_POST['policymakers'])."' where complaint_id='".$complaint_id."'";
            $query=$_SC['db']->query($sql);
        }

        if(!empty($_POST['satisfaction'])){
            $sql="update tbl_complaint set satisfaction='".daddslashes($_POST['satisfaction'])."' where complaint_id='".$complaint_id."'";
            $query=$_SC['db']->query($sql);
        }


        if(!empty($_POST['is_improve'])){
            $sql="update tbl_complaint set is_improve='".daddslashes($_POST['is_improve'])."' where complaint_id='".$complaint_id."'";
            $query=$_SC['db']->query($sql);
        }

        if(!empty($_POST['improve_project'])){
            $sql="update tbl_complaint set improve_project='".daddslashes($_POST['improve_project'])."' where complaint_id='".$complaint_id."'";
            $query=$_SC['db']->query($sql);
        }

        echo "<script>location.href='index.php?do=complaint';</script>";
    }
}

function complaint_list_arr($condition=NULL){
    global $_SC;
    $tmp=array();
    $sql="select * from tbl_complaint where is_delete=0 $condition order by complaint_id DESC";
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $tmp[]=$rs;
    }
    return $tmp;
}

function delete_complaint($complaint_id,$call_id){
    global $_SC;
    $sql="update tbl_complaint set is_delete='1' where complaint_id='".$complaint_id."'";
    $query=$_SC['db']->query($sql);
    $sql="update tbl_call_record set is_delete='1' where call_id='".$call_id."'";
    $query=$_SC['db']->query($sql);
    if($query){
        echo "<script>alert('提示:删除成功');history.go(-1)</script>";
    }
}

function complaint_info($complaint_id){
    global $_SC;
    $sql="select * from tbl_complaint where is_delete=0 and complaint_id='".daddslashes($complaint_id)."'";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    return $rs;
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

<script>
    function CommandConfirm_over(){
        if(window.confirm("提示:确定结束此次投诉进程？")){
            return true;
        }else{
            return false;
        }
    }
</script>