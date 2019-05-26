<?php 
	/*****************
	@author Chun Wai Leong<2546858999@qq.com>  in 2014.1
	****************/
?>
<?php
	//此widget封装了一个modal的对话框，外界只要调用 #id > input.userId change事件，就可以modal显示，然后获取本用户与此userId的对话
										//同时也要填充#id > input.userName
	class ModalChatWidget extends CWidget
	{
		public $id="modalChat";
		public function run()
		{?>
		<style type="text/css">
			#<?php echo $this->id;?> > div.modal-body > #chat > div.say > textarea.chatText{
	width:400px;
}
#<?php echo $this->id;?> > div.modal-body > #chat > div.chatMain{
	height:300px;
	overflow:auto;
	background-color:rgb(245,245,245);
	padding:10px;
}
#<?php echo $this->id;?> > div.modal-body > #chat > div.chatMain > div.block{
	text-align:left;
	margin-bottom:20px;
	line-height:25px;
}
#<?php echo $this->id;?> > div.modal-body > #chat > div.chatMain > div.block.me{text-align:right}
#<?php echo $this->id;?> > div.modal-body > #chat > div.chatMain > div.block > div.line{
	background-color:white;
	display:inline;padding:2px 20px;
}
		</style>
		<script type="text/javascript">
	//绑定modal
	$(document).delegate("#<?php echo $this->id;?> > input.userId","change",function(){
		//载入信息
		$("#<?php echo $this->id;?> > div.modal-body > #chat > input.userId").val($(this).val());
		$("#<?php echo $this->id;?> > div.modal-body > #chat > input.userId").change();
		$("#<?php echo $this->id;?> > div.modal-header > h3 > span.withUserName").html($(this).parent().children("input.userName").val());
		$(this).parent().modal("show");
	});
</script>
		<div class="modal hide fade chat" id="<?php echo $this->id;?>"><!--to set the modal in the center,margin-left should be (-)half its width-->
			<input class="userId" type="hidden" value=""></input>
			<input class="userName" type="hidden" value=""></input>
			<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    		<h3 style='line-height:25px'>
	    			与 <span class="withUserName"></span> 的对话
	    		</h3>
			</div>
			<div class='modal-body'>
				<?php
					$this->widget("ChatWidget",array(
						"id" => "chat",
						
					));
				?>
			</div>
			<div class="modal-footer">
    			<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
			</div>
		</div><!--modal-->
	<?php	}
	}
?>