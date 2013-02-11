<div class="<?php print $classes; ?>"<?php print $attributes; ?>>

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
    <?php print $by_line; ?>

    <?php
      print render($content);
      //print render($content['comments']);
    ?>
  </div>

  <?php print render($content['links']); ?>
</div><!-- /.node -->
