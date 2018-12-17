<?php
$ns = "http://".$_SERVER['HTTP_HOST']."/wsperpus/wskategori.php";

require_once 'lib/nusoap.php';
$server = new soap_server;
$server->configureWSDL("web service menggunakan soap WSDL", $ns);
$server->wsdl->schemaTargetNamespace = $ns;

$server->wsdl->addComplexType("kategoriData", "complexType", "struct", "all", "",
	array(
		"id_kategori_buku" => array("name" => "kategori_buku", "type"=>"xsd:int"),
		"kategori_buku" => array("name" => "kategori_buku", "type" => "xsd:string")
	)
);
$server->wsdl->addComplexType(
	"kategoriArray",
	"complexType",
	"array",
	"",
	"SOAP-ENC:Array",
	array(),
	array(
		array(
			"ref" => "SOAP-ENC:arrayType",
			"wsdl:arrayType" => "tns:kategoriData[]"
			)
		),
	"kategoriData");

$input_create = array('kategori_buku' => "xsd:string");
$return_create = array("return" => "xsd:string");
$server->register('create', $input_create, $return_create, $ns, "urn:".$ns."/create", "rpc", "encoded", "Menyimpan Kategori Buku Baru");

$input_readbyid = array('id_kategori_buku' => "xsd:int");
$retun_readbyid = array("return" => "tns:kategoriArray");
$server->register('readbyid', $input_readbyid, $retun_readbyid, $ns, "urn:".$ns."/readbyid",
	"rpc", "encoded", "Mengambil kategori buku by id_kategori_buku");

$input_update =array("id_kategori_buku" => "xsd:int", "kategori_buku"=> "xsd:string");

$return_update = array("return" => "xsd:string");
$server->register('updatebyid', $input_update, $return_update, $ns, "urn:".$ns."/updatebyid", "rpc", "encoded", "Mengupdate kategori by id_kategori_buku");

$input_delete = array('id_kategori_buku' =>"xsd:string");

$return_delete = array("return" => "xsd:string");
$server->register('deletebyid', $input_delete, $return_delete, $ns, "urn:".$ns."/deletebyid",
	"rpc", "encoded", "Menghapus kategori by id_kategori_buku");

$input_readall = array();
$return_readall = array("return" => "tns:kategoriArray");
$server->register('readall', $input_readall, $return_readall, $ns, "urn:".$ns."/readall",
	"rpc", "encoded", "Mengambil data kategori buku");

function create($kategori_buku){
	require_once 'classDB/Classkategori.php';
	$kategori = new Classkategori;
	if($kategori->create($kategori_buku)){
		$respon = "sukses";
	}else{
		$respon = "error";
	}
	return $respon;
}

function readbyid($id_kategori_buku){
	require_once 'classDB/Classkategori.php';
	$kategori =new Classkategori;
	$hasil = $kategori->readbyid($id_kategori_buku);
	$daftar = array();
	while($item = $hasil->fetch_assoc()){
		array_push($daftar, array('id_kategori_buku'=> $item['id_kategori_buku'], 'kategori_buku' => $item['kategori_buku']));
	}
	return $daftar;
}

/*function readall(){
	require_once 'classDB/Classkategori.php';
	$kategori = new Classkategori;
	$hasil = $kategori->readAll();
	$daftar = array();
	while($item = $hasil->fetch_assoc()){
		array_push($daftar, array('id_kategori_buku'=> $item['id_kategori_buku'],
			'kategori_buku' => $item['kategori_buku']));
	}
	return $daftar;
}
*/

function readall(){
	require_once 'classDB/Classkategori.php';
	$kategori = new Classkategori;
	$hasil = $kategori->readAll();
	$daftar = array();
	while($item = $hasil->fetch_assoc()){
		array_push($daftar, array('id_kategori_buku'=> $item['id_kategori_buku'],
			'kategori_buku' => $item['kategori_buku']));
	}
	return $daftar;
}

function updatebyid($id_kategori_buku, $kategori_buku){
	require_once 'classDB/Classkategori.php';
	$kategori = new Classkategori;
	if($kategori->updatebyid($id_kategori_buku, $kategori_buku)){
		$respon = "sukses";
	}else{
		$respon = "error";
	}

	return $respon;
}

function deletebyid($id_kategori_buku){
	require_once 'classDB/Classkategori.php';
	$kategori = new Classkategori;
	if($kategori->deletebyid($id_kategori_buku)){
		$respon = "sukses";
	}else{
		$respon = "error";
	}

	return $respon;
}

$server->service(file_get_contents("php://input"));