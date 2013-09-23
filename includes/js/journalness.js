function ins_styles(theform,vbcode,prompttext,tag_prompt) {
	// insert [x]yyy[/x] style markup
	inserttext = prompt('Enter the text to be formatted'+"\n["+vbcode+"]xxx[/"+vbcode+"]",prompttext);
	if ((inserttext != null) && (inserttext != "")) {
		theform.value += "["+vbcode+"]"+inserttext+"[/"+vbcode+"] ";
	}
	theform.focus();
}


function ins_image(theform,prompttext) {
	// insert [x]yyy[/x] style markup
	inserttext = prompt('Enter the URL for the image'+"\n[img]"+prompttext+"xxx[/img]",prompttext);
	if ((inserttext != null) && (inserttext != "")) {
		theform.value += "[img]"+inserttext+"[/img] ";
	}
	theform.focus();
}

function ins_url(theform) {
	// inserts named url link - [url=mylink]text[/url]
	linktext = prompt('Enter the text to be displayed for the link (optional)',"");
	prompt_contents = "http://";
	linkurl = prompt('Enter the full URL for the link',prompt_contents);
	if ((linkurl != null) && (linkurl != "")) {
		if ((linktext != null) && (linktext != ""))
			theform.value += "[url="+linkurl+"]"+linktext+"[/url] ";
		else
			theform.value += "[url="+linkurl+"]"+linkurl+"[/url] ";
	}
	theform.focus();
}

function ins_quote(theform) {
	// inserts quote text [quote=name]xxx[/quote] or [quote]xxx[/quote]
	quoteuser = prompt('Enter the person who said the quote (optional)',"");
	quotetext = prompt('Enter the text of the quote',"");
	if ((quotetext != null) && (quotetext != "")) {
		if ((quoteuser != null) && (quoteuser != ""))
			theform.value += "[quote="+quoteuser+"]"+quotetext+"[/quote] ";
		else
			theform.value += "[quote]"+quotetext+"[/quote] ";
	}
	theform.focus();
}

function ins_color(theform) {
	// inserts colored text [color=colorname]xxx[/color]
	color = prompt('Enter the color as text or hex (e.g: red or #000000)',"");
	colortext = prompt('Enter the text to be colored',"");
	if ((colortext != null) && (colortext != "")) {
		if ((color != null) && (color != ""))
			theform.value += "[color="+color+"]"+colortext+"[/color] ";
	}
	theform.focus();
}

function ins_size(theform) {
	// inserts sized text [size=24]xxx[/size]
	size = prompt('Enter the size of the text (1-99)',"");
	sizetext = prompt('Enter the text to be resized',"");
	if ((sizetext != null) && (sizetext != "")) {
		if ((size != null) && (size != ""))
			theform.value += "[size="+size+"]"+sizetext+"[/size] ";
	}
	theform.focus();
}

function openpopup(popurl, w, h, sizable) {
	str = 'width='+w+',height='+h;
	if ( sizable != true ) {
		str = str + ',scrollbars=no,resizable=no,status=no';
	} else {
		str = str + ',scrollbars=yes,resizable=yes,status=yes';
	}
	window.open(popurl,'',str);
}

function addSelectOption(text, value){
	var formVal = parent.document.getElementById('entryform').pictures;

	formVal.options[formVal.options.length] = new Option(text, value);
}

// Insert Image Dropdown Menu
function ins_image_dropdown(theform,theImage) {
	if (theImage.value != 'default') {
		theform.value += theImage.value;
		theform.focus();
	}
}
