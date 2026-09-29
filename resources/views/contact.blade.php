<x-app-layout>
    <div class="flex flex-col items-center justify-center pt-10 bg-gray-100 class="bg-white p-8 rounded-lg shadow-lg w-1/3">
            <h2 class="text-2xl font-bold mb-6 text-center">Enviar E-mail</h2>
            
        <form action="{{ route('contact.store') }}" method="POST">
        @csrf
            <div class="space-y-4">
                <div>
                    <label for="recipient_email" class="block text-sm font-medium text-gray-700">E-mail do Destinatário</label>
                    <input type="email" name="recipient_email" id="recipient_email" class="mt-1 p-2 w-full border rounded-md" required>
                </div>
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Assunto</label>
                    <input type="text" name="subject" id="subject" class="mt-1 p-2 w-full border rounded-md" required>
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Mensagem</label>
                <textarea name="message" id="message" rows="5" class="mt-1 p-2 w-full border rounded-md" required></textarea>
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition-colors">
                    Enviar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>