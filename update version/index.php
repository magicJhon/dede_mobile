<?php
/**
 * @version        $Id: index.php 1 9:23 2010-11-11 tianya $
 * @package        DedeCMS.Site
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
if(!file_exists(dirname(__FILE__).'/data/common.inc.php'))
{
    header('Location:install/index.php');
    exit();
}
// �ж��Ƿ����ֻ�
if(isMobile()){
    header('Location:wap.php');
    exit();
}
//�Զ�����HTML��
if(isset($_GET['upcache']) || !file_exists('index.html'))
{
    require_once (dirname(__FILE__) . "/include/common.inc.php");
    require_once DEDEINC."/arc.partview.class.php";
    $GLOBALS['_arclistEnv'] = 'index';
    $row = $dsql->GetOne("Select * From `#@__homepageset`");
    $row['templet'] = MfTemplet($row['templet']);
    $pv = new PartView();
    $pv->SetTemplet($cfg_basedir . $cfg_templets_dir . "/" . $row['templet']);
    $row['showmod'] = isset($row['showmod'])? $row['showmod'] : 0;
    if ($row['showmod'] == 1)
    {
        $pv->SaveToHtml(dirname(__FILE__).'/index.html');
        include(dirname(__FILE__).'/index.html');
        exit();
    } else { 
        $pv->Display();
        exit();
    }
}
else
{
    header('HTTP/1.1 301 Moved Permanently');
    header('Location:index.html');
}


function isMobile()
{
// �����HTTP_X_WAP_PROFILE��һ�����ƶ��豸
if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
{
return true;
}
// ���via��Ϣ����wap��һ�����ƶ��豸,���ַ����̻����θ���Ϣ
if (isset ($_SERVER['HTTP_VIA']))
{
// �Ҳ���Ϊflase,����Ϊtrue
return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
}
// �Բз����ж��ֻ����͵Ŀͻ��˱�־,�������д����
if (isset ($_SERVER['HTTP_USER_AGENT']))
{
$clientkeywords = array ('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile');
// ��HTTP_USER_AGENT�в����ֻ�������Ĺؼ���
if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
{
return true;
}
}
// Э�鷨����Ϊ�п��ܲ�׼ȷ���ŵ�����ж�
if (isset ($_SERVER['HTTP_ACCEPT']))
{
// ���ֻ֧��wml���Ҳ�֧��html��һ�����ƶ��豸
// ���֧��wml��html����wml��html֮ǰ�����ƶ��豸
if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
{
return true;
}
}
return false;
}
?>