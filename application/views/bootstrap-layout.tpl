{extends file="base-layout.tpl"}
	{block name="main"}
		{container}
			{row}
				{column class="navbar" id="navigationbar"}
					{column class="navbar-header"}
						{h3 id="brand"}{context key="app_name"}{/h3}
					{/column}
					{column class="navbar-section"}
						{block name="navbar"}
							{navigationtoolbar class="navbar-nav" json="application/config/navigation"}{/navigationtoolbar}
						{/block}
					{/column}
				{/column}
				{column id="content"}
					{row}
						{column id="quickbar"}
							{row}
								{column}
									{row class="navbar"}
										{column class="navbar-header"}
											{h3}{context key="html_title"}{/h3}
										{/column}
										{column class="navbar-section"}
											{userinfocard class="userinfo" json="application/config/user"}{/userinfocard}
										{/column}
									{/row}
								{/column}
							{/row}
						{/column}
						{column id="toolbar"}
							{block name="toolbar"}{/block}
						{/column}
						{column id="workbench"}
							{row}
								{column}
									{row id="editarea"}
										{block name="workbench"}{/block}
									{/row}
								{/column}
							{/row}
							{block name="subnavi"}
								{row}
									{column}
										{row id="subnavi"}
											{navigationtoolbar class="navbar-nav" subnavi="true" json="application/config/navigation"}{/navigationtoolbar}
										{/row}
									{/column}
								{/row}
							{/block}
						{/column}
					{/row}
				{/column}
			{/row}
		{/container}
	{/block}
