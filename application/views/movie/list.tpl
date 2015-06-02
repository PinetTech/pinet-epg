{extends file="frontsite-layout.tpl"}
	{block name="nav"}
        {nav}
            <div class="actionbar">
                <div class="actionbar__brand">
                    {resimg data-image="logo.png"}
                </div>            
                {form class="actionbar__search-form" name="search" action='search/movie/'}
                    {field field="search"}{/field}
                    {label class="submit"}
                        {submit value="搜索"}
                    {/label}
                {/form}
                <div class="actionbar__back">
                	<i class="fa fa-chevron-left"></i>
                    <a href="" class="button">电影</a>
                </div>
                <div class="actionbar__switch">
                	<a href="" class="switch__recommendation">推荐</a>
                	<a href="" class="switch__filter active">筛选</a>
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
			{swiper class="slide"}
				{swiper__wrapper items=$items}
					{literal}
						{swiper__slide}
						{a uri="movie/play/{$item->id}"}{resimg data-image=$item->sourceurl}{/a}
						<h3 class="slide__title">{$item->asset_name}</h3>
						{/swiper__slide}
					{/literal}
				{/swiper__wrapper}
				{swiper__pagination}{/swiper__pagination}
			{/swiper}
			<div class="videos">		
				{sect class="types"}
					<div class="select">
						<h3 class="select__title">
							您已选择
						</h3>
						<div class="select__choose">
<!-- 							<div class="select__label">美国<i class="fa fa-times"></i></div>
							<div class="select__label">院线<i class="fa fa-times"></i></div>
 -->						</div>
					</div>
					<div class="movie-filter">
						<div class="list">
							<a href="" class="title">排序</a>
							<a href="" class="hot active">最热</a>
							<a href="" class="new">最新</a>
						</div>
					</div>
					{navigation id="movietypes" class="movietypes" actions=$sifts}{/navigation}
				{/sect}				
				{sect class="movies"}
			        {div class="tab"}
			            {swiper class="tab__nav"}
			                {swiper__wrapper items=$tab['navs']}
			                    {literal}
			                        {swiper__slide}{a href={$item['url']}}{$item['name']}{/a}{/swiper__slide}
			                    {/literal}                    
{* 			                    {swiper__slide class="active"}sdss{/swiper__slide}
			                    {swiper__slide}sdsds{/swiper__slide}
 *}			                {/swiper__wrapper}
			            {/swiper}
			            {swiper class="tab__thumbs"}
			                {swiper__wrapper items=$tab['navs']}
			                    {literal}
			                        {swiper__slide}{/swiper__slide}
			                    {/literal}
{* 			                    {swiper__slide class="active"}{/swiper__slide}
			                    {swiper__slide}{/swiper__slide}
 *}			                {/swiper__wrapper}            
			            {/swiper}
			            {swiper class="tab__content"}
			                {swiper__wrapper}
			                    {swiper__slide}
				                    {foreach $movies as $v}
					                    <figure class="movie">
						                    {a uri="movie/play/{$v->id}"}
					                        {resimg data-image=$v->sourceurl class="movie__thumb"}
						                    {/a}
					                        <figcaption class="movie__title">{$v->title}</figcaption>
					                        <div class="movie__views">
					                            <div class="count-number">
					                                <div class="count-number__icon"></div>
					                                <div class="count-number__text">{$v->record}</div>
					                            </div>
					                        </div>
					                    </figure>
			                    	{/foreach}
			                    {/swiper__slide}
			                {/swiper__wrapper}                        
			            {/swiper}
			        {/div}
				{/sect}					
			</div>		
		</main>	
	{/block}
