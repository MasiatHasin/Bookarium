//show alert
window.setTimeout(function () {
    $(".alert").slideUp(80, function () {
        $(this).remove();
    });
}, 3000);

//reload once
function loadAgain(page) {
    setTimeout(function() {
    if (localStorage.justOnce != "true") {
        localStorage.setItem("justOnce", "true");
        window.location.replace("/bookarium"+page);
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

//Advanced search Genre include exclude display and functionality
function checkbox(id){
    if (document.getElementById(id+'plus').style.display=="none" && document.getElementById(id+'minus').style.display=="none"){
        document.getElementById(id+'plus').style.display="block";
        document.getElementById(id).value="plus";
        document.getElementById(id+'box').style.backgroundColor="#7FB5FF";
        document.getElementById(id+'box').style.borderColor="#7FB5FF";
    }
    else if (document.getElementById(id+'plus').style.display=="block" && document.getElementById(id+'minus').style.display=="none"){
        document.getElementById(id+'minus').style.display="block";
        document.getElementById(id+'plus').style.display="none";
        document.getElementById(id).value="minus";
        document.getElementById(id+'box').style.backgroundColor="#7FB5FF";
        document.getElementById(id+'box').style.borderColor="#7FB5FF";
    }
    else if (document.getElementById(id+'minus').style.display=="block" && document.getElementById(id+'plus').style.display=="none"){
        document.getElementById(id+'minus').style.display="none";
        document.getElementById(id+'box').style.backgroundColor="transparent";
        document.getElementById(id+'box').style.borderColor="grey";
        document.getElementById(id).value="";
    }
}

//Advanced search filter by rating display
function rate(rating){
    rating = (rating/5)*100;
    document.getElementById('rating-advanced').style.width=rating+"%";
}

function editRate(taing, id){
    rating = (rating/5)*100;
    document.getElementById('rating-Edit'+id).style.width=rating+"%";
}

function editReview(id){
    document.getElementById('review'+id).contentEditable = "true";
    document.getElementById('review'+id).style.border = "thick solid #7FB5FF";
    padding = document.getElementById('review'+id).style.padding;
    document.getElementById('review'+id).style.padding = "10px";
    document.getElementById('edit').innerHTML = `Save
    <svg width="14px" height="14px" style="fill: white;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M433.1 129.1l-83.9-83.9C342.3 38.32 327.1 32 316.1 32H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h320c35.35 0 64-28.65 64-64V163.9C448 152.9 441.7 137.7 433.1 129.1zM224 416c-35.34 0-64-28.66-64-64s28.66-64 64-64s64 28.66 64 64S259.3 416 224 416zM320 208C320 216.8 312.8 224 304 224h-224C71.16 224 64 216.8 64 208v-96C64 103.2 71.16 96 80 96h224C312.8 96 320 103.2 320 112V208z"/>
    </svg>`;
    document.getElementById('edit').setAttribute("onclick","saveReview('"+id+"');");
    alert(document.getElementById('rating-Edit'+id).value)
    //document.getElementById('rating-Edit'+id).setAttribute("onclick","editRate("+document.getElementById('rating-Edit'+id)+",'rating-Edit'"+id+");");
}

function saveReview(id){
    document.getElementById('input'+id).setAttribute("value", (document.getElementById('review'+id).innerText || document.getElementById('review'+id).innerContent));
    document.getElementById('theForm'+id).submit();
}
