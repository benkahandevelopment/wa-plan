    <footer class="footer">
        <div class="container">
            <p class="text-muted" style="float:left;">Copyright&copy; 2015 Ben Kahan.</p>
			<?php if($chatroom){ ?>
				<div id="chatWrap">
					<a href="javascript:void(0);" onClick="chatToggle()" id="openChat" >Chat</a>
					<div id="chatContainer" style="display:none;">
						<div id="menu">
							<?php $chatCode = (isset($_SESSION['chatCode']) ? $_SESSION['chatCode'] : $_SESSION['code']); ?>
							<i class="fa fa-info-circle info_prompt" data-toggle="tooltip_below" data-original-title="Type and press Enter to change/refresh the chat" ></i>&nbsp;
							<input type="text" placeholder="Room name" maxlength="16" value="<?php echo $chatCode; ?>" placeholder="Chat Name" id="chatName" />
							<input type="hidden" id="chatCode" value="<?php echo $chatCode ?>" />
							<i onclick="chatToggle()" class="fa fa-chevron-down minimize"></i>
							<div style="clear:both"></div>
						</div>
						 
						<div id="chatbox">
							<div id="chatContent"><?php
								if(file_exists("sessions/chats/log_".$chatCode.".txt") && filesize("sessions/chats/log_".$chatCode.".txt") > 0){
									$handle = fopen("sessions/chats/log_".$chatCode.".txt", "r");
									$contents = fread($handle, filesize("sessions/chats/log_".$chatCode.".txt"));
									fclose($handle);
									 
									#echo $contents;
								}
							?></div>
							<span id="sending" style="display:none;">Sending...</span>
						</div>
						 
						<form name="message" id="chatSubmit" action="">
							<input name="usermsg" type="text" id="usermsg" autocomplete="off" />
							<input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
							<div style="clear:both;"></div>
						</form>
					</div>
					
					<script type="text/javascript">
						$(document).ready(function(){
							
							$('input#chatName').keypress(function(e){
								if(e.which==13) chatRefresh();
							});
							
							$('form#chatSubmit').submit(function(e){
								var chatCode = $('input#chatName').val();								
								$('#sending').show();
								var newscrollHeight = $("#chatContent").innerHeight();
								$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal');
									
								var clientmsg = $("#usermsg").val();
								var chatName = "<?php echo $_SESSION['code']; ?>";
								var chatData = [clientmsg,chatName,chatCode];
								var jsonChatData = JSON.stringify(chatData);
								$.post("inc/chatpost.php", { text: clientmsg, name: chatName, code: chatCode })
									.done(function(data){
										console.log(data);
									});
								
								$("#usermsg").val('');
								return false;
								e.preventDefault();
							});
							
							setInterval (loadLog, 1000);
							
						});
						
						//Load the file containing the chat log
						function loadLog(){
							$('#sending').hide();
							var chatCode = $('input#chatCode').val();
							var oldscrollHeight = $("#chatContent").innerHeight(); //Scroll			
							var oldNum = $('#chatContent>div').length;
							/*$.ajax({
								url: "sessions/chats/log_"+chatCode+".html",
								cache: false,
								success: function(html){
									//$('#chatContent').html(makePretty(html));
									//console.log(html);
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
										var difference = newNum-oldNum;
										$('a#openChat').html('Chat <span class="badge">'+difference+'</span>');
									}

									//Auto-scroll			
									var newscrollHeight = $("#chatContent").innerHeight(); //Scroll height after the request
									if(newscrollHeight > oldscrollHeight){
										$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
									}
								}
							})*/
														
							$.post('inc/chatretrieve.php', { name: chatCode, num: oldNum } )
								.done(function(data) {
									//console.log(data);
									$('#chatContent').html(data);
									var newNum = $('#chatContent>div').length;
									if(newNum>oldNum&&(!$('#chatContainer').is(':visible')&&oldNum>0||!document.hasFocus()&&oldNum>0)){
										$.titleAlert("New Chat Message", {
											interval: 1200,
											originalTitleInterval: null,
											duration: 0,
											stopOnFocus: true
										});
									}
									if(newNum>oldNum&&!$('#chatContainer').is(':visible')&&oldNum>0){
										var difference = newNum-oldNum;
										$('a#openChat').html('Chat <span class="badge">'+difference+'</span>');
									}

									//Auto-scroll			
									var newscrollHeight = $("#chatContent").innerHeight(); //Scroll height after the request
									if(newscrollHeight > oldscrollHeight){
										$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
									}
								});
						};
						
						function chatRefresh(){
							var chatCode = $('input#chatName').val();
							$('input#chatCode').val(chatCode);
							$.post("inc/chatpost.php", { code: chatCode })
								.done(function(){
									$('#chatContent').empty();
									loadLog();
								});
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