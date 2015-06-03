{extends file="bootstrap-layout.tpl"}
	{block name="main"}
		{block name="nav"}
	        {nav}
	            <div class="actionbar">
	                <div class="actionbar__brand">
	                    {resimg data-image="logo.png"}
	                </div>
	                {form class="actionbar__search-form" name="search" action='search/movie/'}
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
	        	<div class="site-share">
	        		<div class="site-share__link"></div>
	        		<div class="site-share__link"></div>
	        		<div class="site-share__link"></div>
	        		<div class="site-share__link"></div>
	        	</div>
	            <ul class="site-map">
	                <li><a href="">关于我们</a></li>
	                <li><a href="">网站地图</a></li>
	                <li><a href="">合作伙伴</a></li>
	                <li><a href="">联系我们</a></li>
	                <li><div class="copyright">2015</div></li>
	            </ul>
	        </footer>		
		{/block}
	{/block}