<?php 

    if(!defined('_PS_VERSION_')) {
        exit;
    }

    class EditBanner extends Module {

        public function __construct()
        {
            $this->name = 'editbanner';
            $this->tab = 'front_office_features';
            $this->version = '1.0.0';
            $this->author = 'Cindy';
            $this->need_instance = 0;
            $this->ps_versions_compliancy = [
                'min' => '1.7',
                'max' => _PS_VERSION_
            ];
            $this->bootstrap = true;

            parent::__construct();

            $this->displayName = $this->l('Module bannière éditable');
            $this->description = $this->l('Bannière éditable');

            $this->confirmUninstall = $this->l('Êtes-vous sûr de vouloir désisntaller ce module ?');

            if (!Configuration::get('EDITBANNER_PAGENAME')) {
                $this->warning = $this->l('Aucun nom fourni');
            }
        }

        public function install()
        {
            if(Shop::isFeatureActive()) {
                Shop::setContext(Shop::CONTEXT_ALL);
            }
            if (!parent::install() ||
                $this->registerHook('Home') ||
                !Configuration::updateValue('EDITBANNER_PAGENAME', 'Mentions légales')  
            ) {
                return false;
            }
            return true;
        }

        public function uninstall()
        {
            if (!parent::uninstall() ||
            !Configuration::deleteByName('EDITBANNER_PAGENAME')
            ) {
                return false;
            }
                return true;
        
        }


        public function getContent()
        {
            $output = null;

            if(Tools::isSubmit('btnSubmit')) {
                $pageName = strval(Tools::getValue('EDITBANNER_PAGENAME'));

                if (
                    !$pageName||
                    empty($pageName)
                ) {
                    $output .= $this->displayError($this->l('Invalid Configuration Value'));
                } else {
                    Configuration::updateValue('EDITBANNER_PAGENAME', $pageName);
                    $output .= $this->displayConfirmation($this->l('Settings updated'));
                }
            }

            return $output.$this->displayForm();
        }

        public function displayForm()
        {
            $defaultLang = (int)Configuration::get('PS_LANG_DEFAULT');

            $form = array(
                'form' => array(
                    'legend' => array(
                        'title' => $this->l('Settings'),
                    ),
                    'input' => array(
                        array(
                            'type' => 'text',
                            'label' => $this->l('Configuration value'),
                            'name' => 'EDITBANNER_PAGENAME',
                            'size' => 20,
                            'required' => true
                        )
                        ),
                        'submit' => array(
                            'title' => $this->l('Save'),
                            'name' => 'btnSubmit'
                        )
                        ),
                    );

                    $helper = new HelperForm();

                    $helper->module = $this;
                    $helper->name_controller = $this->name;
                    $helper->token  = Tools::getAdminTokenLite('AdminModules');
                    $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

                    $helper->default_form_language = $defaultLang;

                    $helper->fields_value['EDITBANNER_PAGENAME'] = Configuration::get('EDITBANNER_PAGENAME');

                    return $helper->generateForm(array($form));
        }









    }