/**
 * Created by Samuel on 2017/6/30.
 */

var base_url = '';
function request(method, api, data, callback, complete) {
    $.ajax({
        beforeSend: function (request) {
            request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        url: base_url + api,
        type: method,
        data: data,
        dataType: 'json',
        success: function (response) {
            if (response.code === 403) {
                location.href = '/admin/login';
                return;
            }
            callback(response);
        },
        complete: function () {
            if (undefined !== complete) {
                complete();
            }
        },
        error: function () {
            alert('接口请求失败！');
        }
    });
}

function get(api, data, callback, complete) {
    request('GET', api, data, callback, complete);
}
function sendDelete(api, data, callback, complete) {
    request('DELETE', api, data, callback, complete);
}

function post(api, data, callback, complete) {
    request('POST', api, data, callback, complete);
}

function postFile(obj) {
    $.ajax({
        beforeSend: function (request) {
            request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        url: base_url + obj.api,
        type: 'post',
        data: obj.data,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.code === 403) {
                location.href = '/admin/login';
                return;
            }
            obj.success(response);
        },
        complete: function () {
            obj.complete();
        },
        error: function () {
            alert('接口请求失败！');
        }
    });
}

function pageHtml(totalPage, currentPage, totalCount) {
    var p = '';
    var currentUrl = window.location.href;

    for (var i = 1; i <= totalPage; i++) {

        var url = '';
        if (currentUrl.indexOf('page=') != -1) {
            url = replaceParamVal(currentUrl, 'page', i)
        } else if (currentUrl.indexOf('?') != -1) {
            url = currentUrl + '&page=' + i;
        } else {
            url = currentUrl + '?page=' + i;
        }
        url = url.replace('#', '');
        //console.log(url);


        var c = '';
        if (currentPage === i) {
            c = ' current';
        }
        if((i == currentPage) || (i < currentPage && (currentPage - i)<=3) || (i > currentPage && (i - currentPage)<=3)){
            p += '<a href="' + url + '" class="number' + c + '">' + i + '</a>';
        }

    }
    p = '<a href="' + replaceParamVal(url,'page',1) + '" class="number">首页</a>' + p + '<a href="' + replaceParamVal(url,'page',totalPage) + '" class="number">末页('+totalPage+')</a> 共:'+totalCount+'条';
    return p;
}

function schoolSelect() {
    $('select[name="school"]').change(function () {
        var schoolId = $(this).find('option:selected').attr('schoolId');
        $('select[name="grade"]').val('');
        $('select[name="class"]').val('');
        $('select[name="payRange"]').val('');
        $('.grade_').hide();
        $('.class_').hide();
        $('.range_').hide();
        $('.grade_' + schoolId).show();
        $('.range_' + schoolId).show();
    });
    $('select[name="grade"]').change(function () {
        var gradeId = $(this).find('option:selected').attr('gradeId');
        $('select[name="class"]').val('');
        $('.class_').hide();
        $('.class_' + gradeId).show();
    });
}

function replaceParamVal(oldUrl, paramName, replaceWith) {
    if(null === oldUrl){
        oldUrl = window.location.href;
    }
    oldUrl = oldUrl.replace(/#(.*)$/,'');
    if (oldUrl.indexOf(paramName+'=') != -1) {
        var re = eval('/(' + paramName + '=)([^&]*)/gi');
        var nUrl = oldUrl.replace(re, paramName + '=' + replaceWith);
        return nUrl;
    } else if (oldUrl.indexOf('?') != -1) {
        return oldUrl + '&' + paramName + '=' + replaceWith;
    } else {
        return oldUrl + '?' + paramName + '=' + replaceWith;
    }

}

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}