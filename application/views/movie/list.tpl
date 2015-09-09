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
                	<i class="fa fa-chevron-left"></i>
                    <a href="" class="button">{lang}电影{/lang}</a>
                </div>
                <div class="actionbar__switch">
                	<a href="" class="switch__recommendation">{lang}Recommend{/lang}</a>
                	<a href="" class="switch__filter active">{lang}Sift{/lang}</a>
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
						{a uri="movie/play/{$item->id}"}{resimg data-image=$item->poster}{/a}
						<h3 class="slide__title">{$item->name}</h3>
						{/swiper__slide}
					{/literal}
				{/swiper__wrapper}
				{swiper__pagination}{/swiper__pagination}
			{/swiper}
			<div class="videos">
				{sect class="types"}
					<div class="movie-filter">
						<div class="list">
							<a href="" class="title">{lang}Sort{/lang}</a>
							<a href="" class="hot active">{lang}Hottest{/lang}</a>
							<a href="" class="new">{lang}Latest{/lang}</a>
						</div>
					</div>
					{navigation id="movietypes" class="movietypes" actions=$sifts}
					{/navigation}
				{/sect}
				{sect class="movies"}
			        {div class="tab"}
			            {swiper class="tab__nav"}
			                {swiper__wrapper items=$tab['navs']}
			                    {literal}
			                        {swiper__slide}{a href={$item['url']}}{lang}{$item['name']}{/lang}{/a}{/swiper__slide}
			                    {/literal}
 			                {/swiper__wrapper}
			            {/swiper}
			            {swiper class="tab__thumbs"}
			                {swiper__wrapper items=$tab['navs']}
                            {literal}
                                {swiper__slide class="{$item['active']}"}{/swiper__slide}
                            {/literal}
			                {/swiper__wrapper}
                        {/swiper}
			            {swiper class="tab__content"}
			                {swiper__wrapper}
			                    {swiper__slide}
				                    {foreach $movies as $v}
					                    <figure class="movie">
						                    {a uri="movie/play/{$v->id}"}
					                        {resimg data-image=$v->poster_normal class="movie__thumb"}
						                    {/a}
					                        <figcaption class="movie__title">{$v->title}</figcaption>
					                        <div class="movie__views">
					                            <div class="count-number">
					                                <div class="count-number__icon"></div>
					                                <div class="count-number__text">{$v->count}</div>
					                            </div>
					                        </div>
					                    </figure>
			                    	{/foreach}
			                    {/swiper__slide}
			                {/swiper__wrapper}
                            <div class="shaft-load">
                                <div class="shaft1"></div>
                                <div class="shaft2"></div>
                                <div class="shaft3"></div>
                                <div class="shaft4"></div>
                                <div class="shaft5"></div>
                                <div class="shaft6"></div>
                                <div class="shaft7"></div>
                                <div class="shaft8"></div>
                                <div class="shaft9"></div>
                                <div class="shaft10"></div>
                            </div>
			            {/swiper}
			        {/div}
				{/sect}
			</div>
		</main>
        {template id="movie-template"}
        {literal}
            <figure class="movie" page="{{page}}">
                <a href="{{url}}">
                    <div data-image="{{sourceurl}}" class="responsive mobile__thumb">
                        <img class="mobile__thumb" src="">
                    </div>
                </a>
                <figcaption class="movie__title">{{asset_name}}</figcaption>
                <div class="movie__views">
                    <div class="count-number">
                        <div class="count-number__icon"></div>
                        <div class="count-number__text">{{count}}</div>
                    </div>
                </div>
            </figure>
        {/literal}
        {/template}
    {/block}
