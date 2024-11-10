var city = {
    0: ["请选择"],
    1: ["请选择", "1班", "2班", "3班", "4班", "5班", "6班", "7班", "8班", "9班", "10班"],
    2: ["请选择", "1班", "2班", "3班", "4班", "5班", "6班", "7班", "8班", "9班", "10班"],
    3: ["请选择", "1班", "2班", "3班", "4班", "5班", "6班", "7班", "8班", "9班", "10班", "测试用班级"]
};

function test1() {
    var xqSelect = document.getElementById("bj");
    xqSelect.innerHTML = "";  // 清空班级下拉框

    var selectValue = document.getElementById("nj").value;  // 获取选择的年级
    var xqElement = city[selectValue];  // 根据年级获取对应的班级

    // 动态生成班级选项
    for (var i = 0; i < xqElement.length; i++) {
        var option = document.createElement("option");
        option.value = xqElement[i];  // 设置选项的值
        option.text = xqElement[i];   // 设置选项显示的文本
        xqSelect.appendChild(option); // 添加到班级下拉框中
    }
}

function init() {
    test1(); // 页面加载时初始化班级选项
    var savedGrade = localStorage.getItem("savedGrade");  // 从 localStorage 获取上次选择的年级
    var savedClass = localStorage.getItem("savedClass");  // 获取上次选择的班级

    if (savedGrade) {
        document.getElementById("nj").value = savedGrade;  // 设置年级
        test1();  // 更新班级选项

        if (savedClass) {
            document.getElementById("bj").value = savedClass;  // 设置班级
        }
    }
}

// 在选择年级时保存选择的年级和班级到 localStorage
function saveSelection() {
    var selectedGrade = document.getElementById("nj").value;
    var selectedClass = document.getElementById("bj").value;

    localStorage.setItem("savedGrade", selectedGrade);
    localStorage.setItem("savedClass", selectedClass);
}