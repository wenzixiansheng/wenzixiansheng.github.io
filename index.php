<?php
define('JIEQI_MODULE_NAME', 'system');
require_once('global.php');

jieqi_getconfigs(JIEQI_MODULE_NAME, 'blocks', 'jieqiBlocks');

include_once(JIEQI_ROOT_PATH.'/header.php');

$jieqiTpl->assign('jieqi_indexpage',1);  //������ҳ��־������ģ����������ж�
$jieqiTset['jieqi_contents_template'] = '';  //����λ�ò���ֵ��ȫ��������
$jieqiTset['jieqi_page_template']=JIEQI_ROOT_PATH.'/17mb/17mb.html';//���ø�ҳ���ģ���ļ���index_1�����Զ������ƣ�
include_once(JIEQI_ROOT_PATH.'/footer.php');
?>