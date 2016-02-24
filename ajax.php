<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 14-7-4
 * Time: 17:45
 */
include_once('common.php');
error_reporting(E_ALL ^ E_NOTICE);

if(!empty($_GET['district'])){
    if($_GET['district']=='all' && $_GET['service']=='all'){
        $sql="SELECT * FROM `tbl_sup_info` where is_delete='0'";
    }elseif($_GET['district']=='all' && $_GET['service']!='all'){
        $service='s'.$_GET['service'];
        $sql="select distinct a.sup_id from tbl_d_s a, tbl_sup_info b where a.server_id='$service' and b.is_delete='0' and a.sup_id=b.sup_id";
    }elseif($_GET['district']!='all' && $_GET['service']=='all'){
        $district=$_GET['district'];
        $sql="select distinct a.sup_id from tbl_d_s a, tbl_sup_info b where a.district_id='$district' and b.is_delete='0' and a.sup_id=b.sup_id";
    }elseif($_GET['district']!='all' && $_GET['service']!='all'){
        $service='s'.$_GET['service'];
        $district=$_GET['district'];
        $sql="select distinct a.sup_id from tbl_d_s a, tbl_sup_info b where a.district_id='$district' and a.server_id='$service' and b.is_delete='0' and a.sup_id=b.sup_id";

    }
    $query=$_SC['db']->query($sql);
    while($rs=$_SC['db']->fetch_array($query)){
        $sql="select * from tbl_sup_info where sup_id='".$rs['sup_id']."'";
        $query_sup_info=$_SC['db']->query($sql);
        $sup_info=$_SC['db']->fetch_array($query_sup_info);
        echo <<<html
       <tr>
          <td>{$sup_info['sup_name']}</td>
          <td>{$sup_info['country']}</td>
          <td>{$sup_info['district']}/{$rs['city']}</td>
          <td>{$sup_info['address']}</td>
          <td>{$sup_info['website']}</td>
          <td>{$sup_info['contract1']}</td>
          <td>{$sup_info['phone_1']}</td>
          <td>
          <a href="index.php?do=edusup&ac=view&sup_id={$sup_info['sup_id']}" class="btn btn-default">查 看</a>
          <a href="index.php?do=edusup&ac=edit&sup_id={$sup_info['sup_id']}" class="btn btn-default">资料修改</a>
          <a href="index.php?do=edusup&ac=info&sup_id={$sup_info['sup_id']}" class="btn btn-default">服务项设置</a>
          </td>
        </tr>
html;
    }

}

