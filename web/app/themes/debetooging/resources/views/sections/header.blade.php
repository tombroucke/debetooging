<header @class([
    'banner',
    'banner--alternative' => $alternativeHeader,
    'banner--default' => !$alternativeHeader,
])>
  <div class="banner__primary spacing-outer">
    <div class="container--wide container">
      <div @class([
          'banner__content',
          'd-flex position-relative  align-items-center w-100',
          'justify-content-between' => $alternativeHeader,
          'justify-content-end' => !$alternativeHeader,
      ])>
        <a
          @class([
              'brand fw-bold text-decoration-none',
              'position-absolute' => !$alternativeHeader,
          ])
          href="{{ home_url('/') }}"
          aria-label="{{ __('Home', 'sage') }}"
        >
          @svg('logo-de-betooging')
        </a>
        @includeWhen(has_nav_menu('primary_navigation'), 'partials.navigation-primary')
      </div>
    </div>
  </div>
</header>
