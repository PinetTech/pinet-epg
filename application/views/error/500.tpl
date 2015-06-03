{extends file="frontsite-layout.tpl"}
	{block name="nav"}
		{nav}
		    <div class="actionbar">
		        <div class="actionbar__brand">
		            {resimg data-image="logo.png"}
		        </div>            
		    </div>			
		{/nav}
	{/block}
	{block name="content"}
		<main>
			<div class="error-message">
				<div class="message">
					<h3 class="message__title">500</h3>
					<p class="message__content">Sorry,再精彩的节目,没有电也看不成啦!</p>
				</div>
			</div>
			<div class="error-section">
				{a href="" class="button"}返回首页{/a}
			</div>
		</main>
	{/block}