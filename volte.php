<?php
require('./wp-load.php');
?>
<!doctype html>
<html>
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0;user-scalable=yes">
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <title></title>
  <script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
  <script src="https://cdn.rawgit.com/naptha/tesseract.js/0.2.0/dist/tesseract.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
  <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
</head>
  <script>
    $(document).ready(function(){
      if(!('url' in window) && ('webkitURL' in window)){
        window.URL=window.webkitURL;
      }

      $('#url').change(function(e){
        $('#pic').attr('src',URL.createObjectURL(e.target.files[0]));
      });
    });
  </script>
  <style>

     input[type=file] {
      background-color: #ddd;
      /* border: 1px solid #336699; */
      color: #336699;
      width: 100%;
      padding: 20px 10px 20px 10px;
      display: block;
      margin-left: auto;
      margin-right: auto;
      font-weight: 700;
      outline: none;
      font-size:2em;
    }

    .ui.button{
      font-size:2em;
      color:#333;
      padding:20px 10px 20px 10px;
    }
    h1{
      background-color:#55e;
      text-align:center;
      padding:20px 10px;
      font-size:2.1em;
      color:#fff;
    }
    h2{
      //background-color:#55e;
      text-align:center;
      padding:20px 10px;
      font-size:2.1em;
      color:#0ff;
    }
  /*
    .pic{
      -webkit-transform:rotate(90deg);
      -moz-transform:rotate(90deg);
      -o-transform:rotate(90deg);
      -ms-transform:rotate(90deg);
      transform:rotate(90deg);
    } */
  </style>
</head>
<body>
  <br>
   <div class="ui two grid container">
     <div class="sixteen wide column">
      <h1>CSCF SOP/보드이력 조회</h1>
        <input type="file" id="url"  name="camera" capture="camera" accept="image/*;capture=camera">
     </div>
     <div class="sixteen wide ocr column">
        <img id="pic" style="width:100%;height:50%;">
        <!-- <input type="button" id="go_button" value="Run"> -->
        <button class="ui button" style="width:100%;" id="go_button">
          <i class="sync icon"></i>실행하기
        </button><br><br>
        <button class="ui button"  onclick="location.reload();" style="width:100%;">
          <i class="eraser icon"></i>지우기
        </button>
        <div id="ocr_status"></div>
        <div id="ocr_results_title"></div>
        <div id="ocr_results" style="display:block;"></div>

      </div>
   </div>

<script>
  function runOCR(url){
    Tesseract.recognize(url)
    .then(function(result){
      document.getElementById("ocr_results").innerText=result.text;
      if(result.text.indexOf('LDU')!=-1){
        location.href="http://kkong7.cafe24.com/ldu.html";
      }else if(result.text.indexOf('FNV')!=-1){
        location.href="http://kkong7.cafe24.com/fnv.html";
      }else if(result.text.indexOf('FNC')!=-1){
        location.href="http://kkong7.cafe24.com/fnc.html";
      }else if(result.text.indexOf('SB')!=-1){
        location.href="http://kkong7.cafe24.com/sb.html";
      }else if(result.text.indexOf('SM')!=-1){
        location.href="http://kkong7.cafe24.com/sm.html";
      }else if(result.text.indexOf('SCN')!=-1){
        location.href="http://kkong7.cafe24.com/scn.html";
      }else if(result.text.indexOf('SDN')!=-1){
        location.href="http://kkong7.cafe24.com/sdn.html";
      }else if(result.text.indexOf('kko')!=-1){
        alert('공하빈 천재~~');
      }else{
          $('#ocr_results_title').html("<br><br><h2>읽기에 실패하였습니다. 아래 보드 정보를 확인해 주세요</h2>");
          $.get("http://kkong7.cafe24.com/ldu.txt",function(data,status){
            document.getElementById('ocr_results').innerHTML=data;
          });
          $.get("http://kkong7.cafe24.com/fnv.txt",function(data,status){
            $('.sixteen.wide.ocr').append("<div id='ocr_results1'></div>");
            $('#ocr_results1').html(data);
          });
          $.get("http://kkong7.cafe24.com/fnc.txt",function(data,status){
            $('.sixteen.wide.ocr').append("<div id='ocr_results2'></div>");
            $('#ocr_results2').html(data);
          });
          $.get("http://kkong7.cafe24.com/sb.txt",function(data,status){
            $('.sixteen.wide.ocr').append("<div id='ocr_results3'></div>");
            $('#ocr_results3').html(data);
          });
          $.get("http://kkong7.cafe24.com/sm.txt",function(data,status){
            $('.sixteen.wide.ocr').append("<div id='ocr_results4'></div>");
            $('#ocr_results4').html(data);
          });
          $.get("http://kkong7.cafe24.com/scn.txt",function(data,status){
            $('.sixteen.wide.ocr').append("<div id='ocr_results5'></div>");
            $('#ocr_results5').html(data);
          });
      }
    }).progress(function(result){
      document.getElementById('ocr_status')
      .innerText=result['status']+' ('+(result['progress']*100).toFixed(1)+'%)';
    });
  } //runOCR() end;

  $('#go_button').click(function(e){
    var url=$('#pic').attr('src');
       if(!url){
         confirm("이미지 파일을 먼저 등록해 주세요");
       }else{
         runOCR(url);
       }
  });

  // $('#pic').click(function(){
  //   $('#pic').toggleClass("pic");
  // });
</script>
</body>
</html>
