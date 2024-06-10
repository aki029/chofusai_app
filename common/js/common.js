window.onload = function(){
    $("input#toggle").prop('checked',false);
    $("input#toggle").on("click",function(){
        $("body").toggleClass('hamburgured');
        document.addEventListener('touchmove',hamburgured,{passive:false});
        document.addEventListener('wheel',hamburgured,{passive:false});
        $('body.hamburgured > *:not(header)').on('click',hamburgured);
    })
    $(document).on("click",function(event){
        if(!$(event.target).closest("div.hamburgur-menu").length){
            $("body").removeClass('hamburgured');
            $("input#toggle").prop('checked',false);
            document.removeEventListener('touchmove',hamburgured);
            document.removeEventListener('wheel',hamburgured);
            $('body.humburgured > *:not(header)').off('click',hamburgured);
        }
    })
}

function hamburgured(e){
    e.preventDefault();
}