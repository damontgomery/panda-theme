<div class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <?php if (isset($unpublished)): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>

  <div class="content"<?php print $content_attributes; ?>>

    <div class="social-links">
      <?php // <div class="social-icon"><span class="meta-label">share</span></div> ?>
      <?php //print render($content['easy_social_1']) ?>    
    </div>

    <div class="hero">

      <?php print render($content['field_hero']);?>

      <div class="title-block">
        <div class="content">
          <div class="section"><?php print render($content['field_section']); ?></div>
          <h1<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h1>
          <?php print render($content['by_line']); ?>
          <div class="comment-count">
            <div class="comment icon no-hover"></div>
            <span class="count"><?php print $comment_count; ?></span>
          </div>
        </div>
      </div>

    </div>

    <?php print render($content['body']); ?>
  </div>
</div><!-- /.node -->
