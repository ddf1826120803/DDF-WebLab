<html>
<head>
<title>LRC 歌词编辑器</title>
<style>
    nav ul {
        position: fixed;
        z-index: 99;
        right: 5%;
        border: 1px solid darkgray;
        border-radius: 5px;
        list-style:none;
        padding: 0;
    }

    .tab {
        padding: 1em;
        display: block;
    }

    .tab:hover {
        cursor: pointer;
        background-color: lightgray !important;
    }

    td {
        padding:0.2em;
    }

    textarea[name="edit_lyric"] {
        width: 100%;
        height: 50em;
    }

    input[type="button"] {
        width: 100%;
        height: 100%;
    }

    input[type="submit"] {
        width: 100%;
        height: 100%;
    }

    #td_submit {
        text-align: center;
    }

    select {
        display: block;
    }

    #lyric {
        width: 35%;
        height: 60%;
        border: 0;
        resize: none;
        font-size: large;
        line-height: 2em;
        text-align: center;
    }
</style>
</head>

<body>
    <nav><ul>
        <li id="d_edit" class="tab">Edit Lyric</li>
        <li id="d_show" class="tab">Show Lyric</li>
    </ul></nav>

<!--歌词编辑部分-->
<section id="s_edit" class="content">
<form id="f_upload" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <p>请上传音乐文件</p>

    <!--TODO: 在这里补充 html 元素，使 file_upload 上传后若为音乐文件，则可以直接播放-->
    <audio id="myAudio" src="" controls></audio>

    <input type="file" name="file_upload" id="audioFile" onchange="playAudio()">
    <table>
        <tr><td>Title: <input type="text"></td><td>Artist: <input type="text"></td></tr>
        <tr><td colspan="2"><textarea name="edit_lyric" id="edit_lyric"></textarea></td></tr>
        <tr><td><input type="button" value="插入时间标签" onclick="insertTime()"></td><td><input type="button" value="替换时间标签"></td></tr>
        <tr><td colspan="2" id="td_submit"><input type="submit" name="submit" value="Submit"></td></tr>   
    </table>
</form>
</section>

<!--歌词展示部分-->
<section id="s_show" class="content">
    <select onchange="selectMusic()" id="selectMusic">
    <!--TODO: 在这里补充 html 元素，使点开 #d_show 之后这里实时加载服务器中已有的歌名-->
    <?php 
        $musicDir=opendir("music");
        while(($musicNameSelect=readdir($musicDir))!==false){
             $nameLength=strlen($musicNameSelect);
            $musicNameR=substr($musicNameSelect,0,$nameLength-4);
            echo '<option value="'.$musicNameR.'">'.$musicNameR.'</option>';
        }
    ?>
    
    </select>

    <textarea id="lyric" readonly="true">

    </textarea>
    
    <!--TODO: 在这里补充 html 元素，使选择了歌曲之后这里展示歌曲进度条，并且支持上下首切换-->

</section>
</body>
<script>

// 界面部分
document.getElementById("d_edit").onclick = function () {click_tab("edit");};
document.getElementById("d_show").onclick = function () {click_tab("show");};

document.getElementById("d_show").click();

function click_tab(tag) {
    for (let i = 0; i < document.getElementsByClassName("tab").length; i++) document.getElementsByClassName("tab")[i].style.backgroundColor = "transparent";
    for (let i = 0; i < document.getElementsByClassName("content").length; i++) document.getElementsByClassName("content")[i].style.display = "none";

    document.getElementById("s_" + tag).style.display = "block";
    document.getElementById("d_" + tag).style.backgroundColor = "darkgray";
} 

// Edit 部分
var edit_lyric_pos = 0;
document.getElementById("edit_lyric").onmouseleave = function () {
    edit_lyric_pos = document.getElementById("edit_lyric").selectionStart;
};

// 获取所在行的初始位置。
function get_target_pos(n_pos) {
    if (n_pos === undefined) n_pos = edit_lyric_pos;
    let value = document.getElementById("edit_lyric").value; 
    let pos = 0;
    for (let i = n_pos; i >= 0; i--) {
        if (value.charAt(i) === '\n') {
            pos = i + 1;
            break;
        }
    }
    return pos;
}

// 选中所在行。
function get_target_line(n_pos) {
    let value = document.getElementById("edit_lyric").value; 
    let f_pos = get_target_pos(n_pos);
    let l_pos = 0;

    for (let i = f_pos;; i++) {
        if (value.charAt(i) === '\n') {
            l_pos = i + 1;
            break;
        }
    }
    return [f_pos, l_pos];
}
// 若为音乐文件，则直接播放
    function playAudio(){
        var audioFile=document.getElementById('audioFile');
        var audio=document.getElementById('myAudio');
        var url=audioFile.value;
        var index=url.indexOf("fakepath");
        var urlReal=url.substr(index+9);
        audio.src=urlReal;
        }

/* HINT: 
 * 已经帮你写好了寻找每行开头的位置，可以使用 get_target_pos()
 * 来获取第一个位置，从而插入相应的歌词时间。
 * 在 textarea 中，可以通过这个 DOM 节点的 selectionStart 和
 * selectionEnd 获取相对应的位置。
 *
 * TODO: 请实现你的歌词时间标签插入效果。
 */
// 插入时间标签
    function insertTime(){
        var getPos=get_target_pos();
        var edit=document.getElementById("edit_lyric");
        var editContent=edit.value;
        var start=editContent.substring(0,getPos);
        var end=editContent.substring(getPos,editContent.length);
        // 获得格式化时间
         var time=document.getElementById('myAudio').currentTime;
        var timeDate= new Date(parseInt(time*1000));
        var timeGet=dateFtt("mm:ss.S",timeDate);

        var addContent=start+"["+timeGet+"]"+end;
        edit.value=addContent;
    }
    //格式化时间
    function dateFtt(fmt,date){  
      var o = {   
        "M+" : date.getMonth()+1,                 //月份   
        "d+" : date.getDate(),                    //日   
        "h+" : date.getHours(),                   //小时   
        "m+" : date.getMinutes(),                 //分   
        "s+" : date.getSeconds(),                 //秒   
        "q+" : Math.floor((date.getMonth()+3)/3), //季度   
        "S"  : date.getMilliseconds()             //毫秒   
      };   
      if(/(y+)/.test(fmt))     
        fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));     
      for(var k in o)     
       if(new RegExp("("+ k +")").test(fmt))     
      fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));     
        return fmt;    
 
}  
// 下拉列表选音乐，并加载相应的歌词
    function selectMusic(){
        let mySelect = document.getElementById('selectMusic');
        var grade = mySelect.options[mySelect.selectedIndex].value;
       showMusicLrc(grade);
    }
    // 获取歌词
    function showMusicLrc(n){
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
             if (xmlhttp.readyState==4 && xmlhttp.status==200){
        document.getElementById("lyric").value=xmlhttp.responseText;
        }
        }
      xmlhttp.open("GET","ddd02.php?selectMusicLrc="+n);
      xmlhttp.send();
    }


/* HINT: 
 * 实现歌词和时间的匹配的时候推荐使用 Map class，ES6 自带。
 * 在 Map 中，key 的值必须是字符串，但是可以通过字符串直接比较。
 * 每一行行高可粗略估计为 40，根据电脑差异或许会有不同。
 * 当前歌词请以粗体显示。
 * 从第八行开始，当歌曲转至下一行的时候，需要调整滚动条，使得当前歌
 * 词保持在正中。
 *
 * TODO: 请实现你的歌词滚动效果。
 */
function start () {
    // body...
     var formatTime = function(time){
        var m = time.split(':')[0];
        var s = time.split(':')[1];
        return Number(m)*60+Number(s);
    };
    var lyricArray = [];
    for(var i = 0;i<lyricData.length;i++){
        var tmpTime = /\d+:\d+.\d+/.exec(lyricData[i]);
        var tmpLyric = lyricData[i].split(/[\\[]\d+:\d+.\d+]/);
        if(tmpTime!=null){
            lyricArray.push({time:formatTime(String(tmpTime)),lyric:tmpLyric[1]});
        }
    }
    for(var i=0 ; i<lyricArray.length;i++){
        var lyricBorder = document.getElementById('words');
        var lyricEl = document.createElement('li');
        lyricEl.innerHTML = lyricArray[i].lyric;
        lyricBorder.appendChild(lyricEl);
    }
    var audio = document.getElementById('audio');
    var count = 0;
    var vaildTime = function(time,index){
        console.log(index,lyricArray.length);
        if(index<lyricArray.length-1){
            if(time>=lyricArray[index].time&&time<=lyricArray[index+1].time){
                return true;
            }else{
                return false;
            }
        }else{
            if(time<=audio.duration){
                return true;
            }else{
                return false;
       }
        }
    };
    var wordEl = document.getElementById('words');
    var marTop = parseInt(wordEl.style.marginTop);
    audio.ontimeupdate = function(){
        var time = audio.currentTime;
        if(!vaildTime(time,count)) {
            count++;
        }
        wordEl.style.marginTop = (marTop-count*48)+'px';
        var li = wordEl.querySelectorAll('li');
        for(var i = 0 ; i < li.length ; i++){
            li[i].removeAttribute('class');
        }
        wordEl.querySelectorAll('li')[count].setAttribute('class','sel');
        if(audio.ended){
            wordEl.style.marginTop = marTop + 'px';
            count=0;
       }
    }
    audio.onseeked = function(){
        var cur_time = audio.currentTime;
        for(var _i = 0;_i <= lyricArray.length - 1;_i++){
            if (cur_time>=lyricArray[_i].time&&cur_time<=lyricArray[_i + 1].time)
                count = _i;
        }
    }

};
}
</script>
</html>
<!-- 上传功能 -->
 <?php
    // 获得音乐文件的名称
  if(!empty(isset($_POST['submit']))){
    $musicName=$_FILES['file_upload']['name'];
    $nameLength=strlen($musicName);
    $musicNameR=substr($musicName,0,$nameLength-4);
    // 创建歌词文件
    $musicFile=fopen("musicLrc/".$musicNameR.".lrc","w");
    // 写入
    fwrite($musicFile, $_POST['edit_lyric']);
    fclose($musicFile);

    // 上传音乐文件

    if ($_FILES["file_upload"]["error"] > 0)
    {
        echo "错误：: " . $_FILES["file_upload"]["error"] . "<br>";
    }
else{
        if (file_exists("music/".$_FILES["file_upload"]["name"]))
        {
            echo $_FILES["file_upload"]["name"]." 文件已经存在。 ";
        }
        else
        {
            // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
            move_uploaded_file($_FILES["file_upload"]["tmp_name"], "music/".$_FILES["file_upload"]["name"]);
        }
    }

  }
?>
