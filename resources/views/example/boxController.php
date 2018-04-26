<?php
/**
 * ricavo subito l'url della pagina quale ha effettuato la richiesta
 */
$url = $_SERVER['HTTP_REFERER'];
/**
 * mi assicuro che sia stato effettivamente selezionato un valore da aggiugere / rimuovere
 */
if (isset($_POST['attribute'])){
    switch ($_REQUEST['subject']) {
        //AGGIUNGI ATTRIBUTO
        case 'addAttr':
            /**
             * aggiungo il valore nella url, in modo tale da poterla poi re-inviare alla stessa pagina tramite metodo GET
             */
            $url .= (strpos($url, '?') == false) ? '?' : '&';
            $url .= 'value[]='.$_POST['attribute'];
            break;
        //RIMUOVI ATTRIBUTO
        case 'removeAttr':
            $input_string = substr($url,strpos($url,'?')+1);
            /**
             * ricavo la stringa in cui sono contenuti i valori ($input_string), dopo di che ne ricavo l'array
             * definita dai quei valori ($array_string)
             */
            parse_str($input_string,$array_string);
            $array_string['value'] = array_diff($array_string['value'],array($_POST['attribute']));
            $url = substr($url, 0, strpos($url,'?')+1);
            /**
             * dopo aver rimosso il campo desiderato dall'array, ristrutturo l'url in modo tale che abbia lo stesso
             * percorso / valori, meno però il valore cancellato
             */
            if (!empty($array_string['value']))
                $url .= http_build_query($array_string);
            break;
        default :
            break;
    }
}
header('Location: example.'.$url);
exit;
?>