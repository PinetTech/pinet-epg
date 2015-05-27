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
            </div>
            {navigation id="menu" class="menu" actions=$actions}{/navigation}
        {/nav}	
        <main>
            <section class="search-result">
                <div class="search-result__title">
                    <h3>搜索结果</h3>
                </div>
                <div>
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
                                <button type="button">play</button>
                            </div>                            
                        </div>
                    </figure>
                </div>
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