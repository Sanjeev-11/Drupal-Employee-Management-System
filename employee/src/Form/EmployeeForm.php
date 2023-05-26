<?php

namespace Drupal\employee\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class EmployeeForm extends FormBase {

  public function getFormId() {
    return 'employee_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['hike_percentage'] = [
      '#type' => 'number',
      '#title' => $this->t('Hike Percentage'),
      '#required' => TRUE,
    ];

    $form['employee_ids'] = [
    //   '#type' => 'hidden',
      '#value' => '',
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Update Salary'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $hikePercentage = $form_state->getValue('hike_percentage');
    $employeeIds = $form_state->getValue('employee_ids');
    $this->messenger()->addStatus($this->t('y'.$employeeIds));
    

    $connection = mysqli_connect('localhost', 'root', '', 'employee_db');

    if (!$connection) {
      die("Connection failed: " . mysqli_connect_error());
    }

    // foreach ($employeeIds as $employeeId) {
      $employeeQuery = "SELECT * FROM employee WHERE EmpID = '$employeeIds'";
      $employeeResult = mysqli_query($connection, $employeeQuery);
      $employee = mysqli_fetch_assoc($employeeResult);

      if ($employee) {
        $newSalary = $employee['EmpSalary'] + ($employee['EmpSalary'] * $hikePercentage / 100);
        // $this->messenger()->addStatus($this->t($newSalary));
        $updateQuery = "UPDATE employee SET EmpSalary = '$newSalary' WHERE EmpID = '$employeeId'";
        mysqli_query($connection, $updateQuery);
      }
    // }


    mysqli_close($connection);

    // $this->messenger()->addStatus($this->t('Salaries updated successfully.'));
  }

}
