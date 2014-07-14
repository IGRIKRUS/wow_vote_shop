$(document).ready(process);
function process(){
    var end = $('#install').attr('rel');
    $('.progress-bar').css("width", end + "%").append(load_int('.progress-bar',end,70));
    
}

function load_int(cls,tmr,lod){
    $(cls).each(function(){
        var ints = tmr;
		
        var on = 0;
        var timer = setInterval(function(){
            if(on>=ints) {
                clearInterval(timer);
                $(cls).text(ints + "% Complete");
            } else {
                $(cls).text(on + "% Complete");
                on++;
                on+=1;
            }
        },lod)
    }); 
}
