// Import des fonctions de la librairie
import {browserSupportsWebAuthn, startAuthentication, startRegistration} from '@simplewebauthn/browser';

// 1. On expose les primitives brutes (Pour compatibilité si besoin)
window.WebAuthn = {
    startRegistration,
    startAuthentication,
    browserSupportsWebAuthn
};

// 2. On expose le Helper "Clé en main" (Recommandé pour simplifier vos Vues)
window.WebAuthnHelper = {

    // Vérification support
    isSupported() {
        return browserSupportsWebAuthn();
    },

    // --- INSCRIPTION (Page Profil) ---
    async register() {
        // A. Options
        const optionsRes = await axios.get('/admin/auth/passkeys/register/options');

        // B. Biométrie
        const attestation = await startRegistration(optionsRes.data);

        // C. Validation
        // Note: attestation est un objet JSON pur grâce à la librairie
        return await axios.post('/admin/auth/passkeys/register', attestation);
    },

    // --- CONNEXION (Page Login) ---
    async login() {
        // A. Challenge générique
        const optionsRes = await axios.post('/admin/auth/passkeys/login/options');

        // B. Biométrie (Le navigateur propose les comptes)
        const assertion = await startAuthentication(optionsRes.data);

        // C. Validation
        return await axios.post('/admin/auth/passkeys/login', assertion);
    }
};
