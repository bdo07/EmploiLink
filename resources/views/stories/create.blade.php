<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create Story') }}
            </h2>
            <a href="{{ route('feed') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Feed
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('stories.store') }}" method="POST" enctype="multipart/form-data" id="story-form">
                        @csrf
                        
                        <!-- Media Upload Area -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">
                                Upload Photo or Video
                            </label>
                            
                            <div id="upload-area" class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center hover:border-brand-500 dark:hover:border-brand-400 transition-colors cursor-pointer">
                                <div id="upload-content">
                                    <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </div>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white mb-2">Click to upload</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">PNG, JPG, MP4 up to 20MB</p>
                                </div>
                                
                                <div id="preview-area" class="hidden">
                                    <img id="preview-image" class="mx-auto max-h-64 rounded-lg shadow-lg" alt="Preview">
                                    <video id="preview-video" class="mx-auto max-h-64 rounded-lg shadow-lg hidden" controls></video>
                                    <button type="button" id="remove-media" class="mt-4 text-red-600 hover:text-red-800 text-sm">
                                        Remove and choose different file
                                    </button>
                                </div>
                            </div>
                            
                            <input type="file" name="media" id="media-input" accept="image/*,video/*" class="hidden" required>
                            
                            @error('media')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Caption -->
                        <div class="mb-8">
                            <label for="caption" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Caption (Optional)
                            </label>
                            <textarea 
                                name="caption" 
                                id="caption" 
                                rows="3" 
                                maxlength="200"
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 dark:focus:border-brand-600 focus:ring-brand-500 dark:focus:ring-brand-600 rounded-md shadow-sm"
                                placeholder="What's happening? (Optional)"
                            ></textarea>
                            <div class="mt-1 text-right">
                                <span id="caption-count" class="text-sm text-gray-500">0/200</span>
                            </div>
                            
                            @error('caption')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Story Info -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-8">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                        Story Information
                                    </h3>
                                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>Your story will be visible for 24 hours</li>
                                            <li>Stories appear at the top of the feed</li>
                                            <li>You can see who viewed your story</li>
                                            <li>Stories are automatically deleted after 24 hours</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('feed') }}" class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                Cancel
                            </a>
                            <button type="submit" id="submit-btn" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition shadow-lg font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="submit-text">Share Story</span>
                                <span id="loading-text" class="hidden">Sharing...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadArea = document.getElementById('upload-area');
            const mediaInput = document.getElementById('media-input');
            const uploadContent = document.getElementById('upload-content');
            const previewArea = document.getElementById('preview-area');
            const previewImage = document.getElementById('preview-image');
            const previewVideo = document.getElementById('preview-video');
            const removeMedia = document.getElementById('remove-media');
            const caption = document.getElementById('caption');
            const captionCount = document.getElementById('caption-count');
            const submitBtn = document.getElementById('submit-btn');
            const submitText = document.getElementById('submit-text');
            const loadingText = document.getElementById('loading-text');
            const form = document.getElementById('story-form');

            // Upload area click handler
            uploadArea.addEventListener('click', () => {
                mediaInput.click();
            });

            // File input change handler
            mediaInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    handleFilePreview(file);
                }
            });

            // Remove media handler
            removeMedia.addEventListener('click', function(e) {
                e.stopPropagation();
                resetUpload();
            });

            // Caption character count
            caption.addEventListener('input', function() {
                captionCount.textContent = this.value.length + '/200';
            });

            // Form submission
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                loadingText.classList.remove('hidden');
            });

            function handleFilePreview(file) {
                const reader = new FileReader();
                
                if (file.type.startsWith('image/')) {
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.classList.remove('hidden');
                        previewVideo.classList.add('hidden');
                        showPreview();
                    };
                    reader.readAsDataURL(file);
                } else if (file.type.startsWith('video/')) {
                    reader.onload = function(e) {
                        previewVideo.src = e.target.result;
                        previewVideo.classList.remove('hidden');
                        previewImage.classList.add('hidden');
                        showPreview();
                    };
                    reader.readAsDataURL(file);
                }
            }

            function showPreview() {
                uploadContent.classList.add('hidden');
                previewArea.classList.remove('hidden');
                uploadArea.classList.remove('border-dashed', 'border-gray-300', 'dark:border-gray-600');
                uploadArea.classList.add('border-solid', 'border-brand-500', 'dark:border-brand-400');
            }

            function resetUpload() {
                mediaInput.value = '';
                uploadContent.classList.remove('hidden');
                previewArea.classList.add('hidden');
                previewImage.src = '';
                previewVideo.src = '';
                uploadArea.classList.remove('border-solid', 'border-brand-500', 'dark:border-brand-400');
                uploadArea.classList.add('border-dashed', 'border-gray-300', 'dark:border-gray-600');
            }

            // Drag and drop support
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('border-brand-500', 'dark:border-brand-400', 'bg-brand-50', 'dark:bg-brand-900/20');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-brand-500', 'dark:border-brand-400', 'bg-brand-50', 'dark:bg-brand-900/20');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-brand-500', 'dark:border-brand-400', 'bg-brand-50', 'dark:bg-brand-900/20');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    mediaInput.files = files;
                    handleFilePreview(files[0]);
                }
            });
        });
    </script>
</x-app-layout>
