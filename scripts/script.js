<!--
function showMenu(id) {
	el_menu = document.getElementById('menu').childNodes;
	el_sub = document.getElementById('submenu').childNodes;
	for (i=0; i< el_menu.length; i++) {
		if (el_menu[i].nodeName == 'A') {
			el_menu[i].className = '';
		}
	}
	for (i=0; i< el_sub.length; i++) {
		el = el_sub[i];
		if (el.nodeName == 'DIV') {
			el.className = 'hidden_submenu';
		}
	}
	document.getElementById('submenu'+id).className = '';
	document.getElementById('menu'+id).className = 'active_menu';
	document.getElementById('menu'+current).className = 'current_menu';
	if (id == current) {
		document.getElementById('menu'+current).className = 'active_menu current_menu';
	}
}
function activeSearch(el) {
	var text = 'search...';
	if ( el.value == text ) {
		el.value = '';
	} else if( !el.value ) {
		el.value = text;
	}
}
function highlight(el) {
	if ( HasClassName(el,'hover') ) {
		RemoveClassName(el,'hover');
	} else {
		AddClassName(el,'hover',true);
	}
}
function highlight_old(el) {
	if ( el.className == 'hover') {
		el.className = '';
	} else {
		el.className = 'hover';
	}
}

// -->