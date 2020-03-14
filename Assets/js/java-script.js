$(document).ready(function(){
let lien=$('li');
   lien.click(function()
    {
        if(lien.hasClass('active')){
            lien.removeClass('active');
        } 
        $(this).addClass('active');
    });
    
});




