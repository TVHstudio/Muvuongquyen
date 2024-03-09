<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8"); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>王权争霸玩家后台</title>  
  <link rel="stylesheet" type="text/css" href="layui/css/layui.css" />
</head>
<body>
<div class="layui-container">
<ul class="layui-nav layui-bg-blue" lay-bar="disabled">
  <li style="margin:0 auto" class="layui-nav-item"><img style="width:50px" src="icon.png"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;王权争霸玩家后台<span class="layui-badge">v1.0</span></li>
</ul></br>
<fieldset class="layui-elem-field">
  <legend>充值系统</legend>
  <div class="layui-field-box layui-form layui-form-pane">
	<div class="layui-form-item">
        <label class="layui-form-label">选择分区</label>
		<div class="layui-input-block">
			<select id="qu" >
			<option value="1">1区</option>
			<option value="2">2区</option>
			<option value="3">3区</option>
			<option value="4">4区</option>
			<option value="5">5区</option>
			<option value="6">6区</option>
			</select>
		</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">游戏账号</label>
		<div class="layui-input-block">
        <input type="text" class="layui-input"  id="uid"  value="" >
        </div>
    </div>
 <!--浮云QQ9851320--> 

  <div class="layui-form-item">
    <label class="layui-form-label">充值元宝</label>
    <div class="layui-input-block">
		<input type="text" class="layui-input" id="chargenum" value="" >
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

 </div>
  </div>
 <!--浮云QQ9851320-->
 </fieldset>  

<script src='jquery-1.7.2.min.js'></script>
<script>
  var uid='';
  var qu=$('#qu').val();
  $('#uid').change(function(){
	  uid=$.trim($(this).val());
  });
  $('#qu').change(function(){
	  qu=$.trim($(this).val());
  });
  $('#chargebtn').click(function(){
	  if(uid==''){
		  alert('账号不能为空。');
		  return false;
	  }
	  var chargenum=$('#chargenum').val();
	  $.ajax({
		  url:'playerquery.php',
		  type:'post',
		  'data':{type:'charge',uid:uid,num:chargenum,qu:qu},
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
	  if(mailnum<1 || mailnum>999999){
		  alert('数量范围:1-999999。');
		  return false;
	  }
	  $.ajax({
		  url:'playerquery.php',
		  type:'post',
		  'data':{type:'mail',uid:uid,item:itemid,num:mailnum,qu:qu},
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
<script>
layui.use('layer', function(){
  var layer = layui.layer;
  
    layer.open({
		 title: '友情提示',
		 time: 1800,
        content: '<font color="red">必看使用说明</font>：</br>1.需要联系群主授权才可以使用</br>2.使用工具时请保持角色在线</br>3.请少量多次使用，避免爆号！</br>',
        btn: "我知道了"
    })
	  
	  
});  

</script>

</div> 
</body>
 <!--浮 云QQ 9 8 5 13 20-->
</html>
