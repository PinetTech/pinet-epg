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
                        {submit}
                    {/label}
                {/form}
                <div class="actionbar__trigger" data-trigger="#menu">
                    <span></span>
                </div>
            </div>
            {navigation id="menu" class="menu" actions=$actions}{/navigation}
        {/nav}

        <main class="welcome/index">
            {swiper class="slide"}
                {swiper__wrapper items=$items}
                    {literal}
                        {swiper__slide data-image=$item->image responsive="true"}
                            <h3 class="slide__title">{$item->title}</h3>
                        {/swiper__slide}
                    {/literal}
                {/swiper__wrapper}
                {swiper__pagination}{/swiper__pagination}
            {/swiper}
	        {foreach $columns as $v}
	            <section class="movielist film">
	                <div class="movielist__head">
	                    <h3 class="movielist__title">{$v['column_name']}</h3>
	                    <a href="#" class="movielist__viewall">查看全部</a>
	                </div>
	                <div class="movielist__body">
	                    {foreach $v['videos'] as $key => $value}
	                        <figure class="movie">
                                {resimg data-image=$value->imageSrc class="movie__thumb"}
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
	            {* section.movielist *}
	        {/foreach}         
        </main>
        <footer>
            <ul class="site-map">
                <li>关于我们</li>
                <li>网站地图</li>
                <li>期刊订阅</li>
                <li>联系我们</li>
                <li>法律声明</li>
                <li>友情链接</li>
                <li>上海工商</li>
                <li>举报中心</li>
            </ul>
            <div class="added-license">增值许可证</div>
            <div class="copy-right">版权</div>
            <div class="technical-support">技术支持 pinet</div>
        </footer>
	{/block}