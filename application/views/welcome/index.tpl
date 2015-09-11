{extends file="frontsite-layout.tpl"}
    {block name="content"}
        <main class="welcome/index">
            {swiper class="slide"}
                {swiper__wrapper items=$items}
                    {literal}
                        {swiper__slide}
                        {a uri="movie/play/{$item->id}"}{resimg data-image=$item->poster_normal}{/a}
                            <h3 class="slide__title">{$item->asset_name}</h3>
                        {/swiper__slide}
                    {/literal}
                {/swiper__wrapper}
                {swiper__pagination}{/swiper__pagination}
            {/swiper}
            {foreach $columns as $v}
                <section class="movielist film">
                    <div class="movielist__head">
                        <h3 class="movielist__title">{$v->label}</h3>
                        <a href="{$v->url}" class="movielist__viewall">全部</a>
                    </div>
                    <div class="movielist__body">
                        {foreach $v->videos as $key => $value}
                            <figure class="movie">
                                {a uri="movie/play/{$value->id}"}{resimg data-image=$value->poster_normal class="movie__thumb"}{/a}
                                <figcaption class="movie__title">{$value->title}</figcaption>
                                <div class="movie__views">
                                    <div class="count-number">
                                        <div class="count-number__icon"></div>
                                        <div class="count-number__text">{$value->count}</div>
                                    </div>
                                </div>
                            </figure>
                        {/foreach}
                    </div>
                </section>
                 {*section.movielist*}
            {/foreach}
        </main>
    {/block}
