document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle
    const sidebar = document.querySelector('.sidebar');
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebarToggle = document.querySelector('.sidebar-toggle');

    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.remove('active');
        });
    }

    // Click outside to close sidebar on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 991) {
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
    });

    // Initialize DataTables
    if ($.fn.DataTable) {
        $('.data-table').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
        });
    }

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Update current time in navbar
    function updateTime() {
        const now = new Date();
        const options = {
            weekday: 'short',
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        const timeElement = document.querySelector('.navbar-time');
        if (timeElement) {
            timeElement.textContent = now.toLocaleDateString('en-US', options);
        }
    }

    updateTime();
    setInterval(updateTime, 60000); // Update every minute

    // Confirm delete actions
    const deleteForms = document.querySelectorAll('form[data-confirm]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this item?')) {
                e.preventDefault();
            }
        });
    });

    // Image preview on file input
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let preview = input.parentElement.querySelector('.image-preview');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.className = 'image-preview mt-2';
                        preview.style.maxWidth = '200px';
                        preview.style.borderRadius = '8px';
                        input.parentElement.appendChild(preview);
                    }
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    });
});
