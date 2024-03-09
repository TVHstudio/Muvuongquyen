<!DOCTYPE html>
<html>
<head>
<body class="full">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>GM Mu Legend H5</title>  
  <link rel="stylesheet" type="text/css" href="layui/css/layui.css" />
  <style>
    body {
      background-image: url('/login/cqlb/img/bg4.jpg');
      background-size: cover;
      background-position: center;
      font-family: 'Tahoma', sans-serif;
      margin: 0;
      padding: 0;
      overflow: hidden;
    }

    .layui-container {
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      padding: 20px;
      margin-top: 20px;
    }

    .layui-nav {
      background-color: transparent;
    }

    .layui-nav-item {
      color: #009688;
    }

    .layui-elem-field {
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      padding: 20px;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="layui-container">
    <ul class="layui-nav layui-bg-black" lay-bar="disabled">
      <li style="margin:0 auto" class="layui-nav-item"><img style="width:160px" src="icon.png"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GM Mu Legend H5 RAGEZONE bigpatreon<span class="layui-badge">New</span></li>
    </ul></br>
    <fieldset class="layui-elem-field">
  <legend>Deposit System - [GM CODE] bigpatreon</legend>
  <div class="layui-field-box layui-form layui-form-pane">
  <!--[if IE]>
  <div><font color='red'>本工具不支持IE,请更换其他浏览器</font></div>
  <![endif]-->
    <div class="layui-form-item">
        <label class="layui-form-label">GM CODE:</label>
		<div class="layui-input-block">
		<input type='password' class="layui-input" value='' id='checknum'> 
		</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">Server</label>
		<div class="layui-input-block">
			<select id='qu' class="layui-input">
			<option value="1">S1</option>
			<option value="2">S2</option>
			<option value="3">S3</option>
			<option value="4">S4</option>
			<option value="5">S5</option>
			<option value="6">S6</option>
			</select>
		</div>
    </div>
    <div class="layui-form-item">
        <label for="username" class="layui-form-label">Account</label>
		<div class="layui-input-block">
        <input type="text" class="layui-input"  id="uid" value='' >
        </div>
    </div>
  <div class="layui-btn-container">  
<div class="layui-row layui-col-space10">
 <div class="layui-col-md3">
      <button type="button" id="addvipbtn"  class="layui-btn layui-btn-fluid layui-btn-danger layui-btn-lg">add VIP</button>
  </div> 
 <div class="layui-col-md3">  
  <button type="button" id="unsetvipbtn"  class="layui-btn layui-btn-fluid layui-bg-cyan layui-btn-lg">Cancel VIP</button>
  </div> 
 <!--div class="layui-col-md3">
      <button type="button" value="Cấm nói" id="jybtn" class="layui-btn layui-btn-fluid layui-btn-danger layui-btn-lg">Cấm nhân vật (Tên nhân vật)</button>
  </div> 
 <div class="layui-col-md3">  
  <button type="button" value="解禁" id="jfbtn" class="layui-btn layui-btn-fluid layui-bg-cyan layui-btn-lg">取消禁言(角色名字)</button>
  </div-->   
  </div> 
 <!--浮云QQ363707305--> 
 </div>     
 <!--浮云QQ363707305--> 
  <div class="layui-form-item">
    <label class="layui-form-label">Diamond</label>
    <div class="layui-input-block">
		<input type="text" class="layui-input" id="chargenum"  value="" >
        </div>
  </div>
 <div class="layui-btn-container">    
        <button type="button" class="layui-btn layui-btn-fluid layui-btn-normal layui-btn-lg" id="chargebtn" value="充值">Recharge</button><br>
</div>
</div>
</fieldset>  
 <!--浮云QQ363707305-->  
<fieldset class="layui-elem-field">
  <legend>Mail Delivery System</legend>
  <div class="layui-field-box layui-form layui-form-pane">
  <div class="layui-form-item">
    <label class="layui-form-label">Select</label>
    <div class="layui-input-block">
     <select id="mailid" lay-verify="" lay-search>
	   <option value=''>Select items or keywords to search automatically</option>
         <?php
         $file = fopen("item.txt", "r");
         while(!feof($file))
        {
        $line=fgets($file);
        $txts=explode(';',$line);
        echo '<option value="'.$txts[0].'">'.$txts[1].'</option>';
        }
        fclose($file);
        ?>
	</select>
	</div>
 </div>
			
		<div class="layui-form-item">
            <label for="num" class="layui-form-label">Amount</label>
		    <div class="layui-input-block">	
		<input type="text" class="layui-input" id="mailnum" value=""><br>
        </div>
		 <div class="layui-btn-container">
			<button type="button" class="layui-btn layui-btn-fluid layui-btn-lg" id="mailbtn" value="发送邮件">Send mail</button>

         </div>
         			<!--input type="button" id='allmailbtn' class="layui-btn layui-btn-fluid layui-btn-danger layui-btn-lg" value='Gửi toàn máy chủ'-->

 </div>
  </div>
 <!--浮云QQ363707305-->

  </fieldset>  
<fieldset class="layui-elem-field">
  <legend>Gift packaging system</legend>
<div class="layui-field-box"> 
<div class="layui-btn-container">
<style>
    .layui-btn-container {
        text-align: center;
        margin-top: 20px;
    }

    .layui-btn {
        width: 250px;
        height: 40px;
        font-size: 16px;
        margin: 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s, border 0.3s;
    }

    .layui-btn:hover {
        background-color: #009688;
        color: white;
        border: 1px solid #009688;
    }
</style>
     <input type="button" id='tc10' class="layui-btn layui-btn-fluid layui-btn-normal layui-btn-lg" value='Package 3 $'>
     <input type="button" id='tc50' class="layui-btn layui-btn-fluid layui-btn-normal layui-btn-lg" value='Package 9 $'>
     <input type="button" id='tc100' class="layui-btn layui-btn-fluid layui-btn-normal layui-btn-lg" value='Package 15 $'>
     <input type="button" id='tc200' class="layui-btn layui-btn-fluid layui-btn-normal layui-btn-lg" value='Package 30 $'>
     <input type="button" id='tc300' class="layui-btn layui-btn-fluid layui-btn-normal layui-btn-lg" value='Package 70 $'>
     <input type="button" id='tc400' class="layui-btn layui-btn-fluid layui-btn-normal layui-btn-lg" value='Package 100 $'>

</div>  
</div>
</fieldset>
<script src='jquery-1.7.2.min.js'></script>
<script>
  var checknum='';
  var uid='';
  var qu=$('#qu').val();
  $('#checknum').change(function(){
	  checknum=$(this).val();
  });
  $('#uid').change(function(){
	  uid=$.trim($(this).val());
  });
  $('#qu').change(function(){
	  qu=$.trim($(this).val());
  });
  $('#addvipbtn').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The role name cannot be empty.');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'addvip',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
  $('#unsetvipbtn').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The role name cannot be empty.');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'unsetvip',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
  $('#zhfhbtn').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The account cannot be empty.');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'zhfh',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
  $('#fhbtn').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The role name cannot be empty.');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'fh',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
  $('#zhjfbtn').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The role name cannot be empty.');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'zhjf',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
  $('#jfbtn').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The role name cannot be empty.');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'jf',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
  $('#jybtn').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The role name cannot be empty.');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'jy',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
  $('#jjbtn').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The role name cannot be empty.');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'jj',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
  $('#tc10').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The account cannot be empty.');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'tc10',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
  $('#tc50').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The account cannot be empty.');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'tc50',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
  $('#tc100').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The account cannot be empty.');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'tc100',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
  $('#tc200').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The account cannot be empty.');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'tc200',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
  $('#tc300').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The account cannot be empty.');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'tc300',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
  $('#tc400').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The account cannot be empty.');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'tc400',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
  $('#tc500').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The account cannot be empty.');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'tc500',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
  $('#tc1000').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The account cannot be empty.');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'tc1000',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
  $('#chargebtn').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The role name cannot be empty.');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  var chargenum=$('#chargenum').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'charge',checknum:checknum,uid:uid,num:chargenum,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
     $('#allmailbtn').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  var itemid=$('#mailid').val();
	  if(itemid=='' || itemid=='0'){
		  alert('Please select an item.');
		  return false;
	  }
	  var mailnum=$('#mailnum').val();
	  if(mailnum=='' || isNaN(mailnum)){
		  alert('Quantity cannot be left blank.');
		  return false;
	  }
	  if(mailnum<1 || mailnum>9999999999){
		  alert('Quantity Range: 1-9999999999。');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'allmail',checknum:checknum,uid:uid,item:itemid,num:mailnum,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });	  
  });
 
  $('#mailbtn').click(function(){
	  if(checknum==''){
		  alert('Please enter the GM verification code.');
		  return false;
	  }
	  if(uid==''){
		  alert('The role name cannot be empty.');
		  return false;
	  }
	  var itemid=$('#mailid').val();
	  if(itemid=='' || itemid=='0'){
		  alert('Please select an item.');
		  return false;
	  }
	  var mailnum=$('#mailnum').val();
	  if(mailnum=='' || isNaN(mailnum)){
		  alert('Quantity cannot be left blank.');
		  return false;
	  }
	  if(mailnum<1 || mailnum>9999999999){
		  alert('Quantity Range: 1-9999999999。');
		  return false;
	  }
	  var qu=$('#qu').val();
	  var uid=$('#uid').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'mail',checknum:checknum,uid:uid,item:itemid,num:mailnum,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });	  
  });
  $('#searchipt').on('change',function(){
	  var keyword=$(this).val();
	  $.ajax({
		  url:'itemquery.php',
		  type:'post',
		  'data':{keyword:keyword},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  if(data){
				  $('#mailid').html('');
				for (var i in data){
				  $('#mailid').append('<option value="'+data[i].key+'" data-desc="'+data[i].desc+'">'+data[i].val+'</option>');
				}
			  }else{
				  $('#mailid').html('<option value="0" data-desc="未找到">未找到</option>');
			  }
			  $('#maildesc').html('Please choose');
		  },
		  error:function(){
			  alert('System failure');
		  }
	  });
  });
  $('#mailid').live('change',function(){
	  console.log('test');
	  var desc=$('#mailid option:selected').data('desc');
	  $('#maildesc').html(desc);
  });
</script>
<script src="layui/layui.js"></script>

</div> 
</body>
 <!--浮云QQ363707305-->
</html>
