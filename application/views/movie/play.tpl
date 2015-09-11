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
                {a uri="{$returnColumn->url}"}<i class="fa fa-chevron-left"></i>{/a}
                {a class="button"}{$movie->asset_name}{/a}
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
                {if ($movie->show_type == 'Series' ) }
                    <div class="videoplayer__list" >
                        <h3>{lang}剧集{/lang}</h3>
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
        {swiper__wrapper items=$tab}
        {literal}
            {swiper__slide}{a href="http://www.pinet.co"}{$item}{/a}{/swiper__slide}
        {/literal}
        {/swiper__wrapper}
        {/swiper}
        {swiper class="tab__thumbs"}
        {swiper__wrapper items=$tab}
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
                    <h3>{lang}简介{/lang}</h3>
                </div>
                <div class="movie-infomation__body">
                    <h3 class="movie-info__title">{$movie->asset_name}</h3>
                    <dl class="movie-info__des">
                        <dt>{lang}主演{/lang}</dt>
                        <dd>{$movie->actors}</dd>
                        <dt>{lang}导演{/lang}</dt>
                        <dd>{$movie->director}</dd>
                        <dt>{lang}简介{/lang}</dt>
                        <dd>{$movie->summary_short}</dd>
                    </dl>
                </div>
            </div>
        {/swiper__slide}
        {swiper__slide}
            <div class="videolist">
                <ul>
                    {if !$seriesList}
                        <li class="active">{a uri="/movie/play/{$column_id}"}1{/a}</li>
                    {else}
                        {foreach $seriesList as $v}
                            <li class="{$v['active']}">{a uri="/movie/play/{$v['titleID']}"}{$v['episode']}{/a}</li>
                        {/foreach}
                    {/if}
                </ul>
            </div>
        {/swiper__slide}
        {swiper__slide}
            <div class="movies">
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
        {/swiper__slide}
        {/swiper__wrapper}
        {/swiper}
        {/div}
        <div class="movie-infos">
            <div class="movie-info summary">
                <div class="movie-info__header">
                    <h3>{lang}简介{/lang}</h3>
                </div>
                <div class="movie-info__body">
                    <h3 class="movie-info__title">{$movie->title}</h3>
                    <dl class="movie-info__des">
                        <dt>{lang}主演{/lang}</dt>
                        <dd>{$movie->actors}</dd>
                        <dt>{lang}导演{/lang}</dt>
                        <dd>{$movie->director}</dd>
                        <dt>{lang}简介{/lang}</dt>
                        <dd>{$movie->summary_short}</dd>
                    </dl>
                </div>
            </div>
            <div class="movie-info guess">
                <div class="movie-info__header">
                    <h3>{lang}猜你喜欢{/lang}</h3>
                </div>
                <div class="movie-info__body">
                    {foreach $sames as $v}
                        <figure class="movie">
                            {a uri="movie/play/{$v->id}"}
                            {resimg data-image=$v->poster_normal class="movie__thumb"}
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