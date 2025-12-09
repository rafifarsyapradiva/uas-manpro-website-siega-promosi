<?php
/**
 * SIEGA Modal Components
 * Reusable modal dialogs for CRUD operations
 */
?>

<!-- Success Notification Modal -->
<div id="success-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeSuccessModal()"></div>
    <div class="relative bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all scale-95 opacity-0" id="success-modal-content">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-500/20 mb-4">
                <svg class="h-8 w-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Berhasil!</h3>
            <p class="text-slate-400 mb-6" id="success-message">Operasi berhasil dilakukan</p>
            <button onclick="closeSuccessModal()" class="px-6 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold transition-all">
                OK
            </button>
        </div>
    </div>
</div>

<!-- Error Notification Modal -->
<div id="error-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeErrorModal()"></div>
    <div class="relative bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all scale-95 opacity-0" id="error-modal-content">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-500/20 mb-4">
                <svg class="h-8 w-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Error!</h3>
            <p class="text-slate-400 mb-6" id="error-message">Terjadi kesalahan</p>
            <button onclick="closeErrorModal()" class="px-6 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold transition-all">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
    <div class="relative bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all scale-95 opacity-0" id="delete-modal-content">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-500/20 mb-4">
                <svg class="h-8 w-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Konfirmasi Hapus</h3>
            <p class="text-slate-400 mb-6" id="delete-message">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex space-x-3 justify-center">
                <button onclick="closeDeleteModal()" class="px-6 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-semibold transition-all">
                    Batal
                </button>
                <button id="confirm-delete-btn" class="px-6 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold transition-all">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Generic Form Modal (for Add/Edit) -->
<div id="form-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeFormModal()"></div>
    <div class="relative bg-slate-800 rounded-2xl shadow-2xl max-w-2xl w-full my-8 transform transition-all scale-95 opacity-0" id="form-modal-content">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-slate-700">
            <h3 class="text-xl font-bold text-white" id="form-modal-title">Form Title</h3>
            <button onclick="closeFormModal()" class="p-2 rounded-lg hover:bg-slate-700 text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6" id="form-modal-body">
            <!-- Form content will be injected here -->
        </div>
        
        <!-- Modal Footer -->
        <div class="flex items-center justify-end space-x-3 p-6 border-t border-slate-700">
            <button onclick="closeFormModal()" class="px-6 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-semibold transition-all">
                Batal
            </button>
            <button id="form-submit-btn" class="px-6 py-2 bg-gradient-to-r from-indigo-500 to-cyan-500 hover:from-indigo-600 hover:to-cyan-600 text-white rounded-lg font-semibold transition-all">
                Simpan
            </button>
        </div>
    </div>
</div>

<!-- Loading Spinner Modal -->
<div id="loading-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm"></div>
    <div class="relative">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-cyan-500"></div>
        <p class="text-white mt-4 text-center font-medium" id="loading-text">Memproses...</p>
    </div>
</div>

<!-- Image Preview Modal -->
<div id="image-preview-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/90 backdrop-blur-sm" onclick="closeImagePreview()"></div>
    <div class="relative max-w-4xl w-full">
        <button onclick="closeImagePreview()" class="absolute -top-12 right-0 p-2 text-white hover:text-cyan-400 transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="preview-image" src="" alt="Preview" class="w-full h-auto rounded-xl shadow-2xl">
    </div>
</div>

<script>
// Success Modal Functions
function showSuccessModal(message = 'Operasi berhasil dilakukan') {
    const modal = document.getElementById('success-modal');
    const content = document.getElementById('success-modal-content');
    const messageEl = document.getElementById('success-message');
    
    messageEl.textContent = message;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    // Auto close after 3 seconds
    setTimeout(() => {
        closeSuccessModal();
    }, 3000);
}

function closeSuccessModal() {
    const modal = document.getElementById('success-modal');
    const content = document.getElementById('success-modal-content');
    
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

// Error Modal Functions
function showErrorModal(message = 'Terjadi kesalahan') {
    const modal = document.getElementById('error-modal');
    const content = document.getElementById('error-modal-content');
    const messageEl = document.getElementById('error-message');
    
    messageEl.textContent = message;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeErrorModal() {
    const modal = document.getElementById('error-modal');
    const content = document.getElementById('error-modal-content');
    
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

// Delete Confirmation Modal Functions
let deleteCallback = null;

function showDeleteModal(message, callback) {
    const modal = document.getElementById('delete-modal');
    const content = document.getElementById('delete-modal-content');
    const messageEl = document.getElementById('delete-message');
    
    messageEl.textContent = message;
    deleteCallback = callback;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('delete-modal');
    const content = document.getElementById('delete-modal-content');
    
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        deleteCallback = null;
    }, 300);
}

// Confirm Delete Button Handler
document.getElementById('confirm-delete-btn')?.addEventListener('click', () => {
    if (deleteCallback && typeof deleteCallback === 'function') {
        deleteCallback();
    }
    closeDeleteModal();
});

// Form Modal Functions
function showFormModal(title, bodyHTML, submitCallback) {
    const modal = document.getElementById('form-modal');
    const content = document.getElementById('form-modal-content');
    const titleEl = document.getElementById('form-modal-title');
    const bodyEl = document.getElementById('form-modal-body');
    const submitBtn = document.getElementById('form-submit-btn');
    
    titleEl.textContent = title;
    bodyEl.innerHTML = bodyHTML;
    
    // Remove old event listeners and add new one
    const newSubmitBtn = submitBtn.cloneNode(true);
    submitBtn.parentNode.replaceChild(newSubmitBtn, submitBtn);
    
    newSubmitBtn.addEventListener('click', submitCallback);
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeFormModal() {
    const modal = document.getElementById('form-modal');
    const content = document.getElementById('form-modal-content');
    
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

// Loading Modal Functions
function showLoading(text = 'Memproses...') {
    const modal = document.getElementById('loading-modal');
    const textEl = document.getElementById('loading-text');
    
    textEl.textContent = text;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function hideLoading() {
    const modal = document.getElementById('loading-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Image Preview Functions
function showImagePreview(imageUrl) {
    const modal = document.getElementById('image-preview-modal');
    const img = document.getElementById('preview-image');
    
    img.src = imageUrl;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeImagePreview() {
    const modal = document.getElementById('image-preview-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Close modals on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeSuccessModal();
        closeErrorModal();
        closeDeleteModal();
        closeFormModal();
        closeImagePreview();
    }
});
</script>

<style>
@keyframes spin {
    to { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>