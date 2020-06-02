<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/ui/prism.min.js')) }}"></script>

@yield('vendor-script')

<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/components.js')) }}"></script>

@yield('page-script')
