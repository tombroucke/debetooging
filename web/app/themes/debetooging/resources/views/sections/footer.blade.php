<footer class="content-info bg-beige text-blue">

  <div class="content-info__widgets">
    <div class="spacing-outer">
      <div class="container--wide container">
        <div class="row">
          @php(dynamic_sidebar('sidebar-footer'))
        </div>
      </div>
    </div>
  </div>

  @if (is_active_sidebar('sidebar-footer-2'))
    <div class="content-info__widgets-2">
      <div class="spacing-outer">
        <div class="container--wide container">
          <div class="row">
            @php(dynamic_sidebar('sidebar-footer-2'))
          </div>
        </div>
      </div>
    </div>
  @endif

  <div class="content-info__credits text-center text-sm text-black">
    <div class="spacing-outer">
      @includeWhen(has_nav_menu('credits_navigation'), 'partials.navigation-credits')
    </div>
  </div>

</footer>
