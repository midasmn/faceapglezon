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
    
    // SEOインプット
    shepherd.addStep('seoup', {
      text: ['Webページのタグを調べたいサイトのURLを入力してチェックボタンを押します。'],
      attachTo: '.seoup bottom',
      classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
      buttons: [
        {
          text: '閉じる',
          classes: 'shepherd-button-secondary',
          action: shepherd.cancel
        }
        // , {
        //   text: '次へ',
        //   action: shepherd.next,
        //   classes: 'shepherd-button-example-primary'
        // }
      ]
    });
    // 
    return shepherd.start();
  };

  $(init);

}).call(this);