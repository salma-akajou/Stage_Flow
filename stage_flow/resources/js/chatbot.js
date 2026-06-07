export default function chatbotApp(config) {
    const role = config?.role || 'guest';
    const userId = config?.userId || 0;
    const messageUrl = config?.messageUrl || '/chatbot/message';

    const getOptionsByRole = (role) => {
        if (role === 'admin') {
            return [
                { label: "Rapport d'activité globale", prompt: "Donne-moi le rapport d'activité globale du site", icon: "📊" },
                { label: "Ajouter des filières et secteurs", prompt: "Ajoute la filière 'Intelligence Artificielle' et le secteur 'Nouvelles Technologies'", icon: "➕" },
                { label: "Renommer un établissement", prompt: "Renomme l'établissement '[Nom actuel]' en '[Nouveau nom]'", icon: "✏️" },
                { label: "Supprimer une filière", prompt: "Supprime la filière '[Nom de la filière]'", icon: "🗑️" }
            ];
        }
        if (role === 'entreprise') {
            return [
                { label: "Publier une offre de stage", prompt: "Publie un stage de Développeur Laravel pour 3 mois, non payé en Présentiel", icon: "➕" },
                { label: "Analyser une candidature", prompt: "Analyse la candidature #[Entrez ID de candidature]", icon: "🔍" },
                { label: "Supprimer une offre", prompt: "Supprime l'offre #[Entrez ID de l'offre]", icon: "🗑️" }
            ];
        }
        if (role === 'etudiant') {
            return [
                { label: "Recommander des stages", prompt: "Recommande-moi des offres de stage selon mon profil", icon: "🎓" },
                { label: "Rédiger un message de motivation", prompt: "Rédige-moi une lettre de motivation pour l'offre #[Entrez ID de l'offre]", icon: "✍️" }
            ];
        }
        return [
            { label: "Comment fonctionne StageFlow ?", prompt: "Comment fonctionne la plateforme ?", icon: "💡" },
            { label: "Quelles sont les statistiques du site ?", prompt: "Quelles sont les statistiques publiques du site ?", icon: "📈" }
        ];
    };

    const getWelcomeMessage = (role) => {
        let text = "Bonjour ! Je suis votre assistant virtuel StageFlow. Comment puis-je vous aider aujourd'hui ?";
        if (role === 'admin') {
            text = "Bonjour Administrateur ! Je suis votre assistant IA de gestion. Je peux vous aider à générer des rapports statistiques ou à gérer les établissements, filières et secteurs.";
        } else if (role === 'entreprise') {
            text = "Bonjour ! Je suis votre assistant de recrutement IA. Je peux vous aider à publier et gérer vos offres de stage, ou à analyser les candidatures reçues.";
        } else if (role === 'etudiant') {
            text = "Bonjour ! Je suis ton conseiller de stage IA. Je peux te recommander des opportunités de stage ou t'aider à rédiger des messages de motivation.";
        }
        return {
            sender: 'bot',
            text: text,
            options: getOptionsByRole(role)
        };
    };

    return {
        open: false,
        unread: false,
        newMessage: '',
        isLoading: false,
        messages: [],
        reloadTimeoutId: null,

        init() {
            window.addEventListener('beforeunload', () => {
                if (this.reloadTimeoutId) {
                    clearTimeout(this.reloadTimeoutId);
                }
            });

            // Load messages from localStorage unique to user/role
            const storageKey = `stageflow_chatbot_messages_${role}_${userId}`;
            const stored = localStorage.getItem(storageKey);
            if (stored) {
                try {
                    this.messages = JSON.parse(stored);
                } catch (e) {
                    this.messages = [getWelcomeMessage(role)];
                }
            } else {
                this.messages = [getWelcomeMessage(role)];
            }

            // Restore open state
            const wasOpen = localStorage.getItem(`stageflow_chatbot_open_${role}_${userId}`);
            if (wasOpen === 'true') {
                this.open = true;
            }

            this.scrollToBottom();
        },

        saveState() {
            const storageKey = `stageflow_chatbot_messages_${role}_${userId}`;
            localStorage.setItem(storageKey, JSON.stringify(this.messages));
            localStorage.setItem(`stageflow_chatbot_open_${role}_${userId}`, this.open ? 'true' : 'false');
        },

        toggleOpen() {
            this.open = !this.open;
            if (this.open) {
                this.unread = false;
            }
            this.saveState();
            this.scrollToBottom();
        },

        clearHistory() {
            if (confirm("Effacer tout l'historique de discussion ?")) {
                this.messages = [getWelcomeMessage(role)];
                this.saveState();
            }
        },

        useOption(text) {
            this.newMessage = text;
            this.$nextTick(() => {
                const input = this.$el.querySelector('input[type="text"]');
                if (input) {
                    input.focus();
                }
            });
        },

        getPlaceholder() {
            if (role === 'admin') return "Ajouter la filière IA...";
            if (role === 'entreprise') return "Créer une offre de développeur...";
            if (role === 'etudiant') return "Recommande-moi des offres...";
            return "Poser une question...";
        },

        formatMessage(text) {
            if (!text) return '';
            // Basic bold markdown conversion
            return text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        },

        async sendMessage() {
            if (!this.newMessage.trim() || this.isLoading) return;

            const textToSend = this.newMessage.trim();
            this.messages.push({
                sender: 'user',
                text: textToSend
            });
            this.newMessage = '';
            this.isLoading = true;
            this.saveState();
            this.scrollToBottom();

            try {
                const response = await fetch(messageUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message: textToSend })
                });

                if (!response.ok) {
                    throw new Error("Erreur HTTP " + response.status);
                }

                const result = await response.json();
                
                this.messages.push({
                    sender: 'bot',
                    text: result.message,
                    success: result.success || false
                });

                this.saveState();

                if (result.success) {
                    // Show validation toast or reload UI
                    this.reloadTimeoutId = setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }

            } catch (error) {
                console.error("Chatbot request failed:", error);
                this.messages.push({
                    sender: 'bot',
                    text: "Désolé, je rencontre des difficultés de connexion. Veuillez réessayer."
                });
                this.saveState();
            } finally {
                this.isLoading = false;
                this.scrollToBottom();
                if (!this.open) {
                    this.unread = true;
                }
            }
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.chatBox;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });
        }
    };
}
