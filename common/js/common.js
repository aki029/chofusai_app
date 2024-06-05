window.onload = function(){
    $("input#toggle").on("click",function(){
        $("html").toggleClass('hamburgered');
    })
    $(document).on("click",function(event){
        if(!$(event.target).closest("div.hamburgur-menu").length){
            $("html").removeClass('hamburgered');
            $("input#toggle").prop('checked',false);
            console.log('clicked');
        }
    })
}