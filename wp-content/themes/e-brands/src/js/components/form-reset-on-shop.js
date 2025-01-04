const formRestOnClear =() =>{

    let clearSearchfield = document.querySelector('.cl-product-search-filter');
    let searchField = document.getElementById('filter-by-search_key');
    let categoryDropdown = document.getElementById('filter-by-category');
    let brandDropdown = document.getElementById('filter-by-brand');
    let clearCategoryButton = document.querySelector('.cl-product-cat-filter');
    let clearBrandButton = document.querySelector('.cl-product-brand-filter');

// Event listener for clearing search field
    clearSearchfield.addEventListener('click', e => {
        e.preventDefault();
        searchField.value = '';
        clearURLParameters();
    });

// Event listener for clearing category dropdown
    clearCategoryButton.addEventListener('click', e => {
        e.preventDefault();
        categoryDropdown.selectedIndex = 0;
        clearURLParameters();
    });

// Event listener for clearing brand dropdown
    clearBrandButton.addEventListener('click', e => {
        e.preventDefault();
        brandDropdown.selectedIndex = 0;
        clearURLParameters();
    });

// Function to clear URL parameters
    function clearURLParameters() {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.delete('search_key');
        urlParams.delete('category');
        urlParams.delete('brand');

        history.replaceState(null, '', window.location.pathname + '?' + urlParams.toString());
    }

    // customJquery();

};

export default formRestOnClear;