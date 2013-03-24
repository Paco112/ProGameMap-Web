<?php if (!defined('IN_PHPBB')) exit; ?>Subject: Avertissement de réponse à un sujet - "<?php echo (isset($this->_rootref['TOPIC_TITLE'])) ? $this->_rootref['TOPIC_TITLE'] : ''; ?>"

Bonjour <?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; ?>,

Vous recevez cet avertissement car vous surveillez le sujet "<?php echo (isset($this->_rootref['TOPIC_TITLE'])) ? $this->_rootref['TOPIC_TITLE'] : ''; ?>" sur "<?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?>". Ce sujet a reçu une réponse depuis votre dernière visite. Vous pouvez utiliser le lien suivant afin de consulter les réponses qui ont été publiées, aucun nouvel avertissement ne vous sera envoyé jusqu'à ce que vous visitez le sujet.

Si vous souhaitez consulter le nouveau message écrit depuis votre dernière visite, veuillez cliquer sur le lien suivant :
<?php echo (isset($this->_rootref['U_NEWEST_POST'])) ? $this->_rootref['U_NEWEST_POST'] : ''; ?>


Si vous souhaitez consulter le sujet, veuillez cliquer sur le lien suivant :
<?php echo (isset($this->_rootref['U_TOPIC'])) ? $this->_rootref['U_TOPIC'] : ''; ?>


Si vous souhaitez consulter le forum, veuillez cliquer sur lien suivant :
<?php echo (isset($this->_rootref['U_FORUM'])) ? $this->_rootref['U_FORUM'] : ''; ?>


Si vous ne souhaitez plus surveiller ce sujet, vous pouvez cliquer sur le lien "Se désabonner au sujet" situé en bas du sujet dont l'adresse est située ci-dessus ou cliquer sur le lien suivant :

<?php echo (isset($this->_rootref['U_STOP_WATCHING_TOPIC'])) ? $this->_rootref['U_STOP_WATCHING_TOPIC'] : ''; ?>


<?php echo (isset($this->_rootref['EMAIL_SIG'])) ? $this->_rootref['EMAIL_SIG'] : ''; ?>