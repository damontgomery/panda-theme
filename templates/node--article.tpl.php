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
      hide($content['taxonomy_forums']); //temporary
      hide($content['easy_social_1']);
      hide($content['field_hero']);
    ?>

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
          <div class="by-line"><span class="meta-label">by</span> <?php print $name; ?> <span class="meta-label"><?php print $date; ?></span></div>
          <div class="comment-count">
            <div class="comment icon no-hover"></div>
            <span class="count"><?php print $comment_count; ?></span>
          </div>
        </div>
      </div>

    </div>

    <?php print render($content['body']); ?>
  </div>

  <?php print render($content['links']); ?>
</div><!-- /.node -->
