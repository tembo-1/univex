<style>
    .content-reset {
        all: initial;
    }

    .content-reset * {
        all: revert;
    }

    .content-reset table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
    }

    .content-reset th,
    .content-reset td {
        border: 1px solid #ccc;
        padding: 8px;
    }
</style>

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
            <li class="breadcrumb__item" style='--icon:url("/img/icons/10.svg")'>
                <span>
                    <a href="{{ route('posts') }}">
                        <span>Новые поступления</span>
                    </a>
                </span>
            </li>
            <li class="breadcrumb__item breadcrumb__item--active">
                <span>
                    <span>{{ $post->title }}</span>
                </span>
            </li>
        </ul>
    </div>

    <section class="newspaper animate-block">
        <div class='newspaper__container'>
            <div class="newspaper__top fade-up" data-watch data-watch-once>
                <a href="{{ route('posts') }}" class="newspaper__back" style='--icon:url("/img/icons/back.svg")'></a>
                <div class="newspaper__name">
                    <div class="newspaper__info">
                        <time datetime="{{ $post->published_at }}" class="newspaper__time">
                            {{ $post->published_at }}
                        </time>
                        <h2 class="newspaper__title block-title">{{ $post->title }}</h2>
                    </div>
                    <a href="#" class="newspaper__btn btn btn--blue btn--icon" style='--icon:url("/img/icons/07.svg")'>Подпишитесь</a>
                </div>
            </div>
            <div class="newspaper__inner">
                <div class="newspaper__img fade-up" data-watch data-watch-once>
                    <picture>
                        <img src="{{ $post->image_url }}"
                             srcset="{{ $post->image_url }} 2x"
                             alt="{{ $post->title }}">
                    </picture>
                </div>
                <div class="newspaper__content fade-up" data-watch data-watch-once>
                    <div class="newspaper__description">
                        <div class="content-reset">
                            {!! $post->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($relatedPosts->count() > 0)
        <section class="admission animate-block">
            <div class='admission__container'>
                <div class="admission__top fade-up" data-watch data-watch-once>
                    <h2 class="admission__title block-title">Это может быть вам<br>интересно</h2>
                </div>
                <div class="admission__row fade-up" data-watch data-watch-once>
                    @foreach($relatedPosts as $relatedPost)
                        <a href="{{ route('post', $relatedPost->slug) }}" class="admission__column card-product">
                            <div class="card-product__img">
                                <picture>
                                    <img data-src="{{ $relatedPost->image_url }}"
                                         data-srcset="{{ $relatedPost->image_url }} 2x"
                                         src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                                         alt="{{ $relatedPost->title }}"
                                         loading="lazy">
                                </picture>
                            </div>
                            <div class="card-product__info">
                                <time datetime="{{ $relatedPost->published_at }}" class="card-product__time">
                                    {{ $relatedPost->published_at }}
                                </time>
                                <div class="card-product__title">{{ $relatedPost->title }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
