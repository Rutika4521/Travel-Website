$(document).ready(function () {
    if ($('#destination-carousel-items').length) {
        $.getJSON('data.json', function (data) {
            const carouselInner = $('#destination-carousel-items');
            let isActiveSet = false;
            let currentItem = null;
            let itemCount = 0;

            // Create carousel items, with 3 cards per row
            data.destinations.forEach((destination, index) => {
                // Create a new carousel item with a horizontal row layout for every 3 cards
                if (itemCount % 3 === 0) {
                    currentItem = $('<div class="carousel-item"><div class="row"></div></div>');
                    if (!isActiveSet) {
                        currentItem.addClass('active');
                        isActiveSet = true;
                    }
                    carouselInner.append(currentItem);
                }

                // Create card
                const card = `
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="${destination.image}" class="card-img-top" alt="${destination.name}">
                            <div class="card-body">
                                <h5 class="card-title">${destination.name}</h5>
                                <a href="destination.html?id=${destination.id}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                `;

                // Append the card to the current row in the carousel item
                currentItem.find('.row').append(card);

                itemCount++;
            });
        }).fail(function () {
            console.error('Error loading the data.');
        });
    }
});


$(document).ready(function() {
    // Check if the destination details element exists
    if ($('#destination-details').length) {
        const urlParams = new URLSearchParams(window.location.search);
        const destinationId = urlParams.get('id');

        $.getJSON('data.json', function(data) {
            const destination = data.destinations.find(dest => dest.id === destinationId);

            if (destination) {
                const detailsContainer = $('#destination-details');
                detailsContainer.html(`
                    <h1>${destination.name}</h1>
                    <img src="${destination.image}" class="img-fluid mb-4" alt="${destination.name}">

                    <h2>Must Visit Places</h2>
                    ${destination.places.map(place => `
                        <div class="mb-3">
                            <h2>${place.name}</h2>
                            <img src="${place.image}" alt="${place.name}" class="img-fluid mb-2">
                            <p>${place.description}</p>
                        </div>
                    `).join('')}

                    <h2>Nearby Hotels</h2>
                    ${destination.hotels.map(hotel => `
                        <div class="mb-3">
                            <h2>${hotel.name}</h2>
                            <img src="${hotel.image}" alt="${hotel.name}" class="img-fluid mb-2">
                            <p>${hotel.description}</p>
                        </div>
                    `).join('')}

                    <h4>Restaurants</h4>
                    ${destination.restaurants.map(restaurant => `
                        <div class="mb-3">
                            <h2>${restaurant.name}</h2>
                            <img src="${restaurant.image}" alt="${restaurant.name}" class="img-fluid mb-2">
                            <p>${restaurant.description}</p>
                        </div>
                    `).join('')}
                `);
            } else {
                $('#destination-details').html('<p>Destination not found.</p>');
            }
        }).fail(function() {
            console.error('Error loading the data.');
        });
    }
});

let slideIndex = 0;

function showSlides(n) {
  const slides = document.querySelectorAll('.slide');
  if (n >= slides.length) slideIndex = 0;
  if (n < 0) slideIndex = slides.length - 1;
  slides.forEach((slide, index) => {
    slide.style.display = index === slideIndex ? 'block' : 'none';
  });
}