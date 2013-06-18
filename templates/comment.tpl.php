<?php
?>
<div class="comments clearfix <?php print $classes . ' ' . $zebra . ' comment-num-' . $id; ?>"<?php print $attributes; ?>>

  <div class="content" <?php print $content_attributes; ?>>
    
    <div class="user clearfix">
      <div class="username">
        <?php print str_replace(' (not verified)', '', $author); ?>
      </div>
      <div class="user-tag">
        <?php print render($author_details['rank']); ?>
      </div>
      <div class="user-donate">
        <?php print render($author_details['donate_level']); ?>
      </div>

      <?php print $picture ?>
      
      <div class="user-labels">
        <div class="user-accounts">
          <div class="xbox icon"><div class="tooltip">PandaEskimo</div></div>
          <div class="psn icon"><div class="tooltip">PandaEskimo</div></div>
          <div class="wii icon"><div class="tooltip">PandaEskimo</div></div>
          <div class="steam icon"><div class="tooltip">PandaEskimo</div></div>
        </div>

        <div class="user-location">
          <?php print render($author_details['location']); ?>
        </div>

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

    <div class="comment-footer">
      <div class="comment-actions">

        <?php print render($content['links']) ?>      

      </div>
      <div class="timestamp meta-label">
        <?php print date('M j, Y g:i a', $node->created); ?>
      </div>  
    </div>
    
    
  </div>
  
</div>
