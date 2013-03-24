<?php
  // pub demo
  
function Pub($largeur,$hauteur)
{
    switch($largeur."x".$hauteur)
    {
        case '160x600':
            switch(rand(1,4))
            {
                case '1':
                    $pub = "<img src=\"http://hamovhotov.com/advertisement/wp-content/uploads/2007/03/160x600ad.gif\" width=\"160\" height=\"600\">";
                    break;
                case '2':
                    $pub = "<img src=\"http://www.13room.com/viewroom/girlfriend/actionista/gf_actionista_160x600.gif\" width=\"160\" height=\"600\">";
                    break;
                case '3':
                    $pub = "<img src=\"http://badges.imagecatalog.com/badges/160x600-1p.gif\" width=\"160\" height=\"600\">";
                    break;
                case '4':
                    $pub = "<img src=\"http://www.savemolives.com/programs/images/Yearbook-160x600.gif\" width=\"160\" height=\"600\">";
                    break;
            }
            break;
        case '468x60':
            switch(rand(1,4))
            {
                case '1':
                    $pub = "<img src=\"http://www.noname.fr/bandeaux-pub/images/ambiance-casino-468.gif\" width=\"468\" height=\"60\">";
                    break;
                case '2':
                    $pub = "<img src=\"http://www.noname.fr/bandeaux-pub/images/skull-poker.gif\" width=\"468\" height=\"60\">";
                    break;
                case '3':
                    $pub = "<img src=\"http://www.noname.fr/bandeaux-pub/images/v7ndotcom-elursrebmem-nn.gif\" width=\"468\" height=\"60\">";
                    break;
                case '4':
                    $pub = "<img src=\"http://www.noname.fr/bandeaux-pub/images/casino-en-ligne.gif\" width=\"468\" height=\"60\">";
                    break;
            }
            break;
    }
    
    return $pub;    
}
?>
