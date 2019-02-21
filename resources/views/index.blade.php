@php
$config = [
    'appName' => config('app.name'),
    'locale' => $locale = app()->getLocale(),
    'locales' => config('app.locales'),
    'githubAuth' => config('services.github.client_id'),
];

$polyfills = [
    'Promise',
    'Object.assign',
    'Object.values',
    'Array.prototype.find',
    'Array.prototype.findIndex',
    'Array.prototype.includes',
    'String.prototype.includes',
    'String.prototype.startsWith',
    'String.prototype.endsWith',
];
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>{{ config('app.name') }}</title>
  <meta name="fragment" content="!">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/favicon/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicon/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('/favicon/site.webmanifest') }}">
  <link rel="mask-icon" href="{{ asset('/favicon/safari-pinned-tab.svg') }}" color="#0f0f0f">
  <meta name="msapplication-TileColor" content="#423a6f">
  <meta name="msapplication-TileImage" content="{{ asset('/favicon/mstile-144x144.png') }}">
  <meta name="theme-color" content="#423a6f">
  <meta name="google-site-verification" content="LWP-U6P36fIbkm2SR4V6uAvCkaEkN7IeGLtfqWu2iI8" />
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-132670287-2"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-132670287-2');
  </script>
  <script type="application/ld+json">
    {
      "@context": "http://schema.org/",
      "@type": "WebSite",
      "name": "WebDevHub",
      "alternateName": "WDH",
      "url": "https://webdevhub.net",
      "image": "https://webdevhub.net/img/logo.png",
      "sameAs": [
        "https://www.facebook.com/webdevhub.official/",
        "https://twitter.com/wdh_official",
        "https://vk.com/webdevhub"
      ]
    }
  </script>
  <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "LibrarySystem",
      "name": "WebDevHub",
      "alternateName": "WDH",
      "url": "https://webdevhub.net",
      "logo": "https://webdevhub.net/img/logo.png",
      "sameAs": "https://www.facebook.com/webdevhub.official/"
    }
</script>

</head>
<body>
  <div id="app"></div>

  {{-- Global configuration object --}}
  <script>window.config = @json($config);</script>

  {{-- Polyfill JS features via polyfill.io --}}
  <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features={{ implode(',', $polyfills) }}"></script>

  {{-- Load the application scripts --}}
  @if (app()->isLocal())
    <script src="{{ mix('js/app.js') }}"></script>
  @else
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
  @endif
</body>
</html>
