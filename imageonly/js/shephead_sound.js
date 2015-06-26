(function() {
  var init, setupShepherd;
  init = function() {
    return setupShepherd();
  };
  setupShepherd = function() {
    var shepherd;
    shepherd = new Shepherd.Tour({
      defaults: {
        classes: 'shepherd-element shepherd-open shepherd-theme-arrows',
        showCancelLink: true
      }
    });
    shepherd.addStep('sh_sound', {
      text: '<i class="glyphicon glyphicon-folder-open "></i>  をクリックして、音声入り動画(mp4,mov,flv,mpeg)をアップロードします。',
      attachTo: '.sh_sound bottom',
      classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
      buttons: [
        {
          text: '閉じる',
          classes: 'shepherd-button-secondary',
          action: shepherd.cancel
        }
      ]
    });
    // 
    // 
    return shepherd.start();
  };
  $(init);
}).call(this);