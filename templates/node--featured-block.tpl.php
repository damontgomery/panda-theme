<div class="node-<?php print $node->nid; ?> <?php print $classes; ?> <?php print str_replace('_', '-', $view_mode); ?> clearfix"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
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

    <div class="hero">
      <?php print render($content); ?>

      <div class="section"><?php print 'Article'; //render($content['field_section']); ?></div>

      <div class="comment-count">
            <div class="comment icon no-hover"></div>
            <span class="count"><?php print $comment_count; ?></span>
          </div>

      <div class="title-block">
        <div class="content">
          <h3<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h3>
        </div>
      </div>

    </div>
  </div>

  <?php// print render($content['links']); ?>
</div><!-- /.node -->
