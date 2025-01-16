<?= $this->extend('layouts/default'); ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header text-bg-primary">
                <div class="card-title">
                    Daftar Produk
                </div>
            </div>
            <div class="card-body">
                <!-- New Product Button -->
                <div class="mb-3">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newProductModal">New Product</button>
                </div>

                <!-- Fetch Button -->
                <div class="mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmFetchModal">Fetch</button>
                </div>

                <!-- Filters -->
                <div class="mb-3">
                    <label for="statusFilter">Filter by Status</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="bisa dijual">Bisa Dijual</option>
                        <option value="tidak bisa dijual">Tidak Bisa Dijual</option>
                    </select>
                </div>

                <!-- Table -->
                <table class="table table-striped table-bordered" id="productTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Action</th> <!-- New Action Column -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Product rows will be inserted here by JS -->
                    </tbody>
                </table>

                <!-- Pagination Controls -->
                <nav id="paginationControls">
                    <ul class="pagination justify-content-center">
                        <!-- Pagination items will be inserted here by JS -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmFetchModal" tabindex="-1" aria-labelledby="confirmFetchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmFetchModalLabel">Confirm Fetch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to fetch the data? This will update the existing product list.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="/fetch" id="confirmFetch" class="btn btn-primary">Yes, Fetch Data</a>
            </div>
        </div>
    </div>
</div>
<!-- New Product Modal (for adding new products) -->
<div class="modal fade" id="newProductModal" tabindex="-1" aria-labelledby="newProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newProductModalLabel">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newProductForm">
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" required>
                    </div>
                    <div class="mb-3">
                        <label for="productPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="productPrice" required>
                    </div>
                    <div class="mb-3">
                        <label for="productCategory" class="form-label">Category</label>
                        <select id="productCategory" class="form-select" required>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="productStatus" class="form-label">Status</label>
                        <select id="productStatus" class="form-select" required>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm">
                    <input type="hidden" id="editProductId">
                    <div class="mb-3">
                        <label for="editProductName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="editProductName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editProductPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="editProductPrice" required>
                    </div>
                    <div class="mb-3">
                        <label for="editProductCategory" class="form-label">Category</label>
                        <select id="editProductCategory" class="form-select" required>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editProductStatus" class="form-label">Status</label>
                        <select id="editProductStatus" class="form-select" required>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script>
    // Sample products data (this will come from PHP)
    const products = <?= json_encode($products); ?>;
    const categories = <?= json_encode($productCategories); ?>;
    const statuses = <?= json_encode($productStatuses); ?>;
    const itemsPerPage = 5;
    let currentPage = 1;
    let productToDelete = null; // Store the product to delete
    let productToEdit = null; // Store the product to edit

    // Function to render products table
    function renderTable(page = 1, statusFilter = '') {
        const filteredProducts = products.filter(product => {
            return statusFilter ? product.productStatus.toLowerCase() === statusFilter.toLowerCase() : true;
        });

        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, filteredProducts.length);
        const currentPageProducts = filteredProducts.slice(startIndex, endIndex);

        // Clear the current table content
        $('#productTable tbody').empty();

        // Insert new rows with Action buttons
        currentPageProducts.forEach((product, index) => {
            const row = `
                <tr>
                    <td>${startIndex + index + 1}</td>
                    <td>${product.productName}</td>
                    <td>${product.productPrice}</td>
                    <td>${product.productCategory}</td>
                    <td>${product.productStatus}</td>
                    <td class="d-flex gap-2">
                        <button class="btn btn-info btn-sm" onclick="editProduct(${startIndex + index})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete(${startIndex + index})">Delete</button>
                    </td>
                </tr>
            `;
            $('#productTable tbody').append(row);
        });
        renderPagination(filteredProducts.length, page);
    }

    // Function to render pagination controls
    function renderPagination(totalItems, currentPage) {
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        const $pagination = $('#paginationControls ul');
        $pagination.empty();
        const pageLimit = 5; // The maximum number of page links to show at onc
        // Calculate the range of pages to display
        let startPage = Math.max(currentPage - Math.floor(pageLimit / 2), 1);
        let endPage = Math.min(startPage + pageLimit - 1, totalPages);

        // Adjust the range if there's not enough room on the left or right
        if (endPage - startPage + 1 < pageLimit) {
            startPage = Math.max(endPage - pageLimit + 1, 1);
        }
        // First page button
        if (currentPage > 1) {
            $pagination.append(`
                <li class="page-item">
                    <a class="page-link" href="#" onclick="changePage(1)">First Page</a>
                </li>
            `);
        }
        // Previous page button
        if (currentPage > 1) {
            $pagination.append(`
                <li class="page-item">
                    <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Previous</a>
                </li>
            `);
        }
        // Ellipsis if there are pages before the first visible range
        if (startPage > 1) {
            $pagination.append(`
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            `);
        }

        // Page numbers
        for (let i = startPage; i <= endPage; i++) {
            const activeClass = i === currentPage ? 'active' : '';
            $pagination.append(`
                <li class="page-item ${activeClass}">
                    <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                </li>
            `);
        }
        // Ellipsis if there are pages after the last visible range
        if (endPage < totalPages) {
            $pagination.append(`
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            `);
        }
        // Next page button
        if (currentPage < totalPages) {
            $pagination.append(`
                <li class="page-item">
                    <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Next</a>
                </li>
            `);
        }
        // Last page button
        if (currentPage < totalPages) {
            $pagination.append(`
                <li class="page-item">
                    <a class="page-link" href="#" onclick="changePage(${totalPages})">Last Page</a>
                </li>
            `);
        }
    }

    // Function to change the page
    function changePage(page) {
        currentPage = page;
        const statusFilter = $('#statusFilter').val();
        renderTable(page, statusFilter);
    }

    // Filter products when status is changed
    $('#statusFilter').change(function() {
        currentPage = 1; // Reset to first page when filter changes
        const statusFilter = $(this).val();
        renderTable(currentPage, statusFilter);
    });

    // Function to confirm delete action
    function confirmDelete(index) {
        productToDelete = products[index]; // Store the product to delete
        $('#deleteConfirmationModal').modal('show');
    }

    // Function to show Bootstrap Toast
    function showToast(message, title = 'Notification', isSuccess = true) {
        const toastEl = $('#toastMessage');
        $('#toastBody').text(message);
        $('#toastTitle').text(title);

        // Add classes for success or error styles
        if (isSuccess) {
            toastEl.removeClass('bg-danger').addClass('bg-success text-white');
        } else {
            toastEl.removeClass('bg-success').addClass('bg-danger text-white');
        }

        const toast = new bootstrap.Toast(toastEl[0]);
        toast.show();
    }

    // delete function
    $('#confirmDeleteBtn').click(function() {
        if (!productToDelete) return;

        $.ajax({
            url: `/${productToDelete.productId}`, // Change this URL to match your route
            method: 'DELETE',
            success: function(response) {
                console.log(response);
                console.log(response.success);

                // Handle success response
                if (response.success) {
                    showToast('Product deleted successfully!', 'Success', true);
                    // Re-render table
                    location.reload();
                } else {
                    showToast('Failed to delete the product.', 'Error', false);
                }
            },
            error: function() {
                showToast('An error occurred while deleting the product.', 'Error', false);
            }
        });

        $('#deleteConfirmationModal').modal('hide');
    });

    // Fetch categories from the controller and populate the select options
    function populateCategories() {
        // Populate categories for Add New Product form
        const categorySelect = $('#productCategory');
        categorySelect.empty();
        categories.forEach(category => {
            categorySelect.append(`<option value="${category.categoryId}">${category.categoryName}</option>`);
        });


        // Populate categories for Edit Product form
        const editCategorySelect = $('#editProductCategory');
        editCategorySelect.empty();
        categories.forEach(category => {
            editCategorySelect.append(`<option value="${category.categoryId}">${category.categoryName}</option>`);
        });
    }

    function populateStatuses() {
        const statusSelects = [$('#productStatus'), $('#editProductStatus')]; // Target both select elements for status
        statusSelects.forEach(statusSelect => {
            statusSelect.empty(); // Clear current options
            statuses.forEach(status => {
                statusSelect.append(`<option value="${status.statusId}">${status.statusName}</option>`);
            });
        });
    }

    // When Add New Product modal is opened
    $('#newProductModal').on('show.bs.modal', function() {
        populateCategories();
        populateStatuses();
    });

    // Function to open the Edit modal and populate the form
    function editProduct(index) {
        productToEdit = products[index];
        populateCategories();
        populateStatuses();
        $('#editProductId').val(productToEdit.productId);
        $('#editProductName').val(productToEdit.productName);
        $('#editProductPrice').val(productToEdit.productPrice);
        $('#editProductCategory').val(categories.find((category) => category.categoryName === productToEdit.productCategory).categoryId)
        $('#editProductStatus').val(statuses.find((status) => status.statusName === productToEdit.productStatus).statusId)
        $('#editProductModal').modal('show');
    }
    // Handle New Product form submission
    $('#newProductForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        const newProduct = {
            productName: $('#productName').val(),
            productPrice: $('#productPrice').val(),
            productCategory: $('#productCategory').val(),
            productStatus: $('#productStatus').val()
        };

        $.ajax({
            url: '/',
            method: 'POST',
            data: newProduct,
            success: function(response) {
                console.log(response);
                console.log(response.data);

                if (response.success) {
                    showToast('New product added successfully!', 'Success', true);
                    location.reload();
                } else {
                    showToast('Failed to add the new product.', 'Error', false);
                }
            },
            error: function() {
                showToast('An error occurred while adding the new product.', 'Error', false);
            }
        });

        $('#newProductModal').modal('hide');
    });

    // Handle Edit form submission
    $('#editProductForm').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        const updatedProduct = {
            productName: $('#editProductName').val(),
            productPrice: $('#editProductPrice').val(),
            productCategory: $('#editProductCategory').val(),
            productStatus: $('#editProductStatus').val()
        };

        $.ajax({
            url: `/${$('#editProductId').val()}`, // Update this URL to match your backend route
            method: 'PUT',
            data: updatedProduct,
            success: function(response) {
                console.log(response);
                if (response.success) {
                    showToast('Product updated successfully!', 'Success', true);
                    location.reload(); // Reload the page to show updated data
                } else {
                    showToast('Failed to update the product.', 'Error', false);
                }
            },
            error: function() {
                showToast('An error occurred while updating the product.', 'Error', false);
            }
        });

        $('#editProductModal').modal('hide');
    });


    // Initial render
    renderTable(currentPage);
</script>
<?= $this->endSection() ?>