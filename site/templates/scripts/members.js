'use strict';

var members = document.querySelectorAll('.member-image');

// Grab all the member profile <noscript>s and convert them to Micromodal modals

console.log('fixup init');

for (var el of document.querySelectorAll('.member-profile')) {
	var modalId = 'modal-' + el.getAttribute('data-name');

	// Container
	var modal = document.createElement('div');
	modal.setAttribute('id', modalId);
	modal.setAttribute('aria-hidden', 'true');
	modal.setAttribute('class', 'modal micromodal-slide');

	// Background overlay
	var overlay = document.createElement('div');
	overlay.setAttribute('tabindex', '-1');
	overlay.setAttribute('data-micromodal-close', '');
	overlay.setAttribute('class', 'modal__overlay');
	modal.appendChild(overlay);

	// a11y container
	var aria = document.createElement('div');
	aria.setAttribute('role', 'dialog');
	aria.setAttribute('aria-modal', 'true');
	aria.setAttribute('aria-labelledby', modalId + '-title');
	aria.setAttribute('class', 'modal__container');
	overlay.appendChild(aria);

	// Modal elements
	var header = document.createElement('header');
	header.setAttribute('class', 'modal__header');
	aria.appendChild(header);

	var title = document.createElement('h2');
	title.setAttribute('id', modalId + '-title');
	title.setAttribute('class', 'modal__title');
	title.textContent = el.getAttribute('data-member-name');
	header.appendChild(title);

	var close = document.createElement('button');
	close.setAttribute('aria-label', 'Close modal');
	close.setAttribute('data-micromodal-close', '');
	close.setAttribute('class', 'modal__close');
	header.appendChild(close);

	var content = document.createElement('div');
	content.appendChild(
		document.getElementById(el.getAttribute('data-name')).cloneNode(false)
	);
	content.firstChild.setAttribute('width', '350');
	content.firstChild.setAttribute('height', '466');
	content.firstChild.setAttribute('class', '');
	content.setAttribute('class', 'modal__content');
	// TODO actually parse this and appendChild()
	content.innerHTML += el.innerHTML; // apparently whatever's inside <noscript> isn't parsed into a DOM tree in Firefox
	aria.appendChild(content);
	//while (el.childNodes.length > 0) {
	//	aria.appendChild(el.firstChild);
	//}

	// Insert modal into document
	document.body.appendChild(modal);
}

console.log('fixup finish');
console.log('binding init');

// Set up Micromodal bindings
for (var member of members) {
	member.setAttribute('data-micromodal-trigger', 'modal-' + member.id);
	//debugger;
}

console.log('binding finish')
console.log('Micromodal init');

MicroModal.init();

console.log('Micromodal finish');
