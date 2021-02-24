<script>
    @if (session('success'))
        $.notify({
            // options
            message: '{{ session('success') }}'
        },{
            // settings
            type: 'success',
            offset: 20,
            z_index: 10000,
            delay: 1500
        });
    @endif

    @if (session('info'))
        $.notify({
            // options
            message: '{{ session('info') }}'
        },{
            // settings
            type: 'info',
            offset: 20,
            z_index: 10000,
            delay: 1500
        });
    @endif

    @if (session('danger'))
        $.notify({
            // options
            message: '{{ session('danger') }}'
        },{
            // settings
            type: 'danger',
            offset: 20,
            z_index: 10000,
            delay: 1500
        });
    @endif
    </script>
