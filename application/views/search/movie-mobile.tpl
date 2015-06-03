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
                <ul class="search-classfication__hotvideos">
                    <li>sdasdas</li>
                    <li>sadsads</li>
                    <li>sadasdssdsdsdsdsdsdsdsdsssdsdsdsdsds</li>
                    <li>sadsads</li>
                </ul>
            </section>
        </main>       
	{/block}