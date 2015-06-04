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
                    <a href="" class="button">电影</a>
                </div>
            </div>
            {navigation id="menu" class="menu" actions=$actions}{/navigation}
        {/nav}
	{/block}
	{block name="content"}
        <main>
        	<div class="videoplayer">
        		<div class="videoplayer__body">
			        {video src="{$movie->playUrl}"}
			        <div class="video-button-text">现在播放</div>
			        {if ($movie->show_type == 'Serise' ) }
        			<div class="videoplayer__list" >
        				<h3>{lang}Episode{/lang}</h3>
        				<ul>
		                {foreach $seriesList as $v}
			                <li class="{$v['active']}">{a uri="/movie/play/{$v['titleID']}"}{$v['episode']}{/a}</li>
				        {/foreach}
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
	                    {swiper__slide}
					        <div class="movie-infomation summary">
					        	<div class="movie-infomation__header">
					        		<h3>{lang}Synopsis{/lang}</h3>
					        	</div>
					        	<div class="movie-infomation__body">
									<h3 class="movie-infomation__title">神奇蜘蛛侠</h3>
									<dl class="movie-infomation__des">
										<dt>{lang}Protagonist{/lang}</dt>
										<dd>不知道</dd>
										<dt>{lang}Directors{/lang}</dt>
										<dd>不知道</dd>
										<dt>{lang}Synopsis{/lang}</dt>
										<dd>不知道</dd>
									</dl>
					        	</div>
					        </div>
	                    {/swiper__slide}
	                    {swiper__slide}
		        			<div class="videolist">		        			
		        				<ul>
						        	<li><a href="">1</a></li>
						        	<li><a href="">2</a></li>
						        	<li><a href="">3</a></li>
						        	<li><a href="">4</a></li>
						        	<li><a href="">5</a></li>
						        	<li><a href="">6</a></li>
						        	<li><a href="">7</a></li>
						        	<li><a href="">8</a></li>
						        	<li><a href="">9</a></li>
						        	<li><a href="">10</a></li>
		        				</ul>
		        			</div>
	                    {/swiper__slide}
	                    {swiper__slide}
	                    	<div class="movies">
								{for $i=1 to 10}
				                    <figure class="movie">
				                        {resimg data-image="test/01.png" class="movie__thumb"}
				                        <figcaption class="movie__title">title</figcaption>
				                        <div class="movie__views">
				                            <div class="count-number">
				                                <div class="count-number__icon"></div>
				                                <div class="count-number__text">152万</div>
				                            </div>
				                        </div>
				                    </figure>
								{/for}
	                    	</div>
	                    {/swiper__slide}
	                {/swiper__wrapper}
	            {/swiper}
	        {/div}
			<div class="movie-infos">
		        <div class="movie-info summary">
		        	<div class="movie-info__header">
		        		<h3>{lang}Synopsis{/lang}</h3>
		        	</div>
		        	<div class="movie-info__body">
						<h3 class="movie-info__title">{$movie->asset_name}</h3>
						<dl class="movie-info__des">
							<dt>{lang}Protagonist{/lang}</dt>
							<dd>{$movie->actors}</dd>
							<dt>{lang}Directors{/lang}</dt>
							<dd>{$movie->director}</dd>
							<dt>{lang}Synopsis{/lang}</dt>
							<dd>{$movie->summary_short}</dd>
						</dl>
		        	</div>
		        </div>
		        <div class="movie-info guess">
		        	<div class="movie-info__header">
		        		<h3>{lang}Guess you like{/lang}</h3>
		        	</div>
		        	<div class="movie-info__body">
				        {foreach $sames as $v}
	                    <figure class="movie">
		                    {a uri="movie/play/{$v->id}"}
	                        {resimg data-image=$v->sourceurl class="movie__thumb"}
		                    {/a}
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
