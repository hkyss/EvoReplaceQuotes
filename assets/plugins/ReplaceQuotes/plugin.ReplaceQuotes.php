<?php
/**
 * Replace Quotes
 *
 * plugin
 *
 * @category        plugin
 * @version         0.1
 * @author          hkyss
 * @documentation   empty
 * @lastupdate      18.05.2021
 * @internal    	@modx_category Resources
 * @internal    	@events OnDocFormSave
 * @internal    	@properties &fields=Наименования полей;string;pagetitle,menutitle &templates=Шаблоны;string;9
 *
 */

if(!defined('MODX_BASE_PATH')) die('What are you doing? Get out of here!');

global $template;

include_once MODX_BASE_PATH.'assets/lib/MODxAPI/modResource.php';
$modResource = new modResource($modx);

$template = !empty($template) ? $template : $doc['template'];
$templates = !empty($templates) ? explode(',',$templates) : array();

if($modx->event->name == 'OnDocFormSave' && array_search($template,$templates) !== false) {
  $modResource->edit((int)$id);

  if(!empty($fields)) {
    $fields = explode(',',$fields);
    foreach($fields as $item_key => $item) {
      $field = $modResource->get($item);
      $field = str_replace('\'','"',$field);
      $field = str_replace('"', '»', preg_replace('/((^|\s)"(\w))/um', '\2«\3', $field));
      $modResource->set($item,$field);
      unset($field);
    }
    $modResource->save(false,false);
    $modResource->close();
  }
}

unset($modResource);