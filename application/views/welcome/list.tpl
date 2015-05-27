{extends file="base-layout.tpl"}
	{block name="main"}
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
					{navigation id="movietypes" class="movietypes" actions=$actions}{/navigation}
				{/sect}
				{sect class="movies"}
			        {div class="tab"}
			            {swiper class="tab__nav"}
			                {swiper__wrapper items=$tab['navs']}
			                    {literal}
			                        {swiper__slide}{$item}{/swiper__slide}
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