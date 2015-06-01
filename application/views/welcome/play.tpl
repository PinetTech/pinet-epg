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
            </div>
        {/nav}		
	{/block}
	{block name="content"}
        <main>
        	<div class="videoplayer">
        		<div class="videoplayer__body">
        			<video class="video-js"></video>
        			<div class="videoplayer__list">
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
					        		<h3>简介</h3>
					        	</div>
					        	<div class="movie-infomation__body">
									<h3 class="movie-infomation__title">神奇蜘蛛侠</h3>	        		
									<dl class="movie-infomation__des">
										<dt>主演</dt>
										<dd>不知道</dd>
										<dt>导演</dt>
										<dd>不知道</dd>
										<dt>简介</dt>	
										<dd>不知道</dd>
									</dl>
					        	</div>
					        </div>
	                    {/swiper__slide}
	                    {swiper__slide}
		        			<div class="videolist">
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
		        		<h3>简介</h3>
		        	</div>
		        	<div class="movie-info__body">
						<h3 class="movie-info__title">神奇蜘蛛侠</h3>	        		
						<dl class="movie-info__des">
							<dt>主演</dt>
							<dd>不知道</dd>
							<dt>导演</dt>
							<dd>不知道</dd>
							<dt>简介</dt>	
							<dd>不知道</dd>
						</dl>
		        	</div>
		        </div>
		        <div class="movie-info guess">
		        	<div class="movie-info__header">
		        		<h3>猜你喜欢</h3>
		        	</div>
		        	<div class="movie-info__body">
		        		{for $i=1 to 7}
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
		        </div>					
			</div>        
        </main>	
	{/block}
