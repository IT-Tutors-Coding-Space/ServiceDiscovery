document.addEventListener('DOMContentLoaded', function () {
  let allBusinesses = []; // Store fetched businesses here

  // Fetch businesses from JSON file
  fetch('/json/businesses.json') // Adjust path if needed
    .then(response => response.json())
    .then(businesses => {
      allBusinesses = businesses; // Store fetched data
      renderBusinesses(businesses); // Render all businesses initially
    })
    .catch(error => {
      console.error('Error fetching businesses:', error);
      const businessList = document.getElementById('business-list');
      businessList.innerHTML = "<p>Error loading business data. Please try again later.</p>";
    });

  // Search and filter functionality
  document.getElementById('search-button').addEventListener('click', function () {
    const searchTerm = document.getElementById('search-input').value.toLowerCase();
    const category = document.getElementById('category-filter').value;
    const filteredBusinesses = filterBusinesses(allBusinesses, searchTerm, category);
    renderBusinesses(filteredBusinesses);
  });

  // Debounce search input for better performance
  let debounceTimer;
  document.getElementById('search-input').addEventListener('input', function () {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
      document.getElementById('search-button').click(); // Trigger search
    }, 300); // Adjust delay as needed
  });

  // Function to render businesses
  function renderBusinesses(businesses) {
    const businessList = document.getElementById('business-list');
    if (businesses.length === 0) {
      businessList.innerHTML = "<p>No businesses found matching your criteria.</p>";
    } else {
      businessList.innerHTML = businesses
        .map(
          (business) => `
          <div class="business-item">
            <h3>${business.name}</h3>
            <img src="${business.image}" alt="${business.name}" style="max-width: 150px;">
            <p>${business.description}</p>
            <p>Category: ${business.category}</p>
          </div>
        `
        )
        .join('');
    }
  }

  // Function to filter businesses
  function filterBusinesses(businesses, searchTerm, category) {
    return businesses.filter((business) => {
      return (
        (category === "All Categories" || business.category === category) &&
        business.name.toLowerCase().includes(searchTerm)
      );
    });
  }
});