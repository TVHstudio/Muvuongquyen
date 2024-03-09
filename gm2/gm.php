<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>微传奇GM后台</title>  
  <link rel="stylesheet" type="text/css" href="layui/css/layui.css" />
</head>
<body>
<div class="layui-container">
<ul class="layui-nav layui-bg-blue" lay-bar="disabled">
  <li style="margin:0 auto" class="layui-nav-item"><img style="width:50px" src="icon.png"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;微传奇GM后台<span class="layui-badge">v1.0</span></li>
</ul></br>
<fieldset class="layui-elem-field">
  <legend>充值系统</legend>
  <div class="layui-field-box layui-form layui-form-pane">
  <!--[if IE]>
  <div><font color='red'>本工具不支持IE,请更换其他浏览器</font></div>
  <![endif]-->
    <div class="layui-form-item">
        <label class="layui-form-label">GM校验码</label>
		<div class="layui-input-block">
		<input type='password' class="layui-input" value='' id='checknum'> 
		</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">选择分区</label>
		<div class="layui-input-block">
			<select id='qu' class="layui-input">
			<option value="1">传奇1区</option>
			<option value="2">传奇2区</option>
			<option value="3">传奇3区</option>
			<option value="4">传奇4区</option>
			<option value="5">传奇5区</option>
			<option value="6">传奇6区</option>
			</select>
		</div>
    </div>
    <div class="layui-form-item">
        <label for="username" class="layui-form-label">游戏账号</label>
		<div class="layui-input-block">
        <input type="text" class="layui-input"  id="uid" value='' >
        </div>
    </div>
  <div class="layui-btn-container">  
<div class="layui-row layui-col-space10">
 <div class="layui-col-md3">
      <button type="button" id="addvipbtn"  class="layui-btn layui-btn-fluid layui-btn-danger layui-btn-lg">加入权根</button>
  </div> 
 <div class="layui-col-md3">  
  <button type="button" id="unsetvipbtn"  class="layui-btn layui-btn-fluid layui-bg-cyan layui-btn-lg">取消授权</button>
  </div> 
 <div class="layui-col-md3">
      <button type="button" value="禁言" id="jybtn" class="layui-btn layui-btn-fluid layui-btn-danger layui-btn-lg">角色禁言(角色名字)</button>
  </div> 
 <div class="layui-col-md3">  
  <button type="button" value="解禁" id="jfbtn" class="layui-btn layui-btn-fluid layui-bg-cyan layui-btn-lg">取消禁言(角色名字)</button>
  </div>   
  </div> 
 <!--浮云QQ9851320--> 
 </div>     
 <!--浮云QQ9851320--> 
  <div class="layui-form-item">
    <label class="layui-form-label">充值元宝</label>
    <div class="layui-input-block">
		<input type="text" class="layui-input" id="chargenum"  value="" >
        </div>
  </div>
 <div class="layui-btn-container">    
        <button type="button" class="layui-btn layui-btn-fluid layui-btn-normal layui-btn-lg" id="chargebtn" value="充值">充值</button><br>
</div>
</div>
</fieldset>  
 <!--浮云QQ9851320-->  
<fieldset class="layui-elem-field">
  <legend>邮件系统</legend>
  <div class="layui-field-box layui-form layui-form-pane">
  <div class="layui-form-item">
    <label class="layui-form-label">物品选择</label>
    <div class="layui-input-block">
     <select id="mailid" lay-verify="" lay-search>
	   <option value=''>选择物品或关键字自动搜索</option>
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
            <label for="num" class="layui-form-label">物品数量</label>
		    <div class="layui-input-block">	
		<input type="text" class="layui-input" id="mailnum" value=""><br>
        </div>
		 <div class="layui-btn-container">
			<button type="button" class="layui-btn layui-btn-fluid layui-btn-lg" id="mailbtn" value="发送邮件">发送物品</button>

         </div>
         			<input type="button" id='allmailbtn' class="layui-btn layui-btn-fluid layui-btn-danger layui-btn-lg" value='发送全服邮件'>

 </div>
  </div>
 <!--浮云QQ9851320-->

  </fieldset>  
<fieldset class="layui-elem-field">
  <legend>套餐系统</legend>
<div class="layui-field-box"> 
<div class="layui-btn-container">
     <input type="button" id='tc10' class="layui-btn layui-btn-fluid layui-btn-normal layui-btn-lg" value='100元套餐'>
     <input type="button" id='tc50' class="layui-btn layui-btn-fluid layui-btn-normal layui-btn-lg" value='300元套餐'>
     <input type="button" id='tc100' class="layui-btn layui-btn-fluid layui-btn-normal layui-btn-lg" value='500元套餐'>
     <input type="button" id='tc200' class="layui-btn layui-btn-fluid layui-btn-normal layui-btn-lg" value='1000元套餐'>
     <input type="button" id='tc300' class="layui-btn layui-btn-fluid layui-btn-normal layui-btn-lg" value='2000元套餐'>
     <input type="button" id='tc400' class="layui-btn layui-btn-fluid layui-btn-normal layui-btn-lg" value='3000元套餐'>
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
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
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
			  alert('操作失败');
		  }
	  });
  });
  $('#unsetvipbtn').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
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
			  alert('操作失败');
		  }
	  });
  });
  $('#zhfhbtn').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('账号不能为空。');
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
			  alert('操作失败');
		  }
	  });
  });
  $('#fhbtn').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
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
			  alert('操作失败');
		  }
	  });
  });
  $('#zhjfbtn').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
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
			  alert('操作失败');
		  }
	  });
  });
  $('#jfbtn').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
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
			  alert('操作失败');
		  }
	  });
  });
  $('#jybtn').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
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
			  alert('操作失败');
		  }
	  });
  });
  $('#jjbtn').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
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
			  alert('操作失败');
		  }
	  });
  });
  $('#tc10').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('账号不能为空。');
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
			  alert('操作失败');
		  }
	  });
  });
  $('#tc50').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('账号不能为空。');
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
			  alert('操作失败');
		  }
	  });
  });
  $('#tc100').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('账号不能为空。');
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
			  alert('操作失败');
		  }
	  });
  });
  $('#tc200').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('账号不能为空。');
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
			  alert('操作失败');
		  }
	  });
  });
  $('#tc300').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('账号不能为空。');
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
			  alert('操作失败');
		  }
	  });
  });
  $('#tc400').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('账号不能为空。');
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
			  alert('操作失败');
		  }
	  });
  });
  $('#tc500').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('账号不能为空。');
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
			  alert('操作失败');
		  }
	  });
  });
  $('#tc1000').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('账号不能为空。');
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
			  alert('操作失败');
		  }
	  });
  });
  $('#chargebtn').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
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
			  alert('操作失败');
		  }
	  });
  });
     $('#allmailbtn').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  var itemid=$('#mailid').val();
	  if(itemid=='' || itemid=='0'){
		  alert('请选择物品。');
		  return false;
	  }
	  var mailnum=$('#mailnum').val();
	  if(mailnum=='' || isNaN(mailnum)){
		  alert('数量不能为空。');
		  return false;
	  }
	  if(mailnum<1 || mailnum>9999999999){
		  alert('数量范围:1-9999999999。');
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
			  alert('操作失败');
		  }
	  });	  
  });
 
  $('#mailbtn').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }
	  var itemid=$('#mailid').val();
	  if(itemid=='' || itemid=='0'){
		  alert('请选择物品。');
		  return false;
	  }
	  var mailnum=$('#mailnum').val();
	  if(mailnum=='' || isNaN(mailnum)){
		  alert('数量不能为空。');
		  return false;
	  }
	  if(mailnum<1 || mailnum>9999999999){
		  alert('数量范围:1-9999999999。');
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
			  alert('操作失败');
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
			  $('#maildesc').html('请选择');
		  },
		  error:function(){
			  alert('操作失败');
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
 <!--浮云QQ9851320-->
</html>
