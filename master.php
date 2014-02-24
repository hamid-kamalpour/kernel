<?php

defined('_JEXEC') or die;
// variables
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$params = $app->getParams();
$headdata = $doc->getHeadData();
$menu = $app->getMenu();
$active = $app->getMenu()->getActive();
$pageclass = $params->get('pageclass_sfx');
$tpath = $this->baseurl . '/templates/' . $this->template;

// Detecting Active Variables
$option = $app->input->getCmd('option', '');
$view = $app->input->getCmd('view', '');
$layout = $app->input->getCmd('layout', '');
$task = $app->input->getCmd('task', '');
$itemid = $app->input->getCmd('Itemid', '');
$sitename = $app->getCfg('sitename');

// detecting page title
$page_title = $doc->getTitle();

// Add current user information
$user = JFactory::getUser();

// parameter
$lessjs = $this->params->get('lessjs');

// Logo file or site title param
if ($this->params->get('logo-image')) {
  $logo = '<img src="' . JUri::root() . $this->params->get('logo-image') . '" alt="' . $sitename . '" '
          . 'width="'. $this->params->get('logo-width') .'" />';
} elseif ($this->params->get('sitetitle')) {
  $logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle')) . '</span>';
} else {
  $logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');
$doc->addScript('templates/' . $this->template . '/js/template.js');

// Add Stylesheets
$doc->addStyleSheet('templates/' . $this->template . '/css/template.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/bootstrap.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/docs.css');

if ($app->isSite()) {
  // disable js
  if ( $this->params->get('disablejs') ) {
    $fnjs=$this->params->get('fnjs');
    if (trim($fnjs) != '') {
      $filesjs=explode(',', $fnjs);
      $head = (array) $headdata['scripts'];
      $newhead = array();         
      foreach($head as $key => $elm) {
        $add = true;
        foreach ($filesjs as $dis) {
          if (strpos($key,$dis) !== false) {
            $add=false;
            break;
          } 
        }
        if ($add) $newhead[$key] = $elm;
      }
      $headdata['scripts'] = $newhead;
    } 
  } 
  // disable css
  if ( $this->params->get('disablecss') ) {
    $fncss=$this->params->get('fncss');
    if (trim($fncss) != '') {
      $filescss=explode(',', $fncss);
      $head = (array) $headdata['styleSheets'];
      $newhead = array();         
      foreach($head as $key => $elm) {
        $add = true;
        foreach ($filescss as $dis) {
          if (strpos($key,$dis) !== false) {
            $add=false;
            break;
          } 
        }
        if ($add) $newhead[$key] = $elm;
      }
      $headdata['styleSheets'] = $newhead;
    } 
  }
  $doc->setHeadData($headdata); 
}

// generator tag
$this->setGenerator(null);

// force latest IE & chrome frame
$doc->setMetadata('x-ua-compatible', 'IE=edge,chrome=1');
// add google font
if ($googlefont !='') $doc->addStyleSheet("https://fonts.googleapis.com/css?family=".$googlefont);

?>
