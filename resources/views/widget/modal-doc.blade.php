<div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">

                <iframe id="previewIframe" width="100%" height="600px"></iframe>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script>
    function previewModal(pdfFile, title) {
        document.getElementById('myLargeModalLabel').innerHTML = title;
        var previewIframe = document.getElementById('previewIframe').src = @json(asset('storage')) + '/' + pdfFile;
        $('#bs-example-modal-lg').modal('show');
    }

    function previewModalLocal(fileUrl, title) {
        $('#myLargeModalLabel').text(title);
        $('#previewIframe').attr('src', fileUrl);
        $('#bs-example-modal-lg').modal('show');
    }
</script>
