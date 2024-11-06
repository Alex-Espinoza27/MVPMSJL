
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/metismenu.min.js') }}"></script>
<script src="{{ asset('assets/js/waves.js') }}"></script>
<script src="{{ asset('assets/js/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/js_general.js?v=') }}@php echo rand(1,9999); @endphp"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

@php
    if(isset($header_js)){
        foreach($header_js as $item){
        @endphp
            <script src="{{ asset('assets/') }}/@php echo $item @endphp?v=@php echo rand(1,9999); @endphp"></script>
        @php
    }
}
@endphp


<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>


{{-- <script src="{{url('assets/js/app_alerts.js')}}"></script> --}}
