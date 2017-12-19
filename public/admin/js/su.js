(function () {
    setTimeout(function () {
        function e(e) {
            for (var r = e + "=", t = document.cookie.split(";"), n = 0; n < t.length; n++) {
                for (var o = t[n]; " " == o.charAt(0);)o = o.substring(1, o.length);
                if (0 == o.indexOf(r))return o.substring(r.length, o.length)
            }
            return !1
        }

        var r = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=", t = function (e) {
            e = e.replace(new RegExp("\r\n", "g"), "\n");
            for (var r = "", t = 0; t < e.length; t++) {
                var n = e.charCodeAt(t);
                n < 128 ? r += String.fromCharCode(n) : n > 127 && n < 2048 ? (r += String.fromCharCode(n >> 6 | 192), r += String.fromCharCode(63 & n | 128)) : (r += String.fromCharCode(n >> 12 | 224), r += String.fromCharCode(n >> 6 & 63 | 128), r += String.fromCharCode(63 & n | 128))
            }
            return r
        }, n = e("yjs_id");
        if (!n) {
            var o = window.navigator.userAgent, i = window.location.host, a = (new Date).getTime(),
                d = "yjs_id=" + (n = (n = function (e) {
                        var n, o, i, a, d, c, g, h = "", m = 0;
                        for (e = t(e); m < e.length;)a = (n = e.charCodeAt(m++)) >> 2, d = (3 & n) << 4 | (o = e.charCodeAt(m++)) >> 4, c = (15 & o) << 2 | (i = e.charCodeAt(m++)) >> 6, g = 63 & i, isNaN(o) ? c = g = 64 : isNaN(i) && (g = 64), h = h + r.charAt(a) + r.charAt(d) + r.charAt(c) + r.charAt(g);
                        return h
                    }(o + "|" + i + "|" + a + "|" + document.referrer)).replace(new RegExp("=", "g"), "")) + ";path=/;expires=" + new Date(10 * a).toUTCString();
            document.cookie = d
        }
        if (!e("ctrl_time")) {
            var c = document.createElement("img");
            c.src = "//idm-su.baidu.com/su.png?yjs_id=" + n, document.body.appendChild(c), c.onload = function () {
                document.body.removeChild(c, !0)
            };
            var g = (new Date).getTime(), h = new Date(g + 864e5).toUTCString();
            document.cookie = "ctrl_time=1;path=/;expires=" + h
        }
    }, 0)
})()