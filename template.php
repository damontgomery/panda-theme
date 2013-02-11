<?php

function panda_preprocess_block(&$variables, $hook) {
  // Add a count to all the blocks in the region.
  //$variables['classes_array'][] = 'count-' . $variables['block_id'];

  // Add a class to nodeblock blocks with their view mode
  if ($variables['block']->module === "nodeblock"){
    if (isset($variables['elements']['#view_mode'])){
      $variables['classes_array'][] = 'view-mode-' . str_replace('_', '-', $variables['elements']['#view_mode']);
    }
    else if (isset($variables['elements']['content']['#view_mode'])){
      $variables['classes_array'][] = 'view-mode-' . str_replace('_', '-', $variables['elements']['content']['#view_mode']);
    }
  }
} 

function panda_preprocess_html(&$variables, $hook){
  
  // Add webfonts
  drupal_add_css('http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Raleway:400,700,200');

  //fix intranet using IE7 Compatibility Mode
  drupal_add_http_header('X-UA-Compatible', 'IE=edge');
  
  //add jQuery from the CDN to have an up to date version available
  drupal_add_js('https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js',
    array(
      'type' => 'external',
      'scope' => 'header',
      'group' => JS_LIBRARY,
      'preprocess' => FALSE,
      'every_page' => TRUE,
      'weight' => -25,
    ));
  
  drupal_add_js('var jQuery_current = jQuery.noConflict(true);',
    array(
      'type' => 'inline',
      'scope' => 'header',
      'group' => JS_LIBRARY,
      'preprocess' => FALSE,
      'every_page' => TRUE,
      'weight' => -24,
    ));
  
  //added here for load order
  drupal_add_css('sites/all/libraries/fancybox/jquery.fancybox.css');
  drupal_add_js('sites/all/libraries/fancybox/jquery.fancybox.js');
  drupal_add_js('sites/all/libraries/fancybox/helpers/jquery.fancybox-media.js');
  
  drupal_add_js('sites/all/libraries/ezMark/js/jquery.ezmark.js');
  
  if (!(in_array('responsive-full-page', $variables['classes_array'], true))){
    //drupal_add_css(path_to_theme() . '/css/core/responsive.css');
    //drupal_add_js(path_to_theme() . '/js/responsive.js');
    
    // add meta tag to set iphone / ipad to display with device width
    $viewport = array(
      '#type' => 'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'name' => 'viewport',
        'content' =>  'width=device-width, initial-scale=1',
      )
    );

    // Add header meta tag for IE to head
    drupal_add_html_head($viewport, 'viewport-meta');
    
    // iPhone scroll past chrome
    
    $iphone_scroll = array(
      '#type' => 'html_tag',
      '#tag' => 'meta',
      '#attributes' => array(
        'name' => 'apple-mobile-web-app-capable',
        'content' =>  'yes',
      )
    );
    
    drupal_add_html_head($iphone_scroll, 'iphone-scroll-meta');
    
    // Add a class for no-js which is removed by js if js is enabled.  This allows easier themeing.
    $variables['classes_array'][] = 'no-js';
  }
}

function panda_preprocess_views_view(&$variables) {
  if (isset($variables['view']->name)) {
    $function = 'panda_preprocess_views_view__'.$variables['view']->name;
    if (function_exists($function)) {
     $function($variables);
    }
  }
  
  //Add the title as a variable ALWAYS.  Not sure why this was removed even though it was in ALL the templates.  Templates can now choose to display the title or not.
  $view = $variables['view'];
  
  $variables['title'] = filter_xss_admin($view->get_title());
}

/*Remove the automatic addition of width and height attributes for images.  This speeds front-end performance, but breaks responsive designs.*/
function panda_preprocess_image(&$variables) {
  unset(
    $variables['width'],
    $variables['height'],
    $variables['attributes']['width'],
    $variables['attributes']['height']
  );
}

// Use node--view-mode.tpl.php files and node--type--view-mode.tpl.php files

function panda_preprocess_node(&$variables) {
  $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->type . '__' . $variables['view_mode'];
  $variables['theme_hook_suggestions'][] = 'node__' . $variables['view_mode'];

  // add class variables
  
  $variables['classes_array'][] = 'node-' . $variables['node']->nid;
  $variables['classes_array'][] = 'clearfix';
  $variables['classes_array'][] = str_replace('_', '-', $variables['view_mode']);

  // create by_line variable that is a replacement for $submitted
  $variables['content']['by_line'] = array(
    '#type' => 'markup',
    '#markup' => '<span class="meta-label">by</span> ' . $variables['name'] . ' <span class="meta-label">' . date('D M j, Y', $variable['node']->created) . '</span>',
    '#prefix' => '<div class="by-line">',
    '#suffix' => '</div>',
  );

  // hide some variables by default
  
  hide($variables['content']['comments']);
  hide($variables['content']['links']);
  hide($variables['content']['by_line']);
  
}
