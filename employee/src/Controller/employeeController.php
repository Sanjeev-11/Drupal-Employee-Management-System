<?php

namespace Drupal\employee\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\employee\Form\EmployeeForm;

class employeeController extends ControllerBase {

  public function employeeList() {
    $connection = mysqli_connect('localhost', 'root', '', 'employee_db');

    if (!$connection) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM employee";
    $employees = mysqli_query($connection, $sql);

    mysqli_close($connection);

    $form = \Drupal::formBuilder()->getForm(EmployeeForm::class);

    return [
      '#theme' => 'employeelist',
      '#title' => 'Employee Details',
      '#details' => $employees,
      '#form' => $form,
    ];
  }

}

?>