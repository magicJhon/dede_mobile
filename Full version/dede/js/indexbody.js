<!--

function AddNew()
{
    $DE('addTab').style.display = 'block';
}

function CloseTab(tb)
{
    $DE(tb).style.display = 'none';
}

function ListAll(){
    $DE('editTab').style.display = 'block';
    var myajax = new DedeAjax($DE('editTabBody'));
    myajax.SendGet('index_body.php?dopost=editshow');
}

function LoadUpdateInfos(){
	$DE('updateinfos').innerHTML = "<div style=\"height:90px;\"><img src='images/loadinglit.gif' /> ���ڴ�����...</div>";
    var myajax = new DedeAjax($DE('updateinfos'));
    myajax.SendGet('update_guide.php?dopost=test');
}

function SkipReload(nnum){
    if( window.confirm("���Ժ��Ժ󶼲�������ʾ�������ǰ��������Ϣ����ȷ��Ҫ������Щ������?") )
    {
        DedeXHTTP = null;
        $DE('updateinfos').innerHTML = "<img src='images/loadinglit.gif' /> ���ڴ�����...";
        var myajax = new DedeAjax($DE('updateinfos'));
        myajax.SendGet('update_guide.php?dopost=skip&vtime='+nnum);
    }
}

function ShowWaitDiv(){
    $DE('loaddiv').style.display = 'block';
    return true;
}

window.onload = function()
{
    var myajax = new DedeAjax($DE('listCount'));
    myajax.SendGet('index_body.php?dopost=getRightSide');
};

-->
