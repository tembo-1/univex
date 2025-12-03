<div>
    <div class="breadcrumb">
        <ul class="breadcrumb__list breadcrumb__container">
            <li class="breadcrumb__item" style='--icon:url("/img/icons/10.svg")'>
                <span>
                    <a href="{{ route('home') }}">
                        <span>Главная</span>
                    </a>
                </span>
            </li>
            <li class="breadcrumb__item breadcrumb__item--active">
                <span>
                    <span>Новые поступления</span>
                </span>
            </li>
        </ul>
    </div>

    <section class="admission admission--two animate-block">
        <div class='admission__container'>
            <div class="admission__top fade-up" data-watch data-watch-once>
                <h2 class="admission__title block-title">Новые<br>поступления</h2>
                <a href="#" class="admission__link btn btn--blue btn--icon" style='--icon:url("/img/icons/07.svg")'>Подпишитесь</a>
            </div>

            <div class="admission__row fade-up" data-watch data-watch-once>
                @foreach($posts as $post)
                    <a href="{{ route('post', $post->slug) }}" class="admission__column card-product">
                        <div class="card-product__img">
                            <picture>
                                <img data-src="{{ $post->image_url }}"
                                     data-srcset="{{ $post->image_url }} 2x"
                                     src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                                     alt="{{ $post->title }}"
                                     loading="lazy">
                            </picture>
                        </div>
                        <div class="card-product__info">
                            <time datetime="{{ $post->published_at }}" class="card-product__time">
                                {{ $post->published_at }}
                            </time>
                            <div class="card-product__title">{{ $post->title }}</div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Пагинация -->
            <div class="admission__pagination pagination fade-up" data-watch data-watch-once>
                @if($posts->onFirstPage())
                    <span class="pagination__arrow pagination__arrow--hidden" style='--icon:url("/img/icons/08.svg")'></span>
                @else
                    <a href="{{ $posts->previousPageUrl() }}" class="pagination__arrow" style='--icon:url("/img/icons/08.svg")'></a>
                @endif

                <ul class="pagination__list">
                    @foreach($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                        @if($page == $posts->currentPage())
                            <li>
                                <span class="pagination__item _active">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="pagination__item">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>

                @if($posts->hasMorePages())
                    <a href="{{ $posts->nextPageUrl() }}" class="pagination__arrow" style='--icon:url("/img/icons/09.svg")'></a>
                @else
                    <span class="pagination__arrow pagination__arrow--hidden" style='--icon:url("/img/icons/09.svg")'></span>
                @endif
            </div>
        </div>
    </section>
</div>
