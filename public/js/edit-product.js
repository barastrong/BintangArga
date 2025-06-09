document.addEventListener('DOMContentLoaded', function() {
    // Initialize form functionality
    initializeImageUpload();
    initializeSizeToggle();
    initializeSizeImageUploads();
    initializeFormValidation();
});

// Main product image upload functionality
function initializeImageUpload() {
    const uploadSection = document.getElementById('uploadSection');
    const fileInput = document.getElementById('gambar');
    const imagePreview = document.getElementById('imagePreview');
    const changeImageBtn = document.getElementById('changeImageBtn');

    if (uploadSection && fileInput) {
        uploadSection.addEventListener('click', function() {
            fileInput.click();
        });

        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                handleImagePreview(this.files[0]);
            }
        });
    }

    if (changeImageBtn) {
        changeImageBtn.addEventListener('click', function() {
            showUploadSection();
        });
    }
}

function handleImagePreview(file) {
    const reader = new FileReader();
    
    reader.onload = function(e) {
        const uploadSection = document.getElementById('uploadSection');
        let imagePreview = document.getElementById('imagePreview');
        let changeImageBtn = document.getElementById('changeImageBtn');

        // Create preview elements if they don't exist
        if (!imagePreview) {
            imagePreview = document.createElement('div');
            imagePreview.className = 'image-preview';
            imagePreview.id = 'imagePreview';
            uploadSection.parentNode.insertBefore(imagePreview, uploadSection);
        }

        if (!changeImageBtn) {
            changeImageBtn = document.createElement('button');
            changeImageBtn.type = 'button';
            changeImageBtn.className = 'change-image-btn';
            changeImageBtn.id = 'changeImageBtn';
            changeImageBtn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Ganti Gambar';
            changeImageBtn.addEventListener('click', showUploadSection);
            uploadSection.parentNode.insertBefore(changeImageBtn, uploadSection);
        }

        // Update preview image
        imagePreview.innerHTML = `<img src="${e.target.result}" alt="Gambar Produk">`;
        
        // Show preview, hide upload section
        imagePreview.style.display = 'block';
        changeImageBtn.style.display = 'block';
        uploadSection.style.display = 'none';
    };

    reader.readAsDataURL(file);
}

function showUploadSection() {
    const uploadSection = document.getElementById('uploadSection');
    const imagePreview = document.getElementById('imagePreview');
    const changeImageBtn = document.getElementById('changeImageBtn');

    if (uploadSection) uploadSection.style.display = 'block';
    if (imagePreview) imagePreview.style.display = 'none';
    if (changeImageBtn) changeImageBtn.style.display = 'none';
}

// Size toggle functionality
function initializeSizeToggle() {
    const sizeCheckboxes = document.querySelectorAll('input[name^="size_active"]');
    
    sizeCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const sizeName = this.id.replace('size_active_', '');
            const sizeDetails = document.getElementById('size_details_' + sizeName);
            
            if (this.checked) {
                sizeDetails.classList.add('active');
                sizeDetails.style.display = 'block';
            } else {
                sizeDetails.classList.remove('active');
                sizeDetails.style.display = 'none';
                // Clear form values when unchecked
                clearSizeInputs(sizeName);
            }
        });
    });
}

function toggleSize(sizeName) {
    const checkbox = document.getElementById('size_active_' + sizeName);
    const sizeDetails = document.getElementById('size_details_' + sizeName);
    
    checkbox.checked = !checkbox.checked;
    
    if (checkbox.checked) {
        sizeDetails.classList.add('active');
        sizeDetails.style.display = 'block';
    } else {
        sizeDetails.classList.remove('active');
        sizeDetails.style.display = 'none';
        clearSizeInputs(sizeName);
    }
}

function clearSizeInputs(sizeName) {
    const hargaInput = document.getElementById(`sizes_${sizeName}_harga`);
    const stockInput = document.getElementById(`sizes_${sizeName}_stock`);
    const imageInput = document.getElementById(`sizes_${sizeName}_gambar`);
    
    if (hargaInput) hargaInput.value = '';
    if (stockInput) stockInput.value = '';
    if (imageInput) imageInput.value = '';
    
    // Reset image preview
    const imagePreview = document.getElementById(`sizeImagePreview_${sizeName}`);
    const imageUpload = document.getElementById(`sizeImageUpload_${sizeName}`);
    
    if (imagePreview) imagePreview.style.display = 'none';
    if (imageUpload) imageUpload.style.display = 'block';
}

// Size image upload functionality
function initializeSizeImageUploads() {
    const availableSizes = ['S', 'M', 'L', 'XL'];
    
    availableSizes.forEach(function(sizeName) {
        const fileInput = document.getElementById(`sizes_${sizeName}_gambar`);
        
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    handleSizeImagePreview(sizeName, this.files[0]);
                }
            });
        }
    });
}

function handleSizeImagePreview(sizeName, file) {
    const reader = new FileReader();
    
    reader.onload = function(e) {
        const imageUpload = document.getElementById(`sizeImageUpload_${sizeName}`);
        let imagePreview = document.getElementById(`sizeImagePreview_${sizeName}`);
        
        // Create preview element if it doesn't exist
        if (!imagePreview) {
            imagePreview = document.createElement('div');
            imagePreview.className = 'size-image-preview';
            imagePreview.id = `sizeImagePreview_${sizeName}`;
            imageUpload.parentNode.insertBefore(imagePreview, imageUpload);
            
            // Create change button
            const changeBtn = document.createElement('button');
            changeBtn.type = 'button';
            changeBtn.className = 'change-image-btn';
            changeBtn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Ganti';
            changeBtn.onclick = function() { changeSizeImage(sizeName); };
            imageUpload.parentNode.insertBefore(changeBtn, imageUpload);
        }

        // Update preview image
        imagePreview.innerHTML = `<img src="${e.target.result}" alt="Gambar Ukuran ${sizeName}">`;
        
        // Show preview, hide upload section
        imagePreview.style.display = 'block';
        imageUpload.style.display = 'none';
        
        // Show change button
        const changeBtn = imagePreview.nextElementSibling;
        if (changeBtn && changeBtn.classList.contains('change-image-btn')) {
            changeBtn.style.display = 'block';
        }
    };

    reader.readAsDataURL(file);
}

function changeSizeImage(sizeName) {
    const imageUpload = document.getElementById(`sizeImageUpload_${sizeName}`);
    const imagePreview = document.getElementById(`sizeImagePreview_${sizeName}`);
    const changeBtn = imagePreview ? imagePreview.nextElementSibling : null;

    if (imageUpload) imageUpload.style.display = 'block';
    if (imagePreview) imagePreview.style.display = 'none';
    if (changeBtn && changeBtn.classList.contains('change-image-btn')) {
        changeBtn.style.display = 'none';
    }
    
    // Clear the file input
    const fileInput = document.getElementById(`sizes_${sizeName}_gambar`);
    if (fileInput) fileInput.value = '';
}

// Form validation
function initializeFormValidation() {
    const form = document.getElementById('productForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });
    }
}

function validateForm() {
    let isValid = true;
    
    // Check if at least one size is selected
    const activeSizes = document.querySelectorAll('input[name^="size_active"]:checked');
    
    if (activeSizes.length === 0) {
        showAlert('Pilih minimal satu ukuran untuk produk ini!');
        scrollToElement(document.querySelector('.size-container'));
        return false;
    }

    // Validate each active size
    for (let checkbox of activeSizes) {
        const sizeName = checkbox.id.replace('size_active_', '');
        const hargaInput = document.getElementById(`sizes_${sizeName}_harga`);
        const stockInput = document.getElementById(`sizes_${sizeName}_stock`);
        
        if (!hargaInput.value || parseFloat(hargaInput.value) <= 0) {
            showAlert(`Masukkan harga yang valid untuk ukuran ${sizeName}!`);
            hargaInput.focus();
            scrollToElement(hargaInput.closest('.size-container'));
            return false;
        }
        
        if (!stockInput.value || parseInt(stockInput.value) < 0) {
            showAlert(`Masukkan stok yang valid untuk ukuran ${sizeName}!`);
            stockInput.focus();
            scrollToElement(stockInput.closest('.size-container'));
            return false;
        }
    }

    return isValid;
}

// Utility functions
function showAlert(message) {
    // Create or update alert message
    let alertElement = document.querySelector('.alert-validation');
    
    if (!alertElement) {
        alertElement = document.createElement('div');
        alertElement.className = 'alert alert-danger alert-validation';
        alertElement.style.position = 'fixed';
        alertElement.style.top = '20px';
        alertElement.style.left = '50%';
        alertElement.style.transform = 'translateX(-50%)';
        alertElement.style.zIndex = '9999';
        alertElement.style.minWidth = '300px';
        alertElement.style.textAlign = 'center';
        alertElement.style.borderRadius = '8px';
        alertElement.style.boxShadow = '0 4px 12px rgba(0,0,0,0.3)';
        document.body.appendChild(alertElement);
    }
    
    alertElement.innerHTML = `
        <i class="bi bi-exclamation-triangle me-2"></i>
        ${message}
    `;
    
    // Auto hide after 4 seconds
    setTimeout(() => {
        if (alertElement && alertElement.parentNode) {
            alertElement.parentNode.removeChild(alertElement);
        }
    }, 4000);
}

function scrollToElement(element) {
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }
}

// Input formatting for price fields
document.addEventListener('DOMContentLoaded', function() {
    const priceInputs = document.querySelectorAll('.price-input');
    
    priceInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            // Remove non-numeric characters except decimal point
            let value = this.value.replace(/[^0-9.]/g, '');
            
            // Ensure only one decimal point
            const parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts.slice(1).join('');
            }
            
            this.value = value;
        });
        
        input.addEventListener('blur', function() {
            // Format number with thousand separators for display
            if (this.value) {
                const number = parseFloat(this.value);
                if (!isNaN(number)) {
                    // You can add thousand separator formatting here if needed
                    // For now, keeping it simple
                    this.value = number.toString();
                }
            }
        });
    });
});

// Smooth animations for size containers
function addSmoothAnimations() {
    const style = document.createElement('style');
    style.textContent = `
        .size-details {
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .size-details:not(.active) {
            max-height: 0;
            padding-top: 0;
            padding-bottom: 0;
        }
        
        .size-details.active {
            max-height: 500px;
        }
    `;
    document.head.appendChild(style);
}

// Initialize smooth animations
document.addEventListener('DOMContentLoaded', addSmoothAnimations);

// Handle image drag and drop (optional enhancement)
function initializeDragAndDrop() {
    const uploadSections = document.querySelectorAll('.upload-section, .size-image-upload');
    
    uploadSections.forEach(function(section) {
        section.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.backgroundColor = 'var(--orange-light)';
            this.style.borderColor = 'var(--orange-primary)';
        });
        
        section.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.backgroundColor = '';
            this.style.borderColor = '';
        });
        
        section.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.backgroundColor = '';
            this.style.borderColor = '';
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const fileInput = this.querySelector('input[type="file"]');
                if (fileInput) {
                    fileInput.files = files;
                    const event = new Event('change', { bubbles: true });
                    fileInput.dispatchEvent(event);
                }
            }
        });
    });
}

// Initialize drag and drop
document.addEventListener('DOMContentLoaded', initializeDragAndDrop);