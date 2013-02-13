// Wrap everything in a private function. Drupal 7 standard.
(function ($) {

  // on document ready
  $(document).ready(function(){

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

      $e.next('.text-wrap').children('input')
        .attr('placeholder', label);

    });

    //user login
    //$('.region-content-navigation #block-user-login h3').click(function(){
    //  $('.region-content-navigation #block-user-login').toggleClass('active');
    //})

    // social links
     
    $('.social-links .social-icon').click(function(){
      $('.easy_social_box').responsive_toggle();
    });


    //Temporary styling things for comps
    


  });//end of document ready

})(jQuery_current);
 
  