<html>
<head>
    <link href = "styles.css" rel = "stylesheet" type = "text/css" />
    <title>PHP Bing</title>
</head>
<body>
<?php
/**
 * GESTIONE DELLE CASELLE DI RICERCA
 *
 * Definiamo un array generico quale conterrà tutti gli attributi selezionabili (in questo caso, gli attributi
 * corrisponderanno a quelli presenti, solitamente, in un profilo).
 */
$attr_profile = array('id', 'first_name', 'last_name', "location", 'research_interests', "discipline");
/**
 * Definiamo un array con gli attributi non ancora selezionati dall'utente. Notare che, ogni volta che viene aperta
 * la pagina, esso contiene tutti gli attributi che definiscono il dato campo (quale può essere quello dei profili,
 * o dei cataloghi, ecc...)
 */
$attr_unselected = $attr_profile;
/**
 * Definiamo un array degli attributi selezionati dall'utente
 */
$attr_selected = array ();
/**
 * Ci assicuriamo che questa pagina abbia effettivamente ricevuto una richiesta da un'altra pagina di metodo
 * GET (ovvero, se siamo stati reindirizzati qui da un'altra pagina) e ci assicuriamo che, all'interno della richiesta,
 * il campo 'value' (ovvero, il campo al cui interno ci devono essere dei valori) non sia vuoto.
 *
 * Questo controllo serve per verificare le richieste mandate dalla pagina boxController, il quale
 * ci indicherà quali sono stati i campi selezionati dall'utente
 */
if (isset($_GET['value'])) {
    /**
     * Partendo dal presupposto che il campo 'value' altro non è se non un array. Pertanto, se è definito,
     * vorrà dire che conterrà almeno un valore.
     *
     * Quindi ad ogni valore definito, sarà aggiunto nell'array dei campi selezionati dall'utente, e verrà di conseguenza
     * rimosso dall'altro ($attr_unselected)
     *
     * Terminato il ciclo, i rispettivi valori saranno mostrati nelle opzioni delle barre di selezione, per poter
     * permettere di aggiungere/rimuovere gli attributi che serviranno, in seguito, per la ricerca di un dato profilo
     * o articolo
     */
    foreach ($_GET['value'] as $value) {
        $attr_selected[] = $value;
        $attr_unselected = array_diff($attr_unselected, array($value));
    }
}
?>
<!--
Creiamo un form per aggiungere gli attributi ed un altro per rimuoverli.
Quando viene selezionato un pulsante, quale che sia e quale che sia il campo desiderato, verranno mandati
tramite methodo POST alla pagina boxController
-->
<form action= {{return view('example.boxController')}} method = "POST">
    <select name = "attribute">
        <option disabled selected value> -- select an attribute -- </option>
        <?php foreach ($attr_unselected as $attr) { echo('<option value="'.$attr.'">'.$attr.'</option>');}?>
    </select>
    <button name = "subject" type = "submit" value = "addAttr">+</button><br>
</form>
<form action="boxController.php" method = "POST">
    <select name = "attribute">
        <option disabled selected value> -- select an attribute -- </option>
        <?php foreach ($attr_selected as $attr) { echo('<option value="'.$attr.'">'.$attr.'</option>');}?>
    </select>
    <button name = "subject" type = "submit" value = "removeAttr">-</button><br>

</form>
<form action=<?php echo $_SERVER['PHP_SELF'].(!empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : false); ?> method = "POST">
<?php
/**
 * Infine, in base agli attributi selezionati dall'utente, mostriamo le caselle associate ad esse.
 */
foreach ($attr_selected as $attr){
    switch ($attr){
        /**
         * La casella Disciplina è un caso particolare. Il motore di ricerca Mendeley è in grado di categorizzare
         * i profili in base a delle "discipline" pre-impostate. Difatti, alla comparsa della casella associata, non
         * si avrà modo di inserire manualmente il valore, dato che ci saranno, appunto, le discipline pre-impostate
         * definite da Mendeley stesso.
         */
        case "discipline":
            echo ($attr.': <select name = "'.$attr.'">');
            echo ('<option disabled selected value> -- select a discipline -- </option>');
            $accessToken = getMendeleyToken();
            /**
             * Per l'appunto, questi valori pre-impostati li richiediamo da mendeley stesso
             */
            $result = callMendeleyAPI("https://api.mendeley.com/disciplines",false,$accessToken);
            $json = json_decode($result, true);
            foreach ($json as $discipline)
                echo ('<option value="'.$discipline['name'].'">'.$discipline['name'].'</option>');
            echo ('</select><br>');
            break;
        /**
         * Al contrario, il resto degli attributi possono essere liberamente compilabili
         */
        default:
            echo($attr.': <input type = "text" name = "'.$attr.'"><br>');
            break;
    }
}
echo ('<button name = "subject" type = "submit" value = "profiles">Search</button>');
echo ('</form>');
/**
 * RISULTATI DI RICERCA
 *
 * Ci assicuriamo di aver ricevuto un richiesta con metodo POST (ovvero, è lo stesso che manda a sè stesso
 * non appena viene cliccato il pulsante Search
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accessToken = getMendeleyToken();
    $requestPath = "/search/".$_REQUEST['subject']."?";
    $queryArr = array();
    $query = array('query' => false);
    /**
     * Ciascun elemento inserito nelle caselle, lo inseriamo in un array, decodificandolo in formato URL.
     */
    foreach ($attr_selected as $string)
        if (!empty($_POST[$string]))
            $query['query'].= (urlencode(' '.$_POST[$string]));
    $result = callMendeleyAPI ("https://api.mendeley.com".$requestPath, $query, $accessToken);
    $json = json_decode($result, true);
    if (is_array($json)) {
        foreach ($json as $result){
            echo '<p>';
            /**
             * Dato che gli attributi sono gli stessi che definiscono i profili presenti su Mendeley, ci basta
             * richiamare l'array quale contiene quelli di nostro interesse e, a ciascun profilo, mostriamo i campi
             * desiderati.
             *
             * NOTA: spesso il risultato associato ad un determinato attributo può essere in formato Array.
             * per ovviare, banalmente, mostreremo solo il nome di tale attributo, dato che sarà l'informazione più
             * rilevante (per esempio, di "location", oltre al nome, possiede anche altitudine e logitudine della
             * località. Inutile dire che sono informazioni irrilevanti per l'utente).
             *
             * ULTIMA NOTA: alcuni profili sono auto-generati da Mendeley, pertanto potrebbero mancare di alcuni campi
             * quali, per esempio, la località, dato che può essere definito solo se il profilo viene creato
             * dallo stesso utente
             */
            foreach ($attr_profile as $attribute){
                if (isset($result[$attribute])){
                    if (is_array($result[$attribute]))
                        echo ' '.$result[$attribute]['name'];
                    else
                        echo ' '.$result[$attribute];
                }
            }
            echo ';</p>';
        }
    }
}
?>
</body>
</html>

<?php
/**
 * @param $url l'url da cui bisogna effettuare la richiesta
 * @param $query array contenente la richiesta da porre (ciascun valore deve essere codificato in URL, vedi 'urlencode')
 * @param $token token per poter fare la richiesta (vedi getMendeleyToken() )
 * @return bool|mixed Se la richiesta è ben strutturata, e se è presente un token valido, restituirà il json associato. Altrimenti false
 *
 * Questa richiesta viene effettuata tramite metodo GET, dato che, in questo caso, si tratterà di effettuare
 * solo delle interrogazioni, pertanto non c'è la necessità di dover nascondere all'utente le richieste effetuate.
 * Ovviamente qualora si volessero effettuare operazioni di modifica/cancellazione tramite API, in tal caso
 * bisognerà modificare il metodo, oltre che modificare la funzione stessa
 */
function callMendeleyAPI ($url, $query, $token) {
    if ($token) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        $headers = array();
        $headers[] = "Authorization: Bearer ".$token;
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $url.htmlentities(http_build_query($query)));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        if (curl_errno($curl))
            die ('Error:' . curl_error($curl));
        return $result;
    }
    return false;
}
/**
 * @return mixed ritorna il token quale permetterà SOLO operazioni di lettura
 */
function getMendeleyToken(){
    $curl = curl_init();
    $url = 'https://api.mendeley.com/oauth/token';
    $query = array ('grant_type' => 'client_credentials', 'scope' => 'all');
    $id = "5047"; //ID dell'applicazione
    $secret = "iOU6ZIt9cvL5spaz"; //Codice segreto che viene fornito da Mendeley alla registrazione dell'applicazione
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($query));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_USERPWD, $id . ":" . $secret);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    if (curl_errno($curl))
        die ('Error:' . curl_error($curl));
    $json = json_decode($result, true);
    return $accessToken = $json['access_token'];
}
?>