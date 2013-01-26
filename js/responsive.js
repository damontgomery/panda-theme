// Wrap everything in a private function. Drupal 7 standard.
(function ($) {
  // on document ready
  $(document).ready(function(){
    //replacement for toggle function to remove "element style if hidding"
    $.fn.responsive_toggle = function () {
      if (this.css('display') === 'block'){this.css({'display' : ''});}
      else {this.css({'display' : 'block'});}
    }

    // Mini Menu (Responsive)
    $('.mm-main-menu').click(function(){
      $(this).toggleClass('active');
      $('.region-navigation').responsive_toggle();
    });
    
    $('.mm-sub-menu').click(function(){
      $(this).toggleClass('active');
      $('.responsive-mobile .block-menu-block').responsive_toggle();
    });

    // Footer Menu
    $('.region-footer h3').click(function(){
      $(this).toggleClass('active');
      $(this).parent().parent().find('ul.menu').responsive_toggle();
    });
    
    $('.region-footer h3').first().addClass('first');
    $('.region-footer h3').last().addClass('last');

    // add hover effects for main menu and sub menu
    $('li.expanded').not('.active-trail').hoverIntent({
    //$('.responsive-full li.expanded, .region-navigation li.expanded').hoverIntent({
      over: function(){
        //do not run on the main menu when on a phone
        if ($(window).width() <= 480 && $(this).is('.menu-name-main-menu li.expanded')){return;}

        $(this).children('ul').slideDown('fast');
        $(this).addClass('active');
      },
      out: function(){
        //do not collapse when on a phone
        if ($(window).width() <= 480){return;}

        $(this).children('ul').slideUp('slow');
        $(this).removeClass('active');
      },
      timeout: 500
    });

    // Handle Z-index more immediately
    $('li.expanded').not('.active-trail').hover(
      function(){
        //do not run on the main menu when on a phone
        if ($(window).width() <= 480 && $(this).is('.menu-name-main-menu li.expanded')){return;}

        $(this).children('ul').css({'z-index' : 1});
      },
      function(){
        //do not collapse when on a phone
        if ($(window).width() <= 480){return;}

        $(this).children('ul').css({'z-index' : ''});
      }
    );
    
    // Scroll to top on load
    window.scrollTo(0, 1);
    
    // Panel Menu
    $('.navbar').click(function(){
      $('body').toggleClass('js-nav');
    });


  });//end of document ready

  $(window).load(function(){
  /*Responsive hacks*/

    /*Set all selected elements to the same height*/
    resp_max_height = function(elements){
      var max_height = 0;

      //clear height before measuring
      elements.css({'height': ''});

      //measure
      elements.each(function(){
        max_height = Math.max(max_height, $(this).height());
      });

      //set
      elements.height(max_height);
    }
    
    /*Set the grid blocks to the same height*/
    resp_max_height($('.grid-block > .content'));
    $(window).resize(function(){
      resp_max_height($('.grid-block > .content'));
    });
    
    resp_max_height($('.grid-block-wide > .content'));
    $(window).resize(function(){
      resp_max_height($('.grid-block-wide > .content'));
    });

    /*Menu Resizing*/
    resize_main_menu = function(){
      var main_menu = $('.menu-name-main-menu');
      var level_1_links = $('.region-navigation li.depth-1').children('a');
      var all_links = $('a', main_menu);
      
      //reset font size
      all_links.css({'font-size' : '' });

      //check if mobile phone (don't resize)
      if ($(window).width() <= 480){return;}

      menu_fits = false;
      
      var total_space, total_width, font_size, new_font_size;
      
      while (menu_fits === false){
        total_space = main_menu.width();
        total_width = 0;
        font_size = parseFloat(level_1_links.eq(0).css('fontSize'),10);

        level_1_links.each(function(){
          total_width += $(this).outerWidth();
        });

        if (total_width <= total_space){menu_fits = true;}
        else {
          new_font_size = font_size - 1;
          if (new_font_size <= 0){new_font_size = 2; menu_fits = true;}
          all_links.css({'font-size' : new_font_size + 'px'});
        }

      }
    }
    
    resize_main_menu();
    $(window).resize(resize_main_menu);
    
  }); //end of window load
  
}(jQuery_current));
