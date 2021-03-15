<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Get all customers
$app->get('/api/customers', function (Request $req, Response $res) {
  $db = new Database;

  $db->query("SELECT * FROM customers");
  $db->execute();

  $customers = $db->resultSet();
  echo json_encode($customers);

  $db = null;
});

// Get single customer
$app->get('/api/customer/{id}',  function (Request $req, Response $res) {
  $db = new Database;

  $id = $req->getAttribute('id');
  $values = array($id);

  $db->query("SELECT * FROM customers WHERE id=?");
  $db->bind('i', $values);
  $db->execute();

  $customer = $db->single();
  echo json_encode($customer);

  $db =  null;
});

// Add customer
$app->post('/api/customers', function (Request $req, Response $res) {
  $db = new Database;
  $data = $req->getParsedBody();

  $first_name = $data['first_name'];
  $last_name = $data['last_name'];
  $email = $data['email'];
  $phone = $data['phone'];
  $address = $data['address'];

  $values = array($first_name, $last_name, $email, $phone, $address);

  $db->query("INSERT INTO customers VALUES ('',?,?,?,?,?)");
  $db->bind('sssss', $values);
  $db->execute();

  if ($db->rowCount() > 0) {
    echo json_encode(["msg" => "Insert customer success"]);
  } else {
    echo json_encode(["msg" => "Insert customer fail"]);
  }

  $db = null;
});

// Update customer
$app->put('/api/customers', function (Request $req, Response $res) {
  $db = new Database;
  $data = $req->getParsedBody();

  $first_name = $data['first_name'];
  $last_name = $data['last_name'];
  $email = $data['email'];
  $phone = $data['phone'];
  $address = $data['address'];
  $id = $data['id'];

  $values = array($first_name, $last_name, $email, $phone, $address, $id);

  $db->query("UPDATE customers SET first_name=?, last_name=?, email=?, phone=?, address=? WHERE id=?");
  $db->bind('sssssi', $values);
  $db->execute();

  if ($db->rowCount() > 0) {
    echo json_encode(["msg" => "Update customer success"]);
  } else {
    echo json_encode(["msg" => "Update customer fail"]);
  }

  $db = null;
});

// Delete customer
$app->delete('/api/customer/{id}', function (Request $req, Response $res) {
  $db = new Database;

  $id = $req->getAttribute('id');
  $values = array($id);

  $db->query("DELETE FROM customers WHERE id=?");
  $db->bind('i', $values);
  $db->execute();

  if ($db->rowCount() > 0) {
    echo json_encode(["msg" => "Delete customer success"]);
  } else {
    echo json_encode(["msg" => "Delete customer fail"]);
  }

  $db =  null;
});
