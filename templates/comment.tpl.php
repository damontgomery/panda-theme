<?php
?>
<div class="comments <?php print $classes . ' ' . $zebra; ?>"<?php print $attributes; ?>>

  <div class="content" <?php print $content_attributes; ?>>
    

    <?php print render($title_prefix); ?>
    <h3<?php print $title_attributes; ?>><?php print $title ?></h3>
    <?php print render($title_suffix); ?>
    
    <div class="submitted">
      <?php 
        //print $submitted
        $comment_author = str_replace(' (not verified)', '', $author);
        $comment_date = date('M j, Y H:i a T', $node->created);
        print "by $comment_author on $comment_date";
      ?>
    </div>
    <?php print $picture ?>
    
    <div class="content-body"><?php hide($content['links']); print render($content); ?></div>
    <?php print $signature ?>
    
  </div>
  <?php print render($content['links']) ?>
  
</ul>
</div>
