<?php
include 'user/config.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title><?php echo $gmbt; ?> GM后台</title>
	<meta name="keywords" content="<?php echo $gmbt; ?> GM后台" />
	<meta name="description" content="<?php echo $gmbt; ?> GM后台" /> 

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>

	<div class="limiter">
		<div class="bg container-login100">
			<div class="wrap-login100">								
				<span class="login100-form-title"><?php echo $gmbt; ?> 授权后台</span>								
      <div class="modal-body">
            <div class="form-group">
                <div class="form-group">
                    <div class="form-group">
  <div><span></span><input type='password' class="form-control" placeholder="输入GM校验码" value='' id='checknum'></div>
  
                        <select id="qu" name="qu" class="form-control selectpicker" data-size="5" title="请选择区服" required>
						<?php
						foreach($quarr as $key=>$value){
							if($value['hidde']!=true){
								echo '<option value="'.$key.'">'.$value['name'].'</option>';
						}
						}
						?>
                        </select>
                    </div>
                </div>
				 <hr/>
  <div><span></span><input type='text' value='' id='uid' class="form-control" placeholder='请输入账号'>
  <input type='text' value='' id='upass' class="form-control" placeholder='请输入授权密码。'>
  <select id="vip" name="vip" class="selectpicker show-tick form-control" data-live-search="true" data-size="5" title="选物品">
								<?php
							  foreach($yzfvip as $k=>$v){
								  echo '<option value="'.$k.'">'.$v.'</option>';
							  }
							  ?>
  </select>  
  <input type='button' class="btn btn-primary btn-block" value='添加授权用户' id='addvipbtn'>
  <input type='button' class="btn btn-primary btn-block" value='修改VIP权限' id='editvip'>
  <input type='button' class="btn btn-primary btn-block" value='修改玩家密码' id='editpwd'>
  <input type='button' class="btn btn-danger btn-block" value='删除玩家权限' id='delvip'>  
  </div>
  <span>权限提醒: </span><span style='color:red'>提示授权成功，玩家登陆无权限，请检查文件夹是否给予777权限！！</span>
  <hr/>
 <div><span></span>
<select id="chargenum" name="chargenum" class="form-control selectpicker" data-size="5" title="请选择金额" required>
<option value="000000000">平台币</option>
<option value="111111111">钻石</option>
</select> 
 <input type='number' id='chargenum1'class="form-control selectpicker"  placeholder='充值数量'>
 
 <input type='button'class="btn btn-danger btn-block"  value='充值' id='chargebtn'></div> 
  <hr/>
 <div><span>充值提醒: </span><span style='color:red'>数量不宜过多,按需求使用，用完再发，发爆号概不负责！！</span><td>
 
 <hr/>
     <div>
  <input type='text' value='' id='searchipt' class="form-control" placeholder='物品搜索'>	 
  <select id="mailid" name="mailid" class="selectpicker show-tick form-control" data-live-search="true" data-size="5" title="选物品">
    <?php
		$file = fopen("user/item_gm.txt", "r");
		while(!feof($file))
		{
			$line=fgets($file);
			$txts=explode(';',$line);
			if(count($txts)==2){
				echo '<option value="'.$txts[0].'">'.$txts[1].'</option>';
			}
		}
		fclose($file);
    ?>
            </select></div>
        <div><span></span><input type='text' value='' id='mailnum' class="form-control"  placeholder='请输入发放数量'></div>
    <div><input type='button'  class="btn btn-primary btn-block"  value='发送物品' id='mailbtn'></div>
 <hr/>
<span>友情提醒: </span><span style='color:red'>发送后背包查看,按需求使用，用完再发，发爆号概不负责！！</span>	
</div>

 <hr/>

 
<select class="form-control selectpicker" id="chargenum2" name="num">
<option value='55' desc=''>角色封号</option>
<option value='66' desc=''>角色解封</option>
<option value='11' desc=''>角色禁言(角色名字)(预留)</option>
<option value='22' desc=''>取消禁言(角色名字)(预留)</option>
 </select>
<input type='button'class="btn btn-primary btn-block"  value='修改属性' id='chargebtn2'></div>

<span>友情提醒: </span><span style='color:red'>封号后重新登陆提示“错误码:249”！！</span>	



<hr/>
<div>
	
</div>

<div class="txt1 text-center">
		<span><?php echo $gmbt; ?> By：WWW.klres.com</span>
</div>
<script src='js/jquery-1.7.2.min.js'></script>
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
	  var upass=$('#upass').val();
	  if(upass==''){
		  alert('请输入授权密码。');
		  return false;
	  }	 
	  var vip=$('#vip').val();
	  if(vip==''){
		  alert('请选择权限。');
		  return false;
	  }	  
	  $.ajax({
		  url:'user/gmquery.php',
		  type:'post',
		  'data':{type:'addvip',checknum:checknum,uid:uid,qu:qu,upass:upass,vip:vip},
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
  $('#editvip').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }
	  var upass=$('#upass').val();
	  if(upass==''){
		  alert('请输入授权密码。');
		  return false;
	  }	 
	  var vip=$('#vip').val();
	  if(vip==''){
		  alert('请选择权限。');
		  return false;
	  }	  
	  $.ajax({
		  url:'user/gmquery.php',
		  type:'post',
		  'data':{type:'editvip',checknum:checknum,uid:uid,qu:qu,upass:upass,vip:vip},
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
   $('#editpwd').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }
	  var upass=$('#upass').val();
	  if(upass==''){
		  alert('请输入授权密码。');
		  return false;
	  }	 
	  var vip=$('#vip').val();
	  if(vip==''){
		  alert('请选择权限。');
		  return false;
	  }	  
	  $.ajax({
		  url:'user/gmquery.php',
		  type:'post',
		  'data':{type:'editpwd',checknum:checknum,uid:uid,qu:qu,upass:upass,vip:vip},
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
 
  $('#delvip').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('请输入需要取消授权的账号。');
		  return false;
	  }
	  var upass=$('#upass').val();
	  if(upass==''){
		  alert('请输入以前授权时候的密码。');
		  return false;
	  }
	  var vip=$('#vip').val();
	  if(vip==''){
		  alert('请选择权限。');
		  return false;
	  }	  
	  $.ajax({
		  url:'user/gmquery.php',
		  type:'post',
		  'data':{type:'delvip',checknum:checknum,uid:uid,qu:qu,upass:upass,vip:vip},
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
	  var chargenum=$('#chargenum').val();
//	  if(chargenum<1 || chargenum>999999){
//		  alert('数量范围:1-999999。');
//		  return false;
//	  }	 
	  var chargenum1=$('#chargenum1').val();
	  if(chargenum1<1 || chargenum1>99999999){
		  alert('数量范围:1-99999999');
		  return false;
	  }	  
	  $.ajax({
		  url:'user/gmquery.php',
		  type:'post',
		  'data':{type:'charge',checknum:checknum,uid:uid,num:chargenum,num2:chargenum1,qu:qu},
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
    $('#chargebtn2').click(function(){
	  if(checknum==''){
		  alert('请输入GM校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }

	  var chargenum2=$('#chargenum2').val();
      var msg = "您真的确定要清理操作吗？\n\n操作后将无法撤销！！！\n\n是否确认继续！！\n\n请确认！";
	  if (confirm(msg)==true){ 	
	  $.ajax({
		  url:'user/gmquery.php',
		  type:'post',
		  'data':{type:'charge2',checknum:checknum,uid:uid,num:chargenum2,qu:qu},
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
	  }else{ 
  	  return false;   
	  //alert('考虑考虑');
 }	  
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
	  if(itemid==''){
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
		  url:'user/gmquery.php',
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
		  url:'user/itemquery.php',
		  type:'post',
		  'data':{keyword:keyword,typea:'item_gm'},  
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
</body>
</html>