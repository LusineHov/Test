$(document).ready(
	function(){

			var img_full_div_top=$(".image_full_div").position().top;
			var img_full_div_left=$(".image_full_div").position().left;
			var newimg = $(".new_image");			

			$("#crop_tool").css("top",5).css("left",5);
			$("#crop_tool").resizable({containment: newimg});
			$("#crop_tool").draggable({containment: newimg});
			$("#crop_btn").click(
					function(){
						var img_full_div_top = parseInt($(".image_full_div").position().top);
						var img_full_div_left = parseInt($(".image_full_div").position().left);
						var crop_tool_top = parseInt($("#crop_tool").position().top);
						var crop_tool_left = parseInt($("#crop_tool").position().left);
						console.log(crop_tool_top);
						img_full_div_left.toFixed();
						img_full_div_top.toFixed();
						//crop_tool_left.toFixed();
						//crop_tool_top.toFixed();

						var crop_start_x = crop_tool_left;
						var crop_start_y = crop_tool_top;


						var crop_tool_width = parseInt($("#crop_tool").width());
						var crop_tool_height = parseInt($("#crop_tool").height());

						//crop_tool_width.toFixed();
						//crop_tool_height.toFixed();

						var img_name = $("#crop_btn").attr("img_name");
						var newimgwdt = $(".new_image").width();
						var newimghgt = $(".new_image").height();

						$.post("crop.php",{img_name: img_name, newimgwdt: newimgwdt, newimghgt: newimghgt, crop_start_x: crop_start_x, crop_start_y: crop_start_y,
						 crop_tool_width: crop_tool_width, crop_tool_height: crop_tool_height},function(img_name){
							alert("Image has been cropped successfully, if you don`t like press on Cansel!");
						});
					}

				)
	}
)