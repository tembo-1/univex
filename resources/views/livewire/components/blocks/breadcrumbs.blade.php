<div>
    @if($items->isNotEmpty() && $show)
        <div class="breadcrumb">
            <ul class="breadcrumb__list breadcrumb__container">
                @foreach($items as $item)
                    <li class="breadcrumb__item {{ $item['active'] ? 'breadcrumb__item--active' : '' }}"
                        style="--icon:url('/img/icons/10.svg')">
                        <span>
                            @if(!$item['active'] && $item['url'] && $item['url'] !== 'javascript:void(0)')
                                <a href="{{ $item['url'] }}">
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            @else
                                <span>{{ $item['label'] }}</span>
                            @endif
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
