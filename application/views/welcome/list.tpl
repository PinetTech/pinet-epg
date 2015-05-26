{extends file="base-layout.tpl"}
	{block name="main"}
		<main class="movielist">
			{sect class="types"}请选择
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
		</main>
	{/block}