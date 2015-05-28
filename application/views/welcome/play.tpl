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
        		{video src="{$movie->playUrl}" height="400" width="600"}
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
	        <div class="movie-info">
	        	<div class="movie-info__header">
	        		简介
	        	</div>
	        	<div class="movie-info__body">
					<h3>神奇蜘蛛侠</h3>	        		
					<dl>
						<dt>导演</dt>
					</dl>
	        	</div>
	        </div>
	        <div class="movie-info">
	        	<div class="movie-info__header">
	        		猜你喜欢
	        	</div>
	        	<div class="movie-info__body">
                    <figure class="movie">
                        {resimg data-image=$value->imageSrc class="movie__thumb"}
                        <figcaption class="movie__title">{$value->title}</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">{$value->count}</div>
                            </div>
                        </div>
                    </figure>	        		
	        	</div>
	        </div>	        
        </main>
	{/block}