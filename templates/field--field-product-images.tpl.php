<?php

//print render($items[0]);

foreach ($items as $i => $image){
  $url = image_style_url('square-medium', $image['#file']->uri);
  
  if ($i === 0){
    
    print '<img class="product-image" src="' . $url . '" alt="">';
  }
  
  else {  
    
    $thumb_url = image_style_url('square-100-thumb', $image['#file']->uri);

    print '<a class="use-modal product-thumbnail" data-fancybox-type="image" href="' . $url . '"><img class="product-image" src="' . $thumb_url . '" alt=""></a>';
  }
}
