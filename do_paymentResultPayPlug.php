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
//$input = file_get_contents('php://input');

require_once("config/database.php");
require_once("engine/payplug/init.php");
require_once("engine/bo/OrderBo.php");
require_once("engine/bo/PaymentBo.php");

\Payplug\Payplug::setSecretKey($config["payplug"]["token"]);

$connection = openConnection();

$orderBo = OrderBo::newInstance($connection);
$paymentBo = PaymentBo::newInstance($connection);

$orderId = $_REQUEST["oid"];
$payment = $paymentBo->getPaymentByOrderId($orderId);

$paymentId = $payment["pay_request"]["response"]["id"];

$paymentResponse = \Payplug\Payment::retrieve($paymentId);

// print_r($payment);

if ($payment["pay_type"] == "payplug") {
//	$response = $morningApi->getPaymentInformation($payment["pay_request"]["hash"]);

	// print_r($response);
	// $payment["pay_response"] = $resource;
	
	$response = array();
	$response["is_paid"] = $paymentResponse->is_paid;
	$response["amount"] = $paymentResponse->amount;
	$response["id"] = $paymentResponse->id;
	$response["is_live"] = $paymentResponse->is_live;
	$response["created_at"] = $paymentResponse->created_at;
	$response["paid_at"] = $paymentResponse->hosted_payment->paid_at;
	
	if ($paymentResponse->is_paid) {
	    $payment["pay_status"] = "accepted";
	}
	else {
	    $payment["pay_status"] = "failed";
	}
	
	$payment["pay_response"] = $response;

	
	$paymentBo->save($payment);
}

if ($paymentResponse->is_paid) {
//	$order = $orderBo->get($payment["pay_order_id"]);

	header("Location: paymentDone.php" . $referer);
}
else {
	header("Location: paymentFailed.php" . $referer);
}

exit();
?>