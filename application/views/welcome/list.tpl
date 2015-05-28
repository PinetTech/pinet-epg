{extends file="base-layout.tpl"}
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
                <div class="actionbar__switch">
                	<a href="" class="switch__recommendation active">推荐</a>
                	<a href="" class="switch__filter">筛选</a>
                </div>
                <div class="actionbar__search">
                    <a href="" class="button"><i class="fa fa-search"></i></a>
                </div>                
            </div>
        {/nav}		
		<main>
			<div class="videos">
				{sect class="types"}
					<div class="select">
						<h3 class="select__title">
							您已选择
						</h3>
						<div class="select__choose">
							<div class="select__label">美国<i class="fa fa-times"></i></div>
							<div class="select__label">院线<i class="fa fa-times"></i></div>
						</div>
					</div>
					<div class="movie-filter">
						<div class="list">
							<a href="" class="title">排序</a>
							<a href="" class="hot">最热</a>
							<a href="" class="new">最新</a>			
						</div>
					</div>
					{navigation id="movietypes" class="movietypes" actions=$actions}{/navigation}
				{/sect}
				{sect class="movies"}
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
				{/sect}					
			</div>		
		</main>
	{/block}