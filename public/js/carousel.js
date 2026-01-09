let position = 0;
const itemWidth = 280; // ancho del item + padding

function moveCarousel(direction) {
    const track = document.getElementById('carouselTrack');
    const maxScroll = track.scrollWidth - track.clientWidth;

    position += direction * itemWidth;

    if (position < 0) position = 0;
    if (position > maxScroll) position = maxScroll;

    track.style.transform = `translateX(-${position}px)`;
}
