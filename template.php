<?php

function rsfilter_preprocess_rsfilter(&$vars, $hook) {
 if ($vars['node']->type == 'thm'){
    $vars['theme_hook_suggestions'][]	= 'rs_resource';
 }
 else if ($vars['node']->type == 'link'){
    $vars['theme_hook_suggestions'][] = 'rsfilter__link';
 }
}

define('MY_MODULE_PATH', drupal_get_path('module', 'rsfilter'));
function my_module_theme_registry_alter(&$theme_registry) {
  $theme_registry_copy = $theme_registry;
  _theme_process_registry($theme_registry_copy, 'phptemplate', 'theme_engine', 'rsfilter', MY_MODULE_PATH);
  $theme_registry += array_diff_key($theme_registry_copy, $theme_registry);
  // A list of templates the module will provide templates for
  $hooks = array('page');
  foreach ($hooks as $h) {
    // Add the key 'theme paths' if it doesn't exist in this theme's registry
    if (!isset($theme_registry[$h]['theme paths'])) {
      $theme_registry[$h]['theme paths'] = array();
    }
    //Shift this module's directory to the top of the theme path list
    if(is_array($theme_registry[$h]['theme paths'])) {
      $first_element = array_shift($theme_registry[$h]['theme paths']);
      if ($first_element) {
        array_unshift($theme_registry[$h]['theme paths'], $first_element, MY_MODULE_PATH);
      } else {
        array_unshift($theme_registry[$h]['theme paths'], MY_MODULE_PATH);
      }
    }
  }
}

?>