$(document).ready(function () {
    $.get("./HTMLrequest.php",function (data,status)
    {
        let res = JSON.parse(data);
    });
});