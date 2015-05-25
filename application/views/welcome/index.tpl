{extends file="base-layout.tpl"}
	{block name="main"}	
        {nav}
            <div class="actionbar">
                <div class="actionbar__brand">
                    brand
                </div>
                {form class="actionbar__search-form" name="search"}
                    {field field="search"}{/field}
                {/form}
                <div class="actionbar__trigger" data-trigger="#menu"></div>
            </div>
            {navigation id="menu" class="menu" actions=$actions}{/navigation}
        {/nav}

        <main class="welcome/index">
            {swiper class="slide"}
                {swiper__wrapper items=$items}
                    {literal}
                        {swiper__slide data-image=$item->image}
                            <h3 class="slide__title">{$item->title}</h3>
                        {/swiper__slide}
                    {/literal}
                {/swiper__wrapper}
                {swiper__pagination}{/swiper__pagination}
            {/swiper}                       
            <section class="movielist film">
                <div class="movielist__head">
                    <h3 class="movielist__title">电影</h3>
                    <a href="#" class="movielist__viewall">查看全部</a>
                </div>
                <div class="movielist__body">
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                </div>
            </section>
            {* section.movielist *}
            <section class="movielist">
                <div class="movielist__head">
                    <h3 class="movielist__title">电影</h3>
                    <a href="#" class="movielist__viewall">查看全部</a>
                </div>
                <div class="movielist__body">
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                </div>
            </section>
            {* section.movielist *}
            <section class="movielist">
                <div class="movielist__head">
                    <h3 class="movielist__title">电影</h3>
                    <a href="#" class="movielist__viewall">查看全部</a>
                </div>
                <div class="movielist__body">
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                </div>
            </section>
            {* section.movielist *}
            <section class="movielist">
                <div class="movielist__head">
                    <h3 class="movielist__title">电影</h3>
                    <a href="#" class="movielist__viewall">查看全部</a>
                </div>
                <div class="movielist__body">
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                    <figure class="movie">
                        <img src="" alt="" class="movie__thumb">
                        <figcaption class="movie__title">movie title</figcaption>
                        <div class="movie__views">
                            <div class="count-number">
                                <div class="count-number__icon"></div>
                                <div class="count-number__text">152.4万</div>
                            </div>
                        </div>
                    </figure>
                </div>
            </section>
            {* section.movielist *}                        
        </main>

	{/block}