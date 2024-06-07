window.onload = function(){
    $("input#toggle").on("click",function(){
        $("body").toggleClass('hamburgured');
    })
    $(document).on("click",function(event){
        if(!$(event.target).closest("div.hamburgur-menu").length){
            $("body").removeClass('hamburgured');
            $("input#toggle").prop('checked',false);
            console.log('clicked');
        }
    })
}