// Interface pour représenter un élément de cargaison
interface Cargaison {
    index: number;
    lieuDepart: string;
    lieuArrivee: string;
    poidsMax: string;
    typeCargaison: string;
}

// Fonction pour récupérer les données du tableau
function recupererCargaisonsDepuisTableau(): Cargaison[] {
    const cargaisons: Cargaison[] = [];
    const lignesTableau = document.querySelectorAll<HTMLTableRowElement>("tbody tr");

    lignesTableau.forEach((ligne, index) => {
        const cellules = ligne.querySelectorAll<HTMLTableCellElement>("td");
        if (cellules.length >= 5) { // S'assurer qu'il y a suffisamment de cellules
            const cargaison: Cargaison = {
                index: parseInt(cellules[0].textContent || '0', 10),
                lieuDepart: cellules[1].textContent || '',
                lieuArrivee: cellules[2].textContent || '',
                poidsMax: cellules[3].textContent || '',
                typeCargaison: cellules[4].textContent || ''
            };
            cargaisons.push(cargaison);
        }
    });

    return cargaisons;
}

// Fonction pour filtrer les données des cargaisons en fonction de l'entrée de recherche
function filtrerCargaisons(cargaisons: Cargaison[], texteRecherche: string): Cargaison[] {
    if (texteRecherche.length < 2) {
        return cargaisons;
    }

    const texteRechercheMinuscule = texteRecherche.toLowerCase();
    return cargaisons.filter(cargaison => {
        return cargaison.index.toString().includes(texteRechercheMinuscule) ||
            cargaison.lieuDepart.toLowerCase().includes(texteRechercheMinuscule) ||
            cargaison.lieuArrivee.toLowerCase().includes(texteRechercheMinuscule) ||
            cargaison.poidsMax.toLowerCase().includes(texteRechercheMinuscule) ||
            cargaison.typeCargaison.toLowerCase().includes(texteRechercheMinuscule);
    });
}

// Fonction pour afficher les cargaisons (ou mettre à jour le DOM selon les besoins) et envoyer au serveur PHP
function afficherCargaisons(cargaisons: Cargaison[]): void {
    console.clear();
    console.log(cargaisons);

    // Envoi des données filtrées au script PHP via une requête POST
    const xhr = new XMLHttpRequest();
    const url = 'path/to/your/php-script.php'; // Remplacez par le chemin correct
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log('Données envoyées avec succès au serveur PHP');
                console.log(xhr.responseText); // Afficher la réponse du serveur
            } else {
                console.error('Erreur lors de l\'envoi des données au serveur PHP');
            }
        }
    };
    xhr.send(JSON.stringify(cargaisons)); // Envoi des données JSON
}

// Fonction pour ajouter une cargaison
function addCargaison() {
    const poidsMax = (document.getElementById("poidsMax") as HTMLInputElement).value;
    const dateDepart = (document.getElementById("dateDepart") as HTMLInputElement).value;
    const lieuDepart = (document.getElementById("lieuDepart") as HTMLInputElement).value;
    const lieuArrivee = (document.getElementById("lieuArrivee") as HTMLInputElement).value;
    const distance = (document.getElementById("distance") as HTMLInputElement).value;
    const typeCargaison = (document.getElementById("typeCargaison") as HTMLSelectElement).value;

    const table = document.querySelector("tbody");
    if (!table) return;

    const row = document.createElement("tr");
    row.classList.add("text-black", "border-blue-200", "bg-slate-200", "text-center", "font-bold");

    const idCell = document.createElement("td");
    idCell.classList.add("p-4");
    idCell.textContent = (table.children.length + 1).toString();
    row.appendChild(idCell);

    const departCell = document.createElement("td");
    departCell.textContent = lieuDepart;
    row.appendChild(departCell);

    const arriveeCell = document.createElement("td");
    arriveeCell.textContent = lieuArrivee;
    row.appendChild(arriveeCell);

    const poidsCell = document.createElement("td");
    poidsCell.textContent = poidsMax;
    row.appendChild(poidsCell);

    const typeCell = document.createElement("td");
    typeCell.classList.add("border-violet-500", "border-2", "p-2", "rounded-full");
    typeCell.textContent = typeCargaison.charAt(0).toUpperCase() + typeCargaison.slice(1);
    row.appendChild(typeCell);

    const ajoutProduitsCell = document.createElement("td");
    const ajoutProduitsButton = document.createElement("button");
    ajoutProduitsButton.classList.add("border-2", "font-bold", "bg-indigo-800", "text-white", "p-2", "rounded-lg", "hover:text-indigo-800", "hover:bg-neutral-300");
    ajoutProduitsButton.textContent = "Ajout Produits";
    ajoutProduitsButton.onclick = () => {
        const modal = document.getElementById("modalAjoutProduits") as HTMLDialogElement;
        modal.showModal();
    };
    ajoutProduitsCell.appendChild(ajoutProduitsButton);
    row.appendChild(ajoutProduitsCell);

    const detailsCell = document.createElement("td");
    const detailsButton = document.createElement("button");
    detailsButton.classList.add("border-2", "font-bold", "bg-green-500", "text-white", "p-2", "rounded-lg", "hover:text-green-800", "hover:bg-neutral-300");
    detailsButton.textContent = "Details";
    detailsCell.appendChild(detailsButton);
    row.appendChild(detailsCell);

    const deleteCell = document.createElement("td");
    const deleteButton = document.createElement("button");
    deleteButton.classList.add("border-2", "font-bold", "bg-red-700", "text-white", "p-2", "rounded-lg", "hover:text-red-700", "hover:bg-neutral-300");
    deleteButton.textContent = "Supprimer";
    deleteButton.onclick = () => {
        table.removeChild(row);
    };
    deleteCell.appendChild(deleteButton);
    row.appendChild(deleteCell);

    table.appendChild(row);
    closeModal();
}

// Fonctions pour gérer les modals
function showModal() {
    const modal = document.getElementById("my_modal_3") as HTMLDialogElement;
    modal.showModal();
}

function closeModal() {
    const modal = document.getElementById("my_modal_3") as HTMLDialogElement;
    modal.close();
}

// Écouteur d'événements pour le champ de recherche et le formulaire
document.addEventListener('DOMContentLoaded', () => {
    const champRecherche = document.querySelector('.search .inputSearch input') as HTMLInputElement;

    if (champRecherche === null) {
        console.error('Élément .search .input2 input non trouvé dans le DOM');
        return; // Arrêtez l'exécution si l'élément n'est pas trouvé
    }

    champRecherche.addEventListener('input', () => {
        const cargaisons = recupererCargaisonsDepuisTableau();
        const cargaisonsFiltrees = filtrerCargaisons(cargaisons, champRecherche.value);
        afficherCargaisons(cargaisonsFiltrees);
    });

    const form = document.getElementById("cargaisonForm") as HTMLFormElement;
    form.addEventListener("submit", (event: Event) => {
        event.preventDefault();
        addCargaison();
    });
});
