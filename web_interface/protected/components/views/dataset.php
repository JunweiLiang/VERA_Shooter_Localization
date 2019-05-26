<?php 
	/*****************
	@author Leongchunwai<2546858999@qq.com>  
	****************/
?>
<style type="text/css">
	#<?php echo $id;?>{
		width:auto;
		white-space:nowrap;
	}
	#<?php echo $id;?> > div.info{
		text-align:center;
		color:gray;
		font-weight:bold;font-size:1.1em;
		padding:30px 0;
	}
	#<?php echo $id;?> > div.block{
		margin:10px;
		min-width:250px;
		height:100px;
		background-color:white;
		display:inline-block;
		cursor:pointer;
		padding:5px;
		-moz-box-shadow:0 1px 1px #999;              
 	  -webkit-box-shadow:0 1px 1px #999;           
 	   box-shadow:0 1px 1px #999;
 	   border-top:3px none solid;
 	   border-radius:5px;
 	   position:relative;
	}
	#<?php echo $id;?> > div.block > a.showDataset{
		display:none;
		position:absolute;
		bottom:10px;
		right:10px;
	}
	#<?php echo $id;?> > div.block > div.deleteCss{
		display:none
	}
	#<?php echo $id;?> > div.block:hover > a.showDataset,
	#<?php echo $id;?> > div.block:hover > div.deleteCss{
		display:block;
	}
	#<?php echo $id;?> > div.block.toggle{
		border-top:3px orange solid;
		-moz-box-shadow:0 3px 3px #999;              
 	  -webkit-box-shadow:0 3px 3px #999;           
 	   box-shadow:0 3px 3px #999;
	}
	#<?php echo $id;?> > div.block > div{
		padding:5px;
		word-break:break-all;
	}
	#<?php echo $id;?> > div.block > div.datasetName{
		font-weight:bold;
		min-height:20px;
		padding-right:30px;
	}
	#<?php echo $id;?> > div.block > div.datasetNote{
		min-height:20px;
	}
	#<?php echo $id;?> > div.block > div.createTime{
		color:gray;
	}
</style>
<div id="<?php echo $id;?>">
	<input class="userId" type="hidden" value="<?php echo $userId?>"></input>
	<div class="info">No Collection Found</div>

</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#<?php echo $id?> > input.userId").change();
	});
	cw.url = "<?php echo Yii::app()->baseUrl?>/index.php/main/";
	//delete collection
	cw.ec("#<?php echo $id?> > div.block > div.delete",function(e){
		e.stopPropagation();
		if($(this).hasClass("disabled"))
		{
			return;
		}
		var data = {};
		data.datasetId = $(this).parent().children("input.datasetId").val();
		//alert(data.datasetId);
		if(!confirm("Delete This Collection?"))
		{
			return;
		}
		$(this).html("<div class='loading'></div>").removeClass("deleteCss").addClass("disabled");
		cw.post(cw.url+"deleteDataset",data,function(result){
			if(result.status == 0)
			{
				if($(this).hasClass("toggle"))
				{
					$("#<?php echo $id?> > input.userId").change();
				}
				else
				{
					$(this).remove();
				}
			}
		},$(this).parent());
	});
	
	cw.ech("#<?php echo $id?> > input.userId",function(){
		var data = {};
		data.userId = $(this).val();
		$("#<?php echo $id?> > div.block").remove();
		$(this).parent().children("div.info").show().html("<div class='loading'></div>");
		cw.post(cw.url+"getDatasetListMain",data,function(result){
			var clickDatasetId = <?php echo $datasetId?>;
			$("#<?php echo $id?> > div.info").html("No Collection Found");
			if(result.status == 0)
			{
				//result.datasetList = [];
				if(result.datasetList.length > 0)
				{
					$("#<?php echo $id?> > div.info").hide();
					for(var i in result.datasetList)
					{
						var dataset = result.datasetList[i];
						$temp = $('<div class="block">'+
							'<input class="datasetId" type="hidden" value="'+dataset.datasetId+'"></input>'+
							'<input class="latitude" type="hidden" value="'+dataset.latitude+'"></input>'+
							'<input class="longitude" type="hidden" value="'+dataset.longitude+'"></input>'+
							'<input class="radius" type="hidden" value="'+dataset.radius+'"></input>'+
							'<div class="delete close deleteCss">&times;</div>'+
							'<div class="datasetName">'+dataset.datasetname+' ('+dataset.videoNum+' videos)'+
								
							'</div>'+
							'<div class="datasetNote">'+dataset.note+'</div>'+
							'<div class="createTime">'+dataset.createTime+'</div>'+
							'<a class="btn btn-small btn-success showDataset" href="<?php echo Yii::app()->baseUrl?>/index.php/application/cShowDataset?showWorkBoard=1&datasetId='+dataset.datasetId+'" target="_blank">Details</a>'+
						'</div>');
						$("#<?php echo $id?>").append($temp);
					}
					if(clickDatasetId == 0)
					{
						// click the first one
						$("#<?php echo $id?> > div.block").eq(0).trigger(cw.ectype);
					}
					else
					{
						// click that one
						if($("#<?php echo $id?> > div.block > input.datasetId[value='"+clickDatasetId+"']").length !=0)
						{
							var $target = $("#<?php echo $id?> > div.block > input.datasetId[value='"+clickDatasetId+"']").parent();
							$target.trigger(cw.ectype);
							// scroll to it
							<?php if($scrollCall != ""){ ?>
								//console.log($target.position().left);
								$("<?php echo $scrollCall?>").val($target.position().left).change();
							<?php } ?>
						}
						else
						{
							//not found, click the first
							$("#<?php echo $id?> > div.block").eq(0).trigger(cw.ectype);
						}
					}
				}
				
			}
		});
	});
	cw.ec("#<?php echo $id?> > div.block > a.showDataset",function(e){
		e.stopPropagation();
		window.open($(this).prop("href"),"_blank");
	});
	//click a dataset
	cw.ec("#<?php echo $id?> > div.block",function(){
		$("#<?php echo $id?> > div.block").removeClass("toggle");
		$(this).addClass("toggle");
		<?php if($target!=""){ ?>

			var datasetId = $(this).children("input.datasetId").val();
			$("<?php echo $target?>").val(datasetId).change();

		<?php } ?>
	});
</script>