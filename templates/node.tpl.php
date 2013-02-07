<div class="node-<?php print $node->nid; ?> <?php print $classes; ?> <?php print str_replace('_', '-', $view_mode); ?> clearfix"<?php print $attributes; ?>>

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
    ?>
    
    <div class="user clearfix">
      <span class="meta-label">by</span> <?php print $name; ?> <span class="meta-label">on <?php print $date; ?></span>
    </div>

    <?php
      print render($content);
    ?>
  </div>

  <?php print render($content['links']); ?>
</div><!-- /.node -->
