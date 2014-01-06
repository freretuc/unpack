<?php
	if(!isset($_POST['content']) || $_POST['content'] == '') {
?>	
<html>
<head>
	<style>
		*{margin:0;padding:0}
		body{font-family:"Trebuchet MS"; padding: 20px;}
		h2 {padding-bottom: 20px;}
	</style>
	
</head>
<body>
<h2>function(p,a,c,k,e,r)</h2>
<form action="" method="post">
<p><textarea name="content" style="width: 100%; height:80%; font-family: monospace;">eval(function(p,a,c,k,e,r){e=String;if(!''.replace(/^/,String)){while(c--)r[c]=k[c]||c;k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('0(\'1 2!\');',3,3,'alert|Hello|world'.split('|'),0,{}))</textarea></p>
<p style="line-height:60px;"><input type="submit" value="unpack" />&nbsp;</p>
</form>
</body>
</html>
<?php		
	} else {
	
	header('Content-Type: text/html; charset=UTF-8');
	
	echo '<pre>';

	include_once('function.unpack.php');
	include_once('function.indent.php');
	
	$str = unpacker($_POST['content']);
	echo_packer($str);
	
}
