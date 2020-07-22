var bashUrl = 'http://company.com/';


function getRequest(data, url, callBack) {
    $.ajax({
        url: bashUrl + '/' + url,
        data: data,
        contentType: 'application/json;charset=UTF-8',
        dataType: "json",
        type: "get",
        success: function (data) {
            callBack(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {

        }
    });
};

var postRequest = function (data, url, callBack) {
    $.ajax({
        url: bashUrl + '/' + url,
        data: JSON.stringify(data),
        contentType: 'application/json;charset=UTF-8',
        dataType: "json",
        type: "post",
        success: function (data) {
            callBack(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {

        }
    });
};
