<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="{{asset('plugin/layui/css/layui.css')}}" media="all" />
		<link rel="stylesheet" href="{{asset('static/css/main.css')}}" />
        <link href="http://cdn.bootcss.com/animate.css/3.0.0/animate.min.css" rel="stylesheet">
	</head>
	<body>
		<div class="admin-main animated fadeInUp">
			<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
				<legend>服务器配置</legend>
			</fieldset>
			<table class="layui-table">
				<colgroup>
					<col width="50">
					<col width="150">
					<col width="50">
					<col width="150">
				</colgroup>
				<tbody>
					<tr>
						<td>服务器域名</td>
						<td colspan="3">
							{{$_SERVER['SERVER_NAME']}}
						</td>
					</tr>
				<tr>
					<td>服务器标识</td>
					<td colspan="3">{{strtolower(substr(PHP_OS, 0, 3))=='win'?'windows':'linux'}}</td>
				</tr>
				<tr>
					<td>服务器操作系统</td>
					<td><?php $os = explode(" ", php_uname());?>
						{{$os[0]}}
						&nbsp;内核版本：
						@if('/'==DIRECTORY_SEPARATOR)
							{{$os[1]}}

						@else
							{{$os[1]}}
						@endif
					</td>
					<td>服务器解译引擎</td>
					<td>{{$_SERVER['SERVER_SOFTWARE']}}</td>
				</tr>
				<tr>
					<td>服务器语言</td>
					<td>{{getenv("HTTP_ACCEPT_LANGUAGE")}}</td>
					<td>服务器端口</td>
					<td>{{$_SERVER['SERVER_PORT']}}</td>
				</tr>
				<tr>
					<td>服务器主机名</td>
					<td>
						@if('/'==DIRECTORY_SEPARATOR)
							{{$os[1]}}
						@else
							{{$os[2]}}
						@endif
					</td>
					<td>绝对路径</td>
					<td>{{$_SERVER['DOCUMENT_ROOT']?str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']):str_replace('\\','/',dirname(__FILE__))}}</td>
				</tr>
				</tbody>
			</table>

			<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
				<legend>PHP相关参数</legend>
			</fieldset>
					<table class="layui-table">
						<colgroup>
							<col width="50">
							<col width="150">
							<col width="50">
							<col width="150">
						</colgroup>
						<tbody>
						<tr>
							<td>php版本</td>
							<td>{{PHP_VERSION}}</td>
							<td>ZEND版本</td>
							<td>{{zend_version()}}</td>
						</tr>
						<tr>
							<td>是否支持mysql</td>
							<td>{{function_exists ("mysql_close")?"是":"否"}}</td>
							<td>最大上传限制</td>
							<td>{{ get_cfg_var ("upload_max_filesize") ? get_cfg_var ("upload_max_filesize"):"不允许"}}</td>
						</tr>
						<tr>
					<td>最大执行时间</td>
					<td>{{ get_cfg_var("max_execution_time")."秒 "}}</td>
					<td>系统时间</td>
					<td>{{date("Y-m-d G:i:s")}}</td>
				</tr>
				</tbody>
			</table>
		</div>
	</body>

</html>