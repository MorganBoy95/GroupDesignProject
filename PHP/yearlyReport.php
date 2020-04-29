<?php
session_start();
require "validate.php";
require "server.php";
require "../jpgraph/jpgraph.php";
require "../jpgraph/jpgraph_bar.php";
require "../fpdf/fpdf.php";

if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

$lastYear = date('d/m/Y', strtotime('-1 year'));

$stmt = $con->prepare("SELECT COUNT(*) FROM request WHERE `date` BETWEEN (CURDATE() - INTERVAL 1 YEAR) AND CURDATE()");
$stmt->execute();
$stmt->bind_result($countLastYear);
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare("SELECT productName FROM (SELECT COUNT(*) AS freq, product.productName FROM product JOIN requestedproduct ON product.productCode = requestedproduct.productCode JOIN request ON requestedproduct.requestID = request.requestID WHERE request.date BETWEEN (CURDATE() - INTERVAL 1 YEAR) AND CURDATE() GROUP BY requestedproduct.productCode ORDER BY freq DESC LIMIT 1) AS q1");
$stmt->execute();
$stmt->bind_result($mostRequestedProduct);
$stmt->fetch();
$stmt->close();

$stmt = "SELECT freq FROM (SELECT COUNT(*) AS freq, staffID FROM request WHERE request.`date` BETWEEN(CURDATE() - INTERVAL 1 YEAR) AND CURDATE() GROUP BY staffID ORDER BY freq DESC) AS q1";
$result = $con->query($stmt);

$staffOrdAmount = array();

while ($row = $result->fetch_assoc()){
    array_push($staffOrdAmount, $row['freq']);
}

$stmt = "SELECT staffID FROM (SELECT COUNT(*) AS freq, staffID FROM request WHERE request.`date` BETWEEN(CURDATE() - INTERVAL 1 YEAR) AND CURDATE() GROUP BY staffID ORDER BY freq DESC) AS q1";
$result = $con->query($stmt);

$staffOrdID = array();

while ($row = $result->fetch_assoc()) {
    array_push($staffOrdID, $row['staffID']);
}

$stmt = "SELECT COUNT(*) AS freq, `order`.supplierID FROM `order` WHERE `order`.`orderDate` BETWEEN (CURDATE() - INTERVAL 1 YEAR) AND CURDATE() GROUP BY supplierID";
$result = $con->query($stmt);

$orderfreq = array();
$supplierIDs = array();

while ($row = $result->fetch_assoc()) {
    array_push($orderfreq, $row['freq']);
    array_push($supplierIDs, $row['supplierID']);
}

$stmt = $con->prepare("SELECT `name` FROM ( SELECT COUNT(*) AS freq, supplier.name FROM supplier JOIN requestedproduct ON supplier.supplierID = requestedproduct.supplierID JOIN request ON requestedproduct.requestID = request.requestID WHERE request.`date` BETWEEN(CURDATE() - INTERVAL 1 YEAR) AND CURDATE() GROUP BY requestedproduct.supplierID ORDER BY freq DESC LIMIT 1) AS q1");
$stmt->execute();
$stmt->bind_result($mostreqsupplier);
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare("SELECT CONCAT( '£', CAST( AVG(totalCost) AS DECIMAL(10, 2) )) AS AvgCost FROM ( SELECT request.totalCost FROM request WHERE request.`date` BETWEEN(CURDATE() - INTERVAL 1 YEAR) AND CURDATE()) AS q1");
$stmt->execute();
$stmt->bind_result($avgreqcost);
$stmt->fetch();
$stmt->close();
$avgreqcost = iconv('UTF-8', 'windows-1252', $avgreqcost);

$stmt = $con->prepare("SELECT COUNT(*) AS orderfreq FROM `order` WHERE `order`.`orderDate` BETWEEN (CURDATE() - INTERVAL 1 YEAR) AND CURDATE()");
$stmt->execute();
$stmt->bind_result($orderamount);
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare("SELECT COUNT(*) FROM orderedproduct WHERE orderedproduct.deliveredOn BETWEEN (CURDATE() - INTERVAL 1 YEAR) AND CURDATE()");
$stmt->execute();
$stmt->bind_result($delivamount);
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare("SELECT CONCAT('£', CAST(AVG(orderTotalCost) AS DECIMAL(10,2))) FROM (SELECT `order`.`orderTotalCost` FROM `order` WHERE `order`.`orderDate` BETWEEN (CURDATE() - INTERVAL 1 YEAR) AND CURDATE()) AS q1");
$stmt->execute();
$stmt->bind_result($avgordcost);
$stmt->fetch();
$stmt->close();
$avgordcost = iconv('UTF-8', 'windows-1252', $avgordcost);

$stmt=$con->prepare("SELECT COUNT(*) FROM request WHERE request.requestState = 'Pending' AND request.`date` BETWEEN (CURDATE() - INTERVAL 1 YEAR) AND CURDATE()");
$stmt->execute();
$stmt->bind_result($currentPending);
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare("SELECT COUNT(*) FROM request WHERE request.requestState = 'Authorised' AND request.`date` BETWEEN (CURDATE() - INTERVAL 1 YEAR) AND CURDATE()");
$stmt->execute();
$stmt->bind_result($currentAuth);
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare("SELECT COUNT(*) FROM request WHERE request.requestState = 'Confirmed' AND request.`date` BETWEEN (CURDATE() - INTERVAL 1 YEAR) AND CURDATE()");
$stmt->execute();
$stmt->bind_result($currentConf);
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare("SELECT COUNT(*) FROM request WHERE request.requestState = 'Issue' AND request.`date` BETWEEN (CURDATE() - INTERVAL 1 YEAR) AND CURDATE()");
$stmt->execute();
$stmt->bind_result($currentIss);
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare("SELECT COUNT(*) FROM `order` WHERE orderState = 'Shipped' AND shippedOn BETWEEN (CURDATE() - INTERVAL 1 YEAR) AND CURDATE()");
$stmt->execute();
$stmt->bind_result($shippedandwaiting);
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare("SELECT COUNT(*) FROM `order` WHERE orderState = 'Pending' AND orderDate BETWEEN (CURDATE() - INTERVAL 1 YEAR) AND CURDATE()");
$stmt->execute();
$stmt->bind_result($pending);
$stmt->fetch();
$stmt->close();

#Create Staff Info Graph
$graph = new Graph(500, 350, "auto");
$graph->SetScale('textint');
$graph->xaxis->SetTickLabels($staffOrdID);
$graph->SetShadow();
$graph->SetMargin(40, 30, 20, 40);
$graph->title->Set("Requests per Staff Member");
$graph->title->SetFont(FF_FONT1, FS_BOLD);
$bplot = new BarPlot($staffOrdAmount);
$graph->Add($bplot);
$graph->Stroke("./yearstaffreq.png");

#Create Supplier Info Graph
$suppliergraph = new Graph(500, 350, "auto");
$suppliergraph->SetScale("textint");
$suppliergraph->xaxis->SetTickLabels($supplierIDs);
$suppliergraph->SetShadow();
$suppliergraph->SetMargin(40, 30, 20, 40);
$suppliergraph->title->Set("Orders Placed to Suppliers");
$suppliergraph->title->SetFont(FF_FONT1, FS_BOLD);
$cplot = new BarPlot($orderfreq);
$suppliergraph->Add($cplot);
$suppliergraph->Stroke("./yearsupplieramnt.png");


# Generate PDF File
$pdf = new FPDF();
$pdf->SetTitle("G4U Yearly Report");
$pdf->SetAuthor($_SESSION['firstName'] . " " . $_SESSION['lastName']);
$pdf->AddPage();
$pdf->SetFont("Arial", "B", 16);
$pdf->Image("../images/logo_sm.png", 70);
$pdf->Cell(0, 10, 'Gadgets4U Yearly Report - Generated by ' . $_SESSION['name'], 0, 1, "C");
$pdf->Cell(0, 10, $lastYear . " - " . date("d/m/Y"), 0, 1, "C");
$pdf->SetFont("Arial", "BU", 12);
$pdf->Cell(0, 10, "Requests", 0, 1);
$pdf->SetFont("Arial", "", 12);
$pdf->Cell(40, 10, "Amount of Requests in Last Year: " . $countLastYear);
$pdf->Ln();
$pdf->Cell(0,10, 'Most Requested Product: ' . $mostRequestedProduct);
$pdf->Ln();
$pdf->Cell(0, 10, "Most Requested Supplier: " . $mostreqsupplier);
$pdf->Ln();
$pdf->Cell(0, 10, "Average Request Cost: " . $avgreqcost, 0, 1);
$pdf->Cell(0, 10, "Current Pending Requests Placed In Last Year: " . $currentPending, 0, 1);
$pdf->Cell(0, 10, "Current Authorised Requests Placed In Last Year: ". $currentAuth, 0, 1);
$pdf->Cell(0, 10, "Current Confirmed Requests Placed In Last Year: " . $currentConf, 0, 1);
$pdf->Cell(0, 10, "Current Requests Placed in Last Year With Issues Flagged: " . $currentIss, 0, 1);
$pdf->Ln();
$pdf->Image("yearstaffreq.png", 40);
$pdf->Ln();
$pdf->SetFont("Arial", "BU", 12);
$pdf->Cell(0, 10, "Orders", 0, 1);
$pdf->SetFont("Arial", "", 12);
$pdf->Cell(0, 10, "Amount of Orders Placed in Last Year: " . $orderamount, 0, 1);
$pdf->Cell(0, 10, "Amount of Deliveries in Last Year: " . $delivamount, 0, 1);
$pdf->Cell(0, 10, "Average Order Cost: " . $avgordcost, 0, 1);
$pdf->Cell(0, 10, "Outstanding Orders Shipped This Year: " . $shippedandwaiting, 0, 1);
$pdf->Cell(0,10, "Orders Placed This Year and Not Shipped: " . $pending);
$pdf->Ln();
$pdf->Image("yearsupplieramnt.png", 40);
$pdf->Output("I", "G4U Yearly Report.pdf");
