<?php
require(dirname(__FILE__)."/config.php");
CheckPurview('plus_�õƹ���');
require_once DEDEINC."/typelink.class.php";
if(empty($dopost))
{
	$dopost = "";
}

if($dopost=="save")
{
	//timeset orderid typeid pic url
	$orderid = trim($orderid);

      	
	$query = "
	 Insert Into #@__myppt(typeid,orderid,title,pic,url)
	 Values('$typeid','$orderid','$title','$picname','$url');	";
	$dsql->ExecuteNoneQuery($query);
	ShowMsg("�ɹ�����һ���õ�Ƭ��","ppt_main.php");
	exit();
}
$dsql->Execute('dd','SELECT * FROM `#@__myppttype` ORDER BY id DESC');
$option = '';
while($arr = $dsql->GetArray('dd'))
{
    $option .= "<option value='{$arr['id']}'>{$arr['typename']}</option>\n\r";
}
$startDay = time();
$endDay = AddDay($startDay,30);
$startDay = GetDateTimeMk($startDay);
$endDay = GetDateTimeMk($endDay);
include DedeInclude('templets/ppt_add.htm');

?>