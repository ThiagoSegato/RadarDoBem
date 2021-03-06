<?php
/**
 * Engine principal de carregamento do framework
 * Inicia configurações, sessão, conexão padrão do banco de dados e autenticação
 * @package includes
 * @version 1.1
 * @copyright atitudeweb
 * @license http://opensource.org/licenses/gpl-3.0.html GPL General Public License
 */

//Definindo constantes
define('ATITUDE_LIBRARIES', ATITUDE_BASE.DS.'com'.DS.'atitudeweb');

//Carregando classe do framework
if(!file_exists('../config.php')) {
	die('Arquivo de configuração não encontrado!');	
}
require_once('../config.php');
require_once(ATITUDE_LIBRARIES.DS.'loader.php');
Loader::import('com.atitudeweb.Session');
Loader::import('com.atitudeweb.Controller');
Loader::import('com.atitudeweb.database.Connection');
Loader::import('com.atitudeweb.IAuthenticate');
Loader::import('com.atitudeweb.Util');

Session::start();
Connection::open();

//Carregando classe de autenticação
if(!Loader::import(Config::AUTH_CLASS)){
	die('Classe de autenticação não encontrado!');	
}
$pack = explode('.', Config::AUTH_CLASS);
$auth = new $pack[count($pack) - 1];

//Carregando o usuário logado na sessão
$user = $auth->getLogin();

//Definindo variáveis da paginação
$limitPagina = 10;
$p = (@$_GET['p'] ? $_GET['p'] : 1);

/**
 * Realiza uma consulta na conexão padrão do banco de dados
 *
 * @param string $id - Identificador da conexão
 * @return com.atitudeweb.database.IResult
 */
function query($sql, $id=null){
	return Connection::query($sql, $id);
}

/**
 * Executa uma instrução no banco de dados
 *
 * @param string $id - Identificador da conexão
 * @return boolean
 */
function execute($sql, $id=null){
	return Connection::exec($sql, $id);
}

function lastInsertId(){
	return Connection::get()->lastInsertId();
}

?>