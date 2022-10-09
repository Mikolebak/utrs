<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>
        @hasSection('title')
        @yield('title') &ndash;
        @endif
        {{ config('app.name') }}
    </title>
    <link rel="stylesheet" href="https://tools-static.wmflabs.org/cdnjs/ajax/libs/bootstrap/5.2.1/css/bootstrap.css">
    <script src="https://tools-static.wmflabs.org/cdnjs/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://tools-static.wmflabs.org/cdnjs/ajax/libs/bootstrap/5.2.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">@yield('scripts')</script>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
        <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto"> <!-- left nav -->
                @auth
                    @can('viewAny', App\Models\Appeal::class)
                        <li class="nav-item">
                            <a href="{{ route('appeal.list') }}" class="nav-link">{{__('generic.open-appeals')}}</a>
                        </li>
                    @endcan
                    @canany('viewAny', [App\Models\User::class, App\Models\Ban::class, App\Models\Template::class])
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="adminNavbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{__('generic.tool-admin')}}
                            </a>

                            <div class="dropdown-menu" aria-labelledby="adminNavbarDropdown">
                                @can('viewAny', App\Models\Ban::class)
                                    <a class="dropdown-item" href="{{ route('admin.bans.list') }}">{{__('generic.admin-tools.bans')}}</a>
                                @endcan
                                @can('viewAny', App\Models\Template::class)
                                    <a class="dropdown-item" href="{{ route('admin.templates.list') }}">{{__('generic.admin-tools.template')}}</a>
                                @endcan
                                @can('viewAny', App\Models\User::class)
                                    <a class="dropdown-item" href="{{ route('admin.users.list') }}">{{__('generic.admin-tools.users')}}</a>
                                @endcan
                                @can('viewAny', App\Models\Sitenotice::class)
                                    <a class="dropdown-item disabled" href="{{ route('admin.sitenotices.list') }}">{{__('generic.admin-tools.sitenotice')}}</a>
                                @endcan
                            </div>
                        </li>
                    @endcanany
                    @can('viewAny', \App\Models\Wiki::class)
                        <li class="nav-item">
                            <a href="{{ route('wiki.list') }}" class="nav-link">{{__('generic.support-wiki')}}</a>
                        </li>
                    @endcan
                @endauth
            </ul>
            <ul class="navbar-nav"> <!-- right nav -->
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->username }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right ms-auto" aria-labelledby="userNavbarDropdown">
                            <a class="dropdown-item" href="{{ route('admin.users.view', Auth::user()) }}">My account</a>
                            <a class="dropdown-item" href="{{ route('logout') }}">Log out</a>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">
                            {{__('generic.admin-login')}}
                        </a>
                    </li>
                @endauth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{__('generic.language')}}: {{App::getLocale()}}</a>

                    <div class="dropdown-menu dropdown-menu-right ms-auto" aria-labelledby="userNavbarDropdown">
                        <a class="dropdown-item" href="/changelang/en">English</a>
                        <a class="dropdown-item" href="/changelang/fr">Français</a>
                        <a class="dropdown-item" href="/changelang/es">Español</a>
                        <a class="dropdown-item" href="/changelang/pt-BR">Português (Brasil)</a>
                        <a class="dropdown-item" href="/changelang/pt-PT">Português</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <br/>
    @if(session()->has('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif
    @yield('content')

    <footer class="mt-4">
        <hr/>
        <p>
            Unblock Ticket Request System{!! Version::getVersion() !!}, <a href="https://github.com/utrs2/utrs/issues">report bugs</a>
        </p>
    </footer>
</div>
</body>
</html>
