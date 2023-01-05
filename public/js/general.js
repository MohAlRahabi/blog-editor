function clearForm($content) {
    $($content).find('.form-control').val('');
    $($content).find('.select2').val(null).trigger('change');
}

function clearErrors($content) {
    $content.find('.error').remove();
}

function _fill($cont, obj) {
    let formID = $cont.prop('id');
    $($cont).find('.summernote').each(function () {
        var $this = $(this);

        $this.summernote('code',obj[$(this).attr('name')].replace("&amp;",'&' ).replace("&gt;", '>').replace("&lt;",'<' ).replace("&quot;", '"'));
    })
    $($cont).find(':input:not(".select2,[name=_method],[name=_token]")').each(function () {
        var $this = $(this);
        if ($this.prop('type')) {
            if ($this.prop('type') === 'radio') {
                $this.prop('checked', obj[$(this).attr('name')] == $(this).attr('value'));
            } else if ($this.prop('type') === 'checkbox') {
                $this.prop('checked', (obj[$(this).attr('name')] === '1' || obj[$(this).attr('name')] === 1));
            } else if ($this.prop('type') === 'password') {

            } else if($this.prop('type') === 'file' && $this.prop('name') === 'image' && obj.image){
                $('#close-img').attr('data-id' , obj.id);
                $('#imgPreview').find('img').prop('src' , obj.image_full_path);
                $('#imgPreview').show();
                $this.hide();
            } else if($this.prop('type') === 'file' && $this.prop('name') === 'file' && obj.file){
                $('#close-file').attr('data-id',obj.id);
                $('#filePreview').find('a').prop('href',obj.full_path_file);
                $('#filePreview').show();
                $this.hide();
            } else if($this.prop('type') === 'file' && $this.prop('name') === 'video' && obj.video) {
                $('#close-video').attr('data-id',obj.id);
                $('#videoPreview').find('a').prop('href',obj.full_path_video);
                $('#videoPreview').show();
                $this.hide();
            } else {
                if ($(this).attr('name') && $(this).attr('name').includes('[')) {
                    let [$obj, name] = $(this).attr('name').replace(']', '').split('[');
                    $this.val(obj[$obj] && obj[$obj][name]);
                } else
                    $this.val(obj[$(this).attr('name')]);
            }
        } else
            $this.html(obj[$(this).attr('name')]);
    });
    $($cont).find('.select2').each(function () {
        var $this = $(this), name = $this.attr('name');
        if ($this.attr('multiple')) {
            var selectedValues = obj[$this.attr('name').replace('[', '').replace(']', '')];
            $this.val(selectedValues).trigger('change');
        }
        if (obj[$this.attr('name')] != null) {
            $this.val(obj[$this.attr('name')]).trigger('change');
        }
    });
    $($cont).find('.kt-selectpicker').each(function () {
        var $this = $(this), name = $this.attr('name');
        if (obj[$this.attr('name')] != null) {
            $this.val(obj[$this.attr('name')]).trigger('change');
        }
    });
}

function SaveItem(e, $this, url, table) {
    e.preventDefault();
    clearErrors($($this));
    var $data = new FormData($this);
    $($this).find('.summernote').each(function () {
        $data.append($(this).attr('name'),$(this).summernote('code'))
    })
    let $url = BASE_URL + url;
    jQuery.ajax({
        type: 'POST',
        url: $url,
        data: $data,
        contentType: false,
        processData: false,
        beforeSend() {
            jQuery('body').append('<div class="overlay"><i class="fa fa-spinner fa-5x fa-spin mt-5"></i></div>');
        },
        success(xhr) {
            if (xhr && xhr.message) {
                new swal(
                    'success',
                    xhr.message,
                    'success'
                );
            } else {
                new swal(
                    'success',
                    'Coupon added successfully',
                    'success'
                );
            }
            $('.modal').modal('hide');
            clearForm($($this));
            if (xhr && xhr.redirect) {
                window.location.replace(xhr.redirect);
            }
            table.ajax.reload();
        },
        error: HandleJsonErrors.bind($this),
        complete() {
            jQuery('body .overlay').remove();
        }
    });
}

function showAlert(options = null, onConfirm, onCancel) {
    let defaultOptions = {
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
    };
    let $options = $.extend(defaultOptions, options);
    new swal($options).then(function (result) {
        if (result) {
            if (result.isConfirmed)
                onConfirm();
        }
    }).catch(swal.noop);
}

HandleJsonErrors = function (xhr, errorThrown) {
    switch (xhr.status) {
        case 400:
            if (typeof xhr.responseJSON.message === 'string') {
                toastr.error(xhr.responseJSON.message, 400);
            }
            if (typeof xhr.responseJSON.message === 'object') {
                _message = '<div class="text-left">';
                for (let error in xhr.responseJSON.message) {
                    _message += xhr.responseJSON.message[error];
                    let input;
                    if (error && error.includes('.')) {
                        let $error = error.replace('.', '[') + ']';
                        input = $("[name='" + $error + "']");

                    } else
                        input = $('[name=' + error + ']');
                    let errorCont = input.closest('span.error');
                    if (errorCont.length) {
                        errorCont.text(xhr.responseJSON.message[error][0]);
                    } else {
                        if (input.hasClass('select2')) {
                            input.parent().find('.select2-container').after('<span class="text-danger error">' + xhr.responseJSON.message[error][0] + '</span>');
                        } else
                            input.after('<span class="text-danger error">' + xhr.responseJSON.message[error][0] + '</span>');
                    }
                }
                _message += '</div>';

                toastr.error(_message, '400', {
                    timeOut: 3000
                });
            }
            break;
        case 401:
            toastr.warning(xhr.responseJSON.message, '401');
            if (window.location.pathname !== '/login') {
                setTimeout(function () {
                    window.location = getBaseURL() + 'login';
                }, 1500);
            }
            break;
        case 404:
            toastr.error(xhr.responseJSON.message, '404');
            break;
        case 422:
            _message = '<div class="text-left">';
            for (let error in xhr.responseJSON.errors) {
                _message += xhr.responseJSON.errors[error][0];
                let input;
                if (error && error.includes('.')) {
                    let $error = error.replace('.', '[') + ']';
                    input = $("[name='" + $error + "']");
                } else {
                    input = $('[name=' + error + ']');
                }
                let errorCont = input.closest('span.error');
                if (errorCont.length) {
                    errorCont.text(xhr.responseJSON.errors[error][0]);
                } else {
                    if (input.hasClass('select2')) {
                        input.parent().find('.select2-container').after('<span class="text-danger error">' + xhr.responseJSON.errors[error][0] + '</span>');
                    } else if (input.parent().hasClass('input-group')) {
                        input.parent().after('<span class="text-danger error">' + xhr.responseJSON.errors[error][0] + '</span>');
                    } else
                        input.after('<span class="text-danger error">' + xhr.responseJSON.errors[error][0] + '</span>');
                }
            }
            _message += '</div>';
            toastr.error(_message, '422', {
                timeOut: 5000
            });
            break;
        case 500:
            toastr.error(xhr.responseJSON.message, '500');
            break;
        default:
            toastr.error('Something went wrong: ' + errorThrown, 'Oops..');
    }
};



function deleteOpr(id, $url,table, $options = null) {
    showAlert($options, () => {
        $.ajax({
            type: 'POST',
            url: BASE_URL + $url,
            data: {_method: 'DELETE', _token},
            success(xhr) {
                // toastr.success(xhr.message);
                new swal(
                    'success',
                    xhr.message,
                    'success'
                );
                table.ajax.reload();
                // reloadDataGrid(true);
                return true;
            },
            error: HandleJsonErrors
        });
        return false;
    },()=>{
        table.ajax.reload();
    });
}
function postOpr(id, $url,table, $options = null) {

    showAlert($options, () => {
        $.ajax({
            type: 'POST',
            url: BASE_URL + $url,
            data: {_token},
            success(xhr) {
                // toastr.success(xhr.message);
                new swal(
                    'success',
                    xhr.message,
                    'success'
                );
                table.ajax.reload();
                // reloadDataGrid(true);
                return true;
            },
            error: HandleJsonErrors
        });
        return false;
    },()=>{
        table.ajax.reload();
    });
}
