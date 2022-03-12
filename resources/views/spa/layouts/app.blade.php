<!DOCTYPE html>
<html>
<!--begin::Head-->
<head>
    @include('spa.layouts.includes.head')
</head>
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    @yield('content')
    @include('spa.layouts.includes.scripts')
</body>
</html>