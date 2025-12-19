<div>
    <section class="spares animate-block">
        <div class='spares__container'>
            <div class="spares__top fade-up" data-watch data-watch-once>
                <h2 class="spares__title block-title">Каталог<br>запчастей</h2>
                <div class="spares__value">10 000 +</div>
            </div>
            <div class="spares__row fade-up" data-watch data-watch-once>
                @foreach($manufacturers as $manufacturer)
                    <a href="{{ route('catalog') . '?selectedManufacturers[0]=' . $manufacturer->id }}" class="spares__column">
                        <div class="spares__column-img">
                            <picture>
                                <img data-src="{{ $manufacturer->imageUrl ?? asset('img/spares/01.webp') }}" data-srcset="{{ asset('img/spares/01@2x.webp') }} 2x" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Рекомендованный товар">
                            </picture>
                        </div>
                    </a>
                @endforeach
            </div>
            <a href="{{ route('manufacturers') }}" class="spares__btn btn btn--showmore fade-up" data-watch data-watch-once>Просмотреть весь каталог</a>
        </div>
    </section>
</div>
