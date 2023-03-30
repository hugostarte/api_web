<?php

namespace Model;

class Comment extends Model
{

    public function __construct()
    {
        parent::__construct("commentaires");
    }

    /*
    * Fonction de detection des commentaires suspects
    * Envoi un email en cas de detection de commentaires suspects
    */
    function antiSpam($chaine){
					
        $a_bannir = array('http', 'www', 'bot', 'investissement','robot ','bravo','riche',"https", "www", ".com", ".mx", ".org", ".net", ".co.uk", ".jp", ".ch", ".info", ".me", ".mobi", ".us", ".biz", ".ca", ".ws", ".ag", 
        ".com.co", ".net.co", ".com.ag", ".net.ag", ".it", ".fr", ".tv", ".am", ".asia", ".at", ".be", ".cc", ".de", ".es", ".com.es", ".eu", 
        ".fm", ".in", ".tk", ".com.mx", ".nl", ".nu", ".tw", ".vg", "sex", "porn", "fuck", "buy", "free", "dating", "viagra", "money", "dollars", 
        "payment", "website", "games", "toys", "poker", "cheap", "gratuit");

        $cpt_mots = 0;
        $chaine = strtolower($chaine);
        if(is_array($a_bannir)){
            foreach($a_bannir as $mot){
                $cpt_mots += substr_count($chaine, $mot);
            }
        }
        $message = "Un commentaire suspect a été posté";
        $to = "contact@hugostawiarski.fr";
        $email = "contact@hugostawiarski.fr";
        $object = "Spam detecte";
        $header = "From: ".$email." \r\n"."Reply-To: ".$email." \r\n"."Content-type: text/html; charset=UTF-8 \r\n";
        
        mail($to, $object, $message, $header);

        return ($cpt_mots > 0 ) ? true : false;
    }
    
}


?>
