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
					<h3 class="message__title">404</h3>
					<p class="message__content">Sorry,电视台可能放假,今天没节目看啦!</p>
				</div>
			</div>
			<div class="error-section">
                {form class="error-section__form" name="search" action='search/movie/'}
                    {field field="search"}{/field}
                    {label class="submit"}
                        {submit value="搜索"}
                    {/label}
                {/form}
			</div>
		</main>
	{/block}