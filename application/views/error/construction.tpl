{extends file="frontsite-layout.tpl"}
	{block name="nav"}
        {nav}
            <div class="actionbar">
                <div class="actionbar__brand">
                    {a uri="/"}{resimg data-image="logo.png"}{/a}
                </div>            
                {form class="actionbar__search-form" name="search" action='search/movie/'}
                    {field field="search"}{/field}
                    {field field="column_id"}{/field}
                    {label class="submit"}
                        {submit value="搜索"}
                    {/label}
                {/form}
                <div class="actionbar__back">
                	{a uri="/"}<i class="fa fa-chevron-left"></i>{/a}
                    <a class="button">{$column_name}</a>
                </div>
                <div class="actionbar__switch">
                	{a uri="movie/top/{$column_id}" class="switch__recommendation"}{lang}推荐{/lang}{/a}
                	{a uri="movie/sift/{$column_id}" class="switch__filter active"}{lang}筛选{/lang}{/a}
                </div>
                <div class="actionbar__search">
	                {a uri="movie/hot" class="button"}<i class="fa fa-search"></i>{/a}
                </div>
            </div>
			{navigation id="menu" class="menu" actions=$actions}{/navigation}            
        {/nav}
	{/block}
	{block name="content"}
		<main>
			<div class="error-bgc">
			</div>
			<div class="error-section">
				<div class="message">
					<h3 class="message__title">正在建设中</h3>
					<p class="message__content">UNDER CONSTRUCTION</p>
				</div>			
				{a href="" class="button"}返回首页{/a}
			</div>
		</main>
	{/block}