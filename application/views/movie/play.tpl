{extends file="bootstrap-layout.tpl"}
	{block name="main"}
		{nav}
            <div class="actionbar">
                <div class="actionbar__brand">
                    {resimg data-image="logo.png"}
                </div>            
                {form class="actionbar__search-form" name="search"}
                    {field field="search"}{/field}
                    {label class="submit"}
                        {submit value="搜索"}
                    {/label}
                {/form}
                <div class="actionbar__back">
                	<i class="fa fa-chevron-left"></i>
                    <a href="" class="button">电影</a>
                </div>               
            </div>
        {/nav}	
        <main>
        	<div class="videoplayer">
        		<div class="videoplayer__body">
			        {video src="{$movie->playUrl}"}
			        {if ($movie->assetClass == 'series' ) }
        			<div class="videoplayer__list" >
        				<h3>剧集</h3>
        				<ul>
				        <li>1</li>
				        <li>2</li>
				        <li>3</li>
				        <li>4</li>
				        <li>5</li>
				        <li>6</li>
				        <li>7</li>
				        <li>8</li>
				        <li>9</li>
				        <li>10</li>
				        </ul>
			        </div>
			        {/if}
        		</div>
        	</div>
	        {div class="tab"}
	            {swiper class="tab__nav"}
	                {swiper__wrapper items=$tab['navs']}
	                    {literal}
	                        {swiper__slide}{a href="http://www.baidu.com"}{$item}{/a}{/swiper__slide}
	                    {/literal}                    
	                {/swiper__wrapper}
	            {/swiper}
	            {swiper class="tab__thumbs"}
	                {swiper__wrapper items=$tab['navs']}
	                    {literal}
	                        {swiper__slide}{/swiper__slide}
	                    {/literal}
	                {/swiper__wrapper}            
	            {/swiper}
	            {swiper class="tab__content"}
	                {swiper__wrapper}
	                    {swiper__slide}1{/swiper__slide}
	                    {swiper__slide}2{/swiper__slide}
	                {/swiper__wrapper}                        
	            {/swiper}
	        {/div}
			<div class="movie-infos">
		        <div class="movie-info summary">
		        	<div class="movie-info__header">
		        		<h3>简介</h3>
		        	</div>
		        	<div class="movie-info__body">
						<h3 class="movie-info__title">{$movie->asset_name}</h3>
						<dl class="movie-info__des">
							<dt>主演</dt>
							<dd>{$movie->actors}</dd>
							<dt>导演</dt>
							<dd>{$movie->director}</dd>
							<dt>简介</dt>	
							<dd>{$movie->summary_short}</dd>
						</dl>
		        	</div>
		        </div>
		        <div class="movie-info guess">
		        	<div class="movie-info__header">
		        		<h3>猜你喜欢</h3>
		        	</div>
		        	<div class="movie-info__body">
				        {foreach $sames as $v}
	                    <figure class="movie">
	                        {resimg data-image=$v->sourceurl class="movie__thumb"}
	                        <figcaption class="movie__title">{$v->asset_name}</figcaption>
	                        <div class="movie__views">
	                            <div class="count-number">
	                                <div class="count-number__icon"></div>
	                                <div class="count-number__text">{$v->record}</div>
	                            </div>
	                        </div>
	                    </figure>
						{/foreach}
		        	</div>
		        </div>					
			</div>        
        </main>
	{/block}