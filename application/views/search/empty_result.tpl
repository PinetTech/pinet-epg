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
        <main class="empty-result">
            <div class="movie-infos">
                <div class="movie-info summary">
                    <div class="movie-info__header">
                        <h3>{lang}搜索结果{/lang}</h3>
                    </div>
                    <div class="movie-info__body">
                        <div class="message">
                            <i class="message__icon">
                                {resimg  data-image="icons/not_found.png"}
                            </i>
                            <p class="message__content"><i>抱歉，</i>没有找到与 “<i class="highlight">您好</i>” 相关的视频结果！</p>
                        </div>
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