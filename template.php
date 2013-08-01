<?php

include 'template_extensions.php';

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

  //add an icon to the user block
  if ($variables['block']->module === 'user' && $variables['block']->delta === 'login'){
    $variables['block']->subject = '<span class="icon lock">Log in</span>';
  }

  panda_extensions_preprocess_block($variables, $hook);
}

// When the view is displayed as a block, render the contextual links for it at the block level, not the page level
function panda_block_view_system_main_alter(&$data, $block) {
  if (module_exists('views')) {
    $view = views_get_page_view();
    if (!empty($view)) {
      views_add_contextual_links($data['content'], 'page', $view, $view->current_display);
    }
  }

  panda_extensions_block_view_system_main_alter($data, $block);
} 

function panda_preprocess_html(&$variables, $hook){
  
  // Add webfonts
  //drupal_add_css('http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700|Raleway:400,700,200');

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

  //dev version of modernizr
  drupal_add_js('http://modernizr.com/downloads/modernizr-latest.js',
    array(
      'type' => 'external',
      'scope' => 'header',
      'group' => JS_LIBRARY,
      'preprocess' => FALSE,
      'every_page' => TRUE,
      'weight' => -30,
    ));

  //MediaElement.js audio player
  drupal_add_js('http://cdn.jsdelivr.net/mediaelement/2.12.0/mediaelement-and-player.min.js',
    array(
      'type' => 'external',
      'scope' => 'header',
      'group' => JS_LIBRARY,
      'preprocess' => FALSE,
      'every_page' => TRUE,
    ));
  
  //added here for load order
  drupal_add_css(path_to_theme() . '/js/fancybox/jquery.fancybox.css');
  drupal_add_js(path_to_theme() . '/js/fancybox/jquery.fancybox.js');
  drupal_add_js(path_to_theme() . '/js/fancybox/helpers/jquery.fancybox-media.js');
  
  drupal_add_js(path_to_theme() . '/js/pandaMark.js');
  
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

  panda_extensions_preprocess_html($variables, $hook);
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
  
  //mimic the node template $page flag
  if ($view->current_display === "page"){
    $variables['page'] = TRUE;
  }
  else {
    $variables['page'] = FALSE;
  }

  $variables['title'] = filter_xss_admin($view->get_title());

  panda_extensions_preprocess_views_view($variables);
}

/*Remove the automatic addition of width and height attributes for images.  This speeds front-end performance, but breaks responsive designs.*/
function panda_preprocess_image(&$variables) {
  unset(
    $variables['width'],
    $variables['height'],
    $variables['attributes']['width'],
    $variables['attributes']['height']
  );

  panda_extensions_preprocess_image($variables);
}

function panda_process_node(&$variables) {
  // Display Suite puts a higher weight on content types than display modes, so ds_1_col__node_article.tpl.php will be used instead of ds_1_col__node_view_mode.tpl.php.
  // We want one view mode for featured content blocks, so I'm going to reverse this order by adding another suggestion to use the view mode

  $ds_layout = NULL;

  //get the ds layout type (example: 1col)
  if (isset($variables['rendered_by_ds']) && $variables['rendered_by_ds']){
    foreach($variables['theme_hook_suggestions'] as $theme_suggestion){
      if (substr($theme_suggestion, 0, 2) === 'ds'){
        $ds_layout = $theme_suggestion;
        break;
      }
    }
  }

  // add the theme suggestion
  if ($ds_layout) {
    $variables['theme_hook_suggestions'][] = $ds_layout . '__node_' . $variables['view_mode'];
  }

  panda_extensions_process_node($variables);
}

function panda_preprocess_node(&$variables) {
  // Use node--view-mode.tpl.php files and node--type--view-mode.tpl.php files
  $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->type . '__' . $variables['view_mode'];
  $variables['theme_hook_suggestions'][] = 'node__' . $variables['view_mode'];

  // add class variables
  
  $variables['classes_array'][] = 'node-' . $variables['node']->nid;
  $variables['classes_array'][] = 'clearfix';
  $variables['classes_array'][] = str_replace('_', '-', $variables['view_mode']);


  // Send the comments to the page template separately.
  if (isset($variables['content']['comments'])) {
    // I couldn't figure out the ordering of the page preprocess functions, etc and the pager was broken when using comment_node_page_additions() in hook_preprocess_page();
    global $panda_comments;
    $panda_comments = $variables['content']['comments'];
  }

  // hide some variables by default
  hide($variables['content']['comments']);
  hide($variables['content']['links']);
  
  panda_extensions_preprocess_node($variables);
}

// Remove some module CSS files
function panda_css_alter(&$css) {
  unset($css[drupal_get_path('module', 'system') . '/system.menus.css']);
  unset($css[drupal_get_path('module', 'system') . '/system.theme.css']);
  unset($css[drupal_get_path('module', 'user') . '/user.css']);

  panda_extensions_css_alter($css);
}

function panda_node_view_alter(&$build) {
  // add the contextual links to nodes when rendered as pages!
  // before, this wouldn't happen if it were a page
  if (!empty($build['#node']->nid) && ($build['#view_mode'] == 'full' && node_is_page($build['#node']))) {
    $build['#contextual_links']['node'] = array('node', array($build['#node']->nid));
  }

  panda_extensions_node_view_alter($build);
}

