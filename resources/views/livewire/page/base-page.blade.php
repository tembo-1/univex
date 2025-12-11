<div>
    <div class="breadcrumb">
        <ul class="breadcrumb__list breadcrumb__container">
            <li class="breadcrumb__item" style='--icon:url(&quot;/img/icons/10.svg&quot;)'>
								<span>
									<a href="/">
										<span>
											Главная
										</span>
									</a>
								</span>
            </li>
            <li class="breadcrumb__item breadcrumb__item--active">
								<span>
									<span>{{ $page->name }}</span>
								</span>
            </li>
        </ul>
    </div>

    <section class="claim ">

        @foreach($blocks as $block)
            <div class='claim__container'>
                <h2 class="claim__title block-title">{{ $block->name }}
                </h2>
                @foreach($block->siteElements as $element)
                    <div class="claim__content">
                        {!! $element->cleanContent !!}
                    </div>
                @endforeach
            </div>
        @endforeach
    </section>
</div>
