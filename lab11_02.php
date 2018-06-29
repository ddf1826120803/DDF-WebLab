<?php
// 获得歌词
  if(isset($_GET['selectMusicLrc'])){
   $fileLrc="musicLrc/".$_GET['selectMusicLrc'].".lrc";
   $content=file_get_contents($fileLrc);
   echo $content; 
  }
  ?>