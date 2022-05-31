<div class="modal fade" id="addComment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Ваш комментарий</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <textarea class="form-control" id="textComment" style="height: 100px"></textarea>
                <label id="alertMsg" class="form-label text-danger"></label>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button id="saveComment" type="button" class="btn btn-primary">Добавить</button>
            </div>
        </div>
    </div>
</div>

<script>
    let win = document.getElementById('addComment');  // $('#addComment') не работает
    win.addEventListener('hide.bs.modal', function () {
        $('#textComment').val('').css({'height': '100px'});
        $('#alertMsg').text('');
    });
</script>
