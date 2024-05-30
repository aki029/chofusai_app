SwitchState();
$('input[name="check"]').change(function(){
    SwitchState();
})
function SwitchState(){
    var id = $('input[name="check"]:checked').attr('id');
    var target = "div.ShowList > div." + id;
    $(target).addClass('showing');
    var reserve = "div.ShowList > :not("+target+")";
    $(reserve).removeClass('showing');
}

$('button#editdata').on('click',function(){
    var target = $('div.showing').attr('class');
    target = target.replace('showing','');
    var url = '../../apply/'+target;
    var agree = confirm('対象の申請ページに遷移します');
    if(agree)window.location.href = url;
});

$("select#year").change(function(){
    var year = $(this).val();
    var target = $("div.ShowList > div.showing");
    var classname = target.attr("class");
    classname = classname.replace('showing','');
    $.ajax({
        type: "POST",
        url:"./index.php",
        data:{"year":year},
        success:function(content){
            var parser = new DOMParser();
            var doc = parser.parseFromString(content, "text/html");
            var result = doc.getElementsByClassName(classname)[0];
            target.html(result.innerHTML);
        }
    })
})