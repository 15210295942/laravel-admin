//创建链接
var conn = new WebIM.connection({
    https: WebIM.config.https,
    url: WebIM.config.xmppURL,
    isAutoLogin: WebIM.config.isAutoLogin,
    isMultiLoginSessions: WebIM.config.isMultiLoginSessions
});
//页面初始加载
$(function(){
    //页面加载的时候，清除所有input框里面的值
    $("#hideFriends").val("");
    $("#hideClass").val("");
    //隐藏注册界面
    $("#imgdiv").hide();
    $("#myRegister").addClass("hide");
    $("#mylogin").addClass("hide");
    $("#main").removeClass("hide");
    //键盘事件。点击Enter直接登录
    /*document.onkeydown=function(event){
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if(e && e.keyCode==13){ // enter 键
            //要做的事情
            login();
        }
    };*/

    //添加消息回调
    conn.listen({
        //连接成功回调
        onOpened: function ( message ) {
            // 如果isAutoLogin设置为false，那么必须手动设置上线，否则无法收消息
            // 手动上线指的是调用conn.setPresence(); 如果conn初始化时已将isAutoLogin设置为true
            // 则无需调用conn.setPresence();
            console.log(message);
            console.log("连接成功");
            conn.setPresence();
            console.log("设置上线状态");
            $("#main").removeClass("hide");//显示比聊天框
            getFriends();
        },
        //连接关闭回调
        onClosed: function ( message ) {
            alert("您已经掉线");
            $("#imgdiv").hide();
            $("#main").addClass("hide");
            //$("#myRegister").addClass("hide");
            //$("#mylogin").removeClass("hide");
            console.log("连接关闭");
        },
        //收到文本消息
        onTextMessage: function ( message ) {
            var div = document.getElementById('content');
            div.scrollTop = div.scrollHeight;
            console.log(message);
            var myData = message.data;
            parseEmoji(myData , message.from , "get")
        },
        //收到表情消息
        onEmojiMessage: function ( message ) {
            // 当为WebIM添加了Emoji属性后，若发送的消息含WebIM.Emoji里特定的字符串，connection就会自动将
            // 这些字符串和其它文字按顺序组合成一个数组，每一个数组元素的结构为{type: 'emoji(或者txt)', data:''}
            // 当type='emoji'时，data表示表情图像的路径，当type='txt'时，data表示文本消息
            console.log('Emoji');
            var data = message.data;
            for(var i = 0 , l = data.length ; i < l ; i++){
                console.log(data[i]);
            }
        },
        //收到图片消息
        onPictureMessage: function ( message ) {
            console.log("收到图片消息"+JSON.stringify(message));
            var date = new Date();
            //"images/文件显示.png"
            var time = date.getFullYear()+"-"+(date.getMonth()+1>=10?(date.getMonth()+1):("0"+date.getMonth()+1))+"-"+(date.getDate()>=10?date.getDate():("0"+date.getDate()))+" "+(date.getHours()>=10?date.getHours():("0"+date.getHours()))+":"+(date.getMinutes()>=10?date.getMinutes():("0"+date.getMinutes()))+":"+(date.getSeconds()>=10?date.getSeconds():("0"+date.getSeconds()));

            createNewTab(message.from);
            var hideClass = $("#hideClass").val();
            $("#hideFriends").val(message.from);
            $("."+hideClass).append("<li><div class='touxiangLeft'></div><p class='titleLeft'>"+message.from+"-"+time+"</p><div class='pLeft'><a href='"+message.url+"'><img class='myImg' alt='微笑' src='"+message.url+"'></a></div><br></li><div class='clearFloat'></div>");
            $("#pic").val("");

            var options = {url: message.url};
            options.onFileDownloadComplete = function (data) {
                // 图片下载成功
                console.log('图片下载完成'+JSON.stringify(data));
            };
            options.onFileDownloadError = function () {
                // 图片下载失败
                console.log('Image download failed!');
            };
            WebIM.utils.download.call(conn, options);       // 意义待查
        },
        onCmdMessage: function ( message ) {},     //收到命令消息
        onAudioMessage: function ( message ) {},   //收到音频消息
        onLocationMessage: function ( message ) {},//收到位置消息
        //收到文件消息
        onFileMessage: function ( message ) {
            console.log("收到文件消息："+JSON.stringify(message));
            var date = new Date();
            //"images/文件显示.png"
            var time = date.getFullYear()+"-"+(date.getMonth()+1>=10?(date.getMonth()+1):("0"+date.getMonth()+1))+"-"+(date.getDate()>=10?date.getDate():("0"+date.getDate()))+" "+(date.getHours()>=10?date.getHours():("0"+date.getHours()))+":"+(date.getMinutes()>=10?date.getMinutes():("0"+date.getMinutes()))+":"+(date.getSeconds()>=10?date.getSeconds():("0"+date.getSeconds()));
            createNewTab(message.from);
            var hideClass = $("#hideClass").val();
            $("#hideFriends").val(message.from);
            $("."+hideClass).append("<li><div class='touxiangLeft'></div><p class='titleLeft'>"+message.from+"-"+time+"</p><div class='getFile'><p class='filenameRight'>文件</p><hr><p class='filenameRight' >"+message.filename+"</p><a href="+message.url+" class='mya'><p class='filenameCenter'>点击下载</p></a></div><br></li><div class='clearFloat'></div>");
        },
        onVideoMessage: function ( message ) {},   //收到视频消息
        //收到联系人订阅请求、处理群组、聊天室被踢解散等消息
        onPresence: function ( message ) {
            handlePresence(message);
        },
        onRoster: function ( message ) {},         //处理好友申请
        onInviteMessage: function ( message ) {},  //处理群组邀请
        onOnline: function () {},                  //本机网络连接成功
        onOffline: function () {},                 //本机网络掉线
        onError: function ( message ) {},          //失败回调
        onBlacklistUpdate: function (list) {       //黑名单变动
            // 查询黑名单，将好友拉黑，将好友从黑名单移除都会回调这个函数，list则是黑名单现有的所有好友信息
// 		    	console.log(Demo.api.blacklist.parse(list));

        }
    });
    //收到联系人订阅请求的处理方法，具体的type值所对应的值请参考xmpp协议规范
    var handlePresence = function ( e ) {
        console.log(e);
        //对方收到请求加为好友
        if (e.type === 'subscribe') {
            var se=confirm(e.from+"请求添加你为好友，同意请确认，拒绝请取消。");
            if (se==true){
                //1.同意好友请求
                conn.subscribed({
                    to: e.from,
                    message : "同意添加好友"
                });
            }else{
                //2.拒绝好友请求
                conn.unsubscribed({
                    to: 'username',
                    message : 'rejectAddFriend'
                });
            }
            //刷新好友列表
            getFriends();
        }else if(e.type === 'subscribed'){
            //对方同意好友请求后的回调
            conn.subscribe({
                to: e.from,
                message : '[resp:true]'
            });
            //刷新好友列表
            getFriends();
        }else if(e.type === 'unavailable'){
            //删除成功，刷新好友列表
            getFriends();
        }
    }
})
function showRegister(){
    $("#mylogin").addClass("hide");//隐藏登录
    $("#myRegister").removeClass("hide");//显示注册
}
function showLogin(){
    $("#mylogin").removeClass("hide");//显示登录
    $("#myRegister").addClass("hide");//隐藏注册
}
function register(){
    var userName = $("#username").val();
    var userPassword = $("#userpassword").val();
    var nickName = $("#nickName").val();
    window.Demo = {
        groupType: 'groupchat'
    };
    Demo.conn = new WebIM.connection({
        isMultiLoginSessions: WebIM.config.isMultiLoginSessions,
        https: typeof WebIM.config.https === 'boolean' ? WebIM.config.https : location.protocol === 'https:',
        url: WebIM.config.xmppURL,
        isAutoLogin: false,
        heartBeatWait: WebIM.config.heartBeatWait,
        autoReconnectNumMax: WebIM.config.autoReconnectNumMax,
        autoReconnectInterval: WebIM.config.autoReconnectInterval
    });
    var options = {
        username: userName,
        password: userPassword,
        nickname: nickName,
        appKey: WebIM.config.appkey,
        success: function () {
            alert("注册成功");
            $("#mylogin").removeClass("hide");//隐藏登录
            $("#myRegister").addClass("hide");//显示注册
        },
        error: function () {
            alert("注册失败");
        },
        apiUrl: WebIM.config.apiURL
    };
    WebIM.utils.registerUser(options);
}
function login(){
    userName = $("#userName").val();
    var userPassword = $("#userPassword").val();
    var options = {
        apiUrl: WebIM.config.apiURL,
        user: userName,
        pwd: userPassword,
        appKey: WebIM.config.appkey
    };
    conn.open(options);
}
//获取好友列表
function getFriends(){
    var friends = new Array();
    var da = "";
    conn.getRoster({
        success: function success(roster) {
            //查询一遍黑名单，如果好友中有和黑名单一样的，则不显示
            var curroster;
            for (var i in roster) {
                var ros = roster[i];
                if (ros.subscription === 'both' || ros.subscription === 'from' || ros.subscription === 'to') {
                    var friend = friends[i];
                    var txt = "<tr><th><div id='friendslist'></div></th><th class='oId' align='left'><span class='friendsName' onclick='chat(this)'>"
                        +ros.name
                        +"</span></th></tr>";
                    da += txt;
                }
            }
            if(da.length<=0){
                da = "<tr><th>暂无好友</th></tr>"
            }
            $("#myfriends").html(da);
        }
    });
}
//选择图片的事件
function upLoad(){
    var filePath=$("#pic").val();
    if(filePath.indexOf("jpg")!=-1 || filePath.indexOf("png")!=-1 || filePath.indexOf("gif")!=-1 || filePath.indexOf("bmp")!=-1){
        sendMessage();
    }else{
        alert("您未上传文件，或者您上传文件类型有误！");
        return false
    }
}
//选择文件的事件
function upLoad2(){
    var filePath=$("#myFile").val();
    if(filePath.indexOf("jpg")!=-1 || filePath.indexOf("png")!=-1 || filePath.indexOf("txt")!=-1 || filePath.indexOf("doc")!=-1 || filePath.indexOf("zip")!=-1 || filePath.indexOf("pdf")!=-1 || filePath.indexOf("gif")!=-1 || filePath.indexOf("bmp")!=-1){
        sendMessage();
    }else{
        alert("您未上传文件，或者您上传文件类型有误！");
        return false
    }
}
//添加好友
function addFriends(){
    var userName = $("#addFriend").val();
    conn.subscribe({
        to: userName,
        // Demo里面接收方没有展现出来这个message，在status字段里面
        message: '[resp:true]'
    });
}
//删除好友
function removeFriends(){
    var userName = $("#removeFriend").val();
    conn.removeRoster({
        to: userName,
        success: function () {  // 删除成功
            conn.unsubscribed({
                to: userName
            });
        },
        error: function () {    // 删除失败
        }
    });
}
//加入黑名单
function toBlackList(){
    var blackList = $("#blackList").val();
    conn.getBlacklist();
}
//点击好友聊天
function chat(obj){
    var friends = $(obj).parent().parent().find('.oId').text();//选择的好友
    createNewTab(friends);//创建聊天的tab
    $("#from").html(friends);
}
//发送消息
function sendMessage(){
    //得到上传的是文件还是图片
    var pic = $("#pic").val();
    var myFile = $("#myFile").val();
    var url;
    if($("#hideFriends").val() == ""){
        alert("请选择好友");
        return;
    }
    if($("#message").val() == "" && pic == "" && myFile == ""){
        alert("消息不能为空");
        return;
    }
    // 单聊发送文本消息
    if(pic != ""){
        var id = conn.getUniqueId();                   // 生成本地消息id
        var msg = new WebIM.message('img', id);        // 创建图片消息
        var input = document.getElementById('pic');  // 选择图片的input
        var file = WebIM.utils.getFileUrl(input);      // 将图片转化为二进制文件
        var allowType = {
            'jpg': true,
            'gif': true,
            'png': true,
            'bmp': true
        };
        if (file.filetype.toLowerCase() in allowType) {
            var option = {
                apiUrl: WebIM.config.apiURL,
                file: file,
                to: $("#hideFriends").val(),                       // 接收消息对象
                roomType: false,
                chatType: 'singleChat',
                onFileUploadError: function () {      // 消息上传失败
                    alert("失败");
                    console.log("上传失败");
                },
                onFileUploadComplete: function (data) {   // 消息上传成功
                    url = data.uri+"/"+data.entities[0].uuid;
                    console.log(data);
                    console.log(url);
                    var date = new Date();
                    var time = date.getFullYear()+"-"+(date.getMonth()+1>=10?(date.getMonth()+1):("0"+date.getMonth()+1))+"-"+(date.getDate()>=10?date.getDate():("0"+date.getDate()))+" "+(date.getHours()>=10?date.getHours():("0"+date.getHours()))+":"+(date.getMinutes()>=10?date.getMinutes():("0"+date.getMinutes()))+":"+(date.getSeconds()>=10?date.getSeconds():("0"+date.getSeconds()));
                    var hideClass = $("#hideClass").val();
                    $("."+hideClass).append("<li><div class='touxiangRight'></div><p class='titleRight'>"+userName+"-"+time+"</p><p class='pRight'><a href='"+url+"'><img class='myImg' alt='微笑' src='"+url+"'></a></p></li><div class='clearFloat'></div>");
                    $("#pic").val("");
                },
                success: function () {                // 消息发送成功
                    console.log('成功');
                },
                flashUpload: WebIM.flashUpload
            };
            msg.set(option);
            conn.send(msg.body);
        }
    }else if($("#message").val() != ""){
        var id = WebIM.connection.prototype.getUniqueId();                 // 生成本地消息id
        var msg = new WebIM.message('txt', id);      // 创建文本消息
        msg.set({
            msg: $("#message").val(),                  // 消息内容
            to: $("#hideFriends").val(),                          // 接收消息对象（用户id）
            roomType: false,
            success: function (id, serverMsgId) {
                //成功以后把消息放到聊天框中
                parseEmoji($("#message").val() , userName , "post");
                $("#message").val("");
            }
        });
        msg.body.chatType = 'singleChat';
        conn.send(msg.body);
    }else if(myFile != ""){
        var id = conn.getUniqueId();                   // 生成本地消息id
        var msg = new WebIM.message('file', id);        // 创建文件消息
        var input = document.getElementById('myFile');  // 选择文件的input
        var file = WebIM.utils.getFileUrl(input);      // 将文件转化为二进制文件
        var allowType = {
            'jpg': true,
            'gif': true,
            'png': true,
            'bmp': true,
            'zip': true,
            'txt': true,
            'doc':true,
            'pdf': true
        };
        if (file.filetype.toLowerCase() in allowType) {
            var option = {
                apiUrl: WebIM.config.apiURL,
                file: file,
                to: $("#hideFriends").val(),                       // 接收消息对象
                roomType: false,
                chatType: 'singleChat',
                onFileUploadError: function () {      // 消息上传失败
                    console.log('onFileUploadError');
                },
                onFileUploadComplete: function (data) {   // 消息上传成功
                    console.log('onFileUploadComplete'+data);
                    var url = data.uri+"/"+data.entities[0].uuid;
                    var date = new Date();
                    var time = date.getFullYear()+"-"+(date.getMonth()+1>=10?(date.getMonth()+1):("0"+date.getMonth()+1))+"-"+(date.getDate()>=10?date.getDate():("0"+date.getDate()))+" "+(date.getHours()>=10?date.getHours():("0"+date.getHours()))+":"+(date.getMinutes()>=10?date.getMinutes():("0"+date.getMinutes()))+":"+(date.getSeconds()>=10?date.getSeconds():("0"+date.getSeconds()));
                    var hideClass = $("#hideClass").val();
                    $("."+hideClass).append("<li><div class='touxiangRight'></div><p class='titleRight'>"+userName+"-"+time+"</p><div class='postFile'><p class='filenameRight'>文件</p><hr><p class='filenameRight'>"+myFile+"</p><a href="+url+" class='mya'><p class='filenameCenter'>点击下载</p></a></div><br></li><div class='clearFloat'></div>");
                    //清除文本框的消息
                    $("#myFile").val("");
                },
                success: function () {                // 消息发送成功
                    console.log('Success');
                },
                flashUpload: WebIM.flashUpload
            };
            msg.set(option);
            conn.send(msg.body);
        }
    }
}
//点击表情的事件
function imgEvent(){
    var a = $("#imgdiv").is(":hidden");
    if(a){
        $("#imgdiv").show();
    }else{
        $("#imgdiv").hide();
    }
};
//获取发送的表情
function getstr(a){
    var message = $("#message").val();
    a = message + a;
    $("#message").val(a);
}
//发送消息的时候解析表情
function parseEmoji(str , from , type){
    //str表示消息
    if(str.indexOf("[):]") != -1){
        var num1 = str.split("[):]").length-1;//回去接收的表情的个数
        for(var i=0;i<num1;i++){
            str = str.replace("[):]","<img alt='微笑' src='/home/js/plugin/webim/1.4.5/images/faces/微笑.png'>")
        }
    }
    if(str.indexOf("[:D]") != -1){
        var num2 = str.split("[:D]").length-1;//回去接收的表情的个数
        for(var i=0;i<num2;i++){
            str = str.replace("[:D]","<img alt='憨笑' src='/home/js/plugin/webim/1.4.5/images/faces/憨笑.png'>")
        }
    }
    if(str.indexOf("[;)]") != -1){
        var num3 = str.split("[;)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num3;i++){
            str = str.replace("[;)]","<img alt='疑问' src='/home/js/plugin/webim/1.4.5/images/faces/疑问.png'>")
        }
    }
    if(str.indexOf("[:-o]") != -1){
        var num4 = str.split("[:-o]").length-1;//回去接收的表情的个数
        for(var i=0;i<num4;i++){
            str = str.replace("[:-o]","<img alt='衰' src='/home/js/plugin/webim/1.4.5/images/faces/衰.png'>")
        }
    }
    if(str.indexOf("[:p]") != -1){
        var num5 = str.split("[:p]").length-1;//回去接收的表情的个数
        for(var i=0;i<num5;i++){
            str = str.replace("[:p]","<img alt='调皮' src='/home/js/plugin/webim/1.4.5/images/faces/调皮.png'>")
        }
    }
    if(str.indexOf("[(H)]") != -1){
        var num6 = str.split("[(H)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num6;i++){
            str = str.replace("[(H)]","<img alt='得意' src='/home/js/plugin/webim/1.4.5/images/faces/得意.png'>")
        }
    }
    if(str.indexOf("[:@]") != -1){
        var num7 = str.split("[:@]").length-1;//回去接收的表情的个数
        for(var i=0;i<num7;i++){
            str = str.replace("[:@]","<img alt='发怒' src='/home/js/plugin/webim/1.4.5/images/faces/发怒.png'>")
        }
    }
    if(str.indexOf("[:s]") != -1){
        var num8 = str.split("[:s]").length-1;//回去接收的表情的个数
        for(var i=0;i<num8;i++){
            str = str.replace("[:s]","<img alt='撇嘴' src='/home/js/plugin/webim/1.4.5/images/faces/撇嘴.png'>")
        }
    }
    if(str.indexOf("[:$]") != -1){
        var num9 = str.split("[:$]").length-1;//回去接收的表情的个数
        for(var i=0;i<num9;i++){
            str = str.replace("[:$]","<img alt='委屈' src='/home/js/plugin/webim/1.4.5/images/faces/委屈.png'>")
        }
    }
    if(str.indexOf("[:(]") != -1){
        var num10 = str.split("[:(]").length-1;//回去接收的表情的个数
        for(var i=0;i<num10;i++){
            str = str.replace("[:(]","<img alt='傲慢' src='/home/js/plugin/webim/1.4.5/images/faces/傲慢.png'>")
        }
    }
    if(str.indexOf("[:'(]") != -1){
        var num11 = str.split("[:'(]").length-1;//回去接收的表情的个数
        for(var i=0;i<num11;i++){
            str = str.replace("[:'(]","<img alt='大哭' src='/home/js/plugin/webim/1.4.5/images/faces/大哭.png'>")
        }
    }
    if(str.indexOf("[:|]") != -1){
        var num12 = str.split("[:|]").length-1;//回去接收的表情的个数
        for(var i=0;i<num12;i++){
            str = str.replace("[:|]","<img alt='尴尬' src='/home/js/plugin/webim/1.4.5/images/faces/尴尬.png'>")
        }
    }
    if(str.indexOf("[(a)]") != -1){
        var num13 = str.split("[(a)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num13;i++){
            str = str.replace("[(a)]","<img alt='抠鼻' src='/home/js/plugin/webim/1.4.5/images/faces/抠鼻.png'>")
        }
    }
    if(str.indexOf("[8o|]") != -1){
        var num14 = str.split("[8o|]").length-1;//回去接收的表情的个数
        for(var i=0;i<num14;i++){
            str = str.replace("[8o|]","<img alt='坏笑' src='/home/js/plugin/webim/1.4.5/images/faces/坏笑.png'>")
        }
    }
    if(str.indexOf("[8-|]") != -1){
        var num15 = str.split("[8-|]").length-1;//回去接收的表情的个数
        for(var i=0;i<num15;i++){
            str = str.replace("[8-|]","<img alt='阴险' src='/home/js/plugin/webim/1.4.5/images/faces/阴险.png'>")
        }
    }
    if(str.indexOf("[+o(]") != -1){
        var num16 = str.split("[+o(]").length-1;//回去接收的表情的个数
        for(var i=0;i<num16;i++){
            str = str.replace("[+o(]","<img alt='吐' src='/home/js/plugin/webim/1.4.5/images/faces/吐.png'>")
        }
    }
    if(str.indexOf("[<o)]") != -1){
        var num17 = str.split("[<o)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num17;i++){
            str = str.replace("[<o)]","<img alt='睡觉' src='/home/js/plugin/webim/1.4.5/images/faces/睡觉.png'>")
        }
    }
    if(str.indexOf("[|-)]") != -1){
        var num18 = str.split("[|-)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num18;i++){
            str = str.replace("[|-)]","<img alt='龇牙' src='/home/js/plugin/webim/1.4.5/images/faces/龇牙.png'>")
        }
    }
    if(str.indexOf("[*-)]") != -1){
        var num19 = str.split("[*-)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num19;i++){
            str = str.replace("[*-)]","<img alt='吓' src='/home/js/plugin/webim/1.4.5/images/faces/吓.png'>")
        }
    }
    if(str.indexOf("[:-#]") != -1){
        var num20 = str.split("[:-#]").length-1;//回去接收的表情的个数
        for(var i=0;i<num20;i++){
            str = str.replace("[:-#]","<img alt='闭嘴' src='/home/js/plugin/webim/1.4.5/images/faces/闭嘴.png'>")
        }
    }
    if(str.indexOf("[:-*]") != -1){
        var num21 = str.split("[:-*]").length-1;//回去接收的表情的个数
        for(var i=0;i<num21;i++){
            str = str.replace("[:-*]","<img alt='偷笑' src='/home/js/plugin/webim/1.4.5/images/faces/偷笑.png'>")
        }
    }
    if(str.indexOf("[^o)]") != -1){
        var num22 = str.split("[^o)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num22;i++){
            str = str.replace("[^o)]","<img alt='咒骂' src='/home/js/plugin/webim/1.4.5/images/faces/咒骂.png'>")
        }
    }
    if(str.indexOf("[8-)]") != -1){
        var num23 = str.split("[8-)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num23;i++){
            str = str.replace("[8-)]","<img alt='抓狂' src='/home/js/plugin/webim/1.4.5/images/faces/抓狂.png'>")
        }
    }
    if(str.indexOf("[(|)]") != -1){
        var num24 = str.split("[(|)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num24;i++){
            str = str.replace("[(|)]","<img alt='爱心' src='/home/js/plugin/webim/1.4.5/images/faces/爱心.png'>")
        }
    }
    if(str.indexOf("[(u)]") != -1){
        var num25 = str.split("[(u)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num25;i++){
            str = str.replace("[(u)]","<img alt='心碎' src='/home/js/plugin/webim/1.4.5/images/faces/心碎.png'>")
        }
    }
    if(str.indexOf("[(S)]") != -1){
        var num26 = str.split("[(S)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num26;i++){
            str = str.replace("[(S)]","<img alt='蛋糕' src='/home/js/plugin/webim/1.4.5/images/faces/蛋糕.png'>")
        }
    }
    if(str.indexOf("[(*)]") != -1){
        var num27 = str.split("[(*)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num27;i++){
            str = str.replace("[(*)]","<img alt='月亮' src='/home/js/plugin/webim/1.4.5/images/faces/月亮.png'>")
        }
    }
    if(str.indexOf("[(#)]") != -1){
        var num28 = str.split("[(#)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num28;i++){
            str = str.replace("[(#)]","<img alt='微笑' src='/home/js/plugin/webim/1.4.5/images/faces/阳光.png'>")
        }
    }
    if(str.indexOf("[(R)]") != -1){
        var num29 = str.split("[(R)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num29;i++){
            str = str.replace("[(R)]","<img alt='晕' src='/home/js/plugin/webim/1.4.5/images/faces/晕.png'>")
        }
    }
    if(str.indexOf("[({)]") != -1){
        var num30 = str.split("[({)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num30;i++){
            str = str.replace("[({)]","<img alt='色' src='/home/js/plugin/webim/1.4.5/images/faces/色.png'>")
        }
    }
    if(str.indexOf("[(})]") != -1){
        var num31 = str.split("[(})]").length-1;//回去接收的表情的个数
        for(var i=0;i<num31;i++){
            str = str.replace("[(})]","<img alt='亲亲' src='/home/js/plugin/webim/1.4.5/images/faces/亲亲.png'>")
        }
    }
    if(str.indexOf("[(k)]") != -1){
        var num32 = str.split("[(k)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num32;i++){
            str = str.replace("[(k)]","<img alt='示爱' src='/home/js/plugin/webim/1.4.5/images/faces/示爱.png'>")
        }
    }
    if(str.indexOf("[(F)]") != -1){
        var num33 = str.split("[(F)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num33;i++){
            str = str.replace("[(F)]","<img alt='心动' src='/home/js/plugin/webim/1.4.5/images/faces/心动.png'>")
        }
    }
    if(str.indexOf("[(W)]") != -1){
        var num34 = str.split("[(W)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num34;i++){
            str = str.replace("[(W)]","<img alt='凋谢' src='/home/js/plugin/webim/1.4.5/images/faces/凋谢.png'>")
        }
    }
    if(str.indexOf("[(D)]") != -1){
        var num35 = str.split("[(D)]").length-1;//回去接收的表情的个数
        for(var i=0;i<num35;i++){
            str = str.replace("[(D)]","<img alt='强' src='/home/js/plugin/webim/1.4.5/images/faces/强.png'>")
        }
    }
    var date = new Date();
    var time = date.getFullYear()+"-"+(date.getMonth()+1>=10?(date.getMonth()+1):("0"+date.getMonth()+1))+"-"+(date.getDate()>=10?date.getDate():("0"+date.getDate()))+" "+(date.getHours()>=10?date.getHours():("0"+date.getHours()))+":"+(date.getMinutes()>=10?date.getMinutes():("0"+date.getMinutes()))+":"+(date.getSeconds()>=10?date.getSeconds():("0"+date.getSeconds()));
    //如果发送消息的人不是同一个人
    if(type == "get"){//background-color:#87CEFA;
        if($("#hideFriends").val() != "" && $("#hideFriends").val() != from){
            createNewTab(from);
            var hideClass = $("#hideClass").val();
            $("#hideFriends").val(from);
            //alert("消息来自不同的人");
            $("."+hideClass).append("<li><div class='touxiangLeft'></div><p class='titleLeft'>"+from+"-"+time+"</p><p class='filenameLeft'>"+str+"</p><br></li>");
        }else{
            createNewTab(from);
            var hideClass = $("#hideClass").val();
            $("#hideFriends").val(from);
            //alert("消息来自相同的人");
            $("."+hideClass).append("<li><div class='touxiangLeft'></div><p class='titleLeft'>"+from+"-"+time+"</p><p class='filenameLeft'>"+str+"</p><br></li>");
        }
    }else{
        var hideClass = $("#hideClass").val();
        $("."+hideClass).append("<div class='touxiangRight'></div><p class='titleRight'>"+from+"-"+time+"</p><p class='filenameRight''>"+str+"</p><br/>")
    }
}
/*根据不同人发送来的消息从而加载不同的聊天界面*/
var i=0;
var className;
var contentName;
var idName;
var flag;
function createNewTab(fromUser){
    //如果该联系人已经存在了，那么就不创建tab了
    i++;
    className = "t"+i;
    var lis=$("ul").find("li");
    if(lis.length>0){
        lis.each(function(){
            var idname=$(this).attr('id');
            if(fromUser == idname){
                flag = false;
                var divClass = $(this).find("a").prop("name").split(".")[1];//显示内容
                $("#hideClass").val(divClass);
                return false;//跳出整个each遍历    return true  跳出当前each
            }else{
                flag = true;
            }
        })
        if(flag){
            $("#hideClass").val(className);
            $("#hideFriends").val(fromUser);
            /*标题------聊天人*/
            $(".tabs").append("<li id='"+fromUser+"'><a href='#' name='."+className+"' onclick='show(this)'>"+fromUser+"</a></li>");
            /*内容------消息记录*/
            $("#content").append("<div class='"+className+"' style='display: none'></div>");
            if(i == 1){
                $("."+className+":first").show();
            }
        }
    }else{
        $("#hideClass").val(className);
        $("#hideFriends").val(fromUser);
        /*标题------聊天人*/
        $(".tabs").append("<li id='"+fromUser+"'><a href='#' name='."+className+"' onclick='show(this)'>"+fromUser+"</a></li><div style='width: 10px;height: 10px;;background-color: #00BFFF;float: left'></div>");
        /*内容------消息记录*/
        $("#content").append("<div class='"+className+"' style='display: none'></div>");
        if(i == 1){
            $("."+className+":first").show();
        }
    }
}
function show(obj){
    $(obj).style.backgroundColor="#004974"
    var divClass = $(obj).prop("name").split(".")[1];//找到当前点击的a标签的name属性值
    $("#hideFriends").val($(obj).text());
    $("#hideClass").val(divClass);
    $("#content>div").hide();//隐藏content div下面第一层的所有div
    $("."+divClass+"").show();//显示当前点击的div
}

//发送截图
document.addEventListener('paste', function (e) {
    if($("#hideFriends").val()==""){
        alert("请选择好友");
        return;
    }

    if (e.clipboardData && e.clipboardData.types) {
        if (e.clipboardData.items.length > 0) {
            if (/^image\/\w+$/.test(e.clipboardData.items[0].type)) {
                var blob = e.clipboardData.items[0].getAsFile();
                var url = window.URL.createObjectURL(blob);
                var id = conn.getUniqueId();             // 生成本地消息id
                var msg = new WebIM.message('img', id);  // 创建图片消息
                msg.set({
                    apiUrl: WebIM.config.apiURL,
                    file: {data: blob, url: url},
                    to: $("#hideFriends").val(),                      // 接收消息对象
                    roomType: false,
                    chatType: 'singleChat',
                    onFileUploadError: function (error) {
                        console.log('Error');
                    },
                    onFileUploadComplete: function (data) {
                        console.log('Complete');
                    },
                    success: function (id) {
                        var date = new Date();
                        var time = date.getFullYear()+"-"+(date.getMonth()+1>=10?(date.getMonth()+1):("0"+date.getMonth()+1))+"-"+(date.getDate()>=10?date.getDate():("0"+date.getDate()))+" "+(date.getHours()>=10?date.getHours():("0"+date.getHours()))+":"+(date.getMinutes()>=10?date.getMinutes():("0"+date.getMinutes()))+":"+(date.getSeconds()>=10?date.getSeconds():("0"+date.getSeconds()));
                        var hideClass = $("#hideClass").val();
                        $("."+hideClass).append("<li style='margin:0;padding:0;'><div class='touxiangRight'></div><p class='titleRight'>"+userName+"-"+time+"</p><p class='pRight''><a href='"+url+"' target='_blank' ><img class='myImg' alt='微笑' src='"+url+"'></a></p></li><div class='clearFloat'></div>");

                        console.log('Success');
                    }
                });
                conn.send(msg.body);
            }
        }
    }
})
function hideEmoji(){
    $("#imgdiv").hide();
}
//点击三角形，显示好友,显示左三角
/*function showLeft(){
 alert("打开好友，显示左边");
 $("#rightImg").addClass("hide");
 $("#leftImg").removeClass("hide");
 $("#leftDiv").addClass("hide");
 }*/
//点击三角形，关闭好友，显示右三角
/*function showRight(){
 alert("关闭好友，显示右边");
 $("#rightImg").removeClass("hide");
 $("#leftImg").addClass("hide");
 $("#leftDiv").removeClass("hide");
 }*/