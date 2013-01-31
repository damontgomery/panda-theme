<?php
?>
<div class="comments clearfix <?php print $classes . ' ' . $zebra; ?>"<?php print $attributes; ?>>

  <div class="content" <?php print $content_attributes; ?>>
    
    <div class="timestamp meta-label">
      <?php print date('M j, Y H:i a T', $node->created); ?>
    </div>
    
    <div class="user clearfix">
      <?php print $picture ?>
      <div class="username">
        <?php 
          print str_replace(' (not verified)', '', $author);
        ?>
      </div>
      
    </div>

    
    
    <div class="body">
      <div class="main">
        <?php hide($content['links']); print render($content); ?>
      </div>
      <div class="signature">
        <?php print $signature ?>
      </div>
      
    </div>
    
  </div>
  <?php //print render($content['links']) ?>
  
</ul>
</div>
