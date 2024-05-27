$("input[type='radio']").on("click", function(event) {
    var id = event.target.getAttribute("id");
    var target = "div.ShowList > div." + id;
    $(target).css("display", "block");
    var reserve = "div.ShowList > :not("+target+")";
    $(reserve).css("display", "none");
});