function load(action){
var container = document.getElementsByClassName("js");
for (var i = 0; i < container.length; i++) {
	container[i].style.display = "inline-block";
}
switch(action)
{
	case 'home':
	console.log('good');
	break;
}
}