{{-- resources/views/contact/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Contactez-nous')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-lg mx-auto">
            
            {{-- Header avec icône WhatsApp --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-500 rounded-full mb-4 shadow-lg">
                    <i class="fab fa-whatsapp text-white text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    Contactez-nous
                </h1>
                <p class="text-gray-600">
                    Envoyez-nous un message, nous vous répondrons rapidement
                </p>
            </div>

            {{-- Formulaire --}}
            <div class="bg-white rounded-2xl shadow-xl p-8">
                
                {{-- Messages d'erreur --}}
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('contacts.store') }}" class="space-y-6">
                    @csrf

                    {{-- Nom --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user text-gray-400 mr-2"></i>
                            Votre nom
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="Entrez votre nom complet">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope text-gray-400 mr-2"></i>
                            Votre email
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="votre@email.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Sujet --}}
                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-tag text-gray-400 mr-2"></i>
                            Sujet
                        </label>
                        <select id="subject" 
                                name="subject" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('subject') border-red-500 @enderror">
                            <option value="">Choisissez un sujet</option>
                            <option value="Information générale" {{ old('subject') == 'Information générale' ? 'selected' : '' }}>
                                Information générale
                            </option>
                            <option value="Support technique" {{ old('subject') == 'Support technique' ? 'selected' : '' }}>
                                Support technique
                            </option>
                            <option value="Demande de devis" {{ old('subject') == 'Demande de devis' ? 'selected' : '' }}>
                                Demande de devis
                            </option>
                            <option value="Réclamation" {{ old('subject') == 'Réclamation' ? 'selected' : '' }}>
                                Réclamation
                            </option>
                            <option value="Autre" {{ old('subject') == 'Autre' ? 'selected' : '' }}>
                                Autre
                            </option>
                        </select>
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Message --}}
                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-comment text-gray-400 mr-2"></i>
                            Votre message
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="6"
                                  required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('message') border-red-500 @enderror"
                                  placeholder="Décrivez votre demande...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Bouton d'envoi --}}
                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-4 px-6 rounded-lg transition duration-200 flex items-center justify-center shadow-lg hover:shadow-xl">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Envoyer le message
                        </button>
                    </div>
                </form>

                {{-- Divider --}}
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">ou</span>
                    </div>
                </div>

                {{-- Bouton WhatsApp --}}
                <div class="text-center">
                    <a href="https://wa.me/+25779123456?text=Bonjour, je souhaite vous contacter" 
                       target="_blank"
                       class="inline-flex items-center justify-center w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 px-6 rounded-lg transition duration-200 shadow-lg hover:shadow-xl">
                        <i class="fab fa-whatsapp text-2xl mr-3"></i>
                        Contacter via WhatsApp
                    </a>
                    <p class="text-sm text-gray-500 mt-2">
                        Réponse rapide garantie
                    </p>
                </div>
            </div>

            {{-- Informations de contact --}}
            <div class="bg-white rounded-2xl shadow-xl p-6 mt-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Autres moyens de contact
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center">
                        <i class="fas fa-phone text-green-500 mr-3"></i>
                        <span>+257 79 123 456</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope text-blue-500 mr-3"></i>
                        <span>contact@example.com</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-red-500 mr-3"></i>
                        <span>Gitega, Burundi</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock text-gray-500 mr-3"></i>
                        <span>Lun-Ven: 8h-17h</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Bouton WhatsApp flottant --}}
<div class="fixed bottom-6 right-6 z-50">
    <a href="https://wa.me/+25779123456?text=Bonjour, je souhaite vous contacter" 
       target="_blank"
       class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center group">
        <i class="fab fa-whatsapp text-2xl"></i>
        <span class="ml-2 hidden group-hover:inline-block whitespace-nowrap">
            Chat WhatsApp
        </span>
    </a>
</div>

{{-- Animation pour le bouton flottant --}}
<style>
.fixed .group:hover {
    transform: scale(1.05);
}

.fixed .group {
    transition: transform 0.3s ease;
}

@keyframes bounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translate3d(0,0,0);
    }
    40%, 43% {
        transform: translate3d(0, -8px, 0);
    }
    70% {
        transform: translate3d(0, -4px, 0);
    }
    90% {
        transform: translate3d(0, -2px, 0);
    }
}

.fixed .group {
    animation: bounce 2s infinite;
}
</style>

{{-- Font Awesome pour les icônes --}}
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush
@endsection