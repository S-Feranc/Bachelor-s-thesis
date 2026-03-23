function validateDelete() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    console.log("Number of checkboxes selected: " + checkboxes.length);
    if (checkboxes.length === 0) {
        alert("Please select at least one item to delete.");
        return false; // Prevent form submission
    } else {
        console.log("Form submitted");
        return true; // Allow form submission
    }
}

// Attach event listener to the button
document.getElementById('deleteButton').addEventListener('click', function(event) {
    if (!validateDelete()) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});

document.getElementById('deleteButtonKategoria').addEventListener('click', function(event) {
    if (!validateDelete()) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});

document.getElementById('deleteButtonTypy').addEventListener('click', function(event) {
    if (!validateDelete()) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});

document.getElementById('deleteButtonFarba').addEventListener('click', function(event) {
    if (!validateDelete()) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});


var modal5 = document.getElementById('id05');
var modal6 = document.getElementById('id06');
var modal7 = document.getElementById('id07');
var modal8 = document.getElementById('id08');
var modal9 = document.getElementById('id09');

window.onclick = function(event) {
    if (event.target == modal5) {
        modal5.style.display = "none";
    }
    if (event.target == modal6) {
        modal6.style.display = "none";
    }
    if (event.target == modal7) {
        modal7.style.display = "none";
    }
    if (event.target == modal8) {
        modal8.style.display = "none";
    }
    if (event.target == modal9) {
        modal9.style.display = "none";
    }
}

function toggleForms(showFormId) {
    document.getElementById(showFormId).style.display = 'block';
}


var x, i, j, l, ll, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
l = x.length;
for (i = 0; i < l; i++) {
    selElmnt = x[i].getElementsByTagName("select")[0];
    ll = selElmnt.length;
    /*for each element, create a new DIV that will act as the selected item:*/
    a = document.createElement("DIV");
    a.setAttribute("class", "select-selected");
    a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    x[i].appendChild(a);
    /*for each element, create a new DIV that will contain the option list:*/
    b = document.createElement("DIV");
    b.setAttribute("class", "select-items select-hide");
    for (j = 1; j < ll; j++) {
        /*for each option in the original select element,
        create a new DIV that will act as an option item:*/
        c = document.createElement("DIV");
        c.innerHTML = selElmnt.options[j].innerHTML;
        c.addEventListener("click", function(e) {
            /*when an item is clicked, update the original select box,
            and the selected item:*/
            var y, i, k, s, h, sl, yl;
            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
            sl = s.length;
            h = this.parentNode.previousSibling;
            for (i = 0; i < sl; i++) {
                if (s.options[i].innerHTML == this.innerHTML) {
                    s.selectedIndex = i;
                    h.innerHTML = this.innerHTML;
                    y = this.parentNode.getElementsByClassName("same-as-selected");
                    yl = y.length;
                    for (k = 0; k < yl; k++) {
                        y[k].removeAttribute("class");
                    }
                    this.setAttribute("class", "same-as-selected");
                    break;
                }
            }
            h.click();
        });
        b.appendChild(c);
    }
    x[i].appendChild(b);
    a.addEventListener("click", function(e) {
        e.stopPropagation();
        closeAllSelect(this);
        this.nextSibling.classList.toggle("select-hide");
        this.classList.toggle("select-arrow-active");
    });
}

function closeAllSelect(elmnt) {
    /*a function that will close all select boxes in the document,
    except the current select box:*/
    var x, y, i, xl, yl, arrNo = [];
    x = document.getElementsByClassName("select-items");
    y = document.getElementsByClassName("select-selected");
    xl = x.length;
    yl = y.length;
    for (i = 0; i < yl; i++) {
        if (elmnt == y[i]) {
            arrNo.push(i)
        } else {
            y[i].classList.remove("select-arrow-active");
        }
    }
    for (i = 0; i < xl; i++) {
        if (arrNo.indexOf(i)) {
            x[i].classList.add("select-hide");
        }
    }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);


function goToHomePage() {
    window.location.href = "katalog.php";
}

function validateInput(input) {
    var regex = /^[0-9+\-/]*$/;
    if (!regex.test(input.value)) {
        alert("Prosím zadajte čísla, +, /, -");
        input.value = input.value.replace(/[^0-9+\-/]/g, ''); // Remove any invalid characters
    }
}