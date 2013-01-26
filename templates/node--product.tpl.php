<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php if ($title && !$page): ?>
    <h1<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h1>
  <?php endif; ?>
  <?php print render($title_suffix); ?>

  <?php if (isset($unpublished)): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>

  <?php if ($display_submitted): ?>
    <div class="submitted">
      <?php print $submitted; ?>
    </div>
  <?php endif; ?>

  <div class="content"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      //print render($content);
    ?>
    
    <div class="product-description">
      <?php print render($content['body']);?>
    </div>
    
    <div class="col-2"><div class="content">
      <?php print render($content['field_product_images']);?>
      
      <?php
      if (isset($content['field_product_shapes'])){
        print '<div class="product-shapes">'
            . '<h2>Shapes</h2>';
                
        
        foreach ($content['field_product_shapes']['#items'] as $shape){
          $shape_title = $shape['taxonomy_term']->name;
          $shape_img = file_create_url($shape['taxonomy_term']->field_shape_icon['und'][0]['uri']);

          print '<div class="product-shape">'
              . '<img src="' . $shape_img . '" alt="" class="shape-icon">'
              . '<div class="shape-term">' . $shape_title . '</div>'
              . '</div>';

        }
        
        print '</div>';
      }
      
      //print render($content['field_product_shapes']);
      
      ?>
      
      <?php //print render($content['field_product_category']);?>
      <?php print render($content['field_tags']);?>
    </div></div>
    
    
    <div class="col-2">
      <div class="content">
        
        <?php if (isset($content['field_product_benefits'])): ?>
        <div class="product-benefits">
          <h2>Benefits</h2>
          <?php print render($content['field_product_benefits']);?>
        </div>
        <?php endif; ?>
        
        <?php if (isset($content['field_product_ingredients'])): ?>
        <div class="product-benefits">
          <h2>Ingredients</h2>
          <?php print render($content['field_product_ingredients']);?>
        </div>
        <?php endif; ?>
        
      </div>
    </div>
    
    
    <?php print render($content['comments']);?>
  </div>

  <?php print render($content['links']); ?>
</div><!-- /.node -->
