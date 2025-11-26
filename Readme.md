# Module CoreUI - Design System & UI Kit

## 🎨 Description
**CoreUI** est la librairie d'interface utilisateur centralisée pour l'écosystème BuildingSaaS.

C'est un module **agnostique** et **transversal** : il ne contient aucune logique métier ni accès à la base de données. Il fournit les briques visuelles (Composants Blade, Layouts, Configuration Tailwind) pour garantir que tous les modules fonctionnels (Stock, Ventes, AdminBase) partagent une identité visuelle unique et cohérente.

## 📦 Stack Technique
* **CSS :** Tailwind CSS (Configuration centralisée via variables CSS).
* **JS :** Alpine.js 3.x (Pour les interactions UI : Modales, Dropdowns, Tabs).
* **Composants :** Blade & Livewire 3 compatible.
* **Icônes :** SVG Natifs ou Heroicons.

## 🛠 Installation

Ce module doit être cloné dans le dossier `Modules` de l'application hôte.

1. **Cloner le module :**
   ```bash
   cd Modules
   git clone https://github.com/ATHANOR667/module-coreui.git CoreUI
   ```

2. **Configuration de l'Hôte (Tailwind) :**
   Dans le fichier `tailwind.config.js` de l'application principale, ajoutez le chemin pour scanner les vues des modules :

   ```js
   export default {
       darkMode: 'class', // Obligatoire pour le ThemeToggle
       content: [
           './resources/**/*.blade.php',
           // ...
           './Modules/*/resources/views/**/*.blade.php', // <--- AJOUTER CECI
       ],
       // ...
   };
   ```

3. **Importation des Assets (CSS/JS) :**
   Dans le fichier `resources/css/app.css` de l'application principale :
   ```css
   @import 'tailwindcss';
   @import '../../Modules/CoreUI/resources/css/coreui.css'; /* Import du Design System */
   ```

   Dans le fichier `resources/js/app.js` de l'application principale :
   ```js
   import './bootstrap';
   import '../../Modules/CoreUI/resources/js/coreui.js'; /* Import des scripts globaux */
   ```

## 💻 Utilisation Rapide

### 1. Utiliser un Layout
Dans vos modules fonctionnels, utilisez les layouts composants :

```blade
<x-coreui::layouts.admin-connected title="Mon Dashboard">
    <x-slot:menu>
        <x-coreui::nav-link href="/home">Accueil</x-coreui::nav-link>
    </x-slot:menu>
    
    <x-slot:desktop_menu>
        <x-coreui::nav-link-desktop href="/home">Accueil</x-coreui::nav-link-desktop>
    </x-slot:desktop_menu>

    <h1>Bienvenue</h1>
</x-coreui::layouts.admin-connected>
```

### 2. Utiliser les Composants
Utilisez les composants avec le préfixe `x-coreui::`.

```blade
<x-coreui::card>
    <h3 class="text-lg font-bold mb-4">Ajouter un produit</h3>
    
    <form wire:submit="save">
        <x-coreui::input label="Nom du produit" wire:model="name" required />
        
        {{-- Upload avec Drag & Drop + Webcam --}}
        <x-coreui::media-uploader label="Photo" file-wire="photo" type="image" />

        <div class="flex justify-end mt-4">
            <x-coreui::button type="submit" variant="primary">
                Sauvegarder
            </x-coreui::button>
        </div>
    </form>
</x-coreui::card>
```

## 📂 Structure du Module
* `resources/views/components` : Tous les atomes UI (Buttons, Inputs, Alerts, Cards...).
* `resources/views/components/layouts` : Les gabarits de page (AdminConnected, AdminDisconnected).
* `resources/css` : Les définitions de variables de couleurs (`--color-primary`) et typographie.
* `resources/js` : Scripts utilitaires globaux (Axios, etc.).

## 📚 Documentation Complète
Pour voir la liste exhaustive des composants et leurs paramètres, consultez le fichier **[COMPONENTS.md](COMPONENTS.md)**.

## ⚠️ Règles de Contribution
1. **Zéro Logique Métier :** Un composant ne doit jamais faire de requête SQL.
2. **Mobile First :** Tous les composants doivent être pensés pour mobile d'abord.
3. **Props Typées :** Utilisez les classes de composants Blade ou `@props` pour définir clairement les entrées.
4. **Pas de surcharge CSS :** Si vous devez changer la couleur d'un bouton, changez la variable CSS globale, ne surchargez pas la classe.
