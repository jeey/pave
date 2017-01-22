<?php /*
	Copyright 2014-2015 Cédric Levieux, Parti Pirate

	This file is part of LePave.

    LePave is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    LePave is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with LePave.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once("config/database.php");
require_once("engine/morning/api.php");
require_once("engine/bo/OrderBo.php");
require_once("engine/bo/PaymentBo.php");

$morningApi = new MorningApiClient($config["morning"]["api_url"], $config["morning"]["token"]);
$connection = openConnection();

$orderBo = OrderBo::newInstance($connection);
$paymentBo = PaymentBo::newInstance($connection);

$orderId = $_REQUEST["oid"];

$payment = $paymentBo->getPaymentByOrderId($orderId);

// print_r($payment);

if ($payment["pay_type"] == "morning") {
	$response = $morningApi->getPaymentInformation($payment["pay_request"]["hash"]);

	// print_r($response);

	if ($response["status"] != "created") {
		$payment["pay_response"] = $response;
		$paymentBo->save($payment);
	}
}

// $referer = "";
// if (isset($_REQUEST["referer"]) && $_REQUEST["referer"]) {
// 	$referer = "?referer=" . urlencode($_REQUEST["referer"]);
// }

if ($response["status"] == "finished") {
//	$order = $orderBo->get($payment["pay_order_id"]);

// 	foreach($order["ord_lines"] as $orderLine) {
// //		print_r($orderLine);
// 		$orderBo->execute($orderLine);
// 	}

	header("Location: paymentDone.php" . $referer);
}
else if ($response["status"] == "failed") {
	header("Location: paymentFailed.php" . $referer);
}

//header("Location: $paymentLink");
exit();
?>