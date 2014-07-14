$(document).ready(folder);
function folder(){
    var urls = $('body').attr('id');
$.ajaxSetup({
    type: 'POST',
    url: '/'+ urls +'/ajax',
    timeout:30000
}); 
}

$(document).ready(item_local);
function item_local()
{ 
       $('#tooltips tr td').mousemove(function(event){
        var id = $(this).attr('rel');
        var has = $('#toltip #' + id).hasClass('item');
        var toltip = $('#toltip').hasClass("tool");
        
        var Y = event.pageY - 70;
        var X = event.pageX + 20;
        var winY = $('body').height();
        var winX = $('body').width();
        var boxY = $('#toltip #' + id + '.item').height();
        var boxX = $('#toltip #' + id + '.item').width();
        
        if (toltip === false) {
            $('body').prepend('<div id="toltip" class="tool"></div>');
        }
        if (id != null) {  
            if (has === false) {
                $('#toltip').prepend('<div id="' + id + '" class="item"></div>');
                  item(id);
                $('#toltip #' + id + '.item').animate({'top': Y ,  'left': X},1); 
                if(Y + boxY >= winY){
                       $('#toltip #' + id + '.item').css({'top': winY - boxY,  'left': X});
                }
                if(X + boxX >= winX){
                       $('#toltip #' + id + '.item').css({'top': Y,  'left': winX - boxX});
                }

            } else {
                $('#toltip #' + id).animate({'top': Y ,'left': X},1);
                if(Y + boxY >= winY){
                       $('#toltip #' + id + '.item').css({'top': winY - boxY,  'left': X});
                }
                if(X + boxX >= winX){
                       $('#toltip #' + id + '.item').css({'top': Y,  'left': winX - boxX});
                }
                $('#toltip #' + id).show();
            }
        }
  });
     $('#tooltips tr td').mouseout(function(){
         var id = $(this).attr('rel');
        $('#toltip #' + id).hide();
  }); 
}

function item(id){
    $.ajax({
        data: {
            ajax: id,
            tooltip: true
        },
        beforeSend: function(){
            $('#toltip #' + id + '.item').prepend('<div class="load"></div>');
        },
        error:function(data){
            $('#toltip #' + id + '.load').hide();          
        },
        success: function(data){
            AjaxSuccess(data,id);
        }
    });
}
    
function AjaxSuccess(data,id)
{   
    $('#toltip #' + id + ' .load').hide(); 
    $('#toltip #' + id + '.item').prepend(data);
}


