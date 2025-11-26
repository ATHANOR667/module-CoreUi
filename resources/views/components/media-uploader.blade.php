@props([
    'label' => 'Média',
    'type' => 'image', // 'image' ou 'video'
    'fileWire' => null,
    'urlWire' => null,
    'previewUrl' => null,
])

@php
    $accept = $type === 'video' ? 'video/mp4,video/x-m4v,video/*' : 'image/png,image/jpg,image/jpeg,image/webp';

    // Icônes
    $iconPath = $type === 'video'
        ? 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z'
        : 'M4 16l4.586-4.586a2 2 0 012.828 0L15 15m0 0l4.818-4.818a2 2 0 012.828 0M16 16l-3.5-3.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
@endphp

<div x-data="{
        mode: 'upload',
        isDragging: false,
        showWebcam: false,
        stream: null,

        async startCamera() {
            if (/Android|iPhone|iPad|iPod/i.test(navigator.userAgent)) {
                $refs.nativeCameraInput.click();
                return;
            }
            this.showWebcam = true;
            try {
                this.stream = await navigator.mediaDevices.getUserMedia({ video: true });
                this.$nextTick(() => {
                    $refs.videoFeed.srcObject = this.stream;
                    $refs.videoFeed.play();
                });
            } catch (err) {
                alert('Erreur caméra: ' + err);
                this.showWebcam = false;
            }
        },

        stopCamera() {
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
                this.stream = null;
            }
            this.showWebcam = false;
        },

        capturePhoto() {
            let canvas = document.createElement('canvas');
            canvas.width = $refs.videoFeed.videoWidth;
            canvas.height = $refs.videoFeed.videoHeight;
            canvas.getContext('2d').drawImage($refs.videoFeed, 0, 0);
            canvas.toBlob(blob => {
                let file = new File([blob], 'capture.jpg', { type: 'image/jpeg' });
                @this.upload('{{ $fileWire }}', file, () => this.stopCamera(), () => this.stopCamera());
            }, 'image/jpeg', 0.9);
        },

        getVideoEmbed(url) {
            if (!url) return null;
            let ytMatch = url.match(/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/);
            if (ytMatch && ytMatch[2].length === 11) return 'https://www.youtube.com/embed/' + ytMatch[2];
            let vimeoMatch = url.match(/vimeo\.com\/([0-9]+)/);
            if (vimeoMatch) return 'https://player.vimeo.com/video/' + vimeoMatch[1];
            return null;
        }
    }"
     class="w-full"
     x-on:livewire-upload-start="isDragging = true"
     x-on:livewire-upload-finish="isDragging = false"
     x-on:livewire-upload-error="isDragging = false"
>

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-2">
        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">
            {{ $label }}
        </label>

        @if($urlWire)
            <div class="flex bg-slate-100 dark:bg-slate-700 rounded-lg p-1">
                <button type="button" @click="mode = 'upload'" :class="mode === 'upload' ? 'bg-white dark:bg-slate-600 text-primary shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400'" class="px-3 py-1 text-xs font-semibold rounded-md transition-all">Upload</button>
                <button type="button" @click="mode = 'url'" :class="mode === 'url' ? 'bg-white dark:bg-slate-600 text-primary shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400'" class="px-3 py-1 text-xs font-semibold rounded-md transition-all">Lien URL</button>
            </div>
        @endif
    </div>

    {{-- ZONE UPLOAD (Container Relatif) --}}
    <div x-show="mode === 'upload'"
         x-transition
         class="relative group"
    >
        {{-- 1. COUCHE DE FOND : Bordure et Drag State --}}
        <div
            class="border-2 border-dashed rounded-2xl p-6 text-center transition-all duration-200 min-h-[200px] flex flex-col items-center justify-center"
            :class="isDragging ? 'border-primary bg-primary/5' : 'border-slate-300 dark:border-slate-600 hover:border-primary/50 hover:bg-slate-50 dark:hover:bg-slate-700/50'"
        >
            {{-- 2. COUCHE CONTENU (Pointer events none pour laisser passer le clic vers l'input global SI on clique dans le vide) --}}
            <div class="pointer-events-none relative z-10 w-full">

                @if($fileWire && $this->getPropertyValue($fileWire))
                    {{-- Preview Livewire --}}
                    <div class="relative w-full rounded-lg overflow-hidden shadow-sm border border-slate-200 dark:border-slate-600 bg-slate-100 dark:bg-slate-900 pointer-events-auto">
                        @if($type === 'image')
                            <img src="{{ $this->getPropertyValue($fileWire)->temporaryUrl() }}" class="w-full h-48 object-contain">
                        @else
                            <video src="{{ $this->getPropertyValue($fileWire)->temporaryUrl() }}" controls class="w-full h-48 bg-black"></video>
                        @endif
                        {{-- Bouton Supprimer --}}
                        <button type="button" wire:click="$set('{{ $fileWire }}', null)" class="absolute top-2 right-2 bg-red-500 text-white p-1.5 rounded-full hover:bg-red-600 transition-colors shadow-sm z-30 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                @elseif($previewUrl)
                    {{-- Preview Existante --}}
                    <div class="relative w-full rounded-lg overflow-hidden shadow-sm border border-slate-200 dark:border-slate-600 bg-slate-100 dark:bg-slate-900 pointer-events-auto">
                        @if($type === 'image')
                            <img src="{{ $previewUrl }}" class="w-full h-48 object-contain">
                        @else
                            <video src="{{ $previewUrl }}" controls class="w-full h-48 bg-black"></video>
                        @endif
                        <div class="absolute bottom-0 inset-x-0 bg-black/60 text-white text-[10px] py-1 uppercase tracking-wider font-bold">Actuel</div>
                    </div>

                @else
                    {{-- État Vide --}}
                    <div class="flex flex-col items-center justify-center gap-3 mb-4">
                        <div class="p-3 bg-slate-100 dark:bg-slate-700 rounded-full text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}" /></svg>
                        </div>
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-slate-700 dark:text-slate-200">Glissez votre fichier ici</p>
                            <p class="text-xs text-slate-500">{{ $type === 'video' ? 'Vidéo (Max 50Mo)' : 'Image (Max 5Mo)' }}</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- 3. COUCHE BOUTONS (Z-Index Élevé pour passer au dessus de l'input drag & drop) --}}
            <div class="relative z-20 mt-4 flex items-center justify-center gap-3 w-full">

                {{-- Bouton Parcourir (Déclenche explicitement l'input) --}}
                <button type="button"
                        @click="$refs.fileInput.click()"
                        class="btn-media-action">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Parcourir
                </button>

                {{-- Bouton Caméra (Indépendant) --}}
                <button type="button"
                        @click="startCamera()"
                        class="btn-media-action">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ $type === 'video' ? 'Filmer' : 'Photo' }}
                </button>
            </div>

            {{-- 4. COUCHE INPUT DRAG & DROP (Z-0, couvre tout le fond mais reste SOUS les boutons Z-20) --}}
            <input
                x-ref="fileInput"
                type="file"
                wire:model="{{ $fileWire }}"
                accept="{{ $accept }}"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-0"
                title=""
            >

            {{-- Loader (Z-30 pour être tout en haut) --}}
            <div wire:loading wire:target="{{ $fileWire }}" class="absolute inset-0 bg-white/90 dark:bg-slate-800/90 backdrop-blur-sm flex flex-col items-center justify-center rounded-2xl z-30">
                <svg class="animate-spin h-8 w-8 text-primary mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span class="text-sm font-semibold text-primary">Traitement...</span>
            </div>
        </div>

        {{-- Input caché spécifique Mobile --}}
        <input x-ref="nativeCameraInput" type="file" accept="image/*" capture="environment" wire:model="{{ $fileWire }}" class="hidden">
    </div>

    {{-- ZONE URL --}}
    @if($urlWire)
        <div x-show="mode === 'url'" style="display: none;" class="pt-2 space-y-4">
            <x-coreui::input name="{{ $urlWire }}" label="Lien externe" placeholder="https://..." wire:model.live.debounce.500ms="{{ $urlWire }}" />
            @if($this->getPropertyValue($urlWire))
                <div class="rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 bg-black aspect-video relative">
                    @if($type === 'video')
                        <template x-if="getVideoEmbed('{{ $this->getPropertyValue($urlWire) }}')"><iframe :src="getVideoEmbed('{{ $this->getPropertyValue($urlWire) }}')" class="w-full h-full" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe></template>
                        <template x-if="!getVideoEmbed('{{ $this->getPropertyValue($urlWire) }}')"><video src="{{ $this->getPropertyValue($urlWire) }}" controls class="w-full h-full"></video></template>
                    @else
                        <img src="{{ $this->getPropertyValue($urlWire) }}" class="w-full h-full object-contain" onerror="this.style.display='none'">
                    @endif
                </div>
            @endif
        </div>
    @endif

    {{-- OVERLAY WEBCAM (Desktop) --}}
    <template x-if="showWebcam">
        <div class="fixed inset-0 z-[100] bg-black/90 backdrop-blur-sm flex flex-col items-center justify-center p-4">
            <div class="relative w-full max-w-3xl bg-black rounded-2xl overflow-hidden shadow-2xl border border-slate-700">
                <video x-ref="videoFeed" class="w-full aspect-video object-cover bg-black transform scale-x-[-1]" autoplay playsinline></video>
                <div class="absolute bottom-6 inset-x-0 flex items-center justify-center gap-8">
                    <button type="button" @click="stopCamera()" class="px-6 py-3 rounded-full font-bold text-white bg-slate-700/80 hover:bg-slate-600">Annuler</button>
                    <button type="button" @click="capturePhoto()" class="w-16 h-16 bg-white rounded-full border-4 border-slate-300 flex items-center justify-center active:scale-95"><div class="w-14 h-14 bg-red-600 rounded-full border-2 border-white"></div></button>
                </div>
            </div>
        </div>
    </template>

    @error($fileWire) <span class="text-xs text-danger mt-1 block font-medium">{{ $message }}</span> @enderror

    <style>
        .btn-media-action {
            @apply relative inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 shadow-sm cursor-pointer select-none transition-all;
            @apply hover:bg-slate-50 dark:hover:bg-slate-600 hover:border-slate-400;
            @apply active:scale-95 active:bg-slate-100 dark:active:bg-slate-800 active:border-primary/50; /* Effet de clic */
        }
    </style>
</div>
