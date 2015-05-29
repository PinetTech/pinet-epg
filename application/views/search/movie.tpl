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
            </div>
        {/nav}	
        <main class="result">
            <section class="search-result">
                <div class="search-result__header">
                    <h3>搜索结果</h3>
                </div>
                <div class="movies">
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
                                            {resimg data-image=$v->sourceurl class="mobile__thumb"}
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
                                                    <a href={$v->url} class="button">play</a>
                                                </div>                            
                                            </div>
                                        </figure>
	                                    {/foreach}
                                    {/swiper__slide}
                                    {swiper__slide}2{/swiper__slide}
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