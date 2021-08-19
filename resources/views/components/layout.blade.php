<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <title>{{ config('app.name') }}</title>
    </head>
    <body>
        <div class="container-md" style="max-width: 720px;">
            <div class="row justify-content-center">
                <div class="col p-1">
                    <div class="row">
                        <div class="col">
                            <div class="text-end">
                                <i class="bi bi-person-circle"></i>
                                {{ Request::get('account')['name'] }}
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ Config::get('app.site_url') }}">
                                            {{ Config::get('app.site_name') }}
                                        </a>
                                    </li>
                                    @if (Route::currentRouteName() == 'welcome')
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Menu
                                    </li>
                                    @else
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('welcome') }}">
                                            Menu
                                        </a>
                                    </li>
                                    @hasSection('title')
                                    @hasSection('title2')
                                    <li class="breadcrumb-item" aria-current="page">
                                        @yield('title')
                                    </li>
                                    @else
                                    <li class="breadcrumb-item active" aria-current="page">
                                        @yield('title')
                                    </li>
                                    @endif
                                    @endif
                                    @hasSection('title2')
                                    <li class="breadcrumb-item active" aria-current="page">
                                        @yield('title2')
                                    </li>
                                    @endif
                                    @endif
                                </ol>
                            </nav>
                        </div>
                    </div>
{{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
