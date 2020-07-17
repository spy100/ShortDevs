window.onload = function() {
  var selItem = sessionStorage.getItem("CreateInputSelect");  
  $('#inputselect').val(selItem);
}
$('#inputselect').change(function() { 
  var selVal = $(this).val();
  sessionStorage.setItem("CreateInputSelect", selVal);
 });


$(document).ready(function() {

  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
  
  $('.icon').click(function(event) {
      event.preventDefault();
      $('body').css('overflow', 'hidden');
      $('.icon').css('display', 'none');
      $('.closeicon').css('display', 'block');
      $('#overlay').css('display', 'block');
      $('#znav').addClass( "responsive" );
  });
  $('.closeicon').click(function(event) {
    $('body').css('overflow', 'auto');
    $('.icon').css('display', 'block');
    $('.closeicon').css('display', 'none');
    $('#overlay').css('display', 'none');
    $('#znav').removeClass( "responsive" );
  });

  $(".panelboxhideshow1" ).click(function(event) {     
     $('.pbox1').slideToggle();
  });
  $(".panelboxhideshow2" ).click(function(event) {     
     $('.pbox2').slideToggle();
  });
  $(".panelboxhideshow3" ).click(function(event) {     
     $('.pbox3').slideToggle();
  });
  $(".panelboxhideshow4" ).click(function(event) {     
     $('.pbox4').slideToggle();
  });


  setInterval(function() {
    var date = new Date();
    $('.ceas').html(
        date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds()
        );
  }, 500);


    $("#submitadd" ).click(function(event) {  
       var needed = $("#addpage").val();  
       if(needed.length == 0){
         $(".errormsgadd").text("Add page input must not be empty");
         event.preventDefault();
         return false;
       }
       
       if(/^[a-zA-Z0-9]+$/.test(needed) == false){
         $(".errormsgadd").text("Add page input must be letters and numbers only , no spaces");
         event.preventDefault();
         return false;
       }

    });


    $("#cipsubmit" ).click(function(event) {  
       if($('#inputselect').val().length == 0){
         $(".errormsgci").text("Create Input select must not be empty");
         event.preventDefault();
         return false;
       }

       var needed = $("#ciadd").val();  
       if(needed.length == 0){
         $(".errormsgci").text("Create input must not be empty");
         event.preventDefault();
         return false;
       }

       if(/^[a-zA-Z0-9]+$/.test(needed) == false){
         $(".errormsgci").text("Create input must be letters and numbers only , no spaces");
         event.preventDefault();
         return false;
       }

    });



    $("#delpagsubmit" ).click(function(event) {  
       if($('#delselect').val().length == 0){
         $(".errormsgdelpage").text("Delete Page select must not be empty");
         event.preventDefault();
         return false;
       }
    });


    $("#viewformsubmit" ).click(function(event) {  
       if($('#vformselect').val().length == 0){
         $(".errormsgvf").text("View form select must not be empty");
         event.preventDefault();
         return false;
       }
    });



     $("#addextsubmit" ).click(function(event) {  
       if($('#extformselect').val().length == 0){
         $(".errormsgext").text("Select Data Type must not be empty");
         event.preventDefault();
         return false;
       }

       var needed = $("#dlab").val();  
       if(needed.length == 0){
         $(".errormsgext").text("External Data Label input must not be empty");
         event.preventDefault();
         return false;
       }

       if(/^[a-zA-Z0-9]+$/.test(needed) == false){
         $(".errormsgext").text("External Data Label input must be letters and numbers only , no spaces");
         event.preventDefault();
         return false;
       }

       if($('#dupdate').val().length == 0){
         $(".errormsgext").text("Select Allow Data Update must not be empty");
         event.preventDefault();
         return false;
       }


       var needed2 = $("#durl").val();  
       if(needed2.length == 0){
         $(".errormsgext").text("Data URL input must not be empty");
         event.preventDefault();
         return false;
       }

    });


    $("#vextsbm" ).click(function(event) {  
       if($('#vext').val().length == 0){
         $(".errormsgvext").text("View external select must not be empty");
         event.preventDefault();
         return false;
       }
    });

    $("#dextsbm" ).click(function(event) {  
       if($('#dext').val().length == 0){
         $(".errormsgdext").text("Delete external select must not be empty");
         event.preventDefault();
         return false;
       }
    });

    

    $("#adspsubmit" ).click(function(event) {  
       var needed = $("#adsp").val();  
       if(needed.length == 0){
         $(".errormsgadsp").text("Add superpage input must not be empty");
         event.preventDefault();
         return false;
       }

       if(/^[a-zA-Z0-9]+$/.test(needed) == false){
         $(".errormsgadsp").text("Add superpage input must be letters and numbers only , no spaces");
         event.preventDefault();
         return false;
       }
    });


    $("#vspsbm" ).click(function(event) {  
       if($('#vsp').val().length == 0){
         $(".errormsgvsp").text("View SuperPage select must not be empty");
         event.preventDefault();
         return false;
       }
    });


    $("#sphsbm" ).click(function(event) {  
       if($('#sph').val().length == 0){
         $(".errormsgsph").text("Set SuperPage as Home select must not be empty");
         event.preventDefault();
         return false;
       }
    });

    $("#dspsbm" ).click(function(event) {  
       if($('#dsp').val().length == 0){
         $(".errormsgdsp").text("Delete SuperPage select must not be empty");
         event.preventDefault();
         return false;
       }
    });


    $("#chpsbm" ).click(function(event) {  
       var needed = $("#ochp").val();  
       if(needed.length == 0){
         $(".errormsgchp").text("Old password input must not be empty");
         event.preventDefault();
         return false;
       }
       var needed1 = $("#nchp").val();  
       if(needed1.length == 0){
         $(".errormsgchp").text("New password input must not be empty");
         event.preventDefault();
         return false;
       }
       var needed2 = $("#cchp").val();  
       if(needed2.length == 0){
         $(".errormsgchp").text("Confirm password input must not be empty");
         event.preventDefault();
         return false;
       }
       if(needed1 != needed2){
         $(".errormsgchp").text("New Password and Confirm Password do not match");
         event.preventDefault();
         return false;

       }

    });

    $("#eesbm" ).click(function(event) {  

      var needed1 = $("#eeid").val();  


      if(needed1.length == 0){
        $(".errormsgee").text("ID input must not be empty");
        event.preventDefault();
        return false;
      }

      var isnr;
      if(Math.floor(needed1) == needed1 && $.isNumeric(needed1)){
         var isnr = "yes";
      }
      if(isnr != "yes"){
        $(".errormsgee").text("Id input must be a int only");
        event.preventDefault();
        return false;
      }

      var needed = $("#eecol").val();  
      if(needed.length == 0){
        $(".errormsgee").text("Column input must not be empty");
        event.preventDefault();
        return false;
      }

      if(/^[a-zA-Z0-9]+$/.test(needed) == false){
        $(".errormsgee").text("Column input must be letters and numbers only , no spaces");
        event.preventDefault();
        return false;
      }

      var needed2 = $("#eeval").val();  
      if(needed2.length == 0){
        $(".errormsgee").text("Value input must not be empty");
        event.preventDefault();
        return false;
      }
      

   });


   $("#delentsmb" ).click(function(event) {  

    var needed1 = $("#delent").val(); 

    if(needed1.length == 0){
      $(".errormsgdelent").text("ID input must not be empty");
      event.preventDefault();
      return false;
    }

    var isnr1;
    if(Math.floor(needed1) == needed1 && $.isNumeric(needed1)){
       var isnr1 = "yes";
    }
    if(isnr1 != "yes"){
      $(".errormsgdelent").text("Id input must be a int only");
      event.preventDefault();
      return false;
    }

  });



  $("#cmdsbm").click(function(event) {  
    var needed3 = $("#cmder").val(); 
    if(needed3.length == 0){
      $(".cmderr").text("Command input must not be empty");
      event.preventDefault();
      return false;
    }
  });


  $("#adrsbm").click(function(event) {  
    var needed3 = $("#adr").val(); 
    if(needed3.length == 0){
      $(".adrerr").text("Add row input must not be empty");
      event.preventDefault();
      return false;
    }
  });



  $("#delrowsmb" ).click(function(event) {  

    var needed1 = $("#delrowid").val(); 
    if(needed1.length == 0){
      $(".errormsgdelrow").text("ID input must not be empty");
      event.preventDefault();
      return false;
    }

    var isnr1;
    if(Math.floor(needed1) == needed1 && $.isNumeric(needed1)){
       var isnr1 = "yes";
    }
    if(isnr1 != "yes"){
      $(".errormsgdelrow").text("Id input must be a int only");
      event.preventDefault();
      return false;
    }

  });



  $("#edrsbm" ).click(function(event) {  

    var needed1 = $("#edrid").val(); 
    if(needed1.length == 0){
      $(".errormsgedr").text("ID input must not be empty");
      event.preventDefault();
      return false;
    }

    var isnr1;
    if(Math.floor(needed1) == needed1 && $.isNumeric(needed1)){
       var isnr1 = "yes";
    }
    if(isnr1 != "yes"){
      $(".errormsgedr").text("Id input must be a int only");
      event.preventDefault();
      return false;
    }

    var needed2 = $("#edrval").val();  
    if(needed2.length == 0){
      $(".errormsgedr").text("Value input must not be empty");
      event.preventDefault();
      return false;
    }


  });








});