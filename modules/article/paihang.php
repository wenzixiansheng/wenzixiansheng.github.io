<?php
define('JIEQI_MODULE_NAME', 'system');
require_once('../../global.php');
jieqi_getconfigs(JIEQI_MODULE_NAME, 'blocks', 'jieqiBlocks');
include_once(JIEQI_ROOT_PATH.'/header.php');
$jieqiTpl->assign('jieqi_indexpage',1);
$jieqiTset['jieqi_contents_template'] = '';
$jieqiTset['jieqi_page_template']=JIEQI_ROOT_PATH.'/modules/article/templates/paihang.html';
include_once(JIEQI_ROOT_PATH.'/footer.php');
?>