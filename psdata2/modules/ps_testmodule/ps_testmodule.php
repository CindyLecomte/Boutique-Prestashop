<?php

/* Test initial : 1e étape = vérifier que la constante PS_VERSION est définie*/
 
    if (!defined('_PS_VERSION_')) {
        exit;                       /* Cette ligne de code permet de vérifier qu'une constante qui est toujours définie dans Prestashop existe et est accessible. Cela indique que l'environnement est bien chargé. */
    }


/* Classe principale : 2e étape = On définit la classe du module. Elle doit être nommée de la même manière que le fichier de module et son dossier, en CamelCase.*/
    class Ps_TestModule extends Module /* La classe extends la classe Module, c'est é dire qu'elle hérite de celle-ci. */
{
    /* Constructeur : Chaque classe dispose d'un constructeur. Cette méthode est appelée lorsqu'une classe de notre module est instanciée avec le mot clé new.*/
    public function __construct() /* Voici en détail ce que fait la méthode __construct : */
    {
        $this->name = 'ps_testmodule'; /* Permet de définir le nom du module. Il s'agit d'un identifiant interne qui doit porter le même nom que le dossier du module.*/
        $this->tab = 'front_office_features'; /* Défini à quel onglet appartient le module.*/
        $this->version = '1.0.0'; /* Défini la version du module. */
        $this->author = 'Cindy'; /* Spécifie l'auteur du module. */
        $this->need_instance = 0; /* Indique s'il faut créer une instance du module au chargement de la liste des modules installés dans Prestashop. Une instance peut-être utile si on doit afficher un avettissement sur la page des modules par exemple.*/
        $this->ps_versions_compliancy = [ 
            'min' => '1.7',
            'max' => _PS_VERSION_ /* Défini avec quelle version de Prestashop le module est compatible. Ici, on indique de la version 1.7 jusqu'a la version actuelle de Prestashop. */
        ];
        $this->bootstrap = true; /* Indique qu'on va utiliser le système de rendu Booststrap pour ce module. Cela améliorera l'affichage. */

        parent::__construct(); /* Appel le constructeur de la classe parente, donc Module, pour exécuter la méthode constructeur de base. */

        $this->displayName = $this->l('Module Cindy'); /* Défini le nom affiché dans la liste des modules. */
        $this->description = $this->l('Test premier module'); /* Défini la description affichée dans la liste des modules.*/

        $this->confirmUninstall = $this->l('Êtes-vous sûr de vouloir désactiver ce module ?'); /* Message de confirmation (optionnel) à afficher lors de la désisntallation. */

        if (!Configuration::get('PS_TESTMODULE_PAGENAME')) { /* Permet de vérifier si la valeur PS_TESTMODULE_PAGENAME est configurée ou non. */
            $this->warning = $this->l('Aucun nom fourni');
        }
    }
/* A ce moment là, on peut voir apparâitre notre module avec le nom choisi donc 'Module Cindy' dans la liste des Modules de Prestashop. On peut l'installer, mais il ne fera rien pour l'instant. */

/* Installation / désinstallation : Par défaut, les méthodes install et uninstall appellent celles de la classe parente. Ici donc, si ces méthodes ne sont pas spécifiées, Prestashop appel celle de la classe Module.
Voici comment appeler ces méthodes en ajoutant la valeur de configuration PS_TEST_MODULE_PAGENAME mentionnée plus haut, et inscrire le module à des hooks spécifiques à l'installation. : */
    public function install()
    {
        if (Shop::isFeatureActive()) { /* Vérifie si le mode multi-boutique de Prestashop est activé. */
            Shop::setContext(Shop::CONTEXT_ALL); /* Si c'est le cas, définit le contexte pour appliquer l'installation à toutes les boutiques. */
        }
    
        if (!parent::install() || /* En récupérant le résultat de cette méthode, un test vérifie que l'installation s'est bien déroulée.*/
            !$this->registerHook('leftColumn') || /* En s'inscrivant au hook leftColumn*/
            !$this->registerHook('leftColumnCindy') || /* Pour le test, on enregistre le module sur leftColumnCindy*/
            !$this->registerHook('header') ||   /* Au hook header*/
            !Configuration::updateValue('PS_TESTMODULE_PAGENAME', 'Mentions légales') /* Et en enregistrant la valeur PS_TESTMODULE_PAGENAME.*/
        ) {
            return false; /* Chacune de ces actions va s'éxécuter et si l'une d'elle retourne false, l'installation a échoué.*/
        }
    
        return true;   /* Dans le cas contraire, l'installation a réussi. */
    }

    /* Une fois l'installation réalisée, on aura donc inscrit notre module aux hooks leftColumn et header, et on a créé un nouveau réglage dans la base de données appelée PS_TESTMODULE_PAGENAME. */

    /* Lors de la désinstallation, pas besoin de désinscrire le module des différents hooks.
    Cependant, il est important, pour faire une désinstallation propre, de supprimer le réglage PS_TESTMODULE_PAGENAME créé dans la base. 
    Voici comment procéder : */
    public function uninstall()
    {
        if (!parent::uninstall() ||
            !Configuration::deleteByName('PS_TESTMODULE_PAGENAME')
        ) {
            return false;
        }
        return true; /* Ce code vérifie que la méthode uninstall retourne true et pareil pour la méthode de suppression du réglage appelée Configuration::deleteByName(). */
    }


/* Le module a bien été créé, maintenant, nous allons lui donner une utilité.
    On va créer un formulaire dans le back office pour gérer ses régleges
    Dans notre cas, on n'aura qu'un seul réglage appelé PS_TESTMODULE_PAGENAME, qui demandera le nom d'une page qui sera affiché en lien dans la colonne de gauche de Prestashop. */

    /* Afficher une page de configuration : Pour que Prestashop sache que notre module dispose d'une page de configuration, il faut utiliser la méthode getContent(), qui retournera un formulaire accessible par l'utilisateur.
        Si cette méthode existe, un bouton Configurer apparaîtra à droite du module (même si cela ne retourne rien).
        
        Contenu de la méthode : */
        public function getContent()
{
            $output = null;
 
        if (Tools::isSubmit('btnSubmit')) { /* On vérifie si le formulaire a été envoyé ou non en fonction du nom du bouton de validation, ici appelé btnSubmit. Si ce n'est pas le cas, il affiche simplement le formulaire plus bas, sinon il gère les informations envoyées par le formulaire.*/
        $pageName = strval(Tools::getValue('PS_TESTMODULE_PAGENAME')); /* On récupère la valeur de PS_TESTMODULE_PAGENAME avec strval(Tools::getValue('PS_TESTMODULE_PAGENAME')*/
 
        if (
            !$pageName||
            empty($pageName) /* On teste cette valeur en regardant si elle existe et si elle n'est pas vide .*/
        ) {
            $output .= $this->displayError($this->l('Invalid Configuration value')); /* Si elle n'est pas valide, on affiche une erreur.*/
        } else {
            Configuration::updateValue('PS_TESTMODULE_PAGENAME', $pageName); /* Sinon, on met à jour la valeur */
            $output .= $this->displayConfirmation($this->l('Settings updated')); /* Et on affiche une confirmation de modification*/
        }
    }
 
    return $output.$this->displayForm(); /* Pour finir, on fait appel à la méthode displayForm (qu'on va créer par la suite) pour afficher le contenu du formulaire. */
}
        


/* Créer un formulaire : La méthode getContent() s'occupé de gérer l'affichage de la page de configuration, pour simplifier les choses, on va gérer l'affichage du formulaire dans une méthode à part, appelée displayForm.
    Cette méthode utilisera la classe HelperForm, qui met à disposition toute une série de méthodes pour créer des formumaires dans le Back Office. 
    Voici la méthode : */
    public function displayForm()
{

    $defaultLang = (int)Configuration::get('PS_LANG_DEFAULT'); /* On récupère la langue actuelle, ce qui nous permettra de définir la langue du formulaire plus tard.*/ 
  
    $form = array( /* On crée les différents éléments qui composeront notre formulaire : */
        'form' => array( 
            'legend' => array(  /* Le titre (legend) */
                'title' => $this->l('Settings'),
            ),
            'input' => array(   /* Le champ (input)*/
                array(
                    'type' => 'text',
                    'label' => $this->l('Configuration value'),
                    'name' => 'PS_TESTMODULE_PAGENAME',
                    'size' => 20,
                    'required' => true
                )
            ),
            'submit' => array( /* Le bouton de validation (submit) */
                'title' => $this->l('Save'),
                'name'  => 'btnSubmit' /* On lui donne le nom btnSubmiy pour valider l'envoi du formulaire plus haut.*/
            )
        ),
    );
  
    $helper = new HelperForm(); /* On crée un nouvel objet HelperForm, il recevra les champs définis en paramètre lors de la génération.*/
  
    $helper->module = $this; /* Spécifie le module parent de ce formulaire*/
    $helper->name_controller = $this->name; /* Renseigne le nom du controller, ici, le nom du module*/
    $helper->token = Tools::getAdminTokenLite('AdminModules');  /* Token unique spécifique à ce formulaire. Ce token est généré grâce à la méthode getAdminTokenLite, fournie par Prestashop. */
    $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name; /* Indique la valeur de l'attribut action du formulaire, donc l'URL à laquelle soumettre le formulaire. Là, il s'agit du controller actuel avec en paramètre le ,om de notre module en valeur de la clé configure. (en gros, la page actuelle)*/
  
    $helper->default_form_language = $defaultLang;  /* Défini la langue utilisée pour ce formulaire à la langue par défaut du shop récupérée plus haut.*/
  
    
    $helper->fields_value['PS_TESTMODULE_PAGENAME'] = Configuration::get('PS_TESTMODULE_PAGENAME'); /* On récupère la valeur actuelle de notre champ dans la base pour l'afficher*/
  
    return $helper->generateForm(array($form)); /* Pour finir, on génère le formulaire avec en paramètre la liste des champs à créer*/
}

 /* A ce stade, on doit avoir notre module avec la possibilité de le configurer.*/
        

/* Afficher du contenu sur la boutique : Ajouter les méthodes liées aux Hooks*/

/* Pour afficher du contenu sur la boutique, */

/** Hook test */
public function hookleftColumnCindy($params)
{
    return "truc muche"; /* Pour le test, on a imbriqué le hook leftColumnCindy sur product.tpl du thème enfant, ce qui nous donnera le rendu qu'on a retourné ici.*/
}

/* On reprend notre code plus haut : 
public function install()
    {
        if (Shop::isFeatureActive()) { 
            Shop::setContext(Shop::CONTEXT_ALL); 
        }
    
        if (!parent::install() || 
            !$this->registerHook('leftColumn') || 
            !$this->registerHook('leftColumnCindy') || 
            !$this->registerHook('header') || 
            !Configuration::updateValue('PS_TESTMODULE_PAGENAME', 'Mentions légales') 
        ) {
            return false; 
        }
    
        return true;  
*/

/* On va ajouter un code qui va permettre de gérer l'affichage du contenu dans la colonne de gauche avec la métode hookDisplayLeftColumn.
    Lors de l'enregistrement du hook, le nom était leftColum. La méthode à appeler se forme de hook qui préfixe chaque méthode de ce type. Display indique qu'il s'agit d'un Hook d'affichagen et leftColumn représente le nom du hook.*/

    public function hookDisplatLeftColumn($params)
    {
        $this->context->smarty->assign([ /* Cette méthode va commencer par afficher des variables qui seront utilisables dans les modèles tpl. Grâce à la méthode $this->context->smarty->assign, on peut assigner des variables à la vue. */
            'ps_page_name' => Configuration::get('PS_TESTMODULE_PAGENAME'), 
            'ps_page_link' => $this->context->link->getModuleLink('ps_testmodule', 'display')   /* Ces variables appelées ici : ps_page_name et ps_page_link, seront ensuite accessibles dans la vue sous la forme : $ps_page_name et $ps_page_link*/
        ]); /* ps_page_name va récupérer le champ dans la table ps_configuration, tel que défini dans la configuration du module. ps_page_link va récupérer un lien vers une action display de notre module ps_testmodule. On le définira plus loin. */

        return $this->display(__FILE__, 'ps_testmodule.tpl'); /* Pour finir, $this->display s'occupe de récupérer le fichier de template ps_testmodule.tpl utilisé pour afficher le contenu. */
    }

    /* Le hook leftColumn a été défini. Maintenant, on va définir le hook header. Celui-ci sera exécuté dans la balise <head> du document HTML. */

    public function hookDisplayHeader()
    {
        $this->context->controller->registerStylesheet(
            'ps_testmodule',
            $this->_path.'views/css/ps_testmodule.css',
            ['server' => 'remote', 'position'=> 'head', 'priority' => 150 ]
        );
    }
/* Le hook header est très utile pour ajouter des fichiers CSS ou JavaScript à nos pages. 
    La méthode registerStyleSheet permet de générer une ligne de type <link> pour afficher le CSS correctement en fonction du chemin donné. */

/* Effectuer le rendu : Pour gérer l'affichage des templates, on a créé des sous-dossiers /views/templates/hooks et on a ajouter un fichier ps_testmodule.tpl*/ 





}





