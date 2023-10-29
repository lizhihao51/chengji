var city = {
    0: ["请选择"],
    1: ["1班", "2班", "3班", "4班", "5班", "6班", "7班", "8班", "9班", "10班"],
    2: ["1班", "2班", "3班", "4班", "5班", "6班", "7班", "8班", "9班", "10班", "11班"],
    3: ["暂无班级"],
}

//js代码
function test1() {
    var xqSelect= document.getElementById("bj");
    xqSelect.innerText="";

    var selectValue = document.getElementById("nj").value;
    var xqElement = city[selectValue];
    for (var i=0;i<xqElement.length;i++) {
        var text = document.createTextNode( xqElement[i]);
        var option = document.createElement("option");
        option.appendChild(text);
        xqSelect.appendChild(option);
    }
}
function  init(){
    test1();
}