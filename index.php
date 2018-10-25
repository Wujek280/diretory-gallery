
<!DOCTYPE html>
<html>
<head>
	<title></title>

	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->

	<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" > -->

	<script
  src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<style type="text/css">
	
	#app thead, #app_length{
		display: none;
	}
	#app{
		margin: auto auto;
		margin-top:50px !important;
	}
	.dataTables_paginate{
		position: fixed;
		bottom: 10px;
		left:50%;
		transform:translateX(-50%);
	}
	.dataTables_paginate .paginate_button{
		padding: 14px;
		background-color: #f0f0f0;
		cursor: pointer;
		text-decoration: none;
		font-family: Arial !important;

	}
	.dataTables_paginate .paginate_button.disabled{
		opacity: 0.7}
	.dataTables_paginate .paginate_button.current{
		text-decoration: underline;}


</style>
</head>
<body>

	<?php
	
	$image_list = array_values(
	 	array_filter(
	 		scandir('C:\xampp\htdocs\img\min'),
	 		function($filename){ 
	 			return preg_match('/.bmp$/',
		 $filename);}));
	//--    --//
	$image_list_nested = [];
	$img_per_row = 1; $count = 0; $row = 0;
	//--nest--//
	foreach($image_list as $image_no => $image_filename){
		if($count === ($img_per_row)){$count = 0; $row++;}
		if($count === 0) $image_list_nested[$row] = [];
		//
		array_push($image_list_nested[$row], $image_filename);
		//
		$count++;
	}
	//--fill out empties--//
	while (sizeof(end($image_list_nested)) < $img_per_row ) {
		array_push($image_list_nested[$row], []);
	}

	//
	echo "<script> window.cols = " . json_encode($image_list_nested) . ";</script>";
	//
	?>

	<table id=app>
		<tbody></tbody>
	</table>

	<script type="text/javascript">
		$(function(){

			let renderCell = function(filename){
				if(!filename.length) return ''
				let origin = 'http://localhost/img' 
				return `<td><img src="${origin}/min/${filename}" data-full="${origin}/max/${filename}"></td>`
			}

			let columns = (function(){
				let ans = []
				window.cols[0].map( (x,i) => ans.push({data:i}))
				return ans
			})()

			var tab = $("#app").DataTable({
				dom:'pl',
				data:window.cols,
				columns:columns,
				lengthMenu:[[2],[2]],
				rowCallback:function(row, data){
					return $(row).html( data.map(renderCell) )
				},
				drawCallback:function(){
					console.log( $("#app img") )
					//--implement gallery--//
				}
			});
		})
	</script>
</body>
</html>
