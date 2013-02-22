// Wrap everything in a private function. Drupal 7 standard.
(function ($) {

  // on document ready
  $(document).ready(function(){

    // this function replaces the CSS Hover with an 'active' class that is toggled.
    // for non-touch devices, this emulates the hover state
    // for touch devices, this emulates iOS emulation of hover. This means a single tap triggers the 'active' state, and a second tap triggers a 'click'.
    // on touch devices, clicking off of the target does NOT remove the 'active' state, only clicking on another member of the group
    $.fn.touchHover = function () {
      elements = this;

      // touch devices
      $(elements, 'html.touch').click(function(e){
        if (!($(this).hasClass('active'))) {
          e.preventDefault();
          $(elements).removeClass('active');
          $(this).addClass('active');
        }
        else {
          $(this).removeClass('active');
        }
      });

      // non touch devices
      $(elements, 'html:not(touch)').hover(
        function(){
          $(this).addClass('active');
        },function(){
          $(this).removeClass('active');
      });

      return elements;
    }

    // check version of ie 
    // ----------------------------------------------------------
    // A short snippet for detecting versions of IE in JavaScript
    // without resorting to user-agent sniffing
    // ----------------------------------------------------------
    // If you're not in IE (or IE version is less than 5) then:
    //     ie === undefined
    // If you're in IE (>=5) then you can determine which version:
    //     ie === 7; // IE7
    // Thus, to detect IE:
    //     if (ie) {}
    // And to detect the version:
    //     ie === 6 // IE6
    //     ie > 7 // IE8, IE9 ...
    //     ie < 9 // Anything less than IE9
    // ----------------------------------------------------------

    // UPDATE: Now using Live NodeList idea from @jdalton

    var ie = (function(){
        var undef,
            v = 3,
            div = document.createElement('div'),
            all = div.getElementsByTagName('i');
        while (
            div.innerHTML = '<!--[if gt IE ' + (++v) + ']><i></i><![endif]-->',
            all[0]
        );
        return v > 4 ? v : undef;
    }());

    // give body a 'js' class and remove class 'no-js'
    $('body').addClass('js').removeClass('no-js');


    // prevent console.log() from throwing an error
    if (!window.console) console = {log: function() {}};

    //fancybox modals
    $('.use-modal').fancybox({
      closeClick	: false,
      openEffect	: 'none',
      closeEffect	: 'none',
      nextEffect  : 'none',
      prevEffect  : 'none',
      margin : [0,0,0,0],
      padding : [0,0,0,0],
      helpers : {
        overlay : {opacity: 0.5},
        title : {
          type : 'inside',
          position : 'bottom'
        },
        media : {}
      }
    });

    //Log in behavior with callback.

    $('#block-user-login h3').wrap('<a href="#user-login-form" class="user-login-modal" data-fancybox-title="log in">');

    $('.user-login-modal').fancybox({
      closeClick  : false,
      openEffect  : 'none',
      closeEffect : 'none',
      nextEffect  : 'none',
      prevEffect  : 'none',
      margin : [0,0,0,0],
      padding : [0,0,0,0],
      helpers : {
        overlay : {opacity: 0.5},
        title : {
          type : 'inside',
          position : 'bottom'
        },
        media : {}
      },
      afterShow : function(){$('#edit-name').focus();}
    });

    

    if(!(ie) || (ie >= 8)){
      // Add styling to form elements
      $('input:text, textarea, input[type=password], input[type=email], input[type=search]').wrap('<div class="text-wrap">');

      // Apply class to focused input fields
      $('*').focus(function(){
        $('.text-wrap').removeClass('focused');
        if ($(this).is('input:text, textarea, input[type=password], input[type=email], input[type=search]')){
          $(this).parent('.text-wrap').addClass('focused');
        }
      });
    }

    // IE7 Inline Block Fix
    $('*')
      .filter(function(index) {
        return $(this).css('display') === 'inline-block';
      })
      .addClass('inline-block');

    // pandaMark checkbox / radio
    $('input[type="checkbox"], input[type="radio"]').pandaMark();

    //replace labels with placeholders
    //need to add modernizr check for this
    $('label').each(function(){
      var $e = $(this);

      var label = $e.html().replace(/<span.*<\/span>/g, '');
      var $inputField = $('#' + $e.attr('for'));

      $inputField.attr('placeholder', label);

      // hide text input fields when there is a placeholder for them and the fields are empty (the placeholder will be visible)

      if ($inputField.is('input[type=text],textarea, input[type=search], input[type=password], input[type=email]') && ($inputField.val() === '')){
        $e.addClass('hide');
      }

    });

    // make labels into tooltips
     
    /*
    $('label').each(function(){
      var $e = $(this);

      // skip over checkbox / radio labels
      if (($e.parents('.form-type-checkbox').length >= 1) || ($e.parents('.form-type-radio') >= 1)) {return;}

      $('#' + $e.attr('for')).parents('.form-item').hover(function(){
        $e.addClass('active');
      },
      function(){
        $e.removeClass('active');
      });

    });
    */

    //user login
    //$('.region-content-navigation #block-user-login h3').click(function(){
    //  $('.region-content-navigation #block-user-login').toggleClass('active');
    //})

    // social links
     
    $('.social-links .social-icon').click(function(){
      $('.easy_social_box').responsive_toggle();
    });

    // create a touch / hover action using the custom function
    $('.icon').touchHover();


    //temporarily set featured block colors randomly
    var color_highlights = ['red', 'blue', 'green', 'orange', 'purple', 'brown'];

    $('.featured-block').each(function(){
      $(this).addClass('color-' + color_highlights[Math.floor(Math.random() * color_highlights.length)]);
    });


  });//end of document ready

})(jQuery_current);
 
  