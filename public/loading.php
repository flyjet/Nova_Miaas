<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="http://malsup.github.io/jquery.blockUI.js"></script>

<script> 

   // unblock when ajax activity stops 
    $(document).ajaxStop($.unblockUI); 
    $(document).ready(function() { 
        $('#loading').click(function() { 
            $.blockUI({ message: $('#waitMessage') }); 
           // test(); 
        }); 
    }); 
</script> 
<script> 

   // unblock when ajax activity stops 
    $(document).ajaxStop($.unblockUI); 
    $(document).ready(function() { 
        $('#loading2').click(function() { 
            $.blockUI({ message: $('#waitMessage') }); 
           // test(); 
        }); 
    }); 
</script> 
<div id="waitMessage" style="display:none; ">    
    <h3>Processing...</h3>
    <img id="myimg" src="image/loading4.gif"  id="loading-indicator" style="margin-left:1em; " />
</div>  
