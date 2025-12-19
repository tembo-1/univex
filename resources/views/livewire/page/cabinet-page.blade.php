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
									<span>Личный кабаинет</span>
								</span>
            </li>
        </ul>
    </div>

    <section class="cabinet  animate-block">
        <div class='cabinet__container'>
            <div class="cabinet__inner">
                <aside class="cabinet__aside" data-watch data-watch-once>
                    <div class="cabinet__info">
                        @livewire('components.blocks.user-menu')
                        <div class="cabinet__manager manager-cabinet">
                            <div class="manager-cabinet__title">Ваш МЕНЕДЖЕР</div>
                            <div class="manager-cabinet__name">{{ $manager->fullName }}</div>
                            <div class="manager-cabinet__items">
                                <a href="javascript:void(0)" class="manager-cabinet__item" style='--icon:url(&quot;/img/icons/11.svg&quot;)'>
                                    <b>{{ $manager->internal_phone }}</b>
                                </a>
                                <a href="javascript:void(0)" class="manager-cabinet__item" style='--icon:url(&quot;/img/icons/12.svg&quot;)'>{{ $manager->user->email }}</a>
                            </div>
                            <div class="manager-cabinet__items">
                                <time datetime="2016-11-18T09:54" class="manager-cabinet__item" style='--icon:url(&quot;/img/icons/13.svg&quot;)'>{{ $manager->work_schedule }}</time>
                            </div>
                        </div>
                    </div>
                </aside>
                <div class="cabinet__main">
                    <div class="cabinet__block" data-watch data-watch-once>
                        <div class="cabinet__top">
                            <div class="cabinet__title">{{ $name }}</div>
                        </div>
                        <div class="cabinet__content">
                            <div class="cabinet__agreement agreement-cabinet">
                                <div class="agreement-cabinet__row">
                                    <div class="agreement-cabinet__column">
                                        <div class="agreement-cabinet__title">
                                            ID клиента</div>
                                        <div class="agreement-cabinet__value">
                                            <b>{{ $id }}</b>
                                        </div>
                                    </div>
                                    <div class="agreement-cabinet__column">
                                        <div class="agreement-cabinet__title">
                                            ИНН/КПП</div>
                                        <div class="agreement-cabinet__value">
                                            <b>{{ $inn }}</b>
                                        </div>
                                    </div>
                                    <div class="agreement-cabinet__column">
                                        <div class="agreement-cabinet__title">
                                            № Договора</div>
                                        <div class="agreement-cabinet__value">
                                            <b>Договор № 12324</b>
                                            <span>от 25 сентября 2025 г
															</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="agreement-cabinet__bottom">
                                    <div class="agreement-cabinet__items">
                                        <a href="javascript:void(0)" class="agreement-cabinet__item" style='--icon:url(&quot;/img/icons/11.svg&quot;)'>{{ $phone }}</a>
                                        <a href="javascript:void(0)" class="agreement-cabinet__item" style='--icon:url(&quot;/img/icons/12.svg&quot;)'>{{ $email }}</a>
                                    </div>
                                    <a href="{{ route('profile') }}" class="agreement-cabinet__link btn btn--blue btn--icon" style='--icon:url(&quot;/img/icons/03.svg&quot;)'>Больше информации</a>
                                </div>
                            </div>
                            @livewire('components.blocks.balance')
                        </div>
                    </div>
                    <div class="cabinet__block" data-watch data-watch-once>
                        <div class="cabinet__top">
                            <div class="cabinet__subtitle">Уведомления</div>
                        </div>
                        <div class="cabinet__cards">
                            @foreach($notifications as $notification)
                                <a href="javascript:void(0)" class="cabinet__card">
                                    <div class="cabinet__card-top">
                                        <time datetime="2016-11-18T09:54" class="cabinet__card-time">{{ $notification->created_at }}</time>
                                        <div class="cabinet__card-title">{{ $notification->title }}</div>
                                    </div>
                                    <div class="cabinet__card-btn" style='--icon:url(&quot;/img/icons/46.svg&quot;)'></div>
                                </a>
                            @endforeach
                        </div>

                        @if($hasMore)
                            <a href="javascript:void(0)"
                                class="cabinet__showmore btn btn--showmore"
                                @if($page == 1) data-watch data-watch-once @endif
                               wire:click="loadMore">
                                    загрузить еще уведомления
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section></div>
