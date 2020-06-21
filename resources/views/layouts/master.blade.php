<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <title>@yield('title') — {{ env('APP_NAME') }}</title>
  <link rel="stylesheet" href="{{ asset('public/css/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/adminlte.min.css') }}">
  <link href="{{ asset('public/img/favicon.png') }}" rel="icon">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  @yield('styles')

</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('index') }}" class="nav-link {{ (Request::route()->getName() == 'index') ? 'active' : '' }}">Все
          записи</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('note.new.get') }}"
           class="nav-link {{ (Request::route()->getName() == 'note.new.get') ? 'active' : '' }}">Новая запись</a>
      </li>
      <form class="form-inline ml-3" method="GET" action="{{ route('note.search') }}">
        <div class="input-group input-group-sm">
          <input class="form-control form-control-navbar" name="query" type="search" placeholder="Поиск по записям..."
                 aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
              class="fas fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('index') }}" class="brand-link">
      <img src="{{ asset('public/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('index') }}"
               class="nav-link {{ (Request::route()->getName() == 'index') ? 'active' : '' }}">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Все записи
                {!! (Request::route()->getName() == 'index') ? '<i class="fas fa-angle-left right"></i>' : '' !!}
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('note.new.get') }}"
               class="nav-link {{ (Request::route()->getName() == 'note.new.get') ? 'active' : '' }}">
              <i class="nav-icon fas fa-plus"></i>
              <p>
                Новая запись
                {!! (Request::route()->getName() == 'note.new.get') ? '<i class="fas fa-angle-left right"></i>' : '' !!}
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview {{ (Request::route()->getName() == 'list.countries.get' || Request::route()->getName() == 'list.cities.get') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (Request::route()->getName() == 'list.countries.get' || Request::route()->getName() == 'list.cities.get') ? 'active' : '' }}">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Редактировать
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('list.countries.get') }}" class="nav-link {{ (Request::route()->getName() == 'list.countries.get') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Список стран</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('list.cities.get') }}" class="nav-link {{ (Request::route()->getName() == 'list.cities.get') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Список городов</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
  <div class="content-wrapper" style="min-height: 220px;">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@yield('content-title')</h1>
          </div>
        </div>
      </div>
    </div>
    @yield('content')
  </div>
  <aside class="control-sidebar control-sidebar-dark">
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
      <b>Generated:</b> {{ date('d.m.Y') }} {{ date('H:i:s') }}
    </div>
    <strong>Copyright © {{ date('Y') }} <a href="{{ url('/') }}">{{ url('/') }}</a></strong>
  </footer>
</div>

<script src="{{ asset('public/js/jquery.min.js') }}"></script>
<script src="{{ asset('public/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/js/adminlte.min.js') }}"></script>
@yield('scripts')
</body>
</html>
