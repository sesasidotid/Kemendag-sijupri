<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                2023 © SIJUPRI.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by SESASI
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
<!-- end main content-->
</div>
<!-- END layout-wrapper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ asset('build/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('build/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('build/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('build/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('build/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('build/js/plugins.js') }}"></script>
<!-- Dashboard init -->
<script src="{{ asset('build/js/pages/dashboard-job.init.js') }}"></script>
<!-- JAVASCRIPT -->{{-- Modal --}}
<script src="{{ asset('build/libs/prismjs/prism.js') }}"></script>
{{-- <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script> --}}
<script src="{{ asset('build/js/pages/modal.init.js') }}"></script>
<script src="{{ asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('build/js/pages/timeline.init.js') }}"></script>
@stack('ext_footer')
@yield('notification')

<script src="{{ asset('build/js/app.js') }}"></script>

<script src="{{ asset('starter/sweetalert2@11.js') }}"></script>

<script>
    $(window).on('load', function() {
        $('#page-loading').fadeOut('slow', function() {
            var $pageContentParent = $('#page-content-parent');
            var currentStyle = $pageContentParent.attr('style');
            var newStyle = currentStyle.replace('min-height: 100vh;', '');
            $pageContentParent.attr('style', newStyle);
            $('#page-content').fadeIn("slow", function() {
                if (typeof setMap === 'function') setMap();
            });
        });
    });
</script>

<script>
    function createHiddenInput(name, value) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        return input;
    }

    fetch('https://api.ipify.org?format=json')
        .then(response => response.json())
        .then(data => {
            const ipAddress = data.ip;
            const userAgent = navigator.userAgent;

            const forms = document.querySelectorAll('form');

            forms.forEach(form => {
                // Check if the form method is not 'GET'
                if (form.method.toUpperCase() !== 'GET') {
                    const ipInput = createHiddenInput('ip_address', ipAddress);
                    const userAgentInput = createHiddenInput('user_agent', userAgent);

                    form.appendChild(ipInput);
                    form.appendChild(userAgentInput);
                }
            });
        });
</script>

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
            const result = field.split('.');
            let suffix = '';
            if (result && result.length > 0) {
                for (let index = 1; index < result.length; index++) {
                    suffix = `${suffix}[${result[index]}]`;
                }
                field = `${result[0]}${suffix}`;
            }
            var input = $('[name="' + field + '"]');
            input.addClass('is-invalid');
            input.before('<span class="text-danger"><strong> | ' + messages[0] + '</strong></span>')
            // $('<span class="invalid-feedback"><strong>' + messages[0] + '</strong></span>').insertAfter(
            //     input);
        });
    });
</script>
<script>
    $(document).ready(function() {

        $(document).ready(function() {
            $('input[type=file]').change(function() {
                var fileInput = $(this);
                var fileName = fileInput.val().split('\\').pop();
                var previewButtonName = 'preview-button-' + fileInput.attr('name');

                var previewButton = $('[name="' + previewButtonName + '"]');
                if (previewButton.length === 0) {
                    previewButton = $(
                        '<a class="btn btn-sm btn-soft-info" name="' + previewButtonName +
                        '">Lihat</a>'
                    );
                    fileInput.before(previewButton);
                }

                previewButton.off('click').on('click', function() {
                    var fileUrl = URL.createObjectURL(fileInput[0].files[0]);
                    previewModalLocal(fileUrl, fileName);
                });
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
<script>
    let previousUrls = JSON.parse(localStorage.getItem('previousUrls')) || [];
    let currentUrl = window.location.href;
    let previousUrlIdx = previousUrls.length - 1;

    let previousUrl = `${domain}/dashboard`;
    if (previousUrls) {
        previousUrl = previousUrls[previousUrlIdx];
        if (window.location.href !== previousUrl)
            previousUrls.push(window.location.href);
    } else
        previousUrls.push(window.location.href);

    const MAX_URLS = 10;
    if (previousUrls.length > MAX_URLS) {
        previousUrls = previousUrls.slice(-MAX_URLS);
    }
    localStorage.setItem('previousUrls', JSON.stringify(previousUrls));

    function backToPreviousUrl() {
        previousUrls.pop();
        localStorage.setItem('previousUrls', JSON.stringify(previousUrls));
        window.location.href = previousUrl;
    }
</script>
@livewireScripts
</body>

</html>
