window.onload = function() {
	document.querySelector('#default-open').click();
}

function openNav() {
	document.getElementById("sidenav-media").style.display = "block";
	document.getElementById("sidenav-media").style.width = "60%";
}

function closeNav() {
	document.getElementById("sidenav-media").style.display = "none";
	document.getElementById("sidenav-media").style.width = "0";
	document.getElementById("main").style.marginLeft= "0";
}

var modifyDegree = document.getElementById('degree-form');

const openAdminTab = (e, tabName) => {
	let i, tabcontent, tablink;

	tabcontent = document.querySelectorAll('.tabcontent');
	for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = 'none';
	}

	tablinks = document.querySelectorAll('.tablinks');
	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace('active', '');
	}

	document.getElementById(tabName).style.display = 'block';
	event.currentTarget.className += " active";

	var xhr = new XMLHttpRequest();
	xhr.open('POST', '/kevin1026/xhradmin/', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.send('m=' + tabName);

	xhr.onreadystatechange = function() {
		if (xhr.readyState === 4 && xhr.status === 200) {
			document.getElementById(tabName).innerHTML = xhr.responseText;

		}
	}
}

const openDegreeModal = (e, tabName) => {
	let degreeModal = document.getElementById('degree-modal');
	let degreeContent = document.getElementById('degree-content');
	let closeDegree = document.getElementById('degree-close');

	degreeModal.style.display = 'block';

	closeDegree.onclick = function() {
		degreeModal.style.display = 'none';
	}

	window.onclick = function(evt) {
		if (evt.target == degreeModal) {
			degreeModal.style.display = 'none';
		}
	}

	var xhr = new XMLHttpRequest();
	xhr.open('POST', './xhradmin/degrees/view/', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.send('degrees=' + tabName);

	xhr.onreadystatechange = function() {
		if (xhr.readyState === 4 && xhr.status === 200) {
			document.getElementById('degree-content').innerHTML = xhr.responseText;
		}
	}
}

const addNewDegree = (e) => {
	let degreeModal = document.getElementById('new-degree-modal');
	let degreeContent = document.getElementById('new-degree-content');
	let closeDegree = document.getElementById('new-degree-close');

	degreeModal.style.display = 'block';

	closeDegree.onclick = function() {
		degreeModal.style.display = 'none';
	}

	window.onclick = function(evt) {
		if (evt.target == degreeModal) {
			degreeModal.style.display = 'none';
		}
	}
}

const editDegree = (e, baseTitle) => {
	e.preventDefault();
	var form = e.target;
	
	var xhr = new XMLHttpRequest();
	xhr.responseType = 'json';
	xhr.open('POST', './xhradmin/degrees/edit/', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send('title=' + form['title'].value + '&year=' + form['year'].value + '&finished=' + form['finished'].checked + '&structure=' + form['structure'].value + '&base-title=' + baseTitle + '&mode=edit');

	xhr.onreadystatechange = function(evt) {
		if (this.readyState === 4 && this.status === 200) {
			window.location.href = './backoffice/home/';
		} else {
			// Show snackbar
		}
	}
}

const submitDegree = e => {
	e.preventDefault();
	
	let xhttp = new XMLHttpRequest();
	let form = e.currentTarget;

	xhttp.responseType = 'json';
	xhttp.open('POST', './xhradmin/degrees/submit', true);
	xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhttp.send('mode=submit&title=' + form['title'].value + '&year=' + form['year'].value + '&finished=' + form['finished'].checked + '&structure=' + form['structure'].value);

	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			window.location.href = './backoffice/home/';
		} else {
			// Show snackbar
		}
	}
}

const deleteDegree = (e, key) => {
	var xhr = new XMLHttpRequest();
	xhr.open('POST', './xhradmin/degrees/delete/', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send('key=' + key + '&mode=delete');

	xhr.onreadystatechange = function(e) {
		if (this.status === 200 && this.readyState === 4) {
			window.location.href = './backoffice/home/';
		} else {
			// Show snackbar
		}
	}
}

const openInterestModal = (e, iName) => {
	e.preventDefault();

	let interestModal = document.getElementById('interest-modal');
	let interestContent = document.getElementById('interest-content');
	let closeInterest = document.getElementById('interest-close');

	interestModal.style.display = 'block';

	closeInterest.onclick = function() {
		interestModal.style.display = 'none';
	}

	window.onclick = function(evt) {
		if (evt.target == interestModal) {
			interestModal.style.display = 'none';
		}
	}

	var xhr = new XMLHttpRequest();
	xhr.open('POST', './xhradmin/interests/view/', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.send('interest=' + iName);

	xhr.onreadystatechange = function() {
		if (xhr.readyState === 4 && xhr.status === 200) {
			document.getElementById('interest-content').innerHTML = xhr.responseText;
		}
	}
}

const editInterest = (e, baseTitle) => {
	e.preventDefault();

	console.log(baseTitle);

	const formData = new FormData(e.target);
	formData.append('mode', 'edit');
	formData.append('key', baseTitle);
	console.log(formData);

	var xhr = new XMLHttpRequest();
	xhr.open('POST', './xhradmin/interests/edit/', true);

	xhr.send(formData);

	xhr.onreadystatechange = function(e) {
		if (this.readyState === 4 && this.status === 200) {
			window.location.href = './backoffice/home/';
		} else {
			// Show snackbar
		}
	}
}

const deleteInterestPicture = (e, keyName, pictureName) => {
	console.log('here');

	var xhr = new XMLHttpRequest();
	xhr.responseType = 'json';
	xhr.open('POST', './xhradmin/interests/deletePicture/', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send('key=' + keyName + '&name=' + pictureName + '&mode=deletePicture');

	xhr.onreadystatechange = function(evt) {
		if (this.readyState === 4 && this.status === 200) {
			if (this.response[0] === 'ok') {
				document.getElementById('picture-' + pictureName).remove();
			} else {
				// Show snackbar
			}
		}
	}
}

const deleteInterest = (e, key) => {
	var xhr = new XMLHttpRequest();
	xhr.open('POST', './xhradmin/interests/delete/', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send('key=' + key + '&mode=delete');

	xhr.onreadystatechange = function(evt) {
		if (this.status === 200 && this.readyState === 4) {
			if (this.responseText === 'ok') {
				window.location.href = './backoffice/home/';
			} else {
				// Show snackbar
			}
		}
	}
}


const addNewInterest = (e) => {
	let interestModal = document.getElementById('new-interest-modal');
	let closeModal = document.getElementById('new-interest-close');

	interestModal.style.display = 'block';

	closeModal.onclick = function() {
		interestModal.style.display = 'none';
	}

	window.onclick = function(evt) {
		if (evt.target == interestModal) {
			interestModal.style.display = 'none';
		}
	}
}

const submitInterest = (e) => {
	e.preventDefault();

	var form = event.target;
	const formData = new FormData(e.target);
	formData.append('mode', 'submit');
	console.log(formData);

	var xhr = new XMLHttpRequest();
	xhr.open('POST', './xhradmin/interests/submit/', true);
	xhr.send(formData);

	xhr.onreadystatechange = function(e) {
		if (this.readyState === 4 && this.status === 200) {
			window.location.href = './backoffice/home/';
		}
	}

}

const openMessage = (e, mailId) => {

	var formData = new FormData();
	formData.append('messageId', mailId);

	fetch('?action=contact&settings=backoffice&getMailContent', {method: "POST", body: formData})
	.then(function(response) {
		return response.text();
	})
	
	.then(function(body) {
		const mailContent = document.getElementById('mail-content');

		mailContent.style.display = 'block';
		mailContent.textContent = body;
	})

	.catch(function(err) {
		console.log(err);
	})
}

const markAsAnswered = (e, mailId) => {

	var formData = new FormData();
	formData.append('messageId', mailId);

	fetch('?action=contact&settings=backoffice&answerMail', {method: "POST", body: formData})
	.then(function(response) {
		return response.text();
	})
	
	.then(function(body) {
		showSnackbar.call(this, body);
	})

	.catch(function(err) {
		console.log(err);
	})
}
