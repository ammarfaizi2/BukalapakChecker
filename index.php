<!DOCTYPE html>
<html>
<head>
	<title>Checker Bukalapak</title>
	<style type="text/css">
		body {
			font-family: Helvetica;
		}
		.wq {
			display: inline-block;
		}
	</style>
</head>
<body style="background-color: #e8094c;">
	<center>
		<h1>Checker Bukalapak</h1>
	</center>
	<form method="post" action="javascript:void(0);">
		<table>
			<td>
				<div style="padding-left: 20%; background-color: #09c0e5; width: 80.1%;padding-top:3px;padding-bottom: 3px;">
					<p style="font-size:20px;"><strong>Input email &amp; password</strong></p>
				</div>
				<textarea id="credentials" style="resize: none; width: 345px; height: 521px;"></textarea>
			</td>
			<td>
				<div style="padding-left: 15%; background-color: #09c0e5; width: 85.1%;padding-top:3px;padding-bottom: 3px;">
					<p style="font-size:20px;"><strong>Input socks</strong></p>
				</div>
				<textarea id="socks" style="resize: none; width: 150px; height: 521px;"></textarea>
			</td>
			<td>
				<div>
					<button id="go" style="margin-top:-100px;">Check</button>
				</div>
			</td>
		<table>
	</form>
	<script type="text/javascript">
		/**
		 * @author Ammar Faizi <ammarfaizi2@gmail.com>
		 * @license MIT
		 */
		class ContextStream
		{
			constructor()
			{
				this.socks = document.getElementById('socks').value;
				this.credentials = document.getElementById('credentials').value;
				this.ContextStream = null;
			}

			buildContextStream()
			{
				// do it later lah...
			}

			get()
			{
				return this.ContextStream;
			}
		}
		document.getElementById('go').addEventListener("click", function() {
			var context_stream = new ContextStream();
			context_stream.buildContextStream();
			context_stream = context_stream.get();
			if (context_stream !== false) {
				var ch = new XMLHttpRequest();
				ch.onreadystatechange = function() {
					if (this.readystate === 4) {
						//
					}
				};
				ch.open("GET", "controller.php?" + context_stream);
				ch.send(null);
			}
		});
	</script>
</body>
</html>