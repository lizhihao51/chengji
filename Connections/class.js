var city = {
    0: ["请选择"],
    1: ["请选择", "1班","2班", "3班", "4班", "5班", "6班", "7班", "8班", "9班", "10班"],
    2: ["请选择","1班", "2班", "3班", "4班", "5班", "6班", "7班", "8班", "9班", "10班"],
    3: ["请选择","1班", "2班", "3班", "4班", "5班", "6班", "7班", "8班", "9班", "10班"],
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