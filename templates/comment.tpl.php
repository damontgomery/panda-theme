<?php
?>
<div class="comments clearfix <?php print $classes . ' ' . $zebra; ?>"<?php print $attributes; ?>>

  <div class="content" <?php print $content_attributes; ?>>
    
    <div class="timestamp meta-label">
      <?php print date('M j, Y H:i a T', $node->created); ?>
    </div>
    
    <div class="user clearfix">
      <?php print $picture ?>
      
      <div class="user-labels">
        <div class="username">
          <?php print str_replace(' (not verified)', '', $author); ?>
        </div>
        <div class="user-tag">
          Not Without Incident
        </div>
        <div class="user-donate">
          <img src="/sites/all/themes/panda/images/cruiseship.gif" alt="">
        </div>
        <div class="user-location">
          <span class="meta-label">location</span> Neither here nor there in a world of wonder
        </div>

        <div class="user-accounts">
        <div class="xbox"><span class="meta-label">XBL</span> PandaEskimo</div>
        <div class="psn"><span class="meta-label">PSN</span> PandaEskimo</div>
        <div class="wii"><span class="meta-label">Wii</span> PandaEskimo</div>
        <div class="steam"><span class="meta-label">Steam</span> PandaEskimo</div>
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
    
  </div>
  <?php //print render($content['links']) ?>
  
</ul>
</div>
