{include file='header' pageTitle='wcf.acp.menu.link.faker.tags'}

<script data-relocate="true" type="text/javascript">
//<![CDATA[
	$(function() {
		WCF.TabMenu.init();
	});
//]]>
</script>

<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.acp.menu.link.faker.tags{/lang}</h1>
	</hgroup>
</header>

<div class="tabMenuContainer">
	<nav class="tabMenu">
		<ul>
			<li><a href="{@$__wcf->getAnchor('tags')}">{lang}wcf.acp.faker.tags{/lang}</a></li>
			<li><a href="{@$__wcf->getAnchor('synonyms')}">{lang}wcf.acp.faker.tags.synonyms{/lang}</a></li>
			
			{event name='tabMenuTabs'}
		</ul>
	</nav>
	
	<div id="tags" class="container containerPadding tabMenuContent">
		<script data-relocate="true" type="text/javascript">
		//<![CDATA[
			$(function() {
				$('#fakeTags').click(function () {
					new WCF.ACP.Worker('faker', 'wcf\\system\\worker\\FakerWorker', '{lang}wcf.acp.faker.faking.tags{/lang}', {
						amount: $('#tagAmount').val(),
						faker: 'wcf\\system\\faker\\TagFaker',
						fakerLocale: $('#tagFakerLocale').val(),
						proceedController: 'TagFaker',
						multiWordChance: $('#multiWordChance').val(),
						multiWordCountMin: $('#multiWordCountMin').val(),
						multiWordCountMax: $('#multiWordCountMax').val()
					});
				});
			});
		//]]>
		</script>
		
		<fieldset>
			<legend>{lang}wcf.global.form.data{/lang}</legend>
			
			<dl>
				<dt><label for="tagFakerLocale">{lang}wcf.acp.faker.locale{/lang}</label></dt>
				<dd>
					{htmlOptions options=$availableLocales name='tagFakerLocale' id='tagFakerLocale'}
					<small>{lang}wcf.acp.faker.locale.description{/lang}</small>
				</dd>
			</dl>
			
			<dl>
				<dt><label for="tagAmount">{lang}wcf.acp.faker.amount{/lang}</label></dt>
				<dd>
					<input type="number" id="tagAmount" name="tagAmount" class="small" min="1" value="100" />
				</dd>
			</dl>
			
			<dl>
				<dt><label for="multiWordChance">{lang}wcf.acp.faker.tags.multipleWords.chance{/lang}</label></dt>
				<dd>
					<input type="number" id="multiWordChance" name="multiWordChance" class="small" min="0" value="10" />
					<small>{lang}wcf.acp.faker.tags.multipleWords.chance.description{/lang}</small>
				</dd>
			</dl>
			
			<dl>
				<dt><label for="multiWordCountMin">{lang}wcf.acp.faker.tags.multipleWords.count{/lang}</label></dt>
				<dd>
					<input type="number" id="multiWordCountMin" name="multiWordCountMin" class="small" min="2" max="10" value="2" />
					<input type="number" id="multiWordCountMax" name="multiWordCountMax" class="small" min="3" max="10" value="5" />
					<small>{lang}wcf.acp.faker.tags.multipleWords.count.description{/lang}</small>
				</dd>
			</dl>
		</fieldset>

		<div class="formSubmit">
			<button id="fakeTags" class="buttonPrimary" accesskey="s">{lang}wcf.acp.faker.button.tags{/lang}</button>
		</div>
	</div>
	
	<div id="synonyms" class="container containerPadding tabMenuContent">
		<script data-relocate="true" type="text/javascript">
		//<![CDATA[
			$(function() {
				$('#fakeSynonyms').click(function () {
					new WCF.ACP.Worker('faker', 'wcf\\system\\worker\\FakerWorker', '{lang}wcf.acp.faker.faking.tags.synonyms{/lang}', {
						amount: $('#synonymsAmount').val(),
						faker: 'wcf\\system\\faker\\TagsSynonymsFaker',
						fakerLocale: 'en_US',
						proceedController: 'TagFaker'
					});
				});
			});
		//]]>
		</script>
		
		<fieldset>
			<legend>{lang}wcf.global.form.data{/lang}</legend>
			
			<dl>
				<dt><label for="synonymsAmount">{lang}wcf.acp.faker.amount{/lang}</label></dt>
				<dd>
					<input type="number" id="synonymsAmount" name="synonymsAmount" class="small" min="1" value="100" />
				</dd>
			</dl>
		</fieldset>

		<div class="formSubmit">
			<button id="fakeSynonyms" class="buttonPrimary" accesskey="s">{lang}wcf.acp.faker.button.tags.synonyms{/lang}</button>
		</div>
	</div>
</div>

{include file='footer'}
