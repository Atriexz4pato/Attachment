<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <!-- Tab Navigation -->
    <div class="bg-white shadow">
        <nav class="flex space-x-4 px-4 sm:px-6 lg:px-8 border-b">
            <button onclick="switchTab('dashboard')" class="tab-btn px-3 py-2 text-sm font-medium border-b-2 border-transparent hover:border-gray-300 active-tab" data-tab="dashboard">
                Dashboard
            </button>
            <button onclick="switchTab('progress')" class="tab-btn px-3 py-2 text-sm font-medium border-b-2 border-transparent hover:border-gray-300" data-tab="progress">
                Attachment Progress
            </button>
            <button onclick="switchTab('documents')" class="tab-btn px-3 py-2 text-sm font-medium border-b-2 border-transparent hover:border-gray-300" data-tab="documents">
                Documents
            </button>
        </nav>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold text-gray-700">
                            Welcome, {{ Auth::user()->name }}!
                        </h3>
                        <span class="px-3 py-1 rounded-full text-sm {{ $attachmentStatus == 'Pending' ? 'bg-yellow-100 text-yellow-800' : ($attachmentStatus == 'Approved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                            Status: {{ $attachmentStatus }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Dashboard Tab Content -->
            <div id="dashboard-tab" class="tab-content">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Quick Overview</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h4 class="font-semibold">Documents Status</h4>
                                <p class="text-sm text-gray-600">2 of 3 submitted</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <h4 class="font-semibold">Attachment Duration</h4>
                                <p class="text-sm text-gray-600">3 months remaining</p>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg">
                                <h4 class="font-semibold">Next Assessment</h4>
                                <p class="text-sm text-gray-600">In 2 weeks</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Tab Content -->
            <div id="progress-tab" class="tab-content hidden">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Attachment Progress</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="flex items-center w-full">
                                    <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white">✓</div>
                                    <div class="ml-4 flex-1">
                                        <h4 class="font-semibold">Application Submitted</h4>
                                        <p class="text-sm text-gray-600">Completed on March 1, 2024</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Add more progress steps here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents Tab Content -->
            <div id="documents-tab" class="tab-content hidden">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Required Documents</h3>
                        <div class="space-y-4">
                            <!-- Acceptance Letter Upload -->
                            <div class="border rounded-lg p-4">
                                <h4 class="font-semibold mb-2">Letter of Acceptance</h4>
                                <form action="{{ route('document.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                                    @csrf
                                    <input type="hidden" name="document_type" value="acceptance_letter">
                                    <input type="file" name="document" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                                    <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Upload</button>
                                </form>
                            </div>

                            <!-- Recommendation Letter Upload -->
                            <div class="border rounded-lg p-4">
                                <h4 class="font-semibold mb-2">Recommendation Letter</h4>
                                <form action="{{ route('document.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                                    @csrf
                                    <input type="hidden" name="document_type" value="recommendation_letter">
                                    <input type="file" name="document" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                                    <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Switching Script -->
    <script>
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-blue-500', 'text-blue-600');
                btn.classList.add('border-transparent');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-tab').classList.remove('hidden');
            
            // Add active class to selected tab
            event.currentTarget.classList.remove('border-transparent');
            event.currentTarget.classList.add('border-blue-500', 'text-blue-600');
        }
    </script>
</x-app-layout> 