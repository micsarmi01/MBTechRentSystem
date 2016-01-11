
$(function () {
    /*-------------------- EXPANDABLE PANELS ----------------------*/
    var panelspeed = 500; //panel animate speed in milliseconds
    var totalpanels = 3; //total number of collapsible panels   
    var defaultopenpanel = 0; //leave 0 for no panel open   
    var accordian = false; //set panels to behave like an accordian, with one panel only ever open at once      

    var panelheight = new Array();
    var currentpanel = defaultopenpanel;
    var iconheight = parseInt($('.icon-close-open').css('height'));

    //Initialise collapsible panels
    function panelinit() {
        for (var i = 1; i <= totalpanels; i++) {
            panelheight[i] = parseInt($('#cp-' + i).find('.expandable-panel-content').css('height'));
            $('#cp-' + i).find('.expandable-panel-content').css('margin-top', -panelheight[i]);
            if (defaultopenpanel == i) {
                $('#cp-' + i).find('.icon-close-open').css('background-position', '0px -' + iconheight + 'px');
                $('#cp-' + i).find('.expandable-panel-content').css('margin-top', 0);
            }
        }
    }



    $('.expandable-panel-heading').click(function () {
        var obj = $(this).next();
        var objid = parseInt($(this).parent().attr('ID').substr(3, 2));
        currentpanel = objid;
        if (accordian == true) {
            resetpanels();
        }

        if (parseInt(obj.css('margin-top')) <= (panelheight[objid] * -1)) {
            obj.clearQueue();
            obj.stop();
            obj.prev().find('.icon-close-open').css('background-position', '0px -' + iconheight + 'px');
            obj.animate({
                'margin-top': 0
            }, panelspeed);
        } else {
            obj.clearQueue();
            obj.stop();
            obj.prev().find('.icon-close-open').css('background-position', '0px 0px');
            obj.animate({
                'margin-top': (panelheight[objid] * -1)
            }, panelspeed);
        }
    });

    function resetpanels() {
        for (var i = 1; i <= totalpanels; i++) {
            if (currentpanel != i) {
                $('#cp-' + i).find('.icon-close-open').css('background-position', '0px 0px');
                $('#cp-' + i).find('.expandable-panel-content').animate({
                    'margin-top': -panelheight[i]
                }, panelspeed);
            }
        }
    }
    
   // run once window has loaded    
   panelinit();

});// JavaScript Document


<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<div id="container">
    <div class="expandable-panel" id="cp-1">
        <div class="expandable-panel-heading">
            <h2>Content heading 1<span class="icon-close-open"></span></h2>
         </div>
        <div class="expandable-panel-content">
            <p>First Panel HTML...</p>
        </div>
    </div>
     
    <div class="expandable-panel" id="cp-2">
        <div class="expandable-panel-heading">
            <h2>Content heading 2<span class="icon-close-open"></span></h2>
         </div>
        <div class="expandable-panel-content">
            <p>Second Panel HTML...</p>
             
        </div>
  </div>
     
  <div class="expandable-panel" id="cp-3">
     <div class="expandable-panel-heading">
         <h2>Content heading 3<span class="icon-close-open"></span></h2>
     </div>
     <div class="expandable-panel-content">
         <p>Third Panel HTML...</p>
     </div>
  </div> 
</div>








<!-- Post Info -->
<div style='position:fixed;bottom:0;left:0;    
            background:lightgray;width:100%;'>
    Code Sample Taken From: <a href='http://www.webdevdoor.com/jquery/expandable-collapsible-panels-jquery/'>Web Dev Door</a>
<div>
</body>
</html>
