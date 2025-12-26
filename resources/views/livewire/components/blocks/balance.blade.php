<div class="cabinet__balance">
    <div class="cabinet__balance-title">Баланс</div>
    <div class="cabinet__balance-items">
        <dl class="cabinet__balance-item">
            <dt class="cabinet__balance-category">Лимит</dt>
            <dd class="cabinet__balance-value">{{ $creditLimit }} ₽</dd>
        </dl>
        <dl class="cabinet__balance-item">
            <dt class="cabinet__balance-category">Остаток</dt>
            <dd class="cabinet__balance-value">{{ $availableBalance }}</dd>
        </dl>
        <dl class="cabinet__balance-item">
            <dt class="cabinet__balance-category">Долг
            </dt>
            <dd class="cabinet__balance-value">{{ $debt }} ₽</dd>
        </dl>
        <dl class="cabinet__balance-item">
            <dt class="cabinet__balance-category">Отсрочка
            </dt>
            <dd class="cabinet__balance-value">{{ $defermentDays }} дней
            </dd>
        </dl>
    </div>
</div>
