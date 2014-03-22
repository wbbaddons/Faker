{include file='header' pageTitle='wcf.acp.menu.link.faker.likes'}

<script data-relocate="true">
//<![CDATA[
	$(function() {
		WCF.TabMenu.init();
	});
//]]>
</script>

<header class="boxHeadline">
	<h1>{lang}wcf.acp.menu.link.faker.likes{/lang}</h1>
</header>

<div class="tabMenuContainer">
	<nav class="tabMenu">
		<ul>
			<li><a href="{@$__wcf->getAnchor('comments')}">{lang}wcf.acp.faker.likes.comments{/lang}</a></li>
			
			{event name='tabMenuTabs'}
		</ul>
	</nav>
	
	<div id="comments" class="container containerPadding tabMenuContent">
		<script data-relocate="true">
		//<![CDATA[
			$(function() {
				$('#fakeComments').click(function () {
					var $objectTypeIDs = [];
					$('input[name="commentObjectTypeIDs[]"]:checked').each(function(index, element) {
						$objectTypeIDs.push($(element).val());
					});
					
					new WCF.ACP.Worker('faker', 'wcf\\system\\worker\\FakerWorker', '{lang}wcf.acp.faker.faking.likes.comments{/lang}', {
						amount: $('#commentAmount').val(),
						faker: 'wcf\\system\\faker\\CommentLikeFaker',
						fakerLocale: 'en_US',
						proceedController: 'LikeFaker',
						objectTypeIDs: $objectTypeIDs,
						likeValue: $('input:radio[name="commentLikeValue"]:checked').val()
					});
				});
			});
		//]]>
		</script>
		
		<fieldset>
			<legend>{lang}wcf.global.form.data{/lang}</legend>
			
			<dl>
				<dt><label for="commentAmount">{lang}wcf.acp.faker.amount{/lang}</label></dt>
				<dd>
					<input type="number" id="commentAmount" name="commentAmount" class="small" min="1" value="100" />
				</dd>
			</dl>
			
			<dl>
				<dt><label for="commentLikeValue">{lang}wcf.acp.faker.likes.value{/lang}</label></dt>
				<dd>
					<label><input name="commentLikeValue" type="radio" value="+" checked="checked" /> <span class="icon icon16 icon-thumbs-up"></span></label>
					<label><input name="commentLikeValue" type="radio" value="+-" /> <span class="icon icon16 icon-thumbs-up"></span> / <span class="icon icon16 icon-thumbs-down"></span></label>
					<label><input name="commentLikeValue" type="radio" value="-" /> <span class="icon icon16 icon-thumbs-down"></span></label>
					
					<small>yadayada</small>
				</dd>
			</dl>
			
			<dl>
				<dt><label for="commentObjectTypeIDs">{lang}wcf.acp.faker.likes.commentObjectTypeIDs{/lang}</label></dt>
				<dd>
					{htmlCheckboxes options=$commentObjectTypeIDs name='commentObjectTypeIDs' id='commentObjectTypeIDs'}
					<small>yadayada</small>
				</dd>
			</dl>
		</fieldset>
		
		<div class="formSubmit">
			<button id="fakeComments" class="buttonPrimary" accesskey="s">{lang}wcf.acp.faker.button.likes.comments{/lang}</button>
		</div>
	</div>
	
	{event name='tabMenuContent'}
</div>

{include file='footer'}
