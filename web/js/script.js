//form scripts
// adding form mask
// ----------------------
document.addEventListener('DOMContentLoaded', () => {

    const inputElements = document.querySelectorAll('.tel')
    const maskOptions = {
      mask: '+{7}(000)000-00-00'
    }
    inputElements.forEach(function(element) {
      IMask(element, maskOptions)
    });
  
  })

document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".form-item__input").forEach((element) => {
    if (element.value == "") {
      element.classList.remove("active");
    } else {
      element.classList.add("active");
    }
  });
});

// ------------------

// form lables interactive
// ----------------------
document.querySelectorAll('.form-item__input').forEach(element => {
  element.addEventListener('click', ()=>{
    element.classList.add('active');
  });
 
    element.nextElementSibling.addEventListener('click', ()=>{
    element.focus();
    element.classList.add('active');
  });
    element.addEventListener('blur', ()=>{
    if (element.value=="")
    element.classList.remove('active');
  });
});
// /------------------