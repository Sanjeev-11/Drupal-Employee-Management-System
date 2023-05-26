(function ($, Drupal, drupalSettings) {

  'use strict';

  /**
   * Attaches the employee JavaScript behavior.
   */
  Drupal.behaviors.employee = {
    attach: function (context, settings) {
      $('.employee-checkbox', context).once('employee').on('change', function () {
        toggleHikePercentage(this);
      });

      $('.hike-percentage-field', context).once('employee').on('change', function () {
        updateSalary(this);
      });
    }
  };

  /**
   * Toggles the display of the hike percentage container.
   */
  function toggleHikePercentage(checkbox) {
    const hikePercentageContainer = $(checkbox).next('.hike-percentage-container');
    hikePercentageContainer.toggle(checkbox.checked);
  }

  /**
   * Updates the displayed salary based on the hike percentage.
   */
  function updateSalary(input) {
    const hikePercentage = parseFloat($(input).val());
    if (!isNaN(hikePercentage)) {
      const salaryCell = $(input).closest('tr').find('td:nth-child(3)');
      const baseSalary = parseFloat(salaryCell.text());
      if (!isNaN(baseSalary)) {
        const updatedSalary = baseSalary + (baseSalary * hikePercentage) / 100;
        salaryCell.text(updatedSalary.toFixed(2));
      }
    }
  }

})(jQuery, Drupal, drupalSettings);
