<?php

# Creates a new Offer for the given Request
# Sets a Offer-Notification

require 'class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('page.search');
$db = DatabaseConnection::get();

$os = new OfferService($logger, $db);
$ns = new NotificationService($logger, $db);

$reqId = $_REQUEST['req_id'];

$offerId = $os->create($reqId, $user['id']);

$ns->createForOffer($offerId);