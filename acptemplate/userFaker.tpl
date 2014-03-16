{include file='header' pageTitle='wcf.acp.menu.link.faker.user'}

<script data-relocate="true">
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
			<li><a href="{@$__wcf->getAnchor('wall')}">{lang}wcf.acp.faker.user.wall{/lang}</a></li>
			<li><a href="{@$__wcf->getAnchor('follower')}">{lang}wcf.acp.faker.user.follower{/lang}</a></li>
			
			{event name='tabMenuTabs'}
		</ul>
	</nav>
	
	<div id="user" class="container containerPadding tabMenuContent">
		<script data-relocate="true">
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
						fakerLocale: $('#userFakerLocale').val(),
						proceedController: 'UserFaker',
						userGender: $('#userGender').val(),
						userRandomOldUsername: $('#userRandomOldUsername').is(':checked') ? 1 : 0,
						userRandomAboutMe: $('#userRandomAboutMe').is(':checked') ? 1 : 0,
						userRandomSignature: $('#userRandomSignature').is(':checked') ? 1 : 0,
						userRandomBirthday: $('#userRandomBirthday').is(':checked') ? 1 : 0,
						userRandomHomepage: $('#userRandomHomepage').is(':checked') ? 1 : 0,
						userRandomLocation: $('#userRandomLocation').is(':checked') ? 1 : 0
					});
				});
			});
		//]]>
		</script>
		
		<fieldset>
			<legend>{lang}wcf.global.form.data{/lang}</legend>
			
			<dl>
				<dt><label for="userFakerLocale">{lang}wcf.acp.faker.locale{/lang}</label></dt>
				<dd>
					{htmlOptions options=$availableLocales name='userFakerLocale' id='userFakerLocale'}
					<small>{lang}wcf.acp.faker.locale.description{/lang}</small>
				</dd>
			</dl>
			
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
		
		<fieldset>
			<legend>{lang}wcf.user.option.category.profile{/lang}</legend>
			
			<dl>
				<dd><label><input type="checkbox" id="userRandomOldUsername" /> {lang}wcf.acp.faker.user.oldUsername{/lang}</label></dd>
			</dl>
			
			<dl>
				<dt><label for="userGender">{lang}wcf.user.option.gender{/lang}</label></dt>
				<dd>
					<select name="userGender" id="userGender">
						<option value="0" selected="selected">{lang}wcf.global.noDeclaration{/lang}</option>
						<option value="-1">{lang}wcf.acp.faker.random{/lang}</option>
						<option value="1">{lang}wcf.user.gender.male{/lang}</option>
						<option value="2">{lang}wcf.user.gender.female{/lang}</option>
					</select>
				</dd>
			</dl>
			
			<dl>
				<dd><label><input type="checkbox" id="userRandomAboutMe" /> {lang}wcf.acp.faker.user.aboutMe{/lang}</label></dd>
			</dl>
			
			<dl>
				<dd><label><input type="checkbox" id="userRandomSignature" /> {lang}wcf.acp.faker.user.signature{/lang}</label></dd>
			</dl>
			
			<dl>
				<dd><label><input type="checkbox" id="userRandomBirthday" /> {lang}wcf.acp.faker.user.birthday{/lang}</label></dd>
			</dl>
			
			<dl>
				<dd><label><input type="checkbox" id="userRandomLocation" /> {lang}wcf.acp.faker.user.location{/lang}</label></dd>
			</dl>
			
			<dl>
				<dd><label><input type="checkbox" id="userRandomHomepage" /> {lang}wcf.acp.faker.user.homepage{/lang}</label></dd>
			</dl>
		</fieldset>
		
		<div class="formSubmit">
			<button id="fakeUsers" class="buttonPrimary" accesskey="s">{lang}wcf.acp.faker.button.user{/lang}</button>
		</div>
	</div>
	
	<div id="wall" class="container containerPadding tabMenuContent tabMenuContainer">
		<nav class="menu">
			<ul>
				<li><a href="{@$__wcf->getAnchor('wall-comment')}">{lang}wcf.acp.faker.user.wall.comment{/lang}</a></li>
				<li><a href="{@$__wcf->getAnchor('wall-response')}">{lang}wcf.acp.faker.user.wall.response{/lang}</a></li>
			</ul>
		</nav>
		
		<div id="wall-comment">
			<script data-relocate="true">
			//<![CDATA[
				$(function() {
					$('#fakeWallComments').click(function () {
						new WCF.ACP.Worker('faker', 'wcf\\system\\worker\\FakerWorker', '{lang}wcf.acp.faker.faking.user.wall.comment{/lang}', {
							amount: $('#wallCommentAmount').val(),
							faker: 'wcf\\system\\faker\\WallFaker',
							fakerLocale: $('#wallFakerLocale').val(),
							proceedController: 'UserFaker'
						});
					});
				});
			//]]>
			</script>
			
			<fieldset>
				<legend>{lang}wcf.global.form.data{/lang}</legend>
				
				<dl>
					<dt><label for="wallFakerLocale">{lang}wcf.acp.faker.locale{/lang}</label></dt>
					<dd>
						{htmlOptions options=$availableLocales name='wallFakerLocale' id='wallFakerLocale'}
						<small>{lang}wcf.acp.faker.locale.description{/lang}</small>
					</dd>
				</dl>
				
				<dl>
					<dt><label for="wallCommentAmount">{lang}wcf.acp.faker.amount{/lang}</label></dt>
					<dd><input type="number" id="wallCommentAmount" name="wallCommentAmount" class="small" min="1" value="100" /></dd>
				</dl>
			</fieldset>
			
			<div class="formSubmit">
				<button id="fakeWallComments" class="buttonPrimary" accesskey="s">{lang}wcf.acp.faker.button.user.wall.comment{/lang}</button>
			</div>
		</div>
		
		<div id="wall-response">
			<script data-relocate="true">
			//<![CDATA[
				$(function() {
					$('#fakeWallResponses').click(function () {
						new WCF.ACP.Worker('faker', 'wcf\\system\\worker\\FakerWorker', '{lang}wcf.acp.faker.faking.user.wall.response{/lang}', {
							amount: $('#wallResponseAmount').val(),
							faker: 'wcf\\system\\faker\\WallResponseFaker',
							fakerLocale: $('#wallResponseFakerLocale').val(),
							proceedController: 'UserFaker'
						});
					});
				});
			//]]>
			</script>
			
			<fieldset>
				<legend>{lang}wcf.global.form.data{/lang}</legend>
				
				<dl>
					<dt><label for="wallReponseFakerLocale">{lang}wcf.acp.faker.locale{/lang}</label></dt>
					<dd>
						{htmlOptions options=$availableLocales name='wallResponseFakerLocale' id='wallResponseFakerLocale'}
						<small>{lang}wcf.acp.faker.locale.description{/lang}</small>
					</dd>
				</dl>
				
				<dl>
					<dt><label for="wallResponseAmount">{lang}wcf.acp.faker.amount{/lang}</label></dt>
					<dd><input type="number" id="wallResponseAmount" name="wallResponseAmount" class="small" min="1" value="100" /></dd>
				</dl>
			</fieldset>
			
			<div class="formSubmit">
				<button id="fakeWallResponses" class="buttonPrimary" accesskey="s">{lang}wcf.acp.faker.button.user.wall.response{/lang}</button>
			</div>
		</div>
	</div>
	
	<div id="follower" class="container containerPadding tabMenuContent">
		<script data-relocate="true">
		//<![CDATA[
			$(function() {
				$('#fakeFollower').click(function () {
					new WCF.ACP.Worker('faker', 'wcf\\system\\worker\\FakerWorker', '{lang}wcf.acp.faker.faking.user.follower{/lang}', {
						amount: $('#followerAmount').val(),
						faker: 'wcf\\system\\faker\\UserFollowFaker',
						fakerLocale: 'en_US',
						proceedController: 'UserFaker'
					});
				});
			});
		//]]>
		</script>
		
		<fieldset>
			<legend>{lang}wcf.global.form.data{/lang}</legend>
			
			<dl>
				<dt><label for="followerAmount">{lang}wcf.acp.faker.amount{/lang}</label></dt>
				<dd><input type="number" id="followerAmount" name="followerAmount" class="small" min="1" value="1000" /></dd>
			</dl>
		</fieldset>
		
		<div class="formSubmit">
			<button id="fakeFollower" class="buttonPrimary" accesskey="s">{lang}wcf.acp.faker.button.user.follower{/lang}</button>
		</div>
	</div>
	
	{event name='tabMenuContent'}
</div>

{include file='footer'}
