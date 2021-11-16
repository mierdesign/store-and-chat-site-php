$('.tab').click(function(e) {
    console.log($(this).index());
    if ( $(this).index() == 1 
        || $(this).index() == 2 
        || $(this).index() == 3 ) {
      tabItemClick($(this).index());
    }
    e.preventDefault();
  });
  
  // if what you tapped is already active, close it
  // and set grid display to none
  
  function tabItemClick(i) {
    if ($('.tab').eq(i).hasClass('active')) {
      $('.overlay').removeClass('overlay-active'); 
      $('.tab').eq(i).removeClass('active');
      // display changes happen immediately
      // by executing the remove class 0.25s after the tab is
      // clicked, we can delay it and keep the transition
      setTimeout(function () {
        // had to add i-1 because grid0 is technically "shop"
        $('.grid').eq(i-1).removeClass('grid-active');
      }, 500);
    } else {
      $('.overlay').addClass('overlay-active');  
      $('.grid').eq(i-1).addClass('grid-active').siblings().removeClass('grid-active');
      $('.tab').eq(i).addClass('active').siblings().removeClass('active');
    }
  }
  
  // need to test performance of this
  $(document).click(function(event) { 
    //make sure .tab and .overlay are not ancestors of the target of the clicked element by using .closest() and .is().
  
  //If not ancestors, then the clicked element is outside of .tab
  // hide overlay
    if ( !$(event.target).closest('.tab').length &&
       !$(event.target).is('.tab') && 
       !$(event.target).closest('.overlay').length &&
       !$(event.target).is('.overlay') ) {
      
      if ($('.overlay').hasClass('overlay-active')) {
     $('.overlay').removeClass('overlay-active');
        $('.tab').removeClass('active');
      }
    }        
  });
  
  
  
  //$('.tab').click(function(e) {
    
  //   if ($(this).hasClass('active')) {
  //     $(this).removeClass('active');
  //     $('.overlay').removeClass('overlay-active'); 
  //   } else {
  //     $(this).addClass('active').siblings().removeClass('active');
  //   //figure out how to load in new content based on specific tab
  //     $('.overlay').addClass('overlay-active');
  //   }