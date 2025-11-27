# 📚 Catalogue des Composants CoreUI

**Version du Design System :** 1.0  
**Stack :** Laravel Blade + Tailwind CSS 4 + Alpine.js

Ce document est la référence technique pour tous les développeurs du projet. Il détaille comment implémenter les interfaces sans écrire de CSS personnalisé.

---

## 🏗 1. Layouts (Structures de Page)

Ces composants définissent le squelette de vos pages. Ils gèrent le responsive, le mode sombre et les scripts globaux.

### 🟢 `x-coreui::layouts.admin-connected`
Le layout standard pour l'interface d'administration (Dashboard, CRUD). Il inclut une Sidebar (mobile), une Navbar, et la gestion du profil.

**Exemple complet :**
```blade
<x-coreui::layouts.admin-connected 
    title="Tableau de Bord" 
    brand="Mon SaaS" 
    :home-url="route('dashboard')"
>
    {{-- Menu Mobile (Vertical) --}}
    <x-slot:menu>
        <x-coreui::nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-coreui::nav-link>
    </x-slot:menu>

    {{-- Menu Desktop (Horizontal) --}}
    <x-slot:desktop_menu>
        <x-coreui::nav-link-desktop href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-coreui::nav-link-desktop>
    </x-slot:desktop_menu>

    {{-- Actions à droite (Logout, Profil) --}}
    <x-slot:actions>
        <form method="POST" action="/logout">
            @csrf
            <x-coreui::button type="submit" variant="ghost" size="sm">Déconnexion</x-coreui::button>
        </form>
    </x-slot:actions>

    {{-- CONTENU PRINCIPAL --}}
    <div class="p-4">
        <h1>Bienvenue sur le dashboard</h1>
    </div>

</x-coreui::layouts.admin-connected>
```

| Prop | Type | Défaut | Description |
| :--- | :--- | :--- | :--- |
| `title` | String | `config('app.name')` | Le titre de la page dans l'onglet navigateur. |
| `brand` | String | `config('app.name')` | Le nom affiché en haut à gauche (Logo). |
| `homeUrl` | String | `#` | L'URL de redirection au clic sur le logo. |

---

### 🟠 `x-coreui::layouts.admin-disconnected`
Le layout centré pour les pages "Guest" (Login, Register, Mot de passe oublié).

**Exemple :**
```blade
<x-coreui::layouts.admin-disconnected title="Connexion" heading="Espace Admin">
    <x-coreui::card>
        <form>...</form>
    </x-coreui::card>
</x-coreui::layouts.admin-disconnected>
```

---

## 📝 2. Formulaires & Saisie

Des composants intelligents qui gèrent automatiquement les labels, le style et l'affichage des erreurs de validation Laravel.

### 🔤 `x-coreui::input`
Champ de saisie polyvalent.

**Exemple :**
```blade
{{-- Avec Livewire --}}
<x-coreui::input 
    name="email" 
    label="Adresse Email" 
    type="email" 
    wire:model.blur="email" 
    placeholder="exemple@domaine.com"
    required 
/>
```

| Prop | Type | Défaut | Description |
| :--- | :--- | :--- | :--- |
| `name` | String | **Requis** | Utilisé pour l'ID, le `name` HTML et la directive `@error`. |
| `label` | String | `null` | Si fourni, affiche un label stylisé au-dessus du champ. |
| `type` | String | `'text'` | Type HTML (`text`, `password`, `date`, `number`...). |

> 💡 **Note :** Tous les autres attributs (`wire:model`, `disabled`, `readonly`) sont automatiquement transférés à la balise `<input>`.

---

### 📸 `x-coreui::media-uploader`
Composant avancé "Tout-en-un" pour la gestion de fichiers.
* **Fonctionnalités :** Drag & Drop, Webcam (Desktop/Mobile), Prévisualisation (Image/Vidéo), Gestion d'URL externe (YouTube/Vimeo).

**Exemple complet :**
```blade
<x-coreui::media-uploader 
    label="Vidéo de présentation" 
    type="video" 
    file-wire="videoFile" 
    url-wire="videoUrl" 
    :preview-url="$videoUrl ?? null"
/>
```

| Prop | Type | Défaut | Description |
| :--- | :--- | :--- | :--- |
| `label` | String | `'Média'` | Label affiché au-dessus de la zone. |
| `type` | String | `'image'` | `'image'` ou `'video'`. Adapte l'icône, le filtre de fichiers et le lecteur de prévisualisation. |
| `fileWire`| String | `null` | Nom de la propriété Livewire qui recevra le fichier uploadé (`UploadedFile`). |
| `urlWire` | String | `null` | Nom de la propriété Livewire pour l'URL externe (optionnel). Si omis, l'onglet "Lien URL" est masqué. |
| `previewUrl`| String| `null` | URL d'un fichier déjà existant (pour le mode édition). |

---

## 🧩 3. Éléments d'Interface (UI)

### ⬜ `x-coreui::card`
Conteneur blanc standard avec ombre portée et bords arrondis.

**Exemple :**
```blade
<x-coreui::card class="max-w-sm mx-auto">
    <h2 class="text-lg font-bold">Titre de la carte</h2>
    <p>Contenu...</p>
</x-coreui::card>
```

---

### 🔘 `x-coreui::button`
Bouton d'action standardisé. Peut se comporter comme un bouton ou un lien.

**Exemple :**
```blade
<div class="flex gap-2">
    {{-- Bouton Submit --}}
    <x-coreui::button type="submit" variant="primary">
        Enregistrer
    </x-coreui::button>

    {{-- Lien (Link) --}}
    <x-coreui::button href="/cancel" variant="ghost">
        Annuler
    </x-coreui::button>
    
    {{-- Bouton avec Icône --}}
    <x-coreui::button variant="danger" wire:click="delete">
        <svg class="w-4 h-4 mr-2">...</svg> Supprimer
    </x-coreui::button>
</div>
```

| Prop | Type | Défaut | Options |
| :--- | :--- | :--- | :--- |
| `variant`| String | `'primary'`| `primary`, `secondary`, `success`, `danger`, `warning`, `ghost`. |
| `size` | String | `'md'` | `sm` (Compact), `md` (Standard), `lg` (Large). |
| `type` | String | `'button'` | `button`, `submit`, `reset`. |
| `href` | String | `null` | Si défini, le composant rend une balise `<a>` au lieu de `<button>`. |

---

### 🏷 `x-coreui::badge`
Petite étiquette pour afficher un statut ou une catégorie.

**Exemple :**
```blade
<x-coreui::badge variant="success">Actif</x-coreui::badge>
<x-coreui::badge variant="warning">En attente</x-coreui::badge>
```

| Prop | Options |
| :--- | :--- |
| `variant`| `primary`, `success`, `danger`, `warning`, `purple`, `neutral`. |
| `size` | `sm` (Texte 10px), `md` (Texte 12px). |

---

### 📊 `x-coreui::progress-bar`
Barre de chargement animée.

**Exemple :**
```blade
<x-coreui::progress-bar value="75" max="100" color="success" />
```

---

### 🌗 `x-coreui::theme-toggle`
Bouton autonome (sans props) qui gère le basculement Clair / Sombre / Système via Alpine.js et localStorage.

---

## 🚨 4. Feedback & Modales

### 🔔 `x-coreui::alert`
Message d'information ou d'erreur.

**Exemple :**
```blade
@if (session('success'))
    <x-coreui::alert type="success">
        {{ session('success') }}
    </x-coreui::alert>
@endif
```

| Prop | Options |
| :--- | :--- |
| `type` | `success` (Vert), `error` (Rouge), `warning` (Jaune), `info` (Bleu). |

---

### 🖼 `x-coreui::modal`
Fenêtre modale gérée par Alpine.js (`x-show`) liée à une propriété Livewire.

**Exemple Livewire :**
```blade
{{-- Dans la vue Blade --}}
<div>
    <x-coreui::button wire:click="$set('showModal', true)">Ouvrir</x-coreui::button>

    <x-coreui::modal wire:model="showModal" title="Confirmation" maxWidth="lg">
        <p>Êtes-vous sûr de vouloir supprimer cet élément ?</p>
        
        <x-slot:footer>
            <x-coreui::button variant="ghost" wire:click="$set('showModal', false)">Non</x-coreui::button>
            <x-coreui::button variant="danger" wire:click="delete">Oui, supprimer</x-coreui::button>
        </x-slot:footer>
    </x-coreui::modal>
</div>
```

| Prop | Type | Défaut | Description |
| :--- | :--- | :--- | :--- |
| `wire:model`| String | - | **Obligatoire**. La variable booléenne Livewire qui pilote l'affichage. |
| `title` | String | `null` | Titre affiché dans l'en-tête de la modale. |
| `maxWidth` | String | `'2xl'` | Largeur max : `sm`, `md`, `lg`, `xl`, `2xl`, `3xl`, `4xl`, `5xl`, `full`. |

---

## 🧭 5. Navigation

Pour respecter le **Mobile First**, nous utilisons deux composants distincts.

### 📱 `x-coreui::nav-link` (Mobile)
Lien style "bloc", pleine largeur, avec bordure à gauche. À utiliser dans le slot `menu` du layout.

### 💻 `x-coreui::nav-link-desktop` (Desktop)
Lien style "inline", avec bordure en bas. À utiliser dans le slot `desktop_menu` du layout.

**Exemple :**
```blade
<x-coreui::nav-link :active="request()->routeIs('home')">
    Accueil
</x-coreui::nav-link>
```


## 📊 6. Tableaux de Données

Suite de composants pour uniformiser l'affichage des listes de données sur Desktop.
*Note : Sur mobile, il est recommandé d'utiliser une boucle de `<x-coreui::card>` à la place.*

### 14. `x-coreui::table`
Conteneur principal du tableau (gère l'arrondi, le bord et le scroll horizontal).

**Utilisation :**
```blade
<x-coreui::table>
    <thead>...</thead>
    <tbody>...</tbody>
</x-coreui::table>
```

### 15. `x-coreui::table.th`
Cellule d'en-tête (Header). Gère le style (uppercase, gris, gras).

**Props :**

| Nom | Type | Défaut | Description |
| :--- | :--- | :--- | :--- |
| `align` | String | `'left'` | `left`, `center`, `right`. |

### 16. `x-coreui::table.row`
Ligne du corps (Body Row). Gère le hover et les transitions.

### 17. `x-coreui::table.td`
Cellule de donnée standard.

**Props :**

| Nom | Type | Défaut | Description |
| :--- | :--- | :--- | :--- |
| `align` | String | `'left'` | `left`, `center`, `right`. |
