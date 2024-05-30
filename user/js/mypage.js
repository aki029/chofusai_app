SwitchState();
$('input[name="check"]').change(function(){
    SwitchState();
})
function SwitchState(){
    var id = $('input[name="check"]:checked').attr('id');
    var target = "div.ShowList > div." + id;
    $(target).toggleClass('showing');
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