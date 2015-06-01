{extends file="frontsite-layout.tpl"}
    {block name="nav"}
        {nav}
            <div class="actionbar">
                <div class="actionbar__brand">
                    {resimg data-image="logo.png"}
                </div>            
                {form class="actionbar__search-form" name="search" action='search/movie/'}
                    {field field="search"}{/field}
                    {label class="submit"}
                        {submit value="搜索"}
                    {/label}
                {/form}
            </div>
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
                        {navigation id="movietypes" class="movietypes" actions=$actions}{/navigation}
                    {/sect}                 
                    <div class="areas">
                        {div class="tab"}
                            {swiper class="tab__nav"}
                                {swiper__wrapper items=$tab['navs']}
                                    {literal}
                                        {swiper__slide class="active"}{a href="http://www.baidu.com"}{$item}{/a}{/swiper__slide}
                                    {/literal}                    
                                {/swiper__wrapper}
                            {/swiper}
                            {swiper class="tab__thumbs"}
                                {swiper__wrapper items=$tab['navs']}
                                    {literal}
                                        {swiper__slide class="active"}{/swiper__slide}
                                    {/literal}
                                {/swiper__wrapper}            
                            {/swiper}
                            {swiper class="tab__content"}
                                {swiper__wrapper}
                                    {swiper__slide}
                                        {for $i=1 to 3}
                                           <figure class="movie">
                                            {resimg data-image="test/08.png" class="mobile__thumb"}
                                            <div class="movie__info">
                                                <figcaption class="movie__title title">sadsadasds</figcaption>
                                                <div class="movie__des">
                                                    <dl>
                                                        <dt>Name</dt>    
                                                        <dd>Godzilla</dd>
                                                        <dt>Born</dt>
                                                        <dd>1952</dd>
                                                        <dt>Birthplace</dt>
                                                        <dd>Japan</dd>
                                                    </dl>
                                                </div>
                                                <div class="movie__control">
                                                    <a href="" class="button">play</a>
                                                </div>                            
                                            </div>
                                        </figure>
                                        {/for}  
                                    {/swiper__slide}
<!--                                     {swiper__slide}2{/swiper__slide}
                                    {swiper__slide}3{/swiper__slide}
                                    {swiper__slide}4{/swiper__slide}
                                    {swiper__slide}5{/swiper__slide} -->
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
