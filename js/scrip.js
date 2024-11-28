// Agrega un evento de clic a la imagen logo
document.querySelector('.logo-menu img').addEventListener('click', function() {
    // Muestra u oculta las opciones
    var opciones = document.querySelector('.opciones');
    opciones.style.display = opciones.style.display === 'block' ? 'none' : 'block';
  });
  




  /*carrucel*/
  // script.js
const images = document.querySelector('.carousel-images');
const imageCount = images.children.length;
let index = 0;

function showNextImage() {
    index = (index + 1) % imageCount;
    const offset = -index * 100; // Mueve el carrusel hacia la izquierda
    images.style.transform = `translateX(${offset}%)`;
}

setInterval(showNextImage, 3000); // Cambia la imagen cada 3 segundos


