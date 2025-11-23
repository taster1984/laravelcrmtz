<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Feedback Widget</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Feedback Form</h3>
    <div id="response"></div>

    <form id="widgetForm" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input type="text" class="form-control" id="name" name="name">
            <div class="invalid-feedback"></div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
            <div class="invalid-feedback"></div>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Телефон</label>
            <input type="text" class="form-control" id="phone" name="phone">
            <div class="invalid-feedback"></div>
        </div>

        <div class="mb-3">
            <label for="subject" class="form-label">Тема</label>
            <input type="text" class="form-control" id="subject" name="subject">
            <div class="invalid-feedback"></div>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Текст</label>
            <textarea class="form-control" id="body" name="body"></textarea>
            <div class="invalid-feedback"></div>
        </div>

        <div class="mb-3">
            <label for="files" class="form-label">Файлы</label>
            <div id="fileInputs">
                <input type="file" name="files[]" multiple class="form-control mb-2">
            </div>
            <button type="button" id="addFile" class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle"></i> Добавить ещё файлы
            </button>
            <div class="invalid-feedback"></div>
        </div>

        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#widgetForm').on('submit', function(e) {
            e.preventDefault();
            $('.form-control').removeClass('is-invalid'); // сброс ошибок
            $('#response').html('');

            let formData = new FormData(this);

            $.ajax({
                url: '/api/tickets',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(res) {
                    $('#response').html('<div class="alert alert-success">Ticket created! ID: '+res.data.id+'</div>');
                    $('#widgetForm')[0].reset();
                },
                error: function(xhr) {
                    if(xhr.status === 422) {
                        if(xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            for(let field in errors) {
                                let input = $('[name="'+field+'"]');
                                input.addClass('is-invalid');
                                input.next('.invalid-feedback').html(errors[field][0]);
                            }
                        } else if(xhr.responseJSON.message) {
                            $('#response').html('<div class="alert alert-danger">'+xhr.responseJSON.message+'</div>');
                        }                    } else {
                        $('#response').html('<div class="alert alert-danger">Unexpected error occurred. Please try again later.</div>');
                    }
                }
            });
        });
        let maxFiles = 5;

        $('#addFile').on('click', function() {
            let currentFiles = $('#fileInputs input[type="file"]').length;
            if(currentFiles < maxFiles) {
                $('#fileInputs').append('<input type="file" name="files[]" multiple class="form-control mb-2">');
            } else {
                alert('Максимальное количество файлов: 5');
            }
        });    });
</script>
</body>
</html>
