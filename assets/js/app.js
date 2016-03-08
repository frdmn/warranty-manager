$(function() {
  /*
   * Functions
   **/

  // Function to clear the table and insert a specific placeholder
  var insertPlaceholder = function(msg) {
    $('table.certificates tbody').html(
      '<tr>' +
      '<td colspan="6"><center>' + msg + '</center></td>' +
      '</tr>'
    );
  };

  // Reload certificates and populate table
  var reloadCertificates = function() {
    insertPlaceholder('loading ...');
    $.ajax({
      type: 'GET'
      , url: window.location.protocol + '//' + window.location.host + '/api/warranties'
      , cache: false
      , success: function(data) {
        // Clear placeholder
        $('table.certificates tbody').html('');
        // Populate <ul> with host <li>'s
        data.data.hosts.forEach(function(warranty) {
          $('table.certificates tbody').append(
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
      }
    });
  };

  /*
   * Main
   **/

  // Call reloadCertificates()
  reloadCertificates();
});
