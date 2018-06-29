<html>
<head>
<title>LRC ��ʱ༭��</title>
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

<!--��ʱ༭����-->
<section id="s_edit" class="content">
<form id="f_upload" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <p>���ϴ������ļ�</p>

    <!--TODO: �����ﲹ�� html Ԫ�أ�ʹ file_upload �ϴ�����Ϊ�����ļ��������ֱ�Ӳ���-->
    <audio id="myAudio" src="" controls></audio>

    <input type="file" name="file_upload" id="audioFile" onchange="playAudio()">
    <table>
        <tr><td>Title: <input type="text"></td><td>Artist: <input type="text"></td></tr>
        <tr><td colspan="2"><textarea name="edit_lyric" id="edit_lyric"></textarea></td></tr>
        <tr><td><input type="button" value="����ʱ���ǩ" onclick="insertTime()"></td><td><input type="button" value="�滻ʱ���ǩ"></td></tr>
        <tr><td colspan="2" id="td_submit"><input type="submit" name="submit" value="Submit"></td></tr>   
    </table>
</form>
</section>

<!--���չʾ����-->
<section id="s_show" class="content">
    <select onchange="selectMusic()" id="selectMusic">
    <!--TODO: �����ﲹ�� html Ԫ�أ�ʹ�㿪 #d_show ֮������ʵʱ���ط����������еĸ���-->
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
    
    <!--TODO: �����ﲹ�� html Ԫ�أ�ʹѡ���˸���֮������չʾ����������������֧���������л�-->

</section>
</body>
<script>

// ���沿��
document.getElementById("d_edit").onclick = function () {click_tab("edit");};
document.getElementById("d_show").onclick = function () {click_tab("show");};

document.getElementById("d_show").click();

function click_tab(tag) {
    for (let i = 0; i < document.getElementsByClassName("tab").length; i++) document.getElementsByClassName("tab")[i].style.backgroundColor = "transparent";
    for (let i = 0; i < document.getElementsByClassName("content").length; i++) document.getElementsByClassName("content")[i].style.display = "none";

    document.getElementById("s_" + tag).style.display = "block";
    document.getElementById("d_" + tag).style.backgroundColor = "darkgray";
} 

// Edit ����
var edit_lyric_pos = 0;
document.getElementById("edit_lyric").onmouseleave = function () {
    edit_lyric_pos = document.getElementById("edit_lyric").selectionStart;
};

// ��ȡ�����еĳ�ʼλ�á�
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

// ѡ�������С�
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
// ��Ϊ�����ļ�����ֱ�Ӳ���
    function playAudio(){
        var audioFile=document.getElementById('audioFile');
        var audio=document.getElementById('myAudio');
        var url=audioFile.value;
        var index=url.indexOf("fakepath");
        var urlReal=url.substr(index+9);
        audio.src=urlReal;
        }

/* HINT: 
 * �Ѿ�����д����Ѱ��ÿ�п�ͷ��λ�ã�����ʹ�� get_target_pos()
 * ����ȡ��һ��λ�ã��Ӷ�������Ӧ�ĸ��ʱ�䡣
 * �� textarea �У�����ͨ����� DOM �ڵ�� selectionStart ��
 * selectionEnd ��ȡ���Ӧ��λ�á�
 *
 * TODO: ��ʵ����ĸ��ʱ���ǩ����Ч����
 */
// ����ʱ���ǩ
    function insertTime(){
        var getPos=get_target_pos();
        var edit=document.getElementById("edit_lyric");
        var editContent=edit.value;
        var start=editContent.substring(0,getPos);
        var end=editContent.substring(getPos,editContent.length);
        // ��ø�ʽ��ʱ��
         var time=document.getElementById('myAudio').currentTime;
        var timeDate= new Date(parseInt(time*1000));
        var timeGet=dateFtt("mm:ss.S",timeDate);

        var addContent=start+"["+timeGet+"]"+end;
        edit.value=addContent;
    }
    //��ʽ��ʱ��
    function dateFtt(fmt,date){  
      var o = {   
        "M+" : date.getMonth()+1,                 //�·�   
        "d+" : date.getDate(),                    //��   
        "h+" : date.getHours(),                   //Сʱ   
        "m+" : date.getMinutes(),                 //��   
        "s+" : date.getSeconds(),                 //��   
        "q+" : Math.floor((date.getMonth()+3)/3), //����   
        "S"  : date.getMilliseconds()             //����   
      };   
      if(/(y+)/.test(fmt))     
        fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));     
      for(var k in o)     
       if(new RegExp("("+ k +")").test(fmt))     
      fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));     
        return fmt;    
 
}  
// �����б�ѡ���֣���������Ӧ�ĸ��
    function selectMusic(){
        let mySelect = document.getElementById('selectMusic');
        var grade = mySelect.options[mySelect.selectedIndex].value;
       showMusicLrc(grade);
    }
    // ��ȡ���
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
 * ʵ�ָ�ʺ�ʱ���ƥ���ʱ���Ƽ�ʹ�� Map class��ES6 �Դ���
 * �� Map �У�key ��ֵ�������ַ��������ǿ���ͨ���ַ���ֱ�ӱȽϡ�
 * ÿһ���и߿ɴ��Թ���Ϊ 40�����ݵ��Բ��������в�ͬ��
 * ��ǰ������Դ�����ʾ��
 * �ӵڰ��п�ʼ��������ת����һ�е�ʱ����Ҫ������������ʹ�õ�ǰ��
 * �ʱ��������С�
 *
 * TODO: ��ʵ����ĸ�ʹ���Ч����
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
<!-- �ϴ����� -->
 <?php
    // ��������ļ�������
  if(!empty(isset($_POST['submit']))){
    $musicName=$_FILES['file_upload']['name'];
    $nameLength=strlen($musicName);
    $musicNameR=substr($musicName,0,$nameLength-4);
    // ��������ļ�
    $musicFile=fopen("musicLrc/".$musicNameR.".lrc","w");
    // д��
    fwrite($musicFile, $_POST['edit_lyric']);
    fclose($musicFile);

    // �ϴ������ļ�

    if ($_FILES["file_upload"]["error"] > 0)
    {
        echo "����: " . $_FILES["file_upload"]["error"] . "<br>";
    }
else{
        if (file_exists("music/".$_FILES["file_upload"]["name"]))
        {
            echo $_FILES["file_upload"]["name"]." �ļ��Ѿ����ڡ� ";
        }
        else
        {
            // ��� upload Ŀ¼�����ڸ��ļ����ļ��ϴ��� upload Ŀ¼��
            move_uploaded_file($_FILES["file_upload"]["tmp_name"], "music/".$_FILES["file_upload"]["name"]);
        }
    }

  }
?>
