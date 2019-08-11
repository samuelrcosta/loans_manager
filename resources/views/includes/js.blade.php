<!-- Scripts info -->
<script type="text/javascript">
    const PUSH_PUBLIC_KEY = '{{ env('PUSH_NOTIFICATIONS_PUBLIC_KEY') }}';
</script>
<!--   Core JS Files   -->
<script src="{{ asset('js/core/jquery.min.js') }}"></script>
<script src="{{ asset('js/core/popper.min.js') }}"></script>
<script src="{{ asset('js/core/bootstrap-material-design.min.js') }}"></script>
<script src="https://unpkg.com/default-passive-events"></script>
<script src="{{ asset('js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<!-- Chartist JS -->
<script src="{{ asset('js/plugins/chartist.min.js') }}"></script>
<!-- Jquery Mask -->
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<!--  Notifications Plugin    -->
<script src="{{ asset('js/plugins/bootstrap-notify.js') }}"></script>
<!-- Fingerprint -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fingerprintjs2/2.1.0/fingerprint2.min.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('js/material-dashboard.min.js') }}?v={{ filemtime('js/material-dashboard.min.js') }}"></script>
<!-- Custom js -->
<script src="{{ asset('js/custom.js') }}?v={{ filemtime('js/custom.js') }}"></script>