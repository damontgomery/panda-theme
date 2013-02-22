<div class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <?php if (isset($unpublished)): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>

  <div class="content"<?php print $content_attributes; ?>>

    <div class="hero">
      <?php print render($content); ?>

      <div class="section"><?php print 'Article'; //render($content['field_section']); ?></div>

      
      <div class="title-block">
        <div class="content">
          <div class="comment-count">
            <div class="comment icon no-hover"></div>
            <span class="count"><?php print $comment_count; ?></span>
          </div>
          <h3<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h3>
        </div>
      </div>

    </div>
  </div>

  <?php// print render($content['links']); ?>
</div><!-- /.node -->
