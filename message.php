<html lang="zh-cn">
<meta content="text/html; charset=UTF-8"  http-equiv="content-type"  >
<!-- Bootstrap core CSS -->
<link href="assets/css/bootstrap.css" rel="stylesheet">
<!-- Add custom CSS here -->
<link href="assets/css/sb-admin.css" rel="stylesheet">
<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
<!-- Bootstrap core JavaScript -->
<script src="assets/js/tablesorter/jquery.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
<!-- Page Specific Plugins -->
<script src="assets/js/tablesorter/raphael-min.js"></script>
<script src="assets/js/tablesorter/morris-0.4.3.min.js"></script>
<script src="assets/js/morris/chart-data-morris.js"></script>
<script src="assets/js/tablesorter/jquery.tablesorter.js"></script>
<script src="assets/js/tablesorter/tables.js"></script>
<script language="javascript" type="text/javascript" src="assets/js/datepicker/wdatepicker.js"></script>
<?php
include_once('common.php');
$edu_server_id=$_GET['edu_server_id'];
$tbl_s_id = $_GET['tbl_s_id'];
$message_num = $_GET['message_num'];

function Ucs2Code($str,$encode="UTF-8"){
    $jumpbit=strtoupper($encode)=='GB2312'?2:3;//跳转位数
    $strlen=strlen($str);//字符串长度
    $pos=0;//位置
    $buffer=array();
    for($pos=0;$pos<$strlen;){
        if(ord(substr($str,$pos,1))>=0xa1){//0xa1（161）汉字编码开始
            $tmpChar=substr($str,$pos,$jumpbit);
            $pos+=$jumpbit;
        }else{
            $tmpChar=substr($str,$pos,1);
            ++$pos;
        }
        $buffer[]=bin2hex(iconv("UTF-8","UCS-2",$tmpChar));
    }
    return strtoupper(join("",$buffer));
}



if(isset($_POST['submit'])){
    if(!empty($_POST['mobile'])){
        $remarks=$_POST['remarks'];
        $phone=$_POST['area_code'].$_POST['mobile'];
        $contnet=$_POST['contnet'];
        $edu_server_id=$_POST['edu_server_id'];
        $tbl_s_id=$_POST['tbl_s_id'];
        $message_num=$_POST['message_num'];
        $state="已经发送，尚未确认成功";
        $sql="insert into tbl_message_record (remarks,content,recipient_mobile,tbl_s_id,edu_server_id,state,send_time,message_num) value ('".daddslashes($remarks)."','".daddslashes($contnet)."','".daddslashes($phone)."','".daddslashes($tbl_s_id)."','".daddslashes($edu_server_id)."','".daddslashes($state)."','".time()."','".$message_num."')";
        $query=$_SC['db']->query($sql);
        $message_record_id=$_SC['db']->insert_id($query);
        $str=Ucs2Code($contnet);
        $post_data =
            array(
                'user=wesley',
                'pass=wesley123',
                'type=5',
                'to='.$phone,
                'from=MACROKIOSK',
                'text='.$str,
                'servid=MKK001'
            );
        $post_data = implode('&',$post_data);
        $url='https://www.etracker.cc/mes/mesbulk.aspx';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        ob_start();
        curl_exec($ch);
        $result = ob_get_contents() ;
        ob_end_clean();

        $tmp=explode(",",$result);
        if(in_array('200',$tmp)){
            $state="已经发送,成功";
            $sql="UPDATE  `tbl_message_record` SET  `state` =  '".daddslashes($state)."',`return_info` =  '$info' where `message_record_id`=$message_record_id";
            $query=$_SC['db']->query($sql);
            if($query){
                echo <<<html
                <div class="row">
                  <div class="col-lg-12">
                    <h2>提示</h2>
                    <div class="bs-example">
                      <div class="alert alert-dismissable alert-success">
                        <button type="button" class="close" data-dismiss="alert" onclick="window.close()">&times;</button>
                        <h4>发送成功!</h4>
                        <p>投递成功,请电话确认是否收到。</p>
                      </div>
                    </div>
                  </div>
                </div>
                <script>setTimeout(close,1500)</script>
html;

            }
        }elseif(in_array('401',$tmp)){
            $state="已经发送,失败";
            $sql="UPDATE  `tbl_message_record` SET  `state` =  '".daddslashes($state)."',`return_info` =  '$info' where `message_record_id`=$message_record_id";
            $query=$_SC['db']->query($sql);
            if($query){
                echo <<<html
                <div class="row">
                  <div class="col-lg-6">
                    <h2>警告</h2>
                    <div class="bs-example">
                      <div class="alert alert-dismissable alert-warning">
                        <button type="button" class="close" data-dismiss="alert" onclick="window.close()">&times;</button>
                        <h4>发送失败</h4>
                        <p>请确认收信人号码及内容是否合法</p>
                      </div>
                    </div>
                  </div>
                </div>
                <script>setTimeout(close,1500)</script>
html;
            }
        }
        elseif(in_array('402',$tmp)){
            $state="已经发送,余额不足";
            $sql="UPDATE  `tbl_message_record` SET  `state` =  '".daddslashes($state)."',`return_info` =  '$info' where `message_record_id`=$message_record_id";
            $query=$_SC['db']->query($sql);
            if($query){
                echo <<<html
                <div class="row">
                  <div class="col-lg-6">
                    <h2>警告</h2>
                    <div class="bs-example">
                      <div class="alert alert-dismissable alert-warning">
                        <button type="button" class="close" data-dismiss="alert" onclick="window.close()">&times;</button>
                        <h4>发送失败</h4>
                        <p>余额不足</p>
                      </div>
                    </div>
                  </div>
                </div>
                <script>setTimeout(close,1500)</script>
html;
            }
        }
    }else{
        echo "<script>window.close()</script>";
    }
}else{
    $sql="select * from tbl_message_mould where message_mould_id='".$message_num."'";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    switch ($message_num){
        case '1':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            $pattern='/\%接机联系人*\%/is';
            $replacement=$edu_server_info['meeting_name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //接机联系人电话
            $mobile=$edu_server_info['metting_mobile'];
            break;
        case '2':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            //替换接机联系人
            $pattern='/\%接机联系人*\%/is';
            $replacement=$edu_server_info['meeting_name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //替换机场接待时间
            $pattern='/\%机场待接时间*\%/is';
            $replacement=$edu_server_info['waiting_time'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换出发地
            $pattern='/\%出发地*\%/is';
            $replacement=$edu_server_info['departure'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换司机姓名
            $pattern='/\%司机姓名*\%/is';
            $replacement=$edu_server_info['driver_name'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换司机联系方式
            $pattern='/\%司机联系方式*\%/is';
            $replacement=$edu_server_info['driver_information'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换牌照
            $pattern='/\%牌照*\%/is';
            $replacement=$edu_server_info['licence'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //接机联系人电话
            $mobile=$edu_server_info['metting_mobile'];
            break;
        case '3':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            $member_info=member_info($edu_server_info['member_id']);
            //替换客户名称
            $pattern='/\%客户名称*\%/is';
            $replacement=$member_info['name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //替换出发地
            $pattern='/\%出发地*\%/is';
            $replacement=$edu_server_info['departure'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换接机联系人姓名
            $pattern='/\%接机联系人*\%/is';
            $replacement=$edu_server_info['meeting_name'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换目的地
            $pattern='/\%目的地*\%/is';
            $replacement=$edu_server_info['destination'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换司机姓名
            $pattern='/\%司机姓名*\%/is';
            $replacement=$edu_server_info['driver_name'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换司机联系方式
            $pattern='/\%司机联系方式*\%/is';
            $replacement=$edu_server_info['driver_information'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //客户电话
            $mobile=$member_info['mobile'];
            break;
        case '4':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            $member_info=member_info($edu_server_info['member_id']);
            //替换客户名称
            $pattern='/\%客户名称*\%/is';
            $replacement=$member_info['name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //替换接机联系人姓名
            $pattern='/\%接机联系人*\%/is';
            $replacement=$edu_server_info['meeting_name'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换目的地
            $pattern='/\%目的地*\%/is';
            $replacement=$edu_server_info['destination'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //客户电话
            $mobile=$member_info['mobile'];
            break;
        case '5':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            $pattern='/\%接机联系人*\%/is';
            $replacement=$edu_server_info['meeting_name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //接机联系人电话
            $mobile=$edu_server_info['metting_mobile'];
            break;
        case '6':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            //替换接机联系人
            $pattern='/\%接机联系人*\%/is';
            $replacement=$edu_server_info['meeting_name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //替换机场接待时间
            $pattern='/\%机场待接时间*\%/is';
            $replacement=$edu_server_info['waiting_time'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换出发地
            $pattern='/\%出发地*\%/is';
            $replacement=$edu_server_info['departure'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换目的地
            $pattern='/\%目的地*\%/is';
            $replacement=$edu_server_info['destination'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换司机姓名
            $pattern='/\%司机姓名*\%/is';
            $replacement=$edu_server_info['driver_name'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换司机联系方式
            $pattern='/\%司机联系方式*\%/is';
            $replacement=$edu_server_info['driver_information'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换牌照
            $pattern='/\%牌照*\%/is';
            $replacement=$edu_server_info['licence'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //接机联系人电话
            $mobile=$edu_server_info['metting_mobile'];
            break;
        case '7':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            $member_info=member_info($edu_server_info['member_id']);
            //替换客户名称
            $pattern='/\%客户名称*\%/is';
            $replacement=$member_info['name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //替换出发地
            $pattern='/\%出发地*\%/is';
            $replacement=$edu_server_info['departure'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换接机联系人姓名
            $pattern='/\%接机联系人*\%/is';
            $replacement=$edu_server_info['meeting_name'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换目的地
            $pattern='/\%目的地*\%/is';
            $replacement=$edu_server_info['destination'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换司机姓名
            $pattern='/\%司机姓名*\%/is';
            $replacement=$edu_server_info['driver_name'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换司机联系方式
            $pattern='/\%司机联系方式*\%/is';
            $replacement=$edu_server_info['driver_information'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //客户电话
            $mobile=$member_info['mobile'];
            break;
        case '8':
        $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
        $member_info=member_info($edu_server_info['member_id']);
        //替换客户名称
        $pattern='/\%客户名称*\%/is';
        $replacement=$member_info['name'];
        $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
        //替换接机联系人姓名
        $pattern='/\%接机联系人*\%/is';
        $replacement=$edu_server_info['meeting_name'];
        $message_content=preg_replace($pattern,$replacement,$message_content);
        //替换目的地
        $pattern='/\%目的地*\%/is';
        $replacement=$edu_server_info['destination'];
        $message_content=preg_replace($pattern,$replacement,$message_content);
        //客户电话
        $mobile=$member_info['mobile'];
        break;
        case '9':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            $member_info=member_info($edu_server_info['member_id']);
            //替换客户名称
            $pattern='/\%客户名称*\%/is';
            $replacement=$member_info['name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //替换接机联系人姓名
            $pattern='/\%接机联系人*\%/is';
            $replacement=$edu_server_info['meeting_name'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换目的地
            $pattern='/\%目的地*\%/is';
            $replacement=$edu_server_info['destination'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //客户电话
            $mobile=$member_info['mobile'];
            break;
        case '10':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            //替换接机联系人姓名
            $pattern='/\%接机联系人*\%/is';
            $replacement=$edu_server_info['contact_name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //替换服务说明
            $pattern='/\%服务说明*\%/is';
            $replacement=$edu_server_info['remarks'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //接机联系人电话
            $mobile=$edu_server_info['contact_mobile'];
            break;
        case '11':
        $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
        //替换接机联系人姓名
        $pattern='/\%接机联系人*\%/is';
        $replacement=$edu_server_info['contact_name'];
        $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
        //替换服务说明
        $pattern='/\%服务说明*\%/is';
        $replacement=$edu_server_info['remarks'];
        $message_content=preg_replace($pattern,$replacement,$message_content);
        //接机联系人电话
        $mobile=$edu_server_info['contact_mobile'];
        break;
        case '12':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            //替换接机联系人姓名
            $pattern='/\%联系人姓名*\%/is';
            $replacement=$edu_server_info['contact_name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //替换礼宾人员姓名
            $pattern='/\%礼宾人员姓名*\%/is';
            $replacement=$edu_server_info['concierge_name'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换礼宾人员联系方式
            $pattern='/\%礼宾人员联系方式*\%/is';
            $replacement=$edu_server_info['contact_concierge'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换礼所在机场
            $pattern='/\%所在机场*\%/is';
            $replacement=$edu_server_info['service_location'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //联系人电话
            $mobile=$edu_server_info['contact_mobile'];
            break;
        case '13':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            //替换接机联系人姓名
            $pattern='/\%联系人姓名*\%/is';
            $replacement=$edu_server_info['contact_name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //替换遗失处理日期
            $pattern='/\%遗失处理日期*\%/is';
            $replacement=$edu_server_info['processing_date'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换所在机场
            $pattern='/\%所在机场*\%/is';
            $replacement=$edu_server_info['service_location'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //联系人电话
            $mobile=$edu_server_info['contact_mobile'];
            break;
        case '14':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            //替换联系人姓名
            $pattern='/\%联系人姓名*\%/is';
            $replacement=$edu_server_info['contact_name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //替换咨询内容简介
            $pattern='/\%咨询内容简介*\%/is';
            $replacement=$edu_server_info['contnet'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //联系人电话
            $mobile=$edu_server_info['contact_mobile'];
            break;
        case '15':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            //替换联系人姓名
            $pattern='/\%联系人姓名*\%/is';
            $replacement=$edu_server_info['contact_name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //替换援驾司机姓名
            $pattern='/\%援驾司机姓名*\%/is';
            $replacement=$edu_server_info['driver_name'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换援驾司机联系方式
            $pattern='/\%援驾司机联系方式*\%/is';
            $replacement=$edu_server_info['driver_contact'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换预计达到时间
            $pattern='/\%预计达到时间*\%/is';
            $replacement=$edu_server_info['time_control'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //联系人电话
            $mobile=$edu_server_info['contact_mobile'];
            break;
        case '16':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            //替换联系人姓名
            $pattern='/\%联系人姓名*\%/is';
            $replacement=$edu_server_info['contact_name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //替换礼宾人员姓名
            $pattern='/\%礼宾人员姓名*\%/is';
            $replacement=$edu_server_info['concierge_name'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换礼宾人员联系方式
            $pattern='/\%礼宾人员联系方式*\%/is';
            $replacement=$edu_server_info['contact_concierge'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换预计到达时间
            $pattern='/\%预计达到时间*\%/is';
            $replacement=$edu_server_info['time_control'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //联系人电话
            $mobile=$edu_server_info['contact_mobile'];
            break;
        case '17':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            //替换联系人姓名
            $pattern='/\%联系人姓名*\%/is';
            $replacement=$edu_server_info['contact_name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //替换预计使用时间
            $pattern='/\%预计使用时间*\%/is';
            $replacement=$edu_server_info['time_control'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换服务地点
            $pattern='/\%服务地点*\%/is';
            $replacement=$edu_server_info['service_location'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //联系人电话
            $mobile=$edu_server_info['contact_mobile'];
            break;
        case '18':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            //替换联系人姓名
            $pattern='/\%联系人姓名*\%/is';
            $replacement=$edu_server_info['contact_name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //替换翻译人员姓名
            $pattern='/\%翻译人员姓名*\%/is';
            $replacement=$edu_server_info['translate_name'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换翻译人员联系方式
            $pattern='/\%翻译人员联系方式*\%/is';
            $replacement=$edu_server_info['contact_translate'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换预计使用时间
            $pattern='/\%预计使用时间*\%/is';
            $replacement=$edu_server_info['time_control'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换服务地点
            $pattern='/\%服务地点*\%/is';
            $replacement=$edu_server_info['service_location'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //联系人电话
            $mobile=$edu_server_info['contact_mobile'];
            break;
        case '19':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            //替换联系人姓名
            $pattern='/\%联系人姓名*\%/is';
            $replacement=$edu_server_info['contact_name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //替换预计使用时间
            $pattern='/\%预计使用时间*\%/is';
            $replacement=$edu_server_info['time_control'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换服务地点
            $pattern='/\%服务地点*\%/is';
            $replacement=$edu_server_info['service_location'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //联系人电话
            $mobile=$edu_server_info['contact_mobile'];
            break;
        case '20':
            $edu_server_info=edu_server_info($edu_server_id,$tbl_s_id);
            //替换联系人姓名
            $pattern='/\%联系人姓名*\%/is';
            $replacement=$edu_server_info['contact_name'];
            $message_content=preg_replace($pattern,$replacement,$rs['moule_content']);
            //替换礼宾人员姓名
            $pattern='/\%礼宾人员姓名*\%/is';
            $replacement=$edu_server_info['concierge_name'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换礼宾人员联系方式
            $pattern='/\%礼宾人员联系方式*\%/is';
            $replacement=$edu_server_info['contact_concierge'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换预计使用时间
            $pattern='/\%预计使用时间*\%/is';
            $replacement=$edu_server_info['time_control'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //替换服务地点
            $pattern='/\%服务地点*\%/is';
            $replacement=$edu_server_info['service_location'];
            $message_content=preg_replace($pattern,$replacement,$message_content);
            //联系人电话
            $mobile=$edu_server_info['contact_mobile'];
            break;
    }
    ?>
    <form action="message.php" method="post">
        <div class="form-group has-success">
            <div class="form-group">
                <input class="form-control" placeholder="请输入短信备注内容以便查询(重要)" name="remarks" style="width: 500px;margin: 0 auto">
                <input  name="tbl_s_id" value="<?php echo $tbl_s_id ?>" style="display: none" ">
                <input  name="edu_server_id" value="<?php echo $edu_server_id ?>" style="display: none" ">
                <input  name="message_num" value="<?php echo $message_num ?>" style="display: none" ">
            </div>
        </div>
        <div class="form-group has-success">
            <div class="form-group" style="width: 500px;margin: 0 auto">
                <div class="form-group">
                    <label>区号选择</label>
                    <select class="control input-inline" style="width: 100px" name="area_code">
                        <option value="86">国内+86</option>
                        <option value="1">美国+001</option>
                    </select>
                </div>
                <input  class="control input-inline" style="width: 300px" placeholder="请输入电话号码" onkeydown="onlyNum();" name="mobile" value="<?php echo $mobile ?>">
            </div>
        </div>
        <div class="form-group has-success">
            <div class="form-group">
                <textarea class="form-control " placeholder="请输入短信内容，超过长度时将自动拆分为多条发送" name="contnet" style="height: 280px;width: 500px;margin: 0 auto"><?php echo $message_content?></textarea>
            </div>
        </div>
        <div style="padding-left: 200px;">
        <button type="submit" class="btn btn-default" name="submit" style="width: 200px">提 交</button>
        </div>
    </form>
<?php

}












function edu_server_info($edu_server_id,$tbl_s_id){
    global $_SC;
    $tbl_name="tbl_s".$tbl_s_id;
    $sql="select * from $tbl_name where s_id='".$edu_server_id."'";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    return $rs;
}

?>










<script language=javascript>
    function onlyNum()
    {
        if(!(event.keyCode==46)&&!(event.keyCode==8)&&!(event.keyCode==37)&&!(event.keyCode==39))
            if(!((event.keyCode>=48&&event.keyCode<=57)||(event.keyCode>=96&&event.keyCode<=105)))
                event.returnValue=false;
    }
    function close(
        window.close();
        )
</script>