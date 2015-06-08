{extends file="bootstrap-layout.tpl"}
	{block name="main"}
		{block name="nav"}
	        {nav}
	            <div class="actionbar">
	                <div class="actionbar__brand">
		                {a uri="/"}{resimg data-image="logo.png"}{/a}
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
	        		<div class="site-share__link">
	        			<a href="http://www.huazhu.com/">
					        <i class="icon"></i>
					        <h3>华住集团</h3>
				        </a>
	        		</div>
	        		<div class="site-share__link">
	        			<a href="http://www.pinet.co/">
					        <i class="icon"></i>
					        <h3>派尔网站</h3>
				        </a>
	        		</div>
	        		<div class="site-share__link">
	        			<a href="http://weibo.com/u/3819705898/">
					        <i class="icon"></i>
					        <h3>派尔微博</h3>
				        </a>
	        		</div>
	        		<div class="site-share__link">
				        <a class="pinet-qr-link">
					        <i class="icon"></i>
					        <h3>派尔公众号</h3>
					        {resimg data-image="pinet-qr.png"}
				        </a>
				        {a class="pinet-qr-link-mobile" uri="welcome/qr"}
					        <i class="icon"></i>
					        <h3>派尔公众号</h3>
				        {/a}
	        		</div>
	        	</div>
	            <ul class="site-map">
	                <li><a href="http://www.pinet.co/">关于我们</a></li>
	                <li><a href="http://www.pinet.co/">网站地图</a></li>
	                <li><a href="http://www.pinet.co/">合作伙伴</a></li>
	                <li><a href="http://www.pinet.co/">联系我们</a></li>
	                <li><div class="copyright">2015<i class="record">备案号</i></div></li>
	            </ul>
	        </footer>		
		{/block}
	{/block}