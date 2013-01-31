<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php if ($title && !$page): ?>
    <h1<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h1>
  <?php endif; ?>
  <?php print render($title_suffix); ?>

  <?php if (isset($unpublished)): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>

  <div class="content"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      hide($content['taxonomy_forums']); //temporary
      hide($content['easy_social_1']);
    ?>
    <div class="hero">

      <div class="user clearfix">
        <span class="meta-label">by</span> <?php print $name; ?> <span class="meta-label">on <?php print $date; ?></span>
      </div>

      <div class="comment-count">
        <span class="meta-label"><?php print count($content['comments']); ?> comments</span>
      </div>

      <div class="social-links">
        <div class="social-icon"><span class="meta-label">share</span></div>
        <?php print render($content['easy_social_1']) ?>    
      </div>

      <img src="http://images.wikia.com/fallout/images/1/1b/Fallout-wp7-1680x1050.jpg">

      <div class="caption">Fallout 3 is the greatest game every! Puce Moose Rules!</div>

    </div>

    <?php
      print render($content);
      print render($content['comments']);
    ?>
  </div>

  <?php print render($content['links']); ?>
</div><!-- /.node -->
