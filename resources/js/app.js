import './bootstrap';

//clear the search input
var clearBtn = document.querySelector('#clear');
var input = document.querySelector('#input');
clearBtn.onclick = clearInput;

function clearInput(){
    input.value = '';
}
