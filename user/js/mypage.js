SwitchState();
display_data();
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
    target = target.replace(' showing','');
    var url = '../../apply/'+target;
    var agree = confirm('対象の申請ページに遷移します');
    if(agree)window.location.href = url;
});

$("select#year").change(function(){display_data(this)});


$('button#applydata').on('click',function(event){
    var target = $("div.ShowList > div.showing");
    var classname = target.attr("class");
    classname = classname.replace(' showing','');
    var year = $('select#year').val();

    if(confirm('この年度のデータを今年のデータとして登録します。')){
        $.ajax({
            type:'POST',
            url:'./apply.php',
            data:{
                'kind':classname,
                'year':year,
            },
            success:function(content){
                console.log(content)
                url = '../../apply/'+classname+"/";
                $.ajax({
                    type:'POST',
                    url:url,
                    data:{
                        'btn_submit':'yes',
                    },
                    success:function(contents){
                        console.log(contents)
                        alert('登録に成功しました');
                    }
                })
            }
        })
    }
})

function display_data(e){
    var year = $(e).val();
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
}