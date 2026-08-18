<div id="menu-profile">
    {!! menu('profile') !!}
    @push('scripts_start')
    <script type="text/javascript">
        var is_profile_menu = {{ $active_menu }};
    </script>
    @endpush
</div>
