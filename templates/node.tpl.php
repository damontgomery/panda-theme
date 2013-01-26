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
      print render($content);
      print render($content['comments']);
    ?>
  </div>

  <?php print render($content['links']); ?>
</div><!-- /.node -->
