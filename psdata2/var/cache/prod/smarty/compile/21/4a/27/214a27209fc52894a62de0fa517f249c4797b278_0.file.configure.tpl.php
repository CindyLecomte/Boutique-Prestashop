<?php
/* Smarty version 4.3.4, created on 2024-03-15 10:57:56
  from '/var/www/html/modules/mymoduletest/views/templates/admin/configure.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_65f41ba4da8a74_69445204',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '214a27209fc52894a62de0fa517f249c4797b278' => 
    array (
      0 => '/var/www/html/modules/mymoduletest/views/templates/admin/configure.tpl',
      1 => 1710496604,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65f41ba4da8a74_69445204 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="panel">
	<h3><i class="icon icon-credit-card"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'mymoduletest','mod'=>'mymoduletest'),$_smarty_tpl ) );?>
</h3>
	<p>
		<strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Here is my new generic module!','mod'=>'mymoduletest'),$_smarty_tpl ) );?>
</strong><br />
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Thanks to PrestaShop, now I have a great module.','mod'=>'mymoduletest'),$_smarty_tpl ) );?>
<br />
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'I can configure it using the following configuration form.','mod'=>'mymoduletest'),$_smarty_tpl ) );?>

	</p>
	<br />
	<p>
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'This module will boost your sales!','mod'=>'mymoduletest'),$_smarty_tpl ) );?>

	</p>
</div>

<div class="panel">
	<h3><i class="icon icon-tags"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Documentation','mod'=>'mymoduletest'),$_smarty_tpl ) );?>
</h3>
	<p>
		&raquo; <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'You can get a PDF documentation to configure this module','mod'=>'mymoduletest'),$_smarty_tpl ) );?>
 :
		<ul>
			<li><a href="#" target="_blank"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'English','mod'=>'mymoduletest'),$_smarty_tpl ) );?>
</a></li>
			<li><a href="#" target="_blank"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'French','mod'=>'mymoduletest'),$_smarty_tpl ) );?>
</a></li>
		</ul>
	</p>
</div>
<?php }
}
