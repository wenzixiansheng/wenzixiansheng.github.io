<?php 
/**
* 文章信息页
*
* 显示一篇文章信息，包括最近书评等
* 
* 调用模板：/modules/article/templates/articleinfo.html
* 
* @category   jieqicms
* @package    article
* @copyright  Copyright (c) Hangzhou Jieqi Network Technology Co.,Ltd. (http://www.wonmeng.com)
* @author     $Author: juny $
* @version    $Id: articleinfo.php 332 2009-02-23 09:15:08Z juny $
*/

define('JIEQI_MODULE_NAME', 'article');
if(!defined('JIEQI_GLOBAL_INCLUDE')) include_once('../../global.php');
if(empty($_REQUEST['id'])) jieqi_printfail(LANG_ERROR_PARAMETER);
jieqi_loadlang('article', JIEQI_MODULE_NAME);
include_once($jieqiModules['article']['path'].'/class/article.php');
$article_handler =& JieqiArticleHandler::getInstance('JieqiArticleHandler');
$article=$article_handler->get($_REQUEST['id']);
if(!$article) jieqi_printfail($jieqiLang['article']['article_not_exists']);
elseif($article->getVar('display') != 0 && $jieqiUsersStatus != JIEQI_GROUP_ADMIN) jieqi_printfail($jieqiLang['article']['article_not_audit']);
else{
        //包含区块参数(定制)
        jieqi_getconfigs(JIEQI_MODULE_NAME, 'sort');
        jieqi_getconfigs(JIEQI_MODULE_NAME, 'configs');
        $jieqi_pagetitle=$article->getVar('articlename').'-'.$article->getVar('author').'-'.JIEQI_SITE_NAME;
        include_once(JIEQI_ROOT_PATH.'/header.php');

        $article_static_url = (empty($jieqiConfigs['article']['staticurl'])) ? $jieqiModules['article']['url'] : $jieqiConfigs['article']['staticurl'];
        $article_dynamic_url = (empty($jieqiConfigs['article']['dynamicurl'])) ? $jieqiModules['article']['url'] : $jieqiConfigs['article']['dynamicurl'];
        $jieqiTpl->assign('article_static_url',$article_static_url);
        $jieqiTpl->assign('article_dynamic_url',$article_dynamic_url);
        $jieqiTpl->assign('makezip', $jieqiConfigs['article']['makezip']);
        $jieqiTpl->assign('makejar', $jieqiConfigs['article']['makejar']);
        $jieqiTpl->assign('makeumd', $jieqiConfigs['article']['makeumd']);
        $jieqiTpl->assign('maketxtfull', $jieqiConfigs['article']['maketxtfull']);
        $jieqiTpl->assign('maketxt', $jieqiConfigs['article']['maketxt']);
        

        $jieqiTpl->assign('articlename', $article->getVar('articlename'));
        $jieqiTpl->assign('keywords', $article->getVar('keywords'));
        $jieqiTpl->assign('postdate', date(JIEQI_DATE_FORMAT, $article->getVar('postdate')));
        $jieqiTpl->assign('lastupdate', date(JIEQI_DATE_FORMAT, $article->getVar('lastupdate')));
        $jieqiTpl->assign('authorid', $article->getVar('authorid'));
        $jieqiTpl->assign('author', $article->getVar('author'));
        $jieqiTpl->assign('agentid', $article->getVar('agentid'));
        $jieqiTpl->assign('agent', $article->getVar('agent'));
        $jieqiTpl->assign('sortid', $article->getVar('sortid'));
        $_REQUEST['class'] = $article->getVar('sortid');
        $_REQUEST['sortid'] = $article->getVar('sortid');
        
        $jieqiTpl->assign('sort', $jieqiSort['article'][$article->getVar('sortid')]['caption']);
        $preg_from=array(
        '/((https?|ftp):\/\/|www\.)[a-z0-9\/\-_+=.~!%@?#%&;:$\\│]+(\.gif|\.jpg|\.jpeg|\.png|\.bmp)/isU'
        );
        $preg_to=array(
        '<img src="\\0" border="0">'
        );
        $jieqiTpl->assign('intro',preg_replace($preg_from, $preg_to, $article->getVar('intro')));
        $jieqiTpl->assign('notice', preg_replace($preg_from, $preg_to, $article->getVar('notice')));

        //文章封面图片标志
        $jieqiTpl->assign('imgflag', $article->getVar('imgflag','n'));
        $url_simage = jieqi_geturl('article', 'cover', $article->getVar('articleid'), 's', $article->getVar('imgflag','n'));
        if(!empty($url_simage)) $jieqiTpl->assign('hasimage', 1);
        else $jieqiTpl->assign('hasimage', 0);
        $jieqiTpl->assign('url_simage',$url_simage);
        $jieqiTpl->assign('url_limage',jieqi_geturl('article', 'cover', $article->getVar('articleid'), 'l', $article->getVar('imgflag','n')));
        $lastchapter=$article->getVar('lastchapter');
        if($lastchapter != ''){
                if($article->getVar('lastvolume') != '') $lastchapter=$article->getVar('lastvolume').' '.$lastchapter;
                $jieqiTpl->assign('url_lastchapter', jieqi_geturl('article', 'chapter', $article->getVar('lastchapterid'), $article->getVar('articleid')));
        }else{
                $jieqiTpl->assign('url_lastchapter', '');
        }
        $jieqiTpl->assign('lastchapter', $lastchapter);
        $jieqiTpl->assign('size', $article->getVar('size'));
        $jieqiTpl->assign('size_k', ceil($article->getVar('size')/1024));
        $jieqiTpl->assign('size_c', ceil($article->getVar('size')/2));
        $jieqiTpl->assign('dayvisit', $article->getVar('dayvisit'));
        $jieqiTpl->assign('weekvisit', $article->getVar('weekvisit'));
        $jieqiTpl->assign('monthvisit', $article->getVar('monthvisit'));
        $jieqiTpl->assign('mouthvisit', $article->getVar('monthvisit'));
        $jieqiTpl->assign('allvisit', $article->getVar('allvisit'));
        $jieqiTpl->assign('dayvote', $article->getVar('dayvote'));
        $jieqiTpl->assign('weekvote', $article->getVar('weekvote'));
        $jieqiTpl->assign('monthvote', $article->getVar('monthvote'));
        $jieqiTpl->assign('mouthvote', $article->getVar('monthvote'));
        $jieqiTpl->assign('allvote', $article->getVar('allvote'));
        $jieqiTpl->assign('goodnum', $article->getVar('goodnum'));
        $jieqiTpl->assign('badnum', $article->getVar('badnum'));
        if($article->getVar('fullflag')==0) $jieqiTpl->assign('fullflag', $jieqiLang['article']['article_not_full']);
        else $jieqiTpl->assign('fullflag', $jieqiLang['article']['article_is_full']);
        $tmpvar='';
        switch($article->getVar('permission')){
                case '3':
                        $tmpvar=$jieqiLang['article']['article_permission_special'];
                        break;
                case '2':
                        $tmpvar=$jieqiLang['article']['article_permission_insite'];
                        break;
                case '1':
                        $tmpvar=$jieqiLang['article']['article_permission_yes'];
                        break;
                case '0':
                default:
                        $tmpvar=$jieqiLang['article']['article_permission_no'];
                        break;
        }
        $jieqiTpl->assign('permission', $tmpvar);
        $tmpvar='';
        switch($article->getVar('firstflag')){
                case '1':
                        $tmpvar=$jieqiLang['article']['article_site_publish'];
                        break;
                case '0':
                default:
                        $tmpvar=$jieqiLang['article']['article_other_publish'];
                        break;
        }
        $jieqiTpl->assign('firstflag', $tmpvar);
        //管理
        $jieqiTpl->assign('url_manage', $article_static_url.'/articlemanage.php?id='.$article->getVar('articleid'));
        //举报
        $tmpstr=sprintf($jieqiLang['article']['article_report_reason'], jieqi_geturl('article', 'article', $article->getVar('articleid'), 'info'));
        $jieqiTpl->assign('url_report', JIEQI_URL.'/newmessage.php?tosys=1&title='.urlencode(sprintf($jieqiLang['article']['article_report_title'], $article->getVar('articlename','n'))).'&content='.urlencode($tmpstr));
        //采集
        $setting=unserialize($article->getVar('setting', 'n'));        $url_collect=$article_static_url.'/admin/collect.php?toid='.$article->getVar('articleid', 'n');
        if(is_numeric($setting['fromarticle'])) $url_collect.='&fromid='.$setting['fromarticle'];
        if(is_numeric($setting['fromsite'])) $url_collect.='&siteid='.$setting['fromsite'];
        $jieqiTpl->assign('url_collect', $url_collect);

     

       

       
        $jieqiTpl->setCaching(0);
        $jieqiTset['jieqi_contents_template'] = $jieqiModules['article']['path'].'/templates/52mb_uptime.html';
        //点击统计要设置cookie和访问数据库，所以放footer.php前面
        if(!isset($jieqiConfigs['article']['visitstatnum']) || !empty($jieqiConfigs['article']['visitstatnum'])) include_once($jieqiModules['article']['path'].'/articlevisit.php');
        include_once(JIEQI_ROOT_PATH.'/footer.php');
}
?>