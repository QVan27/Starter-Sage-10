<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-24 col-md-22 m-auto">
                <div class="header__wrapper">
                    <div class="header__logo">
                        <a href="{{ home_url('/') }}" aria-label="Retour à l'accueil" role="link" tabindex="0">
                            {!! display_svg('logo') !!}
                        </a>
                    </div>
                    <div class="header__container">
                        <nav class="header__menu">
                            @if (!empty($navigation['primary_navigation']))
                                <ul id="primary-navigation" class="header__menu-list">
                                    @foreach ($navigation['primary_navigation'] as $index => $item)
                                        <li class="header__menu-item">
                                            <a class="header__menu-link"
                                                @if ($item['target']) target="_blank" rel="noopener" @endif
                                                href="{{ $item['url'] }}">
                                                <span
                                                    class="u-font-tag header__menu-link__tag">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                                <span class="header__menu-link__label">{{ $item['title'] }}</span>
                                            </a>
                                            @if ($index !== count($navigation['primary_navigation']) - 1)
                                                <div class="header__menu-item__line"></div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </nav>
                        <div class="header__wrapper header__wrapper--inner">
                            <div class="header__copy">
                                <p class="u-upper">&copy; {{ date('Y') }} artvannah.</p>
                            </div>
                            <div class="header__socials">
                                <ul class="header__socials-list">
                                    @foreach ($options['socials'] as $social)
                                        <li class="header__socials-item">
                                            <a class="u-upper u-underline-hover header__socials-link" href="{{ $social['link']['url'] }}"
                                                @if ($social['link']['target']) target="_blank" rel="noopener" @endif>
                                                {{ $social['link']['title'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="header__burger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
