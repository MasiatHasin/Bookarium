//show alert
window.setTimeout(function () {
    $(".alert").slideUp(80, function () {
        $(this).remove();
    });
}, 3000);

//reload once
function loadAgain(route) {
    setTimeout(function () {
        if (localStorage.justOnce == "false") {
            localStorage.setItem("justOnce", "true");
            window.location.replace(route);
        }
        else {
            localStorage.setItem("justOnce", "false");
        }
    }, 1000);
}


//dark mode
function getmode() {
    console.log(localStorage.bookarium);
    if (localStorage.bookarium == "yes") {
        darkmode(0);
    }
}

function darkmode(x) {
    body = document.getElementById("body");
    body.classList.toggle("body_dark");
    stock_0 = document.getElementsByClassName("stock_0");
    apply2all(stock_0, "stock_0_dark");
    stock_1 = document.getElementsByClassName("stock_1");
    apply2all(stock_1, "stock_1_dark");
    card = document.getElementsByClassName("card");
    apply2all(card, "card_dark");
    navbar = document.getElementsByClassName("navbar");
    apply2all(navbar, "navbar_dark");
    footer = document.getElementsByClassName("footer");
    apply2all(footer, "footer_dark");
    cardheader = document.getElementsByClassName("card-header");
    apply2all(cardheader, "card-header_dark");
    formcontrol = document.getElementsByClassName("form-control");
    apply2all(formcontrol, "form-control_dark");
    formselect = document.getElementsByClassName("form-select");
    apply2all(formselect, "form-select_dark");
    if (x == 1) {
        if ((localStorage.bookarium == "no") || (localStorage.bookarium == undefined)) {
            localStorage.bookarium = "yes";
        }
        else {
            localStorage.bookarium = "no";
        }
    }
    if ((localStorage.bookarium == "no") || (localStorage.bookarium == undefined)) {
        document.getElementById("moon").style.display = "block";
        document.getElementById("sun").style.display = "none";
    }
    else{
        document.getElementById("sun").style.display = "block";
        document.getElementById("moon").style.display = "none";
    }
}

function apply2all(array, property) {
    for (i = 0; i < array.length; i++) {
        array[i].classList.toggle(property);
    }
}