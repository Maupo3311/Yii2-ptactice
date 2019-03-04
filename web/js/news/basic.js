$(document).ready(function(){
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
        pricessingText(100);
	} else if(documentWidth < 800){
        $('.newsImage').css('height', '250px');
        pricessingText(160);
        if( $(".optionsButton").parent('p').length != 0 ){
            $(".optionsButton").unwrap();
        }

    } else if(documentWidth < 1400){
        $('.newsImage').css('height', '300px');
        pricessingText(240);
        if( $(".optionsButton").parent('p').length != 0 ){
            $(".optionsButton").unwrap();
        }
    } else {
        pricessingText(350);
        $('.newsImage').css('height', '400px');
        if( $(".optionsButton").parent('p').length != 0 ){
            $(".optionsButton").unwrap();
        }
    }

    return documentWidth;

}

function pricessingText(permissibleLength){

    var newsTexts = $('.newsText');

    for(let count = 0; count < newsTexts.length; ++count){
        var textBlock = newsTexts[count];

        if(textBlock.getAttribute('data-status') == 'open') return;

        textBlock.id = 'processing';
        if( $('#processing').children('.hiddenText').length != 0 ){
            console.log($('#processing').children('.hiddenText'));
            showText( $('#processing').children('.hiddenText')[0] );
        }

        var text = textBlock.innerHTML;

        if(text.length > permissibleLength){

            for(permissibleLength ; text[permissibleLength] != ' '; ++permissibleLength);

            var displayText = text.slice(0, permissibleLength);
            var hiddenText = text.slice(permissibleLength);
            textBlock.innerHTML = displayText + ' <a onclick="showText(this, \'open\')" data-hiddenText="' + hiddenText + '" href="#" class="hiddenText">показать полностью...</a>';
        }
    }
}

function showText(element, status = null){
    var textBlock = element.parentNode;
    console.log(textBlock);
    if(status != null) textBlock.setAttribute('data-status', status);
    var text = element.getAttribute('data-hiddenText');
    element.remove();
    textBlock.innerHTML += text;
}