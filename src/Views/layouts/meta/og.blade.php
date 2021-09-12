    <!--  Essential META Tags -->
    <meta property="og:title" content="@yield('meta_title', 'Titlu pagina')">
    <meta property="og:description" content="@yield('meta_description', $site_settings['meta_description'])">
    <meta property="og:image" content="@yield('og_image', url('images/large/'. $site_settings['og_pic']) )">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <!--  Non-Essential, But Recommended -->
    <meta property="og:site_name" content="{{ $site_settings['site_name'] }}">
    <meta name="twitter:image:alt" content="Alt text for image">
    <!--  Non-Essential, But Required for Analytics -->
    <meta property="fb:app_id" content="your_app_id" />
    <meta name="twitter:site" content="@website-username">