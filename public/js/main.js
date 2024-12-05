// Resaltar el elemento activo
let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
    item.classList.remove("overlay-effect"); // Elimina el efecto de superposición
  });
  this.classList.add("hovered");
  this.classList.add("overlay-effect"); // Agrega el efecto de superposición
}

// Cambiar a 'click' en lugar de 'mouseover' si deseas que el efecto persista
list.forEach((item) => {
  item.addEventListener("mouseover", activeLink);
  item.addEventListener("mouseout", () => {
    item.classList.remove("overlay-effect"); // Elimina el efecto de superposición al salir
  });
});

// Menu Toggle
const toggle = document.querySelector(".toggle");
const navigation = document.querySelector(".navigation");
const main = document.querySelector(".main");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};
