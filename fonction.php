<?php 

function get_user_pref(){
    
// Vérifie si l'utilisateur a cliqué sur le bouton de basculement de mode sombre
    if (isset($_GET['darkmode'])) {
        // Si l'utilisateur a cliqué sur le bouton, définit le cookie "darkmode" sur 1
        setcookie('darkmode', '1', time() + (365 * 24 * 60 * 60), '/');
    }
  
    // Vérifie si l'utilisateur a cliqué sur le bouton de basculement de mode clair
    if (isset($_GET['lightmode'])) {
        // Si l'utilisateur a cliqué sur le bouton, supprime le cookie "darkmode"
        setcookie('darkmode', '', time() - 3600, '/');
    }
  
    // Vérifie si le cookie "darkmode" est défini
    if (isset($_COOKIE['darkmode']) && $_COOKIE['darkmode'] == '1') {
        // Si le cookie est défini et sa valeur est 1, applique le mode sombre
        echo '<style>body{ background-color: #141414;} #entrer{color: #fff} .container-categories1{background-color: #000000!important;} .container-article{color:white;} .container-article h2{color:white;} .button-valide{background-color: white; color: black} .button-valide{background-color: #141414 !important; color: white !important; border: 1px solid white !important; transition: .2s linear !important;} .button-valide:hover{background-color: white !important; border: 1px solid white !important; color:black !important;} .article-title a{color:white!important;text-decoration:none!important;} .article-title a:hover{text-decoration:underline!important;} </style>';
    } else {
        // Sinon, applique le mode clair
        echo '<style>body { background-color: #fff; color: #141414; }</style>';
    }

}

function save_user_pref()
{
    // On vérifie l'existance de la clé dark / light dans le tableau $_POST
    if (isset($_POST['dark']) || isset($_POST['light'])) {
        $mode = isset($_POST['dark']) ? 'dark' : 'light';
        // On récupère l'id de l'utilisateur connecté pour l'utiliser comme clé dans le tableau stocké en cookie, le cas échéant on utilise 0.
        $userId = isset($_SESSION['id'])
            ? filter_var($_SESSION['id'], FILTER_SANITIZE_NUMBER_INT)
            : 0;

        !is_null($userId)
            ? setcookie("pref[$userId]", $mode, strtotime('1 year'))
            : setcookie("pref[$userId]", $mode);
        // On force le rafraîchement de la page pour récupérer la nouvelle valeur du cookie.
        header('Refresh:0');
        exit();
    }
}



function set_user_fav()
{
$check_list= filter_input(INPUT_POST, 'check_list' , FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY );

setcookie('user_favorite',json_encode($check_list), strtotime('1 year'));
}


function check_cookies()
{
    if (isset($_COOKIE['user_favorite'])) {
        $my_cookie_array = json_decode($_COOKIE['user_favorite']);
        return $my_cookie_array;
    } else {
        return false;
    }
}

?>