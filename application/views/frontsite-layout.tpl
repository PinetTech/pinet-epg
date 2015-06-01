{extends file="bootstrap-layout.tpl"}
	{block name="main"}
		{block name="nav"}
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
		{/block}
		{block name="content"}
		{/block}
		{block name="footer"}
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
	{/block}