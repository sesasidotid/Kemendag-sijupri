<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins.js') }}"></script>
<script src="{{ asset('starter/sweetalert2@11.js') }}"></script>
@yield('script')
@yield('script-bottom')
@php
    $errorList = [];
    $errorsBag = session()->has('errors') ? (array) session()->get('errors')->getBags()['default'] : null;
    if ($errorsBag) {
        $messagesKey = array_filter(array_keys($errorsBag), function ($key) {
            return preg_match('/^\x00\*\x00messages$/', $key);
        });
        $errorList = isset($messagesKey[0]) ? $errorsBag[$messagesKey[0]] : [];
    }
@endphp
<script>
    $(document).ready(function() {
        var errors = @json($errorList);

        $.each(errors, function(field, messages) {
            var input = $('[name="' + field + '"]');
            input.addClass('is-invalid');
            $('<span class="invalid-feedback"><strong>' + messages[0] + '</strong></span>').insertAfter(
                input);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('input[type=file]').change(function() {
            var fileInput = $(this);
            var fileName = fileInput.val().split('\\').pop();
            var previewButtonName = 'preview-button-' + fileInput.attr('name');

            var previewButton = $('[name="' + previewButtonName + '"]');
            if (previewButton.length === 0) {
                previewButton = $(
                    '<a class="btn btn-sm btn-soft-info" name="' + previewButtonName + '">Lihat</a>'
                );
                fileInput.before(previewButton);
            }

            previewButton.off('click').on('click', function() {
                var fileUrl = URL.createObjectURL(fileInput[0].files[0]);
                previewModalLocal(fileUrl, fileName);
            });
        });
    });
</script>
@if (session()->has('response'))
    @php
        $title = session('response')['title'] ?? 'Berhasil';
        $text = session('response')['message'];
        $icon = session('response')['icon'] ?? 'success';
    @endphp
    <script>
        $(window).on('load', function() {
            Swal.fire({
                icon: "{{ $icon }}",
                text: '{{ $text }}',
                position: "top",
                showConfirmButton: false,
            });
        });
    </script>
@endif
