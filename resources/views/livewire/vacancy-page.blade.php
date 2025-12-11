<div>
    <div class="breadcrumb">
        <ul class="breadcrumb__list breadcrumb__container">
            <li class="breadcrumb__item" style='--icon:url(&quot;/img/icons/10.svg&quot;)'>
								<span>
									<a href="javascript:void(0)">
										<span>
											Главная
										</span>
									</a>
								</span>
            </li>
            <li class="breadcrumb__item breadcrumb__item--active">
								<span>
									<span>Вакансии</span>
								</span>
            </li>
        </ul>
    </div>
    <section class="vacancy  animate-block fade-up" data-watch data-watch-once>
        <div class='vacancy__container'>
            <h2 class="vacancy__title block-title">Вакансии</h2>
            <div data-spollers data-one-spoller class="vacancy__spollers spollers">
                @foreach($vacancies as $vacancy)
                    <details class="spollers__item" style='--icon:url(&quot;/img/icons/72.svg&quot;)'>
                        <summary class="spollers__title">
                            <span class="spollers__title-name">{{ $vacancy->name }}</span>
                            <span class="spollers__title-experience">{{ $vacancy->experience }}</span>
                            <span class="spollers__title-value">{{ $vacancy->salary }}</span>

                        </summary>

                        <div class="spollers__body">
                            <div class="spollers__inner">
                                <div class="spollers__row claim__content">
                                    {!! $vacancy->content !!}

                                    <a href="{{ route('popup.resume') }}"
                                       data-popup="#callback-popup"
                                       class="spollers__btn btn btn--icon"
                                       style='--icon:url(&quot;/img/icons/03.svg&quot;); color: white; text-decoration: none'>
                                        <span>Отправить ОТКЛИК</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </details>
                @endforeach
            </div>
        </div>
    </section>
</div>
