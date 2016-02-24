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

$sql="select file_id,time,order_id,member_id,product_id,content,amount_money,pay_mode,pay_time,server_type,remark from tbl_server_member where is_delete='0' $sql_start $sql_end order by server_id desc";
$query=$_SC['db']->query($sql);
$result_tmp=array();
while($rs=$_SC['db']->fetch_array($query)){
    $result_tmp[]=$rs;
}

$result=array();
foreach($result_tmp as $k=>$v){
    $v['product_id']=product_info($v['product_id']);
    $tmp_info=member_info($v['member_id']);
    $v['member_id']=$tmp_info['name'];
    if(!empty($v['pay_time'])){
        $v['pay_time']=date('Y-m-d',$v['pay_time']);
    }else{
        $v['pay_time']="暂无";
    }

    if(!empty($v['file_id'])){
        $v['attachments']="已签";
    }else{
        $v['attachments']="没有";
    }

    unset($v['file_id']);
    $v['time']=date('Y-m-d',$v['time']);
    $result[$k]=$v;
}





function product_info($id){
    global $_SC;
    $sql="select product_name from tbl_product_info where product_id='".$id."'";
    $query=$_SC['db']->query($sql);
    $rs=$_SC['db']->fetch_array($query);
    if($rs){
        return $rs['product_name'];
    }else{
        $rs['product_name']="暂无";
        return $rs['product_name'];
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
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(50);

//设置行高度
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(22);

$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

//set font size bold
$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

//设置水平居中
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//
$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');

// set table header content
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', '订单数据汇总  时间:' . date('Y-m-d H:i:s'))
    ->setCellValue('A2', '下单时间')
    ->setCellValue('B2', '订单ID')
    ->setCellValue('C2', '客户姓名')
    ->setCellValue('D2', '消费项目')
    ->setCellValue('E2', '内容')
    ->setCellValue('F2', '金额')
    ->setCellValue('G2', '付款方式')
    ->setCellValue('H2', '付款时间')
    ->setCellValue('I2', '服务类型')
    ->setCellValue('J2', '合同')
    ->setCellValue('K2', '备注');

// Miscellaneous glyphs, UTF-8


if($result){
    for ($i = 0; $i < count($result) ; $i++) {
        $objPHPExcel->getActiveSheet(0)->setCellValue('A' . ($i + 3), $result[$i]['time']);
        $objPHPExcel->getActiveSheet(0)->setCellValueExplicit('B' . ($i + 3), $result[$i]['order_id'],PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet(0)->setCellValue('C' . ($i + 3), $result[$i]['member_id']);
        $objPHPExcel->getActiveSheet(0)->setCellValue('D' . ($i + 3), $result[$i]['product_id']);
        $objPHPExcel->getActiveSheet(0)->setCellValue('E' . ($i + 3), $result[$i]['content']);
        $objPHPExcel->getActiveSheet(0)->setCellValue('F' . ($i + 3), $result[$i]['amount_money']);
        $objPHPExcel->getActiveSheet(0)->setCellValue('G' . ($i + 3), $result[$i]['pay_mode']);
        $objPHPExcel->getActiveSheet(0)->setCellValue('H' . ($i + 3), $result[$i]['pay_time']);
        $objPHPExcel->getActiveSheet(0)->setCellValue('I' . ($i + 3), $result[$i]['server_type']);
        $objPHPExcel->getActiveSheet(0)->setCellValue('J' . ($i + 3), $result[$i]['attachments']);
        $objPHPExcel->getActiveSheet(0)->setCellValue('K' . ($i + 3), $result[$i]['remark']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 3) . ':k' . ($i + 3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 3) . ':k' . ($i + 3))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getRowDimension($i + 3)->setRowHeight(16);
    }


// Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle('订单汇总表');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
    ob_end_clean();//清除缓冲区,避免乱码
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="订单汇总表(' . date('Ymd-His') . ').xls"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
}
?>