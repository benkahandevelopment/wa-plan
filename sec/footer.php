    <footer class="footer">
        <div class="container">
            <p class="text-muted" style="float:left;">Copyright&copy; 2015 Ben Kahan.</p>
			<?php if($chatroom){ ?>
				<div id="chatWrap">
					<a href="javascript:void(0);" onClick="chatToggle()" id="openChat" >Chat</a>
					<div id="chatContainer" style="display:none;">
						<div id="menu">
							<p class="welcome">Your name is <b><?php echo $_SESSION['code']; ?></b></p>
							<?php 
								$chatCode = (isset($_SESSION['chatCode']) ? $_SESSION['chatCode'] : $_SESSION['code']);
							?>
							<p class="welcome">Room code: <input type="text" maxlength="16" value="<?php echo $chatCode; ?>" placeholder="Chat Name" id="chatName" /><input type="submit" id="refreshChat" value="Refresh" name="refresh" onClick="chatRefresh()" /></p>
							<input type="hidden" id="chatCode" value="<?php echo $chatCode ?>" />
							<div style="clear:both"></div>
						</div>
						 
						<div id="chatbox">
							<div id="chatContent"><?php
								if(file_exists("sessions/chats/log_".$chatCode.".html") && filesize("sessions/chats/log_".$chatCode.".html") > 0){
									$handle = fopen("sessions/chats/log_".$chatCode.".html", "r");
									$contents = fread($handle, filesize("sessions/chats/log_".$chatCode.".html"));
									fclose($handle);
									 
									echo $contents;
								}
							?></div>
						</div>
						 
						<form name="message" id="chatSubmit" action="">
							<input name="usermsg" type="text" id="usermsg" autocomplete="off" />
							<input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
							<div style="clear:both;"></div>
						</form>
					</div>
					
					<script type="text/javascript">
						$(document).ready(function(){
							$('form#chatSubmit').submit(function(e){
								var chatCode = $('input#chatName').val();
								
								
									$('#chatContent').append('<span id="sending">Sending...</span>');
									//Auto-scroll			
									var newscrollHeight = $("#chatContent").innerHeight();
									$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal');
								
								var clientmsg = $("#usermsg").val();
								var chatName = $("#chatName").val();
								$.post("inc/chatpost.php", {text: clientmsg, name: chatName, code: chatCode });
								$("#usermsg").val('');
								return false;
								e.preventDefault();
							});
							
							setInterval (loadLog, 1000);	//Reload file every 2500 ms or x ms if you wish to change the second parameter
							
						});
						
						//Load the file containing the chat log
						function loadLog(){
							var chatCode = $('input#chatCode').val();
							var oldscrollHeight = $("#chatContent").innerHeight(); //Scroll			
							var oldNum = $('#chatContent>div').length;
							$.ajax({
								url: "sessions/chats/log_"+chatCode+".html",
								cache: false,
								success: function(html){
									$("#chatContent").html(html); //Insert chat log into the #chatbox div
									var newNum = $('#chatContent>div').length;
									if(newNum>oldNum&&(!$('#chatContainer').is(':visible')||!document.hasFocus())){
										$.titleAlert("New Chat Message", {
											interval: 1200,
											originalTitleInterval: null,
											duration: 0,
											stopOnFocus: true
										});
									}
									if(newNum>oldNum&&!$('#chatContainer').is(':visible')){
										$('a#openChat').html('Chat (NEW)');
									}
																	
									//Auto-scroll			
									var newscrollHeight = $("#chatContent").innerHeight(); //Scroll height after the request
									if(newscrollHeight > oldscrollHeight){
										$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
									}
								},
							});
						}
						
						function chatRefresh(){
							var chatCode = $('input#chatName').val();
							$('input#chatCode').val(chatCode);
							$.post("inc/chatpost.php", { code: chatCode });
							loadLog();
						}
						
						function chatToggle(){
							$('div#chatContainer').toggle();
							var newscrollHeight = $("#chatContent").innerHeight();
							$("#chatbox").animate({ scrollTop: newscrollHeight }, 10);
							$('a#openChat').html('Chat');
							$('input#usermsg').focus();
						}
					</script>
				</div>
			<?php } ?>
			<div style="clear:both;"></div>
        </div>
    </footer>

</body>

</html>