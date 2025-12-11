<div id="callback-popup" aria-hidden="true" role="dialog" class="popup">
    <div class="popup__wrapper">
        <div class="popup__content">
            <div class="popup__inner">
                <button data-close type="button" class="popup__close" style='--icon:url(&quot;/img/icons/73.svg&quot;)'></button>
                <div class="popup__top">
                    <div class="popup__title">Отправить резюме</div>
                </div>
                <form action="#" class="popup__form form">
                    <div class="form__blocks">
                        <div class="form__block">
                            <div class="form__block-items">
                                <div class="form__block-item">
                                    <div class="form__block-input">
                                        <label for="" class="form__block-label">ФИО</label>
                                        <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="Иванво Иван Иванович" class="input" data-validate data-required>
                                    </div>
                                </div>
                                <div class="form__block-item">
                                    <div class="form__block-input">
                                        <label for="" class="form__block-label">Дата рождения</label>
                                        <input autocomplete="off" type="text" name="form[]" data-error="Ошибка" placeholder="25.05.1999" class="input js-date" data-validate data-required="date">
                                    </div>
                                </div>
                                <div class="form__block-item">
                                    <div class="form__block-input">
                                        <label for="" class="form__block-label">Номера телефона</label>
                                        <input autocomplete="off" type="tel" name="form[]" data-error="Ошибка" placeholder="" class="input" data-validate data-required="tel">
                                    </div>
                                </div>
                                <div class="form__block-item">
                                    <div class="form__block-file file-loader file-loader--text" data-type='files'>
                                        <div class="file-loader__inner">
                                            <div class="file-loader__content">
                                                <div class="file-loader__row">
                                                    <div class="file-loader__info">
                                                        <div class="file-loader__btn btn btn--border">Загрузите файл с вашим резюме</div>
                                                        <input id="file-upload" class="file-loader__input visually-hidden" type="file" name="file" accept=".pdf, .png, .jpg, .jpeg" data-validate data-required>
                                                    </div>
                                                    <div class="file-loader__title">Размер файла до 5 Мб, форматы jpg, png, pdf</div>
                                                    <div class="file-loader__files"></div>

                                                </div>
                                            </div>
                                            <div class="file-loader__error"></div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="form__block-bottom">
                                <div class="form__block-checkbox checkbox">
                                    <input id="cddd_1" data-error="Ошибка" class="checkbox__input" type="checkbox" value="1" name="form[]" data-validate data-required>
                                    <label for="cddd_1" class="checkbox__label">
										<span class="checkbox__text">Я даю своё согласие на обработку моих персональных данных на условиях, определённых
											<a href="javascript:void(0)">
												Политикой конфиденциальности</a>
										</span>
                                    </label>
                                </div>
                                <button type="submit" class="form__block-btn btn">Отправить</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
