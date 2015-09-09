{html}
    {head}
        <!-- Start Of CSS -->
            {context key='css'}
        <!-- End Of CSS -->

        <!-- Start Of Header -->

        {block name="header"}
            <link type="image/x-icon" href="{uri static=true}application/static/img/favicon.ico{/uri}" rel="shortcut icon">
        {/block}
        <!-- End of Header -->
    {/head}
	{body}
		{block name="head"}{/block}
		<!-- End Of Head -->
		{block name="main"}{/block}
		<!-- End Of Main -->
		{block name="foot"}{/block}
		<!-- End Of Foot -->
		{js}
		<!-- End Of JS -->
	{/body}
{/html}