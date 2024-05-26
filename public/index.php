<?php
session_start();

// Charger les données initiales de Cargaison.json dans $_SESSION["cargaison"]
$jsonData = file_get_contents('../model/Cargaison.json');
$cargaisons = json_decode($jsonData, true);
$_SESSION["cargaison"] = $cargaisons;

// Afficher les données initiales (debugging)
// var_dump($_SESSION["cargaison"]);

// Terminer le script après le var_dump pour ne pas exécuter le code POST si ce n'est pas nécessaire


// Initialisation de $carg
$carg = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire pour la cargaison
    $poidsMax = $_POST['poids'] ?? '';
    $dateDepart = $_POST['datedepart'] ?? '';
    $lieuDepart = $_POST['depart'] ?? '';
    $lieuArrivee = $_POST['arrivee'] ?? '';
    $distance = $_POST['km'] ?? '';
    $typeCargaison = $_POST['type'] ?? '';

    // Créer un tableau $carg avec les données récupérées
    $carg = [
        "poidsMax" => $poidsMax,
        "dateDepart" => $dateDepart,
        "lieuDepart" => $lieuDepart,
        "lieuArrivee" => $lieuArrivee,
        "distance" => $distance,
        "typeCargaison" => $typeCargaison
    ];

    // Vous pouvez ajouter ici une étape pour sauvegarder $carg si nécessaire
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire pour le produit
    $identifiant_produit = $_POST['identifiant_produit'] ?? '';
    $nom_produit = $_POST['nom_produit'] ?? '';
    $quantite = $_POST['quantite'] ?? '';
    $typepro = $_POST['typepro'] ?? '';

    // Charger le fichier produits.json
    $jsonPro = file_get_contents('../model/produits.json');
    $pro_json = json_decode($jsonPro, true);

    // Créer un nouveau produit avec les données du formulaire
    $newProduct = [
        "identifiant_produit" => $identifiant_produit,
        "nom_produit" => $nom_produit,
        "quantite" => $quantite,
        "typepro" => $typepro
    ];

    // Ajouter le nouveau produit au tableau existant
    $pro_json[] = $newProduct;

    // Réencoder le tableau mis à jour en JSON
    $updatedJsonPro = json_encode($pro_json, JSON_PRETTY_PRINT);

    // Sauvegarder le JSON mis à jour dans produits.json
    file_put_contents('../model/produits.json', $updatedJsonPro);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script type="module" src="js/index.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>

<body class="w-screen overflow-x-hidden  bg-violet-100 ">


    <div class=" ">
        <!-- header -->
        <div class="header border-y-2 shadow-lg shadow-gray-700 w-full">
            <div class="navbar bg-cyan-950 w-full">
                <div class="flex-1">
                    <div class="dropdown text-xl">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </div>
                        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52 text-white">
                            <li><a> <i class="fa-solid fa-gear"></i> Parametre</a></li>
                            <li><a><i class="fa-solid fa-house"></i> Acceuil </a></li>
                            <li><a><i class="fa-brands fa-product-hunt"></i> Produits</a></li>
                        </ul>
                    </div>
                    <a class="btn btn-ghost text-3xl">Cargaison</a>
                </div>

                <div class="search flex-grow">
                    <div class="inputSearch">
                        <input type="text" placeholder="Search" class="input w-full md:w-[140vh] rounded-full" /> <!-- Increased width -->
                    </div>

                </div>
                <div class="flex-none gap-2">
                    <span class="text-3xl mr-4"> <i class="fa-solid fa-bell"></i></span>
                    <div class="dropdown ">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div class="w-15 rounded-full">
                                <img alt="Tailwind CSS Navbar component" src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
                            </div>
                        </div>

                        <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                            <li>
                                <a class="justify-between">
                                    Profile
                                    <span class="badge">New</span>
                                </a>
                            </li>
                            <li><a>Deconnexion</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>

    <div class="nav flex ">
        <div class="left flex-initial w-[200vh] m-3  shadow-lg shadow-gray-700 rounded-lg bg-cyan-950 text-black">
            <h1 class="text-3xl font-bold text-stone-300 flex justify-center aligns-center pt-4 "><span class="border-b-4">Tableau Des Cargaisons</span></h1>
            <div class="line1  my-[2vh]  mx-[2vh]  w-[130vh] flex justify-between">
                <div class="bloc1 w-1/3 mr-5 rounded-box bg-blue-600 px-8 text-white ">
                    <div class="div-nombre flex justify-between  pt-4">
                        <span class="text-3xl font-bold  px-4 rounded-full bg-purple-200 text-black ">456</span>
                        <span class="text-3xl"><i class="fa-solid fa-ship"></i></span>
                    </div>
                    <div class="text  text-xl">Total de cargaison Maritime</div>
                </div>

                <div class="bloc1 w-1/3 mr-5  rounded-box bg-purple-900 px-8 text-white">
                    <div class="div-nombre flex justify-between  pt-4">
                        <span class="text-3xl font-bold  px-4 rounded-full bg-purple-200 text-black">357</span>
                        <span class="text-3xl"><i class="fa-solid fa-truck"></i></span>
                    </div>
                    <div class="text  text-xl">Total de cargaison Routiere</div>
                </div>
                <div class="bloc1 w-1/3 mr-5  rounded-box px-8 bg-violet-700 text-white">
                    <div class="div-nombre flex justify-between  pt-4">
                        <span class="text-3xl font-bold  px-4 rounded-full bg-purple-200 text-black">489</span>
                        <span class="text-3xl"><i class="fa-solid fa-plane"></i></span>
                    </div>
                    <div class="text  text-xl">Total de cargaison Aerienne</div>
                </div>
            </div>
            <div class="btns m-5">
                <button class="btn bg-blue-900 text-white  border-none text-xl hover:text-blue-900 hover:bg-neutral-300" onclick="my_modal_3.showModal()">Ajouter cargaison</button>
                <dialog id="my_modal_3" class="modal">
                    <div class="modal-box">
                        <form id="cargaisonForm" method="post" class="p-6 text-white">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" type="button" onclick="my_modal_3.close()">X</button>
                            <div class="div-carg">
                                <h2 class="flex justify-center items-center mb-8 text-2xl font-bold">Ajouter Une Cargaison</h2>
                                <div class="mb-4">
                                    <input type="text" id="poidsMax" placeholder="Poids-max" name="poids" class="input input-bordered input-accent w-full max-w-xs pl-2" required />
                                </div>
                                <div class="mb-4">
                                    <label class="mb-3 text-xl">Date de départ</label>
                                    <input type="date" id="dateDepart" placeholder="Date de départ" name="datedepart" class="input input-bordered input-accent w-full max-w-xs" required />
                                </div>
                                <div class="mb-4">
                                    <label class="mb-3 text-xl">Lieu de départ</label>
                                    <input type="text" id="lieuDepart" placeholder="Lieu de départ" name="depart" class="input input-bordered input-accent w-full max-w-xs" required />
                                </div>
                                <div class="mb-4">
                                    <label class="mb-3 text-xl">Lieu d'arrivée</label>
                                    <input type="text" id="lieuArrivee" placeholder="Lieu d'arrivée" name="arrivee" class="input input-bordered input-accent w-full max-w-xs" required />
                                </div>
                                <div class="mb-4">
                                    <label class="mb-3 text-xl">Distance en kilomètres</label>
                                    <input type="text" id="distance" placeholder="Distance en kilomètres" name="km" class="input input-bordered input-accent w-full max-w-xs" required />
                                </div>
                                <div class="mb-4">
                                    <label class="mb-3 text-xl">Type de cargaison</label>
                                    <select id="typeCargaison" class="input input-bordered input-accent w-full max-w-xs " name="type" required>
                                        <option value="maritime">Maritime</option>
                                        <option value="aerienne">Aérienne</option>
                                        <option value="routiere">Routière</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <button type="submit" class="btn btn-blue rounded-lg bg-indigo-700">Ajouter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </dialog>
            </div>

            <div class="line2 w-[130vh] border  m-5 rounded-lg bg-slate-200 ">
                <table class="w-[120vh] m-4 ml-10 ">
                    <thead>
                        <tr class="text-black border-2 border-blue-200  bg-blue-200 font-bold text-xl ">
                            <th class="border-2 border-2  p-4">id</th>
                            <th class="border-2">depart</th>
                            <th class="border-2">arrivee</t
                            <th class="border-2">poids</th>
                            <th class="border-2">type</th>
                            <th class="border-2">ajout produits</th>
                            <th class="border-2">Details</th>
                            <th class="border-2">del</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cargaisons as $index => $cargo) : ?>
                            <tr class="text-black border-blue-200 bg-slate-200 text-center font-bold">
                                <td class="p-4"><?= $index + 1 ?></td>
                                <td><?= $cargo['lieuDepart'] ?></td>
                                <td><?= $cargo['lieuArrivee'] ?></td>
                                <td><?= $cargo['poidsMax'] ?></td>
                                <td><span class="border-violet-500 border-2 p-2 rounded-full"><?= ucfirst($cargo['typeCargaison']) ?></span></td>
                                <td><button class="border-2 font-bold bg-indigo-800 text-white p-2 rounded-lg hover:text-indigo-800 hover:bg-neutral-300" onclick="modalAjoutProduits.showModal()">Ajout Produits</button></td>
                                <td><button class="border-2 font-bold bg-green-500 text-white p-2 rounded-lg hover:text-green-800 hover:bg-neutral-300">Details</button></td>
                                <td><button class="border-2 font-bold bg-red-700 text-white p-2 rounded-lg hover:text-red-700 hover:bg-neutral-300">supprimer</button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                

                <!-- modal ajout produit -->
                <dialog id="modalAjoutProduits" class="modal">
                    <div class="modal-box">
                        <form method="post" class="p-6 text-white">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="modalAjoutProduits.close()">X</button>

                            <div class="div-carg">
                                <h2 class="flex justify-center items-center mb-8 text-2xl font-bold">Ajouter des Produits à la Cargaison</h2>
                                <div class="mb-4">
                                    <input type="text" placeholder="identifiant Produit" name="identifiant_produit" class="input input-bordered input-accent w-full max-w-xs pl-2" />
                                </div>

                                <div class="mb-4">
                                    <!-- Ajoutez ici les champs pour ajouter des produits à la cargaison -->
                                    <input type="text" placeholder="Nom du produit" name="nom_produit" class="input input-bordered input-accent w-full max-w-xs pl-2" />
                                </div>
                                <div class="mb-4">
                                    <input type="text" placeholder="Quantité" name="quantite" class="input input-bordered input-accent w-full max-w-xs pl-2" />
                                </div>

                                <div class="mb-4">
                                    <label class="mb-3 text-xl">Type de cargaison</label>
                                    <select id="typepro" class="input input-bordered input-accent w-full max-w-xs " name="typepro" required>
                                        <option value="cassable">Cassable</option>
                                        <option value="incassable">Incassable</option>
                                        <option value="chimique">Chimique</option>
                                        <option value="alimentaire">Alimentaire</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <button type="submit" class="btn btn-blue rounded-lg bg-indigo-700">Ajouter Produit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </dialog>
            </div>
        </div>
        <div class="right flex-initial w-[100vh]  m-3  shadow-lg shadow-gray-700 bg-cyan-950 rounded-lg">
            <div class="infos  bg-slate-200 border rounded-lg m-5 text-black font-bold p-4">
                <h1 class="mb-4 flex justify-center items-center text-2xl border-b border-black">Details Cargaisons</h1>
                <div class="mb-4">
                    <span class="text-xl"> Cargaison : </span><span>302</span>
                </div>
                <div class="mb-4">
                    <span class="text-xl"><span><i class="fa-solid fa-location-dot"></i> </span> Lieu Depart : </span><span>Paris</span>
                </div>
                <div class="mb-4">
                    <span class="text-xl"> <span> <i class="fa-solid fa-location-dot"></i> </span> Lieu Arrivee : </span><span>Espagne</span>
                </div>
                <div class="mb-4">
                    <span class="text-xl"> <span><i class="fa-solid fa-weight-hanging"></i> </span> Poids max : </span><span>200kg</span>
                </div>
                <div class="mb-4">
                    <span class="text-xl"><span><i class="fa-brands fa-product-hunt"></i></span> Nombre de produits : </span>39<span></span>
                </div>
                <div class="div">
                    <span class="text-xl"><span><i class="fa-brands fa-product-hunt"></i></span>Type : </span><span>Aerienne</span>
                </div>
            </div>

            <div class="div text-xl  text-black m-4  p-4 rounded-lg   bg-slate-200">
                <div class="hover:bg-white hover:rounded-full w-80 mb-6 hover:py-4 font-bold"> <button class="ml-3"><span class=" mr-4 text-3xl"><i class="fa-solid fa-gear"></i> </span> Parametre</button></div>
                <div class="hover:bg-white hover:rounded-full w-80 mb-6 hover:py-4 font-bold"> <button class="ml-3"><span class="mr-6"><i class="fa-solid fa-phone"></i> </span> contact</button></div>
                <div class="hover:bg-white hover:rounded-full w-80 mb-6 hover:py-4 font-bold"><button class="ml-3"><span class="mr-8"><i class="fa-solid fa-location-dot"></i> </span> Notre Position</button></div>
                <div class="hover:bg-white hover:rounded-full w-80 mb-6 hover:py-4 font-bold"> <button class="ml-3"><span class="mr-8"><i class="fa-solid fa-chevron-right"></i> </span> Promo</button></div>
            </div>

        </div>
    </div>
    </div>
</body>

</html>