{extends file="frontsite-layout.tpl"}
    {block name="nav"}
        {nav}
            <div class="actionbar">
                <div class="actionbar__brand">
                    {resimg data-image="logo.png"}
                </div>
	            {form class="actionbar__search-form" name="search" action='search/movie/'}
		            {field field="search"}
                        {input}
                    {/field}
	                {field field="column_id"}{/field}
		            {label class="submit"}
		                {submit value="搜索"}
		            {/label}
	            {/form}
            </div>
        {/nav}      
    {/block}
    {block name="content"}	
        <main>
            <section class="search-classfication">
                <div class="search-classfication__header">
                    <h3>热门搜索</h3>
                </div>
	            {ul items=$hots class="search-classfication__hotvideos"}
		            {literal}
			            <li>{a uri="search/movie/?search={$item->keyword}"}{$item->keyword}{/a}</li>
		            {/literal}
	            {/ul}
            </section>
        </main>       
	{/block}