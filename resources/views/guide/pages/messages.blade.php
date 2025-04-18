@extends('guide.layouts.guide')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-comments text-adventure-blue mr-3"></i>
        Messages
    </h1>
    <button onclick="openNewMessageModal()" 
            class="bg-adventure-green hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg flex items-center">
        <i class="fas fa-plus mr-2"></i> New Message
    </button>
</div>

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    @if ($messages->isEmpty())
        <div class="p-12 text-center">
            <i class="fas fa-envelope-open-text text-5xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-500">No messages yet</h3>
            <p class="text-gray-400 mt-2">Start a conversation with your travelers</p>
            <button onclick="openNewMessageModal()" 
                    class="mt-6 bg-adventure-blue hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg inline-flex items-center">
                <i class="fas fa-paper-plane mr-2"></i> Send Message
            </button>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3">
            <!-- Message List -->
            <div class="border-r border-gray-200">
                <div class="p-4 border-b border-gray-200 bg-gray-50">
                    <div class="relative">
                        <input type="text" placeholder="Search messages..." 
                               class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-300 focus:ring-adventure-blue focus:border-adventure-blue">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <div class="divide-y divide-gray-200 max-h-[600px] overflow-y-auto">
                    @foreach ($messages as $message)
                        <div class="p-4 hover:bg-blue-50 cursor-pointer transition-colors duration-200 {{ $loop->first ? 'bg-blue-50' : '' }}">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-adventure-blue text-white flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($message->sender_id === Auth::id() ? 'Y' : 'T', 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">
                                        {{ $message->sender_id === Auth::id() ? 'You' : 'Traveller' }}
                                        <span class="text-xs text-gray-500 ml-2">{{ $message->created_at->diffForHumans() }}</span>
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">{{ Str::limit($message->message, 50) }}</p>
                                </div>
                                @if(!$message->read_at && $message->receiver_id === Auth::id())
                                    <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Message Content -->
            <div class="lg:col-span-2">
                <div class="p-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800">Conversation with Traveller</h3>
                    <div class="flex space-x-2">
                        <button class="text-gray-500 hover:text-adventure-blue p-1 rounded-full hover:bg-gray-100">
                            <i class="fas fa-phone-alt"></i>
                        </button>
                        <button class="text-gray-500 hover:text-adventure-blue p-1 rounded-full hover:bg-gray-100">
                            <i class="fas fa-video"></i>
                        </button>
                        <button class="text-gray-500 hover:text-adventure-blue p-1 rounded-full hover:bg-gray-100">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                    </div>
                </div>
                <div class="p-4 h-[500px] overflow-y-auto bg-gray-50">
                    @foreach ($messages as $message)
                        <div class="mb-4 flex {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg 
                                      {{ $message->sender_id === Auth::id() ? 'bg-adventure-blue text-white' : 'bg-white shadow' }}">
                                <p>{{ $message->message }}</p>
                                <p class="text-xs mt-1 {{ $message->sender_id === Auth::id() ? 'text-blue-100' : 'text-gray-500' }}">
                                    {{ $message->created_at->format('h:i A · M j, Y') }}
                                    @if($message->sender_id === Auth::id())
                                        <i class="fas fa-check ml-1 {{ $message->read_at ? 'text-blue-300' : 'text-blue-200' }}"></i>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="p-4 border-t border-gray-200">
                    <form>
                        <div class="flex items-center space-x-2">
                            <button type="button" class="text-gray-500 hover:text-adventure-blue p-2 rounded-full hover:bg-gray-100">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            <input type="text" placeholder="Type a message..." 
                                   class="flex-1 border-gray-300 rounded-full py-2 px-4 focus:ring-adventure-blue focus:border-adventure-blue">
                            <button type="submit" class="bg-adventure-blue hover:bg-blue-600 text-white p-2 rounded-full">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- New Message Modal (hidden by default) -->
<div id="newMessageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="font-bold text-lg">New Message</h3>
            <button onclick="closeNewMessageModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-4">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">To:</label>
                <select class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-adventure-blue focus:border-adventure-blue">
                    <option>Select a traveller</option>
                    @foreach($travellers as $traveller)
                        <option value="{{ $traveller->id }}">{{ $traveller->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Message:</label>
                <textarea rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-adventure-blue focus:border-adventure-blue"></textarea>
            </div>
        </div>
        <div class="p-4 border-t border-gray-200 flex justify-end space-x-2">
            <button onclick="closeNewMessageModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</button>
            <button class="px-4 py-2 bg-adventure-blue text-white rounded-lg hover:bg-blue-600">Send</button>
        </div>
    </div>
</div>

<script>
    function openNewMessageModal() {
        document.getElementById('newMessageModal').classList.remove('hidden');
    }

    function closeNewMessageModal() {
        document.getElementById('newMessageModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('newMessageModal');
        if (event.target === modal) {
            closeNewMessageModal();
        }
    }
</script>
@endsection