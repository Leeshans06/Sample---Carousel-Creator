$(function() {
 // Color picker
 $('.demo2').colorpicker({
  format: 'hex'
 });
 $('#cp3').colorpicker();
  // Get Current Image Count
  /*var image_count      = $('#image_count').val();
  var max              = 5;
  var limit            = max - image_count;*/

  Dropzone.options.carouselDropzone = {

    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 1,
    maxFiles: 1,
    acceptedFiles: ".jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF",
    addRemoveLinks: false,
    dictDefaultMessage: "Drop A File Here To Upload",
    // The setting up of the dropzone
    //
    init: function() {
      var myDropzone = this;
      this.on("addedfile", function(file) {
          $.ajax({
                    url: '/admin/carouselEditor/create-slide',
                    method: 'post',
                    data: {
                           id:$('#slide_id').val()
                          },
                    success: function(data){
                       //Set Slide ID
                        document.getElementById('slide_id').value = data;
                        var process = myDropzone.processQueue();
                        // Reload Slide Profile
                        setTimeout(function(){document.location = '/admin/carouselEditor/add-slide/' + data;}, 3000);

                    },
                    error: function(){},
           });
         });
      }
    }
  });

var revapi;
jQuery(document).ready(function() {
  revapi = jQuery('.tp-banner').revolution(
            {
              delay:5000,
              startwidth:600,
              startheight:300,
              touchenabled:"on",
              onHoverStop:"on",
              shadow:5,
              fullWidth:"off",
              fullScreen:"off",
              autoHeight:"off",
              forceFullWidth:"off"
            });
});

  /******************************
    - TIMER CHANGER -
  ********************************/

  jQuery('#dectime').click(function() {
    var mrtime = jQuery('#mrtime');
    var curtime = mrtime.data('val');
    curtime=curtime-100;
    if (curtime<300) curtime=300;
    mrtime.data('val',curtime);
    mrtime.text('Time: '+curtime/1000+"s");

    //callChanger();
  })

  jQuery('#inctime').click(function() {
    var mrtime = jQuery('#mrtime');
    var curtime = mrtime.data('val');
    curtime=curtime+100;
    mrtime.data('val',curtime);
    mrtime.text('Time: '+curtime/1000+"s");

    //callChanger();
  })


  /******************************
    - SLOT CHANGER  -
  ********************************/
  jQuery('#decslot').click(function() {
    var mrslot = jQuery('#mrslot');
    var slot = mrslot.data('val');
    slot=slot-1;
    if (slot<1) slot=1;
    mrslot.data('val',slot);
    mrslot.text('Slots: '+slot);

/*    // Update Carousel
     updateCarousel();*/
  });

  jQuery('#incslot').click(function() {
    var mrslot = jQuery('#mrslot');
    var slot = mrslot.data('val');
    slot=slot+1;
    if (slot>20) slot=20;
    mrslot.data('val',slot);
    mrslot.text('Slots: '+slot);

   /* // Update Carousel
    updateCarousel();*/

  });

      $('.selectpicker').selectpicker();
  // THE TRANSITION SELECTOR

  jQuery('#transitselector').click(function() {
    var ts = jQuery('.transition-selectbox-holder');
    if (!ts.hasClass("opened")) {
     TweenLite.fromTo(ts,0.2,{opacity:0,transformOrigin:"center bottom", transformPerspective:400, y:-50,rotationX:0,z:0},{opacity:1,y:0,rotationX:0,ease:Power3.easeOut})
      ts.css({display:'block'});
      setTimeout(function() {
       // naviapi.reinitialise();
      },100)
      ts.addClass("opened");
    }
    else{
        var ts = jQuery('.transition-selectbox-holder');
        TweenLite.to(ts,0.2,{opacity:0,transformOrigin:"center bottom", transformPerspective:400, y:-50,rotationX:0,z:0,ease:Power3.easeOut});
        ts.removeClass("opened");
    }
  })

  jQuery('body').on('mouseleave','.transition-selectbox-holder.opened',function() {

        var ts = jQuery('.transition-selectbox-holder');
        TweenLite.to(ts,0.2,{opacity:0,transformOrigin:"center bottom", transformPerspective:400, y:-50,rotationX:0,z:0,ease:Power3.easeOut});
        ts.removeClass("opened");
    });


  jQuery('.transition-selectbox li').each(function() {
    var li = jQuery(this);
    li.click(function() {
      var li = jQuery(this);
      var anim = li.data('anim');

      jQuery('#mranim').text(li.text());
      jQuery('#mranim').data('val',anim);

      document.getElementById('transitselector').value = $('#mranim').data('val');
      //var selector = jQuery('#transitselector');
      document.getElementById('transname').value = $('#mranim').text();
    })
  })

  function  updateCarousel(){
     var slide_id   = $('#slide_id').val();
     var transition = $('#transitselector').val();
     var slots      = $('#mrslot').data('val');
     var speed      = $('#mrtime').data('val');
     var bg_color   = $("#carousel_bgcolor").val();
     var bg_fit     = $("#carousel_bgfit").val();
     var transname  = $('#transname').val();
     var bg_repeat  = 'no-repeat';

     if(bg_fit     == 'containr'){
        bg_repeat   = "repeat";
        bg_fit      = 'contain';
     }

     // Dimensions of pic
     $.ajax({
                  url: '/admin/carouselEditor/carousel-html',
                  method: 'post',
                  data: {
                          slide_id:slide_id,
                          transition:transition,
                          slots:slots,
                          speed:speed,
                          bg_color:bg_color,
                          transname:transname,
                          bg_fit:bg_fit,
                          bg_repeat:bg_repeat
                  },
                  success: function(data){
                     $("#carousel_div").html('');
                     $("#carousel_div").html(data);
                     revapi = jQuery('.tp-banner').revolution(
                                {

                                  startwidth:600,
                                  startheight:300,
                                  touchenabled:"on",
                                  onHoverStop:"on",
                                  shadow:5,
                                  fullWidth:"off",
                                  fullScreen:"off",
                                  autoHeight:"off",
                                  forceFullWidth:"off"
                                });
                  },
                  error: function(){},
         });
  }

  function saveSlideSettings(){
     var slide_id   = $('#slide_id').val();
     var transition = $('#mranim').data('val');
     var slots      = $('#mrslot').data('val');
     var speed      = $('#mrtime').data('val');
     var bg_color   = $("#carousel_bgcolor").val();
     var transname  = $('#transname').val();
     var bg_fit     = $("#carousel_bgfit").val();
     var bg_repeat  = 'no-repeat';

     if(bg_fit     == 'containr'){
        bg_repeat   = "repeat";
        bg_fit      = 'contain';
     }
     $.ajax({
                  url: '/admin/carouselEditor/slide-update',
                  method: 'post',
                  data: {
                          slide_id:slide_id,
                          transition:transition,
                          slots:slots,
                          speed:speed,
                          bg_color:bg_color,
                          transname:transname,
                          bg_fit:bg_fit,
                          bg_repeat:bg_repeat
                  },
                  success: function(data){
                    setTimeout(function(){document.location = '/admin/carouselEditor/add-slide/' + slide_id;}, 1000);
                  },
                  error: function(){},
         });
  }
  function confirm_delete(slide){
          document.getElementById('remove_slide_id').value = slide;
          $('#remove_slide').modal('show');
  }
  function delete_slide(){
       var slide_id     = $("#remove_slide_id").val();

       $.ajax({
                  url: '/admin/carouselEditor/slide-delete',
                  method: 'post',
                  data: {
                          slide_id:slide_id
                  },
                  success: function(data){ //alert(data);return false;
                    document.location = '/admin/carouselEditor';
                  },
                  error: function(){},
         });
  }
