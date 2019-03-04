$('#showFileInput').click(function(){
    if( $('#showFileInput').attr('data') == 'close' ){
        $('#showFileInput').html('Отмена').attr('data', 'open');
        $('#fileInput').css('display', 'block');
    } else {
        $('#showFileInput').html('Прикрепить').attr('data', 'close');
        $('#fileInput').css('display', 'none');
    }
});

$('#submitInput').click(function(){
    var text = $('#textInput').val();
    if( text != '' ){
        $('#submitInput').css('display', 'none');
    }
})
