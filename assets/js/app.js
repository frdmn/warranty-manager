$(function() {
  /* Functions */

  /**
   * Remove the contents of the current <table> DOM element
   * and replace it with the text from the String argument
   * @param {String} msg
   * @return void
   */
  var insertTablePlaceholder = function(msg) {
    $('table.certificates tbody').html(
      '<tr>' +
      '<td colspan="6"><center>' + msg + '</center></td>' +
      '</tr>'
    );
    return;
  };

  /**
   * Populate <table> DOM element with database entries
   * @return void
   */
  var reloadWarranties = function() {
    insertTablePlaceholder('loading ...');
    $.ajax({
      type: 'GET'
      , url: window.location.protocol + '//' + window.location.host + '/api/warranties'
      , cache: false
      , success: function(data) {
        // Clear placeholder
        $('table.certificates tbody').html('');
        // Populate <ul> with host <li>'s
        data.data.hosts.forEach(function(warranty) {
          $('table.warranties tbody').append(
            '<tr>' +
            '<th scope="row">' + warranty.id + '</th>' +
            '<td>' + warranty.device + '</td>' +
            '<td>' + warranty.expiration + '</td>' +
            '<td>' + warranty.customer + ' (#300123)</td>' +
            '<td>' + warranty.information + '</td>' +
            '<td><button disabled type="button" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></button> <button disabled type="button" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-minus"></span></button></td>' +
            '</tr>'
          );
        });
        return;
      }
    });
  };

  /* Main */

  // Call reloadWarranties() on page load
  reloadWarranties();
});
