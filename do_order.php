<?php /*
	Copyright 2014-2015 Cédric Levieux, Jérémy Collot, ArmagNet

	This file is part of VPN.

    VPN is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    VPN is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with VPN.  If not, see <http://www.gnu.org/licenses/>.
*/
define("WITHOUT", 45);
define("WITH", 60);
define("POSTAL", 5);
define("BYHAND", 0);

require_once("config/database.php");
require_once("engine/morning/api.php");
require_once("engine/bo/AddressBo.php");
require_once("engine/bo/OrderBo.php");
require_once("engine/bo/PaymentBo.php");

$morningApi = new MorningApiClient($config["morning"]["api_url"], $config["morning"]["token"]);
$connection = openConnection();

$addressBo = AddressBo::newInstance($connection);
$orderBo = OrderBo::newInstance($connection);
$paymentBo = PaymentBo::newInstance($connection);

$address = array();

$address["add_entity"] = $_REQUEST["identity"];
$address["add_email"] = $_REQUEST["xxx"]; //confirmationMail
$address["add_line_1"] = $_REQUEST["line1"];
$address["add_line_2"] = $_REQUEST["line2"];
$address["add_zip_code"] = $_REQUEST["zipCode"];
$address["add_city"] = $_REQUEST["city"];
$address["add_company_name"] = "";
$address["add_country_id"] = 1;

$addressBo->addAddress($address);

$title = "";

$order = array();
$order["ord_amount"] = 0;
$order["ord_lines"] = array();

$order["ord_invoice_address_id"] = $address["add_id"];

$orderLine = array();
$orderLine["oli_quantity"] = "1";

switch($_REQUEST["paveInput"]) {
	case "with":
		$orderLine["oli_product_code"] = "pave_with";
		$orderLine["oli_label"] = "Pavé avec un an de VPN préconfiguré";
		$orderLine["oli_unity_price"] = WITH;

		$orderLine["oli_additional_information"] = array();
		$orderLine["oli_additional_information"]["vpn_login"] = $_REQUEST["vpnLogin"];
		$orderLine["oli_additional_information"]["vpn_password"] = $_REQUEST["vpnPassword"]; 

		break;
	case "without":
		$orderLine["oli_product_code"] = "pave_without";
		$orderLine["oli_label"] = "Pavé nu";
		$orderLine["oli_unity_price"] = WITHOUT;
		break;
}

$title = $orderLine["oli_label"];

$orderLine["oli_amount"] = $orderLine["oli_quantity"] * $orderLine["oli_unity_price"];

$order["ord_lines"][] = $orderLine;
$order["ord_amount"] += $orderLine["oli_amount"];

if ($_REQUEST["deliveryInput"] == "postal") {
	$orderLine = array();
	$orderLine["oli_quantity"] = "1";
	
	$orderLine["oli_product_code"] = "postal";
	$orderLine["oli_label"] = "Frais de port";
	$orderLine["oli_unity_price"] = POSTAL;
	
	$orderLine["oli_amount"] = $orderLine["oli_quantity"] * $orderLine["oli_unity_price"];
	
	$order["ord_lines"][] = $orderLine;
	$order["ord_amount"] += $orderLine["oli_amount"];

	$order["ord_delivery_address_id"] = $address["add_id"];

	$title .= " - Par la poste";
}
else {
	$title .= " - Délivré en main propre";
}

$orderBo->save($order);

$backUrl = $config["morning"]["back_url"] . $order["ord_id"];

// if ($_SERVER["HTTP_REFERER"]) {
// 	$backUrl .= "&referer=" . urlencode($_SERVER["HTTP_REFERER"]);
// }

$payment = array("pay_request" => array());
$payment["pay_order_id"] = $order["ord_id"];
$payment["pay_type"] = "morning";
$payment["pay_amount"] = number_format($order["ord_amount"], 2, '.', '');
$payment["pay_request"] = $morningApi->createPayment($payment["pay_amount"], "$title - PP_" . date("Y") . "_" . $payment["pay_order_id"], "direct", $payment["pay_order_id"], $backUrl);
$payment["pay_response"] = "";

$paymentBo->save($payment);

$paymentLink = $payment["pay_request"]["link"];

$data = array();
$data["ok"] = "ok";
$data["paymentLink"] = $paymentLink;

echo json_encode($data);

exit();
?>