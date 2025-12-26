<div class="cabinet__info-items">
    <a href="{{ route('orders') }}" class="cabinet__info-item @if($route == 'orders') _active @endif" style='--icon:url(&quot;/img/icons/61.svg&quot;)'>
        <div class="cabinet__info-name" style='--icon:url(&quot;/img/icons/60.svg&quot;)'>Заказы</div>
    </a>
    <a href="javascript:void(0)" class="cabinet__info-item" style='--icon:url(&quot;/img/icons/61.svg&quot;)'>
        <div class="cabinet__info-name" style='--icon:url(&quot;/img/icons/62.svg&quot;)'>Взаиморасчеты</div>
    </a>
    <a href="{{ route('refunds') }}" class="cabinet__info-item @if($route == 'refunds') _active @endif" style='--icon:url(&quot;/img/icons/61.svg&quot;)'>
        <div class="cabinet__info-name" style='--icon:url(&quot;/img/icons/63.svg&quot;)'>Возвраты</div>
    </a>
    <a href="{{ route('notepad') }}" class="cabinet__info-item @if($route == 'notepad') _active @endif" style='--icon:url(&quot;/img/icons/61.svg&quot;)'>
        <div class="cabinet__info-name" style='--icon:url(&quot;/img/icons/64.svg&quot;)'>Блокнот</div>
    </a>
    <a href="{{ route('info') }}" class="cabinet__info-item @if($route == 'info') _active @endif" style='--icon:url(&quot;/img/icons/61.svg&quot;)'>
        <div class="cabinet__info-name" style='--icon:url(&quot;/img/icons/64.svg&quot;)'>Профиль</div>
    </a>
{{--    <a href="{{ route('profile') }}" class="cabinet__info-item @if($route == 'profile') _active @endif" style='--icon:url(&quot;/img/icons/61.svg&quot;)'>--}}
{{--        <div class="cabinet__info-name" style='--icon:url(&quot;/img/icons/65.svg&quot;)'>Профиль</div>--}}
{{--    </a>--}}
</div>
