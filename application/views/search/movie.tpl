{extends file="frontsite-layout.tpl"}
    {block name="nav"}
        {nav}
            <div class="actionbar">
                <div class="actionbar__brand">
	                {a uri="/"}{resimg data-image="logo.png"}{/a}
                </div>
                {form class="actionbar__search-form" name="search" action='search/movie/'}
                    {field field="search"}
                        {input}
                        <i class="fa fa-times" remove-input-val-trigger="#field_search"></i>
                    {/field}
                    {field field="column_id"}{/field}
                    {label class="submit"}
                        {submit value="搜索"}
                    {/label}
                {/form}
            </div>
            {navigation id="menu" class="menu" actions=$actions}{/navigation}
        {/nav}
    {/block}
    {block name="content"}
        <main class="result">
            <section class="search-result">
                <div class="search-result__header">
                    <h3>搜索结果</h3>
                </div>
                <div class="movies">
                    {sect class="types"}
                        <div class="movie-filter">
                            <div class="list">
                                <a href="" class="title">排序</a>
                                <a href="" class="hot active">最热</a>
                                <a href="" class="new">最新</a>
                            </div>
                        </div>
                        <div class="movie-classfication"></div>
                        {navigation id="movietypes" class="movietypes" actions=$sifts}{/navigation}
                    {/sect}
                    <div class="areas">
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
	                                    {foreach $movies as $v}
                                           <figure class="movie">
                                            {resimg data-image=$v->poster_normal class="mobile__thumb"}
                                            <div class="movie__info">
                                                <figcaption class="movie__title title">{$v->asset_name}</figcaption>
                                                <div class="movie__des">
                                                    <dl>
                                                        <dt>别名</dt>
                                                        <dd>{$v->asset_name}</dd>
                                                        <dt>地区</dt>
                                                        <dd>{$v->area}</dd>
                                                        <dt>类型</dt>
                                                        <dd>{$v->program_type_name}</dd>
                                                        <dt>简介</dt>
                                                        <dd>{$v->summary_short}</dd>
                                                    </dl>
                                                </div>
                                                <div class="movie__control">
                                                    {a uri="/movie/play/{$v->id}" class="button"}播放{/a}
                                                </div>
                                            </div>
                                        </figure>
	                                    {/foreach}
                                    {/swiper__slide}
                                {/swiper__wrapper}
                            {/swiper}
                        {/div}
                    </div>
                </div>
            </section>
            <section class="search-classfication">
                <div class="search-classfication__header">
                    <h3>热门搜索</h3>
                </div>
                <ul class="search-classfication__hotvideos">
                    <li>sdasdas</li>
                    <li>sadsads</li>
                    <li>sadasdssdsdsdsdsdsdsdsdsssdsdsdsdsds</li>
                    <li>sadsads</li>
                </ul>
            </section>
        </main>
	{/block}