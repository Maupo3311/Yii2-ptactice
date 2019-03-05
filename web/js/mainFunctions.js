$(document).ready(function(){
	
	var currentSize;
	var interval;
	
	$("img").click(function(){
		zoomImage(this);
	})
	$(".arrow").click(function(){
		console.log(1);
		$(this).css('color', 'white');
	})
})

function confirmation(type){
	
	var window = document.createElement('div');
	window.id = 'alert';
	alert();
	
	if(type === 'logout'){
		
	}
}

function zoomImage(element){
	
	currentSizeWidth = document.documentElement.clientWidth;
	currentSizeHeight = document.documentElement.clientHeight;
	$('.carousel').css('opacity', '0');
	
	var background = document.createElement('div');
	background.id = 'zoomBackground';
	background.setAttribute('onclick', 'clickProcessing(event, this)');
	document.body.appendChild(background);
	
	var imageBlock = document.createElement('div');
	imageBlock.id = 'zoomImageBlock';
	if(document.documentElement.clientWidth >= 800 && document.documentElement.clientHeight >= 800){

		imageBlock.style.width = '800px';
		imageBlock.style.height = '800px';
		
		var marginTop = (document.documentElement.clientHeight - imageBlock.style.height.slice(0, -2)) / 2;
		imageBlock.style.marginTop = marginTop + 'px';
		
	} else if(document.documentElement.clientHeight < 800 && document.documentElement.clientWidth > 450){

		var bodyWidth = document.documentElement.clientHeight;
		imageBlock.style.width = bodyWidth - 50 + 'px';
		imageBlock.style.height = bodyWidth - 50 + 'px';
		var marginTop = (document.documentElement.clientHeight - imageBlock.style.height.slice(0, -2)) / 2;
		imageBlock.style.marginTop = marginTop + 'px';

	} else if(document.documentElement.clientWidth < 800 && document.documentElement.clientWidth >= 400){

		var bodyWidth = document.documentElement.clientWidth;
		imageBlock.style.width = bodyWidth - 50 + 'px';
		imageBlock.style.height = bodyWidth - 50 + 'px';
		var marginTop = (document.documentElement.clientHeight - imageBlock.style.height.slice(0, -2)) / 2;
		imageBlock.style.marginTop = marginTop + 'px';
		
	} else {

		var bodyWidth = document.documentElement.clientWidth + 'px';
		console.log(bodyWidth);
		imageBlock.style.width = bodyWidth;
		imageBlock.style.height = bodyWidth;
		imageBlock.style.marginTop = '25%';
		
	}
	background.appendChild(imageBlock);
	
	var arrowBlock = document.createElement('div');
	arrowBlock.id = 'arrowBlock';
	arrowBlock.style.width = imageBlock.clientWidth;
	arrowBlock.style.height = imageBlock.clientHeight;
	imageBlock.appendChild(arrowBlock);
	
	var next = document.createElement('div');
	next.className = 'arrow';
	next.id = 'next';
	next.style.width = imageBlock.clientWidth / 2 + 'px';
	next.style.height = imageBlock.clientHeight + 'px';
	next.innerHTML = '►';
	arrowBlock.appendChild(next);
	
	var back = document.createElement('div');
	back.className = 'arrow';
	back.id = 'back';
	back.style.width = imageBlock.clientWidth / 2 + 'px';
	back.style.height = imageBlock.clientHeight + 'px';
	back.innerHTML = '◄';
	arrowBlock.appendChild(back);
	
	
	var image = document.createElement('img');
	image.src = element.src;
	image.setAttribute('data-className', element.className);
	imageBlock.appendChild(image);
	
	processingSize(image, imageBlock);
	
	interval = setInterval(function(){
		if(currentSizeWidth != document.documentElement.clientWidth || currentSizeHeight != document.documentElement.clientHeight){
			clickProcessing('', background, true);
		}
	}, 500);
}

function clickProcessing(event, element, close = false){
	if(!close) var target = event.target;
	if(close || target.id =='zoomBackground'){
		$('.carousel').css('opacity', '1');
		element.remove();
		clearInterval(interval);
	} else if(target.className == 'arrow'){
		var currentImage = element.firstChild.lastChild;
		var images = document.getElementsByClassName(currentImage.getAttribute('data-className'));
		
		var keyCurrentImage;
		for(let count = 0; count < images.length; ++count){
			if(images[count].src == currentImage.src){
				keyCurrentImage = count;
			}
		}
		
		if(target.id == 'back'){
			
			if(keyCurrentImage == 0) return;
			currentImage.src = images[--keyCurrentImage].src;
			
		} else if(target.id == 'next'){
			
			if(keyCurrentImage == images.length - 1) return;
			currentImage.src = images[++keyCurrentImage].src;
			
		}
		
		processingSize(currentImage, currentImage.parentNode);
	}
}

function processingSize(image, imageBlock = null){

        if(image.clientWidth > image.clientHeight){
            image.style.height = null;
            image.style.width = '100%';
            image.style.margin = (imageBlock.clientHeight - image.clientHeight) / 2 + 'px 0';
        } else {
            image.style.height = '100%';
            image.style.width = null;
            image.style.margin = '0 ' + (imageBlock.clientWidth - image.clientWidth) / 2 + 'px';
        }
}


function MyAlert(action, id = null){

	var alertDiv = document.createElement('div');
	alertDiv.id = 'alertDiv';
	document.body.appendChild(alertDiv);

	if(action == 'deleteNews'){
		alertDiv.innerHTML = 'Вы уверенны что хотите удалить новость?';
	} else if(action == 'deleteNewsFiles') {
        alertDiv.innerHTML = 'Вы уверенны что хотите очистить фаилы?';
    }

	var buttonsBlock = document.createElement('p');
	alertDiv.appendChild(buttonsBlock);

	var alertTrue = document.createElement('button');
	alertTrue.innerHTML = 'Да';
	alertTrue.id = 'alertTrue';
	alertTrue.className = 'alertButton';
	alertTrue.setAttribute('onclick', 'alertTrue("' + action + '", "' + id + '")');
    buttonsBlock.appendChild(alertTrue);

	var alertFalse = document.createElement('button');
	alertFalse.innerHTML = 'Нет';
	alertFalse.id = 'alertFalse';
    alertFalse.className = 'alertButton';
    alertFalse.setAttribute('onclick', 'alertFalse(this)');
    buttonsBlock.appendChild(alertFalse);
}

function alertTrue(action, id = null){
	if(action == 'deleteNews') {
        window.location.href = '?r=news/delete-news&id=' + id;
    } else if(action == 'deleteNewsFiles'){
        window.location.href = '?r=news/update-news&deleteFiles=true&id=' + id;
	}
}

function alertFalse(element){
	element.parentNode.parentNode.remove();
}










