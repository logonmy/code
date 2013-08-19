<html>
    <head>
        <title>查看结果</title>
    </head>
    <body>
        <form action="">
            姓氏:<input id="txt1" type="text" onkeyup="showHint(this.value)"/>
        </form>
    </p>
    建议:<span id="txtHint"></span>
</p>


<script type="text/javascript">
                function showHint(str) {
                    var xmlhttp;
                    if (str.length == 0) {
                        document.getElementById("txtHint").innerHTML = "";
                        return;
                    }

                    if (window.XMLHttpRequest) {
                        // code for IE7+, FireFox, Chrome, Opera, Safari 
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveObject("Microsoft.XMLHTTP");
                    }

                    xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            var result = xmlhttp.responseText;
                            result = eval("(" + result + ")");
                            document.getElementById("txtHint").innerHTML = result.response;
                        }

                    }
                    xmlhttp.open("GET", "gethint.php?q=" + str, true);
                    xmlhttp.send();
                }

</script>
</body>
</html>
