$(document).ready(function(){

    $('#showSearch').click(function(){
        if($(this).attr('data-status') == 'close'){
            $('#searchForm').css('display', 'block');
            $(this).attr('data-status', 'open');
            $(this).children('p').html('Скрыть поиск');
        } else {
            $('#searchForm').css('display', 'none');
            $(this).attr('data-status', 'close');
            $(this).children('p').html('Найти новость');
        }
    })

    var documentWidth =  document.documentElement.clientWidth;
	processingCarousel();
	setInterval( function(){
	    if( documentWidth != document.documentElement.clientWidth){
            documentWidth = processingCarousel();
        }
    } , 1000);
})

function processingCarousel(){

    var documentWidth = document.documentElement.clientWidth;

	if(documentWidth < 500){
        $('.newsImage').css('height', '150px');
        $('.optionsButton').wrap('<p></p>');
        processingText(100);
	} else if(documentWidth < 800){
        $('.newsImage').css('height', '250px');
        processingText(160);
        if( $(".optionsButton").parent('p').length != 0 ){
            $(".optionsButton").unwrap();
        }

    } else if(documentWidth < 1400){
        $('.newsImage').css('height', '300px');
        processingText(240);
        if( $(".optionsButton").parent('p').length != 0 ){
            $(".optionsButton").unwrap();
        }
    } else {
        processingText(350);
        $('.newsImage').css('height', '400px');
        if( $(".optionsButton").parent('p').length != 0 ){
            $(".optionsButton").unwrap();
        }
    }

    return documentWidth;

}

function processingText(permissibleLength){
    var newsTexts = $('.newsText');

    for(let count = 0; count < newsTexts.length; ++count){
        var textBlock = newsTexts[count];

        if(textBlock.getAttribute('data-status') == 'open') continue;

        textBlock.id = 'processing';
        if( $('#processing').children('.hiddenText').length != 0 ){
            showText( $('#processing').children('.hiddenText')[0] );
        }
        textBlock.id = '';

        var text = textBlock.innerHTML;

        if(text.length > permissibleLength){

            for(var length = permissibleLength; length < text.length; ++length){
                if(text[length] == ' ' || text[length] == ',' || text[length] == '.') break;
            }

            var displayText = text.slice(0, length);
            var hiddenText = text.slice(length);
            textBlock.innerHTML = displayText + ' <span onclick="showText(this, \'open\')" data-hiddenText="' + hiddenText + '" class="hiddenText">показать полностью...</span>';
        }
    }
}

function showText(element, status = null){
    var textBlock = element.parentNode;
    if(status != null) textBlock.setAttribute('data-status', status);
    var hiddenText = element.getAttribute('data-hiddenText');
    element.remove();
    textBlock.innerHTML += hiddenText;
}