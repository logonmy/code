$(document).ready(function() {
    /*
   var $speech = $('div.speech'); 
   var defaultSize = $speech.css('fontSize');
   $('#switcher button').click(function() {
      var num = parseFloat($speech.css('fontSize')); 
      switch(this.id) {
        case 'switcher-large': 
            num *= 1.4;
            break;
        case 'switcher-small':
            num /= 1.4;
            break;
        default:
            num = parseFloat(defaultSize);
      }
      $speech.css('fontSize', num + 'px');
    });
   */
    
    /*
    //slideDown
    $('p').eq(1).hide();
    $('a.more').click(function() {
       $('p').eq(1).slideDown('slow'); 
       $(this).hide();
       return false;
    });
    */

    /*
    //fadeIn/fadeOut
    var $firstPara = $('p').eq(1);
    $firstPara.hide();
    $('a.more').click(function() {
       if($firstPara.is(':hidden')) {
          $firstPara.fadeIn('slow'); 
          $(this).text('read less');
        }else{
          $firstPara.fadeOut('slow');    
          $(this).text('read more');
        } 
        return false;
    });
    */

    //slideToggle
    /*
    var $firstPara = $('p').eq(1);
    $firstPara.hide();
    $('a.more').click(function() {
       $firstPara.slideToggle('fast'); 
        var $link = $(this);
       if($link.text() == 'read more') {
          $link.text() = 'read less'; 
       }else{
          $link.text() = 'read more'; 
       }
       return false;
    });
    */

    /*
    var $firstPara = $('p').eq(1);
    $firstPara.hide();
    $('a.more').click(function() {
       $firstPara.animate({height: 'toggle',
                           opacity: 'toggle',
                          }, 'slow'); 
       var $link = $(this);
       if($link.text() == 'read more') {
          $line.text('read less'); 
       }else{
        $line.text('read more'); 
       }
       return false;
    });
    */

    
});