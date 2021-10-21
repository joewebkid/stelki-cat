let elems = document.querySelectorAll(".block-for-dot");
elems.forEach(element => {
    element.addEventListener("click",(e)=>{
        elems.forEach(element => {
            if(element.classList.contains("active")){
                element.classList.remove("active");
            }
        });
        element.classList.toggle("active");
    })
});