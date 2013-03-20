{include file='header' pageTitle='wcf.acp.menu.link.faker.user'}

<script type="text/javascript">
//<![CDATA[
	$(function() {
		WCF.TabMenu.init();
	});
//]]>
</script>

<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.acp.menu.link.faker.user{/lang}</h1>
	</hgroup>
</header>

<div class="tabMenuContainer">
	<nav class="tabMenu">
		<ul>
			<li><a href="{@$__wcf->getAnchor('user')}">{lang}wcf.acp.faker.user{/lang}</a></li>
			
			{event name='tabMenuTabs'}
		</ul>
	</nav>
	
	<div id="user" class="container containerPadding tabMenuContent">
		<script type="text/javascript">
		//<![CDATA[
			$(function() {
				$('#fakeUsers').click(function () {
					var $groupIDs = [];
					$('input[name="userGroupIDs[]"]:checked').each(function(index, element) {
						$groupIDs.push($(element).val());
					});
					
					new WCF.ACP.Worker('faker', 'wcf\\system\\worker\\FakerWorker', '{lang}wcf.acp.faker.faking.user{/lang}', {
						amount: $('#userAmount').val(),
						groupIDs: $groupIDs,
						faker: 'wcf\\system\\faker\\UserFaker',
						language: 'de_DE', // todo
						proceedController: 'UserFaker'
					});
				});
			});
		//]]>
		</script>
		
		<fieldset>
			<legend>{lang}wcf.global.form.data{/lang}</legend>
			
			<dl>
				<dt><label for="userAmount">{lang}wcf.acp.faker.amount{/lang}</label></dt>
				<dd><input type="number" id="userAmount" name="userAmount" class="small" min="1" value="10" /></dd>
			</dl>
			
			<dl>
				<dt><label for="userGroupIDs">{lang}wcf.acp.faker.user.userGroups{/lang}</label></dt>
				<dd>
					{htmlCheckboxes options=$userGroups name='userGroupIDs' id='userGroupIDs'}
					<small>{lang}wcf.acp.faker.user.userGroups.description{/lang}</small>
				</dd>
			</dl>
		</fieldset>
		
		<div class="formSubmit">
			<button id="fakeUsers" class="buttonPrimary" accesskey="s">{lang}wcf.acp.faker.button.user{/lang}</button>
		</div>
	</div>
	
	{event name='tabMenuContent'}
</div>

{include file='footer'}