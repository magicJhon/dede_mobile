<?php
require_once(dirname(__FILE__).'/config.php');
$dsql->Execute();
$pre_= $GLOBALS['cfg_dbprefix']; //��õ�ǰ��ǰ׺
mysql_query("UPDATE dede_wapconfig SET value='".$pre_."' WHERE var='prefix'");//�����±�ǰ׺

if($_GET['change']){
		echo clean_catid();
		exit();
}
if(!empty($_POST)){
	// $typeid = implode(',', $_POST['categoryid']);//checkbox��ֵ  ת���ַ��� �� 2,1,4,5
	$typeid = $_POST['categoryid'];//��ҳ��Ŀ
	$typearr = implode(',', $_POST['cate']);//��Ҫ��ʾ����Ŀ ת���ַ���
    $about_id = $_POST['about'];//����������Ŀid
    $news_id = $_POST['news'];//��ҳ������id
	$mobile = $_POST['dede_mobile'];//�绰
	$com = $_POST['dede_com'];//��˾��
	$addr = $_POST['dede_addr'];//��˾��ַ
	$map = $_POST['map'];//��˾��ͼ
	$email = $_POST['email'];//��˾����
	$r = '';
/*	echo "<pre>";
	print_r($_POST);*/
	
    /*��Ҫ��ʾ����Ŀ  ��dede_wapchannel*/
    $clear = mysql_query("DELETE FROM  dede_wapchannel");//�����
	foreach ($typeid as $k => $v) {
        $up = mysql_query("INSERT INTO dede_wapchannel (typeid,mobile) values ('$v','1')");
	}
			
	/*���ͼƬ������ waptype��*/
	$clear2 = mysql_query("DELETE FROM dede_waptype");//�����
	 foreach ($_POST as $key => $value) {
	 	if(strstr($key, 'typelitpic_')){
	 		//��ͼƬ typelitpic_12 ʹ��str_replace�ó�id
	 		$id = str_replace('typelitpic_','',$key);
	 		$orderstr = 'order_'.$id;
	 		$order = isset($_POST[$orderstr]) ? $_POST[$orderstr] : 1 ;
/*			$zd = $dsql->GetOne("SELECT * FROM dede_waptype WHERE typeid=".$id);
			//�����û�и�������
			//�����޸�  �������
			if($zd){
				$sql = "UPDATE dede_waptype SET typelitpic='".$value."',listorder=".$order." WHERE typeid=".$id;
			}else{
				$sql = "INSERT INTO dede_waptype (typeid,typelitpic,listorder) values('".$id."','".$value."',".$order.")";
			}*/
			$sql = "INSERT INTO dede_waptype (typeid,typelitpic,listorder) values('".$id."','".$value."',".$order.")";
	 		$img = mysql_query($sql);
	 		if(!$img){	echo mysql_error();$r = false;	}else{	$r = true;	}
	 	}
	 }
/*    $aid = mysql_query("UPDATE dede_wapconfig SET value=$about_id WHERE var='about'");*/
	$dede_mobile = mysql_query("UPDATE dede_wapconfig SET value='$mobile' WHERE var='mobile'");
	$dede_com = mysql_query("UPDATE  dede_wapconfig SET value='$com' WHERE var='company'");
	$dede_addr = mysql_query("UPDATE dede_wapconfig SET value='$addr' WHERE var='address'");
	$map_up = mysql_query("UPDATE dede_wapconfig SET value='$map' WHERE var='map'");
    $about_up = mysql_query("UPDATE dede_wapconfig  SET value='$about_id' WHERE var='about'");
    $email_up = mysql_query("UPDATE dede_wapconfig  SET value='$email' WHERE var='email'");
    $cate_up = mysql_query("UPDATE dede_wapconfig SET value='".$typearr."' WHERE var='typeid'");
    $news_up = mysql_query("UPDATE dede_wapconfig SET value='".$news_id."' WHERE var='news'");
	$r ? ShowMsg('�޸ĳɹ�','mobile_main.php',0,1) : ShowMsg('�޸�ʧ�� , ������������ .','mobile_main.php',0,4);
}else{

    //����ϵͳ���� ��ȷ����û�б�ѡ��  dede_wapchannel��
	$category1 = get_query("SELECT id,typename FROM  ".$pre_."arctype WHERE reid=0 AND topid=0");
//	var_dump($category1);
	$typearr = explode(',',get_config("typeid"));//��ѡ��id

	//ʹ��dede_waptype�����õ�ͼƬ
	$category = array();
		foreach ($category1 as $key => $value) {
			$value['typelitpic'] = get_pic($value['id']);//׷��ͼƬ�ֶ�
			$value['listorder'] = get_value($value['id']);//׷������
            $value['mobile'] = get_mobile($value['id']);//׷��mobile�ֶ�
			$category[] = $value;
		}
	$contact = array();
	$contact['typelitpic'] = get_pic(88);
	$contact['id'] = 88;
	$contact['mobile'] = 1;
	$contact['typename'] = '��ϵ����';
	$contact['listorder'] = get_value(88);
	$category[] = $contact;
	$tools = array();
	$tools['typelitpic'] = get_pic(99);
	$tools['id'] = 99;
	$tools['mobile'] = 1;
	$tools['typename'] = 'ʵ�ù���';
	$tools['listorder'] = get_value(99);
	$category[] = $tools;
	$dede_mobile = get_config('mobile');
	$dede_addr = get_config('address');
	$dede_com = get_config('company');
	$map = get_config('map');
	$email = get_config('email');
    $about_id = get_config("about");
    $about_name = get_typename($about_id);
    // $about_name = $about_name['typename'];
    $news_id = get_config('news');
    $news_name = get_typename($news_id);
/*    if( $about_id == 88 ){
        $about_name = "��ϵ����";
    }elseif( $about_id == 99 ){
        $about_name = "ʵ�ù���";
    }else{*/

/*    }*/
	// print_r($category);
	include DedeInclude('templets/mobile_main.htm');
}


//������ѯ
function get_query($sql){
		$result = mysql_query($sql);
		$list = array();
		while($result1 = mysql_fetch_assoc($result)){
			$list[] = $result1;
		}
		return $list;
}
//��ȡ����ֵ
function get_config($varname){
	$sql = "SELECT value FROM dede_wapconfig WHERE var='$varname'";
	$result = mysql_query($sql);
	$result1 = mysql_fetch_assoc($result);
	$value = $result1['value'];
	return $value;
}
function get_pic($typeid){
	$sql = "SELECT typeid,typelitpic FROM dede_waptype WHERE typeid=".$typeid;
	$result = mysql_query($sql);
	$result1 = mysql_fetch_assoc($result);
	$value = $result1['typelitpic'];
	return $value;
}
function get_value($typeid){
	$sql = "SELECT listorder FROM dede_waptype WHERE typeid=".$typeid;
	$result = mysql_query($sql);
	$result1 = mysql_fetch_assoc($result);
	$value = $result1['listorder'] ? $result1['listorder'] : 0 ;
	return $value;
}
function get_mobile($typeid){
    global $dsql;
    $sql = "SELECT * FROM dede_wapchannel WHERE typeid=".$typeid;
    $result1 = $dsql->GetOne($sql);
    $result = $result1 == '' ? 0 : $result1['mobile'];
    return $result;
}
function dede_config($varname){
	$sql = "SELECT value FROM  dede_wapconfig WHERE var='$varname'";
	$result = mysql_query($sql);
	$result1 = mysql_fetch_assoc($result);
	$value = $result1['value'];
	return $value;
}
function get_typename($typeid){
	global $dsql;
	$result = $dsql->GetOne("SELECT typename FROM `#@__arctype` WHERE id=".$typeid);
	return $result['typename'];
}
//��ά���鰴ָ���ֶ�˳������
/*
 $array = array(
                array('id'=>'1','listorder'=>'4'),
                array('id'=>'2','listorder'=>'2')
);
order($array , 'listorder'); ��listorder�ֶ�����
*/
function order($array,$zd){
	$arr = array();//���ø�arr
	foreach ( $array as $key => $value ) {
                    /*----------------�ж��ǲ�������------*/
                    $k = $value[$zd];  //��ֵ����
                    if( is_array($value )){
                        if( $arr[$k] != '' ){  // 6 6 5 4 3 31
                            //$k = $value[$zd]+1;�����ظ�
//                            $arr[$k] =
                        	$rand = $k+mt_rand(0,100);
                            $arr[$rand] = $value;
                        }else{

                    $arr[$k] = $value;  //
                }
		}
/*----------------�ж��ǲ�������------*/
	}
			//arr�齨��� , ��ʼ����
			ksort($arr);
	return $arr;
}

function clean_catid(){
	global $dsql,$pre_;
	$table = $pre_."arctype";
	/*
	������Ŀ topid=0 reid=0
	������Ŀ reid=topid ͬ�Ƕ�����Ŀ
	������Ŀ reid topid����ͬ reid���ϼ�Ŀ¼ topidӦ���Ƕ�����Ŀ
	��reid<>topid������ ���Ҵ���Ķ�����Ŀ����ȷ��������Ŀ   ���topid�Ƿ����  �����ھ͸���
	*/
	$count = '0';
	// $toparr = get_query("SELECT * FROM ".$table." WHERE reid=topid AND reid=0");
	$childarr = get_query("SELECT * FROM ".$table." WHERE reid<>topid");
	foreach ($childarr as $key => $value) {
		// $id = $value['id'];
		$parentid = $dsql->GetOne("SELECT * FROM ".$table." WHERE id=".$value['reid']);//���reid�Ƿ��Ƕ�����Ŀ
		$reid = $parentid['reid'];//��Ԫ�ص�reid
		$topid = $parentid['topid'];//��Ԫ�ص�topid
		if( $reid == 0 and $topid ==0 ){ //��Ԫ���Ƕ�����Ŀ  ����Ŀ�Ƕ�����Ŀ   �趨topid = reid
			if($value['topid'] != $value['reid']){ //topid!=reid  ˵������������  �޸�
				$r = mysql_query("UPDATE ".$table." SET topid='".$value['reid']."' WHERE id=".$value['id']);
				$count += $r ? 1 : 0;				
			}
		}elseif( $reid == $topid and $reid <> 0){
			//��Ԫ���Ƕ�����Ŀ ����Ŀ��������Ŀ  topid�͸��Ƕ�����Ŀ��reid  Ҳ���Ƕ�����Ŀid				
			if( $value['topid'] != $reid ){ 
				$r = mysql_query("UPDATE ".$table." SET topid='".$reid."' WHERE id=".$value['id']);
				$count += $r ? 1 : 0;				
			}
		}
	}
	return $count;
}



	function mysort($arr){
		$len = count($arr)-1;
		for($j=0;$j<$len;$j++){
			for($i=0;$i<$len-$j;$i++){
				if($arr[$i]>$arr[$i+1]){
					$k = $arr[$i];
					$arr[$i] = $arr[$i+1];
					$arr[$i+1] = $k;
				}
			}
		}
		return $arr;
	}
	
	function myorder($arr,$zd){
		$tmp = array();
		$tmp1 = array();
		foreach($arr as $v){
			$tmp[] = $v[$zd]; 
		}
		$tmp = mysort($tmp);

		foreach($tmp as $v){
			foreach($arr as $y){
				if($y[$zd] == $v){
					$tmp1[] = $y;
					break;
				}
			}
		}
		return $tmp1;
	}
?>