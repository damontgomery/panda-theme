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
  
  //added here for load order
  drupal_add_css('profiles/gamerswithjobs/libraries/fancybox/jquery.fancybox.css');
  drupal_add_js('profiles/gamerswithjobs/libraries/fancybox/jquery.fancybox.js');
  drupal_add_js('profiles/gamerswithjobs/libraries/fancybox/helpers/jquery.fancybox-media.js');
  
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
    '#markup' => '<span class="meta-label">by</span> ' . $variables['name'] . ' <span class="meta-label">' . date('D M j, Y', $variables['node']->created) . '</span>',
    '#prefix' => '<div class="by-line">',
    '#suffix' => '</div>',
  );

  // Send the comments to the page template separately.
  if (isset($variables['content']['comments'])) {
    // I couldn't figure out the ordering of the page preprocess functions, etc and the pager was broken when using comment_node_page_additions() in hook_preprocess_page();
    global $panda_comments;
    $panda_comments = $variables['content']['comments'];
  }

  // hide some variables by default
  hide($variables['content']['comments']);
  hide($variables['content']['links']);
  hide($variables['content']['by_line']);
  
}

// Remove some module CSS files
function panda_css_alter(&$css) {
  unset($css[drupal_get_path('module', 'system') . '/system.menus.css']);
  unset($css[drupal_get_path('module', 'system') . '/system.theme.css']);
  unset($css[drupal_get_path('module', 'user') . '/user.css']);
}

// Add classes, etc to the comment's links. This provides tooltips and icons in place of text links / buttons

function panda_preprocess_comment(&$variables) {
  $comment_uid = $variables['elements']['#comment']->uid;

  //caching the detailed author information to reduce processing time to about 33% of previous load
  if($cached_author_data = cache_get('panda_comment_author_data_' . $comment_uid, 'cache'))  {
    $variables['author_details'] = $cached_author_data->data;
  }
  else {
    // We need to get all the user data in the comment.
    $author_entity = user_load($comment_uid);
    
    // set up some view options to hide labels!
    $field_view_options = array(
      'label' => 'hidden',
    );

    // Get the rank
    $rank->items = field_get_items('user', $author_entity, 'field_rank');
    $rank->term = taxonomy_term_load($rank->items[0]['tid']);
    $variables['author_details']['rank']['#markup'] = $rank->term->name;

    // Get the Custom Rank
    $rank_custom = field_view_field('user', $author_entity, 'field_custom_rank', $field_view_options);

    // If a custom rank is set, swap it out!
    if ($rank_custom) {
      $variables['author_details']['rank']['#markup'] = $rank_custom[0]['#markup'];
    }

    // Get the location
    $variables['author_details']['location'] = field_view_field('user', $author_entity, 'field_location', $field_view_options);

    // Get the Gaming Services
    $game_ids->items = field_get_items('user', $author_entity, 'field_gaming_services');

    if ($game_ids->items) {

      $game_id_entity_ids = array();
      $variables['author_details']['game_ids'] = array();

      foreach($game_ids->items as $game_id) {
        $game_id_entity_ids[] = $game_id['value'];
      }

      $game_ids->field_collections = entity_load('field_collection_item', $game_id_entity_ids);
      
      foreach($game_ids->field_collections as $fc) {
        $id->name = field_view_field('field_collection_item', $fc, 'field_game_service_identity');
        $id->name = $id->name[0]['#markup'];

        $id->service->items = field_get_items('field_collection_item', $fc, 'field_game_service');
        $id->service->term = taxonomy_term_load($id->service->items[0]['tid']);

        switch ($id->service->term->name) {
          case 'PSN':
            $id->service->name = 'psn';
            break;
          case 'Steam':
            $id->service->name = 'steam';
            break;
          case 'Wii':
            $id->service->name = 'wii';
            break;
          case 'XBox Live':
            $id->service->name = 'xbox';
            break;
        }

        $variables['author_details']['game_ids'][$id->service->name]['#markup'] = '<div class="' . $id->service->name . ' icon"><div class="tooltip">' . $id->name . '</div></div>';
      }
    }

    // Get the donation level (we need to upload some doner images to see what to pull from here.)
    $donate_level->items = field_get_items('user', $author_entity, 'field_donator_level');
    if ($donate_level->items){
      $donate_level->term = taxonomy_term_load($donate_level->items[0]['tid']);
    
      if (count($donate_level->term->field_image) > 0){
        $variables['author_details']['donate_level'] = field_view_field('taxonomy_term', $donate_level->term, 'field_image', $field_view_options);
      }
    }

    // Set the cache
    cache_set('panda_comment_author_data_' . $comment_uid, $variables['author_details'], 'cache', CACHE_TEMPORARY);
  }
  
  //format the date
  $variables['created'] = date('M j, Y g:i a', $variables['elements']['#comment']->created);

  // Add classes to all the actions!
  if (isset($variables['content']['links']['comment']['#links']['comment-delete'])){
    $variables['content']['links']['comment']['#links']['comment-delete']['attributes']['class'] = array('icon', 'delete');
    $variables['content']['links']['comment']['#links']['comment-delete']['title'] = '<span class="tooltip">delete</span>';
  }

  if (isset($variables['content']['links']['comment']['#links']['comment-edit'])){
    $variables['content']['links']['comment']['#links']['comment-edit']['attributes']['class'] = array('icon', 'edit');
    $variables['content']['links']['comment']['#links']['comment-edit']['title'] = '<span class="tooltip">edit</span>';
  }

  if (isset($variables['content']['links']['comment']['#links']['comment-reply'])){
    $variables['content']['links']['comment']['#links']['comment-reply']['attributes']['class'] = array('icon', 'quote');
    $variables['content']['links']['comment']['#links']['comment-reply']['title'] = '<span class="tooltip">quote</span>';
  }

  if (isset($variables['content']['links']['flag']['#links']['flag-report_comment'])){
    $variables['content']['links']['flag']['#links']['flag-report_comment']['attributes']['class'] = array('icon', 'flag');
    $variables['content']['links']['flag']['#links']['flag-report_comment']['title'] = '<span class="tooltip">report</span>';
  }
}
