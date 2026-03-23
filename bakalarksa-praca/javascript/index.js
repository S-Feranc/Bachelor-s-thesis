function validateInput(input) {
    var regex = /^[0-9+\-/]*$/;
    if (!regex.test(input.value)) {
        alert("Prosím zadajte čísla, +, /, -");
        input.value = input.value.replace(/[^0-9+\-/]/g, ''); // Remove any invalid characters
    }
}
var modal1 = document.getElementById('id01');
var modal2 = document.getElementById('id02');
var modal3 = document.getElementById('id03');

window.onclick = function(event) {
    if (event.target == modal1) {
        modal1.style.display = "none";
    }
    if (event.target == modal2) {
        modal2.style.display = "none";
    }
    if (event.target == modal3) {
        modal3.style.display = "none";
    }
}

function toggleForms(showFormId, hideFormId) {
    document.getElementById(showFormId).style.display = 'block';
    document.getElementById(hideFormId).style.display = 'none';
}
