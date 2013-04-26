<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
         <title>js</title>
            <style type="text/css">
            p{margin:0;font-size:12px;line-height:26px;}
            </style>
            <script type="text/javascript">
            function check_all(obj,cName) {
                var checkboxs = document.getElementsByName(cName);     
                for(var i=0;i<checkboxs.length;i++) {
                   checkboxs[i].checked = obj.checked; 
                }
            }

            function checkall(obj,Name) {
               var checkboxs = document.getElementsByName(Name); 
               for(var i=0;i<checkboxs.length;i++) {
                  checkboxs[i].checked = true; 
               }
            }

            function check_none(obj,Name) {
               var checkboxs = document.getElementsByName(Name); 
               for(var i=0;i<checkboxs.length;i++) {
                  checkboxs[i].checked = false; 
               }
            }
            </script>
    </head>
    <body>
    <p><input type="checkbox" name="all" onclick="check_all(this,'c')"/>全选/全不选</p>
    <p><button onclick="checkall(this, 'c')">全选</button></p>
    <p><button onclick="check_none(this, 'c')">取消</button></p>
    <p><input type="checkbox" name="c" value=""/></p>
    <p><input type="checkbox" name="c" value=""/></p>
    <p><input type="checkbox" name="c" value=""/></p>
    <p><input type="checkbox" name="c" value=""/></p>
    <p><input type="checkbox" name="c" value=""/></p>
    </body>
</html>
