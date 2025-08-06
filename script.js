let menu = document.querySelector('#menu-btn');
let navbar = document.querySelector('.header .navbar');

menu.onlick = () =>{
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
};

window.onscroll = () =>{
    menu.classList.remove('fa-times');
    navbar.classList.remove('active');
};

var swiper = new Swiper(".home-slider", {
    loop:true,
    navigation: {
        nextE1: ".swiper-button-next",
        prevE1: ".swiper-button-prev",
    },
});

var swiper = new Swiper(".reviews-slider", {
    loop:true,
    spaceBetween: 20,
    autoHeight: true,
    grabCursor: true,
    breakpoints: {
        640: {
            slidesPerView: 1,    
        },
        768: {
            slidesPerView: 2,   
        },
        1024: {
            slidesPerView: 3,
        },
    },
});
var check=document.querySelector(".check");
check.addEventListener('click',idioma);

function idioma(){
   let.id=check.checked;
   if(id==true){
      location.href="English/home.html";
   }else{
      location.href="../home.html";
   }
}

let loadMoreBtn = document.querySelector('.packages .load-more .btn');
let currentItem = 3;

loadMoreBtn.onclick = () =>{
   let boxes = [...document.querySelectorAll('.packages .box-container .box')];
   for (var i = currentItem; i < currentItem + 3; i++){
      boxes[i].style.display = 'inline-block';
   };
   currentItem += 3;
   if(currentItem >= boxes.length){
      loadMoreBtn.style.display = 'none';
   }
}

var check=document.querySelector(".check");
check.addEventListener('click',idioma);

function idioma(){
   let id=check.checked;
   if(id==true){
      location.href="../home.html";
   }else{
      location.href="English/home.html";
   }
}

const flagsElement = document.getElementById("flags");

const textToChange = document.querySelectorAll("[data-section]");

const changeLanguage = async language =>{
     const requestJson = await fetch('./languages/${language}.json')
     const texts = await requestJson.json()

    for(const textToChange of textToChange){
         const section = textToChange.dataset.section
         const value = textToChange.dataset.value

         textToChange.innerHTML=texts[section][value]
    }

}

flagsElement.addEventListener("click", (e) =>{
   changeLanguage(e.target.parentElement.dataset.language);
});