<header>
    <nav class="top-nav">
        <div class="container">
            <div class="inner">
                <div class="left">
                    <div class="icons">
                        <a class="nav-item" href="{{ $settings->facebook }}"><i class="fab fa-facebook-f"></i></a>
                        <a class="nav-item" href="{{ $settings->twitter }}"><i class="fab fa-twitter"></i></a>
                        <a class="nav-item" href="{{ $settings->instagram }}"><i class="fab fa-instagram"></i></a>
                        <a class="nav-item" href="{{ $settings->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
                        <a class="nav-item" class="nav-item" href="#">
                            <i class="fa-solid fa-phone"></i>
                            <span class="d-none d-lg-block">{{ $settings->phone }}</span>
                        </a>
                    </div>
                </div>
                <div class="right">
                    <div class="lang-dropdown">
                        <div class="active-lang nav-item">
                            <i class="fa-solid fa-globe"></i>
                            <span class="d-none d-lg-block">{{ __('main.lang_selection') }}
                                ({{ Session('lang') }})</span>
                            <span class="d-lg-none">{{ Session('lang') }}</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                        <div class="lang-menu d-none">
                            {{-- <a href="{{ url($lang['az']) }}">Azerbaijan</a> --}}
                            @if(Session('lang') === 'en')
                            <a href="{{ url($lang['ru']) }}">Russian</a>
                            @else
                            <a href="{{ url($lang['en']) }}">English</a>
                            @endif
                        </div>
                    </div>
                    <button class="search-button nav-item">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
                <div class="search-wrapper d-none">
                    <button class="close-button">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <div class="container">
                        <form action="">
                            <input type="text" placeholder="Axtar">
                            <button class="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <nav class="bottom-nav">
        <div class="container">
            <div class="inner">
                <a href="{{ route('index') }}" class="logo">
                    <img class="d-md-none" src="{{ asset('storage/uploads/settings/' . $settings->favicon) }}"
                        alt="logo">
                    <img class="d-none d-md-block" src="{{ asset('storage/uploads/settings/' . $settings->logo) }}"
                        alt="logo">
                </a>
                <div class="right">
                    <div class="nav-menu">
                        <div class="menu-header d-xl-none">
                            <a href="{{ route('index') }}" class="logo">
                                <img src="{{ asset('storage/uploads/settings/' . $settings->logo_white) }}"
                                    alt="logo">
                            </a>
                            <button class="close-button">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <div class="menu-body">
                            <h5 class="menu-title d-xl-none">{{ __('main.pages') }}</h5>
                            <div class="links-wrapper">
                                @foreach ($menues->where('parent', 0) as $menu)
                                    <div
                                        class="link-item 
                                        @if (count($menues->where('parent', $menu->id)) > 0) has-child @endif
                                        @if ($menu->id === 3 && count($services->where('header_status', 1)) > 0) has-child @endif
                                        @if ($menu->id === 4 && count($projectcategories->where('header_status', 1)) > 0) has-child @endif
                                        ">
                                        <div class="label">
                                            {{-- <a
                                                @if (Session('lang') == 'az') href="{{ url($menu->getTranslate->where('lang', Session('lang'))->first()->slug) }}"
                                                @else
                                                href="{{ url(Session('lang') . '/' . $menu->getTranslate->where('lang', Session('lang'))->first()->slug) }}" @endif>
                                                {{ $menu->getTranslate->where('lang', Session('lang'))->first()->title }}
                                            </a> --}}
                                            <a
                                                @if (Session('lang') == 'en') href="{{ url($menu->getTranslate->where('lang', Session('lang'))->first()->slug) }}"
                                                @else
                                                href="{{ url(Session('lang') . '/' . $menu->getTranslate->where('lang', Session('lang'))->first()->slug) }}" @endif>
                                                {{ $menu->getTranslate->where('lang', Session('lang'))->first()->title }}
                                            </a>
                                            <button><i class="fa-solid fa-chevron-down"></i></button>
                                        </div>
                                        @if (count($menues->where('parent', $menu->id)) > 0)
                                            <div class="link-menu d-none">
                                                @foreach ($menues->where('parent', $menu->id) as $altMenu)
                                                    {{-- <a
                                                        @if (Session('lang') == 'az') href="{{ url($menu->getTranslate->where('lang', Session('lang'))->first()->slug . '/' . $altMenu->getTranslate->where('lang', Session('lang'))->first()->slug) }}"
                                                        @else
                                                        href="{{ url(Session('lang') . '/' . $menu->getTranslate->where('lang', Session('lang'))->first()->slug . '/' . $altMenu->getTranslate->where('lang', Session('lang'))->first()->slug) }}" @endif>
                                                        <span>{{ $altMenu->getTranslate->where('lang', Session('lang'))->first()->title }}</span>
                                                    </a> --}}
                                                    <a
                                                        @if (Session('lang') == 'en') href="{{ url($menu->getTranslate->where('lang', Session('lang'))->first()->slug . '/' . $altMenu->getTranslate->where('lang', Session('lang'))->first()->slug) }}"
                                                        @else
                                                        href="{{ url(Session('lang') . '/' . $menu->getTranslate->where('lang', Session('lang'))->first()->slug . '/' . $altMenu->getTranslate->where('lang', Session('lang'))->first()->slug) }}" @endif>
                                                        <span>{{ $altMenu->getTranslate->where('lang', Session('lang'))->first()->title }}</span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if ($menu->id === 3 && count($services->where('header_status', 1)) > 0)
                                            <div class="link-menu d-none">
                                                @foreach ($services->where('header_status', 1) as $service)
                                                    <a
                                                        href="{{ route('service_inner_' . Session('lang'), ['slug' => $service->getTranslate->where('lang', Session('lang'))->first()->slug]) }}">
                                                        <img src="{{ asset('storage/uploads/services/icon/' . $service->icon) }}"
                                                            alt="icon">
                                                        <span>{{ $service->getTranslate->where('lang', Session('lang'))->first()->title }}</span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if ($menu->id === 4 && count($projectcategories->where('header_status', 1)) > 0)
                                            <div class="link-menu d-none">
                                                @foreach ($projectcategories->where('header_status', 1) as $category)
                                                    <a
                                                        href="{{ route('project_category_' . Session('lang'), ['categorySlug' => $category->getTranslate->where('lang', Session('lang'))->first()->slug]) }}">
                                                        <span>{{ $category->getTranslate->where('lang', Session('lang'))->first()->title }}</span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="menu-footer d-xl-none">
                            <h5 class="menu-title">{{ __('main.contact') }}</h5>
                            <div class="contact-links">
                                <a href="#">
                                    <i class="fa-solid fa-phone"></i>
                                    <span>{{ $settings->phone }}</span>
                                </a>
                                <a href="#">
                                    <i class="fa-solid fa-envelope"></i>
                                    <span>{{ $settings->mail }}</span>
                                </a>
                                <a href="#">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>{{ $settings->getTranslate->where('lang', Session('lang'))->first()->address }}</span>
                                </a>
                            </div>
                            <div class="social-icons">
                                <a href="{{ $settings->facebook }}"><i class="fab fa-facebook-f"></i></a>
                                <a href="{{ $settings->twitter }}"><i class="fab fa-twitter"></i></a>
                                <a href="{{ $settings->instagram }}"><i class="fab fa-instagram"></i></a>
                                <a href="{{ $settings->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="menu-backdrop d-none d-xl-none"></div>
                    <button class="menu-button d-xl-none">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>
</header>
