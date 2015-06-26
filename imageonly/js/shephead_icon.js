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
    shepherd.addStep('sh_iconup', {
      text: '<i class="glyphicon glyphicon-folder-open "></i>  をクリックして、310x310ピクセル以上の画像をアップロードします',
      attachTo: '.sh_iconup bottom',
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