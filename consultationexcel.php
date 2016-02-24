<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 14-7-2
 * Time: 13:34
 */
error_reporting(E_ALL ^ E_NOTICE);
session_start();
header("Content-type: text/html; charset=utf-8");
include_once('./common.php');
session_verify($_SESSION['username']);


if(!empty($_GET['time_start'])){
    $time_start=strtotime($_GET['time_start']);
    $sql_start="and time>=$time_start";
}else{
    $sql_start="";
}
if(!empty($_GET['time_end'])){
    $time_end=strtotime($_GET['time_end'])+86399;
    $sql_end="and time<=$time_end";
}else{
    $sql_end="";
}


$sql="select * from tbl_member_follow where is_delete='0' $sql_start  $sql_end  order by id desc";
$query=$_SC['db']->query($sql);
$result_tmp=array();
while($rs=$_SC['db']->fetch_array($query)){
    $result_tmp[]=$rs;
}





$result=array();
foreach($result_tmp as $k=>$v){
    $member_info=member_info($v['member_id']);
    $v['member_id']=$member_info['name'];
    $v['time']=date('Y-m-d',$v['time']);
    $v['rectime']=date('Y-m-d H:i:s',$v['rectime']);
    $v['reptime']=date('Y-m-d H:i:s',$v['reptime']);

    if(!empty($v['server_id'])){
        $server_info=server_info($v['server_id']);
        $v['server_id']=$server_info['order_id'];
    }

    unset($server_info);
    unset($v['id']);
    unset($v['is_delete']);
    unset($v['user_id']);

    $result[$k]=$v;
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





require_once "PHPExcel/PHPExcel.php";


$objPHPExcel = new PHPExcel();


$objPHPExcel->getProperties()->setCreator("ctos")
    ->setLastModifiedBy("ctos")
    ->setTitle("Office 2007 XLSX Test Document")
    ->setSubject("Office 2007 XLSX Test Document")
    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Test result file");

//set width
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(50);

//设置行高度
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(22);

$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

//set font size bold
$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

//设置水平居中
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//
$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');

// set table header content
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', '订单数据汇总  时间:' . date('Y-m-d H:i:s'))
    ->setCellValue('A2', '客户姓名')
    ->setCellValue('B2', '咨询时间')
    ->setCellValue('C2', 'Toplist收到邮件时间')
    ->setCellValue('D2', 'Toplist回复时间')
    ->setCellValue('E2', '内容')
    ->setCellValue('F2', '后续计划')
    ->setCellValue('G2', '订单信息')
    ->setCellValue('H2', '备注');

// Miscellaneous glyphs, UTF-8


if($result){
    for ($i = 0; $i < count($result) ; $i++) {
        if(empty($result[$i]['server_id'])){
            $result[$i]['server_id']="未下单";
        }else{
            $result[$i]['server_id']="有订单";
        }
        $objPHPExcel->getActiveSheet(0)->setCellValue('A' . ($i + 3), $result[$i]['member_id'],PHPExcel_Cell_DataType::TYPE_STRING2);
        $objPHPExcel->getActiveSheet(0)->setCellValue('B' . ($i + 3), $result[$i]['time'],PHPExcel_Cell_DataType::TYPE_STRING2);
        $objPHPExcel->getActiveSheet(0)->setCellValue('C' . ($i + 3), $result[$i]['rectime'],PHPExcel_Cell_DataType::TYPE_STRING2);
        $objPHPExcel->getActiveSheet(0)->setCellValue('D' . ($i + 3), $result[$i]['reptime'],PHPExcel_Cell_DataType::TYPE_STRING2);


        $objPHPExcel->getActiveSheet(0)->setCellValue('E' . ($i + 3), $result[$i]['content'],PHPExcel_Cell_DataType::TYPE_STRING2);
        $objPHPExcel->getActiveSheet(0)->setCellValue('F' . ($i + 3), $result[$i]['follow_plan'],PHPExcel_Cell_DataType::TYPE_STRING2);
        $objPHPExcel->getActiveSheet(0)->setCellValueExplicit('G' . ($i + 3), $result[$i]['server_id'],PHPExcel_Cell_DataType::TYPE_STRING2);
        $objPHPExcel->getActiveSheet(0)->setCellValue('H' . ($i + 3), $result[$i]['remark'],PHPExcel_Cell_DataType::TYPE_STRING2);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 3) . ':h' . ($i + 3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 3) . ':h' . ($i + 3))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getRowDimension($i + 3)->setRowHeight(16);
    }


// Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle('咨询汇总表');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
    ob_end_clean();//清除缓冲区,避免乱码
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="咨询汇总表(' . date('Ymd-His') . ').xls"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
}
?>