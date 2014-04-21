{include file='header' pageTitle='wcf.acp.menu.link.faker.conversations'}

<script data-relocate="true">
//<![CDATA[
	$(function() {
		WCF.Language.add('wcf.acp.worker.abort.confirmMessage', '{lang}wcf.acp.worker.abort.confirmMessage{/lang}');
		
		WCF.TabMenu.init();
	});
//]]>
</script>

<header class="boxHeadline">
	<h1>{lang}wcf.acp.menu.link.faker.conversations{/lang}</h1>
</header>

<div class="tabMenuContainer">
	<nav class="tabMenu">
		<ul>
			<li><a href="{@$__wcf->getAnchor('conversations')}">{lang}wcf.acp.faker.conversations{/lang}</a></li>
			<li><a href="{@$__wcf->getAnchor('conversationsParticipants')}">{lang}wcf.acp.faker.conversations.participants{/lang}</a></li>
			<li><a href="{@$__wcf->getAnchor('conversationsMessages')}">{lang}wcf.acp.faker.conversations.messages{/lang}</a></li>
			
			{event name='tabMenuTabs'}
		</ul>
	</nav>
	
	<div id="conversations" class="container containerPadding tabMenuContent">
		{if $userCount > 1}
			<script data-relocate="true">
			//<![CDATA[
				$(function() {
					$('#fakeConversations').click(function () {
						new WCF.ACP.Worker('faker', 'wcf\\system\\worker\\FakerWorker', '{lang}wcf.acp.faker.faking.conversations{/lang}', {
							amount: $('#conversationAmount').val(),
							faker: 'wcf\\system\\faker\\ConversationFaker',
							fakerLocale: $('#conversationFakerLocale').val(),
							proceedController: 'ConversationFaker',
							minParticipants: $('#minParticipants').val(),
							maxParticipants: $('#maxParticipants').val(),
							invisibleParticipantsPercentage: $('#invisibleParticipantsPercentage').val(),
							participantCanInviteChance: $('#participantCanInviteChance').val()
						});
					});
				});
			//]]>
			</script>
			
			<fieldset>
				<legend>{lang}wcf.global.form.data{/lang}</legend>
				
				<dl>
					<dt><label for="conversationFakerLocale">{lang}wcf.acp.faker.locale{/lang}</label></dt>
					<dd>
						{htmlOptions options=$availableLocales name='conversationFakerLocale' id='conversationFakerLocale'}
						<small>{lang}wcf.acp.faker.locale.description{/lang}</small>
					</dd>
				</dl>
				
				<dl>
					<dt><label for="conversationAmount">{lang}wcf.acp.faker.amount{/lang}</label></dt>
					<dd>
						<input type="number" id="conversationAmount" name="conversationAmount" class="small" min="1" value="100" />
					</dd>
				</dl>
				
				<dl>
					<dt><label for="minParticipants">{lang}wcf.acp.faker.conversations.participants{/lang}</label></dt>
					<dd>
						<input type="number" id="minParticipants" name="minParticipants" class="small" min="1" max="10" value="1" />
						<input type="number" id="maxParticipants" name="maxParticipants" class="small" min="1" max="10" value="4" />
						<small>{lang}wcf.acp.faker.conversations.participants.description{/lang}</small>
					</dd>
				</dl>
				
				<dl>
					<dt><label for="invisibleParticipantsPercentage">{lang}wcf.acp.faker.conversations.invisibleParticipantsPercentage{/lang}</label></dt>
					<dd>
						<input type="number" id="invisibleParticipantsPercentage" name="invisibleParticipantsPercentage" class="small" min="0" max="100" value="0" />
						<small>{lang}wcf.acp.faker.conversations.invisibleParticipantsPercentage.description{/lang}</small>
					</dd>
				</dl>
				
				<dl>
					<dt><label for="participantCanInviteChance">{lang}wcf.acp.faker.conversations.participantCanInviteChance{/lang}</label></dt>
					<dd>
						<input type="number" id="participantCanInviteChance" name="participantCanInviteChance" class="small" min="0" max="100" value="20" />
						<small>{lang}wcf.acp.faker.conversations.participantCanInviteChance.description{/lang}</small>
					</dd>
				</dl>
			</fieldset>
			
			<div class="formSubmit">
				<button id="fakeConversations" class="buttonPrimary" accesskey="s">{lang}wcf.acp.faker.button.conversations{/lang}</button>
			</div>
		{else}
			<p class="error">{lang}wcf.acp.faker.error.twoUsersNeeded{/lang}</p>
		{/if}
	</div>
	
	<div id="conversationsParticipants" class="container containerPadding tabMenuContent">
		<p class="error">TODO</p>
	</div>
	
	<div id="conversationsMessages" class="container containerPadding tabMenuContent">
		<p class="error">TODO</p>
	</div>
	{event name='tabMenuContent'}
</div>

{include file='footer'}
