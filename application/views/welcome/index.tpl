{extends file="base-layout.tpl"}
	{block name="main"}			
		{swiper class="slide"}
			{swiper__wrapper items=$items}
				{literal}
					{swiper__slide data-image=$item->image}
                        <h3 class="slide__title">{$item->title}</h3>
					{/swiper__slide}
				{/literal}
			{/swiper__wrapper}
			{swiper__prevbtn}{/swiper__prevbtn}
			{swiper__nextbtn}{/swiper__nextbtn}
            {swiper__pagination}{/swiper__pagination}
		{/swiper}			

        {swiper__thumbs}
            {swiper__wrapper items=$items}
                {literal}
                    {swiper__slide data-image=$item->image}
                    {/swiper__slide}
                {/literal}
            {/swiper__wrapper}      
        {/swiper__thumbs}

{*     <div class="swiper-container slidecator">
        <div class="swiper-wrapper">
            <div class="swiper-slide">Slide 1</div>
            <div class="swiper-slide">Slide 2</div>
            <div class="swiper-slide">Slide 3</div>
            <div class="swiper-slide">Slide 4</div>
            <div class="swiper-slide">Slide 5</div>
            <div class="swiper-slide">Slide 6</div>
            <div class="swiper-slide">Slide 7</div>
            <div class="swiper-slide">Slide 8</div>
            <div class="swiper-slide">Slide 9</div>
            <div class="swiper-slide">Slide 10</div>
            <div class="swiper-slide">Slide 1</div>
            <div class="swiper-slide">Slide 2</div>
            <div class="swiper-slide">Slide 3</div>
            <div class="swiper-slide">Slide 4</div>
            <div class="swiper-slide">Slide 5</div>
            <div class="swiper-slide">Slide 6</div>
            <div class="swiper-slide">Slide 7</div>
            <div class="swiper-slide">Slide 8</div>
            <div class="swiper-slide">Slide 9</div>
            <div class="swiper-slide">Slide 10</div>            
        </div>
    </div>	 *}	

        <section class="movielist film">
            <div class="movielist__head">
                <h3 class="movielist__title">电影</h3>
                <a href="#" class="movielist__viewall">查看全部</a>
            </div>
            <div class="movielist__body">
                <figure class="movie">
                    <img src="" alt="" class="movie__thumb">
                    <figcaption class="movie__title">movie title</figcaption>
                    <div class="movie__views">views</div>
                </figure>
                <figure class="movie">
                    <img src="" alt="" class="movie__thumb">
                    <figcaption class="movie__title">movie title</figcaption>
                    <div class="movie__views">views</div>
                </figure>
                <figure class="movie">
                    <img src="" alt="" class="movie__thumb">
                    <figcaption class="movie__title">movie title</figcaption>
                    <div class="movie__views">views</div>
                </figure>
                <figure class="movie">
                    <img src="" alt="" class="movie__thumb">
                    <figcaption class="movie__title">movie title</figcaption>
                    <div class="movie__views">views</div>
                </figure>
                <figure class="movie">
                    <img src="" alt="" class="movie__thumb">
                    <figcaption class="movie__title">movie title</figcaption>
                    <div class="movie__views">views</div>
                </figure>
                <figure class="movie">
                    <img src="" alt="" class="movie__thumb">
                    <figcaption class="movie__title">movie title</figcaption>
                    <div class="movie__views">views</div>
                </figure>                                                                                
            </div>
        </section>
	{/block}