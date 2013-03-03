{include file='header' pageTitle='wcf.acp.system.faker'}

<script type="text/javascript">
	//<![CDATA[
	$(function() {
		$('#fake').click(function () {
			new WCF.ACP.Worker('faker', 'wcf\\system\\worker\\FakerWorker', '{lang}wcf.acp.system.faker.faking{/lang}', {
				faker: $('#faker').val(),
				amount: $('#amount').val(),
				language: $('#language').val()
			});
		});
	});
	//]]>
</script>

<header class="boxHeadline">
	<hgroup>
		<h1>{lang}wcf.acp.system.faker{/lang}</h1>
	</hgroup>
</header>
<input id="faker" value="\wcf\system\faker\UserFaker" />
<input id="amount" value="455" />
<input id="language" value="de_DE" />

<button id="fake">Start faking</button>

{include file='footer'}