// Script for index.html to list destinations
if (document.getElementById('destination-list')) {
    document.addEventListener('DOMContentLoaded', () => {
        fetch('data.json')
            .then(response => response.json())
            .then(data => {
                const destinationList = document.getElementById('destination-list');
                data.destinations.forEach(destination => {
                    const col = document.createElement('div');
                    col.classList.add('col-md-4');
                    col.innerHTML = `
                        <div class="card mb-4">
                            <img src="${destination.image}" class="card-img-top" alt="${destination.name}">
                            <div class="card-body">
                                <h5 class="card-title">${destination.name}</h5>
                                <a href="destination.html?id=${destination.id}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    `;
                    destinationList.appendChild(col);
                });
            })
            .catch(error => console.error('Error loading the data:', error));
    });
}

// Script for destination.html to display selected destination details
if (document.getElementById('destination-details')) {
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const destinationId = urlParams.get('id');

        fetch('data.json')
            .then(response => response.json())
            .then(data => {
                const destination = data.destinations.find(dest => dest.id === destinationId);

                if (destination) {
                    const detailsContainer = document.getElementById('destination-details');
                    detailsContainer.innerHTML = `
                        <h2>${destination.name}</h2>
                        <img src="${destination.image}" class="img-fluid mb-4" alt="${destination.name}">
                        
                        <h4>Must Visit Places</h4>
                        ${destination.places.map(place => `
                            <div class="mb-3">
                                <h5>${place.name}</h5>
                                <img src="${place.image}" alt="${place.name}" class="img-fluid mb-2">
                                <p>${place.description}</p>
                            </div>
                        `).join('')}
                        
                        <h4>Nearby Hotels</h4>
                        ${destination.hotels.map(hotel => `
                            <div class="mb-3">
                                <h5>${hotel.name}</h5>
                                <img src="${hotel.image}" alt="${hotel.name}" class="img-fluid mb-2">
                                <p>${hotel.description}</p>
                            </div>
                        `).join('')}
                        
                        <h4>Restaurants</h4>
                        ${destination.restaurants.map(restaurant => `
                            <div class="mb-3">
                                <h5>${restaurant.name}</h5>
                                <img src="${restaurant.image}" alt="${restaurant.name}" class="img-fluid mb-2">
                                <p>${restaurant.description}</p>
                            </div>
                        `).join('')}
                    `;
                } else {
                    document.getElementById('destination-details').innerHTML = `<p>Destination not found.</p>`;
                }
            })
            .catch(error => console.error('Error loading the data:', error));
    });
}

