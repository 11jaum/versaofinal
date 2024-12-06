let currentIndex = 0;

function updateCarousel() {
  const images = document.querySelector('.carousel-images');
  const totalImages = images.children.length;

  currentIndex = (currentIndex + 1) % totalImages; // Vai para a próxima imagem
  images.style.transform = `translateX(-${currentIndex * 100}%)`; // Desliza para a próxima
}

// Troca de imagem a cada 3 segundos
setInterval(updateCarousel, 3000);
