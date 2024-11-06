<script src="{{ asset('assets/js/jquery.min.js') }}"></script> 
<!-- App css -->
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" id="appmodo-normal" />
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="modo-normal" />
<link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/metisMenu.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="appmodo-normal" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@php
if(isset($header_css)){
        foreach($header_css as $item){
@endphp
                <link href="{{ asset('assets/') }}/@php echo $item @endphp" rel="stylesheet" type="text/css" />
@php
        }
}
@endphp

<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
