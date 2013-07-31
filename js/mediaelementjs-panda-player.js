// This is a custom player for mediaelementjs to allow for a simpler theme. The functionality is a little limited, but that should be OK for now and can be expanded.

;(function ($) {
  // on document ready
  $(document).ready(function(){

    $('audio').each(function(){
      var player = new MediaElement(this);
      var controls = $(this).parent();
        
      var play_button = $('.play', controls, controls);
      var pause_button = $('.pause', controls);
      
      var time = {
        container : $('.time-container', controls),
        stamp : {
          current : $('.timestamps .current', controls),
          total : $('.timestamps .total', controls),
        },
        progress : {
          track : $('.progress-track', controls),
          bar : $('.progress-bar', controls),
        },
      };

      var mute_button = $('.mute', controls);

      var volume = {
        container : $('.volume-container', controls),
        track : $('.volume-track', controls),
        bar : $('.volume-bar', controls),
      };
      
      // Do some initialization once the file can be played
      player.addEventListener('canplay', function(){
        // add the duration
        time.stamp.total.html(player.duration.toString().toHHMMSS());
          
        // add the time slider interaction
        time.progress.track.click(function(e){
          var x = e.pageX - time.progress.track.offset().left;
          var percent = x / time.progress.track.width();
          player.setCurrentTime(percent * player.duration);
        });        
      })
      
      // Time Interaction  
      play_button.click(function(){
        player.play();
        play_button.removeClass('show');
        pause_button.addClass('show');
      });
        
      pause_button.click(function(){
        player.pause();
        play_button.addClass('show');
        pause_button.removeClass('show');
      });
      
      // Update the time progress bar
      player.addEventListener('timeupdate', function(e){
        time.stamp.current.html(player.currentTime.toString().toHHMMSS());
        time.progress.bar.width(((player.currentTime / player.duration) * 100) + '%');
      });

      // Update the Play icon when the file is finished
      player.addEventListener('ended', function(e){
        play_button.addClass('show');
        pause_button.removeClass('show');
      });

      //See above for Time Slider Interaction
      
      // Volume Interaction
      mute_button.click(function(){
        player.setMuted(!(player.muted));
        mute_button.toggleClass('show');
        player.setVolume(player.volume);
      });
      
      // Update the Volume Bar
      // Add an update function
      player.addEventListener('volumechange', function(e){
        if (player.muted) {
          if (volume.container.hasClass('vertical')){
            volume.bar.height(0);
          }
          else {
            volume.bar.width(0);  
          }
        }
        else {
          if (volume.container.hasClass('vertical')){
            volume.bar.height((player.volume * 100) + '%');
          }
          else {
            volume.bar.width((player.volume * 100) + '%');
          }
        }
      });
      
      // Slider for volume
      volume.track.click(function(e){
        if (volume.container.hasClass('vertical')){
          var y = e.pageY - volume.track.offset().top;
          var percent = 1 - (y / volume.track.height());
        }
        else {
          var x = e.pageX - volume.track.offset().left;
          var percent = x / volume.track.width();
        }
        player.setMuted(false);
        mute_button.addClass('show');
        player.setVolume(percent);
      });
    });

    // Process Timestamps
    String.prototype.toHHMMSS = function () {
        var sec_num = parseInt(this, 10);
        var hours   = Math.floor(sec_num / 3600);
        var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
        var seconds = sec_num - (hours * 3600) - (minutes * 60);

        if ((hours != 0) && (minutes < 10)) {minutes = "0"+minutes;}
        if (seconds < 10) {seconds = "0"+seconds;}
        
        if (hours != 0){return hours+':'+minutes+':'+seconds;}
        else {return minutes + ':' + seconds;}
    }

  }); //end of document ready
}(jQuery_current));
